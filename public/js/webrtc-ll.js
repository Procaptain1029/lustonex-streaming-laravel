/**
 * Lustonex WebRTC Low-Latency Streaming (0.5-1s)
 * Uses Pusher (via Laravel Echo) for signaling.
 * 
 * Architecture:
 *   Model browser → WebRTC → Fan browser (peer-to-peer, ~0.5-1s latency)
 *   Signaling goes through Pusher private channels (client events)
 *
 * Usage:
 *   const webrtc = new WebRTCLowLatency();
 *   // As model:  webrtc.startBroadcast(streamId, videoElement);
 *   // As viewer: webrtc.joinBroadcast(streamId, videoElement);
 */
class WebRTCLowLatency {
    constructor() {
        this.peerConnections = new Map(); // peerId → RTCPeerConnection
        this.localStream = null;
        this.streamId = null;
        this.isBroadcaster = false;
        this.channel = null;
        this.myPeerId = this._generatePeerId();

        // ICE servers for NAT traversal
        this.iceServers = [
            { urls: 'stun:stun.l.google.com:19302' },
            { urls: 'stun:stun1.l.google.com:19302' },
            { urls: 'stun:stun2.l.google.com:19302' },
        ];

        // Video constraints optimized for low latency
        this.videoConstraints = {
            width: { ideal: 1280, max: 1920 },
            height: { ideal: 720, max: 1080 },
            frameRate: { ideal: 30, max: 60 },
        };

        this.audioConstraints = {
            echoCancellation: true,
            noiseSuppression: true,
            autoGainControl: true,
            sampleRate: 44100,
        };

        console.log('[WebRTC-LL] Initialized, peerId:', this.myPeerId);
    }

    // ════════════════════════════════════════════
    // Broadcaster (Model) Methods
    // ════════════════════════════════════════════

    /**
     * Start broadcasting via WebRTC
     * @param {number} streamId - Stream ID from Laravel
     * @param {HTMLVideoElement} videoElement - Local preview element
     */
    async startBroadcast(streamId, videoElement) {
        this.streamId = streamId;
        this.isBroadcaster = true;

        try {
            // 1. Get camera/mic access
            this.localStream = await navigator.mediaDevices.getUserMedia({
                video: this.videoConstraints,
                audio: this.audioConstraints,
            });

            // 2. Show local preview (muted to avoid echo)
            if (videoElement) {
                videoElement.srcObject = this.localStream;
                videoElement.muted = true;
                await videoElement.play().catch(() => {});
            }

            // 3. Join Pusher signaling channel
            this._joinSignalingChannel(streamId);

            // 4. Notify Laravel
            await this._apiCall(`/api/stream/${streamId}/start-broadcast`, 'POST');

            console.log('[WebRTC-LL] 📡 Broadcasting started for stream:', streamId);
            return { success: true, mode: 'webrtc', peerId: this.myPeerId };

        } catch (error) {
            console.error('[WebRTC-LL] Broadcast error:', error);

            if (error.name === 'NotAllowedError') {
                throw new Error('Camera/mic permission denied');
            } else if (error.name === 'NotFoundError') {
                throw new Error('No camera/mic found');
            }
            throw error;
        }
    }

    // ════════════════════════════════════════════
    // Viewer (Fan) Methods
    // ════════════════════════════════════════════

    /**
     * Join a WebRTC broadcast as viewer
     * @param {number} streamId - Stream ID
     * @param {HTMLVideoElement} videoElement - Remote video element
     */
    async joinBroadcast(streamId, videoElement) {
        this.streamId = streamId;
        this.isBroadcaster = false;
        this.remoteVideoElement = videoElement;

        try {
            // 1. Join signaling channel
            this._joinSignalingChannel(streamId);

            // 2. Notify broadcaster we want to connect
            setTimeout(() => {
                this._sendSignal('viewer-ready', {
                    peerId: this.myPeerId,
                });
            }, 1000); // Wait for channel subscription

            // 3. Notify Laravel
            await this._apiCall(`/api/stream/${streamId}/join-viewer`, 'POST');

            console.log('[WebRTC-LL] 👁️ Joined broadcast as viewer:', streamId);
            return { success: true, mode: 'webrtc', peerId: this.myPeerId };

        } catch (error) {
            console.error('[WebRTC-LL] Join error:', error);
            throw error;
        }
    }

    // ════════════════════════════════════════════
    // Signaling via Pusher
    // ════════════════════════════════════════════

