@extends('layouts.public')
@section('content')
<style>
        .dashboard-container {
            padding: 2rem 2rem 4rem 2rem;
            max-width: 1400px;
            margin: 0 auto;
            /* Espaciado superior ajustado */
            padding-top: 24px;
        }

        /* 1. Hero / Título */
        .welcome-premium-card {
            background: transparent;
            border: none;
            box-shadow: none;
            padding: 0;
            margin-bottom: 48px;
            text-align: left;
        }



        .welcome-premium-card::before {
            display: none;
        }

        /* Las clases .page-title y .page-subtitle se heredan del layout public */



        /* 5. Botones */
        .welcome-actions {
            display: flex;
            justify-content: flex-start;
            gap: 1.5rem;
        }



        .btn-premium-lg {
            padding: 12px 28px;
            /* Ajuste solicitado */
            border-radius: 8px;
            /* Ajuste solicitado */
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            /* Ajuste solicitado */
            transition: all 0.2s ease-out;
            /* Ajuste solicitado */
            text-decoration: none;
        }

        .btn-premium-lg:hover {
            transform: scale(1.02);
            /* Ajuste solicitado */
        }

        .btn-gold {
            background: var(--gradient-gold);
            color: #000;
        }

        .btn-outline-white {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* 3. Grid Layout */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 24px;
            /* Ajuste solicitado */
            margin-bottom: 2rem;
        }

        .main-dash-column {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .side-dash-column {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* 2. Overrides for Components (Info Cards) */
        .stat-card-premium {
            border-radius: 12px !important;
            /* Ajuste solicitado */
            padding: 24px !important;
            /* Ajuste solicitado */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
            /* Ajuste solicitado */
            transition: all 0.2s ease-out !important;
            /* Ajuste solicitado */
            background: rgba(30, 30, 35, 0.6) !important;
            border: 1px solid rgba(255, 255, 255, 0.06) !important;
        }

        .stat-card-premium:hover {
            transform: translateY(-4px) !important;
            /* Ajuste solicitado */
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12) !important;
            border-color: rgba(212, 175, 55, 0.3) !important;
            background: rgba(40, 40, 45, 0.8) !important;
        }

        .stat-value-premium {
            font-size: 32px !important;
            /* Ajuste solicitado */
            font-weight: 700 !important;
            margin-bottom: 8px !important;
        }

        .stat-label-premium {
            font-size: 14px !important;
            /* Ajuste solicitado */
            opacity: 0.75 !important;
        }

        /* 4. Overrides for Favorites (Simulating Model Cards) */
        .fan-favorites-premium {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
        }

        .favorites-premium-header h3 {
            font-size: 24px !important;
            /* Título de sección */
            font-weight: 700 !important;
            margin-bottom: 16px !important;
        }

        .favorites-premium-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)) !important;
            gap: 24px !important;
        }

        .fav-card-premium {
            border-radius: 12px !important;
            /* Ajuste solicitado */
            overflow: hidden !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
            transition: all 0.2s ease-out !important;
            padding: 0 !important;
            background: #1a1a1a !important;
            border: none !important;
            position: relative;
        }


        .fav-card-premium:hover {
            transform: translateY(-4px) !important;
            /* Microinteracción */
        }

        .fav-card-visual {
            aspect-ratio: 4 / 5 !important;
            /* Ajuste solicitado */
            border-radius: 0 !important;
            position: relative;
        }

        /* Simular overlay de la solicitud */
        .fav-card-visual::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 35%;
            /* Ajuste solicitado */
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            pointer-events: none;
            z-index: 1;
        }

        .fav-card-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 2;
            padding: 12px !important;
            text-align: left !important;
            background: transparent !important;
        }

        .fav-name {
            font-size: 18px !important;
            /* Ajuste solicitado */
            font-weight: 700 !important;
            /* Ajuste a 700 para legibilidad */
            color: #FFFFFF !important;
            margin-bottom: 4px !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .fav-meta {
            color: rgba(255, 255, 255, 0.8) !important;
            font-size: 12px !important;
        }

        /* 6. Sección de Seguridad / Historial (Sidebar Widgets) */
        .sidebar-widget-premium {
            padding: 24px !important;
            /* Ajuste solicitado */
            border-radius: 12px !important;
            background: rgba(255, 255, 255, 0.03) !important;
            /* Ajuste solicitado */
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
        }

        .widget-header-premium {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .widget-title-premium {
            font-size: 18px !important;
            font-weight: 700 !important;
            color: #d4af37 !important;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
        }

        .widget-title-premium i {
            color: rgba(255, 255, 255, 0.85);
            font-size: 16px;
        }

        .view-all-link {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.4);
            text-decoration: none;
            font-weight: 600;
            white-space: nowrap;
            transition: color 0.3s ease;
        }

        .view-all-link:hover {
            color: var(--accent-gold);
        }

        /* Animación Fade In Global */
        .dashboard-container {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 1rem 0.75rem;
                padding-top: 12px;
            }

            .welcome-premium-card {
                text-align: center;
                margin-bottom: 28px;
            }

            .welcome-title {
                font-size: 28px;
            }

            .welcome-subtitle {
                font-size: 16px;
                margin-bottom: 18px;
                margin-left: auto;
                margin-right: auto;
            }

            .welcome-actions {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 0.75rem;
            }



            .btn-premium-lg {
                width: 100%;
                text-align: center;
                padding: 10px 20px;
                font-size: 14px;
            }


            .stat-value-premium {
                font-size: 24px !important;
            }

            .favorites-premium-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 12px !important;
            }

            .sidebar-widget-premium {
                padding: 16px !important;
                border-radius: 16px !important;
            }

            .widget-title-premium {
                font-size: 16px !important;
                margin-bottom: 12px;
            }

            .widget-header-premium {
                flex-wrap: wrap;
                gap: 8px;
            }
        }

        @media (max-width: 480px) {
            .dashboard-container {
                padding: 0.75rem;
                padding-top: 8px;
            }

            .welcome-premium-card {
                margin-bottom: 20px;
            }

            .welcome-title {
                font-size: 24px;
                margin-bottom: 10px;
            }

            .welcome-subtitle {
                font-size: 14px;
                margin-bottom: 14px;
            }

            .welcome-actions {
                gap: 0.65rem;
            }

            .btn-premium-lg {
                padding: 9px 16px;
                font-size: 13px;
                border-radius: 8px;
            }

            .dashboard-grid {
                gap: 16px;
            }
        }

        /* Sidebar Persistence Overrides */
        @media (min-width: 1025px) {
            #sidebar:not(.collapsed) {
                width: 240px;
                transform: translateX(0);
                opacity: 1;
                visibility: visible;
            }

            #sidebar:not(.collapsed) .sidebar-content {
                opacity: 1;
                visibility: visible;
            }

            body:not(.sidebar-collapsed) .main-content {
                margin-left: 240px;
                width: calc(100% - 240px);
            }
        }
    </style>
    <div class="dashboard-container">

        <div class="welcome-premium-card">
            <h1 class="page-title">{{ __('fan.dashboard.title', ['name' => auth()->user()->name]) }}</h1>
            <p class="page-subtitle">{{ __('fan.dashboard.subtitle') }}</p>
            <div class="welcome-actions">
                <a href="{{ route('fan.tokens.recharge') }}" class="btn-premium-lg btn-gold">
                    <i class="fas fa-coins" style="margin-right: 8px;"></i> {{ __('fan.dashboard.btn_buy_tokens') }}
                </a>
                <a href="{{ route('fan.subscriptions.index') }}" class="btn-premium-lg btn-outline-white">
                    {{ __('fan.dashboard.btn_view_subscriptions') }}
                </a>
            </div>

        </div>

        <div class="dashboard-grid">

            <div class="main-dash-column">

                <x-fan-stats-grid :stats="$stats" />
                <x-fan-xp-panel :userProgress="$userProgress" :currentLevel="$currentLevel" :nextLevel="$nextLevel"
                    :xpPercentage="$xpPercentage" :currentXP="$currentXP" :requiredXP="$requiredXP" />

               

                <x-fan-favorites-grid :favorites="$favorites" />
            </div>


            <div class="side-dash-column">

                <x-fan-missions-panel :obligatoryMission="$obligatoryMission" :weeklyMissions="$weeklyMissions" />

                

                <style>
                    .activity-item-compact {
                        display: flex;
                        align-items: center;
                        gap: 12px;
                        padding: 12px 0;
                        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
                    }
                    .activity-item-compact:last-child {
                        border-bottom: none;
                    }
                    .activity-type-dot {
                        width: 8px;
                        height: 8px;
                        border-radius: 50%;
                        flex-shrink: 0;
                    }
                    .activity-type-dot.spent { background: var(--color-rosa-vibrante); }
                    .activity-type-dot.recharge, .activity-type-dot.purchase { background: #3b82f6; }
                    .activity-type-dot.earned { background: #10b981; }
                    .activity-details {
                        flex: 1;
                        display: flex;
                        flex-direction: column;
                    }
                    .activity-main-line {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        font-size: 0.9rem;
                    }
                    .activity-user {
                        font-weight: 600;
                        color: #fff;
                    }
                    .amount-negative { color: var(--color-rosa-vibrante); font-weight: 600; }
                    .amount-positive { color: #10b981; font-weight: 600; }
                    .activity-time {
                        font-size: 0.75rem;
                        color: rgba(255, 255, 255, 0.4);
                        margin-top: 2px;
                    }
                    .activity-blank {
                        text-align: center;
                        padding: 20px 0;
                        opacity: 0.5;
                        display: flex;
                        flex-direction: column;
                        gap: 8px;
                    }
                </style>
                <div class="sidebar-widget-premium">
                    <div class="widget-header-premium">
                        <h3 class="widget-title-premium">
                             {{ __('fan.dashboard.recent_activity') }}
                        </h3>
                        <a href="{{ route('fan.tokens.history') }}" class="view-all-link">{{ __('fan.dashboard.view_all') }}</a>
                    </div>
 
                    <div class="activity-stack">
                        @forelse($recentActivity as $activity)
                            <div class="activity-item-compact">
                                <div class="activity-type-dot {{ $activity->type }}"></div>
                                <div class="activity-details">
                                    <div class="activity-main-line">
                                        <span class="activity-user">{{ $activity->main_line }}</span>
                                        <span class="activity-amount {{ $activity->amount_class }}">{{ $activity->amount }}</span>
                                    </div>
                                    <span class="activity-time">{{ $activity->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="activity-blank">
                                <i class="fas fa-moon"></i>
                                <span>{{ __('fan.dashboard.no_activity') }}</span>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log('Fan Dashboard Premium Loaded');
            const sidebar = document.getElementById('sidebar');
            const body = document.body;
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            if (sidebar && window.innerWidth > 1024) {
                sidebar.classList.remove('collapsed');
                body.classList.remove('sidebar-collapsed');
                if (hamburgerBtn) hamburgerBtn.classList.add('active');
                localStorage.setItem('sidebarCollapsed', 'false');
            }
        });
    </script>
@endsection