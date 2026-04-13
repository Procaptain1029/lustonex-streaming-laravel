<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', __('layouts.admin.title')) - Lustonex</title>
    
    
    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Raleway:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Assets managed by Vite (Caching & Versioning) -->
    @vite([
        'resources/css/premium-design.css',
        'resources/css/icons.css',
        'resources/css/app.css',
        'resources/css/sh-search-premium.css',
        'resources/js/app.js'
    ])

    <!-- Non-Critical CSS (Asynchronous Loading) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons/css/flag-icons.min.css" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'">
    
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @yield('styles')
    
    <style>
        :root {
            --admin-sidebar-width: 250px;
            --admin-header-height: 60px; /* Reducido de 80px */
            --admin-gold: #D4AF37;
            --admin-gold-hover: #F4E37D;
            --admin-glass: rgba(15, 15, 18, 0.7);
            --admin-border: rgba(212, 175, 55, 0.15);
            --admin-bg: #0B0B0D;
            --gradient-gold: linear-gradient(135deg, #D4AF37, #FFD700);
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Raleway', sans-serif;
            background: var(--admin-bg);
            color: #fff;
            overflow-x: hidden;
        }

        /* ----- GLOBAL ADMIN TYPOGRAPHY OVERRIDES ----- */
        .page-title, .page-title-main {
            color: #dab843 !important;
            font-family: 'Poppins', sans-serif !important;
            font-size: 28px !important;
            font-weight: 700 !important;
            margin-bottom: 8px !important;
            line-height: 1.2 !important;
        }

        .page-subtitle {
            color: #ffffff !important;
            opacity: 0.85 !important;
            font-size: 16px !important;
            margin-bottom: 24px !important;
        }

        a {
            color: inherit;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        a:hover {
            color: var(--admin-gold);
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* ----- SIDEBAR ----- */
        .admin-sidebar {
            width: var(--admin-sidebar-width);
            background: var(--admin-glass);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border-right: 1px solid var(--admin-border);
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 20px 0 50px rgba(0, 0, 0, 0.3);
        }

        .admin-sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .admin-sidebar::-webkit-scrollbar-thumb {
            background: rgba(212, 175, 55, 0.2);
            border-radius: 10px;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .sidebar-logo-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--admin-gold), #f4e37d);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: #000;
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.2);
        }

        .sidebar-logo-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 1rem;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, #fff, rgba(255,255,255,0.7));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-nav {
            padding: 0 1rem 2rem 1rem;
        }

        .nav-section {
            margin-bottom: 2rem;
        }

        .nav-section-title {
            padding: 0 1rem 0.8rem 1rem;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: rgba(255, 255, 255, 0.3);
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 12px;
            margin-bottom: 4px;
            position: relative;
            overflow: hidden;
        }

        .nav-item i {
            width: 20px;
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }

        .nav-item span {
            font-size: 0.95rem;
            font-weight: 500;
        }

        .nav-item:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.05);
        }

        .nav-item:hover i {
            transform: translateX(3px);
            color: var(--admin-gold);
        }

        .nav-item.active {
            background: linear-gradient(90deg, rgba(212, 175, 55, 0.15), transparent);
            color: var(--admin-gold);
            font-weight: 600;
            border-left: 3px solid var(--admin-gold);
            border-radius: 0 12px 12px 0;
        }

        .nav-item.active i {
            color: var(--admin-gold);
        }

        .nav-badge {
            margin-left: auto;
            padding: 2px 8px;
            background: var(--admin-gold);
            color: #000;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 800;
            box-shadow: 0 4px 10px rgba(212, 175, 55, 0.3);
        }

        /* ----- MAIN CONTENT ----- */
        .admin-main {
            margin-left: var(--admin-sidebar-width);
            flex: 1;
            min-height: 100vh;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .admin-header {
            height: var(--admin-header-height);
            background: rgba(11, 11, 13, 0.8);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--admin-border);
            padding: 0 1.5rem; /* Reducido de 2.5rem */
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1.5rem; /* Reducido de 2rem */
        }

        .menu-toggle {
            display: none;
            width: 40px; /* Reducido de 45px */
            height: 40px; /* Reducido de 45px */
            border-radius: 10px; /* Reducido de 12px */
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            color: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .mobile-header-logo {
            display: none;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .mobile-logo-icon {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--admin-gold);
            font-size: 1.2rem;
        }

        .mobile-logo-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 1.1rem;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, var(--admin-gold), #f4e37d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .menu-toggle:hover {
            background: rgba(212, 175, 55, 0.1);
            color: var(--admin-gold);
            border-color: var(--admin-gold);
        }

        /* Overlay for mobile */
        .admin-sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 998;
            display: none;
            opacity: 0;
            transition: all 0.3s ease;
        }

        @media (max-width: 1024px) {
            .admin-sidebar.active ~ .admin-sidebar-overlay {
                display: block;
                opacity: 1;
            }
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.03);
            padding: 8px 18px;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .breadcrumb-item {
            color: rgba(255, 255, 255, 0.4);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .breadcrumb-item:hover {
            color: #fff;
        }

        .breadcrumb-item.active {
            color: var(--admin-gold);
            font-weight: 700;
        }

        .breadcrumb-separator {
            color: rgba(255, 255, 255, 0.15);
            font-size: 0.7rem;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1.2rem; /* Reducido de 2rem */
        }

        .header-stats {
            display: flex;
            gap: 1.2rem;
        }

        .header-stat {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 16px;
            background: rgba(212, 175, 55, 0.05);
            border: 1px solid rgba(212, 175, 55, 0.1);
            border-radius: 14px;
            transition: all 0.3s ease;
        }

        .header-stat:hover {
            background: rgba(212, 175, 55, 0.1);
            transform: translateY(-2px);
        }

        .header-stat-icon {
            color: var(--admin-gold);
            font-size: 1.1rem;
        }

        .header-stat-value {
            font-weight: 800;
            color: #fff;
            font-size: 1rem;
        }

        .header-stat-label {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.4);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .admin-user {
            position: relative; /* Agregado para dropdown */
            display: flex;
            align-items: center;
            gap: 12px; /* Reducido de 14px */
            padding: 5px 5px 5px 14px; /* Reducido de 6px 6px 6px 16px */
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .admin-user:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(212, 175, 55, 0.3);
        }

        .admin-lang-btn {
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #fff;
        }

        .admin-lang-btn:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(212, 175, 55, 0.3);
        }

        .admin-user-info {
            text-align: right;
        }

        .admin-user-name {
            font-weight: 700;
            font-size: 0.85rem; /* Reducido de 0.9rem */
            color: #fff;
            display: block;
        }

        .admin-user-role {
            font-size: 0.65rem; /* Reducido de 0.7rem */
            color: var(--admin-gold);
            font-weight: 600;
            text-transform: uppercase;
        }

        .admin-user-avatar {
            width: 36px; /* Reducido de 40px */
            height: 36px; /* Reducido de 40px */
            border-radius: 50%;
            background: linear-gradient(135deg, var(--admin-gold), #f4e37d);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-weight: 800;
            font-size: 0.9rem; /* Agregado */
            border: 3px solid rgba(0, 0, 0, 0.2);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Dropdown del usuario admin */
        .admin-user-dropdown {
            position: absolute;
            top: calc(100% + 0.5rem);
            right: 0;
            width: 240px;
            background: rgba(20, 20, 20, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .admin-user.active .admin-user-dropdown,
        .admin-lang-btn.active .admin-user-dropdown {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) !important;
        }

        .admin-dropdown-header {
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .admin-dropdown-name {
            font-weight: 700;
            font-size: 0.95rem;
            color: #fff;
            display: block;
            margin-bottom: 0.25rem;
        }

        .admin-dropdown-role {
            font-size: 0.75rem;
            color: var(--admin-gold);
            font-weight: 600;
            text-transform: uppercase;
        }

        .admin-dropdown-items {
            padding: 0.5rem;
        }

        .admin-dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            cursor: pointer;
            background: transparent;
            border: none;
            width: 100%;
            text-align: left;
            font-size: 0.9rem;
        }

        .admin-dropdown-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        .admin-dropdown-item i {
            width: 16px;
            font-size: 0.95rem;
            color: var(--admin-gold);
        }

        .admin-dropdown-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 0.5rem 0;
        }

        .admin-dropdown-item.logout {
            color: #ef4444;
        }

        .admin-dropdown-item.logout:hover {
            background: rgba(239, 68, 68, 0.1);
        }

        .admin-dropdown-item.logout i {
            color: #ef4444;
        }

        .admin-content {
            padding: 2.5rem;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ----- ALERTS ----- */
        .alert {
            padding: 1.2rem 1.8rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1.2rem;
            border: 1px solid transparent;
            backdrop-filter: blur(10px);
        }

        .alert i {
            font-size: 1.4rem;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border-color: rgba(16, 185, 129, 0.2);
            color: #10b981;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }

        /* ----- RESPONSIVE ----- */
        @media (max-width: 768px) {
            .hidden-mobile {
                display: none !important;
            }
        }
        @media (max-width: 1366px) {
            :root {
                --admin-sidebar-width: 220px;
            }
            
            .sidebar-header {
                padding: 1.5rem 1rem;
            }
            
            .sidebar-logo-text {
                font-size: 1.1rem;
            }
            
            .sidebar-logo-icon {
                width: 36px;
                height: 36px;
                font-size: 1.1rem;
            }
            
            .nav-item {
                padding: 10px 12px;
                gap: 10px;
            }
            
            .nav-item span {
                font-size: 0.85rem;
            }
            
            .admin-content {
                padding: 1.5rem;
            }
        }

        @media (max-width: 1200px) {
            .header-stats {
                display: none;
            }
        }

        @media (max-width: 1024px) {
            .admin-sidebar {
                transform: translateX(-100%);
                box-shadow: none;
            }

            .admin-sidebar.active {
                transform: translateX(0);
                box-shadow: 30px 0 60px rgba(0, 0, 0, 0.8);
            }

            .admin-main {
                margin-left: 0;
            }

            .menu-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .mobile-header-logo {
                display: flex;
            }

            .admin-header {
                padding: 0 1rem;
            }
        }

        @media (max-width: 768px) {
            .breadcrumb {
                display: none;
            }

            .admin-user-info {
                display: none;
            }

            .admin-user-dropdown {
                width: 260px !important;
                right: -10px !important;
            }

            .admin-user-dropdown::before {
                content: '';
                position: absolute;
                top: -6px;
                right: 25px;
                width: 12px;
                height: 12px;
                background: rgba(20, 20, 20, 0.98);
                border-left: 1px solid rgba(212, 175, 55, 0.2);
                border-top: 1px solid rgba(212, 175, 55, 0.2);
                transform: rotate(45deg);
                z-index: -1;
            }

            #adminLocaleDropdown .admin-user-dropdown {
                width: 180px !important;
                right: -40px !important;
            }

            #adminLocaleDropdown .admin-user-dropdown::before {
                right: 55px;
            }

            .admin-content {
                padding: 1.5rem;
            }
        }
        .visible-mobile {
            display: none !important;
        }

        @media (max-width: 1024px) {
            .hidden-mobile {
                display: none !important;
            }

            .visible-mobile {
                display: block !important;
            }

            .sidebar-lang-selector {
                margin-top: auto;
                padding: 1rem 1rem 0.5rem 1rem;
                border-top: 1px solid var(--admin-border);
            }

            .sidebar-lang-options {
                display: flex;
                gap: 6px;
                margin-top: 5px;
            }

            .sidebar-lang-item {
                flex: 1;
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: center;
                gap: 5px;
                padding: 6px 4px;
                background: rgba(255, 255, 255, 0.03);
                border: 1px solid rgba(255, 255, 255, 0.05);
                border-radius: 6px;
                color: rgba(255, 255, 255, 0.6);
                font-size: 0.65rem;
                font-weight: 700;
                transition: all 0.3s ease;
                cursor: pointer;
                min-width: 0;
            }

            .sidebar-lang-item span:last-child {
                text-transform: uppercase;
            }

            .sidebar-lang-item.active {
                background: rgba(212, 175, 55, 0.1);
                border-color: var(--admin-gold);
                color: var(--admin-gold);
            }

            .sidebar-lang-item i {
                font-size: 1.1rem;
            }
        }
    </style>

</head>
<body>
    <div class="admin-container">
        <div class="admin-sidebar-overlay" onclick="toggleSidebar()"></div>
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                    <div class="sidebar-logo-icon">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <span class="sidebar-logo-text">{{ __('layouts.admin.title') }}</span>
                </a>
            </div>

            <nav class="sidebar-nav">
                
                <div class="nav-section">
                    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span>{{ __('layouts.admin.nav.dashboard') }}</span>
                    </a>
                </div>

                
                <div class="nav-section">
                    <div class="nav-section-title">{{ __('layouts.admin.nav.users') }}</div>
                    <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>{{ __('layouts.admin.nav.fans') }}</span>
                    </a>
                    <a href="{{ route('admin.models.index') }}" class="nav-item {{ request()->routeIs('admin.models.*') ? 'active' : '' }}">
                        <i class="fas fa-user-tie"></i>
                        <span>{{ __('layouts.admin.nav.models') }}</span>
                    </a>
                </div>

                
                <div class="nav-section">
                    <div class="nav-section-title">{{ __('layouts.admin.nav.content') }}</div>
                    <a href="{{ route('admin.content.photos') }}" class="nav-item {{ request()->routeIs('admin.content.photos') ? 'active' : '' }}">
                        <i class="fas fa-image"></i>
                        <span>{{ __('layouts.admin.nav.photos') }}</span>
                        @if(isset($pendingPhotosCount) && $pendingPhotosCount > 0)
                        <span class="nav-badge">{{ $pendingPhotosCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.content.videos') }}" class="nav-item {{ request()->routeIs('admin.content.videos') ? 'active' : '' }}">
                        <i class="fas fa-video"></i>
                        <span>{{ __('layouts.admin.nav.videos') }}</span>
                        @if(isset($pendingVideosCount) && $pendingVideosCount > 0)
                        <span class="nav-badge">{{ $pendingVideosCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.streams.index') }}" class="nav-item {{ request()->routeIs('admin.streams.*') ? 'active' : '' }}">
                        <i class="fas fa-broadcast-tower"></i>
                        <span>{{ __('layouts.admin.nav.streams') }}</span>
                        @if(isset($activeStreamsCount) && $activeStreamsCount > 0)
                        <span class="nav-badge" style="background: var(--color-rosa-vibrante);">{{ $activeStreamsCount }}</span>
                        @endif
                    </a>
                </div>

                
                <div class="nav-section">
                    <div class="nav-section-title">{{ __('layouts.admin.nav.verifications') }}</div>
                    <a href="{{ route('admin.verification.index') }}" class="nav-item {{ request()->routeIs('admin.verification.*') ? 'active' : '' }}">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ __('layouts.admin.nav.pending') }}</span>
                        @if(isset($pendingProfilesCount) && $pendingProfilesCount > 0)
                        <span class="nav-badge">{{ $pendingProfilesCount }}</span>
                        @endif
                    </a>
                </div>

                
                <div class="nav-section">
                    <div class="nav-section-title">{{ __('layouts.admin.nav.gamification') }}</div>
                    <a href="{{ route('admin.gamification.levels.index') }}" class="nav-item {{ request()->routeIs('admin.gamification.levels.*') ? 'active' : '' }}">
                        <i class="fas fa-layer-group"></i>
                        <span>{{ __('layouts.admin.nav.levels') }}</span>
                    </a>
                    <a href="{{ route('admin.gamification.missions.index') }}" class="nav-item {{ request()->routeIs('admin.gamification.missions.*') ? 'active' : '' }}">
                        <i class="fas fa-tasks"></i>
                        <span>{{ __('layouts.admin.nav.missions') }}</span>
                    </a>
                    <a href="{{ route('admin.gamification.achievements.index') }}" class="nav-item {{ request()->routeIs('admin.gamification.achievements.*') ? 'active' : '' }}">
                        <i class="fas fa-trophy"></i>
                        <span>{{ __('layouts.admin.nav.achievements') }}</span>
                    </a>
                    <a href="{{ route('admin.gamification.badges.index') }}" class="nav-item {{ request()->routeIs('admin.gamification.badges.*') ? 'active' : '' }}">
                        <i class="fas fa-award"></i>
                        <span>{{ __('layouts.admin.nav.badges') }}</span>
                    </a>
                    <a href="{{ route('admin.gamification.xp-settings.index') }}" class="nav-item {{ request()->routeIs('admin.gamification.xp-settings.*') ? 'active' : '' }}">
                        <i class="fas fa-sliders-h"></i>
                        <span>{{ __('layouts.admin.nav.config_xp') }}</span>
                    </a>
                  
                </div>

                
                <div class="nav-section">
                    <div class="nav-section-title">{{ __('layouts.admin.nav.finance') }}</div>
                    <a href="{{ route('admin.finance.subscriptions') }}" class="nav-item {{ request()->routeIs('admin.finance.subscriptions') ? 'active' : '' }}">
                        <i class="fas fa-crown"></i>
                        <span>{{ __('layouts.admin.nav.subscriptions') }}</span>
                    </a>
                    <a href="{{ route('admin.finance.tips') }}" class="nav-item {{ request()->routeIs('admin.finance.tips') ? 'active' : '' }}">
                        <i class="fas fa-coins"></i>
                        <span>{{ __('layouts.admin.nav.tips') }}</span>
                    </a>
                    <a href="{{ route('admin.withdrawals.index') }}" class="nav-item {{ request()->routeIs('admin.withdrawals.*') ? 'active' : '' }}">
                        <i class="fas fa-money-bill-wave"></i>
                        <span>{{ __('layouts.admin.nav.withdrawals') }}</span>
                    </a>
                    <a href="{{ route('admin.tokens.index') }}" class="nav-item {{ request()->routeIs('admin.tokens.*') ? 'active' : '' }}">
                        <i class="fas fa-gem"></i>
                        <span>{{ __('layouts.admin.nav.tokens') }}</span>
                    </a>
                    <a href="{{ route('admin.token-packages.index') }}" class="nav-item {{ request()->routeIs('admin.token-packages.*') ? 'active' : '' }}">
                        <i class="fas fa-box"></i>
                        <span>{{ __('layouts.admin.nav.packages') }}</span>
                    </a>
                    <a href="{{ route('admin.finance.index') }}" class="nav-item {{ request()->routeIs('admin.finance.index') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie"></i>
                        <span>{{ __('layouts.admin.nav.revenue') }}</span>
                    </a>
                </div>

                
                <div class="nav-section">
                    <div class="nav-section-title">{{ __('layouts.admin.nav.system') }}</div>
                    <a href="{{ route('admin.reports.index') }}" class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <i class="fas fa-flag"></i>
                        <span>{{ __('layouts.admin.nav.reports') }}</span>
                    </a>
                    <a href="{{ route('admin.analytics.index') }}" class="nav-item {{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>{{ __('layouts.admin.nav.analytics') }}</span>
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                                    <span>{{ __('layouts.admin.nav.settings') }}</span>
                    </a>
                    <a href="{{ route('admin.logs.index') }}" class="nav-item {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}">
                        <i class="fas fa-history"></i>
                        <span>{{ __('layouts.admin.nav.activity_logs') }}</span>
                    </a>
                    <a href="{{ route('admin.reports.exports.index') }}" class="nav-item {{ request()->routeIs('admin.reports.exports.*') ? 'active' : '' }}">
                        <i class="fas fa-file-export"></i>
                        <span>{{ __('layouts.admin.nav.exports') }}</span>
                    </a>
                </div>

                <!-- Selector de Idioma Móvil (Compact) -->
                <div class="nav-section visible-mobile sidebar-lang-selector">
                    <div class="sidebar-lang-options">
                        @php $currentLocale = app()->getLocale(); @endphp
                        
                        <form method="POST" action="{{ route('locale.update') }}" id="sidebar-form-locale-es">
                            @csrf
                            <input type="hidden" name="locale" value="es">
                            <div onclick="document.getElementById('sidebar-form-locale-es').submit()" class="sidebar-lang-item {{ $currentLocale == 'es' ? 'active' : '' }}">
                                <span class="fi fi-es"></span>
                                <span>ES</span>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('locale.update') }}" id="sidebar-form-locale-en">
                            @csrf
                            <input type="hidden" name="locale" value="en">
                            <div onclick="document.getElementById('sidebar-form-locale-en').submit()" class="sidebar-lang-item {{ $currentLocale == 'en' ? 'active' : '' }}">
                                <span class="fi fi-us"></span>
                                <span>EN</span>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('locale.update') }}" id="sidebar-form-locale-pt_BR">
                            @csrf
                            <input type="hidden" name="locale" value="pt_BR">
                            <div onclick="document.getElementById('sidebar-form-locale-pt_BR').submit()" class="sidebar-lang-item {{ $currentLocale == 'pt_BR' ? 'active' : '' }}">
                                <span class="fi fi-br"></span>
                                <span>PT</span>
                            </div>
                        </form>
                    </div>
                </div>
            </nav>
        </aside>

        
        <main class="admin-main">
            
            <header class="admin-header">
                <div class="header-left">
                    <button class="menu-toggle" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>

                    <a href="{{ route('admin.dashboard') }}" class="mobile-header-logo">
                        <div class="mobile-logo-icon">
                            <i class="fas fa-shield-halved"></i>
                        </div>
                        <span class="mobile-logo-text">{{ __('layouts.admin.title') }}</span>
                    </a>
                    
                    <div class="breadcrumb">
                        @yield('breadcrumb')
                    </div>
                </div>

                <div class="header-right">
                    <div class="header-stats">
                        @yield('header-stats')
                    </div>

                    <div class="admin-lang-btn hidden-mobile" id="adminLocaleDropdown" onclick="toggleAdminLocaleDropdown(event)">
                        @php $currentLocale = app()->getLocale(); @endphp
                        
                        @if($currentLocale == 'es') <span class="fi fi-es" style="border-radius: 2px; font-size: 1.1rem;"></span>
                        @elseif($currentLocale == 'en') <span class="fi fi-us" style="border-radius: 2px; font-size: 1.1rem;"></span>
                        @elseif($currentLocale == 'pt_BR') <span class="fi fi-br" style="border-radius: 2px; font-size: 1.1rem;"></span>
                        @endif
                        
                        <span class="hidden-mobile" style="font-weight: 600; font-size: 0.8rem;">
                            @if($currentLocale == 'es') Español
                            @elseif($currentLocale == 'en') English
                            @elseif($currentLocale == 'pt_BR') Português (BR)
                            @endif
                        </span>
                        
                        <i class="fas fa-chevron-down hidden-mobile" style="font-size: 0.6rem; color: rgba(255,255,255,0.5); margin-left: 2px;"></i>
                        
                        <div class="admin-user-dropdown" style="width: 150px; right: 0;">
                            <div class="admin-dropdown-items" style="padding: 0.5rem;">
                                <form method="POST" action="{{ route('locale.update') }}" id="admin-form-locale-es">
                                    @csrf
                                    <input type="hidden" name="locale" value="es">
                                    <button type="button" onclick="document.getElementById('admin-form-locale-es').submit()" class="admin-dropdown-item" style="{{ $currentLocale == 'es' ? 'color: var(--admin-gold);' : '' }}">
                                        <span class="fi fi-es"></span> <span>Español</span>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('locale.update') }}" id="admin-form-locale-en">
                                    @csrf
                                    <input type="hidden" name="locale" value="en">
                                    <button type="button" onclick="document.getElementById('admin-form-locale-en').submit()" class="admin-dropdown-item" style="{{ $currentLocale == 'en' ? 'color: var(--admin-gold);' : '' }}">
                                        <span class="fi fi-us"></span> <span>English</span>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('locale.update') }}" id="admin-form-locale-pt_BR">
                                    @csrf
                                    <input type="hidden" name="locale" value="pt_BR">
                                    <button type="button" onclick="document.getElementById('admin-form-locale-pt_BR').submit()" class="admin-dropdown-item" style="{{ $currentLocale == 'pt_BR' ? 'color: var(--admin-gold);' : '' }}">
                                        <span class="fi fi-br"></span> <span>Português</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="admin-user" id="adminUserDropdown" onclick="toggleAdminDropdown(event)">
                        <div class="admin-user-info">
                            <span class="admin-user-name"><p style="font-size: 0.75rem; font-weight: 700; color: rgba(255, 255, 255, 0.4);">{{ auth()->user()->name }}</p></span>
                            
                        </div>
                        <div class="admin-user-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        
                        
                        <div class="admin-user-dropdown">
                            <div class="admin-dropdown-header">
                                <span class="admin-dropdown-name">{{ auth()->user()->name }}</span>
                            </div>
                            
                            <div class="admin-dropdown-items">
                                <a href="{{ route('admin.settings.index') }}" class="admin-dropdown-item">
                                    <i class="fas fa-cog"></i>
                                                <span>{{ __('layouts.admin.nav.settings') }}</span>
                                </a>
                               
                            </div>
                            
                            <div class="admin-dropdown-divider"></div>
                            
                            <div class="admin-dropdown-items">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="admin-dropdown-item logout">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>{{ __('layouts.admin.nav.logout') }}</span>
                                    </button>
                                </form>
                            </div>
                            
                            </div>
                        </div>
                    </div>
            </header>

            
            <div class="admin-content">
                @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                @if(session('info'))
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <span>{{ session('info') }}</span>
                </div>
                @endif

                @if(session('warning'))
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>{{ session('warning') }}</span>
                </div>
                @endif

                @yield('content')
            </div>
            
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('adminSidebar').classList.toggle('active');
        }

        // Toggle admin user dropdown
        function toggleAdminDropdown(event) {
            if (event) {
                event.stopPropagation();
            }
            
            const dropdown = document.getElementById('adminUserDropdown');
            const localeDropdown = document.getElementById('adminLocaleDropdown');
            
            if (localeDropdown && localeDropdown.classList.contains('active')) {
                localeDropdown.classList.remove('active');
            }

            dropdown.classList.toggle('active');
            
            if (dropdown.classList.contains('active')) {
                document.addEventListener('click', closeAdminDropdownOnOutsideClick);
            } else {
                document.removeEventListener('click', closeAdminDropdownOnOutsideClick);
            }
        }

        function closeAdminDropdownOnOutsideClick(event) {
            const dropdown = document.getElementById('adminUserDropdown');
            
            if (dropdown && !dropdown.contains(event.target)) {
                dropdown.classList.remove('active');
                document.removeEventListener('click', closeAdminDropdownOnOutsideClick);
            }
        }

        function toggleAdminLocaleDropdown(event) {
            if (event) {
                event.stopPropagation();
            }
            
            const localeDropdown = document.getElementById('adminLocaleDropdown');
            const userDropdown = document.getElementById('adminUserDropdown');
            
            if (userDropdown && userDropdown.classList.contains('active')) {
                userDropdown.classList.remove('active');
            }

            localeDropdown.classList.toggle('active');
            
            if (localeDropdown.classList.contains('active')) {
                document.addEventListener('click', closeAdminLocaleDropdownOnOutsideClick);
            } else {
                document.removeEventListener('click', closeAdminLocaleDropdownOnOutsideClick);
            }
        }

        function closeAdminLocaleDropdownOnOutsideClick(event) {
            const localeDropdown = document.getElementById('adminLocaleDropdown');
            
            if (localeDropdown && !localeDropdown.contains(event.target)) {
                localeDropdown.classList.remove('active');
                document.removeEventListener('click', closeAdminLocaleDropdownOnOutsideClick);
            }
        }

        // Close dropdown with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const dropdown = document.getElementById('adminUserDropdown');
                const localeDropdown = document.getElementById('adminLocaleDropdown');
                if (dropdown && dropdown.classList.contains('active')) {
                    dropdown.classList.remove('active');
                    document.removeEventListener('click', closeAdminDropdownOnOutsideClick);
                }
                if (localeDropdown && localeDropdown.classList.contains('active')) {
                    localeDropdown.classList.remove('active');
                    document.removeEventListener('click', closeAdminLocaleDropdownOnOutsideClick);
                }
            }
        });

        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('adminSidebar');
            const toggle = document.querySelector('.menu-toggle');
            
            if (window.innerWidth <= 1024) {
                if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });

        // Auto-scroll active menu item into view securely and instantly
        document.addEventListener('DOMContentLoaded', function() {
            const activeItem = document.querySelector('.nav-item.active');
            if (activeItem) {
                // Remove 'behavior: smooth' to eliminate the visible scroll effect on load
                activeItem.scrollIntoView({ block: 'center' });
                
                // Prevent reloading the same page when clicking the active item
                activeItem.addEventListener('click', function(e) {
                    e.preventDefault();
                });
            }

            // Auto-dismiss alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => alert.remove(), 500); // Remove from DOM after fade out
                }, 5000);
            });
        });
    </script>

    @yield('scripts')
    @include('partials.csrf-refresh')
</body>
</html>
