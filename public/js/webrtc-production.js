// Configuración de WebRTC para Producción
class ProductionStreamingManager {
    constructor() {
        this.localStream = null;
        this.remoteStream = null;
        this.peerConnection = null;
        this.streamId = null;
        this.isStreamer = false;
        this.socket = null;
        
        // Configuración para producción
        this.config = {
            // Servidor de señalización WebSocket
            signalingServer: process.env.STREAMING_SERVER_URL || 'wss://your-domain.com/socket.io',
            
            // Servidores STUN/TURN para NAT traversal
            iceServers: [
                { urls: 'stun:stun.l.google.com:19302' },
                { urls: 'stun:stun1.l.google.com:19302' },
                // Agregar servidores TURN para redes corporativas
                {
                    urls: 'turn:your-turn-server.com:3478',
                    username: 'your-username',
                    credential: 'your-password'
                }
            ]
        };
        
        this.setupSignaling();
    }

    // Configurar conexión de señalización WebSocket
    setupSignaling() {
        try {
            // Usar Socket.IO para señalización en tiempo real
            this.socket = io(this.config.signalingServer, {
                transports: ['websocket', 'polling'],
                secure: true,
                rejectUnauthorized: false
            });
            
            this.socket.on('connect', () => {
                console.log('Conectado al servidor de señalización');
            });
            
            this.socket.on('disconnect', () => {
                console.log('Desconectado del servidor de señalización');
            });
            
            // Manejar señales WebRTC
            this.socket.on('webrtc-signal', (data) => {
                this.handleWebRTCSignal(data);
            });
            
            this.socket.on('viewer-joined', (data) => {
                console.log('Nuevo viewer se unió:', data);
                if (this.isStreamer) {
                    this.createPeerConnection(data.viewerId);
                }
            });
            
        } catch (error) {
            console.error('Error configurando señalización:', error);
        }
    }

    // Iniciar streaming como modelo (broadcaster)
    async startStreaming(streamId, videoElement) {
        try {
            this.streamId = streamId;
            this.isStreamer = true;
            
            console.log('Iniciando streaming en producción para stream:', streamId);
            
            // Obtener stream de la cámara
            this.localStream = await navigator.mediaDevices.getUserMedia({
                video: { 
                    width: { ideal: 1280 }, 
                    height: { ideal: 720 },
                    frameRate: { ideal: 30 }
                },
                audio: {
                    echoCancellation: true,
                    noiseSuppression: true,
                    autoGainControl: true
                }
            });
            
            // Mostrar video local
            if (videoElement) {
                videoElement.srcObject = this.localStream;
            }
            
            // Unirse al room del stream
            this.socket.emit('join-stream-room', {
                streamId: streamId,
                role: 'broadcaster'
            });
            
            // Notificar al servidor Laravel
            await this.notifyStreamStart();
            
            console.log('Streaming iniciado exitosamente en producción');
            return true;
            
        } catch (error) {
            console.error('Error iniciando streaming en producción:', error);
            throw error;
        }
    }

    // Conectar como viewer
    async connectAsViewer(streamId, videoElement) {
        try {
            this.streamId = streamId;
            this.isStreamer = false;
            
            console.log('Conectando como viewer en producción al stream:', streamId);
            
            // Verificar que el stream esté activo
            const streamInfo = await this.getStreamInfo(streamId);
            if (!streamInfo || streamInfo.status !== 'live') {
                throw new Error('Stream no está activo');
            }
            
            // Unirse al room como viewer
            this.socket.emit('join-stream-room', {
                streamId: streamId,
                role: 'viewer'
            });
            
            // Crear conexión peer para recibir el stream
            await this.createPeerConnection();
            
            // Notificar al servidor Laravel
            await this.notifyJoinViewer();
            
            console.log('Conectado como viewer exitosamente');
            return true;
            
        } catch (error) {
            console.error('Error conectando como viewer:', error);
            throw error;
        }
    }

