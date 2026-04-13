/**
 * Sistema Híbrido de Streaming para Lustonex
 * Soporta tanto webcam directa como RTMP + OBS
 */
class HybridStreamingManager {
    constructor() {
        this.localStream = null;
        this.mediaRecorder = null;
        this.streamId = null;
        this.isStreaming = false;
        this.streamingMode = 'webcam'; // 'webcam' o 'rtmp'
        this.websocket = null;
        this.recordedChunks = [];

        // Configuración WebRTC para fallback
        this.rtcConfig = {
            iceServers: [
                { urls: 'stun:stun.l.google.com:19302' },
                { urls: 'stun:stun1.l.google.com:19302' }
            ]
        };
    }

    // Detectar capacidades del navegador
    detectCapabilities() {
        const capabilities = {
            getUserMedia: !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia),
            mediaRecorder: !!(window.MediaRecorder),
            webRTC: !!(window.RTCPeerConnection),
            websockets: !!(window.WebSocket)
        };

        console.log('Capacidades detectadas:', capabilities);
        return capabilities;
    }

    // Iniciar streaming (modo automático)
    async startStreaming(streamId, videoElement) {
        this.streamId = streamId;

        try {
            // Detectar capacidades
            const capabilities = this.detectCapabilities();

            if (capabilities.getUserMedia && capabilities.mediaRecorder) {
                // Usar webcam directa
                console.log('Iniciando streaming con webcam directa');
                return await this.startWebcamStreaming(videoElement);
            } else {
                // Fallback a RTMP
                console.log('Fallback a streaming RTMP');
                return await this.startRTMPInstructions(videoElement);
            }

        } catch (error) {
            console.error('Error iniciando streaming:', error);
            throw error;
        }
    }

    // Streaming directo desde webcam
    async startWebcamStreaming(videoElement) {
        try {
            // Solicitar acceso a cámara y micrófono
            this.localStream = await navigator.mediaDevices.getUserMedia({
                video: {
                    width: { ideal: 1280, max: 1920 },
                    height: { ideal: 720, max: 1080 },
                    frameRate: { ideal: 30, max: 60 }
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

            // Configurar MediaRecorder para streaming
            await this.setupMediaRecorder();

            // Conectar WebSocket para transmisión
            await this.connectWebSocket();

            // Iniciar grabación/streaming
            this.mediaRecorder.start(1000); // Chunks de 1 segundo
            this.isStreaming = true;

            // Notificar al servidor que el stream está activo
            await this.notifyStreamStart();

            console.log('Streaming webcam iniciado exitosamente');
            return {
                success: true,
                mode: 'webcam',
                message: 'Streaming iniciado desde webcam'
            };

        } catch (error) {
            console.error('Error en streaming webcam:', error);

            if (error.name === 'NotAllowedError') {
                throw new Error('Permisos de cámara denegados. Por favor, permite el acceso.');
            } else if (error.name === 'NotFoundError') {
                throw new Error('No se encontró cámara o micrófono.');
            } else if (error.name === 'NotReadableError') {
                throw new Error('Cámara en uso por otra aplicación.');
            }

            throw error;
        }
    }

    // Configurar MediaRecorder
    async setupMediaRecorder() {
        if (!this.localStream) {
            throw new Error('No hay stream local disponible');
        }

        // Detectar formato soportado
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

        console.log('Usando MIME type:', mimeType);

        this.mediaRecorder = new MediaRecorder(this.localStream, {
            mimeType: mimeType,
            videoBitsPerSecond: 2500000, // 2.5 Mbps
            audioBitsPerSecond: 128000   // 128 kbps
        });

        this.mediaRecorder.ondataavailable = (event) => {
            if (event.data && event.data.size > 0) {
                this.handleStreamChunk(event.data);
            }
        };

        this.mediaRecorder.onstart = () => {
            console.log('MediaRecorder iniciado');
        };

        this.mediaRecorder.onerror = (event) => {
            console.error('Error en MediaRecorder:', event.error);
        };
    }

    // Conectar WebSocket para transmisión en tiempo real
    async connectWebSocket() {
        return new Promise((resolve, reject) => {
            const protocol = window.location.protocol === 'https:' ? 'wss:' : 'ws:';
            const wsUrl = `${protocol}//${window.location.host}/ws/stream/${this.streamId}`;

            // Fallback: usar HTTP para simular WebSocket
            console.log('Simulando WebSocket con HTTP chunks');
            resolve();
        });
    }

    // Manejar chunks de video
    async handleStreamChunk(chunk) {
        try {
            // Convertir chunk a base64 para envío
            const reader = new FileReader();
            reader.onload = async () => {
                const base64Data = reader.result.split(',')[1];

                // Enviar chunk al servidor
                await this.sendChunkToServer(base64Data);
            };
            reader.readAsDataURL(chunk);

        } catch (error) {
            console.error('Error procesando chunk:', error);
        }
    }

    // Enviar chunk al servidor
    async sendChunkToServer(base64Data) {
        try {
            const response = await fetch('/api/stream/upload-chunk', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                },
                body: JSON.stringify({
                    stream_id: this.streamId,
                    chunk_data: base64Data,
                    timestamp: Date.now()
                })
            });

            if (!response.ok) {
                console.warn('Error enviando chunk al servidor:', response.status);
            }

        } catch (error) {
            console.error('Error en envío de chunk:', error);
        }
    }

    // Mostrar instrucciones RTMP (fallback)
    async startRTMPInstructions(videoElement) {
        try {
            // Generar clave de stream
            const response = await fetch('/api/rtmp/generate-key', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                }
            });

            if (!response.ok) {
                throw new Error('Error generando clave de stream');
            }

            const streamData = await response.json();

            // Mostrar interfaz de instrucciones RTMP
            this.showRTMPInterface(videoElement.parentElement, streamData);

            return {
                success: true,
                mode: 'rtmp',
                message: 'Configuración RTMP lista',
                streamData: streamData
            };

        } catch (error) {
            console.error('Error configurando RTMP:', error);
            throw error;
        }
    }

    // Mostrar interfaz RTMP
    showRTMPInterface(container, streamData) {
        container.innerHTML = `
            <div class="streaming-mode-selector" style="margin-bottom: 2rem;">
                <div style="text-align: center; margin-bottom: 1rem;">
                    <h3 style="color: #D4AF37; margin-bottom: 0.5rem;">Selecciona tu método de streaming</h3>
                    <p style="color: rgba(255,255,255,0.8); font-size: 0.9rem;">Elige cómo quieres transmitir tu contenido</p>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem;">
                    <button onclick="switchToWebcam()" class="mode-btn" style="
                        background: linear-gradient(135deg, #28a745, #20c997);
                        border: none;
                        border-radius: 12px;
                        padding: 1.5rem;
                        color: white;
                        font-weight: 600;
                        cursor: pointer;
                        transition: transform 0.2s;
                    ">
                        <div style="font-size: 2rem; margin-bottom: 0.5rem;">📹</div>
                        <div>Webcam Directa</div>
                        <div style="font-size: 0.8rem; opacity: 0.9; margin-top: 0.5rem;">Fácil y rápido</div>
                    </button>
                    
                    <button onclick="switchToRTMP()" class="mode-btn" style="
                        background: linear-gradient(135deg, #D4AF37, #B8860B);
                        border: none;
                        border-radius: 12px;
                        padding: 1.5rem;
                        color: white;
                        font-weight: 600;
                        cursor: pointer;
                        transition: transform 0.2s;
                    ">
                        <div style="font-size: 2rem; margin-bottom: 0.5rem;">🎥</div>
                        <div>OBS Studio</div>
                        <div style="font-size: 0.8rem; opacity: 0.9; margin-top: 0.5rem;">Profesional</div>
                    </button>
                </div>
            </div>
            
            <div id="webcam-interface" style="display: none;">
                <div style="text-align: center; padding: 2rem; background: rgba(40, 167, 69, 0.1); border-radius: 12px; border: 1px solid rgba(40, 167, 69, 0.3);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📹</div>
                    <h3 style="color: #28a745; margin-bottom: 1rem;">Streaming desde Webcam</h3>
                    <p style="color: rgba(255,255,255,0.8); margin-bottom: 2rem;">Haz clic en el botón para iniciar tu transmisión directamente desde tu cámara web</p>
                    <button onclick="startWebcamDirect()" style="
                        background: linear-gradient(135deg, #28a745, #20c997);
                        border: none;
                        border-radius: 8px;
                        padding: 1rem 2rem;
                        color: white;
                        font-weight: 600;
                        cursor: pointer;
                        font-size: 1.1rem;
                    ">
                        🚀 Iniciar Webcam
                    </button>
                </div>
            </div>
            
            <div id="rtmp-interface" style="display: none;">
                <div style="background: rgba(212, 175, 55, 0.1); border-radius: 12px; border: 1px solid rgba(212, 175, 55, 0.3); padding: 2rem;">
                    <div style="text-align: center; margin-bottom: 2rem;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">📡</div>
                        <h3 style="color: #D4AF37; margin-bottom: 0.5rem;">Configuración RTMP</h3>
                        <p style="color: rgba(255,255,255,0.8);">Usa OBS Studio para streaming profesional</p>
                    </div>
                    
                    <div style="background: rgba(0,0,0,0.3); border-radius: 8px; padding: 1.5rem; margin-bottom: 1rem;">
                        <div style="margin-bottom: 1rem;">
                            <label style="color: #D4AF37; font-weight: 600; display: block; margin-bottom: 0.5rem;">Servidor RTMP:</label>
                            <input type="text" value="rtmp://localhost/live" readonly style="
                                width: 100%; padding: 0.75rem; background: rgba(255,255,255,0.1); 
                                border: 1px solid rgba(212,175,55,0.3); border-radius: 4px; 
                                color: white; font-family: monospace;
                            ">
                        </div>
                        <div>
                            <label style="color: #D4AF37; font-weight: 600; display: block; margin-bottom: 0.5rem;">Clave de Stream:</label>
                            <input type="text" value="${streamData.stream_key}" readonly style="
                                width: 100%; padding: 0.75rem; background: rgba(255,255,255,0.1); 
                                border: 1px solid rgba(212,175,55,0.3); border-radius: 4px; 
                                color: white; font-family: monospace;
                            ">
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Agregar funciones globales
        window.switchToWebcam = () => {
            document.getElementById('webcam-interface').style.display = 'block';
            document.getElementById('rtmp-interface').style.display = 'none';
        };

        window.switchToRTMP = () => {
            document.getElementById('webcam-interface').style.display = 'none';
            document.getElementById('rtmp-interface').style.display = 'block';
        };

        window.startWebcamDirect = async () => {
            try {
                const videoElement = document.createElement('video');
                videoElement.style.width = '100%';
                videoElement.style.height = '100%';
                videoElement.style.borderRadius = '12px';

                container.innerHTML = '';
                container.appendChild(videoElement);

                await this.startWebcamStreaming(videoElement);
            } catch (error) {
                console.error('Error iniciando webcam:', error);
                alert('Error: ' + error.message);
            }
        };
    }

    // Notificar inicio de stream al servidor
    async notifyStreamStart() {
        try {
            const response = await fetch(`/api/stream/${this.streamId}/start-broadcast`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                },
                body: JSON.stringify({
                    streaming_mode: this.streamingMode,
                    started_at: new Date().toISOString()
                })
            });

            if (response.ok) {
                const result = await response.json();
                console.log('Stream iniciado en servidor:', result);
            }

        } catch (error) {
            console.error('Error notificando inicio de stream:', error);
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

            if (this.websocket) {
                this.websocket.close();
                this.websocket = null;
            }

            this.isStreaming = false;

            // Notificar al servidor
            await this.notifyStreamStop();

            console.log('Streaming detenido');

        } catch (error) {
            console.error('Error deteniendo streaming:', error);
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
            console.error('Error notificando fin de stream:', error);
        }
    }

    // Conectar como viewer (para HLS)
    async connectAsViewer(streamId, videoElement) {
        try {
            // Primero intentar obtener playlist HLS de webcam
            let streamInfo = null;

            try {
                const hlsResponse = await fetch(`/api/stream/${streamId}/hls-playlist`);
                if (hlsResponse.ok) {
                    const hlsData = await hlsResponse.json();
                    if (hlsData.success) {
                        streamInfo = hlsData.stream_info;
                        streamInfo.hls_url = hlsData.hls_url;
                        console.log('Stream HLS de webcam encontrado:', streamInfo);
                    }
                }
            } catch (hlsError) {
                console.log('No hay stream HLS de webcam, intentando stream info general...');
            }

            // Si no hay HLS de webcam, intentar stream info general
            if (!streamInfo) {
                const response = await fetch(`/api/stream/${streamId}/info`);

                if (!response.ok) {
                    // Si el stream específico no existe, mostrar placeholder
                    console.log('Stream específico no encontrado, mostrando placeholder');
                    this.showViewerPlaceholder(videoElement);
                    return true;
                }

                streamInfo = await response.json();
            }

            if (streamInfo.status !== 'live') {
                throw new Error('Stream no está activo');
            }

            // Si hay URL HLS, usar reproductor HLS
            if (streamInfo.hls_url) {
                console.log('Inicializando reproductor HLS con:', streamInfo.hls_url);
                await this.initHLSPlayer(streamInfo.hls_url, videoElement);
            } else {
                // Fallback a simulación
                console.log('No hay HLS disponible, mostrando placeholder');
                this.showViewerPlaceholder(videoElement);
            }

            // Notificar unión como viewer
            await this.notifyJoinViewer(streamId);

            return true;

        } catch (error) {
            console.error('Error conectando como viewer:', error);
            throw error;
        }
    }

    // Inicializar reproductor HLS
    async initHLSPlayer(hlsUrl, videoElement) {
        // Cargar HLS.js si no está disponible
        if (!window.Hls && !videoElement.canPlayType('application/vnd.apple.mpegurl')) {
            await this.loadHLSLibrary();
        }

        if (window.Hls && Hls.isSupported()) {
            const hls = new Hls({
                debug: false,
                enableWorker: true,
                lowLatencyMode: true,
                liveSyncDurationCount: 2,
                liveMaxLatencyDurationCount: 4,
                maxBufferLength: 3,
                maxMaxBufferLength: 6,
                backBufferLength: 10,
                highBufferWatchdogPeriod: 1,
            });

            hls.loadSource(hlsUrl);
            hls.attachMedia(videoElement);

            hls.on(Hls.Events.MANIFEST_PARSED, () => {
                videoElement.play().catch(e => console.log('Autoplay prevented:', e));
            });

        } else if (videoElement.canPlayType('application/vnd.apple.mpegurl')) {
            // Safari nativo
            videoElement.src = hlsUrl;
            videoElement.play().catch(e => console.log('Autoplay prevented:', e));
        }
    }

    // Cargar librería HLS.js
    async loadHLSLibrary() {
        return new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/hls.js@latest';
            script.onload = resolve;
            script.onerror = reject;
            document.head.appendChild(script);
        });
    }

    // Mostrar placeholder para viewer
    showViewerPlaceholder(videoElement) {
        videoElement.style.background = 'linear-gradient(45deg, #1a1a1a, #2a2a2a)';
        videoElement.poster = 'data:image/svg+xml;base64,' + btoa(`
            <svg xmlns="http://www.w3.org/2000/svg" width="640" height="360" viewBox="0 0 640 360">
                <rect width="640" height="360" fill="#1a1a1a"/>
                <text x="320" y="140" text-anchor="middle" fill="#D4AF37" font-family="Arial" font-size="24">
                    📹 Stream Simulado
                </text>
                <text x="320" y="180" text-anchor="middle" fill="rgba(255,255,255,0.8)" font-family="Arial" font-size="16">
                    El modelo no está transmitiendo
                </text>
                <text x="320" y="210" text-anchor="middle" fill="rgba(255,255,255,0.6)" font-family="Arial" font-size="14">
                    Mostrando contenido de demostración
                </text>
            </svg>
        `);

        // Agregar animación de pulso
        videoElement.style.animation = 'pulse 2s infinite';

        // Agregar CSS para la animación si no existe
        if (!document.getElementById('pulse-animation')) {
            const style = document.createElement('style');
            style.id = 'pulse-animation';
            style.textContent = `
                @keyframes pulse {
                    0% { opacity: 0.8; }
                    50% { opacity: 1; }
                    100% { opacity: 0.8; }
                }
            `;
            document.head.appendChild(style);
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
                console.log('Notificación de viewer exitosa:', result);
                return result;
            } else {
                console.log('Error en notificación de viewer:', response.status);
            }

        } catch (error) {
            console.error('Error notificando unión como viewer:', error);
        }
    }
}

// Reemplazar el manager anterior
window.StreamingManager = HybridStreamingManager;
