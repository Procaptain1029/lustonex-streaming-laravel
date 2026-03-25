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

        /* Left: Hero/Branding Section */
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
                radial-gradient(circle at 20% 30%, rgba(212, 175, 55, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(244, 227, 125, 0.1) 0%, transparent 40%);
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
            background: #D4AF37;
            top: -100px;
            left: -100px;
        }

        .sh-auth-blob-2 {
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
            background: linear-gradient(135deg, #D4AF37, #F4E37D);
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
            margin-bottom: 30px;
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
            line-height: 1.5;
        }

        /* success message */
        .success-message {
            background: rgba(0, 255, 136, 0.1);
            border: 1px solid rgba(0, 255, 136, 0.3);
            color: #00ff88;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Buttons */
        .sh-auth-btn {
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
            text-decoration: none;
        }

        .sh-auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.3);
        }

        .sh-auth-btn-secondary {
            background: transparent;
            color: rgba(255, 255, 255, 0.5);
            border: none;
            margin-top: 20px;
            box-shadow: none;
        }

        .sh-auth-btn-secondary:hover {
            color: #D4AF37;
            transform: translateY(-2px);
            background: transparent;
            box-shadow: none;
        }

        /* Footer Help */
        .sh-auth-footer-help {
            margin-top: 40px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding-top: 20px;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.4);
            text-align: center;
            line-height: 1.5;
        }
        
        .sh-auth-footer-help a {
            color: #D4AF37;
            text-decoration: none;
        }
        
        .sh-auth-footer-help a:hover {
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
                padding: 20px 10px;
                min-height: calc(100vh - 60px);
            }

            .sh-auth-split {
                border-radius: 20px;
            }

            .sh-auth-form-side {
                padding: 30px 20px;
            }

            .sh-auth-header {
                margin-bottom: 25px;
            }

            .sh-auth-header h2 {
                font-size: 1.5rem;
            }

            .sh-auth-header p {
                font-size: 0.85rem;
            }

            .sh-auth-btn {
                padding: 14px;
                font-size: 0.95rem;
                border-radius: 10px;
            }
        }

        @media (max-width: 480px) {
            .sh-auth-wrapper {
                padding: 15px 0;
                min-height: calc(100vh - 60px);
            }

            .sh-auth-split {
                border: none;
                border-radius: 0;
                background: transparent;
                box-shadow: none;
            }

            .sh-auth-form-side {
                background: transparent;
                padding: 15px;
            }

            .sh-auth-form-container {
                max-width: 100%;
            }

            .sh-auth-header {
                margin-bottom: 20px;
            }

            .sh-auth-header h2 {
                font-size: 1.3rem;
                margin-bottom: 8px;
            }

            .sh-auth-header p {
                font-size: 0.8rem;
            }

            .sh-auth-btn {
                padding: 12px;
                font-size: 0.9rem;
                border-radius: 8px;
                margin-top: 5px;
            }
        }
    </style>

    <div class="sh-auth-wrapper">
        <div class="sh-auth-split">
            <!-- Left: Hero/Branding Section -->
            <div class="sh-auth-hero">
                <div class="sh-auth-hero-blobs">
                    <div class="sh-auth-blob sh-auth-blob-1"></div>
                    <div class="sh-auth-blob sh-auth-blob-2"></div>
                </div>
                <div class="sh-auth-hero-content">
                    <h1 class="sh-auth-hero-title">{{ __('auth_pages.verify_email.title') }}</h1>
                    <p class="sh-auth-hero-subtitle">
                        {{ __('auth_pages.verify_email.subtitle') }}
                    </p>
                </div>
            </div>

            <!-- Right: Form Section -->
            <div class="sh-auth-form-side">
                <div class="sh-auth-form-container">
                    <div class="sh-auth-header">
                        <h2>{{ __('auth_pages.verify_email.title') }}</h2>
                        <p>{{ __('auth_pages.verify_email.subtitle') }}</p>
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div class="success-message">
                            <i class="fas fa-check-circle"></i>
                            {{ __('auth_pages.verify_email.link_sent') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="sh-auth-btn">
                            <i class="fas fa-paper-plane"></i>
                            {{ __('auth_pages.verify_email.btn_resend') }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="sh-auth-btn sh-auth-btn-secondary">
                            <i class="fas fa-sign-out-alt"></i>
                            {{ __('auth_pages.verify_email.btn_logout') }}
                        </button>
                    </form>

                    <div class="sh-auth-footer-help">
                        ¿No recibiste el correo? Revisa tu carpeta de spam o contacta con nuestro <a href="#">soporte VIP</a>.
                    </div>
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