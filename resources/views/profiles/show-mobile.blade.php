@php
    $layout = 'layouts.public';
    if (auth()->check() && auth()->user()->isAdmin()) {
        $layout = 'layouts.admin';
    }
    $isStreaming = ($model->profile && $model->profile->is_streaming) || ($fanLivePlayback ?? false);
@endphp

@extends($layout)

@section('title', ($model->profile->display_name ?? $model->name) . ' - LIVE')

@section('styles')
    <style>
        :root {
            --imm-magenta: #e91e63;
            --imm-yellow: #ffeb3b;
            --imm-orange: #ff9800;
            --imm-glass: rgba(0, 0, 0, 0.4);
            --imm-glass-border: rgba(255, 255, 255, 0.15);
        }

        /* Fullscreen Wrapper */
        .immersive-enhanced-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100dvh;
            background: #000;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            font-family: 'Inter', -apple-system, sans-serif;
        }

        /* Video Layer */
        .imm-video-container {
            position: absolute;
            inset: 0;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #hlsEnhancedPlayer {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        /* UI Layer Overlay */
        .imm-ui-overlay {
            position: relative;
            z-index: 10;
            height: 100%;
            display: flex;
            flex-direction: column;
            padding: 16px;
            pointer-events: none;
        }

        .imm-ui-content-wrapper {
            height: 100%;
            display: flex;
            flex-direction: column;
            pointer-events: none;
        }

        .imm-ui-overlay * {
            pointer-events: auto;
        }

        .imm-ui-overlay.ui-hidden {
            opacity: 0;
            pointer-events: none;
        }

        .imm-ui-overlay {
            transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Top Bar */
        .imm-top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: env(safe-area-inset-top, 8px);
        }

        .imm-model-card {
            background: transparent;
            padding: 4px 12px 4px 4px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
            border: none;
        }

        .imm-avatar-wrap {
            position: relative;
            width: 40px;
            height: 40px;
        }

        .imm-avatar {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .imm-live-tag {
            position: absolute;
            bottom: -4px;
            left: 50%;
            transform: translateX(-50%);
            background: #ff0000;
            color: #fff;
            font-size: 6px;
            font-weight: 800;
            padding: 1px 4px;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .imm-model-meta h4 {
            color: #fff;
            font-size: 13px;
            margin: 0;
            font-weight: 600;
        }

        .imm-model-meta span {
            color: rgba(255,255,255,0.7);
            font-size: 10px;
            display: block;
        }

        .imm-btn-subscribe {
            background: #d4af37;
            color: #000;
            border: none;
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            margin-left: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .imm-btn-subscribed {
            background: rgba(212, 175, 55, 0.15);
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 20px;
            color: #d4af37;
            padding: 5px 14px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            margin-left: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .imm-btn-exit {
            width: 38px;
            height: 38px;
            background: var(--imm-glass);
            backdrop-filter: blur(10px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            border: 1px solid var(--imm-glass-border);
            font-size: 18px;
            text-decoration: none;
        }

        /* Right Actions Sidebar */
        .imm-right-sidebar {
            position: absolute;
            right: 16px;
            bottom: 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }

        .imm-action-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            color: #fff;
        }

        .imm-action-btn {
            background: none;
            border: none;
            color: #fff;
            font-size: 26px;
            cursor: pointer;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));
            -webkit-tap-highlight-color: transparent;
            outline: none;
            -webkit-appearance: none;
        }

        .imm-action-btn:active {
            opacity: 0.7;
            transition: opacity 0.1s;
        }

        .imm-action-item span {
            font-size: 10px;
            font-weight: 700;
            text-shadow: 0 1px 2px rgba(0,0,0,0.8);
        }

        .imm-btn-gift {
            width: 44px;
            height: 44px;
            background: #d4af37;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: none;
            -webkit-tap-highlight-color: transparent;
            border: none;
        }

        .imm-btn-token {
            height: 38px;
            min-width: 38px;
            width: auto;
            background: #d4af37;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            color: #ffff;
            font-size: 14px;
            font-weight: 800;
            padding: 0 12px;
            box-shadow: 0 4px 10px rgba(212, 175, 55, 0.4);
            cursor: pointer;
            transition: all 0.2s;
        }

        .imm-btn-token:active {
            transform: scale(0.95);
            background: #b8962e;
        }

        /* Video Controls (Right Sidebar) */
        .imm-left-controls {
            position: absolute;
            right: 16px;
            top: calc(env(safe-area-inset-top, 16px) + 70px);
            display: flex;
            align-items: center;
            flex-direction: row-reverse;
            gap: 12px;
            z-index: 100;
        }

        @media (orientation: landscape) {
            .imm-ui-overlay, .imm-ui-content-wrapper {
                width: 100% !important;
                max-width: none !important;
                padding-right: constant(safe-area-inset-right, 16px) !important;
                padding-right: env(safe-area-inset-right, 16px) !important;
            }
            .imm-right-sidebar {
                display: none !important;
            }
            .portrait-only-tokens {
                display: none !important;
            }
            .imm-top-bar {
                width: 100% !important;
                justify-content: space-between !important;
                padding-right: 0 !important; /* Managed by parent padding */
                display: flex !important;
            }
            .imm-btn-exit {
                z-index: 1000 !important;
                margin-left: auto !important;
            }
            .imm-left-controls {
                top: auto !important;
                bottom: calc(16px + 60px + env(safe-area-inset-bottom, 0px)) !important;
                right: 16px !important; /* Aligned with 3-dots now at the far right of the group */
                flex-direction: column-reverse !important;
                gap: 8px !important;
                display: flex !important;
            }
            .imm-left-controls .imm-main-toggle {
                display: none !important;
            }
            .imm-controls-group {
                flex-direction: column-reverse !important;
                margin-right: 0 !important;
                transform: translateY(20px) !important;
                display: flex !important;
            }
            .imm-left-controls.expanded .imm-controls-group {
                transform: translateY(0) !important;
                opacity: 1 !important;
                visibility: visible !important;
            }
            .imm-bottom-bar {
                gap: 12px;
                justify-content: space-between;
                width: 100%;
            }
            .imm-input-pill {
                flex: 1;
                max-width: 450px;
            }
            .imm-landscape-actions {
                display: flex !important;
                gap: 8px;
                align-items: center;
                margin-left: 20px;
            }
            .imm-chat-feed {
                max-width: 60%;
                padding-bottom: 60px;
            }
        }

        .imm-landscape-actions {
            display: none;
        }

        .imm-controls-group {
            display: flex;
            flex-direction: row-reverse;
            gap: 12px;
            margin-right: 12px;
            opacity: 0;
            visibility: hidden;
            transform: translateX(20px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .imm-left-controls.expanded .imm-controls-group {
            opacity: 1;
            visibility: visible;
            transform: translateX(0);
        }

        .imm-video-btn {
            width: 44px;
            height: 44px;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #d4af37;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            flex-shrink: 0;
        }

        .imm-video-btn:active {
            transform: scale(0.9);
            background: rgba(0,0,0,0.8);
        }

        .imm-video-btn.active {
            color: #000;
            background: #d4af37;
            border-color: #d4af37;
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.4);
        }

        /* Portrait: Vertical stacking, no toggle */
        @media (orientation: portrait) {
            .imm-left-controls {
                flex-direction: row-reverse;
                gap: 0;
            }
            .imm-controls-group {
                display: flex;
                flex-direction: row-reverse;
                gap: 12px;
            }
            .imm-fullscreen-btn-portrait {
                display: none !important;
            }
        }

        /* Landscape: Horizontal, collapsible row */
        @media (orientation: landscape) {
            .imm-top-bar {
                position: fixed;
                top: 16px;
                left: 16px;
                padding-top: 0;
                z-index: 100;
            }
            
            .imm-btn-exit {
                display: none !important; /* Managed by top-right controls or physical back */
            }

            .imm-left-controls {
                left: auto;
                right: 16px;
                top: 16px;
                bottom: auto;
                flex-direction: row; /* Non-reverse for top-right */
                gap: 12px;
                transform: none;
            }
            
            .imm-controls-group {
                display: flex;
                flex-direction: row;
                gap: 12px;
                background: rgba(0,0,0,0.6);
                backdrop-filter: blur(15px);
                padding: 6px 14px;
                border-radius: 30px;
                border: 1px solid rgba(255,255,255,0.1);
                transition: all 0.4s ease;
            }

            .imm-main-toggle {
                display: none !important; /* Keep always expanded in landscape */
            }

            .imm-bottom-bar {
                max-width: 600px;
                margin: 0 auto;
                left: 0;
                right: 0;
            }
            
            .imm-chat-feed {
                padding-bottom: 80px;
                max-width: 300px;
            }

            .imm-right-sidebar {
                bottom: 100px;
                gap: 12px;
            }
        }

        /* Chat Feed */
        .imm-chat-feed {
            margin-top: auto;
            display: flex;
            flex-direction: column;
            gap: 2px;
            max-width: 90%;
            padding-bottom: 80px;
        }

        .imm-msg-bubble {
            background: rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(8px);
            padding: 2px 8px;
            border-radius: 8px;
            display: inline-flex;
            align-items: flex-start;
            gap: 3px;
            border: 1px solid rgba(255,255,255,0.05);
            width: fit-content;
        }

        .imm-user-name {
            font-weight: 800;
            font-size: 10px;
            white-space: nowrap;
        }

        .imm-msg-content {
            color: #fff;
            font-size: 10px;
            font-weight: 500;
            line-height: 1.1;
        }

        /* Bottom Search/Input */
        .imm-bottom-bar {
            position: absolute;
            bottom: 16px;
            left: 16px;
            right: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: env(safe-area-inset-bottom, 0px);
        }

        .imm-input-pill {
            flex: 1;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(12px);
            border-radius: 30px;
            padding: 4px 6px 4px 16px;
            border: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
        }

        .imm-input-pill input {
            background: transparent;
            border: none;
            color: #fff;
            flex: 1;
            outline: none;
            font-size: 14px;
            padding: 8px 0;
        }

        .imm-input-pill input::placeholder {
            color: rgba(255,255,255,0.6);
        }

        .imm-send-btn {
            background: var(--imm-magenta);
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: none;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            cursor: pointer;
        }

        .imm-auth-prompt {
            justify-content: center;
            color: rgba(255,255,255,0.7);
            font-size: 13px;
            padding: 10px;
            cursor: pointer;
        }

        .imm-guest-auth-container {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 20px;
        }

        .imm-btn-auth-primary {
            background: #d4af37;
            color: #000;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .imm-btn-auth-secondary {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 14px;
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .imm-btn-auth-secondary:active {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Tipping Modal Styles */
        .imm-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.7);
            backdrop-filter: blur(8px);
            z-index: 2000;
            display: none;
            align-items: flex-end;
            justify-content: center;
        }

        .imm-modal-content {
            background: #121214;
            width: 100%;
            max-width: 500px;
            max-height: 85vh;
            max-height: 85dvh;
            overflow-y: auto;
            border-top-left-radius: 30px;
            border-top-right-radius: 30px;
            padding: 20px 20px calc(20px + env(safe-area-inset-bottom, 0px));
            animation: immSlideUp 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 215, 0, 0.15);
        }

        @keyframes immSlideUp {
            from { transform: translateY(100%); }
            to { transform: translateY(0); }
        }

        .imm-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .imm-modal-header h3 {
            margin: 0;
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .imm-modal-close {
            background: rgba(255,255,255,0.1);
            border: none;
            color: #fff;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .imm-tip-presets {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .imm-tip-btn {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.12), rgba(212, 175, 55, 0.05));
            border: 1px solid rgba(212, 175, 55, 0.3);
            padding: 20px 16px;
            border-radius: 16px;
            color: var(--imm-yellow);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .imm-tip-btn:active {
            transform: scale(0.95);
            background: rgba(212, 175, 55, 0.2);
        }

        .imm-tip-btn .amount {
            font-size: 22px;
            font-weight: 800;
            font-family: 'Poppins', sans-serif;
        }

        .imm-tip-btn .label {
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 600;
            opacity: 0.6;
            letter-spacing: 1px;
        }

        .imm-tip-custom {
            display: flex;
            gap: 12px;
        }

        .imm-tip-custom input {
            flex: 1;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 14px 16px;
            color: #fff;
            outline: none;
            font-size: 16px;
            font-weight: 600;
        }

        .imm-tip-custom button {
            background: var(--imm-magenta);
            border: none;
            color: #fff;
            padding: 0 25px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 4px 15px rgba(233, 30, 99, 0.3);
        }

        /* Feed adjustment for Tips */
        .imm-msg-bubble.tip-feed-msg {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.35), rgba(0, 0, 0, 0.45));
            border-color: rgba(212, 175, 55, 0.5);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            padding: 4px 8px;
        }

        /* Recharge Modal Styles */
        .imm-recharge-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            max-height: 60vh;
            overflow-y: auto;
            padding-right: 4px;
        }

        .imm-pkg-card {
            background: linear-gradient(145deg, rgba(30, 30, 35, 0.9), rgba(20, 20, 25, 0.9));
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 18px;
            padding: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .imm-pkg-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.05) 0%, transparent 100%);
            pointer-events: none;
        }

        .imm-pkg-card:active {
            transform: scale(0.96);
            border-color: rgba(212, 175, 55, 0.5);
            background: rgba(212, 175, 55, 0.1);
        }

        .imm-pkg-badge {
            position: absolute;
            top: 0;
            right: 0;
            background: #d4af37;
            color: #000;
            font-size: 8px;
            font-weight: 800;
            padding: 2px 8px;
            border-bottom-left-radius: 10px;
            text-transform: uppercase;
        }

        .imm-pkg-tokens {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #d4af37;
            font-size: 20px;
            font-weight: 800;
            font-family: 'Poppins', sans-serif;
        }

        .imm-pkg-price {
            color: #fff;
            font-size: 14px;
            font-weight: 700;
        }

        .imm-pkg-bonus {
            font-size: 10px;
            color: #4CAF50;
            font-weight: 600;
            background: rgba(76, 175, 80, 0.1);
            padding: 2px 8px;
            border-radius: 10px;
        }

        .imm-recharge-grid::-webkit-scrollbar {
            width: 4px;
        }
        .imm-recharge-grid::-webkit-scrollbar-thumb {
            background: rgba(212, 175, 55, 0.3);
            border-radius: 10px;
        }

        /* Global Layout Hider */
        #header, #sidebar, #adminSidebar, .admin-header, .header-stripchat, 
        .sidebar-v2, .sidebar-mobile-toggle, .mobile-search-filters, 
        #mobileSearchFilters, .footer-premium {
            display: none !important;
        }

        body, html {
            overflow: hidden !important;
            margin: 0 !important;
            padding: 0 !important;
            height: 100dvh !important;
        }
    </style>
