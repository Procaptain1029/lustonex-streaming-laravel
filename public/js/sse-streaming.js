/**
 * SSE Streaming Manager - Sistema simple para streaming en tiempo real
 */
class SSEStreamingManager {
    constructor() {
        this.localStream = null;
        this.mediaRecorder = null;
        this.streamId = null;
        this.isStreaming = false;
        this.eventSource = null;
        this.videoElement = null;
        
        console.log('SSEStreamingManager inicializado');
    }
    
    // ============ BROADCASTER (MODELO) ============
    
    /**
     * Iniciar streaming como broadcaster
     */
    async startBroadcast(streamId, videoElement) {
        try {
            this.streamId = streamId;
            console.log('🎬 Iniciando broadcast SSE para stream:', streamId);
            
            // Obtener acceso a webcam
            this.localStream = await navigator.mediaDevices.getUserMedia({
                video: { width: 1280, height: 720 },
                audio: true
            });
            
            // Mostrar video local
            videoElement.srcObject = this.localStream;
            
            // Configurar MediaRecorder
            this.setupMediaRecorder();
            
            // Iniciar grabación
            this.mediaRecorder.start(2000); // Chunks de 2 segundos
            this.isStreaming = true;
            
            console.log('✅ Broadcast SSE iniciado');
            return { success: true, message: 'Broadcast iniciado' };
            
        } catch (error) {
            console.error('❌ Error iniciando broadcast:', error);
            throw error;
        }
    }
    
    /**
     * Configurar MediaRecorder para SSE
     */
    setupMediaRecorder() {
        // Detectar formato soportado
        let mimeType = 'video/webm;codecs=vp9,opus';
        if (!MediaRecorder.isTypeSupported(mimeType)) {
            mimeType = 'video/webm;codecs=vp8,opus';
        }
        if (!MediaRecorder.isTypeSupported(mimeType)) {
            mimeType = 'video/webm';
        }
        
        console.log('📹 Usando formato:', mimeType);
        
        this.mediaRecorder = new MediaRecorder(this.localStream, {
            mimeType: mimeType,
            videoBitsPerSecond: 1000000, // 1 Mbps
            audioBitsPerSecond: 128000   // 128 kbps
        });
        
        this.mediaRecorder.ondataavailable = (event) => {
            if (event.data && event.data.size > 0) {
                console.log('📦 Chunk generado:', event.data.size, 'bytes');
                this.sendChunkToSSE(event.data);
            }
        };
        
        this.mediaRecorder.onerror = (error) => {
            console.error('❌ Error MediaRecorder:', error);
        };
    }
    
    /**
     * Enviar chunk al servidor SSE
     */
    async sendChunkToSSE(chunk) {
        try {
            // Convertir a base64
            const reader = new FileReader();
            reader.onload = async () => {
                const base64Data = reader.result.split(',')[1];
                
                // Enviar al servidor
                const response = await fetch(`/api/stream/${this.streamId}/sse-chunk`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    },
                    body: JSON.stringify({
                        chunk_data: base64Data,
                        timestamp: Date.now()
                    })
                });
                
                if (response.ok) {
                    const result = await response.json();
                    console.log('✅ Chunk enviado via SSE:', result.chunk_id);
                } else {
                    console.warn('⚠️ Error enviando chunk SSE:', response.status);
                }
            };
            
