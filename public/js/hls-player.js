/**
 * Reproductor HLS para Lustonex
 * Reemplaza el sistema WebRTC con streaming RTMP + HLS
 */
class HLSStreamingManager {
    constructor() {
        this.hls = null;
        this.video = null;
        this.streamKey = null;
        this.isStreaming = false;
        this.retryCount = 0;
        this.maxRetries = 5;
        this.retryDelay = 2000;

        // Configuración
        this.config = {
            debug: false,
            enableWorker: true,
            lowLatencyMode: true,

            // LL-HLS: Tuned for 2-4s latency with 1s segments
            liveSyncDurationCount: 2,         // Sync 2 segments behind live edge
            liveMaxLatencyDurationCount: 4,   // Max 4 segments behind before catch-up
            maxBufferLength: 3,               // Max 3s forward buffer
            maxMaxBufferLength: 6,            // Absolute max 6s buffer
            backBufferLength: 10,             // Keep 10s back buffer
            liveDurationInfinity: true,
            highBufferWatchdogPeriod: 1,      // Check buffer every 1s

            // Network tuning for fast segment loading
            manifestLoadingTimeOut: 5000,
            manifestLoadingMaxRetry: 3,
            levelLoadingTimeOut: 5000,
            fragLoadingTimeOut: 5000,
            fragLoadingMaxRetry: 3,
        };

        this.loadHLSLibrary();
    }

    // Cargar librería HLS.js
    async loadHLSLibrary() {
        if (window.Hls) {
            console.log('HLS.js ya está cargado');
            return;
        }

        try {
            // Cargar HLS.js desde CDN
            await this.loadScript('https://cdn.jsdelivr.net/npm/hls.js@latest');
            console.log('HLS.js cargado exitosamente');
        } catch (error) {
            console.error('Error cargando HLS.js:', error);
            throw new Error('No se pudo cargar la librería HLS.js');
        }
    }