@endsection

@section('content')
    <div class="immersive-enhanced-wrapper">
        <!-- Video Background -->
        <div class="imm-video-container">
            <video id="hlsEnhancedPlayer" playsinline autoplay muted loop></video>
        </div>

        <!-- UI Overlay -->
        <div class="imm-ui-overlay" id="immUiOverlay">
            <div class="imm-ui-content-wrapper" id="immUiContent">
            <!-- Video Controls -->
            <div class="imm-left-controls" id="immVideoControls">
                <button class="imm-video-btn imm-main-toggle" onclick="toggleImmControls()" title="Controles">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                <div class="imm-controls-group">
                    <button id="immMuteBtn" class="imm-video-btn" onclick="toggleImmMute()" title="{{ __('profiles.actions.unmute') }}">
                        <i class="fas fa-volume-mute"></i>
                    </button>
                    <button class="imm-video-btn" id="immFullscreenBtn" onclick="toggleImmFullscreen()" title="Fullscreen">
                        <i class="fas fa-expand"></i>
                    </button>
                </div>
            </div>

            <!-- Header -->
            <div class="imm-top-bar">
                <div class="imm-model-card">
                    <div class="imm-avatar-wrap">
                        <img src="{{ $model->profile->avatar_url }}" alt="" class="imm-avatar">
                        <div class="imm-live-tag">{{ __('profiles.badges.live') }}</div>
                    </div>
                    <div class="imm-model-meta">
                        <h4>{{ $model->profile->display_name ?? $model->name }}</h4>
                        <span>{{ number_format($model->favorited_by_count ?? 1200) }} {{ __('profiles.stats.viewers') }}</span>
                    </div>
                    @auth
                        @if($hasSubscription)
                            <button class="imm-btn-subscribed">
                                <i class="fas fa-check-circle"></i> {{ __('profiles.actions.subscribed') }}
                            </button>
                        @else
                            <form action="{{ route('profiles.subscribe', $model->id) }}" method="POST" onsubmit="handleSubscribe(event, this)">
                                @csrf
                                <button type="submit" class="imm-btn-subscribe">
                                    <i class="fas fa-key"></i> {{ __('profiles.actions.subscribe') }}
                                </button>
                            </form>
                        @endif
                    @else
                        <button type="button" class="imm-btn-subscribe" onclick="openImmAuthModal(immTrans.authModalTitle, immTrans.loginToSubscribe)">
                            <i class="fas fa-key"></i> {{ __('profiles.actions.subscribe') }}
                        </button>
                    @endauth
                </div>
                
                <a href="{{ route('home') }}" class="imm-btn-exit">
                    <i class="fas fa-times"></i>
                </a>
            </div>

            <!-- Right Actions Sidebar -->
            <div class="imm-right-sidebar">
                <div class="imm-action-item">
                    <button class="imm-action-btn" onclick="{{ auth()->check() ? 'toggleFavorite(' . $model->id . ', this)' : 'openImmAuthModal(immTrans.authModalTitle, immTrans.loginToFavorite)' }}">
                        <i class="{{ auth()->check() && auth()->user()->hasFavorite($model->id) ? 'fas fa-star' : 'far fa-star' }}" style="{{ auth()->check() && auth()->user()->hasFavorite($model->id) ? 'color: #D4AF37;' : '' }}"></i>
                    </button>
                    <span id="imm-fav-count">{{ number_format($model->favorited_by_count ?? 0) }}</span>
                </div>
               
                
                <div class="imm-action-item">
                    <div class="imm-btn-gift" onclick="openImmTipModal()">
                        <i class="fas fa-gift"></i>
                    </div>
                </div>
            </div>

            <!-- Modal de Propinas / Auth (Mobile Bottom Sheet) -->
            <div id="immTipModal" class="imm-modal-overlay" onclick="closeImmTipModal(event)">
                <div class="imm-modal-content" onclick="event.stopPropagation()">
                    <div class="imm-modal-header">
                        <h3 id="immModalTitle">{{ __('profiles.tips.send_tip') }}</h3>
                        <button class="imm-modal-close" onclick="closeImmTipModal()"><i class="fas fa-times"></i></button>
                    </div>
                    @auth
                        <div class="imm-modal-body" id="immTippingBody">
                            <div class="imm-tip-presets">
                                <button class="imm-tip-btn" onclick="sendImmTip(10)">
                                    <span class="amount">10</span>
                                    <span class="label">{{ __('profiles.stats.tokens') }}</span>
                                </button>
                                <button class="imm-tip-btn" onclick="sendImmTip(50)">
                                    <span class="amount">50</span>
                                    <span class="label">{{ __('profiles.stats.tokens') }}</span>
                                </button>
                                <button class="imm-tip-btn" onclick="sendImmTip(100)">
                                    <span class="amount">100</span>
                                    <span class="label">{{ __('profiles.stats.tokens') }}</span>
                                </button>
                                <button class="imm-tip-btn" onclick="sendImmTip(500)">
                                    <span class="amount">500</span>
                                    <span class="label">{{ __('profiles.stats.tokens') }}</span>
                                </button>
                            </div>
                            <div class="imm-tip-custom">
                                <input type="number" id="immCustomTipAmount" placeholder="{{ __('profiles.tips.custom_amount') }}">
                                <button onclick="sendImmTip(document.getElementById('immCustomTipAmount').value)">{{ __('profiles.tips.send') }}</button>
                            </div>
                        </div>
                    @else
                        <div class="imm-modal-body" style="text-align: center; padding: 10px 0;">
                            <p id="immAuthPrompt" style="color: rgba(255,255,255,0.7); margin-bottom: 10px; font-size: 14px;">{{ __('profiles.chat.login_to_tip') }}</p>
                            <div class="imm-guest-auth-container">
                                <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="imm-btn-auth-primary">
                                    <i class="fas fa-sign-in-alt"></i> {{ __('profiles.auth.login') }}
                                </a>
                                <a href="{{ route('register', ['redirect' => url()->current()]) }}" class="imm-btn-auth-secondary">
                                    <i class="fas fa-user-plus"></i> {{ __('profiles.auth.register') }}
                                </a>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Modal de Recarga (Quick Recharge) -->
            <div id="immRechargeModal" class="imm-modal-overlay" onclick="closeImmRechargeModal(event)">
                <div class="imm-modal-content" onclick="event.stopPropagation()">
                    <div class="imm-modal-header">
                        <h3 id="immRechargeModalTitle">{{ __('profiles.tips.recharge') }}</h3>
                        <button class="imm-modal-close" onclick="closeImmRechargeModal()"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="imm-modal-body">
                        <div class="imm-recharge-grid">
                            @foreach($tokenPackages as $package)
                                <div class="imm-pkg-card" onclick="startQuickPurchase({{ $package->id }}, {{ $package->price }}, {{ $package->tokens + $package->bonus }})">
                                    @if($package->tokens >= 5000)
                                        <div class="imm-pkg-badge">Best Value</div>
                                    @elseif($package->tokens == 1000)
                                        <div class="imm-pkg-badge">Popular</div>
                                    @endif
                                    
                                    <div class="imm-pkg-tokens">
                                        {{ number_format($package->tokens + $package->bonus, 0, '.', ',') }}
                                        <i class="fas fa-coins" style="font-size: 14px;"></i>
                                    </div>
                                    <div class="imm-pkg-price">${{ number_format($package->price, 2) }}</div>
                                    @if($package->bonus > 0)
                                        <div class="imm-pkg-bonus">+{{ number_format($package->bonus, 0, '.', ',') }} bonus</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Feed -->
            <div class="imm-chat-feed" id="immChatMessages">
                <!-- Messages will be loaded here dynamically -->
            </div>

            <!-- Bottom Input Field -->
            <div class="imm-bottom-bar">
                @auth
                    <div class="imm-input-pill">
                        <input type="text" id="immChatInput" placeholder="{{ __('profiles.chat.placeholder') }}" onkeypress="if(event.key === 'Enter') sendImmMessage()">
                        <button class="imm-send-btn" onclick="sendImmMessage()"><i class="fas fa-paper-plane"></i></button>
                    </div>
                @else
                    <div class="imm-input-pill imm-auth-prompt" onclick="openImmAuthModal(immTrans.authModalTitle, immTrans.loginToChat)">
                        <span>{{ __('profiles.chat.login_to_chat') }}</span>
                    </div>
                @endauth

                <div class="imm-landscape-actions">
                    @auth
                        <div class="imm-btn-token" onclick="openImmRechargeModal()" style="margin: 0 4px;">
                            <i class="fas fa-coins" style="color: #fff; margin-right: 4px;"></i>
                            <span id="imm-user-balance-landscape" style="color: #fff; font-weight: 800;">{{ number_format(auth()->user()->tokens, 0, '.', ',') }}</span>
                        </div>
                    @endauth
                    <button class="imm-btn-gift" onclick="openImmTipModal()" style="width: 40px; height: 40px; margin-bottom: 0; box-shadow: none; color: #fff;">
                        <i class="fas fa-gift"></i>
                    </button>
                    <button class="imm-action-btn" onclick="{{ auth()->check() ? 'toggleFavorite(' . $model->id . ', this)' : 'openImmAuthModal(immTrans.authModalTitle, immTrans.loginToFavorite)' }}" >
                        <i class="{{ auth()->check() && auth()->user()->hasFavorite($model->id) ? 'fas fa-star' : 'far fa-star' }}" style="{{ auth()->check() && auth()->user()->hasFavorite($model->id) ? 'color: #D4AF37;' : '' }}"></i>
                    </button>
                    <button class="imm-video-btn" onclick="toggleImmControls()" style="background: rgba(255,255,255,0.1); width: 40px; height: 40px;">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>

                <!-- Portrait Token Button -->
                @auth
                    <div class="imm-btn-token portrait-only-tokens" onclick="openImmRechargeModal()">
                        <span id="imm-user-balance">{{ number_format(auth()->user()->tokens, 0, '.', ',') }}</span>
                        <i class="fas fa-coins"></i>
                    </div>
                @else
                    <div class="imm-btn-token portrait-only-tokens" onclick="openImmAuthModal(immTrans.authModalTitle, immTrans.recharge)">
                        <i class="fas fa-coins"></i>
                    </div>
                @endauth

               
            </div>
          </div> {{-- End imm-ui-content-wrapper --}}
        </div>
    </div>

    <!-- HLS initialization -->
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script>
        let hls; // Global HLS instance
        const immTrans = {
            user: "{{ __('profiles.chat.user') }}",
            tip: "{{ __('profiles.actions.tip') }}",
            tipSent: "{{ __('profiles.tips.tip_sent') }}",
            successTitle: "{{ __('profiles.tips.success_title') }}",
            insufficientTokensTitle: "{{ __('profiles.tips.insufficient_tokens_title') }}",
            insufficientTokens: "{{ __('profiles.tips.insufficient_tokens') }}",
            recharge: "{{ __('profiles.tips.recharge') }}",
            cancel: "{{ __('profiles.chat.cancel') }}",
            authModalTitle: "{{ __('profiles.auth.modal_title') }}",
            tipModalTitle: "{{ __('profiles.tips.send_tip') }}",
            loginToChat: "{{ __('profiles.chat.login_to_chat') }}",
            loginToTip: "{{ __('profiles.chat.login_to_tip') }}",
            loginToFavorite: "{{ __('profiles.chat.login_to_favorite') }}",
            loginToSubscribe: "{{ __('profiles.chat.login_to_subscribe') }}",
            mute: "{{ __('profiles.actions.mute') }}",
            unmute: "{{ __('profiles.actions.unmute') }}",
            play: "{{ __('profiles.actions.play') }}",
            pause: "{{ __('profiles.actions.pause') }}",
            buy: "{{ __('profiles.tips.buy') }}",
            confirmPurchaseTitle: "{{ __('profiles.tips.confirm_purchase_title') }}",
            confirmPurchaseText: "{{ __('profiles.tips.confirm_purchase_text') }}"
        };

        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('hlsEnhancedPlayer');
            const streamUrl = '{{ asset("hls/live/" . $model->profile->stream_key . "/index.m3u8") }}';

            // Click anywhere on wrapper (except buttons/inputs) to toggle UI
            const wrapper = document.querySelector('.immersive-enhanced-wrapper');
            const uiOverlay = document.getElementById('immUiOverlay');
            
            if (wrapper && uiOverlay) {
                wrapper.addEventListener('click', function(e) {
                    // Ignore clicks on interactive elements
                    if (e.target.closest('button, input, a, .imm-btn-gift, .imm-btn-token, .imm-tip-btn, .imm-pkg-card, .imm-modal-content')) return;
                    
                    uiOverlay.classList.toggle('ui-hidden');
                });
            }

            // Auto Fullscreen on landscape
            window.addEventListener('orientationchange', function() {
                if (window.orientation === 90 || window.orientation === -90) {
                    autoRequestFullscreen();
                }
            });

            if (Hls.isSupported()) {
                hls = new Hls({
                    lowLatencyMode: true,
                    liveSyncDurationCount: 2,
                    liveMaxLatencyDurationCount: 4,
                    maxBufferLength: 3,
                    maxMaxBufferLength: 6,
                    backBufferLength: 10,
                    highBufferWatchdogPeriod: 1,
                });
                hls.loadSource(streamUrl);
                hls.attachMedia(video);
                hls.on(Hls.Events.MANIFEST_PARSED, function() {
                    video.play().catch(e => console.log("Autoplay blocked:", e));
                });
            } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                video.src = streamUrl;
            }

            // Start chat polling
            loadImmChatHistory();
            setInterval(loadImmChatHistory, 4000);

            // ── Stream-Ended Detection (Echo + Polling) ──
            const mobileStreamId = {{ $activeStream->id ?? 'null' }};
            if (video && mobileStreamId) {
                let mobileStreamEnded = false;

                const handleMobileStreamEnded = () => {
                    if (mobileStreamEnded) return;
                    mobileStreamEnded = true;

                    // Stop HLS
                    if (typeof hls !== 'undefined' && hls) {
                        try { hls.destroy(); } catch(_){}
                        hls = null;
                    }
                    video.pause();

                    // Hide UI overlay
                    const uiOv = document.getElementById('immUiOverlay');
                    if (uiOv) uiOv.style.display = 'none';

                    // Show stream-ended overlay
                    const container = document.querySelector('.imm-video-container');
                    if (container) {
                        const endedOverlay = document.createElement('div');
                        endedOverlay.style.cssText = 'position:absolute;inset:0;z-index:200;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;background:radial-gradient(circle at center,#1a1a1a 0%,#000 100%);padding:2rem;';
                        endedOverlay.innerHTML = `
                            <div style="padding:4px;border:2px solid rgba(255,255,255,0.1);border-radius:50%;margin-bottom:1rem;">
                                <img src="{{ $model->profile->avatar_url ?? '' }}"
                                    onerror="this.onerror=null;this.src='{{ asset('images/placeholder-avatar.svg') }}'"
                                    style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:2px solid #fff;">
                            </div>
                            <div style="background:#fff;color:#000;padding:4px 12px;border-radius:20px;font-weight:800;font-size:0.7rem;text-transform:uppercase;margin-bottom:0.5rem;">
                                {{ __('profiles.stream.ended_badge') }}
                            </div>
                            <p style="color:rgba(255,255,255,0.6);font-size:0.9rem;margin:0;">
                                {{ __('profiles.stream.ended_message') }}
                            </p>
                        `;
                        container.appendChild(endedOverlay);
                    }
                };

                // Echo real-time listener (instant, if available)
                if (window.Echo) {
                    window.Echo.channel('stream.' + mobileStreamId)
                        .listen('.App\\Events\\StreamEnded', () => handleMobileStreamEnded());
                }

                // Polling fallback (every 10s)
                const pollMobileStreamStatus = () => {
                    if (mobileStreamEnded) return;
                    fetch('/streams/' + mobileStreamId + '/status', {
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                        credentials: 'same-origin',
                    })
                    .then(r => r.ok ? r.json() : Promise.reject())
                    .then(data => {
                        if (data.status === 'ended' || data.status === 'offline') {
                            handleMobileStreamEnded();
                        }
                    })
                    .catch(() => {});
                };
                setInterval(pollMobileStreamStatus, 10000);
            }
        });

        function loadImmChatHistory() {
            fetch('{{ route("profiles.chat.history", $model->id) }}')
                 .then(response => response.json())
                 .then(data => {
                     if (data.success) {
                         // Get last 4 messages
                        const history = data.history.slice(-4);
                        renderImmChat(history);
                     }
                 })
                 .catch(error => console.error('Error loading mobile chat:', error));
        }

        function renderImmChat(history) {
            const container = document.getElementById('immChatMessages');
            if (!container) return;

            const currentIds = Array.from(container.querySelectorAll('.imm-msg-bubble')).map(el => el.dataset.id);
            const newIds = history.map(item => String(item.id));

            // If IDs match, don't re-render
            if (JSON.stringify(currentIds) === JSON.stringify(newIds)) return;

            container.innerHTML = '';
            
            history.forEach(item => {
                const div = document.createElement('div');
                div.className = 'imm-msg-bubble';
                div.dataset.id = item.id;
                
                const isModel = item.user && item.user.id === {{ $model->id }};
                const userColor = isModel ? '#D4AF37' : (item.user && item.user.is_vip ? '#F06292' : '#64B5F6');
                
                if (item.type === 'tip' || item.type === 'roulette' || item.type === 'menu') {
                    const isRoulette = item.type === 'roulette' || (item.content && item.content.includes('🎲'));
                    const isMenu = item.type === 'menu';
                    const iconHtml = isRoulette ? '<i class="fas fa-dharmachakra"></i>' : (isMenu ? '<i class="fas fa-list-ul"></i>' : '<i class="fas fa-coins"></i>');
                    
                    div.classList.add('tip-feed-msg');
                    div.innerHTML = `
                        <span class="imm-user-name" style="color: #FFD700;">${iconHtml} ${item.user ? item.user.name : immTrans.user}:</span>
                        <span class="imm-msg-content"><b>${item.amount}Tk</b> ${item.content || immTrans.tip}</span>
                    `;
                } else {
                    const isReply = isModel && item.content.startsWith('@');
                    if (isModel) div.style.borderLeft = `2px solid ${isReply ? '#9333ea' : '#D4AF37'}`;
                    if (item.is_pinned) div.style.background = 'rgba(212, 175, 55, 0.15)';

                    div.innerHTML = `
                        <span class="imm-user-name" style="color: ${userColor};">${item.user ? item.user.name : immTrans.user}:</span>
                        <span class="imm-msg-content">${item.content}</span>
                    `;
                }
                container.appendChild(div);
            });
            
            container.scrollTop = container.scrollHeight;
        }

        // Modal management
        function openImmTipModal() {
            const title = document.getElementById('immModalTitle');
            const prompt = document.getElementById('immAuthPrompt');
            if (title) title.innerText = immTrans.tipModalTitle;
            if (prompt) prompt.innerText = immTrans.loginToTip;
            
            document.getElementById('immTipModal').style.display = 'flex';
        }

        function openImmAuthModal(titleText, promptText) {
            const title = document.getElementById('immModalTitle');
            const prompt = document.getElementById('immAuthPrompt');
            if (title) title.innerText = titleText;
            if (prompt) prompt.innerText = promptText;
            
            document.getElementById('immTipModal').style.display = 'flex';
        }

        function closeImmTipModal(e) {
            if (e && e.target !== document.getElementById('immTipModal') && !e.target.closest('.imm-modal-close')) return;
            document.getElementById('immTipModal').style.display = 'none';
        }

        function openImmRechargeModal() {
            document.getElementById('immRechargeModal').style.display = 'flex';
        }

        function closeImmRechargeModal(e) {
            if (e && e.target !== e.currentTarget && e.target.tagName !== 'I' && e.target.className !== 'imm-modal-close') return;
            document.getElementById('immRechargeModal').style.display = 'none';
        }

        function startQuickPurchase(packageId, price, tokens) {
            Swal.fire({
                title: immTrans.confirmPurchaseTitle || 'Confirm Recharge',
                text: `${immTrans.confirmPurchaseText || 'Buy'} ${Math.floor(tokens).toLocaleString()} tokens for $${price}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: immTrans.buy || 'Buy',
                cancelButtonText: immTrans.cancel,
                confirmButtonColor: '#d4af37',
                cancelButtonColor: '#222',
                background: '#121214',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `{{ route('fan.tokens.recharge') }}?package_id=${packageId}`;
                }
            });
        }

        function toggleImmControls() {
            const container = document.getElementById('immVideoControls');
            container.classList.toggle('expanded');
        }

        // Video Player Logic
        const player = document.getElementById('hlsEnhancedPlayer');
        const muteBtn = document.getElementById('immMuteBtn');

        function toggleImmMute() {
            if (player.muted) {
                player.muted = false;
                muteBtn.innerHTML = '<i class="fas fa-volume-up"></i>';
                muteBtn.classList.add('active');
                muteBtn.title = immTrans.mute;
            } else {
                player.muted = true;
                muteBtn.innerHTML = '<i class="fas fa-volume-mute"></i>';
                muteBtn.classList.remove('active');
                muteBtn.title = immTrans.unmute;
            }
        }

        function refreshImmStream() {
            const streamUrl = '{{ asset("hls/live/" . $model->profile->stream_key . "/index.m3u8") }}';
            if (typeof hls !== 'undefined' && hls) {
                hls.detachMedia();
                hls.loadSource(streamUrl);
                hls.attachMedia(player);
            } else {
                player.load();
            }
        }

        function sendImmTip(amount) {
            amount = parseInt(amount);
            if (!amount || amount < 1) return;

            // Optional message
            const message = immTrans.tipSent; 

            fetch('{{ route("profiles.tip", $model->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ amount: amount, message: message })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeImmTipModal();
                    Swal.fire({
                        icon: 'success',
                        title: immTrans.successTitle,
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false,
                        background: '#121214',
                        color: '#fff'
                    });
                    
                    // Update header tokens if element exists
                    const tokenDisplays = document.querySelectorAll('.header-token-amount, #user-tokens-balance, #imm-user-balance');
                    tokenDisplays.forEach(el => {
                        el.innerText = data.new_balance.toLocaleString();
                    });

                    loadImmChatHistory();
                } else {
                    if (data.message && data.message.toLowerCase().includes('token')) {
                        Swal.fire({
                            icon: 'warning',
                            title: immTrans.insufficientTokensTitle,
                            text: immTrans.insufficientTokens,
                            showCancelButton: true,
                            confirmButtonText: immTrans.recharge,
                            cancelButtonText: immTrans.cancel,
                            confirmButtonColor: '#d4af37',
                            background: '#121214',
                            color: '#fff'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '{{ route("fan.tokens.recharge") }}';
                            }
                        });
                    } else {
                        Swal.fire('Error', data.message || 'Error', 'error');
                    }
                }
            })
            .catch(error => console.error('Error sending mobile tip:', error));
        }

        function sendImmMessage() {
            const input = document.getElementById('immChatInput');
            if (!input) return;
            const message = input.value.trim();
            if (!message) return;

            fetch('{{ route("profiles.chat.send", $model->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: message })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    input.value = '';
                    loadImmChatHistory();
                }
            })
            .catch(error => console.error('Error sending mobile message:', error));
        }

        function toggleFavorite(modelId, btn) {
            if (!{{ auth()->check() ? 'true' : 'false' }}) {
                window.location.href = '{{ route('login') }}';
                return;
            }
            const icon = btn.querySelector('i');
            const countSpan = document.getElementById('imm-fav-count');

            fetch(`/fan/favorites/${modelId}/toggle`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.is_favorite) {
                        icon.classList.add('fas');
                        icon.classList.remove('far');
                        icon.style.color = '#D4AF37';
                        if (countSpan) {
                            let count = parseInt(countSpan.innerText.replace(/,/g, '')) || 0;
                            countSpan.innerText = (count + 1).toLocaleString();
                        }
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        icon.style.color = '';
                        if (countSpan) {
                            let count = parseInt(countSpan.innerText.replace(/,/g, '')) || 0;
                            countSpan.innerText = Math.max(0, count - 1).toLocaleString();
                        }
                    }
                }
            })
            .catch(e => console.error("Favorite error:", e));
        }

        function handleSubscribe(e, form) {
            e.preventDefault();
            const btn = form.querySelector('button[type="submit"]');
            const originalHTML = btn.innerHTML;
            
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Suscripción Exitosa!',
                        text: 'Ahora eres suscriptor de esta modelo.',
                        background: '#1a1a1e',
                        color: '#fff',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    if (data.message && data.message.toLowerCase().includes('token')) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Tokens Insuficientes',
                            text: 'Te quedaste sin tokens. Regarga ahora para seguir disfrutando.',
                            showCancelButton: true,
                            confirmButtonText: '<i class="fas fa-coins"></i> Recargar Tokens',
                            cancelButtonText: 'Cancelar',
                            confirmButtonColor: '#d4af37',
                            cancelButtonColor: 'rgba(255,255,255,0.1)',
                            background: '#1a1a1e',
                            color: '#fff'
                        }).then((result) => {
                            if(result.isConfirmed) {
                                window.location.href = '{{ route("fan.tokens.recharge") }}';
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'No se pudo procesar la suscripción.',
                            background: '#1a1a1e',
                            color: '#fff'
                        });
                    }
                }
            })
            .catch(e => {
                console.error("Subscribe error:", e);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error inesperado.',
                    background: '#1a1a1e',
                    color: '#fff'
                });
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = originalHTML;
            });
        }

        // Immersive/Fullscreen Utilities
        function toggleImmFullscreen() {
            const doc = window.document;
            const docEl = doc.documentElement;
            const btn = document.getElementById('immFullscreenBtn');

            const requestFullScreen = docEl.requestFullscreen || docEl.mozRequestFullScreen || docEl.webkitRequestFullScreen || docEl.msRequestFullscreen;
            const cancelFullScreen = doc.exitFullscreen || doc.mozCancelFullScreen || doc.webkitExitFullscreen || doc.msExitFullscreen;

            if(!doc.fullscreenElement && !doc.mozFullScreenElement && !doc.webkitFullscreenElement && !doc.msFullscreenElement) {
                requestFullScreen.call(docEl);
                if(btn) btn.innerHTML = '<i class="fas fa-compress"></i>';
            } else {
                cancelFullScreen.call(doc);
                if(btn) btn.innerHTML = '<i class="fas fa-expand"></i>';
            }
        }

        function autoRequestFullscreen() {
            const doc = window.document;
            const docEl = doc.documentElement;
            const requestFullScreen = docEl.requestFullscreen || docEl.mozRequestFullScreen || docEl.webkitRequestFullScreen || docEl.msRequestFullscreen;
            
            if(!doc.fullscreenElement && !doc.mozFullScreenElement && !doc.webkitFullscreenElement && !doc.msFullscreenElement) {
                // Browsers often require user interaction, so this might only work if they clicked something recently
                requestFullScreen.call(docEl).catch(e => console.log("Auto-fullscreen blocked:", e));
            }
        }
    </script>
@endsection
