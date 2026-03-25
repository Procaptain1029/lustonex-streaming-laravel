<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Lustonex') }}</title>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">


    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f0f0f 0%, #1a1a1a 50%, #0f0f0f 100%);
            min-height: 100vh;
        }

        .auth-container {
            background: rgba(26, 26, 26, 0.5);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(42, 42, 42, 0.5);
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .auth-logo {
            background: linear-gradient(to right, #e50914, #dc2626);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            font-size: 2rem;
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-input {
            background: rgba(42, 42, 42, 0.5);
            border: 1px solid rgba(58, 58, 58, 0.5);
            border-radius: 0.75rem;
            color: white;
            padding: 0.75rem 1rem;
            width: 100%;
            transition: all 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: #e50914;
            box-shadow: 0 0 0 3px rgba(229, 9, 20, 0.1);
            background: rgba(42, 42, 42, 0.8);
        }

        .form-input::placeholder {
            color: rgb(156, 163, 175);
        }

        .form-label {
            color: rgb(209, 213, 219);
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block;
        }

        .btn-primary {
            background: linear-gradient(to right, #e50914, #dc2626);
            color: white;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #dc2626, #b91c1c);
            box-shadow: 0 0 15px rgba(229, 9, 20, 0.5);
            transform: translateY(-1px);
        }

        .auth-link {
            color: rgb(147, 197, 253);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }

        .auth-link:hover {
            color: white;
            text-decoration: underline;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .success-message {
            color: #10b981;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 0.5rem;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            margin: 1rem 0;
        }

        .checkbox-input {
            width: 1rem;
            height: 1rem;
            margin-right: 0.5rem;
            accent-color: #e50914;
        }

        .checkbox-label {
            color: rgb(209, 213, 219);
            font-size: 0.875rem;
        }
    </style>
</head>

<body class="font-sans antialiased text-white">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">

        <div class="mb-8">
            <a href="/" class="auth-logo">
                Lustonex
            </a>
        </div>


        <div class="w-full sm:max-w-md auth-container p-8">
            {{ $slot }}
        </div>


        <div class="mt-8 text-center text-sm text-gray-400">
            <p>&copy; {{ date('Y') }} Lustonex. {{ __('layouts.guest.footer') }}</p>
        </div>
    </div>

    @include('partials.csrf-refresh')
    @include('partials.age-verification')
</body>

</html>