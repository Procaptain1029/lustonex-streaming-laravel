<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', __('layouts.model.title')) - Lustonex</title>

    
    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">

    <!-- Preload Critical Assets -->
    <link rel="preload" href="{{ asset('css/premium-design.css') }}" as="style">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/webfonts/fa-solid-900.woff2" as="font" type="font/woff2" crossorigin>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Raleway:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Critical CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/premium-design.css') }}">

    <!-- Non-Critical CSS (Asynchronous Loading) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons/css/flag-icons.min.css" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{ asset('css/icons.css') }}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{ asset('css/sh-search-premium.css') }}" media="print" onload="this.media='all'">

    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('styles')

    <style>
        :root {
            --model-sidebar-width: 220px;
            --model-header-height: 55px;
            /* Modificado de 60px */
            --model-gold: #D4AF37;
            --model-gold-hover: #F4E37D;
            --model-glass: rgba(15, 15, 18, 0.7);
            --model-border: rgba(212, 175, 55, 0.15);
            --model-bg: #0B0B0D;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Raleway', sans-serif;
            background: var(--model-bg);
            color: #fff;
            overflow-x: hidden;
        }

        /* ----- GLOBAL MODEL TYPOGRAPHY OVERRIDES ----- */
        .page-title, .page-title-main, #withdrawals-view .page-title {
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

        @media (max-width: 768px) {
            .page-title {
                font-size: 20px !important;
            }
            .page-subtitle {
                font-size: 14px !important;
            }
        }

        a {
            color: inherit;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        a:hover {
            color: var(--model-gold);
        }

        .model-container {
            display: flex;
            min-height: 100vh;
        }

        /* ----- SIDEBAR ----- */
        .model-sidebar {
            width: var(--model-sidebar-width);
            background: var(--model-glass);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border-right: 1px solid var(--model-border);
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 20px 0 50px rgba(0, 0, 0, 0.3);
        }

        .model-sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .model-sidebar::-webkit-scrollbar-thumb {
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
            flex-grow: 1; /* Forzar al logo a tomar todo el espacio en desktop */
        }

        .sidebar-logo-icon {
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sidebar-logo-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 1.4rem;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, var(--model-gold), #f4e37d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-close {
            display: none;
            background: transparent;
            border: none;
            color: rgba(255,255,255,0.6);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 5px;
            transition: color 0.3s;
        }

        .sidebar-close:hover {
            color: var(--model-gold);
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
            color: var(--model-gold);
        }

        .nav-item.active {
            background: linear-gradient(90deg, rgba(212, 175, 55, 0.15), transparent);
            color: var(--model-gold);
            font-weight: 600;
            border-left: 3px solid var(--model-gold);
            border-radius: 0 12px 12px 0;
        }

        .nav-item.active i {
            color: var(--model-gold);
        }

        .nav-badge {
            margin-left: auto;
            padding: 2px 8px;
            background: var(--model-gold);
            color: #000;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 800;
            box-shadow: 0 4px 10px rgba(212, 175, 55, 0.3);
        }

        /* ----- MAIN CONTENT ----- */
        .model-main {
            margin-left: var(--model-sidebar-width);
            flex: 1;
            min-height: 100vh;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .model-header {
            height: var(--model-header-height);
            background: rgba(11, 11, 13, 0.8);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--model-border);
            padding: 0 1.5rem;
            /* Reducido de 2.5rem */
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
            gap: 1.5rem;
            /* Reducido de 2rem */
        }

        .menu-toggle {
            display: none;
            width: 40px;
            /* Reducido de 45px */
            height: 40px;
            /* Reducido de 45px */
            border-radius: 10px;
            /* Reducido de 12px */
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
        }

        .mobile-logo-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 1.2rem;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, var(--model-gold), #f4e37d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .menu-toggle:hover {
            background: rgba(212, 175, 55, 0.1);
            color: var(--model-gold);
            border-color: var(--model-gold);
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
            color: var(--model-gold);
            font-weight: 700;
        }

        .breadcrumb-separator {
            color: rgba(255, 255, 255, 0.15);
            font-size: 0.7rem;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1.2rem;
            /* Reducido de 2rem */
        }

        .header-stats {
            display: flex;
            gap: 1.2rem;
        }

        /* ----- NOTIFICATION COMPACT (from header-unified) ----- */
        .btn-notification-compact {
            position: relative;
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: rgba(255, 255, 255, 0.7);
            transition: all 0.2s ease;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-notification-compact:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .notification-count {
            position: absolute;
            top: -2px;
            right: -2px;
            min-width: 18px;
            height: 18px;
            padding: 0 4px;
            background: #ef4444;
            color: #fff;
            font-size: 0.625rem;
            font-weight: 700;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #0a0a0a;
        }

        .user-menu-compact {
            position: relative;
        }

        .user-menu-dropdown.notification-dropdown {
            width: 320px;
        }
        
        .user-menu-dropdown {
            position: absolute;
            top: calc(100% + 0.5rem);
            right: 0;
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
            text-align: left;
        }

        .user-menu-compact.active .user-menu-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-header-compact {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
        }

        .dropdown-divider-compact {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 0;
        }

        .dropdown-items-compact {
            padding: 0.5rem;
            max-height: 300px;
            overflow-y: auto;
        }

        .dropdown-item-compact {
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

        .dropdown-item-compact:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
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
            color: var(--model-gold);
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

        .model-user {
            position: relative;
            /* Agregado para dropdown */
            display: flex;
            align-items: center;
            gap: 12px;
            /* Reducido de 14px */
            padding: 5px 5px 5px 14px;
            /* Reducido de 6px 6px 6px 16px */
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .model-lang-btn {
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

        .model-lang-btn:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(212, 175, 55, 0.3);
        }

        .model-lang-btn.active .user-menu-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .model-user:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(212, 175, 55, 0.3);
        }

        .model-user-info {
            text-align: right;
        }

        .model-user-name {
            font-weight: 700;
            font-size: 0.85rem;
            /* Reducido de 0.9rem */
            color: #fff;
            display: block;
        }

        .model-user-role {
            font-size: 0.65rem;
            /* Reducido de 0.7rem */
            color: var(--model-gold);
            font-weight: 600;
            text-transform: uppercase;
        }

        .model-user-avatar {
            width: 36px;
            /* Reducido de 40px */
            height: 36px;
            /* Reducido de 40px */
            border-radius: 50%;
            background: linear-gradient(135deg, var(--model-gold), #f4e37d);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-weight: 800;
            font-size: 0.9rem;
            /* Agregado */
            border: 3px solid rgba(0, 0, 0, 0.2);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Dropdown del usuario modelo */
        .model-user-dropdown {
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

        .model-user.active .model-user-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .model-dropdown-header {
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .model-dropdown-name {
            font-weight: 700;
            font-size: 0.95rem;
            color: #fff;
            display: block;
            margin-bottom: 0.25rem;
        }

        .model-dropdown-role {
            font-size: 0.75rem;
            color: var(--model-gold);
            font-weight: 600;
            text-transform: uppercase;
        }

        .model-dropdown-items {
            padding: 0.5rem;
        }

        .model-dropdown-item {
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

        .model-dropdown-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        .model-dropdown-item i {
            width: 16px;
            font-size: 0.95rem;
            color: var(--model-gold);
        }

        .model-dropdown-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 0.5rem 0;
        }

        .model-dropdown-item.logout {
            color: #ef4444;
        }

        .model-dropdown-item.logout:hover {
            background: rgba(239, 68, 68, 0.1);
        }

        .model-dropdown-item.logout i {
            color: #ef4444;
        }

        .model-content {
            padding: 0 2.5rem;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        .alert-info {
            background: rgba(59, 130, 246, 0.1);
            border-color: rgba(59, 130, 246, 0.2);
            color: #3b82f6;
        }

        /* ----- RESPONSIVE ----- */
        @media (max-width: 1300px) {
            .header-stats {
                display: none;
            }

            .sidebar-logo-text {
                font-size: 1.1rem;
            }

            .nav-item {
                padding: 10px 12px;
            }

            .nav-item span {
                font-size: 0.85rem;
            }

            .model-content {
                padding: 0 1.5rem;
            }
        }

        @media (max-width: 1024px) {
            .model-sidebar {
                transform: translateX(-100%);
                box-shadow: none;
                width: 260px; /* Un poco más ancho en móvil */
            }

            .model-sidebar.active {
                transform: translateX(0);
                box-shadow: 30px 0 60px rgba(0, 0, 0, 0.8);
            }

            .model-main {
                margin-left: 0;
            }

            .sidebar-close {
                display: block; /* Mostrar botón de cerrar en móvil */
            }

            .menu-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .mobile-header-logo {
                display: flex;
            }

            .model-header {
                padding: 0 1rem;
            }
        }

        @media (max-width: 768px) {
            .breadcrumb {
                display: none;
            }

            .header-right {
                gap: 0.5rem; /* Ajustar el gap para que quepa en móvil */
            }

            .model-user-info {
                display: none;
            }

            /* Dropdowns adjustments for mobile */
            .user-menu-dropdown.notification-dropdown {
                width: 280px; 
                right: -60px; /* Centrar un poco más en móviles pequeños */
            }

            /* Puntero para la ventana */
            .user-menu-dropdown.notification-dropdown::before {
                content: '';
                position: absolute;
                top: -6px;
                right: 75px; /* Alineado al icono */
                width: 12px;
                height: 12px;
                background: rgba(20, 20, 20, 0.98);
                border-left: 1px solid rgba(212, 175, 55, 0.2);
                border-top: 1px solid rgba(212, 175, 55, 0.2);
                transform: rotate(45deg);
                z-index: -1;
            }

            .model-user-dropdown {
                width: 200px;
                right: 0px;
                z-index: 9999; /* Forzar que gane jerarquía en móvil sobre cualquier superposición abstracta */
            }
            
            /* Asegurar que el Header no enjaule los dropdowns */
            .model-header {
                z-index: 105;
            }

            .model-content {
                padding: 1.5rem 1rem;
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
            .sidebar-nav {
                display: flex;
                flex-direction: column;
                min-height: calc(100vh - 100px);
            }
            .sidebar-lang-selector {
                margin-top: auto;
                padding: 1.5rem 1rem 0.5rem 1rem;
                border-top: 1px solid var(--model-border);
            }
            .sidebar-lang-options {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
                margin-top: 10px;
            }
            .sidebar-lang-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 6px;
                padding: 10px 5px;
                background: rgba(255, 255, 255, 0.03);
                border: 1px solid rgba(255, 255, 255, 0.05);
                border-radius: 12px;
                color: rgba(255, 255, 255, 0.6);
                font-size: 0.7rem;
                font-weight: 600;
                transition: all 0.3s ease;
                cursor: pointer;
            }
            .sidebar-lang-item.active {
                background: rgba(212, 175, 55, 0.1);
                border-color: var(--model-gold);
                color: var(--model-gold);
            }
            .sidebar-lang-item i {
                font-size: 1.1rem;
            }
        }
    </style>
</head>

<body>
    <div class="model-container">
        
        <aside class="model-sidebar" id="modelSidebar">
            <div class="sidebar-header">
                <a href="{{ route('model.dashboard') }}" class="sidebar-logo">
                    <div class="sidebar-logo-icon">
                        <svg width="34" height="34" viewBox="0 0 28 28" fill="none">
                            <path d="M14 3L3 8.75V19.25L14 25L25 19.25V8.75L14 3Z" fill="url(#logoGradientSidebar)" />
                            <circle cx="14" cy="14" r="5.25" fill="#0B0B0D" />
                            <circle cx="14" cy="14" r="2.625" fill="url(#logoGradientSidebar)" />
                            <defs>
                                <linearGradient id="logoGradientSidebar" x1="3" y1="3" x2="25" y2="25">
                                    <stop offset="0%" stop-color="#D4AF37" />
                                    <stop offset="100%" stop-color="#FFD700" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                    <span class="sidebar-logo-text">Lustonex</span>
                </a>
                <button class="sidebar-close" onclick="toggleSidebar()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <nav class="sidebar-nav">
                
                <div class="nav-section">
                    <a href="{{ route('model.dashboard') }}"
                        class="nav-item {{ request()->routeIs('model.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i>
                        <span>{{ __('layouts.model.nav.dashboard') }}</span>
                    </a>
                </div>

                
                <div class="nav-section">
                    <div class="nav-section-title">{{ __('layouts.model.nav.content') }}</div>
                    <a href="{{ route('model.photos.index') }}"
                        class="nav-item {{ request()->routeIs('model.photos.*') ? 'active' : '' }}">
                        <i class="fas fa-images"></i>
                        <span>{{ __('layouts.model.nav.photos') }}</span>
                    </a>
                    <a href="{{ route('model.videos.index') }}"
                        class="nav-item {{ request()->routeIs('model.videos.*') ? 'active' : '' }}">
                        <i class="fas fa-video"></i>
                        <span>{{ __('layouts.model.nav.videos') }}</span>
                    </a>
                    <a href="{{ route('model.streams.index') }}"
                        class="nav-item {{ request()->routeIs('model.streams.*') ? 'active' : '' }}">
                        <i class="fas fa-broadcast-tower"></i>
                        <span>{{ __('layouts.model.nav.streams') }}</span>
                    </a>
                    <a href="{{ route('model.chat.index') }}"
                        class="nav-item {{ request()->routeIs('model.chat.*') ? 'active' : '' }}">
                        <i class="fas fa-envelope"></i>
                        <span>{{ __('layouts.model.nav.messages') }}</span>
                    </a>
                </div>

                
                <div class="nav-section">
                    <div class="nav-section-title">{{ __('layouts.model.nav.finance') }}</div>
                    <a href="{{ route('model.earnings.index') }}"
                        class="nav-item {{ request()->routeIs('model.earnings.*') ? 'active' : '' }}">
                        <i class="fas fa-wallet"></i>
                        <span>{{ __('layouts.model.nav.earnings') }}</span>
                    </a>
                    <a href="{{ route('model.withdrawals.index') }}"
                        class="nav-item {{ request()->routeIs('model.withdrawals.*') ? 'active' : '' }}">
                        <i class="fas fa-hand-holding-usd"></i>
                        <span>{{ __('layouts.model.nav.withdrawals') }}</span>
                    </a>
                    <a href="{{ route('model.analytics.index') }}"
                        class="nav-item {{ request()->routeIs('model.analytics.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span>{{ __('layouts.model.nav.analytics') }}</span>
                    </a>
                    <a href="{{ route('model.exports.index') }}"
                        class="nav-item {{ request()->routeIs('model.exports.*') ? 'active' : '' }}">
                        <i class="fas fa-file-export"></i>
                        <span>{{ __('layouts.model.nav.exports') }}</span>
                    </a>
                </div>

                
                <div class="nav-section">
                    <div class="nav-section-title">{{ __('layouts.model.nav.gamification') }}</div>
                    <a href="{{ route('model.missions.index') }}"
                        class="nav-item {{ request()->routeIs('model.missions.*') ? 'active' : '' }}">
                        <i class="fas fa-tasks"></i>
                        <span>{{ __('layouts.model.nav.missions') }}</span>
                    </a>
                    <a href="{{ route('model.achievements.index') }}"
                        class="nav-item {{ request()->routeIs('model.achievements.*') ? 'active' : '' }}">
                        <i class="fas fa-trophy"></i>
                        <span>{{ __('layouts.model.nav.achievements') }}</span>
                    </a>
                    <a href="{{ route('model.leaderboard.index') }}"
                        class="nav-item {{ request()->routeIs('model.leaderboard.*') ? 'active' : '' }}">
                        <i class="fas fa-crown"></i>
                        <span>{{ __('layouts.model.nav.leaderboard') }}</span>
                    </a>
                </div>

                
                <div class="nav-section">
                    <div class="nav-section-title">{{ __('layouts.model.nav.settings') }}</div>
                    <a href="{{ route('model.profile.edit') }}"
                        class="nav-item {{ request()->routeIs('model.profile.edit') ? 'active' : '' }}">
                        <i class="fas fa-user-edit"></i>
                        <span>{{ __('layouts.model.nav.edit_profile') }}</span>
                    </a>
                    <a href="{{ route('model.profile.settings') }}"
                        class="nav-item {{ request()->routeIs('model.profile.settings') ? 'active' : '' }}">
                        <i class="fas fa-user-cog"></i>
                        <span>{{ __('layouts.model.nav.adjustments') }}</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" class="nav-item"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>{{ __('layouts.model.nav.logout') }}</span>
                        </a>
                    </form>
                </div>

                <!-- Selector de Idioma Móvil -->
                <div class="nav-section visible-mobile sidebar-lang-selector">
                    <div class="nav-section-title">Seleccionar Idioma</div>
                    <div class="sidebar-lang-options">
                        @php $currentLocale = app()->getLocale(); @endphp
                        
                        <form method="POST" action="{{ route('locale.update') }}" id="sidebar-form-locale-es">
                            @csrf
                            <input type="hidden" name="locale" value="es">
                            <div onclick="document.getElementById('sidebar-form-locale-es').submit()" class="sidebar-lang-item {{ $currentLocale == 'es' ? 'active' : '' }}">
                                <span class="fi fi-es"></span>
                                <span>Español</span>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('locale.update') }}" id="sidebar-form-locale-en">
                            @csrf
                            <input type="hidden" name="locale" value="en">
                            <div onclick="document.getElementById('sidebar-form-locale-en').submit()" class="sidebar-lang-item {{ $currentLocale == 'en' ? 'active' : '' }}">
                                <span class="fi fi-us"></span>
                                <span>English</span>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('locale.update') }}" id="sidebar-form-locale-pt_BR">
                            @csrf
                            <input type="hidden" name="locale" value="pt_BR">
                            <div onclick="document.getElementById('sidebar-form-locale-pt_BR').submit()" class="sidebar-lang-item {{ $currentLocale == 'pt_BR' ? 'active' : '' }}">
                                <span class="fi fi-br"></span>
                                <span>Português</span>
                            </div>
                        </form>
                    </div>
                </div>
            </nav>
        </aside>

        
        <main class="model-main">
            
            <header class="model-header">
                <div class="header-left">
                    <button class="menu-toggle" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <a href="{{ route('model.dashboard') }}" class="mobile-header-logo">
                        <div class="mobile-logo-icon">
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                                <path d="M14 3L3 8.75V19.25L14 25L25 19.25V8.75L14 3Z" fill="url(#logoGradientMobile)" />
                                <circle cx="14" cy="14" r="5.25" fill="#0B0B0D" />
                                <circle cx="14" cy="14" r="2.625" fill="url(#logoGradientMobile)" />
                                <defs>
                                    <linearGradient id="logoGradientMobile" x1="3" y1="3" x2="25" y2="25">
                                        <stop offset="0%" stop-color="#D4AF37" />
                                        <stop offset="100%" stop-color="#FFD700" />
                                    </linearGradient>
                                </defs>
                            </svg>
                        </div>
                        <span class="mobile-logo-text">Lustonex</span>
                    </a>

                    <div class="breadcrumb">
                        @yield('breadcrumb')
                    </div>
                </div>

                <div class="header-right">
                    <div class="header-stats">
                        @yield('header-stats')
                    </div>

                    <!-- Notificaciones del Modelo -->
                    <div class="user-menu-compact" id="notificationDropdown">
                        <button class="btn-notification-compact" onclick="toggleNotificationDropdown(event)">
                            <i class="fas fa-bell"></i>
                            @php
                                $unreadCount = auth()->user()->unreadNotifications()->count();
                                $recentNotifications = auth()->user()->notifications()->take(5)->get();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="notification-count">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                            @endif
                        </button>

                        <div class="user-menu-dropdown notification-dropdown" id="notificationDropdownMenu">
                            <div class="dropdown-header-compact">
                                <span style="font-weight: 700; color: #fff;">{{ __('layouts.navigation.notifications') }}</span>
                                <button onclick="markAllNotificationsReadDropdown(event)"
                                    style="background: none; border: none; color: #D4AF37; font-size: 0.75rem; font-weight: 600; cursor: pointer;">
                                    {{ __('fan.notifications.mark_all_read') }}
                                </button>
                            </div>
                            <div class="dropdown-divider-compact"></div>

                            <div class="dropdown-items-compact">
                                @forelse($recentNotifications as $notification)
                                    @php $data = $notification->data; @endphp
                                    <a href="{{ route('model.notifications.index') }}" class="dropdown-item-compact"
                                        style="align-items: flex-start; gap: 10px; {{ is_null($notification->read_at) ? 'background: rgba(212, 175, 55, 0.05);' : '' }}">
                                        <div
                                            style="width: 32px; height: 32px; border-radius: 50%; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #D4AF37;">
                                            <i class="fas {{ $data['icon'] ?? 'fa-bell' }}" style="font-size: 0.8rem;"></i>
                                        </div>
                                        <div style="flex: 1;">
                                            <div
                                                style="color: #fff; font-size: 0.85rem; font-weight: 600; line-height: 1.2; margin-bottom: 2px;">
                                                {{ $data['title'] ?? __('layouts.navigation.notifications') }}
                                            </div>
                                            <div style="color: rgba(255,255,255,0.6); font-size: 0.75rem; line-height: 1.3;">
                                                {{ Str::limit($data['message'] ?? '', 40) }}
                                            </div>
                                            <div style="color: rgba(255,255,255,0.4); font-size: 0.65rem; margin-top: 4px;">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div
                                        style="padding: 1.5rem; text-align: center; color: rgba(255,255,255,0.4); font-size: 0.85rem;">
                                        {{ __('fan.notifications.empty_title') }}
                                    </div>
                                @endforelse
                            </div>

                            <div class="dropdown-divider-compact"></div>
                            <a href="{{ route('model.notifications.index') }}" class="dropdown-item-compact"
                                style="justify-content: center; color: #D4AF37; font-size: 0.8rem;">
                                {{ __('admin.finance.balance.tables.view_all') }}
                            </a>
                        </div>
                    </div>

                    <!-- Selector de Idioma -->
                    <div class="model-lang-btn hidden-mobile" id="modelLocaleDropdown" onclick="toggleModelLocaleDropdown(event)">
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
                        
                        <div class="user-menu-dropdown" style="width: 150px; right: 0;">
                            <div class="dropdown-items-compact" style="padding: 0.5rem;">
                                <form method="POST" action="{{ route('locale.update') }}" id="model-form-locale-es">
                                    @csrf
                                    <input type="hidden" name="locale" value="es">
                                    <button type="button" onclick="document.getElementById('model-form-locale-es').submit()" class="dropdown-item-compact" style="{{ $currentLocale == 'es' ? 'color: var(--model-gold);' : '' }}">
                                        <span class="fi fi-es"></span> <span>Español</span>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('locale.update') }}" id="model-form-locale-en">
                                    @csrf
                                    <input type="hidden" name="locale" value="en">
                                    <button type="button" onclick="document.getElementById('model-form-locale-en').submit()" class="dropdown-item-compact" style="{{ $currentLocale == 'en' ? 'color: var(--model-gold);' : '' }}">
                                        <span class="fi fi-us"></span> <span>English</span>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('locale.update') }}" id="model-form-locale-pt_BR">
                                    @csrf
                                    <input type="hidden" name="locale" value="pt_BR">
                                    <button type="button" onclick="document.getElementById('model-form-locale-pt_BR').submit()" class="dropdown-item-compact" style="{{ $currentLocale == 'pt_BR' ? 'color: var(--model-gold);' : '' }}">
                                        <span class="fi fi-br"></span> <span>Português</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Usuario del Modelo -->
                    <div class="model-user" id="modelUserDropdown" onclick="toggleModelDropdown(event)">
                        <div class="model-user-info">
                            <span class="model-user-name">{{ auth()->user()->name }}</span>
                        </div>
                        <div class="model-user-avatar">
                            @if(auth()->user()->profile && auth()->user()->profile->avatar)
                                <img src="{{ auth()->user()->profile->avatar_url }}" alt="Avatar"
                                    style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                            @else
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            @endif
                        </div>

                        
                        <div class="model-user-dropdown">
                            <div class="model-dropdown-header">
                                <span class="model-dropdown-name">{{ auth()->user()->name }}</span>
                                <span class="model-dropdown-role">{{ __('global.title') }} Model</span>
                            </div>

                            <div class="model-dropdown-items">
                                <a href="{{ route('model.profile.edit') }}" class="model-dropdown-item">
                                    <i class="fas fa-user-circle"></i>
                                    <span>{{ __('layouts.model.nav.edit_profile') }}</span>
                                </a>
                                <a href="{{ route('model.profile.settings') }}" class="model-dropdown-item">
                                    <i class="fas fa-cog"></i>
                                    <span>{{ __('layouts.model.nav.settings') }}</span>
                                </a>
                                <a href="{{ route('profiles.show', auth()->id()) }}" target="_blank"
                                    class="model-dropdown-item">
                                    <i class="fas fa-external-link-alt"></i>
                                    <span>{{ __('layouts.model.nav.public_profile') }}</span>
                                </a>
                            </div>

                            <div class="model-dropdown-divider"></div>

                            <div class="model-dropdown-items">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="model-dropdown-item logout">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>{{ __('layouts.model.nav.logout') }}</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            
            <div class="model-content">
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

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('modelSidebar').classList.toggle('active');
        }

        // Toggle Notificaciones Dropdown
    function toggleNotificationDropdown(event) {
        // Solo prevenir por defecto si se clickea en el botón campana directamente, no en los enlaces de adentro
        if(event.target.closest('.btn-notification-compact') && !event.target.closest('.dropdown-item-compact')) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        const dropdown = document.getElementById('notificationDropdown');
        const userDropdown = document.getElementById('modelUserDropdown');
        
        // Cerrar el de usuario si está abierto
        if (userDropdown && userDropdown.classList.contains('active')) {
            userDropdown.classList.remove('active');
        }

        if(event.target.closest('.btn-notification-compact')) {
             dropdown.classList.toggle('active');
        }
    }

    // Toggle User Dropdown
    function toggleModelDropdown(event) {
        // Permitir que los enlaces dentro del dropdown se ejecuten de forma nativa
        if (event.target.closest('.model-dropdown-items') || event.target.closest('a') || event.target.closest('button')) {
            return; 
        }

        event.preventDefault();
        event.stopPropagation();
        
        const dropdown = document.getElementById('modelUserDropdown');
        const notifDropdown = document.getElementById('notificationDropdown');

        // Cerrar el de notificaciones si está abierto
        if (notifDropdown && notifDropdown.classList.contains('active')) {
            notifDropdown.classList.remove('active');
        }

        dropdown.classList.toggle('active');
    }

    // Toggle Model Locale Dropdown
    function toggleModelLocaleDropdown(event) {
        if (event) {
            event.stopPropagation();
        }
        
        const localeDropdown = document.getElementById('modelLocaleDropdown');
        const userDropdown = document.getElementById('modelUserDropdown');
        const notifDropdown = document.getElementById('notificationDropdown');
        
        if (userDropdown && userDropdown.classList.contains('active')) {
            userDropdown.classList.remove('active');
        }
        if (notifDropdown && notifDropdown.classList.contains('active')) {
            notifDropdown.classList.remove('active');
        }

        localeDropdown.classList.toggle('active');
        
        if (localeDropdown.classList.contains('active')) {
            document.addEventListener('click', closeModelLocaleDropdownOnOutsideClick);
        } else {
            document.removeEventListener('click', closeModelLocaleDropdownOnOutsideClick);
        }
    }

    function closeModelLocaleDropdownOnOutsideClick(event) {
        const localeDropdown = document.getElementById('modelLocaleDropdown');
        
        if (localeDropdown && !localeDropdown.contains(event.target)) {
            localeDropdown.classList.remove('active');
            document.removeEventListener('click', closeModelLocaleDropdownOnOutsideClick);
        }
    }

    // Funcionalidad para marcar notificaciones como leídas
    function markAllNotificationsReadDropdown(event) {
        event.preventDefault();
        event.stopPropagation();
        
        fetch('{{ route("model.notifications.read-all") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Ocultar contador
                const badge = document.querySelector('.notification-count');
                if(badge) badge.style.display = 'none';
                
                // Quitar estilos de no leído
                document.querySelectorAll('#notificationDropdownMenu .dropdown-item-compact').forEach(item => {
                    item.style.background = 'transparent';
                });
                
                // Mostrar alerta
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Todas marcadas como leídas',
                    showConfirmButton: false,
                    timer: 3000,
                    background: '#1a1a1e',
                    color: '#fff'
                });
            }
        });
    }

    // Cierra dropdowns al hacer click fuera
    document.addEventListener('click', function(event) {
        const notifDropdown = document.getElementById('notificationDropdown');
        const userDropdown = document.getElementById('modelUserDropdown');

        if (notifDropdown && !notifDropdown.contains(event.target)) {
            notifDropdown.classList.remove('active');
        }
        
        if (userDropdown && !userDropdown.contains(event.target)) {
            userDropdown.classList.remove('active');
        }
    });

    if (typeof feather !== 'undefined') {
        feather.replace();
    }

        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', function (event) {
            const sidebar = document.getElementById('modelSidebar');
            const toggle = document.querySelector('.menu-toggle');

            if (sidebar && toggle && window.innerWidth <= 1024) {
                if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });

        // Automatically scroll sidebar to active item and prevent reloading same page
        document.addEventListener("DOMContentLoaded", function() {
            const activeItem = document.querySelector('.model-sidebar .nav-item.active');
            if (activeItem) {
                // block: 'center' keeps it in the middle of the sidebar vertically
                activeItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Prevent reloading the same page when clicking the active item
                activeItem.addEventListener('click', function(e) {
                    e.preventDefault();
                });
            }
        });

        // Hide alerts automatically after 5 seconds
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.model-content .alert');
                alerts.forEach(function(alert) {
                    alert.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => alert.remove(), 600); // Remove from DOM after transition
                });
            }, 5000);
        });
    </script>

    @yield('scripts')
    @include('partials.csrf-refresh')
    <x-cookie-banner />
</body>

</html>