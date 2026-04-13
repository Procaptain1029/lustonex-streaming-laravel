<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', __('layouts.fan.title')) - Lustonex</title>


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
    <!-- Search UI is header-critical; keep sync to avoid default button/icon flash -->
    <link rel="stylesheet" href="{{ asset('css/sh-search-premium.css') }}">


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
            font-family: 'Raleway', sans-serif;
            background: var(--color-negro-azabache);
            background-color: #0B0B0D;
            color: var(--color-blanco-puro);
            color: #FFFFFF;
            overflow-x: hidden;
        }

        .main-content {
            margin-left: 280px;
            transition: all 0.3s ease;
            width: calc(100% - 280px);
            min-height: 100vh;
            position: relative;
            z-index: 10;
            padding-top: 60px;
            /* Match header height */
            margin-top: 0 !important;
            /* Prevent JS/CSS overrides */
        }

        .main-content.sidebar-hidden {
            margin-left: 0;
            width: 100%;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>


    @yield('styles')
</head>

<body>

    <x-header-unified />


    <x-sidebar-premium />


    <div class="main-content" id="mainContent">
        @yield('content')
    </div>


    <x-sidebar-scripts />

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
    @yield('scripts')
    @include('partials.csrf-refresh')
    <x-cookie-banner />
</body>

</html>