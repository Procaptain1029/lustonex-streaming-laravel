@extends('layouts.public')

@section('content')
    <style>
        /* Login Split Layout */
        .sh-login-wrapper {
            min-height: calc(100vh - 80px);
            /* Adjust for header height approx */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0px 20px;
        }

        .sh-login-split {
            width: 100%;
            max-width: 1200px;
            background: rgba(15, 15, 18, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 30px;
            display: flex;
            overflow: hidden;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.5);
        }

        /* Left: Hero/Branding Section */
        .sh-login-hero {
            flex: 1;
            background: #0B0B0D;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .sh-login-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: 
                radial-gradient(circle at 20% 30%, rgba(212, 175, 55, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(244, 227, 125, 0.1) 0%, transparent 40%);
            z-index: 1;
        }

        .sh-login-hero-blobs {
            position: absolute;
            inset: 0;
            z-index: 1;
        }

        .sh-login-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.12;
            animation: blob-move 25s infinite alternate ease-in-out;
        }

        .sh-login-blob-1 {
            width: 400px;
            height: 400px;
            background: #D4AF37;
            top: -100px;
            left: -100px;
        }

        .sh-login-blob-2 {
            width: 350px;
            height: 350px;
            background: #F4E37D;
            bottom: -50px;
            right: -50px;
            animation-duration: 30s;
            animation-direction: alternate-reverse;
        }

        @keyframes blob-move {
            0% { transform: translate(0, 0) rotate(0deg) scale(1); }
            33% { transform: translate(30px, 50px) rotate(10deg) scale(1.1); }
            66% { transform: translate(-20px, 80px) rotate(-10deg) scale(0.9); }
            100% { transform: translate(0, 0) rotate(0deg) scale(1); }
        }

        .sh-login-hero-content {
            position: relative;
            z-index: 2;
        }

        .sh-login-hero-title {
            font-family: 'Poppins', sans-serif;
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #D4AF37, #F4E37D);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sh-login-hero-subtitle {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 40px;
            max-width: 450px;
            line-height: 1.6;
        }

        .sh-login-features {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .sh-login-feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #fff;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .sh-login-feature-icon {
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #D4AF37;
        }

        /* Right: Form Section */
        .sh-login-form-side {
            flex: 1;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #0B0B0D;
        }

        .sh-login-form-container {
            max-width: 400px;
            margin: 0 auto;
            width: 100%;
        }

        .sh-login-header {
            margin-bottom: 40px;
            text-align: left;
        }

        .sh-login-header h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 10px;
        }

        .sh-login-header p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.95rem;
        }

        /* Inputs Styling */
        .sh-login-group {
            margin-bottom: 25px;
        }

        .sh-login-label {
            display: block;
            margin-bottom: 10px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sh-login-input-wrapper {
            position: relative;
        }

        .sh-login-input-wrapper i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.3);
            transition: color 0.3s ease;
        }

        .sh-login-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 15px 20px 15px 55px;
            color: #fff;
            font-family: 'Raleway', sans-serif;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .sh-login-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.06);
            border-color: #D4AF37;
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.1);
        }

        .sh-login-input:focus+i {
            color: #D4AF37;
        }

        /* Button */
        .sh-login-btn {
            width: 100%;
            background: linear-gradient(135deg, #D4AF37, #F4E37D);
            color: #000;
            border: none;
            padding: 16px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .sh-login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.3);
        }

        /* Actions & Links */
        .sh-login-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            margin-bottom: 40px;
        }

        .sh-login-remember {
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.9rem;
            cursor: pointer;
        }

        .sh-login-remember input {
            accent-color: #D4AF37;
        }

        .sh-login-forgot {
            color: #D4AF37;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .sh-login-footer {
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding-top: 30px;
        }

        .sh-login-footer p {
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .sh-login-signup-options {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .sh-login-signup-link {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 10px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sh-login-signup-link:hover {
            background: rgba(255, 255, 255, 0.03);
            border-color: #D4AF37;
            color: #D4AF37;
        }

        .sh-login-signup-link i {
            margin-right: 8px;
            font-size: 0.8rem;
            opacity: 0.7;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sh-login-hero {
                display: none;
            }

            .sh-login-split {
                max-width: 500px;
            }

            .sh-login-form-side {
                padding: 40px;
            }
        }

        @media (max-width: 768px) {
            .sh-login-wrapper {
                padding: 20px 15px;
                min-height: calc(100vh - 70px);
                align-items: flex-start;
                padding-top: 40px;
            }

            .sh-login-split {
                border-radius: 20px;
                max-width: 100%;
            }

            .sh-login-form-side {
                padding: 40px 25px;
            }

            .sh-login-header {
                margin-bottom: 30px;
            }

            .sh-login-header h2 {
                font-size: 1.75rem;
            }

            .sh-login-header p {
                font-size: 0.9rem;
            }

            .sh-login-input {
                padding: 14px 15px 14px 45px;
                font-size: 0.95rem;
            }

            .sh-login-input-wrapper i {
                left: 15px;
            }

            .sh-login-actions {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
                margin-top: 20px;
                margin-bottom: 30px;
            }

            .sh-login-btn {
                padding: 15px;
            }
        }

        @media (max-width: 480px) {
            .sh-login-wrapper {
                padding: 0;
                min-height: calc(100vh - 60px);
                padding-top: 0;
                align-items: flex-start;
            }

            .sh-login-split {
                border: none;
                border-radius: 0;
                background: transparent;
                box-shadow: none;
                padding-bottom: 40px;
            }

            .sh-login-form-side {
                padding: 30px 20px;
            }

            .sh-login-header {
                margin-bottom: 25px;
            }

            .sh-login-header h2 {
                font-size: 1.5rem;
            }

            .sh-login-header p {
                font-size: 0.85rem;
                margin-bottom: 0;
            }

            .sh-login-group {
                margin-bottom: 18px;
            }

            .sh-login-label {
                font-size: 0.8rem;
            }

            .sh-login-input {
                padding: 12px 14px 12px 42px;
                font-size: 0.9rem;
                border-radius: 10px;
            }

            .sh-login-input-wrapper i {
                left: 14px;
                font-size: 0.9rem;
            }

            .sh-login-btn {
                padding: 14px;
                font-size: 0.95rem;
                margin-top: 5px;
            }

            .sh-login-actions {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                gap: 10px;
                margin-top: 15px;
                margin-bottom: 25px;
            }

            .sh-login-remember {
                font-size: 0.85rem;
            }

            .sh-login-forgot {
                font-size: 0.85rem;
            }

            .sh-login-footer {
                padding-top: 20px;
            }

            .sh-login-footer p {
                font-size: 0.85rem;
                margin-bottom: 15px;
            }

            .sh-login-signup-link {
                font-size: 0.85rem;
                padding: 12px;
            }
        }
    </style>
    <div class="sh-login-wrapper">
        <div class="sh-login-split">
            
            <div class="sh-login-hero">
                <div class="sh-login-hero-blobs">
                    <div class="sh-login-blob sh-login-blob-1"></div>
                    <div class="sh-login-blob sh-login-blob-2"></div>
                </div>
                <div class="sh-login-hero-content">
                    <h1 class="sh-login-hero-title">{{ __('auth_pages.login.hero_title') }}</h1>
                    <p class="sh-login-hero-subtitle">
                        {{ __('auth_pages.login.hero_subtitle') }}
                    </p>
                    <ul class="sh-login-features">
                        <li class="sh-login-feature-item">
                            <div class="sh-login-feature-icon"><i class="fas fa-bolt"></i></div>
                            {{ __('auth_pages.login.feature_live') }}
                        </li>
                        <li class="sh-login-feature-item">
                            <div class="sh-login-feature-icon"><i class="fas fa-comment-dots"></i></div>
                            {{ __('auth_pages.login.feature_chat') }}
                        </li>
                        <li class="sh-login-feature-item">
                            <div class="sh-login-feature-icon"><i class="fas fa-shield-alt"></i></div>
                            {{ __('auth_pages.login.feature_secure') }}
                        </li>
                        <li class="sh-login-feature-item">
                            <div class="sh-login-feature-icon"><i class="fas fa-gift"></i></div>
                            {{ __('auth_pages.login.feature_exclusive') }}
                        </li>
                    </ul>
                </div>
            </div>

            
            <div class="sh-login-form-side">
                <div class="sh-login-form-container">
                    <div class="sh-login-header">
                        <h2>{{ __('auth_pages.login.title') }}</h2>
                        <p>{{ __('auth_pages.login.subtitle') }}</p>
                    </div>

                    
                    @if (session('status'))
                        <div class="success-message"
                            style="background: rgba(0, 255, 136, 0.1); border: 1px solid rgba(0, 255, 136, 0.3); color: #00ff88; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-size: 0.9rem;">
                            <i class="fas fa-check-circle"></i>
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        
                        <div class="sh-login-group">
                            <label class="sh-login-label" for="email">{{ __('auth_pages.login.email_label') }}</label>
                            <div class="sh-login-input-wrapper">
                                <i class="fas fa-envelope"></i>
                                <input id="email" class="sh-login-input" type="email" name="email"
                                    value="{{ old('email') }}" required autofocus autocomplete="username"
                                    placeholder="tu@email.com">
                            </div>
                            @error('email')
                                <p style="color: #ff4b4b; font-size: 0.8rem; margin-top: 8px;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        
                        <div class="sh-login-group">
                            <label class="sh-login-label" for="password">{{ __('auth_pages.login.password_label') }}</label>
                            <div class="sh-login-input-wrapper">
                                <i class="fas fa-lock"></i>
                                <input id="password" class="sh-login-input" type="password" name="password" required
                                    autocomplete="current-password" placeholder="••••••••">
                            </div>
                            @error('password')
                                <p style="color: #ff4b4b; font-size: 0.8rem; margin-top: 8px;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="sh-login-actions">
                            <label for="remember_me" class="sh-login-remember">
                                <input id="remember_me" type="checkbox" name="remember">
                                <span>{{ __('auth_pages.login.remember_me') }}</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a class="sh-login-forgot" href="{{ route('password.request') }}">
                                    {{ __('auth_pages.login.forgot_password') }}
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="sh-login-btn">
                            {{ __('auth_pages.login.btn_login') }}
                            <i class="fas fa-arrow-right"></i>
                        </button>

                        <div class="sh-login-footer">
                            <p>{{ __('auth_pages.login.no_account') }}</p>
                            <div class="sh-login-signup-options">
                                <a href="{{ route('register') }}" class="sh-login-signup-link">
                                    <i class="fas fa-user-plus"></i> {{ __('auth_pages.login.register_fan') }}
                                </a>
                                <a href="{{ route('register.model') }}" class="sh-login-signup-link">
                                    <i class="fas fa-crown"></i> {{ __('auth_pages.login.register_model') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');

            if (sidebar && mainContent) {
                // Force colapsed mode on this page
                sidebar.classList.add('sidebar-collapsed');
                mainContent.classList.add('sidebar-collapsed');

                // Sync localStorage
                localStorage.setItem('sidebarCollapsed', 'true');
            }
        });
    </script>
@endsection