    _joinSignalingChannel(streamId) {
        // Requires Laravel Echo to be initialized (window.Echo)
        if (!window.Echo) {
            console.error('[WebRTC-LL] Laravel Echo not available. Ensure Pusher is configured.');
            return;
        }

        const channelName = `presence-stream.${streamId}`;
        this.channel = window.Echo.join(channelName);

        this.channel
            .here((users) => {
                console.log('[WebRTC-LL] Users in channel:', users.length);
            })
            .joining((user) => {
                console.log('[WebRTC-LL] User joined:', user);
            })
            .leaving((user) => {
                console.log('[WebRTC-LL] User left:', user);
                this._handlePeerDisconnect(user.id);
            })
            // Listen for client events (signaling)
            .listenForWhisper('viewer-ready', (data) => {
                if (this.isBroadcaster) {
                    this._handleViewerReady(data);
                }
            })
            .listenForWhisper('webrtc-offer', (data) => {
                if (!this.isBroadcaster && data.targetPeerId === this.myPeerId) {
                    this._handleOffer(data);
                }
            })
            .listenForWhisper('webrtc-answer', (data) => {
                if (this.isBroadcaster && data.targetPeerId === this.myPeerId) {
                    this._handleAnswer(data);
                }
            })
            .listenForWhisper('webrtc-ice', (data) => {
                if (data.targetPeerId === this.myPeerId) {
                    this._handleIceCandidate(data);
                }
            });

        console.log('[WebRTC-LL] Joined signaling channel:', channelName);
    }

    _sendSignal(event, data) {
        if (this.channel) {
            this.channel.whisper(event, {
                ...data,
                senderPeerId: this.myPeerId,
            });
        }
    }

    // ════════════════════════════════════════════
    // WebRTC Connection Management
    // ════════════════════════════════════════════

    /**
     * Broadcaster: handle new viewer requesting connection
     */
    async _handleViewerReady(data) {
        const viewerPeerId = data.peerId;
        console.log('[WebRTC-LL] Viewer ready:', viewerPeerId);

        try {
            // Create peer connection for this viewer
            const pc = this._createPeerConnection(viewerPeerId);

            // Add local tracks
            if (this.localStream) {
                this.localStream.getTracks().forEach(track => {
                    pc.addTrack(track, this.localStream);
                });
            }

            // Create and send offer
            const offer = await pc.createOffer({
                offerToReceiveAudio: false,
                offerToReceiveVideo: false,
            });
            await pc.setLocalDescription(offer);

            this._sendSignal('webrtc-offer', {
                targetPeerId: viewerPeerId,
                offer: pc.localDescription,
            });

            console.log('[WebRTC-LL] Offer sent to:', viewerPeerId);

        } catch (error) {
            console.error('[WebRTC-LL] Error handling viewer:', error);
        }
    }

    /**
     * Viewer: handle offer from broadcaster
     */
    async _handleOffer(data) {
        const broadcasterPeerId = data.senderPeerId;
        console.log('[WebRTC-LL] Offer received from:', broadcasterPeerId);

        try {
            const pc = this._createPeerConnection(broadcasterPeerId);

            await pc.setRemoteDescription(new RTCSessionDescription(data.offer));

            const answer = await pc.createAnswer();
            await pc.setLocalDescription(answer);

            this._sendSignal('webrtc-answer', {
                targetPeerId: broadcasterPeerId,
                answer: pc.localDescription,
            });

            console.log('[WebRTC-LL] Answer sent to:', broadcasterPeerId);

        } catch (error) {
            console.error('[WebRTC-LL] Error handling offer:', error);
        }
    }

    /**
     * Broadcaster: handle answer from viewer
     */
    async _handleAnswer(data) {
        const viewerPeerId = data.senderPeerId;
        const pc = this.peerConnections.get(viewerPeerId);

        if (pc) {
            await pc.setRemoteDescription(new RTCSessionDescription(data.answer));
            console.log('[WebRTC-LL] Answer received from:', viewerPeerId);
        }
    }

    /**
     * Handle ICE candidate from remote peer
     */
    async _handleIceCandidate(data) {
        const pc = this.peerConnections.get(data.senderPeerId);

        if (pc && data.candidate) {
            try {
                await pc.addIceCandidate(new RTCIceCandidate(data.candidate));
            } catch (error) {
                console.error('[WebRTC-LL] ICE candidate error:', error);
            }
        }
    }

