/**
 * Sistema de Streaming Directo desde Webcam
 * Flujo: Modelo inicia webcam → Viewer ve stream en tiempo real
 */
class WebcamStreamingManager {
    constructor() {
        this.localStream = null;
        this.mediaRecorder = null;
        this.streamId = null;
        this.isStreaming = false;
        this.recordedChunks = [];
        this.streamInterval = null;
        
        // WebRTC para streaming real
        this.peerConnection = null;
        this.rtcConfig = {
            iceServers: [
                { urls: 'stun:stun.l.google.com:19302' },
                { urls: 'stun:stun1.l.google.com:19302' }
            ]
        };
        
        console.log('WebcamStreamingManager inicializado');
    }
    
    // Iniciar streaming desde webcam (para modelos)
    async startStreaming(streamId, videoElement) {
        try {
            this.streamId = streamId;
            console.log('Iniciando streaming webcam para stream ID:', streamId);
            
            // Solicitar acceso a cámara y micrófono
            this.localStream = await navigator.mediaDevices.getUserMedia({
                video: {
                    width: { ideal: 1280, max: 1920 },
                    height: { ideal: 720, max: 1080 },
                    frameRate: { ideal: 30 }
                },
                audio: {
                    echoCancellation: true,
                    noiseSuppression: true,
                    autoGainControl: true
                }
            });
            
            // Mostrar video local
            videoElement.srcObject = this.localStream;
            videoElement.muted = true; // Evitar feedback
            await videoElement.play();
            
            // Configurar MediaRecorder
            await this.setupMediaRecorder();
            
            // Iniciar grabación en chunks
            console.log('🎬 Iniciando MediaRecorder con chunks de 2 segundos...');
            this.mediaRecorder.start(2000); // Chunks de 2 segundos
            this.isStreaming = true;
            
            // Verificar estado después de un momento
            setTimeout(() => {
                console.log('📊 Estado MediaRecorder:', this.mediaRecorder.state);
            }, 1000);
            
            // Notificar al servidor que el stream está activo
            await this.notifyStreamStart();
            
            // Configurar WebRTC como broadcaster
            await this.initWebRTCBroadcaster();
            
            console.log('✅ Streaming webcam iniciado exitosamente');
            return {
                success: true,
                mode: 'webcam',
                message: 'Streaming iniciado desde webcam'
            };
            
        } catch (error) {
            console.error('❌ Error iniciando streaming webcam:', error);
            
            if (error.name === 'NotAllowedError') {
                throw new Error('Permisos de cámara denegados. Por favor, permite el acceso a la cámara.');
            } else if (error.name === 'NotFoundError') {
                throw new Error('No se encontró cámara o micrófono. Verifica que estén conectados.');
            } else if (error.name === 'NotReadableError') {
                throw new Error('Cámara en uso por otra aplicación. Cierra otras aplicaciones que usen la cámara.');
            }
            
            throw error;
        }
    }
    
    // Configurar MediaRecorder
    async setupMediaRecorder() {
        if (!this.localStream) {
            throw new Error('No hay stream local disponible');
        }
        
        // Detectar formato soportado (usar WebM que es más confiable)
        let mimeType = 'video/webm;codecs=vp9,opus';
        if (!MediaRecorder.isTypeSupported(mimeType)) {
            mimeType = 'video/webm;codecs=vp8,opus';
        }
        if (!MediaRecorder.isTypeSupported(mimeType)) {
            mimeType = 'video/webm';
        }
        if (!MediaRecorder.isTypeSupported(mimeType)) {
            mimeType = 'video/mp4';
        }
        
        console.log('📹 Usando formato de video:', mimeType);
        
        this.mediaRecorder = new MediaRecorder(this.localStream, {
            mimeType: mimeType,
            videoBitsPerSecond: 1500000, // 1.5 Mbps
            audioBitsPerSecond: 128000   // 128 kbps
        });
        
        this.mediaRecorder.ondataavailable = (event) => {
            console.log('📹 Chunk recibido:', event.data.size, 'bytes');
            if (event.data && event.data.size > 0) {
                this.handleStreamChunk(event.data);
            } else {
                console.warn('⚠️ Chunk vacío recibido');
            }
        };
        
        this.mediaRecorder.onstart = () => {
            console.log('📹 MediaRecorder iniciado');
        };
        
        this.mediaRecorder.onerror = (event) => {
            console.error('❌ Error en MediaRecorder:', event.error);
        };
    }
    