    // Cargar script dinámicamente
    loadScript(src) {
        return new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = src;
            script.onload = resolve;
            script.onerror = reject;
            document.head.appendChild(script);
        });
    }

    // Iniciar streaming como modelo (mostrar instrucciones OBS)
    async startStreaming(streamId, videoElement) {
        try {
            this.streamId = streamId;

            console.log('Generando clave de stream para RTMP...');

            // Generar clave de stream
            const response = await fetch('/api/rtmp/generate-key', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            if (!response.ok) {
                throw new Error('Error generando clave de stream');
            }

            const streamData = await response.json();
            this.streamKey = streamData.stream_key;

            // Mostrar información de streaming
            this.showStreamingInstructions(streamData, videoElement);

            // Iniciar monitoreo del stream
            this.startStreamMonitoring();

            console.log('Stream configurado para RTMP:', streamData);
            return true;

        } catch (error) {
            console.error('Error iniciando streaming RTMP:', error);
            throw error;
        }
    }

    // Mostrar instrucciones de streaming
    showStreamingInstructions(streamData, videoElement) {
        const container = videoElement.parentElement;
        if (!container) return;

        // Limpiar contenido anterior
        container.innerHTML = '';

        // Crear interfaz de instrucciones
        const instructionsHTML = `
            <div class="rtmp-instructions" style="
                background: linear-gradient(135deg, rgba(31, 31, 35, 0.95), rgba(15, 15, 20, 0.98));
                border: 2px solid rgba(212, 175, 55, 0.3);
                border-radius: 16px;
                padding: 2rem;
                text-align: center;
                color: white;
                font-family: 'Poppins', sans-serif;
            ">
                <div style="margin-bottom: 2rem;">
                    <div style="font-size: 3rem; color: #D4AF37; margin-bottom: 1rem;">
                        📡
                    </div>
                    <h2 style="color: #D4AF37; margin-bottom: 0.5rem; font-size: 1.8rem;">
                        Configuración de Streaming
                    </h2>
                    <p style="opacity: 0.8; margin-bottom: 2rem;">
                        Usa OBS Studio o cualquier software de streaming compatible con RTMP
                    </p>
                </div>
                
                <div class="stream-config" style="
                    background: rgba(0, 0, 0, 0.3);
                    border-radius: 12px;
                    padding: 1.5rem;
                    margin-bottom: 2rem;
                    text-align: left;
                ">
                    <div style="margin-bottom: 1rem;">
                        <label style="color: #D4AF37; font-weight: 600; display: block; margin-bottom: 0.5rem;">
                            🌐 Servidor RTMP:
                        </label>
                        <div class="copy-field" style="
                            background: rgba(255, 255, 255, 0.1);
                            border: 1px solid rgba(212, 175, 55, 0.3);
                            border-radius: 8px;
                            padding: 0.75rem;
                            font-family: 'Courier New', monospace;
                            font-size: 0.9rem;
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                        ">
                            <span id="rtmp-server">rtmp://localhost/live</span>
                            <button onclick="copyToClipboard('rtmp-server')" style="
                                background: #D4AF37;
                                border: none;
                                border-radius: 4px;
                                padding: 0.25rem 0.5rem;
                                color: black;
                                font-size: 0.8rem;
                                cursor: pointer;
                            ">Copiar</button>
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 1rem;">
                        <label style="color: #D4AF37; font-weight: 600; display: block; margin-bottom: 0.5rem;">
                            🔑 Clave de Stream:
                        </label>
                        <div class="copy-field" style="
                            background: rgba(255, 255, 255, 0.1);
                            border: 1px solid rgba(212, 175, 55, 0.3);
                            border-radius: 8px;
                            padding: 0.75rem;
                            font-family: 'Courier New', monospace;
                            font-size: 0.9rem;
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                        ">
                            <span id="stream-key">${streamData.stream_key}</span>
                            <button onclick="copyToClipboard('stream-key')" style="
                                background: #D4AF37;
                                border: none;
                                border-radius: 4px;
                                padding: 0.25rem 0.5rem;
                                color: black;
                                font-size: 0.8rem;
                                cursor: pointer;
                            ">Copiar</button>
                        </div>
                    </div>
                </div>
                
                <div class="stream-status" style="
                    background: rgba(220, 53, 69, 0.1);
                    border: 1px solid rgba(220, 53, 69, 0.3);
                    border-radius: 12px;
                    padding: 1rem;
                    margin-bottom: 2rem;
                ">
                    <div id="stream-status-indicator" style="
                        color: #dc3545;
                        font-weight: 600;
                        margin-bottom: 0.5rem;
                    ">
                        ⏳ Esperando conexión...
                    </div>
                    <div style="color: rgba(220, 53, 69, 0.8); font-size: 0.9rem;">
                        Inicia tu stream en OBS para comenzar la transmisión
                    </div>
                </div>
                
                <div class="obs-instructions" style="
                    text-align: left;
                    background: rgba(0, 123, 255, 0.1);
                    border: 1px solid rgba(0, 123, 255, 0.3);
                    border-radius: 12px;
                    padding: 1.5rem;
                ">
                    <h3 style="color: #007bff; margin-bottom: 1rem; text-align: center;">
                        📹 Configuración en OBS Studio
                    </h3>
                    <ol style="color: rgba(255, 255, 255, 0.9); line-height: 1.6;">
                        <li>Abre OBS Studio</li>
                        <li>Ve a <strong>Configuración → Stream</strong></li>
                        <li>Selecciona <strong>Servicio: Personalizado</strong></li>
                        <li>Copia el <strong>Servidor RTMP</strong> de arriba</li>
                        <li>Copia la <strong>Clave de Stream</strong> de arriba</li>
                        <li>Haz clic en <strong>"Iniciar Stream"</strong> en OBS</li>
                    </ol>
                </div>
            </div>
        `;

        container.innerHTML = instructionsHTML;

        // Agregar función de copiar al portapapeles
        window.copyToClipboard = function (elementId) {
            const element = document.getElementById(elementId);
            const text = element.textContent;

            navigator.clipboard.writeText(text).then(() => {
                // Mostrar feedback visual
                const button = element.nextElementSibling;
                const originalText = button.textContent;
                button.textContent = '✓ Copiado';
                button.style.background = '#28a745';

                setTimeout(() => {
                    button.textContent = originalText;
                    button.style.background = '#D4AF37';
                }, 2000);
            }).catch(err => {
                console.error('Error copiando al portapapeles:', err);
            });
        };
    }

    // Monitorear estado del stream
    startStreamMonitoring() {
        const checkInterval = setInterval(async () => {
            try {
                const response = await fetch(`/api/rtmp/stream/${this.streamKey}`);

                if (response.ok) {
                    const streamInfo = await response.json();

                    if (streamInfo.status === 'live') {
                        // Stream está activo, mostrar reproductor
                        this.showLiveStream(streamInfo);
                        clearInterval(checkInterval);
                    }
                } else if (response.status === 404) {
                    // Stream no encontrado o no activo
                    console.log('Stream aún no está activo...');
                }

            } catch (error) {
                console.error('Error verificando estado del stream:', error);
            }
        }, 3000); // Verificar cada 3 segundos

        // Limpiar interval después de 5 minutos si no hay conexión
        setTimeout(() => {
            clearInterval(checkInterval);
        }, 300000);
    }

    // Mostrar stream en vivo
    showLiveStream(streamInfo) {
        const container = document.querySelector('.rtmp-instructions').parentElement;

        container.innerHTML = `
            <div style="position: relative; width: 100%; height: 100%;">
                <video id="hls-video" 
                       controls 
                       autoplay 
                       muted
                       style="width: 100%; height: 100%; background: black; border-radius: 12px;">
                </video>
                
                <div style="
                    position: absolute;
                    top: 20px;
                    left: 20px;
                    background: rgba(220, 53, 69, 0.9);
                    color: white;
                    padding: 0.5rem 1rem;
                    border-radius: 20px;
                    font-weight: 600;
                    font-size: 0.9rem;
                    z-index: 100;
                    animation: pulse 2s infinite;
                ">
                    🔴 EN VIVO
                </div>
                
                <div style="
                    position: absolute;
                    top: 20px;
                    right: 20px;
                    background: rgba(0, 0, 0, 0.7);
                    color: white;
                    padding: 0.5rem 1rem;
                    border-radius: 12px;
                    font-size: 0.9rem;
                ">
                    👁️ <span id="viewer-count">${streamInfo.viewers_count || 0}</span> viewers
                </div>
            </div>
        `;

        // Inicializar reproductor HLS
        this.initHLSPlayer(streamInfo.hls_url);

        // Actualizar estado
        const statusIndicator = document.getElementById('stream-status-indicator');
        if (statusIndicator) {
            statusIndicator.innerHTML = '🔴 Stream activo';
            statusIndicator.style.color = '#28a745';
        }
    }

    // Conectar como viewer
    async connectAsViewer(streamId, videoElement) {
        try {
            console.log('Conectando como viewer al stream HLS:', streamId);

            // Obtener información del stream
            const response = await fetch(`/api/stream/${streamId}/info`);
            if (!response.ok) {
                throw new Error('Stream no encontrado');
            }

            const streamInfo = await response.json();

            if (streamInfo.status !== 'live') {
                throw new Error('Stream no está activo');
            }

            // Inicializar reproductor HLS
            this.video = videoElement;
            await this.initHLSPlayer(streamInfo.hls_url || `/hls/live/${streamInfo.stream_key}/index.m3u8`);

            // Notificar al servidor
            await this.notifyJoinViewer(streamId);

            console.log('Conectado como viewer exitosamente');
            return true;

        } catch (error) {
            console.error('Error conectando como viewer:', error);
            throw error;
        }
    }

    // Inicializar reproductor HLS
    async initHLSPlayer(hlsUrl) {
        if (!window.Hls) {
            await this.loadHLSLibrary();
        }

        const video = this.video || document.getElementById('hls-video');
        if (!video) {
            throw new Error('Elemento de video no encontrado');
        }

        if (Hls.isSupported()) {
            this.hls = new Hls(this.config);

            this.hls.on(Hls.Events.MEDIA_ATTACHED, () => {
                console.log('Video attached to HLS');
            });

            this.hls.on(Hls.Events.MANIFEST_PARSED, (event, data) => {
                console.log('Manifest parsed, found ' + data.levels.length + ' quality levels');
                video.play().catch(e => console.log('Autoplay prevented:', e));
            });

            this.hls.on(Hls.Events.ERROR, (event, data) => {
                console.error('HLS Error:', data);

                if (data.fatal) {
                    switch (data.type) {
                        case Hls.ErrorTypes.NETWORK_ERROR:
                            console.log('Network error, trying to recover...');
                            this.retryConnection();
                            break;
                        case Hls.ErrorTypes.MEDIA_ERROR:
                            console.log('Media error, trying to recover...');
                            this.hls.recoverMediaError();
                            break;
                        default:
                            console.log('Fatal error, destroying HLS instance');
                            this.hls.destroy();
                            break;
                    }
                }
            });

            this.hls.attachMedia(video);
            this.hls.loadSource(hlsUrl);

        } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
            // Safari nativo
            video.src = hlsUrl;
            video.addEventListener('loadedmetadata', () => {
                video.play().catch(e => console.log('Autoplay prevented:', e));
            });
        } else {
            throw new Error('HLS no es compatible con este navegador');
        }
    }

    // Reintentar conexión
    retryConnection() {
        if (this.retryCount < this.maxRetries) {
            this.retryCount++;
            console.log(`Reintentando conexión (${this.retryCount}/${this.maxRetries})...`);

            setTimeout(() => {
                this.hls.startLoad();
            }, this.retryDelay * this.retryCount);
        } else {
            console.error('Máximo número de reintentos alcanzado');
            this.showConnectionError();
        }
    }

    // Mostrar error de conexión
    showConnectionError() {
        const video = this.video || document.getElementById('hls-video');
        if (video && video.parentElement) {
            const errorDiv = document.createElement('div');
            errorDiv.style.cssText = `
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: rgba(220, 53, 69, 0.9);
                color: white;
                padding: 1rem 2rem;
                border-radius: 12px;
                text-align: center;
                z-index: 200;
            `;
            errorDiv.innerHTML = `
                <div style="font-size: 2rem; margin-bottom: 0.5rem;">⚠️</div>
                <div style="font-weight: 600; margin-bottom: 0.5rem;">Error de Conexión</div>
                <div style="font-size: 0.9rem;">No se pudo conectar al stream</div>
            `;

            video.parentElement.appendChild(errorDiv);
        }
    }

    // Detener streaming
    async stopStreaming() {
        try {
            if (this.hls) {
                this.hls.destroy();
                this.hls = null;
            }

            if (this.video) {
                this.video.src = '';
                this.video = null;
            }

            console.log('Streaming HLS detenido');

        } catch (error) {
            console.error('Error deteniendo streaming HLS:', error);
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
            }

        } catch (error) {
            console.error('Error notificando unión como viewer:', error);
        }
    }
}

// Reemplazar el StreamingManager anterior
window.StreamingManager = HLSStreamingManager;