    /**
     * Create a new RTCPeerConnection for a specific peer
     */
    _createPeerConnection(peerId) {
        // Close existing connection if any
        if (this.peerConnections.has(peerId)) {
            this.peerConnections.get(peerId).close();
        }

        const pc = new RTCPeerConnection({ iceServers: this.iceServers });

        // ICE candidates → send to remote peer
        pc.onicecandidate = (event) => {
            if (event.candidate) {
                this._sendSignal('webrtc-ice', {
                    targetPeerId: peerId,
                    candidate: event.candidate,
                });
            }
        };

        // Connection state monitoring
        pc.onconnectionstatechange = () => {
            console.log(`[WebRTC-LL] Connection (${peerId}): ${pc.connectionState}`);

            if (pc.connectionState === 'connected') {
                this._onPeerConnected(peerId);
            } else if (['disconnected', 'failed', 'closed'].includes(pc.connectionState)) {
                this._handlePeerDisconnect(peerId);
            }
        };

        // Receive remote tracks (viewer side)
        pc.ontrack = (event) => {
            console.log('[WebRTC-LL] Remote track received:', event.track.kind);

            if (this.remoteVideoElement && event.streams[0]) {
                this.remoteVideoElement.srcObject = event.streams[0];
                this.remoteVideoElement.play().catch(() => {});
            }
        };

        this.peerConnections.set(peerId, pc);
        return pc;
    }

    _onPeerConnected(peerId) {
        console.log(`[WebRTC-LL] ✅ Peer connected: ${peerId}`);

        // Dispatch custom event for UI updates
        window.dispatchEvent(new CustomEvent('webrtc-peer-connected', {
            detail: { peerId, streamId: this.streamId }
        }));
    }

    _handlePeerDisconnect(peerId) {
        const pc = this.peerConnections.get(peerId);
        if (pc) {
            pc.close();
            this.peerConnections.delete(peerId);
        }

        console.log(`[WebRTC-LL] Peer disconnected: ${peerId}`);

        window.dispatchEvent(new CustomEvent('webrtc-peer-disconnected', {
            detail: { peerId, streamId: this.streamId }
        }));
    }

    // ════════════════════════════════════════════
    // Cleanup
    // ════════════════════════════════════════════

    async stop() {
        console.log('[WebRTC-LL] Stopping...');

        // Close all peer connections
        for (const [peerId, pc] of this.peerConnections) {
            pc.close();
        }
        this.peerConnections.clear();

        // Stop local media
        if (this.localStream) {
            this.localStream.getTracks().forEach(track => track.stop());
            this.localStream = null;
        }

        // Leave signaling channel
        if (this.channel && window.Echo) {
            window.Echo.leave(`presence-stream.${this.streamId}`);
            this.channel = null;
        }

        // Notify Laravel
        if (this.streamId) {
            const endpoint = this.isBroadcaster
                ? `/api/stream/${this.streamId}/stop-broadcast`
                : `/api/stream/${this.streamId}/leave-viewer`;
            await this._apiCall(endpoint, 'POST');
        }
    }

    // ════════════════════════════════════════════
    // Utilities
    // ════════════════════════════════════════════

    _generatePeerId() {
        return 'peer_' + Math.random().toString(36).substring(2, 10) + '_' + Date.now();
    }

    async _apiCall(url, method = 'GET', body = null) {
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            const options = {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
            };
            if (csrfToken) options.headers['X-CSRF-TOKEN'] = csrfToken;
            if (body) options.body = JSON.stringify(body);

            const res = await fetch(url, options);
            return res.ok ? await res.json() : null;
        } catch (e) {
            console.error('[WebRTC-LL] API error:', e);
            return null;
        }
    }

    /**
     * Get stats for monitoring
     */
    async getStats() {
        const stats = {
            peerId: this.myPeerId,
            isBroadcaster: this.isBroadcaster,
            connectedPeers: this.peerConnections.size,
            peers: {},
        };

        for (const [peerId, pc] of this.peerConnections) {
            const rtcStats = await pc.getStats();
            const peerStats = { state: pc.connectionState };

            rtcStats.forEach(report => {
                if (report.type === 'candidate-pair' && report.state === 'succeeded') {
                    peerStats.roundTripTime = report.currentRoundTripTime;
                    peerStats.bytesSent = report.bytesSent;
                    peerStats.bytesReceived = report.bytesReceived;
                }
            });

            stats.peers[peerId] = peerStats;
        }

        return stats;
    }
}

// Export globally
window.WebRTCLowLatency = WebRTCLowLatency;
console.log('[WebRTC-LL] 🚀 Module loaded');
