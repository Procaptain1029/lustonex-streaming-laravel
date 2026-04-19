@php
    $layout = 'layouts.public';
    if (auth()->check()) {
        if (auth()->user()->isAdmin())
            $layout = 'layouts.admin';
        elseif (auth()->user()->isModel())
            $layout = 'layouts.public';
        elseif (auth()->user()->isFan())
            $layout = 'layouts.public';
    }
@endphp

@extends($layout)

@section('title', ($model->profile->display_name ?? $model->name) . ' - ' . __('profiles.public_profile'))

@section('styles')
    @stack('styles')
@endsection

@section('content')
 <style>
        :root {
            --glass-bg: rgba(18, 18, 22, 0.75);
            --glass-border: rgba(212, 175, 55, 0.15);
            --accent-gold: #d4af37;
            --glass-white: rgba(255, 255, 255, 0.1);
        }


        /* Layout Reset for Profile */
        .profile-wrapper {
            display: block;
            width: 100%;
            padding-bottom: 3rem;
            padding: 0 1rem;
            max-width: 1700px;
            margin: 0 auto;
            position: relative;
        }

        /* Responsive layout adjustments */
        @media (max-width: 1200px) {
            .profile-wrapper {
                grid-template-columns: 1fr;

            }
        }

        /* 1. Profile Immersive Header */
        .profile-hero {
            position: relative;
            margin-bottom: 5rem;
            background: #000;
            border-radius: 32px;
            overflow: visible;
        }

        .hero-cover-wrapper {
            position: absolute;
            inset: 0;
            border-radius: 32px;
            overflow: hidden;
            border: 1px solid var(--glass-border);
            z-index: 1;
        }

        .hero-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.6;
        }

        .hero-avatar-area {
            position: absolute;
            bottom: -60px;
            left: 2.5rem;
            display: flex;
            align-items: flex-end;
            gap: 1.5rem;
            z-index: 10;
        }

        .profile-avatar-premium {
            width: 160px;
            border-radius: 16px;
            border: 4px solid #121216;
            background: #121216;
            object-fit: cover;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
            aspect-ratio: 4 / 5;
            margin-bottom: 24px;
        }

        /* 2. Info Block */
        .profile-info-block {
            padding-left: 2.5rem;
            padding-top: 0.5rem;
            display: flex;
            justify-content: flex-start;
            align-items: flex-end;
            gap: 3rem;
        }

        .info-content {
            flex: 0 0 auto;
        }

        .action-deck {
            flex: 1;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            gap: 1rem;
            padding-bottom: 5px;
        }

        .display-name {
            font-size: 32px;
            font-weight: 700;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .badge-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 12px;
        }

        .premium-badge {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(20px);
            border: 1.5px solid;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .premium-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s;
        }

        .premium-badge:hover::before {
            left: 100%;
        }

        .badge-vip {
            background: linear-gradient(135deg, #d4af37 0%, #f9d976 100%) !important;
            color: #000 !important;
            border-color: #d4af37 !important;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4) !important;
            font-weight: 800 !important;
        }

        .badge-gold {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.15), rgba(255, 215, 0, 0.1));
            color: #FFD700;
            border-color: rgba(212, 175, 55, 0.4);
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.2);
        }

        .badge-gold:hover {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.25), rgba(255, 215, 0, 0.15));
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.3);
            transform: translateY(-2px);
        }

        .badge-live {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(220, 53, 69, 0.15));
            color: #ff4d4d;
            border-color: rgba(239, 68, 68, 0.5);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
            animation: pulse-glow 2s infinite;
            font-size: 14px;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
            }

            50% {
                box-shadow: 0 4px 20px rgba(239, 68, 68, 0.5);
            }
        }

        .pulse-live {
            width: 8px;
            height: 8px;
            background: #ff4d4d;
            border-radius: 50%;
            animation: pulse-dot 1.5s infinite;
            box-shadow: 0 0 8px rgba(255, 77, 77, 0.8);
        }

        @keyframes pulse-dot {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.2);
                opacity: 0.8;
            }
        }

        .premium-badge:not(.badge-gold):not(.badge-live) {
            background: rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.9);
            border-color: rgba(255, 255, 255, 0.15);
        }

        .premium-badge:not(.badge-gold):not(.badge-live):hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.25);
        }

        /* Modern 2-Column Desktop Layout */
        .profile-layout-wrapper {
            display: flex;
            gap: 1.5rem;
            /* align-items: stretch; is default */
            margin-bottom: 2rem;
            position: relative;
            z-index: 10;
        }

        .profile-col-left {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            min-width: 0;
        }

        .profile-col-right {
            width: 360px;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            min-width: 0;
            flex-shrink: 0;
        }

        /* Ocultar columna derecha (Chat y Stats) en móviles */
        @media (max-width: 991px) {
            .profile-col-right {
                display: none !important;
            }
        }

        .player-section {
            min-width: 0;
        }

        .item-chat {
            display: flex;
            flex-direction: column;
            flex: 1; /* Stretch en la columna derecha */
        }

        /* Chat Widget */
        .chat-widget {
            background: var(--glass-bg);
            border-radius: 20px;
            border: 1px solid var(--glass-border);
            overflow: hidden;
            flex: 1; /* Ocupa todo el alto de .item-chat */
            display: flex;
            flex-direction: column;
            min-height: 450px; /* Evita que se encoja demasiado en pantallas ultra anchas */
            height: 100%;
        }

        .chat-header {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.1), rgba(255, 215, 0, 0.05));
            border-bottom: 1px solid var(--glass-border);
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #FFD700;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .chat-header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-chat-tip {
            background: rgba(212, 175, 55, 0.1);
            border: 1px solid rgba(212, 175, 55, 0.3);
            color: var(--accent-gold);
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-chat-tip:hover {
            background: var(--accent-gold);
            color: #000;
            transform: scale(1.05);
        }

        .chat-count {
            background: rgba(212, 175, 55, 0.2);
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.75rem;
            border: 1px solid rgba(212, 175, 55, 0.3);
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: rgba(212, 175, 55, 0.3);
            border-radius: 3px;
        }

        .chat-message {
            display: flex;
            flex-direction: column;
            gap: 4px;
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .chat-message:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .chat-message.system-msg {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.1), rgba(255, 215, 0, 0.05));
            border-color: rgba(212, 175, 55, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 12px;
        }

        .chat-user {
            font-weight: 700;
            font-size: 0.8rem;
            color: var(--accent-gold);
        }

        .chat-text {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.85rem;
            line-height: 1.4;
        }

        .chat-input-container {
            padding: 1rem;
            border-top: 1px solid var(--glass-border);
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .quick-tips-row {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 4px;
        }

        .quick-tips-row::-webkit-scrollbar {
            height: 3px;
        }

        .quick-tip-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 6px 12px;
            color: #fff;
            font-size: 0.75rem;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .quick-tip-btn:hover {
            background: rgba(212, 175, 55, 0.15);
            border-color: var(--accent-gold);
            color: var(--accent-gold);
        }

        .chat-input-row {
            display: flex;
            gap: 0.5rem;
        }

        .chat-input {
            flex: 1;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            color: white;
            font-size: 0.85rem;
            outline: none;
            transition: all 0.3s ease;
        }

        .chat-input:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--accent-gold);
        }

        .chat-send {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.2), rgba(255, 215, 0, 0.15));
            border: 1px solid rgba(212, 175, 55, 0.4);
            color: #FFD700;
            padding: 0.75rem 1.25rem;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .chat-send:hover {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.3), rgba(255, 215, 0, 0.2));
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
        }

        .chat-login-prompt {
            width: 100%;
            text-align: center;
            padding: 1rem;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.85rem;
        }

        .chat-login-prompt a {
            color: var(--accent-gold);
            text-decoration: none;
            font-weight: 700;
        }

        .chat-login-prompt a:hover {
            text-decoration: underline;
        }

        @media (max-width: 1200px) {
            .profile-layout-wrapper {
                flex-direction: column;
                align-items: stretch;
                margin-top: 1rem;
            }

            /* Rip open the columns on mobile to reorganize the stack */
            .profile-col-left, .profile-col-right {
                display: contents;
            }

            .item-player { order: 1; }
            .item-info { order: 2; }
            .item-chat { order: 3; }
            .item-stats { order: 4; }
            .item-tabs { order: 5; }
            
            .chat-widget {
                height: 400px;
            }

            /* Hide chat on mobile if offline */
            .chat-hidden-mobile {
                display: none !important;
            }

            /* HIDE OFFLINE PLACEHOLDER COMPLETELY ON MOBILE */
            .offline-placeholder {
                display: none !important;
            }
            
            /* Collapse player if offline placeholder is hidden */
            .player-window:has(.offline-placeholder) {
                 display: none;
            }
        }

        /* 3. Stage */
        .stage-card {
            background: var(--glass-bg);
            border-radius: 28px;
            border: 1px solid var(--glass-border);
            overflow: hidden;
            margin-bottom: 0;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .player-window {
            width: 100%;
            aspect-ratio: 16/9;
            background: #000;
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            flex: 1;
        }

        /* Móvil vertical: marco más alto para que el vídeo no quede en una franja pequeña */
        @media (max-width: 1024px) and (orientation: portrait) {
            .player-window {
                aspect-ratio: 9 / 16;
                max-height: min(78vh, 720px);
                margin-left: auto;
                margin-right: auto;
            }
        }

        .player-aspect-ratio {
            width: 100%;
            height: 100%;
            position: relative;
        }

        #hlsProfilePlayer {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        /* Pause Overlay */
        .pause-overlay {
            position: absolute;
            inset: 0;
            z-index: 20;
            background: #000;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .pause-media {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        /* Player Overlay Actions */
        .player-overlay-actions {
            position: absolute;
            bottom: 2rem;
            right: 2rem;
            z-index: 50;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .btn-player-quick-tip {
            width: 54px;
            height: 54px;
            background: var(--accent-gold);
            color: #000;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            border: none;
            cursor: pointer;
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-player-quick-tip:hover {
            transform: scale(1.1) rotate(15deg);
            background: #fff;
            box-shadow: 0 12px 30px rgba(255, 255, 255, 0.3);
        }

        .pause-content {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.4);
            padding: 2rem;
        }

        .pause-message {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(10px);
            padding: 1.5rem 2.5rem;
            border-radius: 20px;
            color: #fff;
            border: 1px solid rgba(212, 175, 55, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .pause-message h3 {
            color: var(--accent-gold);
            margin-bottom: 0.5rem;
            font-family: 'Poppins';
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 1.2rem;
        }

        .pause-message p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        /* Offline Placeholder */
        .offline-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: radial-gradient(circle at center, #1a1a1a 0%, #000 100%);
            padding: 3rem;
            z-index: 10;
            transition: all 0.5s ease;
        }

        .offline-placeholder i {
            color: rgba(212, 175, 55, 0.2);
            filter: drop-shadow(0 0 20px rgba(212, 175, 55, 0.1));
            margin-bottom: 2rem;
            animation: moon-glow 4s infinite alternate;
        }

        @keyframes moon-glow {
            from {
                transform: translateY(0);
                opacity: 0.3;
            }

            to {
                transform: translateY(-10px);
                opacity: 0.6;
            }
        }

        .offline-placeholder h4 {
            color: #fff;
            font-family: 'Poppins';
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .offline-placeholder p {
            color: rgba(255, 255, 255, 0.4);
            font-size: 1rem;
            max-width: 400px;
        }

        .btn-notify-full {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.15), rgba(255, 215, 0, 0.05));
            color: #fff;
            padding: 14px 28px;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: 700;
            border: 1px solid rgba(212, 175, 55, 0.5);
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            backdrop-filter: blur(8px);
            font-family: inherit;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
        }

        .btn-notify-full i {
            color: #FFD700;
            font-size: 1.3rem;
            filter: drop-shadow(0 0 6px rgba(255, 215, 0, 0.6));
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-notify-full:hover {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.3), rgba(255, 215, 0, 0.15));
            border-color: #FFD700;
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(212, 175, 55, 0.3);
        }

        .btn-notify-full:hover i {
            transform: scale(1.15) rotate(10deg);
            filter: drop-shadow(0 0 10px rgba(255, 215, 0, 0.8));
        }

        /* 4. Actions */
        .action-deck {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .btn-profile {
            padding: 12px 28px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease-out;
            cursor: pointer;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .btn-profile:hover {
            transform: scale(1.02);
            transition: all 0.2s ease-out;
        }

        .btn-premium {
            background: var(--accent-gold);
            color: #000;
            border: none;
        }

        /* Tabs & Grid */
        .content-tabs {
            display: flex;
            gap: 2rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            padding-bottom: 16px;
            border-top: 1px solid rgba(0, 0, 0, 0.06);
        }

        /* PC-Only Custom Player Controls */
        .player-custom-controls {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 25px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .player-aspect-ratio:hover .player-custom-controls,
        .player-custom-controls.active {
            opacity: 1;
            pointer-events: all;
        }

        .controls-left, .controls-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .player-control-btn {
            background: none;
            border: none;
            color: #fff;
            cursor: pointer;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            padding: 5px;
        }

        .player-control-btn:hover {
            color: var(--accent-gold);
            transform: scale(1.1);
        }

        .player-volume-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .vol-slider-container {
            width: 0;
            overflow: hidden;
            transition: width 0.3s ease;
            display: flex;
            align-items: center;
        }

        .player-volume-group:hover .vol-slider-container {
            width: 80px;
        }

        .player-vol-slider {
            -webkit-appearance: none;
            width: 80px;
            height: 4px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
            outline: none;
        }

        .player-vol-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 12px;
            height: 12px;
            background: var(--accent-gold);
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 0 10px rgba(212, 175, 55, 0.5);
        }

        /* Center Play Button */
        .player-center-play {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 101;
            width: 80px;
            height: 80px;
            background: rgba(212, 175, 55, 0.2);
            border: 2px solid var(--accent-gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-gold);
            font-size: 2rem;
            cursor: pointer;
            backdrop-filter: blur(4px);
            opacity: 0;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .player-center-play.visible {
            opacity: 1;
            pointer-events: all;
        }

        .player-center-play:hover {
            background: var(--accent-gold);
            color: #000;
            transform: translate(-50%, -50%) scale(1.1);
        }

        @media (max-width: 1024px) {
            .pc-only-control {
                display: none !important;
            }
        }

        .profile-info-block .widget-title,
        .content-tabs .tab-item {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 0;
        }

        .tab-item {
            padding: 1rem 0;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 700;
            cursor: pointer;
            position: relative;
        }

        .tab-item.active {
            color: #fff;
        }

        .tab-item.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--accent-gold);
        }

        .media-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 16px;
        }

        @media (max-width: 768px) {
            .media-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.5rem;
            }
        }

        /* Pagination Styles */
        .sh-pagination {
            display: flex !important;
            align-items: center;
            justify-content: space-between;
            padding: 2rem 0;
            font-family: inherit;
        }

        .sh-pagination-mobile {
            display: none;
            flex: 1;
            justify-content: space-between;
        }

        .sh-pagination-desktop {
            display: flex !important;
            flex: 1;
            align-items: center;
            justify-content: space-between;
        }

        .sh-pagination-info {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.6);
        }

        .sh-pagination-info p {
            margin: 0;
        }

        .sh-pagination-links {
            display: inline-flex !important;
            border-radius: 0.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .sh-page-link {
            position: relative;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            padding: 0.625rem 1rem;
            margin-left: -1px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background-color: rgba(20, 20, 25, 0.8);
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.875rem;
            font-weight: 500;
            line-height: 1.25rem;
            text-decoration: none;
            transition: all 0.2s ease;
            min-width: 40px;
        }

        .sh-page-link:hover {
            color: #D4AF37;
            border-color: rgba(212, 175, 55, 0.5);
            background-color: rgba(212, 175, 55, 0.15);
            z-index: 2;
        }

        .sh-page-link.active {
            z-index: 3;
            background-color: #D4AF37 !important;
            border-color: #D4AF37 !important;
            color: #000 !important;
            font-weight: 700;
        }

        .sh-page-link:first-child {
            border-top-left-radius: 0.5rem;
            border-bottom-left-radius: 0.5rem;
            margin-left: 0;
        }

        .sh-page-link:last-child {
            border-top-right-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
        }

        .sh-page-link svg {
            width: 1.25rem;
            height: 1.25rem;
        }

        @media (max-width: 640px) {
            .sh-pagination-mobile {
                display: flex !important;
            }

            .sh-pagination-desktop {
                display: none !important;
            }
        }

        .media-card {
            background: #1a1a1e;
            border-radius: 12px;
            aspect-ratio: 4/5;
            overflow: hidden;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.2s ease-out;
            object-fit: cover;
        }

        .media-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

        .media-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .lock-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 15px;
            color: #fff;
            text-align: center;
            padding: 1.5rem;
            backdrop-filter: blur(5px);
        }

        .lock-overlay i {
            color: var(--accent-gold);
            opacity: 0.8;
        }

        /* Widgets */
        .sidebar-widget {
            background: var(--glass-bg);
            border-radius: 24px;
            border: 1px solid var(--glass-border);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .widget-title {
            font-size: 0.8rem;
            text-transform: uppercase;
            color: var(--accent-gold);
            letter-spacing: 1px;
            font-weight: 800;
        }

        /* Footer Sections */
        .footer-section-title {
            color: white;
            margin: 4rem 0 2rem;
            border-left: 4px solid var(--accent-gold);
            padding-left: 1rem;
            font-weight: 800;
            font-size: 1.5rem;
        }

        .category-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.06);
            color: rgba(255, 255, 255, 0.8);
            padding: 10px 18px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .category-badge:hover {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.2), rgba(255, 215, 0, 0.15));
            color: #FFD700;
            border-color: rgba(212, 175, 55, 0.4);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.2);
        }

        @media (max-width: 768px) {
            .profile-info-block {
                padding-left: 0;
                flex-direction: column;
                align-items: center;
                text-align: center;
                gap: 1.5rem;
            }

            .action-deck {
                justify-content: center;
                width: 100%;
            }

            .hero-avatar-area {
                left: 50%;
                transform: translateX(-50%);
                bottom: -80px;
            }
        }

        /* Floating Action Buttons */
        .player-floating-actions {
            position: absolute;
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            flex-direction: column;
            gap: 1rem;
            z-index: 100;
        }

        .player-fab {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        .player-fab i {
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }

        .fab-label {
            font-size: 0.5rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.9;
        }

        .player-fab-tip {
            background: linear-gradient(135deg, #d4af37 0%, #f1c40f 100%);
            color: #000;
        }

        .player-fab-tip:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 20px rgba(212, 175, 55, 0.5);
        }

        .player-fab-tip:active {
            transform: scale(0.95);
        }

        .player-fab-roulette {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: #fff;
        }

        .player-fab-roulette:hover {
            transform: scale(1.1) rotate(15deg);
            box-shadow: 0 8px 20px rgba(231, 76, 60, 0.5);
        }

        .player-fab-roulette:active {
            transform: scale(0.95) rotate(15deg);
        }

        /* Pulse animation for attention */
        @keyframes fab-pulse {

            0%,
            100% {
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            }

            50% {
                box-shadow: 0 4px 20px rgba(212, 175, 55, 0.6);
            }
        }

        .player-fab-tip {
            animation: fab-pulse 2s ease-in-out infinite;
        }

        /* Mobile responsive for FABs */
        @media (max-width: 768px) {
            .player-floating-actions {
                right: 1rem;
                gap: 0.75rem;
            }

            .player-fab {
                width: 50px;
                height: 50px;
            }

            .player-fab i {
                font-size: 1.2rem;
            }

            .fab-label {
                font-size: 0.55rem;
            }
        }

        @media (max-width: 480px) {
            .player-floating-actions {
                right: 0.5rem;
                gap: 0.5rem;
            }

            .player-fab {
                width: 45px;
                height: 45px;
            }

            .player-fab i {
                font-size: 1.1rem;
            }

            .fab-label {
                display: none;
            }
        }

        /* Floating Video Player */
        .floating-player {
            position: fixed;
            bottom: 20px;
            left: 20px;
            width: 320px;
            aspect-ratio: 16/9;
            background: #000;
            border-radius: 12px;
            overflow: hidden;
            z-index: 9999;
            border: 2px solid var(--accent-gold);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0;
            transform: translateY(20px) scale(0.9);
            pointer-events: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6);
        }

        .floating-player.active {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: all;
        }

        .floating-player video {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .floating-content {
            width: 100%;
            height: 100%;
            position: relative;
        }

        .close-floating {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            cursor: pointer;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            backdrop-filter: blur(4px);
            transition: all 0.2s ease;
        }

        .close-floating:hover {
            background: rgba(212, 175, 55, 0.8);
            color: black;
        }

        .btn-heart.active i {
            color: #ef4444 !important;
            filter: drop-shadow(0 0 5px rgba(239, 68, 68, 0.5));
        }

        /* Modal Tip Premium */
        .modal-tip-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(10px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .modal-tip-content {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 32px;
            width: 100%;
            max-width: 480px;
            padding: 2.5rem;
            position: relative;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        /* Sidebar Tipping View */
        .chat-widget {
            position: relative;
            overflow: hidden;
        }

        .chat-messages {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease;
        }

        .sidebar-tip-view {
            position: absolute;
            top: 60px;
            /* Below header */
            left: 0;
            width: 100%;
            height: calc(100% - 130px);
            /* Space for header and input */
            background: #121216;
            z-index: 10;
            padding: 1.5rem;
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .sidebar-tip-view.active {
            transform: translateX(0);
        }

        .chat-messages.dimmed {
            opacity: 0.3;
            filter: blur(4px);
            pointer-events: none;
        }

        .user-tip-balance {
            background: rgba(212, 175, 55, 0.05);
            border: 1px solid rgba(212, 175, 55, 0.15);
            color: var(--accent-gold);
            padding: 0.75rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.9rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .tip-sub-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 1.25rem;
            background: rgba(255, 255, 255, 0.03);
            padding: 4px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .tip-sub-tab {
            flex: 1;
            background: transparent;
            border: none;
            padding: 0.5rem;
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.75rem;
            font-weight: 700;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .tip-sub-tab.active {
            background: rgba(255, 255, 255, 0.08);
            color: white;
        }

        .tip-pane {
            display: none;
        }

        .tip-pane.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Roulette Overlay */
        .roulette-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 100;
            backdrop-filter: blur(12px);
        }

        .roulette-overlay.active {
            display: flex;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes pulseGlow {

            0%,
            100% {
                box-shadow: 0 0 40px rgba(212, 175, 55, 0.4),
                    0 0 80px rgba(212, 175, 55, 0.2),
                    inset 0 0 20px rgba(212, 175, 55, 0.1);
            }

            50% {
                box-shadow: 0 0 60px rgba(212, 175, 55, 0.6),
                    0 0 120px rgba(212, 175, 55, 0.3),
                    inset 0 0 30px rgba(212, 175, 55, 0.2);
            }
        }

        @keyframes rotate360 {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .roulette-wheel-container {
            position: relative;
            width: 320px;
            height: 320px;
            border: 10px solid #d4af37;
            border-radius: 50%;
            background: linear-gradient(135deg, #1a1a1e 0%, #0a0a0c 100%);
            animation: pulseGlow 2s ease-in-out infinite;
        }

        .roulette-wheel-container::before {
            content: '';
            position: absolute;
            top: -15px;
            left: -15px;
            right: -15px;
            bottom: -15px;
            border-radius: 50%;
            background: conic-gradient(from 0deg,
                    transparent 0deg,
                    rgba(212, 175, 55, 0.3) 90deg,
                    transparent 180deg,
                    rgba(212, 175, 55, 0.3) 270deg,
                    transparent 360deg);
            animation: rotate360 4s linear infinite;
            z-index: -1;
        }

        .roulette-wheel {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            position: relative;
            overflow: hidden;
            transition: transform 5s cubic-bezier(0.17, 0.67, 0.12, 0.99);
            border: 5px solid rgba(255, 255, 255, 0.15);
            /* Vibrant gradient colors for each slice */
            background: conic-gradient(#ff3b3b 0deg 45deg,
                    #ff1493 45deg 90deg,
                    #9b59b6 90deg 135deg,
                    #8e44ad 135deg 180deg,
                    #3498db 180deg 225deg,
                    #00bcd4 225deg 270deg,
                    #00d9a3 270deg 315deg,
                    #16a085 315deg 360deg);
            box-shadow: inset 0 0 60px rgba(0, 0, 0, 0.6),
                inset 0 0 30px rgba(0, 0, 0, 0.4);
        }

        .roulette-wheel::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, transparent 30%, rgba(0, 0, 0, 0.3) 100%);
            pointer-events: none;
        }

        .wheel-label {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 30px;
            transform: rotate(calc(45deg * var(--i) + 22.5deg));
            pointer-events: none;
            z-index: 5;
        }

        .wheel-label span {
            color: #fff;
            font-weight: 900;
            font-size: 0.65rem;
            text-transform: uppercase;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.9),
                0 0 10px rgba(0, 0, 0, 0.5);
            white-space: nowrap;
            max-width: 85px;
            text-align: center;
            letter-spacing: 0.5px;
        }

        @media (max-width: 600px) {
            .roulette-wheel-container {
                width: 260px !important;
                height: 260px !important;
            }

            .wheel-label {
                padding-top: 25px;
            }

            .wheel-label span {
                font-size: 0.5rem !important;
            }
        }

        .roulette-pointer {
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 18px solid transparent;
            border-right: 18px solid transparent;
            border-top: 40px solid #d4af37;
            z-index: 110;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.6)) drop-shadow(0 0 15px rgba(212, 175, 55, 0.8));
        }

        .roulette-pointer::after {
            content: '';
            position: absolute;
            top: -40px;
            left: -18px;
            width: 36px;
            height: 40px;
            background: linear-gradient(180deg, #ffd700 0%, #d4af37 100%);
            clip-path: polygon(50% 100%, 0 0, 100% 0);
        }

        .roulette-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #1a1a1e 0%, #0a0a0c 100%);
            border: 4px solid #d4af37;
            border-radius: 50%;
            z-index: 105;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #d4af37;
            font-size: 1.2rem;
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.5),
                inset 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .roulette-center::before {
            content: '';
            position: absolute;
            width: 60px;
            height: 60px;
            border: 2px solid rgba(212, 175, 55, 0.3);
            border-radius: 50%;
            animation: pulseRing 2s ease-in-out infinite;
        }

        @keyframes pulseRing {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.5;
            }

            50% {
                transform: scale(1.2);
                opacity: 0;
            }
        }

        .fa-spin-slow {
            animation: fa-spin 8s linear infinite;
        }

        .btn-spin-roulette {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 20px rgba(212, 175, 55, 0.4);
        }

        .btn-spin-roulette:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.5);
            filter: brightness(1.1);
        }

        .btn-spin-roulette:active:not(:disabled) {
            transform: translateY(0);
        }

        .tip-type-selector {
            display: flex;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            margin-bottom: 1.25rem;
            padding: 3px;
        }

        .tip-type-btn {
            flex: 1;
            background: transparent;
            border: none;
            padding: 0.6rem;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 700;
            font-size: 0.75rem;
            cursor: pointer;
            border-radius: 9px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .tip-type-btn.active {
            background: var(--accent-gold);
            color: #000;
        }

        .tip-presets {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
            margin-bottom: 1.25rem;
        }

        .tip-preset-btn {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 0.75rem;
            color: white;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .preset-amount {
            font-size: 1.1rem;
            font-weight: 800;
        }

        .preset-label {
            font-size: 0.55rem;
            opacity: 0.5;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .tip-preset-btn:hover {
            background: rgba(212, 175, 55, 0.1);
            border-color: var(--accent-gold);
        }

        .tip-preset-btn.active {
            background: var(--accent-gold);
            color: #000;
            border-color: var(--accent-gold);
        }

        .tip-preset-btn.active .preset-label {
            color: rgba(0, 0, 0, 0.5);
        }

        .tip-custom-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 0.75rem;
            color: white;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .tip-message {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 0.75rem;
            color: white;
            margin-bottom: 1.5rem;
            resize: none;
            font-size: 0.85rem;
        }

        .btn-send-tip {
            width: 100%;
            background: var(--accent-gold);
            color: #000;
            border: none;
            border-radius: 12px;
            padding: 1rem;
            font-weight: 800;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.2);
        }

        .btn-send-tip:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.3);
        }

        .btn-send-tip:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Toggle icon animation */
        .btn-chat-tip i {
            transition: transform 0.3s ease;
        }

        .btn-chat-tip.active i {
            transform: rotate(45deg);
        }

        /* Fan Club Tiers */
        .tiers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .tier-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 28px;
            padding: 2rem;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .tier-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .tier-card.tier-bronze {
            border-color: rgba(205, 127, 50, 0.3);
        }

        .tier-card.tier-gold {
            border-color: rgba(212, 175, 55, 0.3);
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.05), rgba(0, 0, 0, 0));
        }

        .tier-card.tier-diamond {
            border-color: rgba(185, 242, 255, 0.3);
            background: linear-gradient(135deg, rgba(185, 242, 255, 0.05), rgba(0, 0, 0, 0));
        }

        .tier-card.active {
            border-width: 2px;
            box-shadow: 0 0 30px rgba(212, 175, 55, 0.1);
        }

        .tier-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.2));
        }

        .tier-bronze .tier-icon {
            color: #cd7f32;
        }

        .tier-gold .tier-icon {
            color: #d4af37;
        }

        .tier-diamond .tier-icon {
            color: #b9f2ff;
        }

        .tier-name {
            font-family: var(--font-titles);
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            color: #fff;
        }

        .tier-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--accent-gold);
            margin-bottom: 1.5rem;
        }

        .tier-perks {
            list-style: none;
            padding: 0;
            margin: 0 0 2rem 0;
            text-align: left;
        }

        .tier-perks li {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .tier-perks li i {
            color: #00ff88;
            font-size: 0.8rem;
        }

        .btn-tier-action {
            width: 100%;
            padding: 1rem;
            border-radius: 14px;
            border: none;
            font-weight: 800;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .tier-bronze .btn-tier-action {
            background: rgba(205, 127, 50, 0.2);
            color: #cd7f32;
            border: 1px solid rgba(205, 127, 50, 0.3);
        }

        .tier-gold .btn-tier-action {
            background: var(--accent-gold);
            color: #000;
        }

        .tier-diamond .btn-tier-action {
            background: #b9f2ff;
            color: #000;
        }

        .btn-tier-action:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        /* Media Heart Styles */
        .media-card {
            position: relative;
        }

        .media-actions {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 5;
            display: flex;
            gap: 8px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .media-card:hover .media-actions {
            opacity: 1;
        }

        /* Always show actions on touch devices to avoid double-tap issues */
        @media (hover: none) {
            .media-actions {
                opacity: 1;
            }
        }

        .btn-media-heart {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-media-heart:hover {
            transform: scale(1.1);
            background: rgba(255, 255, 255, 0.2);
        }

        .btn-media-heart.active {
            color: #ff4d4d;
            background: rgba(255, 77, 77, 0.1);
            border-color: rgba(255, 77, 77, 0.3);
        }

        .media-likes-count {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.7rem;
            color: #fff;
            font-weight: 700;
            gap: 4px;
        }

        .profile-footer-section {
            padding: 48px 24px;
            font-size: 14px;
            opacity: 0.75;
            text-align: center;
        }

        .sidebar-widget .widget-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 16px;
        }
        
        .sidebar-widget span {
            font-size: 16px;
            line-height: 1.5;
        }

        .sidebar-widget p {
            font-size: 16px;
            line-height: 1.6;
            opacity: 0.85;
            margin-bottom: 24px;
            color: rgba(255,255,255,0.85) !important;
        }
    </style>
    <div class="profile-wrapper">

            <div class="profile-layout-wrapper">
                <!-- Left Column -->
                <div class="profile-col-left">
                    @if(!(auth()->check() && ((auth()->user()->isModel() && auth()->id() === $model->id) || auth()->user()->isAdmin())))
                        <div class="item-player">
                            @include('profiles.partials.player-section')
                        </div>
                    @endif

                    <div class="item-info">
                        @include('profiles.partials.profile-info')
                    </div>

                    <div class="item-tabs">
                        @include('profiles.partials.tabs-content')
                    </div>
                </div>

                <!-- Right Column -->
                <div class="profile-col-right">
                    @if(!(auth()->check() && ((auth()->user()->isModel() &&  auth()->id() === $model->id) || auth()->user()->isAdmin())))
                        <div class="@if(!($model->profile && $model->profile->is_streaming)) chat-hidden-mobile @endif">
                            @include('profiles.partials.chat-widget')
                        </div>
                    @endif

                    <div class="item-stats">
                        @include('profiles.partials.stats-sidebar')
                    </div>
                </div>
            </div>

            @if(!$isOwner && (!auth()->check() || !auth()->user()->isAdmin()))

                <div class="profile-footer-section">
                    <h3 class="footer-section-title">Modelos que te encantarán</h3>
                    <div class="sh-models-grid">
                        @foreach($relatedModels->take(10) as $model)
                            <a href="{{ route('profiles.show', ['model' => $model->id]) }}" class="sh-model-card">
                                <div class="sh-card-image-wrapper">
                                    @if($model->profile && $model->profile->avatar)
                                        <img src="{{ $model->profile->avatar_url }}" alt="{{ $model->name }}" class="sh-card-image" loading="lazy">
                                    @else
                                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #1a1a1a;">
                                            <i class="fas fa-user" style="font-size: 48px; color: rgba(255,255,255,0.1);"></i>
                                        </div>
                                    @endif

                                    @if($model->profile && $model->profile->is_streaming)
                                        <div class="sh-live-badge">
                                            <i class="fas fa-circle" style="font-size: 6px; color: white;"></i> EN VIVO
                                        </div>
                                    @endif
                                    
                                    @if($model->isVIP())
                                        <div class="sh-category-badge" style="display: flex; align-items: center; gap: 4px; background: rgba(156, 39, 176, 0.9);">
                                            <i class="fas fa-crown" style="font-size: 0.6rem;"></i>
                                            <span style="color: white;">VIP</span>
                                        </div>
                                    @endif

                                    <div class="sh-card-overlay">
                                        <h3 class="sh-model-name">
                                            {{ $model->profile->display_name ?? $model->name }}
                                            @if($model->profile && $model->profile->verification_status == 'approved')
                                                <i class="fas fa-check-circle" style="color: #1da1f2; font-size: 14px;" title="Verificado"></i>
                                            @endif
                                        </h3>
                                        <div class="sh-model-location">
                                            <span class="fi fi-{{ $model->profile->country ?? 'us' }}"></span> 
                                            {{ $model->profile->city ?? 'Internacional' }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    
                    <h3 class="footer-section-title">Explora por Categoría</h3>
                    <div class="profile-categories-container">
                    
                    <style>
                        .profile-categories-container {
                            display: flex;
                            flex-wrap: wrap;
                            gap: 0.5rem;
                            justify-content: flex-start;
                        }

                        .profile-categories-container .category-badge {
                            display: inline-flex;
                            align-items: center;
                            gap: 6px;
                            padding: 6px 14px;
                            background: rgba(255, 255, 255, 0.08); /* Darkish grey badge */
                            color: #ddd;
                            border: none;
                            border-radius: 20px; /* Pill shape */
                            text-decoration: none;
                            font-size: 0.8rem;
                            font-weight: 500;
                            transition: all 0.2s ease;
                            white-space: nowrap;
                        }

                        .profile-categories-container .category-badge:hover {
                            background: rgba(255, 255, 255, 0.15);
                            color: #fff;
                        }

                        .profile-categories-container .category-badge i,
                        .profile-categories-container .category-badge span[class^="fi"] {
                            font-size: 0.9rem;
                            opacity: 0.8;
                        }
                    </style>
                        @php
                            $filters = [
                                // País
                                ['label' => 'Colombia', 'route' => route('filtros.pais', 'co'), 'icon' => 'fi fi-co'],
                                ['label' => 'Argentina', 'route' => route('filtros.pais', 'ar'), 'icon' => 'fi fi-ar'],
                                ['label' => 'México', 'route' => route('filtros.pais', 'mx'), 'icon' => 'fi fi-mx'],
                                ['label' => 'España', 'route' => route('filtros.pais', 'es'), 'icon' => 'fi fi-es'],
                                ['label' => 'Brasil', 'route' => route('filtros.pais', 'br'), 'icon' => 'fi fi-br'],

                                // Etnia
                                ['label' => 'Latina', 'route' => route('filtros.etnia', 'latina'), 'icon' => 'fas fa-users'],
                                ['label' => 'Blanca', 'route' => route('filtros.etnia', 'blanca'), 'icon' => 'fas fa-users'],
                                ['label' => 'Asiática', 'route' => route('filtros.etnia', 'asiatica'), 'icon' => 'fas fa-users'],
                                ['label' => 'Negra', 'route' => route('filtros.etnia', 'negra'), 'icon' => 'fas fa-users'],
                                ['label' => 'Mixta', 'route' => route('filtros.etnia', 'multietnica'), 'icon' => 'fas fa-users'],

                                // Cabello
                                ['label' => 'Rubio', 'route' => route('filtros.cabello', 'rubio'), 'icon' => 'fas fa-scissors'],
                                ['label' => 'Moreno', 'route' => route('filtros.cabello', 'moreno'), 'icon' => 'fas fa-scissors'],
                                ['label' => 'Negro', 'route' => route('filtros.cabello', 'negro'), 'icon' => 'fas fa-scissors'],
                                ['label' => 'Pelirroja', 'route' => route('filtros.cabello', 'pelirroja'), 'icon' => 'fas fa-scissors'],
                                ['label' => 'Colorido', 'route' => route('filtros.cabello', 'colorido'), 'icon' => 'fas fa-scissors'],

                                // Edad
                                ['label' => '18-25 años', 'route' => route('filtros.edad', '18-25'), 'icon' => 'fas fa-cake-candles'],
                                ['label' => '26-30 años', 'route' => route('filtros.edad', '26-30'), 'icon' => 'fas fa-cake-candles'],
                                ['label' => '31-35 años', 'route' => route('filtros.edad', '31-35'), 'icon' => 'fas fa-cake-candles'],
                                ['label' => '36+ años', 'route' => route('filtros.edad', '36-plus'), 'icon' => 'fas fa-cake-candles'],
                            ];
                        @endphp
                        @foreach($filters as $filter)
                            <a href="{{ $filter['route'] }}" class="category-badge">
                                @if(str_contains($filter['icon'], 'fi-'))
                                    <span class="{{ $filter['icon'] }}"></span>
                                @else
                                    <i class="{{ $filter['icon'] }}"></i>
                                @endif
                                {{ $filter['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

    </div>
@endsection

@push('scripts')
    @yield('scripts')
@endpush

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Force sidebar collapse for profile view
            const sidebar = document.getElementById('sidebar');
            const body = document.body;
            const hamburgerBtn = document.getElementById('hamburgerBtn');

            if (sidebar && !sidebar.classList.contains('collapsed')) {
                sidebar.classList.add('collapsed');
                body.classList.add('sidebar-collapsed');
                localStorage.setItem('sidebarCollapsed', 'true');
                if (hamburgerBtn) hamburgerBtn.classList.remove('active');
            }
        });
    </script>
    <script src="{{ asset('js/webrtc-ll.js') }}?v={{ filemtime(public_path('js/webrtc-ll.js')) }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const video = document.getElementById('hlsProfilePlayer');
            const modeBadge = document.getElementById('profilePlaybackModeBadge');
            const loadingOverlay = document.getElementById('profileStreamLoadingOverlay');
            const setModeBadge = (label, bgColor = 'rgba(0,0,0,0.7)') => {
                if (!modeBadge) return;
                modeBadge.textContent = `Mode: ${label}`;
                modeBadge.style.background = bgColor;
            };
            const showLoadingOverlay = () => {
                if (loadingOverlay) loadingOverlay.style.display = 'flex';
            };
            const hideLoadingOverlay = () => {
                if (loadingOverlay) loadingOverlay.style.display = 'none';
            };
            if (video) {
                const url = video.dataset.url;
                let hls = null;
                let hlsStarted = false;
                const streamId = {{ $activeStream->id ?? 'null' }};
                const shouldTryWebRtc = Number.isInteger(streamId);
                setModeBadge('Connecting...', '#2563eb');
                showLoadingOverlay();

                const markVideoReady = () => hideLoadingOverlay();
                video.addEventListener('playing', markVideoReady);
                video.addEventListener('loadeddata', () => {
                    if (video.readyState >= 2) {
                        markVideoReady();
                    }
                });

                const tryPlay = () => {
                    video.muted = true;
                    const p = video.play();
                    if (p && typeof p.catch === 'function') {
                        p.catch(() => {});
                    }
                };

                const startHlsFallback = () => {
                    if (hlsStarted) return;
                    hlsStarted = true;
                    setModeBadge('HLS Fallback', '#b45309');
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
                        hls.loadSource(url);
                        hls.attachMedia(video);
                        hls.on(Hls.Events.MANIFEST_PARSED, () => tryPlay());
                        hls.on(Hls.Events.ERROR, () => {});
                    } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                        video.src = url;
                        video.addEventListener('loadedmetadata', () => tryPlay(), { once: true });
                    }
                    tryPlay();
                };

                /* Móvil: controles nativos (play / pantalla completa). Los custom están ocultos con .pc-only-control */
                if (window.matchMedia && window.matchMedia('(max-width: 1024px)').matches) {
                    video.setAttribute('controls', 'controls');
                }

                if (shouldTryWebRtc && window.WebRTCLowLatency) {
                    const webrtc = new WebRTCLowLatency();
                    webrtc.joinBroadcast(streamId, video)
                        .catch(() => startHlsFallback());

                    window.addEventListener('webrtc-peer-connected', () => {
                        if (hls) {
                            hls.destroy();
                            hls = null;
                        }
                    }, { once: true });

                    window.addEventListener('webrtc-video-ready', () => {
                        setModeBadge('WebRTC (Low Latency)', '#15803d');
                        markVideoReady();
                    }, { once: true });

                    setTimeout(() => {
                        if (!video.srcObject) {
                            startHlsFallback();
                        }
                    }, 8000);
                } else {
                    startHlsFallback();
                }
            }

            // Tab Switcher Logic
            const switchTab = (target) => {
                // Update active tab state
                document.querySelectorAll('.tab-item').forEach(t => {
                    t.classList.remove('active');
                    if (t.dataset.tab === target) t.classList.add('active');
                });

                // Show/Hide panes
                document.querySelectorAll('.tab-pane').forEach(pane => {
                    pane.style.display = 'none';
                });
                const activePane = document.getElementById(`${target}-pane`);
                if (activePane) {
                    activePane.style.display = 'block';
                }
            };

            document.querySelectorAll('.tab-item').forEach(tab => {
                tab.addEventListener('click', () => {
                    switchTab(tab.dataset.tab);
                });
            });

            // Sidebar Join Club Link
            const btnJoinClub = document.getElementById('btnJoinClub');
            if (btnJoinClub) {
                btnJoinClub.addEventListener('click', () => {
                    switchTab('club');
                    document.querySelector('.content-tabs').scrollIntoView({ behavior: 'smooth' });
                });
            }

            // --- Chat Height Sync ---
            const playerSection = document.querySelector('.item-player');
            const chatWidget = document.querySelector('.chat-widget');

            if (playerSection && chatWidget) {
                const resizeObserver = new ResizeObserver(entries => {
                    for (let entry of entries) {
                        // Forzamos el chat para que tenga la misma altura
                        chatWidget.style.height = entry.contentRect.height + 'px';
                        chatWidget.style.maxHeight = entry.contentRect.height + 'px';
                        chatWidget.style.minHeight = entry.contentRect.height + 'px';
                    }
                });
                resizeObserver.observe(playerSection);
            }
        });
        function toggleFavorite(modelId, btn) {
            fetch(`{{ url('/fan/favorites') }}/${modelId}/toggle`, {
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
                            btn.classList.add('active');
                            Swal.fire({
                                icon: 'success',
                                title: '¡Agregado a favoritos!',
                                text: 'Has agregado a esta modelo a tus favoritos.',
                                background: '#1a1a1e',
                                color: '#fff',
                                timer: 3000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            });
                        } else {
                            btn.classList.remove('active');
                            Swal.fire({
                                icon: 'info',
                                title: 'Eliminado de favoritos',
                                text: 'Has eliminado a esta modelo de tus favoritos.',
                                background: '#1a1a1e',
                                color: '#fff',
                                timer: 3000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            });
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Error al actualizar favorito',
                            background: '#1a1a1e',
                            color: '#fff',
                            confirmButtonColor: '#d4af37'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de conexión',
                        text: 'No se pudo contactar con el servidor.',
                        background: '#1a1a1e',
                        color: '#fff',
                        confirmButtonColor: '#d4af37'
                    });
                });
        }

        function toggleMediaLike(event, type, id, btn) {
            // Prevent event bubbling so it doesn't trigger the modal open click on the card
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }

            if (!{{ auth()->check() ? 'true' : 'false' }}) {
                window.location.href = "{{ route('login') }}";
                return;
            }

            // Sync all identical media elements on the page (grid and modal)
            const allBtns = document.querySelectorAll(`button[onclick*="toggleMediaLike(event, '${type}', ${id}"]`);
            const allCounts = document.querySelectorAll(`.media-card[data-id="${id}"] .media-likes-count .count, #modalLikesCount`);

            const isLiked = btn.classList.contains('active');
            const newLikedState = !isLiked;

            // Optimistic UI update
            allBtns.forEach(b => {
                if (newLikedState) b.classList.add('active');
                else b.classList.remove('active');
            });

            allCounts.forEach(span => {
                let currentCount = parseInt(span.innerText.replace(/,/g, '')) || 0;
                span.innerText = (newLikedState ? currentCount + 1 : Math.max(0, currentCount - 1)).toLocaleString();
            });

            fetch(`{{ url('/fan/media') }}/${type}/${id}/like`, {
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
                    // Update final state from server
                    allBtns.forEach(b => {
                        if (data.liked) b.classList.add('active');
                        else b.classList.remove('active');
                    });
                    allCounts.forEach(span => {
                        span.innerText = data.count.toLocaleString();
                    });
                } else {
                    // Revert on error
                    allBtns.forEach(b => {
                        if (isLiked) b.classList.add('active');
                        else b.classList.remove('active');
                    });
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Error al actualizar like',
                        background: '#1a1a1e',
                        color: '#fff',
                        confirmButtonColor: '#d4af37'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Revert on error
                allBtns.forEach(b => {
                    if (isLiked) b.classList.add('active');
                    else b.classList.remove('active');
                });
            });
        }

        // Tipping Logic (Sidebar View)
        let isTipViewOpen = false;
        let currentAmount = 0;
        let isMenuItem = false;
        let selectedMessage = '';

        function toggleTipView() {
            const tipView = document.getElementById('sidebarTipView');
            const chatMessages = document.getElementById('chatMessages');
            const btnToggle = document.getElementById('btnToggleTip');

            isTipViewOpen = !isTipViewOpen;

            if (isTipViewOpen) {
                tipView.classList.add('active');
                chatMessages.classList.add('dimmed');
                btnToggle.classList.add('active');
            } else {
                tipView.classList.remove('active');
                chatMessages.classList.remove('dimmed');
                btnToggle.classList.remove('active');
            }
        }

        function switchTipSubTab(tab) {
            document.querySelectorAll('.tip-pane').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.tip-sub-tab').forEach(b => b.classList.remove('active'));

            const pane = document.getElementById('pane-' + tab);
            const btn = document.getElementById('tab-btn-' + tab);

            if (pane) pane.classList.add('active');
            if (btn) btn.classList.add('active');

            // Reset selection when switching tabs
            currentAmount = 0;
            isMenuItem = false;
            selectedMessage = '';
            const btnSend = document.getElementById('btnSendTip');
            if (btnSend) btnSend.disabled = true;

            const display = document.getElementById('selectedActionDisplay');
            if (display) display.innerText = '';
            document.querySelectorAll('.tip-preset-btn').forEach(b => b.classList.remove('active'));
        }

        // Replace old modal functions with no-ops or redirect to toggle for compatibility
        function openTipModal() { toggleTipView(); }
        function closeTipModal() { if (isTipViewOpen) toggleTipView(); }

        function selectTip(amount, btn, isMenu, actionName = '') {
            document.querySelectorAll('.tip-preset-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            if (!actionName && !isMenu) {
                const labelEl = btn.querySelector('.preset-label');
                actionName = labelEl ? labelEl.innerText.trim() : 'Propina enviada';
            }

            currentAmount = amount;
            isMenuItem = isMenu;
            selectedMessage = actionName;

            const display = document.getElementById('selectedActionDisplay');
            if (display) {
                if (isMenu) {
                    display.innerText = 'Seleccionado: ' + actionName + ' (' + amount + ' Tk)';
                } else {
                    display.innerText = 'Seleccionado: Propina de ' + amount + ' Tk';
                }
            }

            const btnSend = document.getElementById('btnSendTip');
            if (btnSend) btnSend.disabled = false;
        }

        function spinRoulette() {
            const btn = document.getElementById('btnSpinRoulette');
            const overlay = document.getElementById('rouletteOverlay');
            const wheel = document.getElementById('rouletteWheel');

            if (!btn || !overlay || !wheel) return;

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Girando...';

            fetch('{{ route('profiles.spin', $model->id) }}', {
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
                        // Show overlay
                        overlay.classList.add('active');

                        // Rotation logic
                        const sectorDeg = 45;
                        const extraSpins = 360 * 5; // 5 full turns
                        // Landing on the right sector. 
                        // We want the pointer (top middle) to be on the result.
                        // Pointer is fixed at top. So we need to rotate wheel so sector result_index is at top.
                        const finalDeg = extraSpins + (360 - (data.result_index * 45 + 22.5));

                        // Reset position first without transition if needed
                        wheel.style.transition = 'none';
                        wheel.style.transform = 'rotate(0deg)';

                        // Force reflow
                        wheel.offsetHeight;

                        // Set transition and rotate
                        wheel.style.transition = 'transform 5s cubic-bezier(0.1, 0, 0.1, 1)';
                        wheel.style.transform = `rotate(${finalDeg}deg)`;

                        setTimeout(() => {
                            Swal.fire({
                                title: '¡RUEDA GIRADA!',
                                text: `Resultado: ${data.result}`,
                                icon: 'success',
                                background: '#1a1a1e',
                                color: '#fff',
                                confirmButtonColor: '#d4af37'
                            });

                            // Update balances
                            const balanceValues = data.new_balance.toLocaleString();
                            const bHeader = document.getElementById('user-tokens-balance');
                            const bSidebar = document.getElementById('sidebar-user-tokens');
                            if (bHeader) bHeader.innerText = balanceValues;
                            if (bSidebar) bSidebar.innerText = balanceValues;

                            // Reload chat to show roulette result
                            if (typeof loadPublicChatHistory === 'function') {
                                loadPublicChatHistory();
                            }

                            // Cleanup
                            setTimeout(() => {
                                overlay.classList.remove('active');
                                wheel.style.transition = 'none';
                                wheel.style.transform = 'rotate(0deg)';
                                setTimeout(() => { wheel.style.transition = 'transform 5s cubic-bezier(0.1, 0, 0.1, 1)'; }, 100);
                                btn.disabled = false;
                                btn.innerHTML = '<i class="fas fa-sync-alt"></i> ¡Girar Ruleta!';
                            }, 2000);
                        }, 5500);
                    } else {
                        Swal.fire('Error', data.message || 'Error al girar', 'error');
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fas fa-sync-alt"></i> ¡Girar Ruleta!';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-sync-alt"></i> ¡Girar Ruleta!';
                });
        }

        function quickTip(amount) {
            Swal.fire({
                title: '¿Enviar propina?',
                text: `¿Deseas enviar ${amount} tokens a {{ $model->profile->display_name ?? $model->name }}?`,
                icon: 'question',
                showCancelButton: true,
                background: '#1a1a1e',
                color: '#fff',
                confirmButtonColor: '#d4af37',
                cancelButtonColor: 'rgba(255,255,255,0.1)',
                confirmButtonText: 'Sí, enviar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Execute tip via silent sendTip call
                    fetch('{{ route('profiles.tip', $model->id) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ amount, message: 'Propina enviada' })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Propina enviada!',
                                    text: data.message,
                                    timer: 2000,
                                    showConfirmButton: false,
                                    background: '#1a1a1e',
                                    color: '#fff'
                                });
                                // Update balance
                                const balanceEl = document.getElementById('user-tokens-balance');
                                if (balanceEl) {
                                    balanceEl.innerText = data.new_balance.toLocaleString();
                                }
                                const balanceSidebar = document.getElementById('sidebar-user-tokens');
                                if (balanceSidebar) balanceSidebar.innerText = data.new_balance.toLocaleString();

                                // Refresh chat physically
                                if (typeof loadPublicChatHistory === 'function') {
                                    loadPublicChatHistory();
                                }
                            } else {
                                if (data.message && data.message.toLowerCase().includes('token')) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Tokens Insuficientes',
                                        text: 'Te quedaste sin tokens. Recarga ahora para seguir disfrutando.',
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
                                    Swal.fire('Error', data.message, 'error');
                                }
                            }
                        });
                }
            });
        }



        function sendTip() {
            const btn = document.getElementById('btnSendTip');

            if (currentAmount < 1) return;

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';

            fetch('{{ route('profiles.tip', $model->id) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    amount: currentAmount,
                    message: selectedMessage,
                    is_menu_item: isMenuItem
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: isMenuItem ? '¡Acción Pagada!' : '¡Propina enviada!',
                            text: data.message,
                            background: '#1a1a1e',
                            color: '#fff',
                            confirmButtonColor: '#d4af37'
                        }).then(() => {
                            // Reset selection
                            currentAmount = 0;
                            isMenuItem = false;
                            selectedMessage = '';
                            document.getElementById('btnSendTip').disabled = true;
                            document.getElementById('selectedActionDisplay').innerText = '';
                            document.querySelectorAll('.tip-preset-btn').forEach(b => b.classList.remove('active'));

                            // Update all balance indicators
                            const balanceValues = data.new_balance.toLocaleString();

                            const balanceHeader = document.getElementById('user-tokens-balance');
                            if (balanceHeader) balanceHeader.innerText = balanceValues;

                            const balanceSidebar = document.getElementById('sidebar-user-tokens');
                            if (balanceSidebar) balanceSidebar.innerText = balanceValues;

                            // Refresh chat logically
                            if (typeof loadPublicChatHistory === 'function') {
                                loadPublicChatHistory();
                            }

                            // Close view after 1.5s to show result or if user clicks out
                            setTimeout(() => {
                                if (isTipViewOpen) toggleTipView();
                            }, 1500);
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
                                text: data.message,
                                background: '#1a1a1e',
                                color: '#fff',
                                confirmButtonColor: '#d4af37'
                            });
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de conexión',
                        text: 'No se pudo contactar con el servidor.',
                        background: '#1a1a1e',
                        color: '#fff',
                        confirmButtonColor: '#d4af37'
                    });
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-paper-plane"></i> Enviar Tokens';
                });
        }

        function handleSubscribe(e, form) {
            e.preventDefault();
            
            const btn = form.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';

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
                        confirmButtonColor: '#d4af37',
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
                            text: data.message,
                            background: '#1a1a1e',
                            color: '#fff',
                            confirmButtonColor: '#d4af37'
                        });
                    }
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'No se pudo contactar con el servidor.',
                    background: '#1a1a1e',
                    color: '#fff',
                    confirmButtonColor: '#d4af37'
                });
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
        }
    </script>
    
    <style>
        /* Model Cards Grid Styles (Imported from welcome.blade.php) */
        .sh-models-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 24px;
            width: 100%;
            padding-bottom: 24px;
        }

        .sh-model-card {
            flex: 1 1 220px;
            max-width: 250px;
            border-radius: 12px;
            overflow: hidden;
            background: rgba(31, 31, 35, 0.5);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.05);
            display: block;
            text-decoration: none;
        }

        .sh-model-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.2);
            border-color: rgba(212, 175, 55, 0.3);
            z-index: 2;
        }

        .sh-card-image-wrapper {
            aspect-ratio: 4/5;
            position: relative;
            background: #000;
            overflow: hidden;
        }

        .sh-card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .sh-model-card:hover .sh-card-image {
            transform: scale(1.05);
        }

        .sh-live-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: #ff3b30;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
            z-index: 5;
            box-shadow: 0 2px 4px rgba(0,0,0,0.3);
            letter-spacing: 0.5px;
        }
        
        .sh-category-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(4px);
            color: #fff;
            font-size: 10px;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 4px;
            z-index: 5;
        }

        .sh-card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 40%;
            background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 16px;
        }

        .sh-model-name {
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            margin: 0 0 4px 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .sh-model-location {
            color: rgba(255, 255, 255, 0.7);
            font-size: 12px;
            font-weight: 500;
            display: flex; 
            align-items: center; 
            gap: 4px;
        }

        @media (max-width: 768px) {
            .sh-models-grid {
                gap: 16px;
                padding-bottom: 16px;
                justify-content: flex-start;
            }
            .sh-model-card {
                flex: 1 1 calc(50% - 16px);
                max-width: calc(50% - 8px);
            }
            /* Card compact style for mobile */
            .sh-card-overlay { padding: 10px; }
            .sh-model-name { font-size: 14px; }
            .sh-model-location { font-size: 10px; }
        }
    </style>


    <div id="floatingPlayerContainer" class="floating-player">
        <div class="floating-content"></div>
        <button type="button" class="close-floating" onclick="closeFloatingPlayer()" aria-label="Cerrar reproductor flotante">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const playerSection = document.querySelector('.player-aspect-ratio');
            const videoElement = document.getElementById('hlsProfilePlayer');
            const floatingContainer = document.getElementById('floatingPlayerContainer');
            const floatingContent = floatingContainer.querySelector('.floating-content');
            let isFloating = false;
            let manuallyClosed = false;

            // Safe guard if elements don't exist
            if (!playerSection || !videoElement || !floatingContainer) return;

            // observer options
            const options = {
                root: null,
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    const isPlaying = !videoElement.paused && !videoElement.ended;

                    if (!entry.isIntersecting && isPlaying && !manuallyClosed) {
                        // Enter Floating Mode
                        if (!isFloating) {
                            floatingContent.appendChild(videoElement);
                            floatingContainer.classList.add('active');
                            isFloating = true;
                            videoElement.play().catch(e => console.log('Autoplay prevent', e));
                        }
                    } else if (entry.isIntersecting) {
                        // Exit Floating Mode
                        if (isFloating) {
                            playerSection.appendChild(videoElement);
                            floatingContainer.classList.remove('active');
                            isFloating = false;
                            manuallyClosed = false;
                            videoElement.play().catch(e => console.log('Autoplay prevent', e));
                        }
                    }
                });
            }, options);

            observer.observe(playerSection);

            window.closeFloatingPlayer = function () {
                manuallyClosed = true;
                floatingContainer.classList.remove('active');
            };

            // Custom Player Controls Logic (PC Only)
            const controlsBar = document.querySelector('.player-custom-controls');
            const centerPlay = document.getElementById('playerCenterPlay');
            const playPauseBtn = document.getElementById('playerPlayPauseBtn');
            const muteBtn = document.getElementById('playerMuteBtn');
            const volSlider = document.getElementById('playerVolumeSlider');
            const fullscreenBtn = document.getElementById('playerFullscreenBtn');
            let hideTimeout;

            if (videoElement && controlsBar) {
                // Play/Pause Logic
                const togglePlay = () => {
                    if (videoElement.paused) {
                        videoElement.play();
                    } else {
                        videoElement.pause();
                    }
                };

                videoElement.addEventListener('play', () => {
                    playPauseBtn.querySelector('i').className = 'fas fa-pause';
                    centerPlay.classList.remove('visible');
                });

                videoElement.addEventListener('pause', () => {
                    playPauseBtn.querySelector('i').className = 'fas fa-play';
                    centerPlay.classList.add('visible');
                });

                playPauseBtn.addEventListener('click', togglePlay);
                centerPlay.addEventListener('click', togglePlay);
                videoElement.addEventListener('click', togglePlay);

                // Volume Logic
                volSlider.addEventListener('input', function() {
                    const val = parseFloat(this.value);
                    videoElement.volume = val;
                    videoElement.muted = (val === 0);
                    updateVolIcons();
                });

                muteBtn.addEventListener('click', () => {
                    videoElement.muted = !videoElement.muted;
                    if (!videoElement.muted && videoElement.volume === 0) videoElement.volume = 0.5;
                    updateVolIcons();
                });

                const updateVolIcons = () => {
                    const val = videoElement.muted ? 0 : videoElement.volume;
                    volSlider.value = val;
                    const icon = muteBtn.querySelector('i');
                    icon.className = 'fas';
                    if (val === 0) icon.classList.add('fa-volume-mute');
                    else if (val < 0.5) icon.classList.add('fa-volume-down');
                    else icon.classList.add('fa-volume-up');
                };

                const tryWebkitVideoFullscreen = () => {
                    const v = videoElement;
                    if (v && typeof v.webkitEnterFullscreen === 'function') {
                        try {
                            v.webkitEnterFullscreen();
                        } catch (_) {}
                    }
                };

                const enterFullscreen = () => {
                    if (document.fullscreenElement) {
                        document.exitFullscreen().catch(() => {});
                        return;
                    }
                    const v = videoElement;
                    if (v.requestFullscreen) {
                        v.requestFullscreen().catch(() => tryWebkitVideoFullscreen());
                    } else {
                        tryWebkitVideoFullscreen();
                    }
                };

                fullscreenBtn.addEventListener('click', enterFullscreen);
                fullscreenBtn.addEventListener('touchend', (e) => {
                    e.preventDefault();
                    enterFullscreen();
                }, { passive: false });

                // Autohide Logic
                const showControls = () => {
                    controlsBar.classList.add('active');
                    videoElement.style.cursor = 'default';
                    clearTimeout(hideTimeout);
                    if (!videoElement.paused) {
                        hideTimeout = setTimeout(() => {
                            controlsBar.classList.remove('active');
                            videoElement.style.cursor = 'none';
                        }, 3000);
                    }
                };

                const stage = document.querySelector('.player-aspect-ratio');
                if (stage) {
                    stage.addEventListener('mousemove', showControls);
                    stage.addEventListener('touchstart', showControls, { passive: true });
                }
                videoElement.addEventListener('play', showControls);
                
                // Initial sync
                updateVolIcons();
            }
        });
    </script>
@endsection