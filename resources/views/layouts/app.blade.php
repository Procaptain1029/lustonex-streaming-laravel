<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Lustonex') }}</title>


    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <!-- Preload Critical Assets -->
    <link rel="preload" href="{{ asset('css/premium-design.css') }}" as="style">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/webfonts/fa-solid-900.woff2" as="font" type="font/woff2" crossorigin>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Raleway:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Critical CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/premium-design.css') }}">

    <!-- Non-Critical CSS (Asynchronous Loading) -->
    <link rel="stylesheet" href="{{ asset('css/icons.css') }}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{ asset('css/sh-search-premium.css') }}" media="print" onload="this.media='all'">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')



</head>

<body class="font-sans antialiased"
    style="background: var(--color-negro-azabache, #0B0B0D); color: var(--color-blanco-puro, #FFFFFF);">
    <div class="min-h-screen"
        style="background: linear-gradient(135deg, var(--color-negro-azabache, #0B0B0D), var(--color-gris-carbon, #1F1F23))">
        @include('layouts.navigation')


        @if (isset($header))
            <header class="bg-dark-800/50 backdrop-blur-sm border-b border-dark-700 shadow-lg">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="text-white">
                        {{ $header }}
                    </div>
                </div>
            </header>
        @endif


        @if (session('success'))
            <div class="animate-slide-in mx-4 mt-4">
                <div class="card-premium"
                    style="background: linear-gradient(135deg, rgba(0, 255, 136, 0.1), rgba(0, 200, 100, 0.1)); border-color: rgba(0, 255, 136, 0.3); color: #00ff88;"
                    role="alert">
                    <div style="display: flex; align-items: center;">
                        <i class="fas fa-check-circle" style="margin-right: 12px; color: #00ff88;"></i>
                        <span class="text-body" style="font-weight: 500;">{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="animate-slide-in mx-4 mt-4">
                <div class="card-premium"
                    style="background: linear-gradient(135deg, rgba(194, 24, 91, 0.1), rgba(255, 64, 129, 0.1)); border-color: var(--color-rosa-oscuro); color: var(--color-rosa-vibrante);"
                    role="alert">
                    <div style="display: flex; align-items: center;">
                        <i class="fas fa-exclamation-triangle"
                            style="margin-right: 12px; color: var(--color-rosa-vibrante);"></i>
                        <span class="text-body" style="font-weight: 500;">{{ session('error') }}</span>
                    </div>
                </div>
            </div>
        @endif

        @if (session('info'))
            <div class="animate-slide-in mx-4 mt-4">
                <div class="card-premium"
                    style="background: linear-gradient(135deg, rgba(212, 175, 55, 0.1), rgba(244, 227, 125, 0.1)); border-color: var(--color-oro-sensual); color: var(--color-oro-sensual);"
                    role="alert">
                    <div style="display: flex; align-items: center;">
                        <i class="fas fa-info-circle" style="margin-right: 12px; color: var(--color-oro-sensual);"></i>
                        <span class="text-body" style="font-weight: 500;">{{ session('info') }}</span>
                    </div>
                </div>
            </div>
        @endif


        <main class="relative">
            {{ $slot }}
        </main>
    </div>


    <div id="notification-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    @stack('scripts')


    <script>
        // Add glow effect to buttons on hover
        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.btn-primary, .btn-fire, .btn-gold');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function () {
                    this.classList.add('shadow-glow-red');
                });
                button.addEventListener('mouseleave', function () {
                    this.classList.remove('shadow-glow-red');
                });
            });
        });

        // Premium notification system
        function showNotification(message, type = 'info', duration = 5000) {
            const container = document.getElementById('notification-container');
            const notification = document.createElement('div');

            const colors = {
                success: 'from-green-500/20 to-green-600/20 border-green-500/30 text-green-300',
                error: 'from-primary-500/20 to-primary-600/20 border-primary-500/30 text-primary-300',
                info: 'from-blue-500/20 to-blue-600/20 border-blue-500/30 text-blue-300',
                tip: 'from-fire-500/20 to-fire-600/20 border-fire-500/30 text-fire-300'
            };

            notification.className = `animate-slide-in bg-gradient-to-r ${colors[type]} border px-6 py-4 rounded-xl backdrop-blur-sm shadow-lg max-w-sm`;
            notification.innerHTML = `
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-current rounded-full animate-pulse mr-3"></div>
                            <span class="font-medium">${message}</span>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-current hover:opacity-70">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                `;

            container.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, duration);
        }
    </script>

    @include('partials.csrf-refresh')
    @include('partials.age-verification')
    <x-cookie-banner />
</body>

</html>