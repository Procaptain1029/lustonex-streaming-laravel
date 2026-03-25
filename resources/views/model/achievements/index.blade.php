@extends('layouts.model')

@section('title', __('model.achievements.title'))

@section('breadcrumb')
    <a href="{{ route('model.dashboard') }}" class="breadcrumb-item">{{ __('model.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('model.achievements.breadcrumb') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Model Achievements Professional Styling ----- */

        .page-header {
            padding-top: 32px;
            margin-bottom: 28px;
        }

        /* Estilos de encabezado heredados del layout model */

        /* Stats Grid — 3 cols desktop, 2 tablet/mobile */
        .sh-stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 32px;
        }

        .sh-stat-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 20px 16px;
            display: flex;
            align-items: center;
            gap: 14px;
            backdrop-filter: blur(10px);
            min-width: 0; /* prevent overflow in grid */
        }

        .sh-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(212, 175, 55, 0.1);
            color: var(--model-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .sh-stat-content {
            display: flex;
            flex-direction: column;
            min-width: 0;
            overflow: hidden;
        }

        .sh-stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
            white-space: nowrap;
        }

        .sh-stat-label {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Achievements Grid */
        .sh-achievements-container {
            padding-bottom: 80px;
        }

        .sh-achievements-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 16px;
        }

        .sh-achi-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            gap: 16px;
            transition: all 0.2s ease-out;
            position: relative;
            overflow: hidden;
        }

        .sh-achi-card:hover {
            transform: translateY(-4px);
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        /* Locked State */
        .sh-achi-card.locked {
            opacity: 0.6;
            border-style: dashed;
            background: rgba(0, 0, 0, 0.2);
        }

        .sh-achi-card.locked .sh-achi-icon {
            filter: grayscale(100%);
            opacity: 0.5;
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        /* Unlocked State */
        .sh-achi-card.unlocked {
            border: 1px solid rgba(212, 175, 55, 0.3);
            background: linear-gradient(180deg, rgba(212, 175, 55, 0.05) 0%, rgba(0, 0, 0, 0) 100%);
        }

        .sh-achi-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: rgba(212, 175, 55, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: var(--model-gold);
            flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .sh-achi-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-width: 0;
        }

        .sh-achi-title {
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 4px;
            line-height: 1.3;
            padding-right: 56px; /* Space for rarity badge */
        }

        .sh-achi-desc {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.5;
            margin-bottom: 10px;
        }

        /* Progress Bar */
        .sh-progress-wrapper {
            margin-top: auto;
        }

        .sh-progress-bar {
            height: 5px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 5px;
        }

        .sh-progress-fill {
            height: 100%;
            background: var(--model-gold);
            border-radius: 3px;
        }

        .sh-progress-text {
            font-size: 11px;
            color: var(--model-gold);
            font-weight: 600;
            text-align: right;
        }

        /* Badges */
        .sh-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 700;
            color: #28a745;
            background: rgba(40, 167, 69, 0.1);
            padding: 3px 8px;
            border-radius: 20px;
            margin-top: 6px;
            width: fit-content;
        }

        .sh-rarity-badge {
            position: absolute;
            top: 16px;
            right: 14px;
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            padding: 3px 7px;
            border-radius: 6px;
            letter-spacing: 0.5px;
        }

        .rarity-common {
            background: rgba(108, 117, 125, 0.2);
            color: #adb5bd;
            border: 1px solid rgba(108, 117, 125, 0.3);
        }

        .rarity-rare {
            background: rgba(0, 123, 255, 0.2);
            color: #4dabf7;
            border: 1px solid rgba(0, 123, 255, 0.3);
        }

        .rarity-epic {
            background: rgba(111, 66, 193, 0.2);
            color: #d63384;
            border: 1px solid rgba(111, 66, 193, 0.3);
        }

        .rarity-legendary {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
            box-shadow: 0 0 10px rgba(255, 193, 7, 0.2);
        }

        /* ---- Tablet (≤ 768px) ---- */
        @media (max-width: 768px) {
            .page-header {
                padding-top: 20px;
                margin-bottom: 20px;
            }

            .page-header {
                padding-top: 20px;
                margin-bottom: 20px;
            }

            /* Estilos responsivos de encabezado heredados */

            /* 3 stat cards side by side but compact */
            .sh-stats-row {
                grid-template-columns: repeat(3, 1fr);
                gap: 10px;
                margin-bottom: 20px;
            }

            .sh-stat-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
                padding: 14px 12px;
            }

            .sh-stat-icon {
                width: 38px;
                height: 38px;
                font-size: 16px;
            }

            .sh-stat-value {
                font-size: 18px;
            }

            .sh-stat-label {
                font-size: 9px;
                letter-spacing: 0.3px;
            }

            /* Achievements: single column */
            .sh-achievements-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .sh-achi-card {
                padding: 16px;
                gap: 14px;
            }
        }

        /* Estilos responsivos heredados */

        /* ---- Mobile (≤ 480px) ---- */
        @media (max-width: 480px) {
            .sh-stat-card {
                padding: 12px 10px;
            }

            .sh-stat-value {
                font-size: 16px;
            }

            .sh-stat-label {
                font-size: 8px;
            }

            .sh-stat-icon {
                width: 32px;
                height: 32px;
                font-size: 14px;
            }
        }
    </style>
