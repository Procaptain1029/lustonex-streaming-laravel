<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>🔴 EN VIVO - {{ $stream->title }} - Lustonex</title>

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Raleway:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    
    <link rel="stylesheet" href="{{ asset('css/premium-design.css') }}">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Raleway', sans-serif;
            background: var(--color-negro-azabache);
            color: var(--color-blanco-puro);
            overflow-x: hidden;
        }

        .live-container {
            margin-left: 280px;
            transition: all 0.3s ease;
            width: calc(100% - 280px);
            min-height: 100vh;
            position: relative;
            z-index: 10;
            padding-top: 85px;
        }

        .live-container.sidebar-hidden {
            margin-left: 0;
            width: 100%;
        }

        @media (max-width: 1024px) {
            .live-container {
                margin-left: 0;
                width: 100%;
                padding-top: 90px;
            }
        }

        .live-header {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(255, 71, 87, 0.1));
            border: 1px solid rgba(220, 53, 69, 0.3);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .live-pulse {
            display: inline-block;
            width: 12px;
            height: 12px;
            background: #dc3545;
            border-radius: 50%;
            animation: pulse 2s infinite;
            margin-right: 0.5rem;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
            }

            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
            }
        }

        .live-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(31, 31, 35, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
        }

        .stat-value {
            font-family: var(--font-titles);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-blanco-puro);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.8rem;
        }

        .main-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .video-section {
            background: rgba(31, 31, 35, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 16px;
            padding: 1.5rem;
        }

        .video-container {
            position: relative;
            background: var(--color-negro-azabache);
            border-radius: 12px;
            overflow: hidden;
            aspect-ratio: 16/9;
            margin-bottom: 1rem;
        }

        .video-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-overlay {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: rgba(220, 53, 69, 0.9);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .video-controls {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn-control {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-family: var(--font-titles);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .btn-end-stream {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .btn-end-stream:hover {
            background: rgba(220, 53, 69, 0.3);
            transform: translateY(-2px);
        }

        .sidebar-section {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .chat-section,
        .tips-section {
            background: rgba(31, 31, 35, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 16px;
            padding: 1.5rem;
            flex: 1;
        }

        .section-header {
            font-family: var(--font-titles);
            font-size: 1.1rem;
            color: var(--color-oro-sensual);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .chat-messages {
            height: 300px;
            overflow-y: auto;
            background: rgba(11, 11, 13, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .chat-message {
            margin-bottom: 1rem;
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            border-left: 3px solid var(--color-oro-sensual);
        }

        .chat-username {
            font-family: var(--font-titles);
            font-weight: 600;
            color: var(--color-oro-sensual);
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .chat-text {
            color: var(--color-blanco-puro);
            font-size: 0.9rem;
        }

        .tips-container {
            height: 300px;
            overflow-y: auto;
        }

        .tip-item {
            background: rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.3);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .tip-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .tip-username {
            font-family: var(--font-titles);
            font-weight: 600;
            color: #28a745;
        }

        .tip-amount {
            font-family: var(--font-titles);
            font-weight: 700;
            color: #28a745;
            font-size: 1.1rem;
        }

        .tip-message {
            color: rgba(40, 167, 69, 0.9);
            font-size: 0.9rem;
        }

        @media (max-width: 1024px) {
            .main-content {
                grid-template-columns: 1fr;
            }

            .live-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>

<body>
    @include('components.sidebar-premium')
    @include('components.header-unified')

    
    <div class="live-container" id="mainContent">
        <div class="container" style="padding: 2rem;">
            
            <div class="live-header">
                <div
                    style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <h1
                            style="font-family: var(--font-titles); font-size: 1.8rem; color: #dc3545; margin: 0; display: flex; align-items: center;">
                            <span class="live-pulse"></span>
                            <i class="fas fa-broadcast-tower"></i>
                            {{ __('model.streams.live.title') }}: {{ $stream->title }}
                        </h1>
                        <p style="color: rgba(255, 255, 255, 0.8); margin: 0.5rem 0 0 0;">
                            {{ __('model.streams.live.transmit_obs') }}
                        </p>
                    </div>

                    <div>
                        <a href="{{ route('model.streams.show', $stream) }}" class="btn-control"
                            style="background: rgba(255, 255, 255, 0.1); color: var(--color-blanco-puro);">
                            <i class="fas fa-cog"></i>
                            {{ __('model.streams.live.btn_settings') }}
                        </a>
                    </div>
                </div>
            </div>

            
            <div class="live-stats">
                <div class="stat-card">
                    <div class="stat-value" id="viewers-count">{{ $stream->viewers_count }}</div>
                    <div class="stat-label">{{ __('model.streams.live.viewers') }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="tips-count">{{ $stream->tips->count() }}</div>
                    <div class="stat-label">{{ __('model.streams.live.tips') }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="messages-count">{{ $stream->chatMessages->count() }}</div>
                    <div class="stat-label">{{ __('model.streams.live.messages') }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="duration">0m</div>
                    <div class="stat-label">{{ __('model.streams.live.duration') }}</div>
                </div>
            </div>

            
            <div class="main-content">
                
                <div class="video-section">
                    <h3 class="section-header">
                        <i class="fas fa-video"></i>
                        {{ __('model.streams.live.section_your_stream') }}
                    </h3>

                    <div class="video-container">
                        <video id="liveVideo" autoplay muted playsinline controls>
                        </video>
                        <div class="video-overlay">
                            <span class="live-pulse"></span>
                            {{ __('model.streams.live.status_live') }}
                        </div>
                    </div>

                    <div class="video-controls">
                        <button onclick="refreshStream()" class="btn-control"
                            style="background: rgba(13, 110, 253, 0.2); color: #007bff; border: 1px solid rgba(13, 110, 253, 0.3);">
                            <i class="fas fa-sync"></i>
                            {{ __('model.streams.live.btn_refresh') }}
                        </button>

                        <button onclick="confirmEndStream()" class="btn-control btn-end-stream">
                            <i class="fas fa-stop"></i>
                            {{ __('model.streams.live.btn_end') }}
                        </button>
                    </div>
                </div>

                
                <div class="sidebar-section">
                    
                    <div class="chat-section">
                        <h3 class="section-header">
                            <i class="fas fa-comments"></i>
                            {{ __('model.streams.live.section_chat') }}
                        </h3>

                        <div id="chat-messages" class="chat-messages">
                            @foreach($stream->chatMessages()->visible()->with('user')->latest()->take(20)->get()->reverse() as $message)
                                <div class="chat-message" data-message-id="{{ $message->id }}">
                                    <div class="chat-username">{{ $message->user->name }}</div>
                                    <div class="chat-text">{{ $message->message }}</div>
                                </div>
                            @endforeach
                        </div>

                        <p style="color: rgba(255, 255, 255, 0.6); font-size: 0.8rem; margin: 0;">
                            <i class="fas fa-info-circle"></i>
                            {{ __('model.streams.live.hint_chat') }}
                        </p>
                    </div>

                    
                    <div class="tips-section">
                        <h3 class="section-header">
                            <i class="fas fa-dollar-sign"></i>
                            {{ __('model.streams.live.section_tips') }}
                        </h3>

                        <div id="tips-container" class="tips-container">
                            @foreach($stream->tips()->with('fan')->latest()->take(10)->get() as $tip)
                                <div class="tip-item">
                                    <div class="tip-header">
                                        <span class="tip-username">{{ $tip->fan->name }}</span>
                                        <span class="tip-amount">${{ $tip->amount }}</span>
                                    </div>
                                    @if($tip->message)
                                        <div class="tip-message">{{ $tip->message }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <script>
        let hlsPlayer = null;
        let statsInterval = null;
        let startTime = Date.now();

        // Inicializar cuando se carga la página
        document.addEventListener('DOMContentLoaded', function () {
            initLiveStream();
            startStatsUpdates();
        });

        // Función para mostrar mensajes en el reproductor
        function showStreamMessage(title, message, type = 'info') {
            const videoContainer = document.querySelector('.video-container');
            if (!videoContainer) return;

            // Remover mensaje anterior si existe
            const existingMessage = videoContainer.querySelector('.stream-message');
            if (existingMessage) {
                existingMessage.remove();
            }

            // Crear nuevo mensaje
            const messageDiv = document.createElement('div');
            messageDiv.className = 'stream-message';
            messageDiv.innerHTML = `
                <div class="message-content">
                    <h3>${title}</h3>
                    <p>${message}</p>
                    <div class="loading-spinner"></div>
                </div>
            `;

            // Estilos del mensaje
            messageDiv.style.cssText = `
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: rgba(0, 0, 0, 0.9);
                color: white;
                padding: 30px;
                border-radius: 15px;
                text-align: center;
                z-index: 1000;
                border: 2px solid var(--color-dorado);
            `;

            videoContainer.appendChild(messageDiv);
        }

        // Inicializar stream HLS
        async function initLiveStream() {
            try {
                const videoElement = document.getElementById('liveVideo');
                const hlsUrl = '{{ $stream->hls_url }}';

                console.log('🎥 Inicializando stream HLS:', hlsUrl);

                if (Hls.isSupported()) {
                    hlsPlayer = new Hls({
                        enableWorker: true,
                        lowLatencyMode: true,
                        liveSyncDurationCount: 2,
                        liveMaxLatencyDurationCount: 4,
                        maxBufferLength: 3,
                        maxMaxBufferLength: 6,
                        backBufferLength: 10,
                        highBufferWatchdogPeriod: 1,
                    });

                    hlsPlayer.loadSource(hlsUrl);
                    hlsPlayer.attachMedia(videoElement);

                    hlsPlayer.on(Hls.Events.MANIFEST_PARSED, () => {
                        console.log('✅ Stream HLS cargado');
                        videoElement.play().catch(e => console.log('Autoplay prevented'));
                    });

                    hlsPlayer.on(Hls.Events.ERROR, (event, data) => {
                        console.error('❌ Error HLS:', data);

                        // Si es error de parsing del manifest, mostrar mensaje informativo
                        if (data.details === 'manifestParsingError') {
                            showStreamMessage('{{ __('model.streams.live.js_msg_config_title') }}', '{{ __('model.streams.live.js_msg_config_text') }}', 'info');

                            // Reintentar cada 10 segundos
                            setTimeout(() => {
                                console.log('🔄 Reintentando conexión HLS...');
                                hlsPlayer.loadSource(hlsUrl);
                            }, 10000);
                        } else if (data.fatal) {
                            setTimeout(() => {
                                console.log('🔄 Reintentando conexión HLS...');
                                hlsPlayer.loadSource(hlsUrl);
                            }, 5000);
                        }
                    });

                } else if (videoElement.canPlayType('application/vnd.apple.mpegurl')) {
                    // Safari nativo
                    videoElement.src = hlsUrl;
                    videoElement.addEventListener('loadedmetadata', () => {
                        videoElement.play().catch(e => console.log('Autoplay prevented'));
                    });
                }

            } catch (error) {
                console.error('❌ Error inicializando stream:', error);
            }
        }

        // Actualizar estadísticas
        function startStatsUpdates() {
            updateDuration();

            statsInterval = setInterval(() => {
                updateDuration();
                // Aquí puedes agregar más actualizaciones en tiempo real
            }, 1000);
        }

        // Actualizar duración
        function updateDuration() {
            const duration = Math.floor((Date.now() - startTime) / 60000);
            document.getElementById('duration').textContent = duration + 'm';
        }

        // Refrescar stream
        function refreshStream() {
            if (hlsPlayer) {
                hlsPlayer.destroy();
            }
            initLiveStream();
            console.log('🔄 Stream actualizado');
        }

        // Confirmar finalización de stream
        function confirmEndStream() {
            if (confirm('{{ __('model.streams.live.confirm_end') }}')) {
                window.location.href = '{{ route("model.streams.end", $stream) }}';
            }
        }

        // Limpiar al salir
        window.addEventListener('beforeunload', function () {
            if (hlsPlayer) {
                hlsPlayer.destroy();
            }
            if (statsInterval) {
                clearInterval(statsInterval);
            }
        });
    </script>

    
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>

    
    @include('components.sidebar-header-scripts')
</body>

</html>