    // Manejar chunks de video
    async handleStreamChunk(chunk) {
        try {
            console.log('🔄 Procesando chunk de', chunk.size, 'bytes');
            
            // Convertir chunk a base64
            const reader = new FileReader();
            reader.onload = async () => {
                try {
                    const result = reader.result;
                    console.log('📄 FileReader result type:', typeof result);
                    console.log('📄 FileReader result length:', result?.length);
                    console.log('📄 FileReader result start:', result?.substring(0, 100));
                    
                    if (result && typeof result === 'string' && result.includes('data:')) {
                        const parts = result.split(',');
                        if (parts.length >= 2) {
                            const base64Data = parts[1];
                            console.log('📤 Base64 data length:', base64Data.length);
                            console.log('📤 Base64 sample:', base64Data.substring(0, 50) + '...');
                            
                            if (base64Data.length > 100) {
                                // Enviar chunk al servidor Laravel
                                await this.sendChunkToServer(base64Data);
                            } else {
                                console.error('❌ Base64 demasiado corto:', base64Data.length);
                            }
                        } else {
                            console.error('❌ No se pudo dividir result:', result.substring(0, 100));
                        }
                    } else {
                        console.error('❌ FileReader result inválido:', result?.substring(0, 100));
                    }
                } catch (error) {
                    console.error('❌ Error procesando FileReader result:', error);
                }
            };
            
            reader.onerror = (error) => {
                console.error('❌ Error en FileReader:', error);
            };
            
            console.log('📖 Iniciando FileReader.readAsDataURL...');
            reader.readAsDataURL(chunk);
            
        } catch (error) {
            console.error('❌ Error procesando chunk:', error);
        }
    }
    