    // Crear conexión WebRTC peer-to-peer
    async createPeerConnection(targetId = null) {
        try {
            this.peerConnection = new RTCPeerConnection({
                iceServers: this.config.iceServers
            });
            
            // Agregar stream local si es broadcaster
            if (this.isStreamer && this.localStream) {
                this.localStream.getTracks().forEach(track => {
                    this.peerConnection.addTrack(track, this.localStream);
                });
            }
            
            // Manejar stream remoto
            this.peerConnection.ontrack = (event) => {
                console.log('Stream remoto recibido');
                this.remoteStream = event.streams[0];
                
                const remoteVideo = document.getElementById('remoteVideo');
                if (remoteVideo) {
                    remoteVideo.srcObject = this.remoteStream;
                }
            };
            
            // Manejar candidatos ICE
            this.peerConnection.onicecandidate = (event) => {
                if (event.candidate) {
                    this.socket.emit('webrtc-signal', {
                        type: 'ice-candidate',
                        candidate: event.candidate,
                        streamId: this.streamId,
                        targetId: targetId
                    });
                }
            };
            
            // Si es viewer, crear offer
            if (!this.isStreamer) {
                const offer = await this.peerConnection.createOffer();
                await this.peerConnection.setLocalDescription(offer);
                
                this.socket.emit('webrtc-signal', {
                    type: 'offer',
                    offer: offer,
                    streamId: this.streamId
                });
            }
            
        } catch (error) {
            console.error('Error creando conexión peer:', error);
            throw error;
        }
    }

    // Manejar señales WebRTC
    async handleWebRTCSignal(data) {
        try {
            if (!this.peerConnection) {
                await this.createPeerConnection();
            }
            
            switch (data.type) {
                case 'offer':
                    if (this.isStreamer) {
                        await this.peerConnection.setRemoteDescription(data.offer);
                        const answer = await this.peerConnection.createAnswer();
                        await this.peerConnection.setLocalDescription(answer);
                        
                        this.socket.emit('webrtc-signal', {
                            type: 'answer',
                            answer: answer,
                            streamId: this.streamId,
                            targetId: data.senderId
                        });
                    }
                    break;
                    
                case 'answer':
                    if (!this.isStreamer) {
                        await this.peerConnection.setRemoteDescription(data.answer);
                    }
                    break;
                    
                case 'ice-candidate':
                    await this.peerConnection.addIceCandidate(data.candidate);
                    break;
            }
            
        } catch (error) {
            console.error('Error manejando señal WebRTC:', error);
        }
    }

    // Obtener información del stream del servidor
    async getStreamInfo(streamId) {
        try {
            const response = await fetch(`/api/stream/${streamId}/info`);
            if (response.ok) {
                return await response.json();
            }
            return null;
        } catch (error) {
            console.error('Error obteniendo info del stream:', error);
            return null;
        }
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
            
            if (this.peerConnection) {
                this.peerConnection.close();
                this.peerConnection = null;
            }
            
            if (this.socket) {
                this.socket.emit('leave-stream-room', {
                    streamId: this.streamId,
                    role: this.isStreamer ? 'broadcaster' : 'viewer'
                });
            }
            
            if (this.isStreamer) {
                await this.notifyStreamStop();
            } else {
                await this.notifyLeaveViewer();
            }
            
            console.log('Streaming detenido');
            
        } catch (error) {
            console.error('Error deteniendo streaming:', error);
        }
    }

    // Notificaciones al servidor Laravel (igual que en desarrollo)
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
            const response = await fetch(`/api/stream/${this.streamId}/join-viewer`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            return await response.json();
        } catch (error) {
            console.error('Error notificando unión como viewer:', error);
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
}

// Detectar si estamos en producción o desarrollo
const isProduction = window.location.protocol === 'https:' && !window.location.hostname.includes('localhost');

// Usar el manager apropiado según el entorno
window.StreamingManager = isProduction ? ProductionStreamingManager : StreamingManager;
