@extends('layouts.public')

@section('content')
    <style>
        /* Inherited Styles for Model Cards */
        .sh-models-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 24px;
            width: 100%;
            padding-bottom: 24px;
        }

        .sh-model-card {
            flex: 1 1 220px;
            max-width: 250px;
            border-radius: 12px;
            overflow: hidden;
            background: rgba(31, 31, 35, 0.5);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.05);
            display: block;
            text-decoration: none;
        }

        .sh-model-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.2);
            border-color: rgba(212, 175, 55, 0.3);
            z-index: 2;
        }

        .sh-card-image-wrapper {
            aspect-ratio: 4/5;
            position: relative;
            background: #000;
            overflow: hidden;
        }

        .sh-card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .sh-model-card:hover .sh-card-image {
            transform: scale(1.05);
        }

        /* Ultra-Premium Badges */
        @keyframes sh-fade-in {
            from { opacity: 0; transform: translateY(2px); }
            to { opacity: 0.95; transform: translateY(0); }
        }

        .sh-badge-premium {
            position: absolute;
            z-index: 10;
            height: 20px;
            padding: 0 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1px;
            line-height: 1.1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            border: none;
            box-shadow: none;
            opacity: 0.95;
            transition: opacity 120ms ease-in-out, transform 120ms ease-in-out;
            animation: sh-fade-in 160ms ease-out both;
            color: #fff;
            pointer-events: none;
        }

        .sh-badge-premium:hover {
            opacity: 0.85;
        }

        .sh-badge-premium i {
            font-size: 11px;
            font-weight: 300;
        }

        .sh-badge-live {
            top: 12px;
            left: 12px;
            background: #C44545; /* Carmesí oscuro */
        }

        .sh-badge-new {
            top: 12px;
            right: 12px;
            background: #8FCFA8; /* Jade profundo */
            color: #1a3d2c; /* Contrast for Jade */
        }

        .sh-badge-favorite {
            top: 12px;
            right: 12px;
            background: #E88A9A; /* Coral premium */
        }

        .sh-badge-vip {
            top: 12px;
            right: 12px;
            background: #9D81B1; /* Lavanda profundo/Vip */
        }

        .sh-badge-viewers {
            top: 12px;
            right: 12px;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .sh-card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 40%;
            background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 16px;
        }

        .sh-model-name {
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            margin: 0 0 4px 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .sh-model-location {
            color: rgba(255, 255, 255, 0.7);
            font-size: 12px;
            font-weight: 500;
            display: flex; 
            align-items: center; 
            gap: 4px;
        }

        @media (max-width: 768px) {
            .sh-models-grid {
                gap: 16px;
                padding-bottom: 16px;
                justify-content: flex-start;
            }
            .sh-model-card {
                flex: 1 1 calc(50% - 16px);
                max-width: calc(50% - 8px);
            }
            /* Card compact style for mobile */
            .sh-card-overlay { padding: 10px; }
            .sh-model-name { font-size: 14px; }
            .sh-model-location { font-size: 10px; }

            /* Adjust badges for mobile to prevent overlapping */
            .sh-badge-premium {
                padding: 0 5px;
                font-size: 9px;
                height: 18px;
                border-radius: 4px;
                gap: 3px;
            }
            .sh-badge-premium i {
                font-size: 9px !important;
            }
            .sh-badge-live {
                top: 8px;
                left: 8px;
            }
            .sh-badge-new, .sh-badge-favorite, .sh-badge-vip, .sh-badge-viewers {
                top: 8px;
                right: 8px;
            }
        }
    </style>
  

    
    <style>
        @media (max-width: 769px) {
            .btn-mobile-hide {
                display: none !important;
            }
        }

        .btn-ver-todas {
            background: linear-gradient(135deg, #d4af37, #f4e37d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-decoration: none;
            transition: opacity 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-ver-todas i {
            -webkit-text-fill-color: #d4af37; /* Icon color doesn't clip well, so use solid gold */
        }

        .btn-ver-todas:hover {
            opacity: 1;
            filter: drop-shadow(0 0 8px rgba(212, 175, 55, 0.8));
            transform: scale(1.02);
        }
    </style>
    <section class="container" >
        <div id="nuevas" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h4 class="text-title text-gradient-gold" style="font-size: 20px;">
                {{ __('welcome.new_models') }}
            </h4>
            @if($nuevasModelos && $nuevasModelos->count() > 0)
                <a href="{{ route('modelos.nuevas') }}" class="btn-ver-todas btn-mobile-hide">
                    {{ __('welcome.view_all') }} <i class="fas fa-arrow-right"></i>
                </a>
            @endif
        </div>

        @if($nuevasModelos && $nuevasModelos->count() > 0)
            <div class="sh-models-grid">
                @foreach ($nuevasModelos as $model)
                    <a href="{{ route('profiles.show', ['model' => $model->id]) }}" class="sh-model-card">
                        <div class="sh-card-image-wrapper">
                            @if($model->profile && $model->profile->avatar)
                                <img src="{{ $model->profile->avatar_url }}" alt="{{ $model->name }}" class="sh-card-image" loading="lazy" decoding="async" onerror="this.onerror=null;this.src='{{ asset('images/placeholder-avatar.svg') }}'">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #1a1a1a;">
                                    <i class="fas fa-user" style="font-size: 48px; color: rgba(255,255,255,0.1);"></i>
                                </div>
                            @endif

                         
                            
                            <div class="sh-badge-premium sh-badge-new">
                                <i class="far fa-star"></i> {{ __('welcome.new_badge') }}
                            </div>

                            <div class="sh-card-overlay">
                                <h3 class="sh-model-name">
                                    {{ $model->profile->display_name ?? $model->name }}
                                    @if($model->is_verified)
                                        <i class="fas fa-check-circle" style="color: #1da1f2; font-size: 14px;" title="{{ __('welcome.verified') }}"></i>
                                    @endif
                                </h3>
                                <div class="sh-model-location">
                                    <span class="fi fi-{{ $model->profile->country }}"></span> 
                                    {{ $model->profile->city ?? __('welcome.international') }}
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div
                style="text-align: center; padding: 4rem 2rem; background: rgba(255, 255, 255, 0.02); border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.05);">
                <div style="margin-bottom: 1rem;">
                    <i class="fas fa-search" style="font-size: 48px; color: var(--color-oro-sensual); margin-bottom: 20px; opacity: 0.5;"></i>
                </div>
                <h3 style="color: rgba(255, 255, 255, 0.6); font-size: 1.2rem; margin-bottom: 0.5rem;">{{ __('welcome.no_new_models') }}
                </h3>
                <p style="color: rgba(255, 255, 255, 0.4); font-size: 0.9rem;">{{ __('welcome.no_new_models_desc') }}</p>
            </div>
        @endif
    </section>



    
    <section class="container" style="padding: 1rem 2rem;" id="vip-semana">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h4 class="text-title" style="font-size: 20px; display: flex; align-items: center; gap: 0.75rem;">
              
                <span class="text-gradient-gold">{{ __('welcome.vip_week') }}</span>
            </h4>
            <a href="{{ route('modelos.vip') }}" class="btn-ver-todas btn-mobile-hide">
                {{ __('welcome.view_all') }} <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        @if($vipPopularModelos && $vipPopularModelos->count() > 0)
            <div class="sh-models-grid">
                @foreach ($vipPopularModelos as $model)
                    <a href="{{ route('profiles.show', ['model' => $model->id]) }}" class="sh-model-card">
                        <div class="sh-card-image-wrapper">
                            @if($model->profile && $model->profile->avatar)
                                <img src="{{ $model->profile->avatar_url }}" alt="{{ $model->name }}" class="sh-card-image" loading="lazy" decoding="async" onerror="this.onerror=null;this.src='{{ asset('images/placeholder-avatar.svg') }}'">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #1a1a1a;">
                                    <i class="fas fa-user" style="font-size: 48px; color: rgba(255,255,255,0.1);"></i>
                                </div>
                            @endif

                           
                            
                            <div class="sh-badge-premium sh-badge-vip">
                                <i class="far fa-crown"></i> {{ __('welcome.vip_badge') }}
                            </div>

                            <div class="sh-card-overlay">
                                <h3 class="sh-model-name">
                                    {{ $model->profile->display_name ?? $model->name }}
                                    @if($model->is_verified)
                                        <i class="fas fa-check-circle" style="color: #1da1f2; font-size: 14px;" title="{{ __('welcome.verified') }}"></i>
                                    @endif
                                </h3>
                                <div class="sh-model-location">
                                    <span class="fi fi-{{ $model->profile->country }}"></span> 
                                    {{ $model->profile->city ?? __('welcome.international') }}
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div
                style="text-align: center; padding: 4rem 2rem; background: rgba(255, 255, 255, 0.02); border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.05);">
                <div style="margin-bottom: 1rem;">
                    <i class="fas fa-search" style="font-size: 48px; color: var(--color-oro-sensual); margin-bottom: 20px; opacity: 0.5;"></i>
                </div>
                <h3 style="color: rgba(255, 255, 255, 0.6); font-size: 1.2rem; margin-bottom: 0.5rem;">{{ __('welcome.no_vip') }}</h3>
                <p style="color: rgba(255, 255, 255, 0.4); font-size: 0.9rem;">{{ __('welcome.no_vip_desc') }}</p>
            </div>
        @endif
    </section>

    
    <section class="container" style="padding: 1rem 2rem;" id="favoritas">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h4 class="text-title text-gradient-gold" style="font-size: 20px;">
                {{ __('welcome.favorites') }}
            </h4>
            @if($favoritasModelos && $favoritasModelos->count() > 0)
                <a href="{{ route('modelos.favoritas') }}" class="btn-ver-todas btn-mobile-hide">
                    {{ __('welcome.view_all') }} <i class="fas fa-arrow-right"></i>
                </a>
            @endif
        </div>

        @if($favoritasModelos && $favoritasModelos->count() > 0)
            <div class="sh-models-grid">
                @foreach ($favoritasModelos as $model)
                    <a href="{{ route('profiles.show', ['model' => $model->id]) }}" class="sh-model-card">
                        <div class="sh-card-image-wrapper">
                            @if($model->profile && $model->profile->avatar)
                                <img src="{{ $model->profile->avatar_url }}" alt="{{ $model->name }}" class="sh-card-image" loading="lazy" decoding="async" onerror="this.onerror=null;this.src='{{ asset('images/placeholder-avatar.svg') }}'">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #1a1a1a;">
                                    <i class="fas fa-user" style="font-size: 48px; color: rgba(255,255,255,0.1);"></i>
                                </div>
                            @endif

                          
                            
                            <div class="sh-badge-premium sh-badge-favorite">
                                <i class="far fa-heart"></i> {{ __('welcome.favorite_badge') }}
                            </div>

                            <div class="sh-card-overlay">
                                <h3 class="sh-model-name">
                                    {{ $model->profile->display_name ?? $model->name }}
                                    @if($model->is_verified)
                                        <i class="fas fa-check-circle" style="color: #1da1f2; font-size: 14px;" title="Verificado"></i>
                                    @endif
                                </h3>
                                <div class="sh-model-location">
                                    <span class="fi fi-{{ $model->profile->country }}"></span> 
                                    {{ $model->profile->city ?? 'Internacional' }}
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div
                style="text-align: center; padding: 4rem 2rem; background: rgba(255, 255, 255, 0.02); border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.05);">
                <div style="margin-bottom: 1rem;">
                    <i class="fas fa-search" style="font-size: 48px; color: var(--color-oro-sensual); margin-bottom: 20px; opacity: 0.5;"></i>
                </div>
                <h3 style="color: rgba(255, 255, 255, 0.6); font-size: 1.2rem; margin-bottom: 0.5rem;">{{ __('welcome.no_favorites') }}</h3>
                <p style="color: rgba(255, 255, 255, 0.4); font-size: 0.9rem;">{{ __('welcome.no_favorites_desc') }}</p>
            </div>
        @endif
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Force sidebar expand for home view
            const sidebar = document.getElementById('sidebar');
            const body = document.body;
            const hamburgerBtn = document.getElementById('hamburgerBtn');

            if (sidebar && window.innerWidth > 1024) {
                sidebar.classList.remove('collapsed');
                body.classList.remove('sidebar-collapsed');
                localStorage.setItem('sidebarCollapsed', 'false');
                if (hamburgerBtn) hamburgerBtn.classList.add('active');
            }
        });
    </script>
@endsection