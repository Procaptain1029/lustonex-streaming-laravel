<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', __('layouts.public.title'))</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Raleway:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Assets managed by Vite (Caching & Versioning) -->
    @vite([
        'resources/css/premium-design.css',
        'resources/css/icons.css',
        'resources/css/sh-search-premium.css',
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <!-- Non-Critical CSS (Asynchronous Loading) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons/css/flag-icons.min.css" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'">


    <style>
        :root {
            --color-negro-azabache: #0B0B0D;
            --color-blanco-puro: #FFFFFF;
            --color-oro-sensual: #D4AF37;
            --color-rosa-vibrante: #FF4081;
            --color-rosa-oscuro: #C2185B;
            --color-gris-carbon: #1F1F23;
            --color-gris-claro: #E5E7EB;
            --font-titles: 'Poppins', sans-serif;
            --font-buttons: 'Montserrat', sans-serif;
            --gradient-gold: linear-gradient(135deg, #D4AF37, #f4e37d);
            --shadow-glow-gold: 0 0 20px rgba(212, 175, 55, 0.4);
        }

        /* Asegurar que el body use el diseño premium */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Raleway', sans-serif;
            background: var(--color-negro-azabache);
            background-color: #0B0B0D;
            color: var(--color-blanco-puro);
            color: #FFFFFF;
            overflow-x: clip;
            width: 100%;
        }

        /* Container principal */
        .page-container {
            position: relative;
            min-height: 100vh;
            z-index: 1;
        }

        /* Full width when no sidebar */
        .main-content.no-sidebar {
            margin-left: 0 !important;
            width: 100% !important;
        }

        /* Fix layout shift */
        body {
            padding-top: 0 !important;
        }

        .main-content {
            margin-top: 20px !important;
            /* Header Height */
            padding-top: 0 !important;
            min-height: calc(100vh - 60px);
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
        }

        /* Adjust for sidebar presence if needed */
        @media (min-width: 1025px) {
            body:not(.sidebar-collapsed) .main-content {
                margin-left: 240px;
                /* Sidebar width */
                width: calc(100% - 240px);
            }

            body.sidebar-collapsed .main-content {
                margin-left: 0;
                width: 100%;
            }
        }

        /* ----- GLOBAL PREMIUM TYPOGRAPHY ----- */
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

        @media (max-width: 768px) {
            .page-title {
                font-size: 20px !important;
            }
            .page-subtitle {
                font-size: 14px !important;
            }
        }
    </style>

    @include('components.sidebar-header-scripts')

    @stack('styles')
    @yield('styles')
</head>

<body>
    <div class="page-container">

        @include('components.header-unified')


        @include('components.mobile-search-filters')


        @include('components.sidebar-premium')




        <div class="main-content {{ request()->routeIs('profiles.show') ? 'no-sidebar' : '' }}" id="mainContent">
            @yield('content')


            @include('components.footer-premium')
        </div>
    </div>


    <script>
        // Header scroll effect
        window.addEventListener('scroll', function () {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Smooth scroll para enlaces internos del sidebar
        document.querySelectorAll('.sidebar-item[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });

                    // Cerrar sidebar en mobile después del scroll
                    if (window.innerWidth <= 1024) {
                        document.getElementById('sidebar').classList.remove('open');
                    }
                }
            });
        });

        // Highlight active sidebar item based on scroll position
        function updateActiveSidebarItem() {
            const sections = document.querySelectorAll('section[id]');
            const sidebarItems = document.querySelectorAll('.sidebar-item[href^="#"]');

            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (window.scrollY >= (sectionTop - 200)) {
                    current = section.getAttribute('id');
                }
            });

            sidebarItems.forEach(item => {
                item.classList.remove('active');
                if (item.getAttribute('href') === '#' + current) {
                    item.classList.add('active');
                }
            });
        }

        // Update active item on scroll
        window.addEventListener('scroll', updateActiveSidebarItem);

        // Smooth scroll para enlaces internos
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Animate cards on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all model cards
        document.querySelectorAll('.card-model').forEach(card => {
            observer.observe(card);
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>


    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: "{{ __('layouts.public.alerts.success') }}",
                text: "{{ session('success') }}",
                background: '#1a1a1e',
                color: '#fff',
                confirmButtonColor: '#d4af37'
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: "{{ __('layouts.public.alerts.error') }}",
                text: "{{ session('error') }}",
                background: '#1a1a1e',
                color: '#fff',
                confirmButtonColor: '#d4af37'
            });
        </script>
    @endif

    @if(session('info'))
        <script>
            Swal.fire({
                icon: 'info',
                title: "{{ __('layouts.public.alerts.info') }}",
                text: "{{ session('info') }}",
                background: '#1a1a1e',
                color: '#fff',
                confirmButtonColor: '#d4af37'
            });
        </script>
    @endif


    @include('components.search-scripts')

    @stack('scripts')
    @yield('scripts')

    @include('partials.csrf-refresh')
    @include('partials.age-verification')
    <x-cookie-banner />
</body>

</html>