    // Enviar chunk al servidor
    async sendChunkToServer(base64Data) {
        try {
            console.log('🌐 Enviando chunk al servidor para stream', this.streamId);
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            console.log('🔐 CSRF Token:', csrfToken ? 'Presente' : 'FALTANTE');
            
            const response = await fetch('/api/stream/upload-chunk', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    stream_id: this.streamId,
                    chunk_data: base64Data,
                    timestamp: Date.now()
                })
            });
            
            if (response.ok) {
                const result = await response.json();
                console.log('✅ Chunk enviado exitosamente:', result.message);
            } else {
                const errorText = await response.text();
                console.warn('⚠️ Error enviando chunk:', response.status, errorText);
            }
            
        } catch (error) {
            console.error('❌ Error en envío de chunk:', error);
        }
    }
    
    // Conectar como viewer (WebRTC real)
    async connectAsViewer(streamId, videoElement) {
        try {
            console.log('👁️ Conectando como viewer al stream:', streamId);
            
            // Verificar si hay stream activo
            const response = await fetch(`/api/stream/${streamId}/info`);
            
            console.log('📡 Respuesta del servidor:', response.status, response.statusText);
            
            if (response.ok) {
                const data = await response.json();
                console.log('📄 Datos recibidos:', data);
                
                if (data.status === 'live') {
                    console.log('🎥 Stream activo encontrado, iniciando WebRTC como viewer');
                    
                    // Inicializar WebRTC como viewer
                    await this.initWebRTCViewer(streamId, videoElement);
                    
                    // Notificar unión como viewer
                    await this.notifyJoinViewer(streamId);
                    
                    return true;
                } else {
                    console.log('📺 Stream no activo:', data.status);
                    this.showViewerPlaceholder(videoElement);
                    return true;
                }
            } else {
                console.log('❌ Error HTTP:', response.status);
                this.showViewerPlaceholder(videoElement);
                return true;
            }
            
        } catch (error) {
            console.error('❌ Error conectando como viewer:', error);
            this.showViewerPlaceholder(videoElement);
            return true;
        }
    }
    
    // Inicializar reproductor HLS
    async initHLSPlayer(hlsUrl, videoElement) {
        try {
            // Cargar HLS.js si no está disponible
            if (!window.Hls) {
                await this.loadHLSLibrary();
            }
            
            if (window.Hls && Hls.isSupported()) {
                const hls = new Hls({
                    debug: false,
                    enableWorker: true,
                    lowLatencyMode: true,
                    liveSyncDurationCount: 1,
                    liveMaxLatencyDurationCount: 2
                });
                
                hls.loadSource(hlsUrl);
                hls.attachMedia(videoElement);
                
                hls.on(Hls.Events.MANIFEST_PARSED, () => {
                    console.log('🎥 HLS manifest cargado, iniciando reproducción');
                    videoElement.play().catch(e => console.log('Autoplay prevented:', e));
                });
                
                hls.on(Hls.Events.ERROR, (event, data) => {
                    console.error('❌ Error HLS:', data);
                    if (data.fatal) {
                        console.log('Error fatal, mostrando placeholder');
                        this.showViewerPlaceholder(videoElement);
                    }
                });
                
            } else if (videoElement.canPlayType('application/vnd.apple.mpegurl')) {
                // Safari nativo
                console.log('🍎 Usando HLS nativo de Safari');
                videoElement.src = hlsUrl;
                videoElement.play().catch(e => console.log('Autoplay prevented:', e));
            } else {
                throw new Error('HLS no soportado en este navegador');
            }
            
        } catch (error) {
            console.error('❌ Error inicializando HLS player:', error);
            this.showViewerPlaceholder(videoElement);
        }
    }
    
    // Cargar librería HLS.js
    async loadHLSLibrary() {
        return new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/hls.js@latest';
            script.onload = () => {
                console.log('📚 HLS.js cargado exitosamente');
                resolve();
            };
            script.onerror = reject;
            document.head.appendChild(script);
        });
    }
    
    // Mostrar placeholder cuando no hay stream
    showViewerPlaceholder(videoElement) {
        console.log('📺 Mostrando placeholder de stream');
        
        videoElement.style.background = 'linear-gradient(45deg, #1a1a1a, #2a2a2a)';
        
        // SVG sin emojis para evitar error btoa
        const svgContent = `<svg xmlns="http://www.w3.org/2000/svg" width="640" height="360" viewBox="0 0 640 360">
            <rect width="640" height="360" fill="#1a1a1a"/>
            <text x="320" y="120" text-anchor="middle" fill="#D4AF37" font-family="Arial" font-size="24">
                Esperando Conexion
            </text>
            <text x="320" y="160" text-anchor="middle" fill="rgba(255,255,255,0.8)" font-family="Arial" font-size="16">
                El modelo esta transmitiendo pero no se puede conectar
            </text>
            <text x="320" y="190" text-anchor="middle" fill="rgba(255,255,255,0.6)" font-family="Arial" font-size="14">
                Intentando conectar via WebRTC...
            </text>
            <text x="320" y="220" text-anchor="middle" fill="rgba(212,175,55,0.8)" font-family="Arial" font-size="12">
                Haz clic para reintentar
            </text>
        </svg>`;
        
        videoElement.poster = 'data:image/svg+xml;base64,' + btoa(svgContent);
        
        // Animación de pulso
        videoElement.style.animation = 'pulse 3s infinite';
        
        if (!document.getElementById('pulse-animation')) {
            const style = document.createElement('style');
            style.id = 'pulse-animation';
            style.textContent = `
                @keyframes pulse {
                    0% { opacity: 0.7; }
                    50% { opacity: 1; }
                    100% { opacity: 0.7; }
                }
            `;
            document.head.appendChild(style);
        }
    }
    
    // Mostrar simulación de video en vivo
    showLiveSimulation(videoElement) {
        console.log('🎬 Mostrando simulación de stream en vivo');
        
        // Crear canvas para simulación
        const canvas = document.createElement('canvas');
        canvas.width = 640;
        canvas.height = 360;
        const ctx = canvas.getContext('2d');
        
        // Función de animación
        let frame = 0;
        const animate = () => {
            // Fondo degradado animado
            const gradient = ctx.createLinearGradient(0, 0, 640, 360);
            gradient.addColorStop(0, `hsl(${(frame * 2) % 360}, 50%, 20%)`);
            gradient.addColorStop(1, `hsl(${(frame * 2 + 180) % 360}, 50%, 30%)`);
            
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, 640, 360);
            
            // Círculos animados
            for (let i = 0; i < 5; i++) {
                const x = 320 + Math.sin((frame + i * 60) * 0.02) * 100;
                const y = 180 + Math.cos((frame + i * 60) * 0.02) * 50;
                const radius = 20 + Math.sin((frame + i * 30) * 0.05) * 10;
                
                ctx.beginPath();
                ctx.arc(x, y, radius, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(212, 175, 55, ${0.3 + Math.sin(frame * 0.03) * 0.2})`;
                ctx.fill();
            }
            
            // Texto "LIVE"
            ctx.fillStyle = '#D4AF37';
            ctx.font = 'bold 32px Arial';
            ctx.textAlign = 'center';
            ctx.fillText('🔴 LIVE', 320, 180);
            
            ctx.fillStyle = 'rgba(255,255,255,0.8)';
            ctx.font = '16px Arial';
            ctx.fillText('Transmision en vivo desde webcam', 320, 220);
            
            frame++;
            requestAnimationFrame(animate);
        };
        
        // Iniciar animación
        animate();
        
        // Convertir canvas a stream y asignar al video
        const stream = canvas.captureStream(30);
        videoElement.srcObject = stream;
        videoElement.play().catch(e => console.log('Autoplay prevented:', e));
        
        // Agregar indicador visual
        videoElement.style.border = '2px solid #D4AF37';
        videoElement.style.borderRadius = '8px';
        videoElement.style.boxShadow = '0 0 20px rgba(212, 175, 55, 0.3)';
    }
    
    // Notificar inicio de stream
    async notifyStreamStart() {
        try {
            const response = await fetch(`/api/stream/${this.streamId}/start-broadcast`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                },
                body: JSON.stringify({
                    streaming_mode: 'webcam',
                    started_at: new Date().toISOString()
                })
            });
            
            if (response.ok) {
                console.log('✅ Stream notificado al servidor');
            }
            
        } catch (error) {
            console.error('❌ Error notificando inicio de stream:', error);
        }
    }
    
    // Notificar unión como viewer
    async notifyJoinViewer(streamId) {
        try {
            const response = await fetch(`/api/stream/${streamId}/join-viewer`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                }
            });
            
            if (response.ok) {
                const result = await response.json();
                console.log('✅ Viewer notificado al servidor:', result);
            }
            
        } catch (error) {
            console.error('❌ Error notificando viewer:', error);
        }
    }
    
    // Detener streaming
    async stopStreaming() {
        try {
            if (this.mediaRecorder && this.mediaRecorder.state === 'recording') {
                this.mediaRecorder.stop();
            }
            
            if (this.localStream) {
                this.localStream.getTracks().forEach(track => track.stop());
                this.localStream = null;
            }
            
            if (this.streamInterval) {
                clearInterval(this.streamInterval);
                this.streamInterval = null;
            }
            
            this.isStreaming = false;
            
            // Notificar al servidor
            await this.notifyStreamStop();
            
            console.log('✅ Streaming detenido');
            
        } catch (error) {
            console.error('❌ Error deteniendo streaming:', error);
        }
    }
    
    // Notificar fin de stream
    async notifyStreamStop() {
        try {
            await fetch(`/api/stream/${this.streamId}/stop-broadcast`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                }
            });
        } catch (error) {
            console.error('❌ Error notificando fin de stream:', error);
        }
    }
    
    // ============ FUNCIONES WEBRTC ============
    
    // Inicializar WebRTC como broadcaster (modelo)
    async initWebRTCBroadcaster() {
        try {
            console.log('📡 Inicializando WebRTC como broadcaster');
            
            // Configurar canal de comunicación usando localStorage (para desarrollo local)
            this.setupSignalingChannel();
            
            // Escuchar solicitudes de conexión de viewers
            this.listenForViewers();
            
            console.log('✅ WebRTC broadcaster configurado');
            
        } catch (error) {
            console.error('❌ Error configurando WebRTC broadcaster:', error);
        }
    }
    
    // Inicializar WebRTC como viewer
    async initWebRTCViewer(streamId, videoElement) {
        try {
            console.log('📺 Inicializando WebRTC como viewer para stream:', streamId);
            
            this.streamId = streamId;
            this.videoElement = videoElement;
            
            // Crear PeerConnection
            this.peerConnection = new RTCPeerConnection(this.rtcConfig);
            
            // Configurar eventos
            this.peerConnection.onicecandidate = (event) => {
                if (event.candidate) {
                    console.log('🧊 ICE candidate generado');
                    this.sendSignal({
                        type: 'ice-candidate',
                        candidate: event.candidate,
                        streamId: this.streamId,
                        from: 'viewer'
                    });
                }
            };
            
            this.peerConnection.ontrack = (event) => {
                console.log('🎥 Stream recibido del broadcaster');
                videoElement.srcObject = event.streams[0];
                videoElement.play().catch(e => console.log('Autoplay prevented:', e));
            };
            
            // Solicitar conexión al broadcaster
            await this.requestConnection();
            
            // Timeout si no hay respuesta en 5 segundos
            setTimeout(() => {
                if (!this.videoElement.srcObject) {
                    console.warn('⏰ Timeout WebRTC - Mostrando placeholder');
                    this.showViewerPlaceholder(videoElement);
                }
            }, 5000);
            
        } catch (error) {
            console.error('❌ Error inicializando WebRTC viewer:', error);
            this.showViewerPlaceholder(videoElement);
        }
    }
    
    // Configurar canal de señalización (localStorage para desarrollo)
    setupSignalingChannel() {
        this.channelName = `stream_${this.streamId}`;
        
        // Escuchar mensajes de señalización
        window.addEventListener('storage', (event) => {
            if (event.key === `${this.channelName}_signal`) {
                const signal = JSON.parse(event.newValue);
                this.handleSignal(signal);
            }
        });
    }
    
    // Escuchar solicitudes de viewers (broadcaster)
    listenForViewers() {
        console.log('👂 Escuchando solicitudes de viewers...');
        
        // Escuchar en localStorage
        window.addEventListener('storage', (event) => {
            if (event.key === `${this.channelName}_request`) {
                const request = JSON.parse(event.newValue);
                if (request.type === 'viewer-request') {
                    console.log('📞 Solicitud de viewer recibida:', request);
                    this.handleViewerRequest(request);
                }
            }
        });
        
        // También verificar periódicamente (fallback)
        setInterval(() => {
            const requestKey = `${this.channelName}_request`;
            const request = localStorage.getItem(requestKey);
            if (request) {
                const parsedRequest = JSON.parse(request);
                if (parsedRequest.type === 'viewer-request' && !parsedRequest.processed) {
                    console.log('📞 Solicitud de viewer encontrada (polling):', parsedRequest);
                    parsedRequest.processed = true;
                    localStorage.setItem(requestKey, JSON.stringify(parsedRequest));
                    this.handleViewerRequest(parsedRequest);
                }
            }
        }, 1000);
    }
    
    // Manejar solicitud de viewer (broadcaster)
    async handleViewerRequest(request) {
        try {
            console.log('🤝 Procesando solicitud de viewer');
            
            // Crear nueva PeerConnection para este viewer
            const peerConnection = new RTCPeerConnection(this.rtcConfig);
            
            // Agregar stream local
            if (this.localStream) {
                this.localStream.getTracks().forEach(track => {
                    peerConnection.addTrack(track, this.localStream);
                });
            }
            
            // Configurar eventos
            peerConnection.onicecandidate = (event) => {
                if (event.candidate) {
                    this.sendSignal({
                        type: 'ice-candidate',
                        candidate: event.candidate,
                        streamId: this.streamId,
                        from: 'broadcaster',
                        to: request.viewerId
                    });
                }
            };
            
            // Crear offer
            const offer = await peerConnection.createOffer();
            await peerConnection.setLocalDescription(offer);
            
            // Enviar offer al viewer
            this.sendSignal({
                type: 'offer',
                offer: offer,
                streamId: this.streamId,
                from: 'broadcaster',
                to: request.viewerId
            });
            
            console.log('📤 Offer enviado al viewer');
            
        } catch (error) {
            console.error('❌ Error manejando solicitud de viewer:', error);
        }
    }
    
    // Solicitar conexión (viewer)
    async requestConnection() {
        console.log('📞 Solicitando conexión al broadcaster');
        
        const viewerId = 'viewer_' + Date.now();
        this.viewerId = viewerId;
        
        // Configurar canal de señalización
        this.setupSignalingChannel();
        
        // Enviar solicitud
        this.sendSignal({
            type: 'viewer-request',
            viewerId: viewerId,
            streamId: this.streamId
        }, '_request');
    }
    
    // Manejar señales WebRTC
    async handleSignal(signal) {
        try {
            console.log('📨 Señal recibida:', signal.type);
            
            if (signal.type === 'offer' && signal.to === this.viewerId) {
                // Viewer recibe offer del broadcaster
                await this.peerConnection.setRemoteDescription(signal.offer);
                
                const answer = await this.peerConnection.createAnswer();
                await this.peerConnection.setLocalDescription(answer);
                
                this.sendSignal({
                    type: 'answer',
                    answer: answer,
                    streamId: this.streamId,
                    from: 'viewer',
                    to: 'broadcaster'
                });
                
                console.log('📤 Answer enviado al broadcaster');
            }
            
            if (signal.type === 'ice-candidate') {
                // Agregar ICE candidate
                await this.peerConnection.addIceCandidate(signal.candidate);
                console.log('🧊 ICE candidate agregado');
            }
            
        } catch (error) {
            console.error('❌ Error manejando señal:', error);
        }
    }
    
    // Enviar señal
    sendSignal(signal, suffix = '_signal') {
        const key = `${this.channelName}${suffix}`;
        const signalWithTimestamp = {
            ...signal,
            timestamp: Date.now()
        };
        
        console.log('📤 Enviando señal:', key, signalWithTimestamp.type);
        localStorage.setItem(key, JSON.stringify(signalWithTimestamp));
        
        // Limpiar después de un momento
        setTimeout(() => {
            localStorage.removeItem(key);
        }, 5000);
    }
}

// Reemplazar el manager anterior
window.StreamingManager = WebcamStreamingManager;
console.log('🚀 WebcamStreamingManager cargado y listo');