@endsection

@section('content')

    <div class="page-header">
        <h1 class="page-title">{{ __('model.achievements.title') }}</h1>
        <p class="page-subtitle">{{ __('model.achievements.subtitle') }}</p>
    </div>

    <!-- Stats Row -->
    <div class="sh-stats-row">
        <div class="sh-stat-card">
            <div class="sh-stat-icon"><i class="fas fa-trophy"></i></div>
            <div class="sh-stat-content">
                <span class="sh-stat-value">{{ $stats['unlocked'] }} / {{ $stats['total'] }}</span>
                <span class="sh-stat-label">{{ __('model.achievements.stats.unlocked') }}</span>
            </div>
        </div>
        <div class="sh-stat-card">
            <div class="sh-stat-icon" style="color: #28a745; background: rgba(40,167,69,0.1);"><i
                    class="fas fa-chart-pie"></i></div>
            <div class="sh-stat-content">
                <span class="sh-stat-value">{{ number_format($stats['completion_percentage'], 0) }}%</span>
                <span class="sh-stat-label">{{ __('model.achievements.stats.completion') }}</span>
            </div>
        </div>
        <div class="sh-stat-card">
            <div class="sh-stat-icon" style="color: #0dcaf0; background: rgba(13,202,240,0.1);"><i class="fas fa-medal"></i>
            </div>
            <div class="sh-stat-content">
                <span class="sh-stat-value">{{ $userProgress->current_rank ?? 'N/A' }}</span>
                <span class="sh-stat-label">{{ __('model.achievements.stats.current_rank') }}</span>
            </div>
        </div>
    </div>

    <div class="sh-achievements-container">
        <div class="sh-achievements-grid">
            @foreach($achievementsData as $achievement)
                <div class="sh-achi-card {{ $achievement['unlocked'] ? 'unlocked' : 'locked' }}">

                    <div class="sh-rarity-badge rarity-{{ $achievement['rarity'] }}">
                        {{ __('model.achievements.rarity.' . $achievement['rarity']) }}
                    </div>

                    <div class="sh-achi-icon">
                        <i class="fas {{ $achievement['icon'] }}"></i>
                    </div>

                    <div class="sh-achi-body">
                        <h3 class="sh-achi-title">{{ $achievement['name'] }}</h3>
                        <p class="sh-achi-desc">{{ $achievement['description'] }}</p>

                        @if(!$achievement['unlocked'])
                            <div class="sh-progress-wrapper" style="width: 100%;">
                                <div class="sh-progress-bar">
                                    <div class="sh-progress-fill"
                                        style="width: {{ ($achievement['progress'] / $achievement['target']) * 100 }}%"></div>
                                </div>
                                <div class="sh-progress-text">
                                    {{ $achievement['progress'] }} / {{ $achievement['target'] }}
                                </div>
                            </div>
                        @else
                            <div class="sh-status-badge">
                                <i class="fas fa-check-circle"></i> {{ __('model.achievements.status.completed') }}
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection