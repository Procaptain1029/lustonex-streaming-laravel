<style>
    /* ========================================
   SIDEBAR FULL HEIGHT WITH COLLAPSE
   ======================================== */

    /* Botón flotante móvil */
    .sidebar-mobile-toggle {
        position: fixed;
        top: calc(60px + 1rem);
        left: 1rem;
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.95), rgba(255, 215, 0, 0.95));
        border: none;
        border-radius: 12px;
        color: #0a0a0a;
        display: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 1002;
        box-shadow: 0 4px 16px rgba(212, 175, 55, 0.5);
        transition: all 0.3s ease;
    }

    .sidebar-mobile-toggle:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(212, 175, 55, 0.6);
    }

    .sidebar-mobile-toggle:active {
        transform: scale(0.95);
    }

    /* Sidebar principal - BELOW HEADER */
    .sidebar-v2 {
        position: fixed;
        top: 60px;
        left: 0;
        bottom: 0;
        width: 240px;
        background: rgba(15, 15, 15, 0.98);
        backdrop-filter: blur(20px);
        border-right: 1px solid rgba(255, 255, 255, 0.05);
        z-index: 2001;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Estado colapsado (desktop) - COMPLETAMENTE OCULTO */
    .sidebar-v2.collapsed {
        width: 0;
        transform: translateX(-100%);
        opacity: 0;
        visibility: hidden;
    }

    .sidebar-v2.collapsed .sidebar-content {
        opacity: 0;
        visibility: hidden;
    }

    /* Overlay móvil */
    .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(4px);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 2000;
        display: none;
    }

    /* Contenido del sidebar */
    .sidebar-content {
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    /* Header del sidebar */
    .sidebar-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-shrink: 0;
        min-height: 70px;
    }

    .sidebar-logo {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .sidebar-logo-text {
        font-weight: 700;
        font-size: 1.125rem;
        background: linear-gradient(135deg, #D4AF37, #FFD700);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        transition: all 0.3s ease;
    }

    .sidebar-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Botón de colapsar (desktop) */
    .sidebar-collapse-btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 6px;
        color: rgba(255, 255, 255, 0.6);
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .sidebar-collapse-btn:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #D4AF37;
    }

    .sidebar-collapse-btn svg {
        transition: transform 0.3s ease;
    }

    /* Botón de cerrar (móvil) */
    .sidebar-close {
        width: 32px;
        height: 32px;
        display: none;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 6px;
        color: rgba(255, 255, 255, 0.6);
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .sidebar-close:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    /* Progress Box */
    .sidebar-user-progress {
        margin: 1rem;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(212, 175, 55, 0.2);
        border-radius: 16px;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .sidebar-v2.collapsed .sidebar-user-progress {
        padding: 0.5rem;
        margin: 0.5rem;
    }

    .sidebar-v2.collapsed .sidebar-user-progress .level-info,
    .sidebar-v2.collapsed .sidebar-user-progress .progress-footer {
        display: none;
    }

    .progress-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .mini-league-icon img {
        width: 24px;
        height: 24px;
        object-fit: contain;
    }

    .level-info {
        display: flex;
        flex-direction: column;
    }

    .lvl-label {
        font-size: 0.6rem;
        font-weight: 800;
        color: rgba(255, 255, 255, 0.4);
        letter-spacing: 1px;
    }

    .lvl-number {
        font-size: 1rem;
        font-weight: 900;
        color: #D4AF37;
        line-height: 1;
    }

    .progress-bar-mini {
        height: 4px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 2px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(135deg, #D4AF37, #FFD700);
        box-shadow: 0 0 10px rgba(212, 175, 55, 0.5);
    }

    .progress-footer {
        font-size: 0.65rem;
        color: rgba(255, 255, 255, 0.4);
        font-weight: 600;
        text-align: right;
    }

    /* Navegación */
    .sidebar-nav {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 1rem 0;
    }

    .sidebar-nav::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar-nav::-webkit-scrollbar-track {
        background: transparent;
    }

    .sidebar-nav::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 3px;
    }

    .sidebar-nav::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    /* Secciones de navegación */
    .nav-section {
        padding: 0 1rem;
        margin-bottom: 1.5rem;
    }

    .nav-section-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0.75rem;
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.5rem;
    }

    .nav-section-title span {
        transition: all 0.3s ease;
    }

    /* Items de navegación */
    .nav-item {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        padding: 0.625rem 1rem;
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        border-radius: 12px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-bottom: 0.375rem;
        position: relative;
        white-space: nowrap;
    }

    /* Wrapper premium para iconos */
    .nav-icon-wrapper {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        color: inherit;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        flex-shrink: 0;
    }

    .nav-item:hover {
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
        transform: translateX(4px);
    }

    .nav-item:hover .nav-icon-wrapper {
        background: rgba(212, 175, 55, 0.1);
        border-color: rgba(212, 175, 55, 0.3);
        color: #D4AF37;
        box-shadow: 0 0 15px rgba(212, 175, 55, 0.15);
        transform: scale(1.05);
    }

    .nav-item.active {
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.15), rgba(255, 215, 0, 0.05));
        color: #D4AF37;
        border-left: none;
        /* Quitamos el borde izquierdo anterior */
        padding-left: 1rem;
    }

    .nav-item.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 20%;
        bottom: 20%;
        width: 3px;
        background: #D4AF37;
        border-radius: 0 4px 4px 0;
        box-shadow: 0 0 10px rgba(212, 175, 55, 0.5);
    }

    .nav-item.active .nav-icon-wrapper {
        background: linear-gradient(135deg, #D4AF37, #FFD700);
        border-color: #FFD700;
        color: #0a0a0a;
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.4);
    }

    .nav-item svg {
        transition: transform 0.3s ease;
    }

    .nav-item:hover svg {
        transform: scale(1.1);
    }

    /* Estilo para iconos de sección */
    .section-title-icon {
        width: 24px;
        height: 24px;
        border-radius: 6px;
        background: rgba(255, 255, 255, 0.02);
        margin-right: -4px;
    }

    .section-title-icon svg {
        opacity: 0.6;
    }

    /* Animación para iconos en vivo */
    @keyframes pulse-gold {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.1);
            opacity: 0.8;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .nav-item:hover .icon-live-pulse {
        animation: pulse-gold 1.5s infinite;
    }

    .nav-item span {
        transition: all 0.3s ease;
    }

    /* Badges */
    .nav-badge {
        padding: 0.125rem 0.5rem;
        font-size: 0.625rem;
        font-weight: 700;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .nav-badge.live {
        background: linear-gradient(135deg, #ff6b63, #ff3b30);
        color: #ffffff;
        border: none;
        box-shadow: 0 2px 5px rgba(255, 59, 48, 0.3);
    }

    .nav-badge.new {
        background: linear-gradient(135deg, #00e65c, #00c851);
        color: #ffffff;
        border: none;
        box-shadow: 0 2px 5px rgba(0, 200, 81, 0.3);
    }

    .nav-badge.premium {
        background: rgba(212, 175, 55, 0.15);
        color: #D4AF37;
        border: 1px solid rgba(212, 175, 55, 0.3);
    }

    /* Grupos de filtros */
    .filter-group {
        margin-bottom: 0.5rem;
    }

    .filter-toggle {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        background: transparent;
        border: none;
        color: rgba(255, 255, 255, 0.7);
        text-align: left;
        cursor: pointer;
        border-radius: 8px;
        transition: all 0.2s ease;
        font-size: 0.9375rem;
        font-weight: 500;
    }

    .filter-toggle:hover {
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
    }

    .filter-toggle svg:first-child {
        flex-shrink: 0;
    }

    .filter-toggle span {
        transition: all 0.3s ease;
    }

    .filter-toggle .chevron {
        transition: transform 0.3s ease;
        color: rgba(255, 255, 255, 0.4);
        flex-shrink: 0;
    }

    .filter-group.active .filter-toggle .chevron {
        transform: rotate(180deg);
    }

    /* Items de filtro */
    .filter-items {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
        padding-left: 2.5rem;
    }

    .filter-group.active .filter-items {
        max-height: 500px;
    }

    .filter-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.625rem 1rem;
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        border-radius: 6px;
        transition: all 0.2s ease;
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }

    .filter-item:hover {
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
    }

    .filter-item .fi {
        font-size: 1rem;
        flex-shrink: 0;
    }

    /* Footer del sidebar */
    .sidebar-footer {
        padding: 1.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .sidebar-footer-links {
        display: flex;
        gap: 1rem;
        margin-bottom: 0.75rem;
    }

    .sidebar-footer-links a {
        color: rgba(255, 255, 255, 0.5);
        text-decoration: none;
        font-size: 0.75rem;
        transition: color 0.2s ease;
    }

    .sidebar-footer-links a:hover {
        color: #D4AF37;
    }

    .sidebar-footer-copy {
        color: rgba(255, 255, 255, 0.3);
        font-size: 0.75rem;
    }

    .visible-mobile {
        display: none !important;
    }

    /* ========================================
   RESPONSIVE DESIGN
   ======================================== */

    /* Desktop */
    @media (min-width: 1025px) {
        .sidebar-v2 {
            transform: translateX(0);
        }

        .sidebar-mobile-toggle {
            display: none !important;
        }

        .sidebar-close {
            display: none !important;
        }

        .sidebar-collapse-btn {
            display: flex;
        }

        .sidebar-overlay {
            display: none !important;
        }

        /* Ajustar contenido principal según estado del sidebar */
        body:not(.sidebar-collapsed) .main-content {
            margin-left: 240px;
            margin-top: 60px;
            transition: margin-left 0.3s ease;
        }

        body.sidebar-collapsed .main-content {
            margin-left: 0;

            transition: margin-left 0.3s ease;
        }

        body:not(.sidebar-collapsed) .header-premium-v2 {
            margin-left: 280px;
            width: calc(100% - 280px);
            transition: all 0.3s ease;
        }

        body.sidebar-collapsed .header-premium-v2 {
            margin-left: 0;
            width: 100%;
            transition: all 0.3s ease;
        }
    }

    /* Tablet y Mobile */
    @media (max-width: 1024px) {
        .visible-mobile {
            display: block !important;
        }

        .sidebar-lang-selector {
            margin-top: auto;
            padding: 1.5rem 1.5rem 0.5rem 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
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
            border-color: #D4AF37;
            color: #D4AF37;
        }
        .sidebar-lang-item i {
            font-size: 1.1rem;
        }

        .sidebar-v2 {
            transform: translateX(-100%);
            width: 240px;
        }

        .sidebar-v2.open {
            transform: translateX(0) !important;
        }

        .sidebar-mobile-toggle {
            display: flex;
        }

        .sidebar-v2.open~.sidebar-mobile-toggle {
            opacity: 0;
            pointer-events: none;
        }

        .sidebar-collapse-btn {
            display: none !important;
        }

        .sidebar-close {
            display: flex !important;
        }



        .sidebar-v2.open .sidebar-overlay {
            opacity: 0;
            visibility: visible;
        }

        .main-content {
            margin-left: 0 !important;
            margin-top: 0px !important;
        }

        .header-premium-v2 {
            margin-left: 0 !important;
            width: 100% !important;
        }
    }

    /* Mobile pequeño */
    @media (max-width: 768px) {
        .sidebar-v2 {
            width: 100%;
            max-width: 320px;
        }
    }
</style>
<aside class="sidebar-v2" id="sidebar">

    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>


    <div class="sidebar-content">


        @if(auth()->check() && auth()->user()->role === 'fan' && isset($sidebarLevel))

            <div class="sidebar-user-progress">
                <div class="progress-header" style="justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <div class="mini-league-icon">
                            <img src="{{ auth()->user()->getLigaIcon() }}" alt="Liga" loading="lazy" decoding="async">
                        </div>
                        <span class="lvl-number" style="font-size: 0.9rem;">{{ __('components.sidebar.level', ['number' => $sidebarLevel->level_number]) }}</span>
                    </div>
                    <span class="xp-text"
                        style="font-size: 0.7rem; color: rgba(255,255,255,0.5);">{{ number_format($sidebarCurrentXP) }} /
                        {{ number_format($sidebarRequiredXP) }} XP</span>
                </div>
                <div class="progress-bar-mini" style="margin-top: 5px;">
                    <div class="progress-fill" style="width: {{ $sidebarXpPercentage }}%"></div>
                </div>
            </div>
        @endif
        <nav class="sidebar-nav">

            <div class="nav-section">
                <div class="nav-section-title">
                    <span>{{ __('components.sidebar.categories') }}</span>
                </div>

                <a href="{{ url('/') }}" class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                    <div class="nav-icon-wrapper">
                        <i class="fa-solid fa-house"></i>
                    </div>
                    <span>{{ __('components.sidebar.home') }}</span>
                </a>

                @if(auth()->check() && auth()->user()->role === 'fan')
                    <a href="{{ route('fan.chat.index') }}" class="nav-item {{ request()->routeIs('fan.chat.*') ? 'active' : '' }}">
                        <div class="nav-icon-wrapper">
                            <i class="fa-solid fa-message"></i>
                        </div>
                        <span>{{ __('components.sidebar.private') }}</span>
                    </a>
                @endif

            

                <a href="{{ route('modelos.nuevas') }}"
                    class="nav-item {{ request()->routeIs('modelos.nuevas') ? 'active' : '' }}">
                    <div class="nav-icon-wrapper">
                        <i class="fa-solid fa-user-group"></i>
                    </div>
                    <span>{{ __('components.sidebar.models') }}</span>
                    
                </a>





                <a href="{{ route('modelos.favoritas') }}"
                    class="nav-item {{ request()->routeIs('modelos.favoritas') ? 'active' : '' }}">
                    <div class="nav-icon-wrapper">
                        <i class="fa-solid fa-heart"></i>
                    </div>
                    <span>{{ __('components.sidebar.favorites') }}</span>
                </a>
            </div>


            <div class="nav-section">
                <div class="nav-section-title">
                    <div class="nav-icon-wrapper section-title-icon">
                        <i class="fa-solid fa-filter"></i>
                    </div>
                    <span>{{ __('components.sidebar.filters') }}</span>
                </div>


                <div class="filter-group">
                    <button class="filter-toggle" onclick="toggleFilter('country')">
                        <div class="nav-icon-wrapper">
                            <i class="fa-solid fa-earth-americas"></i>
                        </div>
                        <span>{{ __('components.sidebar.country') }}</span>
                        <i class="fa-solid fa-chevron-down chevron"></i>
                    </button>
                    <div class="filter-items" id="filter-country">
                        <a href="{{ route('filtros.pais', 'co') }}" class="filter-item {{ request()->url() == route('filtros.pais', 'co') ? 'active' : '' }}">
                            <span class="fi fi-co"></span>
                            <span>{{ __('components.sidebar.colombia') }}</span>
                        </a>
                        <a href="{{ route('filtros.pais', 'ar') }}" class="filter-item {{ request()->url() == route('filtros.pais', 'ar') ? 'active' : '' }}">
                            <span class="fi fi-ar"></span>
                            <span>{{ __('components.sidebar.argentina') }}</span>
                        </a>
                        <a href="{{ route('filtros.pais', 'mx') }}" class="filter-item {{ request()->url() == route('filtros.pais', 'mx') ? 'active' : '' }}">
                            <span class="fi fi-mx"></span>
                            <span>{{ __('components.sidebar.mexico') }}</span>
                        </a>
                        <a href="{{ route('filtros.pais', 'es') }}" class="filter-item {{ request()->url() == route('filtros.pais', 'es') ? 'active' : '' }}">
                            <span class="fi fi-es"></span>
                            <span>{{ __('components.sidebar.spain') }}</span>
                        </a>
                        <a href="{{ route('filtros.pais', 'br') }}" class="filter-item {{ request()->url() == route('filtros.pais', 'br') ? 'active' : '' }}">
                            <span class="fi fi-br"></span>
                            <span>{{ __('components.sidebar.brazil') }}</span>
                        </a>
                    </div>
                </div>


                <div class="filter-group">
                    <button class="filter-toggle" onclick="toggleFilter('age')">
                        <div class="nav-icon-wrapper">
                            <i class="fa-solid fa-cake-candles"></i>
                        </div>
                        <span>{{ __('components.sidebar.age') }}</span>
                        <i class="fa-solid fa-chevron-down chevron"></i>
                    </button>
                    <div class="filter-items" id="filter-age">
                        <a href="{{ route('filtros.edad', '18-25') }}" class="filter-item {{ request()->url() == route('filtros.edad', '18-25') ? 'active' : '' }}">
                            <span>{{ __('components.sidebar.age_18_25') }}</span>
                        </a>
                        <a href="{{ route('filtros.edad', '26-30') }}" class="filter-item {{ request()->url() == route('filtros.edad', '26-30') ? 'active' : '' }}">
                            <span>{{ __('components.sidebar.age_26_30') }}</span>
                        </a>
                        <a href="{{ route('filtros.edad', '31-35') }}" class="filter-item {{ request()->url() == route('filtros.edad', '31-35') ? 'active' : '' }}">
                            <span>{{ __('components.sidebar.age_31_35') }}</span>
                        </a>
                        <a href="{{ route('filtros.edad', '36-plus') }}" class="filter-item {{ request()->url() == route('filtros.edad', '36-plus') ? 'active' : '' }}">
                            <span>{{ __('components.sidebar.age_36_plus') }}</span>
                        </a>
                    </div>
                </div>


                <div class="filter-group">
                    <button class="filter-toggle" onclick="toggleFilter('ethnicity')">
                        <div class="nav-icon-wrapper">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <span>{{ __('components.sidebar.ethnicity') }}</span>
                        <i class="fa-solid fa-chevron-down chevron"></i>
                    </button>
                    <div class="filter-items" id="filter-ethnicity">
                        <a href="{{ route('filtros.etnia', 'latina') }}" class="filter-item {{ request()->url() == route('filtros.etnia', 'latina') ? 'active' : '' }}">
                            <span>{{ __('components.sidebar.latina') }}</span>
                        </a>
                        <a href="{{ route('filtros.etnia', 'blanca') }}" class="filter-item {{ request()->url() == route('filtros.etnia', 'blanca') ? 'active' : '' }}">
                            <span>{{ __('components.sidebar.white') }}</span>
                        </a>
                        <a href="{{ route('filtros.etnia', 'asiatica') }}" class="filter-item {{ request()->url() == route('filtros.etnia', 'asiatica') ? 'active' : '' }}">
                            <span>{{ __('components.sidebar.asian') }}</span>
                        </a>
                        <a href="{{ route('filtros.etnia', 'negra') }}" class="filter-item {{ request()->url() == route('filtros.etnia', 'negra') ? 'active' : '' }}">
                            <span>{{ __('components.sidebar.black') }}</span>
                        </a>
                        <a href="{{ route('filtros.etnia', 'multietnica') }}" class="filter-item {{ request()->url() == route('filtros.etnia', 'multietnica') ? 'active' : '' }}">
                            <span>{{ __('components.sidebar.mixed') }}</span>
                        </a>
                    </div>
                </div>


                <div class="filter-group">
                    <button class="filter-toggle" onclick="toggleFilter('hair')">
                        <div class="nav-icon-wrapper">
                            <i class="fa-solid fa-scissors"></i>
                        </div>
                        <span>{{ __('components.sidebar.hair') }}</span>
                        <i class="fa-solid fa-chevron-down chevron"></i>
                    </button>
                    <div class="filter-items" id="filter-hair">
                        <a href="{{ route('search.models', ['hair_color[]' => 'Rubio']) }}" class="filter-item {{ (request()->get('hair_color') && in_array('Rubio', (array)request()->get('hair_color'))) ? 'active' : '' }}"><span>{{ __('components.sidebar.blonde') }}</span></a>
                        <a href="{{ route('search.models', ['hair_color[]' => 'Moreno']) }}" class="filter-item {{ (request()->get('hair_color') && in_array('Moreno', (array)request()->get('hair_color'))) ? 'active' : '' }}"><span>{{ __('components.sidebar.brunette') }}</span></a>
                        <a href="{{ route('search.models', ['hair_color[]' => 'Pelo Negro']) }}" class="filter-item {{ (request()->get('hair_color') && in_array('Pelo Negro', (array)request()->get('hair_color'))) ? 'active' : '' }}"><span>{{ __('components.sidebar.black_hair') }}</span></a>
                        <a href="{{ route('search.models', ['hair_color[]' => 'Pelirroja']) }}" class="filter-item {{ (request()->get('hair_color') && in_array('Pelirroja', (array)request()->get('hair_color'))) ? 'active' : '' }}"><span>{{ __('components.sidebar.redhead') }}</span></a>
                        <a href="{{ route('search.models', ['hair_color[]' => 'Colorido']) }}" class="filter-item {{ (request()->get('hair_color') && in_array('Colorido', (array)request()->get('hair_color'))) ? 'active' : '' }}"><span>{{ __('components.sidebar.colorful') }}</span></a>
                    </div>
                </div>

                <!-- Liga Actual -->
                <div class="filter-group">
                    <button class="filter-toggle" onclick="toggleFilter('league')">
                        <div class="nav-icon-wrapper">
                            <i class="fa-solid fa-trophy"></i>
                        </div>
                        <span>{{ __('components.sidebar.league') }}</span>
                        <i class="fa-solid fa-chevron-down chevron"></i>
                    </button>
                    <div class="filter-items" id="filter-league">
                        <a href="{{ route('search.models', ['league[]' => 'Diamante']) }}" class="filter-item {{ (request()->get('league') && in_array('Diamante', (array)request()->get('league'))) ? 'active' : '' }}"><span>💎 {{ __('components.sidebar.diamond') }}</span></a>
                        <a href="{{ route('search.models', ['league[]' => 'Oro']) }}" class="filter-item {{ (request()->get('league') && in_array('Oro', (array)request()->get('league'))) ? 'active' : '' }}"><span>🥇 {{ __('components.sidebar.gold') }}</span></a>
                        <a href="{{ route('search.models', ['league[]' => 'Plata']) }}" class="filter-item {{ (request()->get('league') && in_array('Plata', (array)request()->get('league'))) ? 'active' : '' }}"><span>🥈 {{ __('components.sidebar.silver') }}</span></a>
                        <a href="{{ route('search.models', ['league[]' => 'Bronce']) }}" class="filter-item {{ (request()->get('league') && in_array('Bronce', (array)request()->get('league'))) ? 'active' : '' }}"><span>🥉 {{ __('components.sidebar.bronze') }}</span></a>
                    </div>
                </div>

                <!-- Disponibilidad -->
                <div class="filter-group">
                    <button class="filter-toggle" onclick="toggleFilter('availability')">
                        <div class="nav-icon-wrapper">
                            <i class="fa-solid fa-signal"></i>
                        </div>
                        <span>{{ __('components.sidebar.availability') }}</span>
                        <i class="fa-solid fa-chevron-down chevron"></i>
                    </button>
                    <div class="filter-items" id="filter-availability">
                        <a href="{{ route('search.models', ['availability[]' => 'live']) }}" class="filter-item {{ (request()->get('availability') && in_array('live', (array)request()->get('availability'))) ? 'active' : '' }}">
                            <i class="fa-solid fa-circle-dot icon-live-pulse" style="color: #4CAF50;"></i>
                            <span>{{ __('components.sidebar.live_now') }}</span>
                        </a>
                        <a href="{{ route('search.models', ['availability[]' => 'online']) }}" class="filter-item {{ (request()->get('availability') && in_array('online', (array)request()->get('availability'))) ? 'active' : '' }}">
                            <i class="fa-solid fa-circle" style="color: #4CAF50;"></i>
                            <span>{{ __('components.sidebar.online') }}</span>
                        </a>
                    </div>
                </div>

                <!-- Idiomas -->
                <div class="filter-group">
                    <button class="filter-toggle" onclick="toggleFilter('languages')">
                        <div class="nav-icon-wrapper">
                            <i class="fa-solid fa-language"></i>
                        </div>
                        <span>{{ __('components.sidebar.languages') }}</span>
                        <i class="fa-solid fa-chevron-down chevron"></i>
                    </button>
                    <div class="filter-items" id="filter-languages">
                        @if(isset($activeLanguages) && count($activeLanguages) > 0)
                            @foreach($activeLanguages as $language)
                                <a href="{{ route('search.models', ['languages[]' => $language]) }}" class="filter-item {{ (request()->get('languages') && in_array($language, (array)request()->get('languages'))) ? 'active' : '' }}">
                                    <span>{{ __('model.options.languages.' . $language) }}</span>
                                </a>
                            @endforeach
                        @else
                            <div style="padding: 10px; font-size: 0.75rem; opacity: 0.5;">
                                {{ __('components.sidebar.no_languages') }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Redes Sociales -->
                <div class="filter-group">
                    <button class="filter-toggle" onclick="toggleFilter('social')">
                        <div class="nav-icon-wrapper">
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                        <span>{{ __('components.sidebar.social') }}</span>
                        <i class="fa-solid fa-chevron-down chevron"></i>
                    </button>
                    <div class="filter-items" id="filter-social">
                        <a href="{{ route('search.models', ['social' => 1]) }}" class="filter-item {{ request()->get('social') == 1 ? 'active' : '' }}"><span>{{ __('components.sidebar.connected') }}</span></a>
                    </div>
                </div>

                <!-- Selector de Idioma Móvil -->
                <div class="nav-section visible-mobile sidebar-lang-selector">
                    <div class="nav-section-title" style="padding: 0 0 0.8rem 0; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; color: rgba(255, 255, 255, 0.3);">
                        {{ __('components.sidebar.select_language') }}
                    </div>
                    <div class="sidebar-lang-options">
                        @php $currentLocale = app()->getLocale(); @endphp
                        
                        <form method="POST" action="{{ route('locale.update') }}" id="sidebar-form-locale-es-premium">
                            @csrf
                            <input type="hidden" name="locale" value="es">
                            <div onclick="document.getElementById('sidebar-form-locale-es-premium').submit()" class="sidebar-lang-item {{ $currentLocale == 'es' ? 'active' : '' }}">
                                <span class="fi fi-es"></span>
                                <span>{{ __('components.sidebar.spanish') }}</span>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('locale.update') }}" id="sidebar-form-locale-en-premium">
                            @csrf
                            <input type="hidden" name="locale" value="en">
                            <div onclick="document.getElementById('sidebar-form-locale-en-premium').submit()" class="sidebar-lang-item {{ $currentLocale == 'en' ? 'active' : '' }}">
                                <span class="fi fi-us"></span>
                                <span>{{ __('components.sidebar.english') }}</span>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('locale.update') }}" id="sidebar-form-locale-pt_BR-premium">
                            @csrf
                            <input type="hidden" name="locale" value="pt_BR">
                            <div onclick="document.getElementById('sidebar-form-locale-pt_BR-premium').submit()" class="sidebar-lang-item {{ $currentLocale == 'pt_BR' ? 'active' : '' }}">
                                <span class="fi fi-br"></span>
                                <span>{{ __('components.sidebar.portuguese') }}</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </nav>


        <div class="sidebar-footer">
            <div class="sidebar-footer-links">
                <a href="{{ route('support.main') }}">{{ __('components.sidebar.help') }}</a>
                <a href="{{ route('legal.privacy') }}">{{ __('components.sidebar.privacy') }}</a>
                <a href="{{ route('legal.terms') }}">{{ __('components.sidebar.terms') }}</a>
            </div>
            <div class="sidebar-footer-copy">
                {{ __('components.sidebar.copyright', ['year' => date('Y')]) }}
            </div>
        </div>
    </div>
</aside>

