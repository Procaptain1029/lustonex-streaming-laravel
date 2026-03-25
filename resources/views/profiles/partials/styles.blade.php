<style>
    :root {
        --glass-bg: rgba(18, 18, 22, 0.75);
        --glass-border: rgba(212, 175, 55, 0.15);
        --accent-gold: #d4af37;
    }

    /* Layout Reset for Profile */
    .profile-wrapper {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 360px;
        gap: 1.5rem;
        padding-bottom: 3rem;
        max-width: 1440px;
        margin: 0 auto;
        padding-top: 2rem;
        position: relative;
    }

    /* Adjust for Model Dashboard (when $isOwner, the sidebar space is restricted) */
    @if($isOwner ?? false)
        .profile-wrapper {
            grid-template-columns: 1fr;
        }

        .profile-sidebar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

    @endif

    /* Fix for Guest Layout (main-content margin) */
    @if(!auth()->check() || (!auth()->user()->isModel() && !auth()->user()->isAdmin()))
        body:not(.sidebar-collapsed) .main-content {
            margin-left: 0 !important;
            width: 100% !important;
            padding-top: 20px !important;
            margin-top: 60px !important;
            /* Space for fixed header */
            position: relative !important;
            left: 0 !important;
        }

        .profile-wrapper {
            margin-top: 0;
            padding-left: 2rem;
            padding-right: 2rem;
            width: 100% !important;
            max-width: 1440px !important;
        }

    @endif

    /* 1. Profile Immersive Header */
    .profile-hero {
        position: relative;
        height: 350px;
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

    .hero-content {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 2.5rem;
        background: linear-gradient(0deg, rgba(0, 0, 0, 0.95) 0%, transparent 100%);
        z-index: 2;
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
        height: 160px;
        border-radius: 40px;
        border: 4px solid #121216;
        background: #121216;
        object-fit: cover;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
    }

    /* 2. Model Info & Badges */
    .profile-info-block {
        padding-left: 200px;
        padding-top: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .display-name {
        font-size: 2.25rem;
        font-weight: 800;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .model-username {
        color: rgba(255, 255, 255, 0.4);
        font-size: 1rem;
        margin-bottom: 0.75rem;
    }

    .badge-container {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .premium-badge {
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        display: flex;
        align-items: center;
        gap: 5px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .badge-gold {
        background: rgba(212, 175, 55, 0.1);
        color: var(--accent-gold);
        border-color: var(--glass-border);
    }

    .badge-live {
        background: rgba(220, 53, 69, 0.1);
        color: #ff4d4d;
        border-color: rgba(220, 53, 69, 0.3);
    }

    /* 3. The Stage (Player Section) */
    .stage-card {
        background: var(--glass-bg);
        border-radius: 28px;
        border: 1px solid var(--glass-border);
        overflow: hidden;
        margin-bottom: 2rem;
        max-width: 100%;
    }

    .player-window {
        width: 100%;
        aspect-ratio: 16/9;
        background: #000;
        position: relative;
    }

    #hlsProfilePlayer {
        width: 100%;
        height: 100%;
        max-width: 100%;
    }

    .offline-placeholder {
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: radial-gradient(circle, #1a1a1a 0%, #000 100%);
    }

    /* 4. Action Bar */
    .action-deck {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .btn-profile {
        padding: 0.85rem 1.75rem;
        border-radius: 16px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        cursor: pointer;
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
        text-decoration: none;
    }

    .btn-profile:hover {
        transform: translateY(-3px);
        background: rgba(255, 255, 255, 0.15);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }

    .btn-premium {
        background: var(--accent-gold);
        color: #000;
        border: none;
    }

    .btn-premium:hover {
        background: #f1c40f;
        box-shadow: 0 10px 25px rgba(212, 175, 55, 0.4);
    }

    /* 5. Sidebar Widgets */
    .sidebar-widget {
        background: var(--glass-bg);
        border-radius: 24px;
        border: 1px solid var(--glass-border);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        backdrop-filter: blur(20px);
    }

    .widget-title {
        font-size: 0.8rem;
        text-transform: uppercase;
        color: var(--accent-gold);
        letter-spacing: 1px;
        font-weight: 800;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* 6. Tabs & Content Grid */
    .content-tabs {
        display: flex;
        gap: 2rem;
        margin: 3rem 0 1.5rem;
        border-bottom: 1px solid var(--glass-border);
    }

    .tab-item {
        padding: 1rem 0;
        color: rgba(255, 255, 255, 0.5);
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        position: relative;
        transition: all 0.3s ease;
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
        border-radius: 10px 10px 0 0;
    }

    .media-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        gap: 24px;
        width: 100%;
    }

    .media-card {
        flex: 1 1 220px;
        max-width: 250px;
        background: #1a1a1e;
        border-radius: 12px;
        aspect-ratio: 4/5;
        overflow: hidden;
        position: relative;
        border: 1px solid rgba(255, 255, 255, 0.05);
        cursor: pointer;
    }

    .media-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .media-card:hover img {
        transform: scale(1.1);
    }

    .lock-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(15px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        color: var(--accent-gold);
    }

    /* Footer Sections */
    .footer-section-title {
        color: white;
        margin: 4rem 0 2rem;
        border-left: 4px solid var(--accent-gold);
        padding-left: 1rem;
        font-weight: 800;
    }

    .category-badge {
        background: rgba(255, 255, 255, 0.05);
        color: #ccc;
        padding: 8px 16px;
        border-radius: 50px;
        text-decoration: none;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .category-badge:hover {
        background: var(--accent-gold);
        color: #000;
        transform: translateY(-2px);
    }

    /* Media Queries */
    @media (max-width: 1200px) {
        .profile-wrapper {
            grid-template-columns: 1fr;
            padding: 1rem;
        }
    }

    @media (max-width: 768px) {
        .hero-avatar-area {
            left: 50%;
            transform: translateX(-50%);
            bottom: -80px;
        }

        .profile-info-block {
            padding-left: 0;
            padding-top: 90px;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .action-deck {
            flex-wrap: wrap;
            justify-content: center;
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
        font-size: 1.5rem;
        transition: transform 0.3s ease;
    }

    .fab-label {
        font-size: 0.65rem;
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

    /* Mobile responsive */
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
</style>