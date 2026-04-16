class WebRTCLowLatency {
    constructor() {
        this.peerConnections = new Map();
        this.pendingIceCandidates = new Map();
        this.localStream = null;
        this.streamId = null;
        this.isBroadcaster = false;
        this.channel = null;
        this.remoteVideoElement = null;
        this.myPeerId = this._generatePeerId();
        this.viewerReadyTimer = null;
        this.viewerReadyDeadline = 0;
        this.handledSignalIds = new Set();
        this.useRelayForMediaSignals = true;
        this.mediaRelayFallbackTimer = null;
        this.remoteVideoReadyBound = false;

        this.iceServers = window.WEBRTC_ICE_SERVERS || [
            { urls: "stun:stun.l.google.com:19302" },
            { urls: "stun:stun1.l.google.com:19302" },
            { urls: "stun:stun2.l.google.com:19302" }
        ];
    }

    async startBroadcast(streamId, videoElement) {
        this.streamId = streamId;
        this.isBroadcaster = true;

        this.localStream = await navigator.mediaDevices.getUserMedia({
            video: { width: { ideal: 1280 }, height: { ideal: 720 }, frameRate: { ideal: 30, max: 30 } },
            audio: { echoCancellation: true, noiseSuppression: true, autoGainControl: true }
        });

        if (videoElement) {
            videoElement.srcObject = this.localStream;
            videoElement.muted = true;
            await videoElement.play().catch(() => {});
        }

        await this._joinSignalingChannel(streamId);
        await this._apiCall(`/webrtc/stream/${streamId}/start-broadcast`, "POST");
        this._sendSignal("broadcaster-ready", { peerId: this.myPeerId });

        return { success: true, mode: "webrtc" };
    }

    async stopBroadcast() {
        if (!this.streamId || !this.isBroadcaster) {
            return;
        }
        await this._apiCall(`/webrtc/stream/${this.streamId}/stop-broadcast`, "POST").catch(() => {});
        this.cleanup();
    }

    async joinBroadcast(streamId, videoElement) {
        this.streamId = streamId;
        this.isBroadcaster = false;
        this.remoteVideoElement = videoElement;

        await this._joinSignalingChannel(streamId);
        await this._apiCall(`/webrtc/stream/${streamId}/join-viewer`, "POST");

        this._startViewerReadyLoop();
        this._scheduleMediaRelayFallback();
        return { success: true, mode: "webrtc" };
    }

    async leaveBroadcast() {
        if (!this.streamId || this.isBroadcaster) {
            return;
        }
        await this._apiCall(`/webrtc/stream/${this.streamId}/leave-viewer`, "POST").catch(() => {});
        this.cleanup();
    }

    async _joinSignalingChannel(streamId) {
        if (!window.Echo) {
            throw new Error("Laravel Echo is not initialized");
        }

        if (this.channel) {
            return;
        }

        this.channel = window.Echo.join(`presence-stream.${streamId}`);
        this.channel
            .here((users) => {
                if (!this.isBroadcaster) {
                    const modelUser = users.find((u) => u && Number(u.id) !== Number(window.currentUserId || 0));
                    if (modelUser) {
                        this._sendViewerReady();
                    }
                }
            })
            .joining((user) => {
                if (!this.isBroadcaster && user && Number(user.id) !== Number(window.currentUserId || 0)) {
                    this._sendViewerReady();
                }
            })
            .leaving((user) => {
                if (!user) return;
                this._handlePeerDisconnect(user.id);
            })
            .listen(".webrtc.signal", (data) => {
                this._handleRelayedSignal(data);
            });

        this.channel.listenForWhisper("webrtc-signal", (data) => {
            const evt = data?.signalEvent || data?.payload?.signalEvent;
            // Server-relay is the source of truth for media signaling.
            if (evt === "webrtc-offer" || evt === "webrtc-answer" || evt === "webrtc-ice") {
                return;
            }
            this._handleRelayedSignal(data);
        });
    }

    _handleRelayedSignal(rawData) {
        this._handleRelayedSignalImpl(rawData).catch((err) => console.error("[WebRTC-LL] relay error", err));
    }

    async _handleRelayedSignalImpl(rawData) {
        if (!rawData || rawData.senderPeerId === this.myPeerId) {
            return;
        }

        let envelope = rawData;
        if (rawData.relayId && this.streamId) {
            const res = await fetch(`/webrtc/stream/${this.streamId}/relay/${encodeURIComponent(rawData.relayId)}`, {
                method: "GET",
                headers: {
                    "X-CSRF-TOKEN": this._getCsrfToken(),
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                },
                credentials: "same-origin",
            });
            const json = await res.json().catch(() => ({}));
            if (!res.ok || !json.success) {
                console.warn("[WebRTC-LL] relay fetch failed", res.status, json);
                return;
            }
            envelope = {
                ...rawData,
                senderPeerId: json.senderPeerId,
                signalEvent: json.signalEvent,
                ...(json.payload || {}),
            };
        }

        const data = this._normalizeSignal(envelope);
        if (!data) return;
        if (data.targetPeerId && data.targetPeerId !== this.myPeerId) {
            return;
        }

        if (data.signalId) {
            if (this.handledSignalIds.has(data.signalId)) {
                return;
            }
            this.handledSignalIds.add(data.signalId);
            if (this.handledSignalIds.size > 300) {
                this.handledSignalIds.clear();
            }
        }

        if (this.isBroadcaster) {
            if (data.signalEvent === "viewer-ready") {
                this._handleViewerReady(data).catch(console.error);
            } else if (data.signalEvent === "webrtc-answer") {
                this._handleAnswer(data).catch(console.error);
            } else if (data.signalEvent === "webrtc-ice") {
                this._handleIceCandidate(data).catch(console.error);
            }
            return;
        }

        if (data.signalEvent === "broadcaster-ready") {
            this._sendViewerReady();
        } else if (data.signalEvent === "webrtc-offer") {
            this._handleOffer(data).catch(console.error);
        } else if (data.signalEvent === "webrtc-ice") {
            this._handleIceCandidate(data).catch(console.error);
        }
    }

    _normalizeSignal(raw) {
        const payload = raw.payload && typeof raw.payload === "object" ? raw.payload : {};
        const signalEvent = raw.signalEvent || payload.signalEvent;
        if (!signalEvent) return null;
        const offer = this._normalizeSessionDescription(raw.offer || payload.offer || null, "offer");
        const answer = this._normalizeSessionDescription(raw.answer || payload.answer || null, "answer");
        return {
            ...payload,
            ...raw,
            signalEvent,
            offer,
            answer,
            rawOffer: raw.offer || payload.offer || null,
            rawAnswer: raw.answer || payload.answer || null,
            candidate: raw.candidate || payload.candidate || null,
            targetPeerId: raw.targetPeerId || payload.targetPeerId || null
        };
    }

    _normalizeSessionDescription(input, expectedType) {
        if (!input) return null;

        let parsed = input;
        if (typeof parsed === "string") {
            try {
                parsed = JSON.parse(parsed);
            } catch (_) {
                return null;
            }
        }

        if (!parsed || typeof parsed !== "object") return null;
        const type = typeof parsed.type === "string" ? parsed.type : "";
        const hasSdp64 = typeof parsed.sdp64 === "string" && parsed.sdp64.length > 0;
        let sdp = hasSdp64 ? this._decodeBase64Utf8(parsed.sdp64) : (typeof parsed.sdp === "string" ? parsed.sdp : "");
        if (!type || !sdp) return null;
        if (expectedType && type !== expectedType) return null;

        if (hasSdp64) {
            // sdp64 is produced locally from RTCPeerConnection.localDescription.sdp.
            // Keep it as-is to avoid mutating valid SDP semantics.
            if (!sdp.startsWith("v=0")) {
                return null;
            }
            return { type, sdp };
        }

        // Legacy transport fallback: tolerate escaped/newline-wrapped SDP.
        sdp = this._decodeSdpText(sdp);
        if (!sdp) return null;
        sdp = this._sdpCanonicalize(sdp);
        if (!sdp.startsWith("v=0")) return null;

        return { type, sdp };
    }

    _encodeSessionDescription(desc) {
        if (!desc || typeof desc !== "object") return null;
        if (typeof desc.type !== "string" || typeof desc.sdp !== "string") return null;
        return {
            type: desc.type,
            sdp64: this._encodeBase64Utf8(desc.sdp)
        };
    }

    _encodeBase64Utf8(str) {
        try {
            const bytes = new TextEncoder().encode(str);
            let bin = "";
            for (let i = 0; i < bytes.length; i += 1) {
                bin += String.fromCharCode(bytes[i]);
            }
            return btoa(bin);
        } catch (_) {
            return "";
        }
    }

    _decodeBase64Utf8(base64) {
        try {
            const bin = atob(base64);
            const bytes = new Uint8Array(bin.length);
            for (let i = 0; i < bin.length; i += 1) {
                bytes[i] = bin.charCodeAt(i);
            }
            return new TextDecoder("utf-8").decode(bytes);
        } catch (_) {
            return "";
        }
    }

    _decodeSdpText(sdp) {
        if (!sdp || typeof sdp !== "string") return "";

        let text = sdp.trim();

        // Unwrap accidental surrounding quotes repeatedly.
        for (let i = 0; i < 3; i += 1) {
            if ((text.startsWith('"') && text.endsWith('"')) || (text.startsWith("'") && text.endsWith("'"))) {
                text = text.slice(1, -1).trim();
                continue;
            }
            break;
        }

        // Try JSON string decode if relay double-encoded SDP text.
        for (let i = 0; i < 2; i += 1) {
            if ((text.startsWith('"') && text.endsWith('"')) || text.includes("\\u000d") || text.includes("\\r\\n")) {
                try {
                    const decoded = JSON.parse(text);
                    if (typeof decoded === "string" && decoded.length) {
                        text = decoded;
                        continue;
                    }
                } catch (_) {}
            }
            break;
        }

        // Decode escaped newlines/unicode literals that remain as plain text.
        text = text
            .replace(/\\u000d\\u000a/g, "\n")
            .replace(/\\u000a/g, "\n")
            .replace(/\\u000d/g, "\n")
            .replace(/\\r\\n/g, "\n")
            .replace(/\\n/g, "\n")
            .replace(/\\r/g, "\n")
            .replace(/\\"/g, '"');

        return text;
    }

    /**
     * Only normalize line endings and strip leading junk. Do NOT split on spaces inside SDP
     * attribute values (that regex previously broke lines like a=ssrc / fingerprint / IN IP4).
     */
    _sdpCanonicalize(rawSdp) {
        if (!rawSdp || typeof rawSdp !== "string") return "";

        let sdp = rawSdp.replace(/\r\n/g, "\n").replace(/\r/g, "\n");
        const vIdx = sdp.indexOf("v=0");
        if (vIdx > 0) {
            sdp = sdp.slice(vIdx);
        }

        return sdp
            .split("\n")
            .map((line) => String(line || "").trim())
            .filter((line) => line.length > 0)
            .join("\r\n");
    }

    _startViewerReadyLoop() {
        clearInterval(this.viewerReadyTimer);
        this.viewerReadyDeadline = Date.now() + 20000;
        this._sendViewerReady();

        this.viewerReadyTimer = setInterval(() => {
            if (Date.now() > this.viewerReadyDeadline || this._hasConnectedPeer()) {
                clearInterval(this.viewerReadyTimer);
                this.viewerReadyTimer = null;
                return;
            }
            this._sendViewerReady();
        }, 2000);
    }

    _sendViewerReady() {
        this._sendSignal("viewer-ready", { peerId: this.myPeerId });
    }

    _scheduleMediaRelayFallback() {
        if (this.isBroadcaster) return;
        clearTimeout(this.mediaRelayFallbackTimer);
        this.mediaRelayFallbackTimer = setTimeout(() => {
            if (this._hasConnectedPeer()) {
                return;
            }
            // Retry viewer-ready if offer did not arrive yet.
            this._sendViewerReady();
        }, 3500);
    }

    async _handleViewerReady(data) {
        const viewerPeerId = data.peerId || data.senderPeerId;
        if (!viewerPeerId) return;
        if (this.peerConnections.has(viewerPeerId)) return;

        const pc = this._createPeerConnection(viewerPeerId);
        if (this.localStream) {
            this.localStream.getTracks().forEach((track) => pc.addTrack(track, this.localStream));
        }

        const offer = await pc.createOffer();
        await pc.setLocalDescription(offer);
        this._requestVideoKeyframe(viewerPeerId);

        this._sendSignal("webrtc-offer", {
            offer: this._encodeSessionDescription(pc.localDescription),
            targetPeerId: viewerPeerId
        });
    }

    async _handleOffer(data) {
        const peerId = data.senderPeerId;
        if (!data.offer) {
            return;
        }
        let pc = this._createPeerConnection(peerId);

        // Repeated offers can arrive while the current connection is already stable.
        // Ignore exact duplicates, otherwise rebuild peer connection for a clean negotiation.
        if (pc.remoteDescription && pc.signalingState === "stable") {
            const currentRemote = pc.remoteDescription;
            const sameOffer = currentRemote.type === "offer" &&
                data.offer &&
                currentRemote.sdp === data.offer.sdp;

            if (sameOffer) {
                return;
            }

            this._handlePeerDisconnect(peerId);
            pc = this._createPeerConnection(peerId);
        }

        try {
            await pc.setRemoteDescription(new RTCSessionDescription(data.offer));
        } catch (error) {
            // One retry path for legacy payloads: attempt to normalize raw offer object/string.
            const fallbackOffer = this._normalizeSessionDescription(data.rawOffer || null, "offer");
            if (fallbackOffer && fallbackOffer.sdp !== data.offer?.sdp) {
                try {
                    await pc.setRemoteDescription(new RTCSessionDescription(fallbackOffer));
                    await this._flushPendingIce(peerId);
                    const answer = await pc.createAnswer();
                    await pc.setLocalDescription(answer);
                    this._sendSignal("webrtc-answer", {
                        answer: this._encodeSessionDescription(pc.localDescription),
                        targetPeerId: peerId
                    });
                    return;
                } catch (_) {}
            }
            console.warn("[WebRTC-LL] Invalid offer SDP received", error, data.offer);
            return;
        }
        await this._flushPendingIce(peerId);

        const answer = await pc.createAnswer();
        await pc.setLocalDescription(answer);

        this._sendSignal("webrtc-answer", {
            answer: this._encodeSessionDescription(pc.localDescription),
            targetPeerId: peerId
        });
    }

    async _handleAnswer(data) {
        const peerId = data.senderPeerId;
        const pc = this.peerConnections.get(peerId);
        if (!pc || !data.answer) return;

        try {
            await pc.setRemoteDescription(new RTCSessionDescription(data.answer));
            this._requestVideoKeyframe(peerId);
        } catch (error) {
            console.warn("[WebRTC-LL] Invalid answer SDP received", error, data.answer);
            return;
        }
        await this._flushPendingIce(peerId);
    }

    async _handleIceCandidate(data) {
        const peerId = data.senderPeerId;
        const pc = this.peerConnections.get(peerId);
        if (!data.candidate) return;

        if (!pc || !pc.remoteDescription) {
            if (!this.pendingIceCandidates.has(peerId)) {
                this.pendingIceCandidates.set(peerId, []);
            }
            this.pendingIceCandidates.get(peerId).push(data.candidate);
            return;
        }

        try {
            await pc.addIceCandidate(new RTCIceCandidate(data.candidate));
        } catch (error) {
            console.warn("[WebRTC-LL] ICE add failed", error);
        }
    }

    async _flushPendingIce(peerId) {
        const pc = this.peerConnections.get(peerId);
        const list = this.pendingIceCandidates.get(peerId) || [];
        this.pendingIceCandidates.delete(peerId);
        if (!pc || !pc.remoteDescription || !list.length) return;

        for (const candidate of list) {
            try {
                await pc.addIceCandidate(new RTCIceCandidate(candidate));
            } catch (error) {
                console.warn("[WebRTC-LL] Pending ICE add failed", error);
            }
        }
    }

    _createPeerConnection(peerId) {
        if (this.peerConnections.has(peerId)) {
            return this.peerConnections.get(peerId);
        }

        const pc = new RTCPeerConnection({ iceServers: this.iceServers });
        this.peerConnections.set(peerId, pc);

        pc.onicecandidate = (event) => {
            if (!event.candidate) return;
            this._sendSignal("webrtc-ice", {
                candidate: event.candidate.toJSON(),
                targetPeerId: peerId
            });
        };

        if (!this.isBroadcaster) {
            pc.ontrack = (event) => {
                if (!this.remoteVideoElement || !event.streams[0]) return;
                this.remoteVideoElement.srcObject = event.streams[0];
                this._bindRemoteVideoReadySignals(this.remoteVideoElement);
                this.remoteVideoElement.play().catch(() => {});
                window.dispatchEvent(new CustomEvent("webrtc-peer-connected"));
            };
        }

        pc.onconnectionstatechange = () => {
            if (pc.connectionState === "failed" || pc.connectionState === "closed" || pc.connectionState === "disconnected") {
                this.peerConnections.delete(peerId);
            }
        };

        return pc;
    }

    _bindRemoteVideoReadySignals(videoEl) {
        if (!videoEl || this.remoteVideoReadyBound) return;
        this.remoteVideoReadyBound = true;

        const markReady = () => {
            if (videoEl.readyState >= 2 && !videoEl.paused) {
                window.dispatchEvent(new CustomEvent("webrtc-video-ready"));
            }
        };

        videoEl.addEventListener("loadeddata", markReady);
        videoEl.addEventListener("playing", markReady);
    }

    _requestVideoKeyframe(peerId) {
        if (!this.isBroadcaster) return;
        const pc = this.peerConnections.get(peerId);
        if (!pc || typeof pc.getSenders !== "function") return;

        const senders = pc.getSenders().filter((sender) => sender?.track?.kind === "video");
        senders.forEach((sender) => {
            if (typeof sender.generateKeyFrame !== "function") return;
            try {
                const first = sender.generateKeyFrame();
                if (first && typeof first.catch === "function") first.catch(() => {});
                setTimeout(() => {
                    try {
                        const second = sender.generateKeyFrame();
                        if (second && typeof second.catch === "function") second.catch(() => {});
                    } catch (_) {}
                }, 350);
            } catch (_) {}
        });
    }

    _sendSignal(signalEvent, payload = {}) {
        const data = {
            signalId: `${this.myPeerId}_${Date.now()}_${Math.random().toString(36).slice(2, 8)}`,
            senderPeerId: this.myPeerId,
            signalEvent,
            ...payload
        };

        if (this.channel) {
            const isMediaSignal = signalEvent === "webrtc-offer" || signalEvent === "webrtc-answer" || signalEvent === "webrtc-ice";
            if (!isMediaSignal) {
                this.channel.whisper("webrtc-signal", data);
            }
        }

        this._apiCall(`/webrtc/stream/${this.streamId}/signal`, "POST", {
            senderPeerId: this.myPeerId,
            signalEvent,
            payload
        }).catch(() => {});
    }

    _hasConnectedPeer() {
        for (const pc of this.peerConnections.values()) {
            if (pc.connectionState === "connected" || pc.connectionState === "completed") return true;
        }
        return false;
    }

    _handlePeerDisconnect(peerId) {
        const pc = this.peerConnections.get(peerId);
        if (pc) {
            pc.close();
            this.peerConnections.delete(peerId);
        }
    }

    async _apiCall(url, method, body = null) {
        const response = await fetch(url, {
            method,
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": this._getCsrfToken(),
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json"
            },
            credentials: "same-origin",
            body: body ? JSON.stringify(body) : null
        });

        if (!response.ok) {
            const text = await response.text();
            throw new Error(`WebRTC API ${response.status}: ${text.slice(0, 160)}`);
        }

        return response.json();
    }

    _getCsrfToken() {
        const token = document.querySelector('meta[name="csrf-token"]');
        return token ? token.getAttribute("content") : "";
    }

    _generatePeerId() {
        return `peer_${Math.random().toString(36).slice(2, 10)}_${Date.now()}`;
    }

    cleanup() {
        clearInterval(this.viewerReadyTimer);
        this.viewerReadyTimer = null;
        this.viewerReadyDeadline = 0;
        clearTimeout(this.mediaRelayFallbackTimer);
        this.mediaRelayFallbackTimer = null;

        for (const pc of this.peerConnections.values()) {
            pc.close();
        }
        this.peerConnections.clear();
        this.pendingIceCandidates.clear();
        this.useRelayForMediaSignals = true;
        this.remoteVideoReadyBound = false;

        if (this.localStream) {
            this.localStream.getTracks().forEach((track) => track.stop());
            this.localStream = null;
        }

        if (this.channel && window.Echo) {
            window.Echo.leave(`presence-stream.${this.streamId}`);
        }
        this.channel = null;
    }
}

window.WebRTCLowLatency = WebRTCLowLatency;
