@extends('layouts.public')

@section('content')
    <style>
        /* Auth Split Layout */
        .sh-auth-wrapper {
            min-height: calc(100vh - 80px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0px 20px;
        }

        .sh-auth-split {
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

        /* Left: Hero/Branding Section - Model Specific */
        .sh-auth-hero {
            flex: 1;
            background: #0B0B0D;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .sh-auth-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: 
                radial-gradient(circle at 20% 30%, rgba(34, 197, 94, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(212, 175, 55, 0.1) 0%, transparent 40%);
            z-index: 1;
        }

        .sh-auth-hero-blobs {
            position: absolute;
            inset: 0;
            z-index: 1;
        }

        .sh-auth-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.12;
            animation: blob-move 25s infinite alternate ease-in-out;
        }

        .sh-auth-blob-1 {
            width: 400px;
            height: 400px;
            background: #22c55e;
            top: -100px;
            left: -100px;
        }

        .sh-auth-blob-2 {
            width: 350px;
            height: 350px;
            background: #D4AF37;
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

        .sh-auth-hero-content {
            position: relative;
            z-index: 2;
        }

        .sh-auth-hero-title {
            font-family: 'Poppins', sans-serif;
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #22c55e, #D4AF37);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sh-auth-hero-subtitle {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 40px;
            max-width: 450px;
            line-height: 1.6;
        }

        .sh-auth-features {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .sh-auth-feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #fff;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .sh-auth-feature-icon {
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #22c55e;
        }

        /* Right: Form Section */
        .sh-auth-form-side {
            flex: 1;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #0B0B0D;
        }

        .sh-auth-form-container {
            max-width: 400px;
            margin: 0 auto;
            width: 100%;
        }

        .sh-auth-header {
            margin-bottom: 40px;
            text-align: left;
        }

        .sh-auth-header h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 10px;
        }

        .sh-auth-header p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.95rem;
        }

        /* Inputs Styling */
        .sh-auth-group {
            margin-bottom: 25px;
        }

        .sh-auth-label {
            display: block;
            margin-bottom: 10px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sh-auth-input-wrapper {
            position: relative;
        }

        .sh-auth-input-wrapper i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.3);
            transition: color 0.3s ease;
        }

        .sh-auth-input {
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

        .sh-auth-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.06);
            border-color: #22c55e;
            box-shadow: 0 0 20px rgba(34, 197, 94, 0.1);
        }

        .sh-auth-input:focus+i {
            color: #22c55e;
        }

        /* Checkbox Styling */
        .sh-auth-checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 25px;
            cursor: pointer;
        }

        .sh-auth-checkbox-input {
            appearance: none;
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.05);
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .sh-auth-checkbox-input:checked {
            background: #22c55e;
            border-color: #22c55e;
        }

        .sh-auth-checkbox-input:checked::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: #fff;
            font-size: 12px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .sh-auth-checkbox-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            line-height: 1.4;
            user-select: none;
            cursor: pointer;
        }

        .sh-auth-checkbox-label a {
            color: #D4AF37;
            text-decoration: none;
            font-weight: 600;
        }

        .sh-auth-checkbox-label a:hover {
            color: #22c55e;
            text-decoration: underline;
        }

        /* Button */
        .sh-auth-btn {
            width: 100%;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: #fff;
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

        .sh-auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(34, 197, 94, 0.3);
        }

        .sh-auth-footer {
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding-top: 30px;
            margin-top: 30px;
        }

        .sh-auth-footer p {
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .sh-auth-link {
            color: #D4AF37;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .sh-auth-link:hover {
            color: #22c55e;
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sh-auth-hero {
                display: none;
            }

            .sh-auth-split {
                max-width: 500px;
            }

            .sh-auth-form-side {
                padding: 40px;
            }
        }

        @media (max-width: 768px) {
            .sh-auth-wrapper {
                padding: 20px 15px;
                min-height: calc(100vh - 70px);
                align-items: flex-start;
                padding-top: 40px;
            }

            .sh-auth-split {
                border-radius: 20px;
                max-width: 100%;
            }

            .sh-auth-form-side {
                padding: 40px 25px;
            }

            .sh-auth-header {
                margin-bottom: 30px;
            }

            .sh-auth-header h2 {
                font-size: 1.75rem;
            }

            .sh-auth-header p {
                font-size: 0.9rem;
            }

            .sh-auth-input {
                padding: 14px 15px 14px 45px;
                font-size: 0.95rem;
            }

            .sh-auth-input-wrapper i {
                left: 15px;
            }

            .sh-auth-checkbox-group {
                margin-bottom: 20px;
            }

            .sh-auth-btn {
                padding: 15px;
                font-size: 0.95rem;
                margin-top: 10px;
            }
            
            .sh-auth-footer {
                padding-top: 25px;
                margin-top: 25px;
            }
        }

        @media (max-width: 480px) {
            .sh-auth-wrapper {
                padding: 0;
                min-height: calc(100vh - 60px);
                padding-top: 0;
                align-items: flex-start;
            }

            .sh-auth-split {
                border: none;
                border-radius: 0;
                background: transparent;
                box-shadow: none;
                padding-bottom: 40px;
            }

            .sh-auth-form-side {
                padding: 30px 20px;
                background: transparent;
            }

            .sh-auth-form-container {
                max-width: 100%;
            }

            .sh-auth-header {
                margin-bottom: 25px;
            }

            .sh-auth-header h2 {
                font-size: 1.5rem;
            }

            .sh-auth-header p {
                font-size: 0.85rem;
                margin-bottom: 0;
            }

            .sh-auth-group {
                margin-bottom: 15px;
            }

            .sh-auth-label {
                font-size: 0.8rem;
                margin-bottom: 6px;
            }

            .sh-auth-input {
                padding: 12px 14px 12px 42px;
                font-size: 0.9rem;
                border-radius: 10px;
            }

            .sh-auth-input-wrapper i {
                left: 14px;
                font-size: 0.9rem;
            }

            .sh-auth-checkbox-group {
                align-items: flex-start;
                gap: 10px;
                margin-bottom: 20px;
            }

            .sh-auth-checkbox-input {
                width: 18px;
                height: 18px;
                margin-top: 3px;
            }

            .sh-auth-checkbox-label {
                font-size: 0.85rem;
                line-height: 1.5;
            }

            .sh-auth-btn {
                padding: 14px;
                font-size: 0.95rem;
                margin-top: 5px;
                border-radius: 10px;
            }

            .sh-auth-footer {
                padding-top: 20px;
                margin-top: 20px;
            }

            .sh-auth-footer p {
                font-size: 0.85rem;
                margin-bottom: 12px;
            }

            .sh-auth-link {
                font-size: 0.85rem;
            }
        }
    </style>

    <div class="sh-auth-wrapper">
        <div class="sh-auth-split">
            
            <div class="sh-auth-hero">
                <div class="sh-auth-hero-blobs">
                    <div class="sh-auth-blob sh-auth-blob-1"></div>
                    <div class="sh-auth-blob sh-auth-blob-2"></div>
                </div>
                <div class="sh-auth-hero-content">
                    <h1 class="sh-auth-hero-title">{{ __('auth_pages.register_model.title') }}</h1>
                    <p class="sh-auth-hero-subtitle">
                        {{ __('auth_pages.register_model.subtitle') }}
                    </p>
                    <ul class="sh-auth-features">
                        <li class="sh-auth-feature-item">
                            <div class="sh-auth-feature-icon"><i class="fas fa-dollar-sign"></i></div>
                            {{ __('auth_pages.register_model.feature_earnings') }}
                        </li>
                        <li class="sh-auth-feature-item">
                            <div class="sh-auth-feature-icon"><i class="fas fa-globe"></i></div>
                            {{ __('auth_pages.register_model.feature_tools') }}
                        </li>
                        <li class="sh-auth-feature-item">
                            <div class="sh-auth-feature-icon"><i class="fas fa-user-shield"></i></div>
                            {{ __('auth_pages.register_model.feature_flexibility') }}
                        </li>
                        <li class="sh-auth-feature-item">
                            <div class="sh-auth-feature-icon"><i class="fas fa-chart-line"></i></div>
                            {{ __('auth_pages.register_model.feature_support') }}
                        </li>
                    </ul>
                </div>
            </div>

            
            <div class="sh-auth-form-side">
                <div class="sh-auth-form-container">
                    <div class="sh-auth-header">
                        <h2>{{ __('auth_pages.register_model.header_title') }}</h2>
                        <p>{{ __('auth_pages.register_model.header_subtitle') }}</p>
                    </div>

                    <form method="POST" action="{{ route('register.model.store') }}">
                        @csrf

                        
                        <div class="sh-auth-group">
                            <label class="sh-auth-label" for="name">{{ __('auth_pages.register.username_label') }}</label>
                            <div class="sh-auth-input-wrapper">
                                <i class="fas fa-crown"></i>
                                <input id="name" class="sh-auth-input" type="text" name="name" value="{{ old('name') }}"
                                    required autofocus autocomplete="name" placeholder="{{ __('auth_pages.register.username_placeholder') }}">
                            </div>
                            @error('name')
                                <p style="color: #ff4b4b; font-size: 0.8rem; margin-top: 8px;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        
                        <div class="sh-auth-group">
                            <label class="sh-auth-label" for="email">{{ __('auth_pages.register.email_label') }}</label>
                            <div class="sh-auth-input-wrapper">
                                <i class="fas fa-envelope"></i>
                                <input id="email" class="sh-auth-input" type="email" name="email" value="{{ old('email') }}"
                                    required autocomplete="username" placeholder="{{ __('auth_pages.register.email_placeholder') }}">
                            </div>
                            @error('email')
                                <p style="color: #ff4b4b; font-size: 0.8rem; margin-top: 8px;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        
                        <div class="sh-auth-group">
                            <label class="sh-auth-label" for="password">{{ __('auth_pages.register.password_label') }}</label>
                            <div class="sh-auth-input-wrapper">
                                <i class="fas fa-lock"></i>
                                <input id="password" class="sh-auth-input" type="password" name="password" required
                                    autocomplete="new-password" placeholder="{{ __('auth_pages.register.password_placeholder') }}">
                            </div>
                            @error('password')
                                <p style="color: #ff4b4b; font-size: 0.8rem; margin-top: 8px;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        
                        <div class="sh-auth-group">
                            <label class="sh-auth-label" for="password_confirmation">{{ __('auth_pages.register.confirm_password_label') }}</label>
                            <div class="sh-auth-input-wrapper">
                                <i class="fas fa-check-circle"></i>
                                <input id="password_confirmation" class="sh-auth-input" type="password"
                                    name="password_confirmation" required placeholder="{{ __('auth_pages.register.confirm_password_placeholder') }}">
                            </div>
                        </div>

                        <div class="sh-auth-checkbox-group">
                            <input type="checkbox" name="terms_accepted" id="terms_accepted" class="sh-auth-checkbox-input" required>
                            <label for="terms_accepted" class="sh-auth-checkbox-label">
                                {!! __('legal.clickwrap_acceptance') !!}
                            </label>
                        </div>
                        @error('terms_accepted')
                            <p style="color: #ff4b4b; font-size: 0.8rem; margin-top: -15px; margin-bottom: 15px;">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror

                        <button type="submit" class="sh-auth-btn">
                            {{ __('auth_pages.register_model.btn_register') }}
                            <i class="fas fa-rocket"></i>
                        </button>

                        <div class="sh-auth-footer">
                            <p>{{ __('auth_pages.register.have_account') }}</p>
                            <a href="{{ route('login') }}" class="sh-auth-link">
                                {{ __('auth_pages.register.login_now') }}
                            </a>
                            <div style="margin-top: 20px; opacity: 0.6; font-size: 0.8rem; color: #fff;">
                                {{ __('auth_pages.register.is_model') == 'Are you a model?' ? 'Want to be a fan?' : (__('auth_pages.register.is_model') == '¿Eres modelo?' ? '¿Quieres ser fan?' : 'Quer ser fã?') }} <a href="{{ route('register') }}"
                                    style="color: #FF4081; text-decoration: none;">{{ __('auth_pages.register.register_here') }}</a>
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
                sidebar.classList.add('sidebar-collapsed');
                mainContent.classList.add('sidebar-collapsed');
                localStorage.setItem('sidebarCollapsed', 'true');
            }
        });
    </script>
@endsection