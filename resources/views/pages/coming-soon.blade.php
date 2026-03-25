@extends('layouts.public')

@section('content')
    <style>
        .coming-soon-container {
            padding: 4rem 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 60vh;
            text-align: center;
        }

        .icon-wrapper {
            margin-bottom: 2rem;
            position: relative;
        }

        .glow-effect {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100px;
            height: 100px;
            background: var(--color-oro-sensual);
            filter: blur(40px);
            opacity: 0.2;
            border-radius: 50%;
        }

        .main-icon {
            font-size: 5rem;
            background: var(--gradient-gold);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .coming-soon-title {
            font-size: 3rem;
            margin-bottom: 1rem;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
        }

        .coming-soon-desc {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.2rem;
            max-width: 600px;
            line-height: 1.6;
            margin-bottom: 3rem;
        }

        .info-box {
            padding: 2rem;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 16px;
            border: 1px solid rgba(212, 175, 55, 0.1);
            max-width: 500px;
            width: 100%;
        }

        .info-box-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .info-box-icon {
            color: var(--color-oro-sensual);
            font-size: 1.5rem;
        }

        .info-box-title {
            color: white;
            margin: 0;
            font-size: 1.2rem;
        }

        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
            text-align: left;
        }

        .info-list-item {
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255, 255, 255, 0.6);
        }

        .check-icon {
            color: var(--color-oro-sensual);
            font-size: 0.8rem;
        }

        .info-link {
            color: var(--color-oro-sensual);
            text-decoration: none;
        }

        .action-btn-container {
            margin-top: 3rem;
        }

        .action-btn {
            padding: 12px 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .coming-soon-container {
                padding: 2rem 1.5rem;
                min-height: 50vh;
            }

            .icon-wrapper {
                margin-bottom: 1.5rem;
            }

            .main-icon {
                font-size: 3.5rem;
            }

            .coming-soon-title {
                font-size: 2rem;
            }

            .coming-soon-desc {
                font-size: 1rem;
                margin-bottom: 2rem;
            }

            .info-box {
                padding: 1.5rem;
            }

            .info-box-title {
                font-size: 1.1rem;
            }

            .info-list-item {
                font-size: 0.95rem;
            }
        }
    </style>

    <div class="coming-soon-container">
        <div class="icon-wrapper">
            
            <div class="glow-effect"></div>
            <i class="fas fa-clock main-icon"></i>
        </div>

        <h1 class="text-gradient-gold coming-soon-title">
            {{ $title ?? __('pages.coming_soon.title') }}
        </h1>

        <p class="coming-soon-desc">
            {{ $description ?? __('pages.coming_soon.desc') }}
        </p>

        <div class="info-box">
            <div class="info-box-header">
                <i class="fas fa-info-circle info-box-icon"></i>
                <h3 class="info-box-title">{{ __('pages.coming_soon.box_title') }}</h3>
            </div>
            <ul class="info-list">
                <li class="info-list-item">
                    <i class="fas fa-check check-icon"></i>
                    {{ __('pages.coming_soon.streams') }} <a href="{{ route('home') }}" class="info-link">streams en vivo</a>
                </li>
                <li class="info-list-item">
                    <i class="fas fa-check check-icon"></i>
                    {{ __('pages.coming_soon.new_models') }} <a href="{{ route('modelos.nuevas') }}" class="info-link">nuevas modelos</a>
                </li>
                <li class="info-list-item">
                    <i class="fas fa-check check-icon"></i>
                    <a href="{{ route('register.model') }}" class="info-link">{{ __('pages.coming_soon.register_model') }}</a>
                </li>
            </ul>
        </div>

        <div class="action-btn-container">
            <a href="{{ route('home') }}" class="btn-primary action-btn">
                <i class="fas fa-home" style="margin-right: 8px;"></i> {{ __('pages.coming_soon.back_home') }}
            </a>
        </div>
    </div>
@endsection