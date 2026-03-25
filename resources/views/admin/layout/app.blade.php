<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Lustonex - Tu deseo tiene niveles</title>

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Raleway:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    
    <link rel="stylesheet" href="{{ asset('css/premium-design.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons/css/flag-icons.min.css">


    
    @stack('styles')
</head>

<body>
    <div class="welcome-container">
        @include('components.header-unified')
        @include('components.sidebar-premium')
        
        <div class="main-content" id="mainContent">
            @yield('content')
        </div>
    </div>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    @include('components.sidebar-header-scripts')
    @include('components.search-scripts')
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

    <style>
        <style>

        /* Fondo negro y borde dorado */
        #toast-container>.toast {
            background-color: #000000 !important;
            color: #FFD700 !important;
            /* Dorado */
            border: 1px solid #FFD700 !important;
            font-weight: bold;
            box-shadow: 0 0 10px #FFD700;
        }

        /* Iconos dorados */
        #toast-container>.toast-success {
            background-color: #000000 !important;
            border-left: 5px solid #FFD700 !important;
        }

        #toast-container>.toast-error {
            background-color: #000000 !important;
            border-left: 5px solid #FFD700 !important;
        }

        #toast-container>.toast-info {
            background-color: #000000 !important;
            border-left: 5px solid #FFD700 !important;
        }

        #toast-container>.toast-warning {
            background-color: #000000 !important;
            border-left: 5px solid #FFD700 !important;
        }
    </style>

    </style>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}", "{{ __('admin.layout.app.toastr_success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}", "{{ __('admin.layout.app.toastr_error') }}");
        @endif

        @if (session('warning'))
            toastr.warning("{{ session('warning') }}", "{{ __('admin.layout.app.toastr_warning') }}");
        @endif

        @if (session('info'))
            toastr.info("{{ session('info') }}", "{{ __('admin.layout.app.toastr_info') }}");
        @endif
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>