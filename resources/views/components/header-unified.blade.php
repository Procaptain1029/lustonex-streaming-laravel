<style>
    .header-stripchat {
        position: sticky;
        top: 0;
        left: 0;
        right: 0;
        height: 60px;
        background: rgba(10, 10, 10, 0.98);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        z-index: 2000;
        transition: all 0.3s ease;
        color-scheme: dark;
    }

    .header-container {
        position: relative;
        height: 100%;
        max-width: 100%;
        padding: 0;
        /* Eliminar padding horizontal para manejarlo en los hijos si es necesario */
        box-sizing: border-box;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    /* Header Left */
    .header-left {
        display: flex;
        align-items: center;
        gap: 0;
        flex-shrink: 0;
        position: relative;
        z-index: 20;
    }

    .header-center {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        max-width: 480px;
        /* Más pequeño (era 600px) */
        display: flex;
        justify-content: center;
        pointer-events: none;
        /* Evitar que bloquee clics si se estira */
        z-index: 10;
    }

    .header-center>* {
        pointer-events: auto;
        /* Reactivar clics en el buscador */
        width: 100%;
    }

    /* Sidebar Trigger (Hamburger) - Area de 60px */
    .sidebar-trigger {
        width: 60px;
        /* Ancho igual al menú colapsado */
        height: 60px;
        /* Altura igual al header */
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: none;
        border-right: 1px solid rgba(255, 255, 255, 0.05);
        /* Separador sutil */
        color: rgba(255, 255, 255, 0.7);
        cursor: pointer;
        transition: all 0.2s ease;
        border-radius: 0;
        /* Remover radio para encajar */
    }

    .sidebar-trigger:hover {
        background: rgba(255, 255, 255, 0.05);
        color: #D4AF37;
    }

    .sidebar-trigger svg {
        width: 24px;
        height: 24px;
    }

    /* Logo Compact */
    .logo-compact {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        text-decoration: none;
        transition: all 0.3s ease;
        padding-left: 1rem;
        /* Espacio después del trigger */
    }

    .logo-compact:hover .logo-icon svg {
        transform: scale(1.05);
    }

    .logo-icon {
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .logo-icon svg {
        transition: transform 0.3s ease;
    }

    .logo-text {
        font-size: 1.125rem;
        font-weight: 700;
        background: linear-gradient(135deg, #D4AF37, #FFD700);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.5px;
    }



    /* Overrides para el componente de búsqueda */
    .sh-search-bar {
        width: 100%;
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }

    .sh-search-input-group {
        height: 38px !important;
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 19px !important;
        /* Pill shape */
        display: flex;
        align-items: center;
    }

    .sh-search-input-field {
        font-size: 0.85rem !important;
        height: 100% !important;
        min-width: 0 !important;
        background: transparent !important;
        background-color: transparent !important;
        border: none !important;
        border-width: 0 !important;
        border-radius: 0 !important;
        padding: 0 0.35rem !important;
        margin: 0 !important;
        box-shadow: none !important;
        color: #fff !important;
        -webkit-text-fill-color: #fff !important;
    }

    .header-center .sh-search-input-field:focus,
    .header-center .sh-search-input-field:focus-visible {
        outline: none !important;
        box-shadow: none !important;
        --tw-ring-offset-shadow: 0 0 #0000 !important;
        --tw-ring-shadow: 0 0 #0000 !important;
        border-color: transparent !important;
    }

    .header-center .sh-search-input-field:-webkit-autofill,
    .header-center .sh-search-input-field:-webkit-autofill:hover,
    .header-center .sh-search-input-field:-webkit-autofill:focus {
        -webkit-box-shadow: 0 0 0 1000px rgba(30, 30, 35, 1) inset !important;
        box-shadow: 0 0 0 1000px rgba(30, 30, 35, 1) inset !important;
        -webkit-text-fill-color: #fff !important;
    }

    .sh-search-icon-gold {
        font-size: 0.85rem !important;
        margin-left: 12px !important;
    }

    /* Header search: kill native button chrome (white box) and keep actions in one row */
    .header-center .sh-search-input-group {
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        align-items: center !important;
        padding-right: 10px;
        box-sizing: border-box;
    }

    .header-center .sh-search-actions {
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        align-items: center !important;
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }

    .header-center .sh-search-btn-clear,
    .header-center .sh-search-btn-filters {
        -webkit-appearance: none !important;
        appearance: none !important;
        background-image: none !important;
        box-shadow: none !important;
    }

    .header-center .sh-search-btn-filters {
        background-color: rgba(212, 175, 55, 0.12) !important;
        display: inline-flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        align-items: center !important;
        justify-content: center !important;
        white-space: nowrap !important;
        padding: 0 10px !important;
        min-height: 28px !important;
        max-height: 34px !important;
        line-height: 1 !important;
    }

    .header-center .sh-search-filters-inner {
        display: inline-flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        align-items: center !important;
        gap: 0.35rem !important;
        line-height: 1 !important;
    }

    .header-center .sh-search-filters-icon {
        display: inline-block !important;
        flex-shrink: 0 !important;
        line-height: 1 !important;
        font-size: 0.8rem !important;
    }

    .header-center .sh-search-btn-clear {
        background-color: transparent !important;
    }

    @media (max-width: 1200px) {
        .header-center .sh-search-filters-label {
            display: none !important;
        }

        .header-center .sh-search-btn-filters {
            padding: 0 8px !important;
            min-width: 2rem;
        }
    }

    /* Header Right */
    .header-right {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-shrink: 0;
        padding-right: 1.5rem;
        /* Espacio derecho */
        position: relative;
        z-index: 20;
    }

    /* Compact Buttons */
    .btn-tokens-compact {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0 1rem;
        height: 34px;
        /* Altura fija reducida */
        background: linear-gradient(135deg, #D4AF37, #FFD700);
        color: #0a0a0a;
        font-weight: 700;
        font-size: 0.75rem;
        /* Texto más pequeño */
        border-radius: 17px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(212, 175, 55, 0.3);
    }

    .btn-tokens-compact svg {
        width: 14px;
        height: 14px;
    }

    .btn-tokens-compact:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.4);
    }

    .btn-notification-compact {
        position: relative;
        width: 34px;
        /* Reducido */
        height: 34px;
        /* Reducido */
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        /* Circular */
        color: rgba(255, 255, 255, 0.7);
        transition: all 0.2s ease;
        text-decoration: none;
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

    /* User Menu Compact */
    .user-menu-compact {
        position: relative;
    }

    .user-menu-toggle {
        display: flex;
        align-items: center;
        padding: 2px;
        /* Padding reducido */
        background: transparent;
        border: 1px solid transparent;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .user-menu-toggle:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.1);
    }

    .user-avatar-compact {
        width: 34px;
        /* Reducido */
        height: 34px;
        /* Reducido */
        border-radius: 50%;
        overflow: hidden;
    }

    .user-avatar-compact img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-placeholder-compact {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #D4AF37, #FFD700);
        color: #0a0a0a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.8125rem;
        /* Reducido de 0.875rem */
    }

    /* Dropdown */
    .user-menu-dropdown {
        position: absolute;
        top: calc(100% + 0.5rem);
        right: 0;
        width: 280px;
        background: rgba(20, 20, 20, 0.98);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .user-menu-compact.active .user-menu-dropdown {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-header {
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .user-avatar-large {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0;
    }

    .user-avatar-large img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-placeholder-large {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #D4AF37, #FFD700);
        color: #0a0a0a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.25rem;
    }

    .user-details {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .user-name {
        font-weight: 600;
        color: #fff;
        font-size: 0.9375rem;
    }

    .user-name-line {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .user-level-tag {
        background: linear-gradient(135deg, #D4AF37, #FFD700);
        color: #000;
        font-size: 0.65rem;
        font-weight: 800;
        padding: 1px 6px;
        border-radius: 4px;
        height: 16px;
        display: flex;
        align-items: center;
    }

    .user-role-badge {
        display: inline-block;
        padding: 0.125rem 0.5rem;
        background: rgba(212, 175, 55, 0.1);
        color: #D4AF37;
        font-size: 0.6875rem;
        font-weight: 600;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        width: fit-content;
    }

    .dropdown-divider {
        height: 1px;
        background: rgba(255, 255, 255, 0.05);
        margin: 0.5rem 0;
    }

    .dropdown-balance {
        padding: 0.75rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(212, 175, 55, 0.05);
        color: #D4AF37;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .dropdown-items {
        padding: 0.5rem;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        border-radius: 6px;
        transition: all 0.2s ease;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        border: none;
        background: transparent;
        width: 100%;
        text-align: left;
    }

    .dropdown-item:hover {
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
    }

    .dropdown-item.logout {
        color: rgba(239, 68, 68, 0.8);
    }

    .dropdown-item.logout:hover {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    /* Auth Buttons Compact */
    .auth-buttons-compact {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .btn-login-compact {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0 1rem;
        height: 34px;
        /* Match tokens button */
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.9);
        font-weight: 600;
        font-size: 0.75rem;
        /* Smaller font */
        border-radius: 17px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-login-compact:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .btn-register-compact {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0 1rem;
        height: 34px;
        /* Match tokens button */
        background: linear-gradient(135deg, #D4AF37, #FFD700);
        color: #0a0a0a;
        font-weight: 700;
        font-size: 0.75rem;
        /* Smaller font */
        border-radius: 17px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(212, 175, 55, 0.3);
    }

    .btn-register-compact:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.4);
    }

    /* Responsive */
    @media (max-width: 1305px) {
        #localeDropdown {
            display: none !important;
        }
    }

    @media (max-width: 1024px) {
        .header-center {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .hidden-mobile-text {
            display: none !important;
        }

        .header-container {
            padding: 0 1rem;
            gap: 0.75rem;
        }

        /* Compact hamburger menu for mobile */
        .sidebar-trigger {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .sidebar-trigger svg {
            width: 20px;
            height: 20px;
        }

        .header-left {
            gap: 10px;
        }

        .logo-compact {
            padding-left: 0;
        }

        .header-right {
            padding-right: 0;
            margin-left: auto;
        }

        .hidden-mobile-flex {
            display: none !important;
        }

        .btn-tokens-compact {
            display: none !important;
        }

        .btn-login-compact span,
        .btn-register-compact span {
            display: none;
        }

        .btn-login-compact,
        .btn-login-compact {
            width: 40px;
            height: 40px;
            padding: 0;
            justify-content: center;
            align-items: center;
            border-radius: 8px;
        }

        .btn-register-compact {
            width: 40px;
            height: 40px;
            padding: 0;
            justify-content: center;
            border-radius: 50%;
        }

        .btn-login-compact i,
        .btn-register-compact i {
            margin: 0;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .user-menu-dropdown {
            width: calc(100vw - 2rem);
            max-width: 340px;
            position: fixed;
            top: 60px;
            right: 1rem;
            border-radius: 12px;
        }
    }
</style>

<header class="header-stripchat" id="header">
    <div class="header-container">

        <div class="header-left">
            <button class="sidebar-trigger" id="hamburgerBtn" onclick="toggleSidebar()" aria-label="Toggle Sidebar">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <line x1="3" y1="12" x2="21" y2="12" />
                    <line x1="3" y1="18" x2="21" y2="18" />
                </svg>
            </button>

            <a href="{{ route('home') }}" class="logo-compact" onclick="if(this.getAttribute('data-clicked')) return false; this.setAttribute('data-clicked', 'true');">
                <div class="logo-icon">
                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                        <path d="M14 3L3 8.75V19.25L14 25L25 19.25V8.75L14 3Z" fill="url(#logoGradient)" />
                        <circle cx="14" cy="14" r="5.25" fill="#0a0a0a" />
                        <circle cx="14" cy="14" r="2.625" fill="url(#logoGradient)" />
                        <defs>
                            <linearGradient id="logoGradient" x1="3" y1="3" x2="25" y2="25">
                                <stop offset="0%" stop-color="#D4AF37" />
                                <stop offset="100%" stop-color="#FFD700" />
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <span class="logo-text">Lustonex</span>
            </a>
        </div>


        <div class="header-center hidden-mobile-flex">
            @if(!isset($hide_search_bar) || !$hide_search_bar)
                @include('components.search-models')
            @endif
        </div>


        <div class="header-right">
            <!-- Language Selector -->
            <div class="user-menu-compact hidden-mobile-flex" id="localeDropdown">
                <button class="btn-notification-compact" onclick="toggleLocaleDropdown(event)" style="width: auto; padding: 0 10px; border-radius: 17px; gap: 6px;">
                    @php $currentLocale = app()->getLocale(); @endphp
                    @if($currentLocale == 'es')
                        <span class="fi fi-es" style="border-radius: 2px;"></span> <span class="locale-text hidden-mobile-text" style="font-size: 0.75rem; font-weight: 600;">Español</span>
                    @elseif($currentLocale == 'en')
                        <span class="fi fi-us" style="border-radius: 2px;"></span> <span class="locale-text hidden-mobile-text" style="font-size: 0.75rem; font-weight: 600;">English</span>
                    @elseif($currentLocale == 'pt_BR')
                        <span class="fi fi-br" style="border-radius: 2px;"></span> <span class="locale-text hidden-mobile-text" style="font-size: 0.75rem; font-weight: 600;">Português</span>
                    @endif
                    <i class="fas fa-chevron-down hidden-mobile-text" style="font-size: 0.6rem; color: rgba(255,255,255,0.5);"></i>
                </button>
                
                <div class="user-menu-dropdown" id="localeDropdownMenu" style="width: 140px; right: 0;">
                    <div class="dropdown-items">
                        <form method="POST" action="{{ route('locale.update') }}" id="form-locale-es">
                            @csrf
                            <input type="hidden" name="locale" value="es">
                            <button type="button" onclick="document.getElementById('form-locale-es').submit()" class="dropdown-item" style="gap: 10px; {{ $currentLocale == 'es' ? 'color: #D4AF37;' : '' }}">
                                <span class="fi fi-es"></span> Español
                            </button>
                        </form>
                        <form method="POST" action="{{ route('locale.update') }}" id="form-locale-en">
                            @csrf
                            <input type="hidden" name="locale" value="en">
                            <button type="button" onclick="document.getElementById('form-locale-en').submit()" class="dropdown-item" style="gap: 10px; {{ $currentLocale == 'en' ? 'color: #D4AF37;' : '' }}">
                                <span class="fi fi-us"></span> English
                            </button>
                        </form>
                        <form method="POST" action="{{ route('locale.update') }}" id="form-locale-pt_BR">
                            @csrf
                            <input type="hidden" name="locale" value="pt_BR">
                            <button type="button" onclick="document.getElementById('form-locale-pt_BR').submit()" class="dropdown-item" style="gap: 10px; {{ $currentLocale == 'pt_BR' ? 'color: #D4AF37;' : '' }}">
                                <span class="fi fi-br"></span> Português
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            @if (Route::has('login'))
                @auth

                    @if(auth()->user()->role === 'fan')
                        <a href="{{ route('fan.tokens.recharge') }}" class="btn-tokens-compact">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="currentColor">
                                <circle cx="9" cy="9" r="8" stroke="currentColor" stroke-width="1.5" fill="none" />
                                <text x="9" y="12" text-anchor="middle" font-size="10" font-weight="bold"
                                    fill="currentColor">T</text>
                            </svg>
                            <span>{{ number_format(auth()->user()->tokens ?? 0) }} Tokens</span>
                        </a>
                    @endif



                    <div class="user-menu-compact" id="notificationDropdown">
                        <button class="btn-notification-compact" onclick="toggleNotificationDropdown(event)">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M10 2C8.9 2 8 2.9 8 4V4.29C6.03 5.17 4.5 7.02 4.5 9.25V13L3 14.5V15.5H17V14.5L15.5 13V9.25C15.5 7.02 13.97 5.17 12 4.29V4C12 2.9 11.1 2 10 2ZM10 18C11.1 18 12 17.1 12 16H8C8 17.1 8.9 18 10 18Z" />
                            </svg>
                            @php
                                $unreadCount = auth()->user()->unreadNotifications()->count();
                                $recentNotifications = auth()->user()->notifications()->take(5)->get();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="notification-count">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                            @endif
                        </button>

                        <div class="user-menu-dropdown" id="notificationDropdownMenu" style="width: 320px;">
                            <div class="dropdown-header" style="justify-content: space-between; padding: 1rem;">
                                <span style="font-weight: 700; color: #fff;">{{ __('components.header.notifications') }}</span>
                                <button onclick="markAllNotificationsReadDropdown(event)"
                                    style="background: none; border: none; color: #D4AF37; font-size: 0.75rem; font-weight: 600; cursor: pointer;">
                                    {{ __('components.header.mark_read') }}
                                </button>
                            </div>
                            <div class="dropdown-divider" style="margin: 0;"></div>

                            <div class="dropdown-items" style="max-height: 300px; overflow-y: auto;">
                                @forelse($recentNotifications as $notification)
                                    @php $data = $notification->data; @endphp
                                    <a href="{{ route('fan.notifications.index') }}" class="dropdown-item"
                                        style="align-items: flex-start; gap: 10px; {{ is_null($notification->read_at) ? 'background: rgba(212, 175, 55, 0.05);' : '' }}">
                                        <div
                                            style="width: 32px; height: 32px; border-radius: 50%; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #D4AF37;">
                                            <i class="fas {{ $data['icon'] ?? 'fa-bell' }}" style="font-size: 0.8rem;"></i>
                                        </div>
                                        <div style="flex: 1;">
                                            <div
                                                style="color: #fff; font-size: 0.85rem; font-weight: 600; line-height: 1.2; margin-bottom: 2px;">
                                                {{ $data['title'] ?? 'Notificación' }}
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
                                        {{ __('components.header.no_notifications') }}
                                    </div>
                                @endforelse
                            </div>

                            <div class="dropdown-divider" style="margin: 0;"></div>
                            <a href="{{ route('fan.notifications.index') }}" class="dropdown-item"
                                style="justify-content: center; color: #D4AF37; font-size: 0.8rem;">
                                {{ __('components.header.view_all_notifications') }}
                            </a>
                        </div>
                    </div>


                    <div class="user-menu-compact" id="userDropdown">
                        <button class="user-menu-toggle" onclick="toggleUserDropdown(event)">
                            <div class="user-avatar-compact">
                                @if(auth()->user()->profile && auth()->user()->profile->avatar)
                                    <img src="{{ asset('storage/' . auth()->user()->profile->avatar) }}"
                                        alt="{{ auth()->user()->name }}" loading="lazy" decoding="async">
                                @else
                                    <div class="avatar-placeholder-compact">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </button>

                        <div class="user-menu-dropdown" id="userDropdownMenu">

                            <div class="dropdown-header">
                                <div class="user-avatar-large">
                                    @if(auth()->user()->profile && auth()->user()->profile->avatar)
                                        <img src="{{ asset('storage/' . auth()->user()->profile->avatar) }}"
                                            alt="{{ auth()->user()->name }}" loading="lazy" decoding="async">
                                    @else
                                        <div class="avatar-placeholder-large">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="user-details">
                                    <div class="user-name-line">
                                        <span class="user-name">{{ auth()->user()->name }}</span>
                                        @if(auth()->user()->progress && auth()->user()->progress->currentLevel)
                                            <span class="user-level-tag">Lvl
                                                {{ auth()->user()->progress->currentLevel->level_number }}</span>
                                        @endif
                                    </div>
                                    <span class="user-role-badge">
                                        @if(auth()->user()->role === 'fan') Fan
                                        @elseif(auth()->user()->role === 'model') Model
                                        @elseif(auth()->user()->role === 'admin') Admin
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="dropdown-divider"></div>


                            @if(auth()->user()->role === 'fan')
                                <div class="dropdown-balance">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.5" fill="none" />
                                        <text x="8" y="11" text-anchor="middle" font-size="10" font-weight="bold"
                                            fill="currentColor">T</text>
                                    </svg>
                                    <span>{{ auth()->user()->tokens ?? 0 }} Tokens</span>
                                </div>
                                <div class="dropdown-divider"></div>
                            @endif


                            <div class="dropdown-items">
                                @if(auth()->user()->role === 'fan')
                                    <a href="{{ route('fan.dashboard') }}" class="dropdown-item">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                            <path d="M2 2h5v5H2V2zm0 7h5v5H2V9zm7-7h5v5H9V2zm0 7h5v5H9V9z" />
                                        </svg>
                                        <span>{{ __('components.user_menu.dashboard') }}</span>
                                    </a>
                                    <a href="{{ route('fan.chat.index') }}" class="dropdown-item">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                            <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                        </svg>
                                        <span>{{ __('components.user_menu.private') }}</span>
                                    </a>
                                    <a href="{{ route('fan.subscriptions.index') }}" class="dropdown-item">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                            <path d="M8 2l2 4h4l-3 3 1 4-4-2-4 2 1-4-3-3h4l2-4z" />
                                        </svg>
                                        <span>{{ __('components.user_menu.subscriptions') }}</span>
                                    </a>
                                    <a href="{{ route('fan.favorites.index') }}" class="dropdown-item">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                            <path d="M8 2l1.5 3 3.5.5-2.5 2.5.5 3.5-3-1.5-3 1.5.5-3.5L3 6l3.5-.5L8 2z" />
                                        </svg>
                                        <span>{{ __('components.user_menu.favorites') }}</span>
                                    </a>
                                @elseif(auth()->user()->role === 'model')
                                    <a href="{{ route('model.dashboard') }}" class="dropdown-item">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                            <path d="M2 2h5v5H2V2zm0 7h5v5H2V9zm7-7h5v5H9V2zm0 7h5v5H9V9z" />
                                        </svg>
                                        <span>{{ __('components.user_menu.dashboard') }}</span>
                                    </a>
                                    <a href="{{ route('fan.chat.index') }}" class="dropdown-item">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                            <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                        </svg>
                                        <span>{{ __('components.user_menu.private') }}</span>
                                    </a>
                                    <a href="{{ route('model.streams.index') }}" class="dropdown-item">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                            <path d="M2 3v10l10-5L2 3z" />
                                        </svg>
                                        <span>{{ __('components.user_menu.my_streams') }}</span>
                                    </a>
                                @elseif(auth()->user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                            <path d="M8 2l2 4h4l-3 3 1 4-4-2-4 2 1-4-3-3h4l2-4z" />
                                        </svg>
                                        <span>{{ __('components.user_menu.admin_panel') }}</span>
                                    </a>
                                    <a href="{{ route('admin.reports.exports.index') }}" class="dropdown-item">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                            <path d="M14 3v10l-10-5 10-5zm-12 0h2v10h-2V3z"/>
                                        </svg>
                                        <span>Exportar Datos CSV</span>
                                    </a>
                                @endif

                                @if(auth()->user()->role !== 'admin')
                                    <a href="{{ route('reports.index') }}" class="dropdown-item">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                            <path d="M8 0L0 3v5c0 4.42 3.42 8 8 8s8-3.58 8-8V3L8 0zm0 14.5c-3.58 0-6.5-2.92-6.5-6.5V4l6.5-2.44L14.5 4v4c0 3.58-2.92 6.5-6.5 6.5z"/>
                                        </svg>
                                        <span>{{ __('components.user_menu.my_reports') }}</span>
                                    </a>

                                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                            <path
                                                d="M8 8c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                        </svg>
                                        <span>{{ __('components.user_menu.settings') }}</span>
                                    </a>
                                @endif
                            </div>

                            <div class="dropdown-divider"></div>


                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item logout">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                        <path
                                            d="M6 2v2H2v8h4v2H2a2 2 0 01-2-2V4a2 2 0 012-2h4zm7.5 6L10 4.5v3H5v1h5v3L13.5 8z" />
                                    </svg>
                                    <span>{{ __('components.user_menu.logout') }}</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @else

                    <div class="auth-buttons-compact">
                        <a href="{{ route('login') }}" class="btn-login-compact">
                            <i class="fa-solid fa-right-to-bracket"></i>
                            <span> {{ __('components.header.login') }}</span>
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-register-compact">
                                <i class="fa-solid fa-user-plus"></i>
                                <span>{{ __('components.header.register') }}</span>
                            </a>
                        @endif
                    </div>
                @endauth
            @endif
        </div>
    </div>
</header>



<script>
    // Toggle user dropdown
    function toggleUserDropdown(event) {
        if (event) event.stopPropagation();
        const dropdown = document.getElementById('userDropdown');
        const notifDropdown = document.getElementById('notificationDropdown');
        const localeDropdown = document.getElementById('localeDropdown');

        if (notifDropdown && notifDropdown.classList.contains('active')) {
            notifDropdown.classList.remove('active');
        }
        if (localeDropdown && localeDropdown.classList.contains('active')) {
            localeDropdown.classList.remove('active');
        }

        dropdown.classList.toggle('active');

        if (dropdown.classList.contains('active')) {
            document.addEventListener('click', closeUserDropdownOnOutsideClick);
        } else {
            document.removeEventListener('click', closeUserDropdownOnOutsideClick);
        }
    }

    // Toggle Notification Dropdown
    function toggleNotificationDropdown(event) {
        if (event) event.stopPropagation();
        const dropdown = document.getElementById('notificationDropdown');
        const userDropdown = document.getElementById('userDropdown');
        const localeDropdown = document.getElementById('localeDropdown');

        if (userDropdown && userDropdown.classList.contains('active')) {
            userDropdown.classList.remove('active');
        }
        if (localeDropdown && localeDropdown.classList.contains('active')) {
            localeDropdown.classList.remove('active');
        }

        dropdown.classList.toggle('active');

        if (dropdown.classList.contains('active')) {
            document.addEventListener('click', closeNotificationDropdownOnOutsideClick);
        } else {
            document.removeEventListener('click', closeNotificationDropdownOnOutsideClick);
        }
    }

    function closeNotificationDropdownOnOutsideClick(event) {
        const dropdown = document.getElementById('notificationDropdown');
        if (!dropdown.contains(event.target)) {
            dropdown.classList.remove('active');
            document.removeEventListener('click', closeNotificationDropdownOnOutsideClick);
        }
    }

    function markAllNotificationsReadDropdown(event) {
        if (event) event.stopPropagation();

        fetch('/fan/notifications/mark-all-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove unread dots/styles visually
                    const items = document.querySelectorAll('#notificationDropdownMenu .dropdown-item');
                    items.forEach(item => item.style.background = 'transparent');

                    // Remove badge
                    const badge = document.querySelector('.notification-count');
                    if (badge) badge.remove();
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function closeUserDropdownOnOutsideClick(event) {
        const dropdown = document.getElementById('userDropdown');

        if (!dropdown.contains(event.target)) {
            dropdown.classList.remove('active');
            document.removeEventListener('click', closeUserDropdownOnOutsideClick);
        }
    }

    // Toggle Locale Dropdown
    function toggleLocaleDropdown(event) {
        if (event) event.stopPropagation();
        const dropdown = document.getElementById('localeDropdown');
        const userDropdown = document.getElementById('userDropdown');
        const notifDropdown = document.getElementById('notificationDropdown');

        if (userDropdown && userDropdown.classList.contains('active')) {
            userDropdown.classList.remove('active');
        }
        if (notifDropdown && notifDropdown.classList.contains('active')) {
            notifDropdown.classList.remove('active');
        }

        dropdown.classList.toggle('active');

        if (dropdown.classList.contains('active')) {
            document.addEventListener('click', closeLocaleDropdownOnOutsideClick);
        } else {
            document.removeEventListener('click', closeLocaleDropdownOnOutsideClick);
        }
    }

    function closeLocaleDropdownOnOutsideClick(event) {
        const dropdown = document.getElementById('localeDropdown');
        if (dropdown && !dropdown.contains(event.target)) {
            dropdown.classList.remove('active');
            document.removeEventListener('click', closeLocaleDropdownOnOutsideClick);
        }
    }

    // Cerrar con Escape
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            const userDropdown = document.getElementById('userDropdown');
            const notifDropdown = document.getElementById('notificationDropdown');
            const localeDropdown = document.getElementById('localeDropdown');

            if (userDropdown && userDropdown.classList.contains('active')) {
                userDropdown.classList.remove('active');
                document.removeEventListener('click', closeUserDropdownOnOutsideClick);
            }

            if (notifDropdown && notifDropdown.classList.contains('active')) {
                notifDropdown.classList.remove('active');
                document.removeEventListener('click', closeNotificationDropdownOnOutsideClick);
            }

            if (localeDropdown && localeDropdown.classList.contains('active')) {
                localeDropdown.classList.remove('active');
                document.removeEventListener('click', closeLocaleDropdownOnOutsideClick);
            }
        }
    });
</script>