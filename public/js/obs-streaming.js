/**
 * OBS Streaming Manager - Sistema profesional RTMP + HLS
 */
class OBSStreamingManager {
    constructor() {
        this.streamKey = null;
        this.rtmpUrl = null;
        this.hlsUrl = null;
        this.isConnected = false;
        this.connectionCheckInterval = null;
        this.hlsPlayer = null;
        
        console.log('🎬 OBS Streaming Manager inicializado');
    }
    
    // ============ SETUP OBS ============
    
    /**
     * Generar configuración OBS para el modelo
     */
    async generateOBSConfig(streamId) {
        try {
            console.log('🔧 Generando configuración OBS para stream:', streamId);
            
            // Verificar CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            if (!csrfToken) {
                throw new Error('CSRF token no encontrado. Recarga la página.');
            }
            console.log('🔐 CSRF token encontrado:', csrfToken.substring(0, 10) + '...');
            
            const response = await fetch('/model/obs/generate-key', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    stream_id: streamId
                })
            });
            
            if (!response.ok) {
                const errorText = await response.text();
                console.error('❌ Response error:', response.status, errorText);
                
                if (response.status === 401) {
                    throw new Error('No autorizado. Inicia sesión como modelo.');
                } else if (response.status === 403) {
                    throw new Error('Acceso denegado. Solo modelos pueden generar configuración OBS.');
                } else {
                    throw new Error(`Error del servidor (${response.status}): ${errorText}`);
                }
            }
            
            const config = await response.json();
            
            this.streamKey = config.stream_key;
            this.rtmpUrl = config.rtmp_url;
            this.hlsUrl = config.hls_url;
            
            console.log('✅ Configuración OBS generada:', {
                rtmp_url: this.rtmpUrl,
                stream_key: this.streamKey.substring(0, 8) + '...'
            });
            
            return config;
            
        } catch (error) {
            console.error('❌ Error generando configuración OBS:', error);
            throw error;
        }
    }
    
    /**
     * Mostrar instrucciones de configuración OBS
     */
    showOBSInstructions(config) {
        const instructionsContainer = document.getElementById('obs-instructions');
        if (!instructionsContainer) return;
        
        instructionsContainer.innerHTML = `
            <div class="obs-config-card">
                <h3><i class="fas fa-broadcast-tower"></i> Configuración OBS Studio</h3>
                
                <div class="config-step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h4>Configurar Servidor RTMP</h4>
                        <div class="config-field">
                            <label>Servidor:</label>
                            <div class="config-value">
                                <code>${config.rtmp_url}</code>
                                <button onclick="copyToClipboard('${config.rtmp_url}')" class="btn-copy">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                        <div class="config-field">
                            <label>Clave de Stream:</label>
                            <div class="config-value">
                                <code>${config.stream_key}</code>
                                <button onclick="copyToClipboard('${config.stream_key}')" class="btn-copy">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="config-step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h4>Configuración Recomendada</h4>
                        <ul class="config-list">
                            <li><strong>Resolución:</strong> 1280x720 (720p)</li>
                            <li><strong>FPS:</strong> 30</li>
                            <li><strong>Bitrate:</strong> 2500 kbps</li>
                            <li><strong>Encoder:</strong> x264</li>
                            <li><strong>Audio:</strong> 128 kbps</li>
                        </ul>
                    </div>
                </div>
                
                <div class="config-step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h4>Iniciar Transmisión</h4>
                        <p>En OBS Studio, haz clic en <strong>"Iniciar transmisión"</strong></p>
                        <div class="connection-status" id="connection-status">
                            <i class="fas fa-circle" style="color: #ffc107;"></i>
                            Esperando conexión OBS...
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    // ============ VERIFICACIÓN DE CONEXIÓN ============
    
    /**
     * Verificar conexión OBS via RTMP stats
     */
    async checkOBSConnection(streamId) {
        try {
            // Verificar si hay streams activos en el servidor RTMP
            const response = await fetch('http://127.0.0.1:8080/api/streams');
            if (!response.ok) return false;
            
            const streams = await response.json();
            
            // Buscar stream activo con nuestro stream key
            const activeStreams = Object.keys(streams);
            return activeStreams.length > 0;
            
        } catch (error) {
            console.error('Error verificando conexión OBS:', error);
            return false;
        }
    }
    
    /**
     * Iniciar monitoreo de conexión
     */
    startConnectionMonitoring(streamId) {
        console.log('👀 Iniciando monitoreo de conexión OBS...');
        
        this.connectionCheckInterval = setInterval(async () => {
            const isConnected = await this.checkOBSConnection(streamId);
            
            if (isConnected && !this.isConnected) {
                this.onOBSConnected(streamId);
            } else if (!isConnected && this.isConnected) {
                this.onOBSDisconnected();
            }
            
        }, 3000); // Verificar cada 3 segundos
    }
    
    /**
     * OBS conectado
     */
    onOBSConnected(streamId) {
        this.isConnected = true;
        console.log('✅ OBS conectado y transmitiendo');
        
        // Actualizar estado visual
        const statusElement = document.getElementById('connection-status');
        if (statusElement) {
            statusElement.innerHTML = `
                <i class="fas fa-circle" style="color: #28a745;"></i>
                OBS conectado y transmitiendo
            `;
        }
        
        // Mostrar botón para ir a vista de transmisión
        this.showGoLiveButton(streamId);
        
        // Notificar éxito
        if (window.showNotification) {
            window.showNotification('🎉 OBS conectado exitosamente', 'success');
        }
    }
    
    /**
     * OBS desconectado
     */
    onOBSDisconnected() {
        this.isConnected = false;
        console.log('❌ OBS desconectado');
        
        const statusElement = document.getElementById('connection-status');
        if (statusElement) {
            statusElement.innerHTML = `
                <i class="fas fa-circle" style="color: #dc3545;"></i>
                OBS desconectado
            `;
        }
    }
    
    /**
     * Mostrar botón para ir en vivo
     */
    showGoLiveButton(streamId) {
        const container = document.getElementById('go-live-container');
        if (!container) return;
        
        container.innerHTML = `
            <div class="go-live-card">
                <h3><i class="fas fa-play-circle"></i> ¡Listo para transmitir!</h3>
                <p>OBS está conectado y funcionando correctamente.</p>
                <a href="/model/streams/${streamId}/live" class="btn-go-live">
                    <i class="fas fa-broadcast-tower"></i>
                    Ir a Transmisión en Vivo
                </a>
            </div>
        `;
    }
    
    // ============ REPRODUCTOR HLS ============
    
    /**
     * Inicializar reproductor HLS para viewers
     */
    async initHLSPlayer(videoElement, hlsUrl) {
        try {
            console.log('🎥 Inicializando reproductor HLS:', hlsUrl);
            
            if (Hls.isSupported()) {
                this.hlsPlayer = new Hls({
                    enableWorker: true,
                    lowLatencyMode: true,
                    liveSyncDurationCount: 2,
                    liveMaxLatencyDurationCount: 4,
                    maxBufferLength: 3,
                    maxMaxBufferLength: 6,
                    backBufferLength: 10,
                    highBufferWatchdogPeriod: 1,
                });
                
                this.hlsPlayer.loadSource(hlsUrl);
                this.hlsPlayer.attachMedia(videoElement);
                
                this.hlsPlayer.on(Hls.Events.MANIFEST_PARSED, () => {
                    console.log('✅ HLS manifest cargado');
                    videoElement.play().catch(e => console.log('Autoplay prevented'));
                });
                
                this.hlsPlayer.on(Hls.Events.ERROR, (event, data) => {
                    console.error('❌ Error HLS:', data);
                });
                
            } else if (videoElement.canPlayType('application/vnd.apple.mpegurl')) {
                // Safari nativo
                videoElement.src = hlsUrl;
                videoElement.addEventListener('loadedmetadata', () => {
                    videoElement.play().catch(e => console.log('Autoplay prevented'));
                });
            }
            
        } catch (error) {
            console.error('❌ Error inicializando HLS:', error);
        }
    }
    
    // ============ UTILIDADES ============
    
    /**
     * Detener monitoreo
     */
    stopMonitoring() {
        if (this.connectionCheckInterval) {
            clearInterval(this.connectionCheckInterval);
            this.connectionCheckInterval = null;
        }
    }
    
    /**
     * Limpiar recursos
     */
    cleanup() {
        this.stopMonitoring();
        
        if (this.hlsPlayer) {
            this.hlsPlayer.destroy();
            this.hlsPlayer = null;
        }
    }
}

// Utilidad para copiar al portapapeles
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        if (window.showNotification) {
            window.showNotification('📋 Copiado al portapapeles', 'success');
        }
    }).catch(err => {
        console.error('Error copiando:', err);
    });
}

// Hacer disponible globalmente
window.OBSStreamingManager = OBSStreamingManager;
console.log('🚀 OBS Streaming Manager cargado y listo');
