<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $stream->title }} - Lustonex</title>

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Raleway:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    
    <script src="{{ asset('js/webrtc-ll.js') }}?v={{ filemtime(public_path('js/webrtc-ll.js')) }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>

    
    <link rel="stylesheet" href="{{ asset('css/premium-design.css') }}">

    @auth
        <script type="application/json" id="stream-broadcast-config">
            @json([
                'streamId' => $stream->id,
                'userId' => auth()->id(),
                'pollUrl' => route('streams.chat.poll', $stream),
                'lastMessageId' => $chatMessages->max('id') ?? 0,
            ])
        </script>
    @endauth

    <style>
        @if(request('mode') === 'moderation')
            .stream-title-section,
            .tips-section,
            .chat-tabs,
            .stream-background,
            .live-indicator,
            .viewer-count,
            .no-video-message,
            .stream-info-overlay,
            .video-overlay {
                display: none !important;
            }

            .video-container {
                border: none !important;
                box-shadow: none !important;
                background: transparent !important;
                aspect-ratio: auto !important;
                height: 100% !important;
                width: 100% !important;
                max-width: none !important;
                border-radius: 0 !important;
            }

            .video-player {
                /*   object-fit: contain !important; */
            }

            .chat-sidebar {
                display: none !important;
            }

            .video-section {
                padding: 0 !important;
                flex: 1 !important;
                width: 100vw !important;
                height: 100vh !important;
            }

            .stream-viewer-container {
                min-height: 0 !important;
                height: 100vh !important;
                overflow: hidden !important;
            }

            .stream-content {
                height: 100vh !important;
                display: block !important;
            }

            /* Responsive tweaks for embed */
            @media (max-width: 1024px) {
                .chat-sidebar {
                    width: 300px !important;
                    max-height: none !important;
                }

                .stream-content {
                    flex-direction: row !important;
                }
            }

        @endif body {
            margin: 0;
            padding: 0;
            font-family: 'Raleway', sans-serif;
            background: var(--color-negro-azabache);
            color: var(--color-blanco-puro);
            overflow-x: hidden;
        }

        .stream-viewer-container {
            position: relative;
            min-height: 100vh;
            display: flex;
            background: var(--color-negro-azabache);
        }

        .stream-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('{{ $stream->user->profile->cover_image_url }}');
            background-size: cover;
            background-position: center;
            filter: blur(20px) brightness(0.3);
            z-index: 1;
        }

        .stream-content {
            position: relative;
            z-index: 2;
            display: flex;
            width: 100%;
            height: 100vh;
        }

        .video-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            position: relative;
        }

        .video-container {
            position: relative;
            width: 100%;
            max-width: 1200px;
            aspect-ratio: 16/9;
            background: rgba(0, 0, 0, 0.8);
            border-radius: 20px;
            overflow: hidden;
            border: 2px solid rgba(212, 175, 55, 0.3);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }

        .video-player {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg,
                    rgba(0, 0, 0, 0.1) 0%,
                    rgba(212, 175, 55, 0.1) 50%,
                    rgba(0, 0, 0, 0.1) 100%);
            pointer-events: none;
        }

        .stream-info-overlay {
            position: absolute;
            top: 1.5rem;
            left: 1.5rem;
            right: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .live-indicator {
            background: rgba(220, 53, 69, 0.9);
            backdrop-filter: blur(10px);
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: white;
            font-family: var(--font-titles);
            font-weight: 600;
            box-shadow: 0 10px 30px rgba(220, 53, 69, 0.3);
        }

        .live-pulse {
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.7);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 10px rgba(255, 255, 255, 0);
            }

            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
            }
        }

        .viewer-count {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: white;
            font-family: var(--font-titles);
            font-weight: 500;
        }

        .no-video-message {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            background: rgba(0, 0, 0, 0.7);
        }

        .no-video-icon {
            font-size: 4rem;
            color: var(--color-oro-sensual);
            margin-bottom: 1rem;
        }

        .stream-title-section {
            position: absolute;
            bottom: 2rem;
            left: 2rem;
            right: 2rem;
            background: rgba(31, 31, 35, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 16px;
            padding: 1.5rem;
        }

        .stream-title {
            font-family: var(--font-titles);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-blanco-puro);
            margin-bottom: 0.5rem;
        }

        .stream-description {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 1rem;
        }

        .model-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .model-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid var(--color-oro-sensual);
            object-fit: cover;
        }

        .model-details h3 {
            font-family: var(--font-titles);
            font-weight: 600;
            color: var(--color-oro-sensual);
            margin-bottom: 0.25rem;
        }

        .model-stats {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .chat-sidebar {
            width: 400px;
            background: rgba(31, 31, 35, 0.98);
            backdrop-filter: blur(20px);
            border-left: 1px solid rgba(212, 175, 55, 0.2);
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .chat-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(212, 175, 55, 0.1);
        }

        .chat-tabs {
            display: flex;
            gap: 0.5rem;
        }

        .chat-tab {
            flex: 1;
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            font-family: var(--font-titles);
            font-weight: 500;
        }

        .chat-tab.active {
            background: linear-gradient(135deg, var(--color-oro-sensual), #f4e37d);
            color: var(--color-negro-azabache);
            border-color: var(--color-oro-sensual);
        }

        .chat-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .chat-messages {
            flex: 1;
            padding: 1rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .chat-message {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 1rem;
            border-left: 3px solid var(--color-oro-sensual);
            animation: slideInRight 0.3s ease;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .chat-message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .chat-username {
            font-family: var(--font-titles);
            font-weight: 600;
            color: var(--color-oro-sensual);
            font-size: 0.9rem;
        }

        .chat-time {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.8rem;
        }

        .chat-text {
            color: var(--color-blanco-puro);
            line-height: 1.4;
            word-wrap: break-word;
        }

        .chat-input-section {
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.3);
        }

        .emoji-picker {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .emoji-btn {
            padding: 0.5rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.2rem;
        }

        .emoji-btn:hover {
            background: rgba(212, 175, 55, 0.2);
            transform: scale(1.1);
        }

        .chat-input-container {
            display: flex;
            gap: 0.5rem;
        }

        .chat-input {
            flex: 1;
            padding: 1rem;
            background: rgba(11, 11, 13, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: var(--color-blanco-puro);
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .chat-input:focus {
            outline: none;
            border-color: var(--color-oro-sensual);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        }

        .chat-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .send-btn {
            padding: 1rem;
            background: linear-gradient(135deg, var(--color-oro-sensual), #f4e37d);
            color: var(--color-negro-azabache);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .send-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.4);
        }

        .tips-section {
            padding: 1rem;
            display: none;
        }

        .tips-section.active {
            display: block;
        }

        .token-selector {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .token-option {
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .token-option:hover {
            border-color: var(--color-oro-sensual);
            background: rgba(212, 175, 55, 0.1);
        }

        .token-option.selected {
            border-color: var(--color-oro-sensual);
            background: rgba(212, 175, 55, 0.2);
        }

        .token-amount {
            font-family: var(--font-titles);
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--color-oro-sensual);
            margin-bottom: 0.25rem;
        }

        .token-label {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .tip-message-input {
            width: 100%;
            padding: 1rem;
            background: rgba(11, 11, 13, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: var(--color-blanco-puro);
            margin-bottom: 1rem;
            resize: vertical;
            min-height: 80px;
        }

        .tip-message-input:focus {
            outline: none;
            border-color: var(--color-oro-sensual);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        }

        .send-tip-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border: none;
            border-radius: 12px;
            font-family: var(--font-titles);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .send-tip-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(40, 167, 69, 0.4);
        }

        .send-tip-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .tips-list {
            max-height: 300px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .tip-item {
            background: rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.3);
            border-radius: 12px;
            padding: 1rem;
            animation: slideInRight 0.3s ease;
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
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .tip-message {
            color: rgba(40, 167, 69, 0.9);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            font-style: italic;
        }

        .tip-time {
            color: rgba(40, 167, 69, 0.7);
            font-size: 0.8rem;
        }

        .tip-notification {
            position: fixed;
            top: 2rem;
            right: 2rem;
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 1.5rem;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(40, 167, 69, 0.3);
            z-index: 1000;
            animation: tipNotification 0.5s ease;
            max-width: 300px;
        }

        @keyframes tipNotification {
            from {
                opacity: 0;
                transform: translateX(100px) scale(0.8);
            }

            to {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }

        .login-prompt {
            text-align: center;
            padding: 2rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .login-btn {
            background: linear-gradient(135deg, var(--color-oro-sensual), #f4e37d);
            color: var(--color-negro-azabache);
            padding: 1rem 2rem;
            border: none;
            border-radius: 12px;
            font-family: var(--font-titles);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(212, 175, 55, 0.4);
            color: var(--color-negro-azabache);
        }

        @media (max-width: 1024px) {
            .stream-content {
                flex-direction: column;
                height: auto;
            }

            .chat-sidebar {
                width: 100%;
                max-height: 50vh;
            }

            .video-section {
                padding: 1rem;
            }

            .stream-title-section {
                position: static;
                margin-top: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="stream-viewer-container">
        
        <div class="stream-background"></div>

        <div class="stream-content">
            
            <div class="video-section">
                <div class="video-container">
                    <video id="remoteVideo" autoplay muted playsinline class="video-player">
                    </video>

                    
                    <div class="video-overlay"></div>

                    
                    <div class="stream-info-overlay">
                        <div class="live-indicator">
                            <div class="live-pulse"></div>
                            <i class="fas fa-broadcast-tower"></i>
                            {{ __('streams.live_badge') }}
                        </div>

                        <div class="viewer-count">
                            <i class="fas fa-eye"></i>
                            <span id="viewer-count">{{ $stream->viewers_count }}</span> {{ __('streams.viewers', ['count' => '']) }}
                        </div>
                    </div>

                    
                    <div id="no-video-message" class="no-video-message">
                        <div class="no-video-icon">
                            <i class="fas fa-broadcast-tower"></i>
                        </div>
                        <h2 style="font-family: var(--font-titles); font-size: 1.5rem; margin-bottom: 0.5rem;">
                            {{ __('streams.is_live', ['name' => $stream->user->name]) }}
                        </h2>
                        <p style="opacity: 0.8;">{{ __('streams.connecting') }}</p>
                    </div>
                </div>

                
                <div class="stream-title-section">
                    <h1 class="stream-title">{{ $stream->title }}</h1>
                    @if($stream->description)
                        <p class="stream-description">{{ $stream->description }}</p>
                    @endif

                    <div class="model-info">
                        <img src="{{ $stream->user->profile->avatar_url }}"
                            alt="{{ $stream->user->name }}" class="model-avatar"
                            onerror="this.onerror=null;this.src='{{ asset('images/placeholder-avatar.svg') }}'">
                        <div class="model-details">
                            <h3>{{ $stream->user->name }}</h3>
                            <div class="model-stats">
                                <i class="fas fa-users"></i>
                                {{ __('streams.subscribers', ['count' => $stream->user->subscriptionsAsModel->count()]) }}
                                <span style="margin-left: 1rem;">
                                    <i class="fas fa-clock"></i>
                                    {{ __('streams.started_at', ['date' => $stream->started_at->diffForHumans()]) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="chat-sidebar">
                
                <div class="chat-header">
                    <div class="chat-tabs">
                        <button class="chat-tab active" data-tab="chat">
                            <i class="fas fa-comments"></i>
                            {{ __('streams.chat') }}
                        </button>
                        <button class="chat-tab" data-tab="tips">
                            <i class="fas fa-coins"></i>
                            {{ __('streams.tokens') }}
                        </button>
                    </div>
                </div>

                
                <div class="chat-content">
                    
                    <div id="chat-section" class="chat-messages">
                        @foreach($chatMessages as $message)
                            <div class="chat-message" data-message-id="{{ $message->id }}">
                                <div class="chat-message-header">
                                    <span class="chat-username">{{ $message->user->name }}</span>
                                    <span class="chat-time">{{ $message->created_at->format('H:i') }}</span>
                                </div>
                                <div class="chat-text">{{ $message->message }}</div>
                            </div>
                        @endforeach
                    </div>

                    
                    <div id="tips-section" class="tips-section">
                        @auth
                            
                            <div class="token-selector">
                                <div class="token-option" data-tokens="10">
                                    <div class="token-amount">10</div>
                                    <div class="token-label">{{ __('streams.tokens') }}</div>
                                </div>
                                <div class="token-option" data-tokens="25">
                                    <div class="token-amount">25</div>
                                    <div class="token-label">{{ __('streams.tokens') }}</div>
                                </div>
                                <div class="token-option" data-tokens="50">
                                    <div class="token-amount">50</div>
                                    <div class="token-label">{{ __('streams.tokens') }}</div>
                                </div>
                                <div class="token-option" data-tokens="100">
                                    <div class="token-amount">100</div>
                                    <div class="token-label">{{ __('streams.tokens') }}</div>
                                </div>
                                <div class="token-option" data-tokens="250">
                                    <div class="token-amount">250</div>
                                    <div class="token-label">{{ __('streams.tokens') }}</div>
                                </div>
                                <div class="token-option" data-tokens="500">
                                    <div class="token-amount">500</div>
                                    <div class="token-label">{{ __('streams.tokens') }}</div>
                                </div>
                            </div>

                            
                            <textarea id="tip-message" class="tip-message-input"
                                placeholder="{{ __('streams.message_placeholder', ['name' => $stream->user->name]) }}"></textarea>

                            
                            <button id="send-tip-btn" class="send-tip-btn" disabled>
                                <i class="fas fa-coins"></i>
                                {{ __('streams.send_tokens') }}
                            </button>
                        @else
                            <div class="login-prompt">
                                <i class="fas fa-coins"
                                    style="font-size: 3rem; color: var(--color-oro-sensual); margin-bottom: 1rem;"></i>
                                <h3 style="font-family: var(--font-titles); margin-bottom: 1rem;">{{ __('streams.send_tokens') }}</h3>
                                <p>{{ __('streams.login_prompt', ['name' => $stream->user->name]) }}</p>
                                <a href="{{ route('login') }}" class="login-btn">
                                    <i class="fas fa-sign-in-alt"></i>
                                    {{ __('streams.login_btn') }}
                                </a>
                            </div>
                        @endauth

                        
                        <div class="tips-list" style="margin-top: 1rem;">
                            @foreach($stream->tips()->with('fan')->latest()->take(10)->get() as $tip)
                                <div class="tip-item">
                                    <div class="tip-header">
                                        <span class="tip-username">{{ $tip->fan->name }}</span>
                                        <span class="tip-amount">
                                            <i class="fas fa-coins"></i>
                                            {{ $tip->amount }}
                                        </span>
                                    </div>
                                    @if($tip->message)
                                        <div class="tip-message">{{ $tip->message }}</div>
                                    @endif
                                    <div class="tip-time">{{ $tip->created_at->diffForHumans() }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                
                @auth
                    <div class="chat-input-section">
                        
                        <div class="emoji-picker">
                            <button class="emoji-btn" data-emoji="😍">😍</button>
                            <button class="emoji-btn" data-emoji="🔥">🔥</button>
                            <button class="emoji-btn" data-emoji="💖">💖</button>
                            <button class="emoji-btn" data-emoji="👏">👏</button>
                            <button class="emoji-btn" data-emoji="💯">💯</button>
                            <button class="emoji-btn" data-emoji="🎉">🎉</button>
                            <button class="emoji-btn" data-emoji="💋">💋</button>
                            <button class="emoji-btn" data-emoji="⭐">⭐</button>
                        </div>

                        
                        <form id="chat-form" class="chat-input-container">
                            @csrf
                            <input type="text" id="chat-input" name="message" class="chat-input"
                                placeholder="{{ __('streams.chat_placeholder', ['name' => $stream->user->name]) }}" maxlength="500" required>
                            <button type="submit" class="send-btn">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="login-prompt">
                        <p>{{ __('streams.login_prompt_chat') }}</p>
                        <a href="{{ route('login') }}" class="login-btn">
                            <i class="fas fa-sign-in-alt"></i>
                            {{ __('streams.login_btn') }}
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    
    <script>
        let selectedTokens = 0;

        // Tab functionality
        document.querySelectorAll('.chat-tab').forEach(button => {
            button.addEventListener('click', function () {
                const tabName = this.dataset.tab;

                // Remove active class from all buttons
                document.querySelectorAll('.chat-tab').forEach(btn => {
                    btn.classList.remove('active');
                });

                // Add active class to clicked button
                this.classList.add('active');

                // Show/hide sections
                if (tabName === 'chat') {
                    document.getElementById('chat-section').style.display = 'flex';
                    document.getElementById('tips-section').classList.remove('active');
                } else {
                    document.getElementById('chat-section').style.display = 'none';
                    document.getElementById('tips-section').classList.add('active');
                }
            });
        });

        // Token selection
        document.querySelectorAll('.token-option').forEach(option => {
            option.addEventListener('click', function () {
                // Remove selected class from all options
                document.querySelectorAll('.token-option').forEach(opt => {
                    opt.classList.remove('selected');
                });

                // Add selected class to clicked option
                this.classList.add('selected');
                selectedTokens = parseInt(this.dataset.tokens);

                // Enable send button
                const sendBtn = document.getElementById('send-tip-btn');
                if (sendBtn) {
                    sendBtn.disabled = false;
                    sendBtn.innerHTML = `<i class="fas fa-coins"></i> {{ __('streams.send_btn') }} ${selectedTokens} {{ __('streams.tokens') }}`;
                }
            });
        });

        // Emoji functionality
        document.querySelectorAll('.emoji-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const emoji = this.dataset.emoji;
                const chatInput = document.getElementById('chat-input');
                if (chatInput) {
                    chatInput.value += emoji;
                    chatInput.focus();
                }

                // Animate emoji
                this.style.transform = 'scale(1.3)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 200);
            });
        });

        // Chat form submission
        const chatForm = document.getElementById('chat-form');
        if (chatForm) {
            chatForm.addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);
                const messageInput = document.getElementById('chat-input');
                const message = messageInput.value.trim();

                if (!message) return;

                fetch('{{ route("streams.chat", $stream) }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.message) {
                            messageInput.value = '';
                            const m = data.message;
                            addChatMessage({
                                id: m.id,
                                user: m.user ? { name: m.user.name } : { name: '' },
                                message: m.message,
                                created_at: m.created_at,
                            });
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        }

        // Tip form submission
        const sendTipBtn = document.getElementById('send-tip-btn');
        if (sendTipBtn) {
            sendTipBtn.addEventListener('click', function () {
                if (selectedTokens === 0) {
                    alert('{{ __('streams.select_tokens_alert') }}');
                    return;
                }

                const message = document.getElementById('tip-message').value;
                const formData = new FormData();
                formData.append('amount', selectedTokens);
                formData.append('message', message);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                // Disable button during request
                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __('streams.sending') }}';

                fetch('{{ route("streams.tip", $stream) }}', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reset form
                            document.getElementById('tip-message').value = '';
                            document.querySelectorAll('.token-option').forEach(opt => {
                                opt.classList.remove('selected');
                            });
                            selectedTokens = 0;
                            this.disabled = true;
                            this.innerHTML = '<i class="fas fa-coins"></i> {{ __('streams.send_tokens') }}';

                            // Show notification
                            showTipNotification({
                                fan: { name: '{{ auth()->user()->name ?? __("Tú") }}' },
                                amount: selectedTokens,
                                message: message
                            });
                        } else {
                            alert('Error al enviar tokens: ' + (data.message || 'Error desconocido'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al enviar tokens');
                    })
                    .finally(() => {
                        this.disabled = false;
                        this.innerHTML = '<i class="fas fa-coins"></i> {{ __('streams.send_tokens') }}';
                    });
            });
        }

        // Stream connection simulation
        document.addEventListener('DOMContentLoaded', function () {
            connectToStream();
        });

        function connectToStream() {
            const remoteVideo = document.getElementById('remoteVideo');
            const noVideoMessage = document.getElementById('no-video-message');

            // Hide loading message
            if (noVideoMessage) {
                noVideoMessage.style.display = 'none';
            }

            const streamUrl = '{{ asset("hls/live/" . $stream->user->profile->stream_key . "/index.m3u8") }}';
            const streamId = {{ $stream->id }};
            let hls = null;
            let hlsStarted = false;

            const startHlsFallback = () => {
                if (hlsStarted) return;
                hlsStarted = true;
                if (Hls.isSupported()) {
                    hls = new Hls({
                        enableWorker: true,
                        lowLatencyMode: true,
                        liveSyncDurationCount: 2,
                        liveMaxLatencyDurationCount: 4,
                        maxBufferLength: 3,
                        maxMaxBufferLength: 6,
                        backBufferLength: 10,
                        highBufferWatchdogPeriod: 1,
                    });
                    hls.loadSource(streamUrl);
                    hls.attachMedia(remoteVideo);
                    hls.on(Hls.Events.MANIFEST_PARSED, function () {
                        remoteVideo.play().catch(e => console.log("Autoplay error:", e));
                    });
                    hls.on(Hls.Events.ERROR, function (event, data) {
                        console.error('HLS error:', data);
                        if (data.fatal) {
                            switch (data.type) {
                                case Hls.ErrorTypes.NETWORK_ERROR:
                                    hls.startLoad();
                                    break;
                                case Hls.ErrorTypes.MEDIA_ERROR:
                                    hls.recoverMediaError();
                                    break;
                                default:
                                    hls.destroy();
                                    break;
                            }
                        }
                    });
                } else if (remoteVideo.canPlayType('application/vnd.apple.mpegurl')) {
                    remoteVideo.src = streamUrl;
                    remoteVideo.addEventListener('loadedmetadata', function () {
                        remoteVideo.play().catch(e => console.log("Autoplay error:", e));
                    });
                }
            };

            if (window.WebRTCLowLatency) {
                const webrtc = new WebRTCLowLatency();
                webrtc.joinBroadcast(streamId, remoteVideo).catch(() => startHlsFallback());
                window.addEventListener('webrtc-peer-connected', () => {
                    if (hls) {
                        hls.destroy();
                        hls = null;
                    }
                    remoteVideo.muted = true;
                    remoteVideo.play().catch(() => {});
                }, { once: true });
                window.addEventListener('webrtc-video-ready', () => {
                    remoteVideo.muted = true;
                    remoteVideo.play().catch(() => {});
                }, { once: true });
                setTimeout(() => {
                    if (!remoteVideo.srcObject) {
                        startHlsFallback();
                    }
                }, 8000);
            } else {
                startHlsFallback();
            }

            console.log('{{ __('streams.is_live', ['name' => $stream->user->name]) }}');

            // Update viewer count periodically
            setInterval(updateViewerCount, 10000);
        }

        function updateViewerCount() {
            const viewerCount = document.getElementById('viewer-count');
            if (!viewerCount) return;
            fetch('{{ url('/api/stream/' . $stream->id . '/info') }}', {
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin',
            })
                .then((r) => (r.ok ? r.json() : Promise.reject()))
                .then((data) => {
                    if (data && data.viewers_count != null) {
                        viewerCount.textContent = data.viewers_count;
                    }
                })
                .catch(() => {});
        }

        function escapeHtml(text) {
            if (text === null || text === undefined) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function formatChatTime(createdAt) {
            const d = createdAt ? new Date(createdAt) : new Date();
            if (Number.isNaN(d.getTime())) {
                return new Date().toLocaleTimeString(document.documentElement.lang || undefined, { hour: '2-digit', minute: '2-digit' });
            }
            return d.toLocaleTimeString(document.documentElement.lang || undefined, { hour: '2-digit', minute: '2-digit' });
        }

        function addChatMessage(message) {
            const chatSection = document.getElementById('chat-section');
            if (!chatSection) return;

            const mid = message.id != null && message.id !== '' ? String(message.id) : null;
            if (mid && chatSection.querySelector('.chat-message[data-message-id="' + mid + '"]')) {
                return;
            }

            const messageDiv = document.createElement('div');
            messageDiv.className = 'chat-message';
            if (mid) {
                messageDiv.setAttribute('data-message-id', mid);
            }
            const userName = message.user && message.user.name ? message.user.name : '';
            const body = message.message != null ? String(message.message) : '';
            messageDiv.innerHTML =
                '<div class="chat-message-header">' +
                '<span class="chat-username">' + escapeHtml(userName) + '</span>' +
                '<span class="chat-time">' + escapeHtml(formatChatTime(message.created_at)) + '</span>' +
                '</div>' +
                '<div class="chat-text">' + escapeHtml(body) + '</div>';

            chatSection.appendChild(messageDiv);
            chatSection.scrollTop = chatSection.scrollHeight;
        }

        window.appendStreamChatFromBroadcast = function (payload) {
            if (!payload || payload.id == null) return;
            addChatMessage({
                id: payload.id,
                user: payload.user || { name: '' },
                message: payload.message,
                created_at: payload.created_at,
            });
        };

        function showTipNotification(tip) {
            const notification = document.createElement('div');
            notification.className = 'tip-notification';
            notification.innerHTML = `
                <div style="font-family: var(--font-titles); font-weight: 700; margin-bottom: 0.5rem;">
                    <i class="fas fa-coins"></i> {{ __('streams.tokens_sent') }}
                </div>
                <div style="margin-bottom: 0.5rem;">
                    ${tip.fan.name}: ${tip.amount} tokens
                </div>
                ${tip.message ? `<div style="font-style: italic; opacity: 0.9;">"${tip.message}"</div>` : ''}
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 5000);
        }

        // Auto-scroll chat to bottom
        function scrollChatToBottom() {
            const chatSection = document.getElementById('chat-section');
            if (chatSection) {
                chatSection.scrollTop = chatSection.scrollHeight;
            }
        }

        // Initialize
        scrollChatToBottom();
    </script>

    @vite(['resources/js/stream-viewer.js'])
</body>

</html>