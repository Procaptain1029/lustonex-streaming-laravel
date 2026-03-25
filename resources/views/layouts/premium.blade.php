<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Lustonex')) - {{ __('layouts.public.title') }}</title>

    
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

    
    @stack('styles')

    
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

        body {
            margin: 0;
            padding: 0;
            padding-top: 70px;
            /* Espacio para header fijo */
            font-family: 'Raleway', sans-serif;
            background: var(--color-negro-azabache);
            color: var(--color-blanco-puro);
            overflow-x: hidden;
        }

        @media (max-width: 1024px) {
            body {
                padding-top: 60px;
                /* Espacio reducido en mobile */
            }
        }
    </style>
</head>

<body>
    
    @include('components.header-unified')

    
    @include('components.sidebar-premium')

    
    <div class="main-content" id="mainContent">
        
        @if (session('success'))
            <div class="success-message"
                style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3); color: #22c55e; padding: 0.75rem 1rem; border-radius: 8px; margin: 1rem 2rem; font-size: 0.9rem;">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="error-message"
                style="background: rgba(194, 24, 91, 0.1); border: 1px solid rgba(194, 24, 91, 0.3); color: #FF4081; padding: 0.75rem 1rem; border-radius: 8px; margin: 1rem 2rem; font-size: 0.9rem;">
                <i class="fas fa-exclamation-triangle"></i>
                {{ session('error') }}
            </div>
        @endif

        @if (session('info'))
            <div class="info-message"
                style="background: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.3); color: #D4AF37; padding: 0.75rem 1rem; border-radius: 8px; margin: 1rem 2rem; font-size: 0.9rem;">
                <i class="fas fa-info-circle"></i>
                {{ session('info') }}
            </div>
        @endif

        
        @yield('content')
    </div>

    
    @if(!isset($hideFooter) || !$hideFooter)
        @include('components.footer-premium')
    @endif

    
    @include('components.sidebar-header-scripts')
    @include('components.search-scripts')

    
    @stack('scripts')

    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Auto-hide mensajes después de 5 segundos
            const messages = document.querySelectorAll('.success-message, .error-message, .info-message');
            messages.forEach(message => {
                setTimeout(() => {
                    message.style.opacity = '0';
                    message.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        message.remove();
                    }, 300);
                }, 5000);
            });
        });
    </script>
    @include('partials.csrf-refresh')
</body>

</html>