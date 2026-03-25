@extends('layouts.model')

@section('title', __('model.analytics.title'))

@section('breadcrumb')
    <a href="{{ route('model.dashboard') }}" class="breadcrumb-item">{{ __('model.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('model.analytics.breadcrumb') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Model Analytics Professional Styling ----- */

        /* === Page Header === */
        .page-header {
            padding-top: 32px;
            margin-bottom: 28px;
        }

        /* Estilos de encabezado heredados del layout model */

        /* === Stats Grid === */
        .sh-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .sh-stat-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 22px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 130px;
            transition: transform 0.2s, box-shadow 0.2s;
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
            box-sizing: border-box;
            min-width: 0;  /* evita que el item desborde el grid track */
        }

        .sh-stat-card:hover {
            transform: translateY(-4px);
            border-color: rgba(255, 255, 255, 0.12);
            background: rgba(255, 255, 255, 0.04);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .sh-stat-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 14px;
        }

        .sh-stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            flex-shrink: 0;
        }

        .sh-stat-value {
            font-size: clamp(20px, 3.5vw, 36px);
            font-weight: 800;
            color: #fff;
            line-height: 1;
            margin-bottom: 8px;
        }

        .sh-stat-label {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            /* Permite wrappeo — no trunca con max-width fija */
            flex: 1;
            min-width: 0;
            line-height: 1.3;
        }

        .sh-trend {
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.05);
            white-space: nowrap;
        }

        .sh-trend.up {
            color: #28a745;
            background: rgba(40, 167, 69, 0.12);
        }

        .sh-trend.down {
            color: #dc3545;
            background: rgba(220, 53, 69, 0.12);
        }

        .sh-trend.neutral {
            color: #adb5bd;
            background: rgba(173, 181, 189, 0.1);
        }

        /* === Section Cards === */
        .sh-section-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 28px;
            margin-bottom: 32px;
        }

        .sh-section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 8px;
        }

        .sh-section-title {
            font-size: 18px;
            font-weight: 700;
            color: #dfc04e;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* === Chart === */
        .sh-chart-scroll {
            display: block;         /* bloquea la expansión inline */
            width: 100%;            /* se limita al ancho del padre */
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .sh-chart-scroll::-webkit-scrollbar {
            height: 4px;
        }

        .sh-chart-scroll::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.04);
            border-radius: 4px;
        }

        .sh-chart-scroll::-webkit-scrollbar-thumb {
            background: rgba(212, 175, 55, 0.4);
            border-radius: 4px;
        }

        .sh-chart-container {
            height: 280px;
            min-width: 600px;
            width: 100%;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 3px;
            padding-top: 20px;
        }

        .sh-bar-wrapper {
            flex: 1;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: center;
            position: relative;
            cursor: pointer;
        }

        .sh-bar {
            width: 100%;
            background: linear-gradient(to top, rgba(212, 175, 55, 0.2), rgba(212, 175, 55, 0.8));
            border-radius: 4px 4px 0 0;
            transition: all 0.3s;
            min-height: 4px;
            opacity: 0.7;
        }

        .sh-bar-wrapper:hover .sh-bar {
            opacity: 1;
            background: var(--model-gold);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.4);
        }

        .sh-bar-tooltip {
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #111;
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
            margin-bottom: 8px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
            z-index: 10;
            color: #fff;
        }

        .sh-bar-wrapper:hover .sh-bar-tooltip {
            opacity: 1;
        }

        .sh-bar-label {
            font-size: 9px;
            color: rgba(255,255,255,0.35);
            margin-top: 4px;
            white-space: nowrap;
        }

        /* === Dashboard Split === */
        .sh-dashboard-split {
            display: grid;
            grid-template-columns: 3fr 2fr;
            gap: 24px;
            margin-bottom: 32px;
            min-width: 0;
        }

        /* === Content Grid === */
        .sh-media-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
            gap: 12px;
        }

        .sh-media-item {
            aspect-ratio: 1;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            cursor: pointer;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.2s;
        }

        .sh-media-item:hover {
            transform: scale(1.05);
            z-index: 2;
            border-color: var(--model-gold);
        }

        .sh-media-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sh-media-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 8px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9), transparent);
            font-size: 11px;
            font-weight: 700;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* === Fans List === */
        .sh-fans-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .sh-fan-row {
            display: flex;
            align-items: center;
            padding: 12px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            gap: 12px;
            transition: background 0.2s;
            border: 1px solid transparent;
        }

        .sh-fan-row:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .sh-fan-rank {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            font-size: 11px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sh-fan-row:nth-child(1) .sh-fan-rank {
            background: #FFD700;
            color: #000;
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.4);
        }

        .sh-fan-row:nth-child(2) .sh-fan-rank {
            background: #C0C0C0;
            color: #000;
        }

        .sh-fan-row:nth-child(3) .sh-fan-rank {
            background: #CD7F32;
            color: #000;
        }

        .sh-fan-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }

        .sh-fan-info {
            min-width: 0;
        }

        .sh-fan-info h4 {
            font-size: 14px;
            color: #fff;
            margin: 0 0 2px 0;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sh-fan-info p {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.5);
            margin: 0;
        }

        /* === Peak Hours Heatmap === */
        .sh-heatmap {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 8px;
        }

        .sh-heat-block {
            aspect-ratio: 1;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: transform 0.2s;
        }

        .sh-heat-block:hover {
            transform: scale(1.08);
            z-index: 2;
            border-color: rgba(255,255,255,0.3);
        }

        .sh-heat-hour {
            font-size: 12px;
            font-weight: 700;
            color: #fff;
        }

        .sh-heat-val {
            font-size: 10px;
            opacity: 0.7;
        }

        /* ==================== RESPONSIVE ==================== */

        /* Tablet */
        @media (max-width: 1024px) {
            .sh-stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 14px;
            }

            .sh-dashboard-split {
                grid-template-columns: 1fr;
                gap: 16px;
            }
        }

        /* Móvil grande */
        @media (max-width: 768px) {
            /* Ocultar gráfico en móvil */
            .sh-chart-section {
                display: none;
            }
            /* Page header */
            .page-header {
                padding-top: 16px;
                margin-bottom: 16px;
            }

            .page-header {
                padding-top: 16px;
                margin-bottom: 16px;
            }

            /* Estilos responsivos de encabezado heredados */

            /* Stats */
            .sh-stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
                margin-bottom: 16px;
                width: 100%;
            }

            .sh-stat-card {
                padding: 14px;
                min-height: auto;
                min-width: 0;
            }

            .sh-stat-top {
                margin-bottom: 10px;
                gap: 6px;
                align-items: center;
            }

            .sh-stat-icon {
                width: 32px;
                height: 32px;
                font-size: 14px;
                flex-shrink: 0;
            }

            .sh-stat-label {
                font-size: 9px;
                letter-spacing: 0;
                line-height: 1.2;
            }

            .sh-stat-value {
                font-size: clamp(18px, 5vw, 26px);
                margin-bottom: 6px;
            }

            .sh-trend {
                font-size: 10px;
                padding: 3px 8px;
            }

            /* Sections */
            .sh-section-card {
                padding: 16px;
                margin-bottom: 16px;
                border-radius: 14px;
            }

            .sh-section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
                margin-bottom: 16px;
            }

            .sh-section-title {
                font-size: 15px;
            }

            /* Chart */
            .sh-chart-scroll {
                width: 100%;
                max-width: 100%;
            }

            .sh-chart-container {
                height: 220px;
                min-width: 400px;
            }

            /* Media grid */
            .sh-media-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
            }

            /* Fans */
            .sh-fan-avatar {
                width: 34px;
                height: 34px;
            }

            .sh-fan-row {
                padding: 10px;
                gap: 8px;
            }

            .sh-fan-info h4 {
                font-size: 13px;
            }

            .sh-fan-info p {
                font-size: 10px;
            }

            /* Heatmap */
            .sh-heatmap {
                gap: 5px;
            }

            .sh-heat-hour {
                font-size: 10px;
            }

            .sh-heat-val {
                display: none;
            }
        }

        /* Estilos responsivos heredados */

        /* Móvil pequeño */
        @media (max-width: 420px) {
            .sh-stats-grid {
                gap: 8px;
            }

            .sh-stat-card {
                padding: 10px 12px;
            }

            .sh-stat-top {
                margin-bottom: 8px;
            }

            .sh-stat-icon {
                width: 28px;
                height: 28px;
                font-size: 12px;
                border-radius: 8px;
            }

            .sh-stat-label {
                font-size: 8px;
            }

            .sh-stat-value {
                font-size: clamp(16px, 5vw, 22px);
            }

            .sh-section-card {
                padding: 12px;
            }

            .sh-heatmap {
                grid-template-columns: repeat(6, 1fr);
                gap: 4px;
            }

            .sh-heat-block {
                border-radius: 5px;
            }

            .sh-fan-rank {
                width: 20px;
                height: 20px;
                font-size: 10px;
            }

            .sh-fan-avatar {
                width: 30px;
                height: 30px;
            }
        }

        /* === SHARED BUTTONS === */
        .sh-btn {
            padding: 10px 18px;
            font-size: 0.9rem;
            font-weight: 700;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            justify-content: center;
        }

        .sh-btn-secondary {
            background: rgba(255,255,255,0.06);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .sh-btn-secondary:hover {
            background: rgba(255,255,255,0.1);
            transform: translateY(-2px);
            border-color: var(--model-gold);
        }

        .header-actions {
            display: flex;
            gap: 12px;
            margin-top: 15px;
        }

        @media (min-width: 769px) {
            .page-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .header-actions {
                margin-top: 0;
            }
        }
    </style>
@endsection

@section('content')

    <div class="page-header">
        <div>
            <h1 class="page-title">{{ __('model.analytics.breadcrumb') }}</h1>
            <p class="page-subtitle">{{ __('model.analytics.subtitle') }}</p>
        </div>
        <div class="header-actions">
            {{-- <a href="{{ route('model.analytics.export') }}" class="sh-btn sh-btn-secondary">
                <i class="fas fa-file-csv"></i> {{ __('model.earnings.filters.export_csv') }}
            </a> --}}
        </div>
    </div>

    <!-- Key Stats -->
    <div class="sh-stats-grid">
        <div class="sh-stat-card">
            <div class="sh-stat-top">
                <div class="sh-stat-label">{{ __('model.analytics.stats.total_views') }}</div>
                <div class="sh-stat-icon" style="color: #0dcaf0; background: rgba(13,202,240,0.1);"><i
                        class="fas fa-eye"></i></div>
            </div>
            <div>
                <div class="sh-stat-value">{{ number_format($profileViews['total']) }}</div>
                <div class="sh-trend up"><i class="fas fa-arrow-up"></i> {{ __('model.analytics.stats.global') }}</div>
            </div>
        </div>

        <div class="sh-stat-card">
            <div class="sh-stat-top">
                <div class="sh-stat-label">{{ __('model.analytics.stats.last_30_days') }}</div>
                <div class="sh-stat-icon" style="color: var(--model-gold); background: rgba(212, 175, 55, 0.1);"><i
                        class="fas fa-calendar-alt"></i></div>
            </div>
            <div>
                <div class="sh-stat-value">{{ number_format($profileViews['last_30_days']) }}</div>
                <div class="sh-trend neutral">{{ __('model.analytics.stats.monthly') }}</div>
            </div>
        </div>

        <div class="sh-stat-card">
            <div class="sh-stat-top">
                <div class="sh-stat-label">{{ __('model.analytics.stats.this_week') }}</div>
                <div class="sh-stat-icon" style="color: #28a745; background: rgba(40,167,69,0.1);"><i
                        class="fas fa-calendar-week"></i></div>
            </div>
            <div>
                <div class="sh-stat-value">{{ number_format($profileViews['last_7_days']) }}</div>
                <div class="sh-trend down">{{ __('model.analytics.stats.weekly') }}</div>
            </div>
        </div>

        <div class="sh-stat-card">
            <div class="sh-stat-top">
                <div class="sh-stat-label">{{ __('model.analytics.stats.today') }}</div>
                <div class="sh-stat-icon" style="color: #ffc107; background: rgba(255,193,7,0.1);"><i
                        class="fas fa-bolt"></i></div>
            </div>
            <div>
                <div class="sh-stat-value">{{ number_format($profileViews['today']) }}</div>
                <div class="sh-trend neutral">{{ __('model.analytics.stats.daily') }}</div>
            </div>
        </div>
    </div>

    <!-- Main Chart -->
    <div class="sh-section-card sh-chart-section">
        <div class="sh-section-header">
            <h3 class="sh-section-title"><i class="fas fa-chart-bar" style="color: var(--model-gold);"></i> {{ __('model.analytics.charts.traffic_title') }}</h3>
        </div>
        <div class="sh-chart-scroll">
            <div class="sh-chart-container">
                @php
                    $maxViews = max(array_column($profileViews['chart_data'], 'views')) ?: 1;
                @endphp
                @foreach($profileViews['chart_data'] as $data)
                    <div class="sh-bar-wrapper">
                        <div class="sh-bar-tooltip">{{ __('model.analytics.charts.visits_tooltip', ['date' => $data['date'], 'count' => $data['views']]) }}</div>
                        <div class="sh-bar" style="height: {{ max(5, ($data['views'] / $maxViews) * 100) }}%;"></div>
                        @if($loop->index % 5 === 0)
                            <span class="sh-bar-label">{{ \Carbon\Carbon::parse($data['date'])->format('d/m') }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="sh-dashboard-split">
        <!-- Top Content -->
        <div class="sh-section-card" style="margin-bottom: 0;">
            <div class="sh-section-header">
                <h3 class="sh-section-title"> {{ __('model.analytics.content.popular_title') }}</h3>
            </div>

            <h4 style="font-size: 14px; text-transform: uppercase; color: rgba(255,255,255,0.5); margin-bottom: 16px;">{{ __('model.analytics.content.top_photos') }}</h4>
            @if($popularPhotos->count() > 0)
                <div class="sh-media-grid" style="margin-bottom: 32px;">
                    @foreach($popularPhotos as $photo)
                        <div class="sh-media-item">
                            <img src="{{ $photo['thumbnail'] }}" alt="Photo">
                            <div class="sh-media-overlay">
                                <i class="fas fa-eye"></i> {{ number_format($photo['views']) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="color: rgba(255,255,255,0.3); font-style: italic; margin-bottom: 32px;">{{ __('model.analytics.content.no_data') }}</p>
            @endif

            <h4 style="font-size: 14px; text-transform: uppercase; color: rgba(255,255,255,0.5); margin-bottom: 16px;">
                {{ __('model.analytics.content.top_videos') }}</h4>
            @if($popularVideos->count() > 0)
                <div class="sh-media-grid">
                    @foreach($popularVideos as $video)
                        <div class="sh-media-item">
                            <img src="{{ $video['thumbnail'] }}" alt="Video">
                            <div class="sh-media-overlay">
                                <i class="fas fa-play"></i> {{ number_format($video['views']) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="color: rgba(255,255,255,0.3); font-style: italic;">{{ __('model.analytics.content.no_data') }}</p>
            @endif
        </div>

        <!-- Top Fans & Growth -->
        <div>
            <div class="sh-section-card">
                <div class="sh-section-header">
                    <h3 class="sh-section-title">{{ __('model.analytics.fans.top_fans_title') }}</h3>
                </div>

                @if($demographics['top_fans']->count() > 0)
                    <div class="sh-fans-list">
                        @foreach($demographics['top_fans'] as $index => $fan)
                            <div class="sh-fan-row">
                                <div class="sh-fan-rank">{{ $index + 1 }}</div>
                                <img src="{{ $fan['avatar'] }}" alt="{{ $fan['name'] }}" class="sh-fan-avatar">
                                <div class="sh-fan-info">
                                    <h4>{{ $fan['name'] }}</h4>
                                    <p><i class="fas fa-coins" style="color: var(--model-gold);"></i>
                                        {{ number_format($fan['total_tips']) }} {{ __('model.analytics.fans.tokens') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 20px; color: rgba(255,255,255,0.4);">
                        <i class="fas fa-users" style="font-size: 24px; margin-bottom: 8px; opacity: 0.5;"></i>
                        <p>{{ __('model.analytics.fans.no_fans') }}</p>
                    </div>
                @endif
            </div>

            <div class="sh-section-card" style="margin-bottom: 0;">
                <div class="sh-section-header">
                    <h3 class="sh-section-title"> {{ __('model.analytics.growth.title') }}</h3>
                </div>

                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div
                        style="background: rgba(255,255,255,0.03); padding: 16px; border-radius: 12px; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <div style="font-size: 12px; color: rgba(255,255,255,0.5); text-transform: uppercase;">
                                {{ __('model.analytics.growth.subscribers') }}</div>
                            <div style="font-size: 20px; font-weight: 700; color: #fff;">
                                {{ number_format($growthTrends['subscribers']['current']) }}</div>
                        </div>
                        @php $subGrowth = $growthTrends['subscribers']['growth_percentage']; @endphp
                        <div class="sh-trend {{ $subGrowth >= 0 ? 'up' : 'down' }}">
                            {{ $subGrowth >= 0 ? '+' : '' }}{{ $subGrowth }}%
                        </div>
                    </div>

                    <div
                        style="background: rgba(255,255,255,0.03); padding: 16px; border-radius: 12px; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <div style="font-size: 12px; color: rgba(255,255,255,0.5); text-transform: uppercase;">{{ __('model.analytics.growth.earnings') }}
                            </div>
                            <div style="font-size: 20px; font-weight: 700; color: #fff;">
                                {{ number_format($growthTrends['earnings']['current']) }}</div>
                        </div>
                        @php $earnGrowth = $growthTrends['earnings']['growth_percentage']; @endphp
                        <div class="sh-trend {{ $earnGrowth >= 0 ? 'up' : 'down' }}">
                            {{ $earnGrowth >= 0 ? '+' : '' }}{{ $earnGrowth }}%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Heatmap -->
    <div class="sh-section-card" style="margin-bottom: 0;">
        <div class="sh-section-header">
            <h3 class="sh-section-title"> {{ __('model.analytics.peak_hours.title') }}
            </h3>
        </div>
        <div class="sh-heatmap">
            @foreach($peakHours as $hour)
                @php
                    $intensity = $hour['activity'];
                    $maxActivity = max(array_column($peakHours, 'activity')) ?: 1;
                    $percentage = ($intensity / $maxActivity) * 100;
                    $bgAlpha = max(0.05, $percentage / 100);
                @endphp
                <div class="sh-heat-block" style="background: rgba(212, 175, 55, {{ $bgAlpha }});">
                    <span class="sh-heat-hour">{{ $hour['hour'] }}</span>
                    <span class="sh-heat-val">{{ $hour['activity'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

@endsection