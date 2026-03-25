class StreamingManager {
    constructor() {
        this.localStream = null;
        this.remoteStream = null;
        this.peerConnection = null;
        this.streamId = null;
        this.isStreamer = false;
        this.viewers = new Set();
        
        // Configuración WebRTC
        this.rtcConfig = {
            iceServers: [
                { urls: 'stun:stun.l.google.com:19302' },
                { urls: 'stun:stun1.l.google.com:19302' }
            ]
        };
        
        // Canal de comunicación (simulado con localStorage para desarrollo local)
        this.channelName = null;
        this.setupLocalChannel();
    }

    // Configurar canal de comunicación local
    setupLocalChannel() {
        // Escuchar cambios en localStorage para simular WebSocket
        window.addEventListener('storage', (e) => {
            if (e.key && e.key.startsWith('stream_signal_')) {
                this.handleSignal(JSON.parse(e.newValue));
            }
        });
    }

    // Iniciar como streamer (modelo)
    async startStreaming(streamId, videoElement) {
        try {
            this.streamId = streamId;
            this.isStreamer = true;
            this.channelName = `stream_${streamId}`;
            
            console.log('Iniciando streaming para stream:', streamId);
            
            // Obtener stream de la cámara
            this.localStream = await navigator.mediaDevices.getUserMedia({
                video: { width: 1280, height: 720 },
                audio: true
            });
            
            // Mostrar video local
            if (videoElement) {
                videoElement.srcObject = this.localStream;
            }
            
            // Notificar al servidor que el streaming ha iniciado
            await this.notifyStreamStart();
            
            // Guardar información del stream para viewers
            const streamInfo = {
                streamId: streamId,
                isActive: true,
                startedAt: new Date().toISOString(),
                streamerReady: true
            };
            localStorage.setItem(`stream_info_${streamId}`, JSON.stringify(streamInfo));
            
            console.log('Streaming iniciado exitosamente');
            return true;
            
        } catch (error) {
            console.error('Error iniciando streaming:', error);
            throw error;
        }
    }

    // Conectar como viewer
    async connectAsViewer(streamId, videoElement) {
        try {
            this.streamId = streamId;
            this.isStreamer = false;
            this.channelName = `stream_${streamId}`;
            
            console.log('Conectando como viewer al stream:', streamId);
            
            // Primero verificar con el servidor si el stream está activo
            let streamActive = false;
            try {
                const response = await fetch(`/api/stream/${streamId}/info`);
                if (response.ok) {
                    const serverInfo = await response.json();
                    console.log('Info del servidor:', serverInfo);
                    streamActive = serverInfo.status === 'live';
                }
            } catch (serverError) {
                console.log('No se pudo verificar con el servidor, usando localStorage');
            }
            
            // Si el servidor no responde, verificar localStorage como fallback
            if (!streamActive) {
                const streamInfo = localStorage.getItem(`stream_info_${streamId}`);
                if (streamInfo) {
                    const info = JSON.parse(streamInfo);
                    streamActive = info.isActive && info.streamerReady;
                    console.log('Info de localStorage:', info);
                }
            }
            
            // Si no encontramos información activa, intentar conectar de todos modos
            if (!streamActive) {
                console.log('No se encontró información del stream, intentando conexión directa...');
            }
            
            // Notificar al servidor que se unió como viewer
            await this.notifyJoinViewer();
            
            // Simular conexión al stream del modelo
            await this.simulateViewerConnection(videoElement);
            
            console.log('Conectado como viewer exitosamente');
            return true;
            
        } catch (error) {
            console.error('Error conectando como viewer:', error);
            throw error;
        }
    }

    // Simular conexión de viewer (para desarrollo local)
    async simulateViewerConnection(videoElement) {
        if (!videoElement) {
            console.error('No se proporcionó elemento de video');
            return;
        }

        try {
            console.log('Intentando conectar con cámara para simulación...');
            
            // Intentar diferentes configuraciones de video
            const videoConfigs = [
                { video: { width: 1280, height: 720 }, audio: true },
                { video: { width: 854, height: 480 }, audio: true },
                { video: { width: 640, height: 360 }, audio: false },
                { video: true, audio: false }
            ];
            
            let connected = false;
            
            for (const config of videoConfigs) {
                try {
                    console.log('Probando configuración:', config);
                    this.remoteStream = await navigator.mediaDevices.getUserMedia(config);
                    
                    videoElement.srcObject = this.remoteStream;
                    
                    // Agregar overlay para indicar que es una simulación
                    this.addViewerOverlay(videoElement);
                    
                    console.log('Conexión exitosa con configuración:', config);
                    connected = true;
                    break;
                    
                } catch (configError) {
                    console.log('Configuración falló:', config, configError.message);
                    continue;
                }
            }
            
            if (!connected) {
                throw new Error('No se pudo conectar con ninguna configuración de cámara');
            }
            
        } catch (error) {
            console.error('Error simulando conexión de viewer:', error);
            console.log('Mostrando placeholder animado...');
            
            // Si no hay cámara, mostrar placeholder
            this.showPlaceholder(videoElement);
        }
    }

    // Agregar overlay para viewers
    addViewerOverlay(videoElement) {
        const container = videoElement.parentElement;
        if (!container) return;
        
        const overlay = document.createElement('div');
        overlay.className = 'viewer-overlay';
        overlay.style.cssText = `
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(0, 123, 255, 0.9);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            z-index: 100;
            animation: pulse 2s infinite;
        `;
        overlay.innerHTML = '👁️ VIEWER MODE - Simulación Local';
        
        container.style.position = 'relative';
        container.appendChild(overlay);
    }

    // Mostrar placeholder cuando no hay cámara
    showPlaceholder(videoElement) {
        const canvas = document.createElement('canvas');
        canvas.width = 1280;
        canvas.height = 720;
        const ctx = canvas.getContext('2d');
        
        let frame = 0;
        const animate = () => {
            // Fondo degradado
            const gradient = ctx.createLinearGradient(0, 0, canvas.width, canvas.height);
            gradient.addColorStop(0, '#1F1F23');
            gradient.addColorStop(1, '#0B0B0D');
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            
            // Texto
            ctx.fillStyle = '#007bff';
            ctx.font = 'bold 48px Arial';
            ctx.textAlign = 'center';
            ctx.fillText('👁️ VIEWER MODE', canvas.width/2, canvas.height/2 - 50);
            
            ctx.fillStyle = '#FFFFFF';
            ctx.font = '32px Arial';
            ctx.fillText('Stream Simulado', canvas.width/2, canvas.height/2 + 20);
            
            // Indicador pulsante
            const pulse = Math.sin(frame * 0.1) * 0.3 + 0.7;
            ctx.fillStyle = `rgba(0, 123, 255, ${pulse})`;
            ctx.beginPath();
            ctx.arc(canvas.width/2 - 200, canvas.height/2 - 40, 20, 0, 2 * Math.PI);
            ctx.fill();
            
            frame++;
            requestAnimationFrame(animate);
        };
        animate();
        
        const stream = canvas.captureStream(30);
        videoElement.srcObject = stream;
    }

    // Detener streaming
    async stopStreaming() {
        try {
            if (this.localStream) {
                this.localStream.getTracks().forEach(track => track.stop());
                this.localStream = null;
            }
            
            if (this.remoteStream) {
                this.remoteStream.getTracks().forEach(track => track.stop());
                this.remoteStream = null;
            }
            
            if (this.isStreamer) {
                // Limpiar información del stream
                localStorage.removeItem(`stream_info_${this.streamId}`);
                await this.notifyStreamStop();
            } else {
                await this.notifyLeaveViewer();
            }
            
            console.log('Streaming detenido');
            
        } catch (error) {
            console.error('Error deteniendo streaming:', error);
        }
    }

    // Notificaciones al servidor
    async notifyStreamStart() {
        try {
            const response = await fetch(`/api/stream/${this.streamId}/start-broadcast`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            return await response.json();
        } catch (error) {
            console.error('Error notificando inicio de stream:', error);
        }
    }

    async notifyStreamStop() {
        try {
            const response = await fetch(`/api/stream/${this.streamId}/stop-broadcast`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            return await response.json();
        } catch (error) {
            console.error('Error notificando fin de stream:', error);
        }
    }

    async notifyJoinViewer() {
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.log('No se encontró token CSRF, continuando sin notificación al servidor');
                return { success: false, message: 'No CSRF token' };
            }

            const response = await fetch(`/api/stream/${this.streamId}/join-viewer`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken.content
                }
            });
            
            if (!response.ok) {
                console.log('Respuesta del servidor no exitosa:', response.status, response.statusText);
                return { success: false, message: 'Server error' };
            }
            
            const result = await response.json();
            console.log('Notificación al servidor exitosa:', result);
            return result;
            
        } catch (error) {
            console.error('Error notificando unión como viewer:', error);
            return { success: false, message: error.message };
        }
    }

    async notifyLeaveViewer() {
        try {
            const response = await fetch(`/api/stream/${this.streamId}/leave-viewer`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            return await response.json();
        } catch (error) {
            console.error('Error notificando salida como viewer:', error);
        }
    }

    // Manejar señales (para futuro WebRTC completo)
    handleSignal(signal) {
        console.log('Señal recibida:', signal);
        // Aquí se manejarían las señales WebRTC en un entorno completo
    }

    // Función de debugging para verificar estado
    debugStreamState(streamId) {
        console.log('=== DEBUG STREAM STATE ===');
        console.log('Stream ID:', streamId);
        
        // Verificar localStorage
        const streamInfo = localStorage.getItem(`stream_info_${streamId}`);
        console.log('localStorage stream info:', streamInfo ? JSON.parse(streamInfo) : 'No encontrado');
        
        // Verificar todas las claves de localStorage relacionadas con streams
        const allKeys = Object.keys(localStorage);
        const streamKeys = allKeys.filter(key => key.includes('stream'));
        console.log('Todas las claves de stream en localStorage:', streamKeys);
        
        streamKeys.forEach(key => {
            console.log(`${key}:`, localStorage.getItem(key));
        });
        
        console.log('=== END DEBUG ===');
    }
}

// Instancia global
window.StreamingManager = StreamingManager;