            reader.readAsDataURL(chunk);
            
        } catch (error) {
            console.error('❌ Error enviando chunk SSE:', error);
        }
    }
    
    /**
     * Detener broadcast
     */
    async stopBroadcast() {
        try {
            if (this.mediaRecorder && this.mediaRecorder.state !== 'inactive') {
                this.mediaRecorder.stop();
            }
            
            if (this.localStream) {
                this.localStream.getTracks().forEach(track => track.stop());
                this.localStream = null;
            }
            
            this.isStreaming = false;
            console.log('🛑 Broadcast SSE detenido');
            
        } catch (error) {
            console.error('❌ Error deteniendo broadcast:', error);
        }
    }
    
    // ============ VIEWER ============
    
    /**
     * Conectar como viewer via SSE
     */
    async connectAsViewer(streamId, videoElement) {
        try {
            this.streamId = streamId;
            this.videoElement = videoElement;
            
            console.log('👁️ Conectando como viewer SSE al stream:', streamId);
            
            // Verificar que el stream existe
            const infoResponse = await fetch(`/api/stream/${streamId}/sse-info`);
            if (!infoResponse.ok) {
                throw new Error('Stream no encontrado');
            }
            
            const streamInfo = await infoResponse.json();
            console.log('📄 Info del stream:', streamInfo);
            
            if (streamInfo.status !== 'live') {
                this.showPlaceholder('Stream no activo');
                return;
            }
            
            // Conectar SSE
            this.connectSSE();
            
        } catch (error) {
            console.error('❌ Error conectando viewer SSE:', error);
            this.showPlaceholder('Error de conexión');
        }
    }
    
    /**
     * Conectar al stream SSE
     */
    connectSSE() {
        const sseUrl = `/api/stream/${this.streamId}/sse`;
        console.log('🔗 Conectando SSE:', sseUrl);
        
        this.eventSource = new EventSource(sseUrl);
        
        this.eventSource.onopen = () => {
            console.log('✅ Conexión SSE establecida');
        };
        
        this.eventSource.onmessage = (event) => {
            try {
                const data = JSON.parse(event.data);
                this.handleSSEMessage(data);
            } catch (error) {
                console.error('❌ Error procesando mensaje SSE:', error);
            }
        };
        
        this.eventSource.onerror = (error) => {
            console.error('❌ Error SSE:', error);
            this.showPlaceholder('Error de conexión SSE');
        };
    }
    
    /**
     * Manejar mensajes SSE
     */
    handleSSEMessage(data) {
        switch (data.type) {
            case 'connected':
                console.log('🔗 Conectado al stream SSE:', data.stream_id);
                break;
                
            case 'video_chunk':
                console.log('📦 Chunk recibido via SSE:', data.chunk_id);
                this.playVideoChunk(data.data);
                break;
                
            case 'heartbeat':
                console.log('💓 Heartbeat SSE');
                break;
                
            case 'stream_ended':
                console.log('🛑 Stream terminado');
                this.showPlaceholder('Stream terminado');
                this.disconnectSSE();
                break;
                
            default:
                console.log('📨 Mensaje SSE desconocido:', data.type);
        }
    }
    
    /**
     * Reproducir chunk de video
     */
    playVideoChunk(base64Data) {
        try {
            // Crear blob del chunk
            const binaryString = atob(base64Data);
            const bytes = new Uint8Array(binaryString.length);
            for (let i = 0; i < binaryString.length; i++) {
                bytes[i] = binaryString.charCodeAt(i);
            }
            
            const blob = new Blob([bytes], { type: 'video/webm' });
            const videoUrl = URL.createObjectURL(blob);
            
            // Reproducir en el elemento video
            this.videoElement.src = videoUrl;
            this.videoElement.play().catch(e => {
                console.log('Autoplay prevented:', e);
            });
            
            // Limpiar URL después de un tiempo
            setTimeout(() => {
                URL.revokeObjectURL(videoUrl);
            }, 5000);
            
        } catch (error) {
            console.error('❌ Error reproduciendo chunk:', error);
        }
    }
    
    /**
     * Mostrar placeholder
     */
    showPlaceholder(message) {
        if (!this.videoElement) return;
        
        this.videoElement.src = '';
        this.videoElement.poster = `data:image/svg+xml;base64,${btoa(`
            <svg xmlns="http://www.w3.org/2000/svg" width="640" height="360" viewBox="0 0 640 360">
                <rect width="640" height="360" fill="#1a1a1a"/>
                <text x="320" y="180" text-anchor="middle" fill="#D4AF37" font-family="Arial" font-size="24">
                    ${message}
                </text>
                <text x="320" y="220" text-anchor="middle" fill="rgba(255,255,255,0.6)" font-family="Arial" font-size="16">
                    Streaming via SSE
                </text>
            </svg>
        `)}`;
    }
    
    /**
     * Desconectar SSE
     */
    disconnectSSE() {
        if (this.eventSource) {
            this.eventSource.close();
            this.eventSource = null;
            console.log('🔌 Desconectado de SSE');
        }
    }
}

// Hacer disponible globalmente
window.SSEStreamingManager = SSEStreamingManager;
console.log('🚀 SSEStreamingManager cargado y listo');
