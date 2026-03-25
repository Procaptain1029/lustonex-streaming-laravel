@extends('layouts.model')

@section('title', __('model.leaderboard.title'))

@section('breadcrumb')
    <a href="{{ route('model.dashboard') }}" class="breadcrumb-item">{{ __('model.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('model.leaderboard.title') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Premium Leaderboard Styling ----- */

        .leaderboard-wrapper {
            padding-top: 32px;
            padding-bottom: 80px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .page-header {
            margin-bottom: 32px;
            text-align: center;
        }

        /* Estilos de encabezado heredados del layout model */

        /* Filters */
        .sh-filters-bar {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 36px;
            flex-wrap: wrap;
        }

        .sh-filter-chip {
            padding: 8px 20px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.02);
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .sh-filter-chip:hover,
        .sh-filter-chip.active {
            background: rgba(255, 255, 255, 0.1);
            border-color: #fff;
            color: #fff;
            font-weight: 600;
        }

        .sh-filter-chip.active {
            border-color: var(--model-gold);
            color: var(--model-gold);
        }

        /* Podium (Top 3) */
        .sh-podium {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            gap: 24px;
            margin-bottom: 48px;
            flex-wrap: wrap;
        }

        .sh-podium-card {
            background: rgba(31, 31, 35, 0.6);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 32px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            text-align: center;
            position: relative;
            transition: all 0.3s ease;
            width: 280px;
        }

        .sh-podium-card.rank-1 {
            transform: scale(1.1);
            z-index: 2;
            border-color: rgba(255, 215, 0, 0.4);
            box-shadow: 0 0 30px rgba(255, 215, 0, 0.15);
            order: 2;
        }

        .sh-podium-card.rank-2 {
            border-color: rgba(192, 192, 192, 0.3);
            box-shadow: 0 0 20px rgba(192, 192, 192, 0.1);
            order: 1;
        }

        .sh-podium-card.rank-3 {
            border-color: rgba(205, 127, 50, 0.3);
            box-shadow: 0 0 20px rgba(205, 127, 50, 0.1);
            order: 3;
        }

        .sh-podium-img-wrapper {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 16px;
        }

        .sh-podium-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.1);
        }

        .rank-1 .sh-podium-img { border-color: #FFD700; }
        .rank-2 .sh-podium-img { border-color: #C0C0C0; }
        .rank-3 .sh-podium-img { border-color: #CD7F32; }

        .sh-podium-badge {
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            color: #000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .rank-1 .sh-podium-badge { background: #FFD700; }
        .rank-2 .sh-podium-badge { background: #C0C0C0; }
        .rank-3 .sh-podium-badge { background: #CD7F32; }

        .sh-podium-name {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 8px;
        }

        .sh-podium-score {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
            background: rgba(0, 0, 0, 0.2);
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-block;
        }

        /* Ranking Table */
        .sh-ranking-table {
            background: rgba(31, 31, 35, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            overflow: hidden;
        }

        .sh-ranking-row {
            display: grid;
            grid-template-columns: 80px 1fr 150px;
            padding: 16px 24px;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            transition: background 0.2s ease;
        }

        .sh-ranking-row:hover { background: rgba(255, 255, 255, 0.03); }
        .sh-ranking-row:last-child { border-bottom: none; }

        .sh-ranking-header {
            font-weight: 700;
            color: rgba(255, 255, 255, 0.5);
            background: rgba(0, 0, 0, 0.2);
            padding: 12px 24px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sh-rank-num {
            font-size: 18px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.4);
        }

        .sh-rank-user {
            display: flex;
            align-items: center;
            gap: 16px;
            min-width: 0;
        }

        .sh-rank-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }

        /* Avatar in the "your position" card — always bigger */
        .sh-current-user-rank .sh-rank-avatar {
            width: 52px;
            height: 52px;
            min-width: 52px;
            min-height: 52px;
        }

        .sh-rank-name {
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sh-rank-score {
            font-size: 16px;
            font-weight: 700;
            color: var(--model-gold);
            text-align: right;
        }

        /* Your Position Section */
        .sh-current-user-rank {
            background: linear-gradient(90deg, rgba(212, 175, 55, 0.1), rgba(212, 175, 55, 0.02));
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 12px;
            padding: 20px 24px;
            margin-bottom: 36px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .sh-user-rank-info {
            display: flex;
            align-items: center;
            gap: 20px;
            min-width: 0;
        }

        .sh-user-rank-position {
            font-size: 32px;
            font-weight: 800;
            color: var(--model-gold);
            flex-shrink: 0;
        }

        /* ---- Tablet (≤ 768px) ---- */
        @media (max-width: 768px) {
            .leaderboard-wrapper {
                padding-top: 20px;
            }

            .page-header {
                margin-bottom: 24px;
            }

            .page-header {
                margin-bottom: 24px;
            }

            /* Estilos responsivos de encabezado heredados */

            .sh-filters-bar {
                gap: 8px;
                margin-bottom: 24px;
            }

            .sh-filter-chip {
                padding: 6px 14px;
                font-size: 13px;
            }

            /* Podium — stacked, compact */
            .sh-podium {
                flex-direction: column;
                align-items: center;
                gap: 16px;
                margin-bottom: 28px;
            }

            .sh-podium-card {
                width: 100%;
                max-width: 100%;
                order: unset !important;
                padding: 20px 16px;
                display: flex;
                align-items: center;
                text-align: left;
                gap: 16px;
            }

            .sh-podium-card.rank-1 {
                transform: none;
            }

            .sh-podium-img-wrapper {
                width: 64px;
                height: 64px;
                flex-shrink: 0;
                margin: 0;
            }

            .sh-podium-card-info {
                flex: 1;
                min-width: 0;
            }

            .sh-podium-name {
                font-size: 16px;
                margin-bottom: 4px;
            }

            .sh-podium-badge {
                bottom: auto;
                left: auto;
                top: -10px;
                right: -10px;
                transform: none;
                width: 26px;
                height: 26px;
                font-size: 12px;
            }

            /* Ranking table */
            .sh-ranking-row {
                grid-template-columns: 44px 1fr 70px;
                padding: 10px 14px;
                gap: 8px;
            }

            .sh-ranking-header {
                padding: 10px 14px;
                font-size: 12px;
            }

            .sh-rank-num {
                font-size: 14px;
            }

            /* Table row avatars (smaller on mobile) */
            .sh-ranking-table .sh-rank-avatar {
                width: 36px;
                height: 36px;
            }

            .sh-rank-name {
                font-size: 13px;
            }

            .sh-rank-score {
                font-size: 13px;
            }

            /* Current user rank card */
            .sh-current-user-rank {
                flex-direction: column;
                gap: 12px;
                text-align: center;
                padding: 16px;
                margin-bottom: 24px;
            }

            .sh-user-rank-info {
                flex-direction: column;
                gap: 10px;
            }

            .sh-user-rank-position {
                font-size: 28px;
            }
        }

        /* Estilos responsivos heredados */

        /* ---- Mobile pequeño (≤ 480px) ---- */
        @media (max-width: 480px) {
            .sh-ranking-row {
                grid-template-columns: 36px 1fr 60px;
                padding: 8px 10px;
            }

            .sh-rank-avatar {
                width: 30px;
                height: 30px;
            }

            .sh-rank-name {
                font-size: 12px;
            }

            .sh-rank-score {
                font-size: 12px;
            }

            .sh-rank-num {
                font-size: 12px;
            }
        }
    </style>
@endsection

@section('content')

    <div class="leaderboard-wrapper">
        <div class="page-header">
            <h1 class="page-title">{{ __('model.leaderboard.title') }}</h1>
            <p class="page-subtitle">{{ __('model.leaderboard.subtitle') }}</p>

            <div class="sh-filters-bar">
                <a href="#" class="sh-filter-chip active">{{ __('model.leaderboard.filters.this_week') }}</a>
                <a href="#" class="sh-filter-chip">{{ __('model.leaderboard.filters.this_month') }}</a>
                <a href="#" class="sh-filter-chip">{{ __('model.leaderboard.filters.global') }}</a>
            </div>
        </div>

        <!-- Current User Stat (Highlighted) -->
        <div class="sh-current-user-rank">
            <div class="sh-user-rank-info">
                <div class="sh-user-rank-position">#{{ $stats['your_rank'] }}</div>
                <div class="sh-rank-user">
                    <img src="{{ auth()->user()->profile->avatar_url ?? asset('images/default-avatar.png')}}" alt="{{ __('model.leaderboard.you_alt') }}"
                        class="sh-rank-avatar" style="border: 2px solid var(--model-gold);">
                    <div style="text-align: left;">
                        <div class="sh-rank-name">{{ auth()->user()->name }} {{ __('model.leaderboard.you') }}</div>
                        <div style="font-size: 12px; opacity: 0.7;">{{ __('model.leaderboard.top_percentage', ['percentage' => $stats['top_percentage']]) }}</div>
                    </div>
                </div>
            </div>
            <div class="sh-rank-score">
                {{ number_format($stats['your_erank'], 0) }} <span
                    style="font-size: 12px; opacity: 0.6; font-weight: 400;">{{ __('model.leaderboard.points') }}</span>
            </div>
        </div>

        <!-- Podium Top 3 -->
        <div class="sh-podium">
            @foreach($topModels->take(3) as $model)
                <div class="sh-podium-card rank-{{ $model['rank'] }}">
                    <div class="sh-podium-img-wrapper">
                        <img src="{{ $model['avatar'] }}" alt="{{ $model['name'] }}" class="sh-podium-img">
                        <div class="sh-podium-badge">{{ $model['rank'] }}</div>
                    </div>
                    <div class="sh-podium-card-info">
                        <div class="sh-podium-name">{{ $model['name'] }}</div>
                        <div class="sh-podium-score">{{ number_format($model['erank']) }} {{ __('model.leaderboard.pts_short') }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Detailed Ranking Table (4th+) -->
        <div class="sh-ranking-table">
            <div class="sh-ranking-row sh-ranking-header">
                <span>{{ __('model.leaderboard.table.rank') }}</span>
                <span>{{ __('model.leaderboard.table.model') }}</span>
                <span style="text-align: right;">{{ __('model.leaderboard.table.erank') }}</span>
            </div>

            @foreach($topModels->slice(3) as $model)
                <div class="sh-ranking-row">
                    <div class="sh-rank-num">#{{ $model['rank'] }}</div>
                    <div class="sh-rank-user">
                        <img src="{{ $model['avatar'] }}" alt="{{ $model['name'] }}" class="sh-rank-avatar">
                        <span class="sh-rank-name">
                            {{ $model['name'] }}
                            @if($model['is_current_user']) <span
                                style="font-size: 10px; background: var(--model-gold); color:#000; padding:2px 4px; border-radius:4px; margin-left:6px;">{{ __('model.leaderboard.you_badge') }}</span>
                            @endif
                        </span>
                    </div>
                    <div class="sh-rank-score">{{ number_format($model['erank']) }}</div>
                </div>
            @endforeach
        </div>

    </div>

@endsection