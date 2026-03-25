@extends('layouts.admin')

@section('title', __('admin.analytics.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.analytics.title') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Analytics Dashboard Professional Styling ----- */

        /* 1. Hero / Title */
        .page-header {
            margin-bottom: 32px;
        }


        /* 2. Overview Grid (Metric Cards) */
        .sh-overview-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }

        .sh-stat-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            padding: 24px;
            position: relative;
            overflow: hidden;
            transition: all 0.2s ease-out;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .sh-stat-card:hover {
            background: rgba(255, 255, 255, 0.04);
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .sh-stat-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 16px;
        }

        .sh-icon-users {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .sh-icon-revenue {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .sh-icon-streams {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .sh-icon-gold {
            background: rgba(212, 175, 55, 0.1);
            color: var(--admin-gold);
        }

        .sh-stat-label {
            font-size: 16px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 8px;
        }

        .sh-stat-value {
            font-size: 32px;
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
            margin-bottom: 8px;
        }

        .sh-stat-trend {
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .sh-trend-up {
            color: #10b981;
        }

        .sh-trend-down {
            color: #ef4444;
        }

        .sh-trend-neutral {
            color: rgba(255, 255, 255, 0.4);
        }

        /* 3. Charts */
        .sh-chart-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 32px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .sh-chart-header {
            margin-bottom: 24px;
        }

        .sh-chart-title {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            margin: 0 0 4px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sh-chart-subtitle {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.5);
        }

        .sh-chart-placeholder {
            height: 350px;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* 4. Activity & Metrics Grid */
        .sh-metrics-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 32px;
            margin-bottom: 32px;
        }

        .sh-metric-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sh-metric-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 16px;
        }

        .sh-metric-item:last-child {
            border-bottom: none;
        }

        .sh-metric-name {
            color: rgba(255, 255, 255, 0.7);
        }

        .sh-metric-data {
            font-weight: 700;
            color: #fff;
        }

        /* 5. Top Models Table */
        .sh-table-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 0;
            /* Table fills card */
        }

        .sh-table-header-padding {
            padding: 24px 24px 16px 24px;
        }

        .sh-modern-table {
            width: 100%;
            border-collapse: collapse;
        }

        .sh-modern-table th {
            padding: 12px 24px;
            text-align: left;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.4);
            letter-spacing: 0.5px;
            background: rgba(255, 255, 255, 0.01);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sh-modern-table td {
            padding: 16px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            vertical-align: middle;
            font-size: 14px;
            color: #fff;
        }

        .sh-modern-table tr {
            transition: background 0.2s ease-out;
        }

        .sh-modern-table tr:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .sh-user-link {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .sh-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sh-rank {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: 800;
            font-size: 14px;
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.4);
        }

        .sh-rank-1 {
            background: var(--gradient-gold);
            color: #000;
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.3);
        }

        .sh-rank-2 {
            background: linear-gradient(135deg, #e0e0e0, #9e9e9e);
            color: #000;
        }

        .sh-rank-3 {
            background: linear-gradient(135deg, #cd7f32, #a05a2c);
            color: #fff;
        }

        .sh-revenue-text {
            font-weight: 700;
            color: #10b981;
            font-family: 'Space Mono', monospace;
            font-size: 15px;
        }

        @media (max-width: 768px) {
            .page-header {
                margin-bottom: 20px;
            }

            .sh-overview-grid {

                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
                margin-bottom: 24px;
            }

            .sh-stat-card {
                padding: 18px;
                border-radius: 10px;
            }

            .sh-stat-icon-wrapper {
                width: 38px;
                height: 38px;
                border-radius: 10px;
                font-size: 1rem;
                margin-bottom: 12px;
            }

            .sh-stat-label {
                font-size: 13px;
                margin-bottom: 6px;
            }

            .sh-stat-value {
                font-size: 24px;
                margin-bottom: 6px;
            }

            .sh-stat-trend {
                font-size: 12px;
            }

            .sh-chart-card {
                padding: 18px;
                border-radius: 10px;
                margin-bottom: 24px;
            }

            .sh-chart-title {
                font-size: 16px;
            }

            .sh-chart-subtitle {
                font-size: 12px;
            }

            .sh-chart-placeholder {
                height: 220px;
                border-radius: 10px;
            }

            .sh-metrics-grid {
                grid-template-columns: 1fr;
                gap: 16px;
                margin-bottom: 24px;
            }

            .sh-metric-item {
                font-size: 14px;
                padding: 12px 0;
            }

            .sh-table-card {
                border-radius: 10px;
            }

            .sh-table-header-padding {
                padding: 18px 18px 12px 18px;
            }

            .sh-modern-table th,
            .sh-modern-table td {
                padding: 12px 16px;
            }

            .sh-modern-table th {
                font-size: 11px;
            }

            /* Hide email column */
            .sh-modern-table th:nth-child(3),
            .sh-modern-table td:nth-child(3) {
                display: none;
            }

            .sh-avatar {
                width: 32px;
                height: 32px;
            }

            .sh-user-link {
                gap: 10px;
            }

            .sh-rank {
                width: 24px;
                height: 24px;
                font-size: 12px;
            }

            .sh-revenue-text {
                font-size: 13px;
            }

            .sh-badge-live {
                font-size: 10px;
                padding: 3px 10px;
                margin-left: 6px;
            }
        }

        @media (max-width: 480px) {
            .sh-overview-grid {

                grid-template-columns: 1fr;
                gap: 10px;
            }

            .sh-stat-card {
                padding: 16px;
            }

            .sh-stat-icon-wrapper {
                width: 34px;
                height: 34px;
                font-size: 0.9rem;
                margin-bottom: 10px;
            }

            .sh-stat-value {
                font-size: 22px;
            }

            .sh-stat-label {
                font-size: 12px;
            }

            .sh-chart-card {
                padding: 16px;
            }

            .sh-chart-title {
                font-size: 14px;
            }

            .sh-chart-placeholder {
                height: 180px;
            }

            .sh-metric-item {
                font-size: 13px;
                padding: 10px 0;
            }

            .sh-table-header-padding {
                padding: 16px 14px 10px 14px;
            }

            .sh-modern-table th,
            .sh-modern-table td {
                padding: 10px 12px;
            }

            /* Also hide Rank column */
            .sh-modern-table th:nth-child(1),
            .sh-modern-table td:nth-child(1) {
                display: none;
            }

            .sh-avatar {
                width: 28px;
                height: 28px;
            }

            .sh-user-link {
                gap: 8px;
            }

            .sh-revenue-text {
                font-size: 12px;
            }

            .sh-badge-live {
                display: none;
            }
        }

        /* Utility */
        .text-right {
            text-align: right;
        }

        .sh-badge-live {
            background: rgba(212, 175, 55, 0.1);
            color: var(--admin-gold);
            font-weight: 800;
            font-size: 11px;
            padding: 4px 12px;
            border-radius: 20px;
            border: 1px solid rgba(212, 175, 55, 0.2);
            display: inline-block;
            margin-left: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title">{{ __('admin.analytics.dashboard_title') }}</h1>
        <p class="page-subtitle">{{ __('admin.analytics.subtitle') }}</p>
    </div>

    <!-- 1. Overview Cards -->
    <div class="sh-overview-grid">
        <div class="sh-stat-card">
            <div class="sh-stat-icon-wrapper sh-icon-users"><i class="fas fa-users"></i></div>
            <div class="sh-stat-label">{{ __('admin.analytics.overview.total_community') }}</div>
            <div class="sh-stat-value">{{ number_format($overview['total_users']) }}</div>
            <div class="sh-stat-trend {{ $overview['users_growth'] > 0 ? 'sh-trend-up' : ($overview['users_growth'] < 0 ? 'sh-trend-down' : 'sh-trend-neutral') }}">
                @if($overview['users_growth'] > 0)
                    <i class="fas fa-arrow-up"></i>
                @elseif($overview['users_growth'] < 0)
                    <i class="fas fa-arrow-down"></i>
                @else
                    <i class="fas fa-minus"></i>
                @endif
                {{ abs($overview['users_growth']) }}% {{ __('admin.analytics.overview.vs_previous_month') }}
            </div>
        </div>

        <div class="sh-stat-card">
            <div class="sh-stat-icon-wrapper sh-icon-users" style="background: rgba(59,130,246,0.2); color: #60a5fa;"><i class="fas fa-user-check"></i></div>
            <div class="sh-stat-label">{{ __('admin.analytics.overview.active_fans') }}</div>
            <div class="sh-stat-value">{{ number_format($overview['total_fans']) }}</div>
            <div class="sh-stat-trend {{ $overview['fans_growth'] > 0 ? 'sh-trend-up' : ($overview['fans_growth'] < 0 ? 'sh-trend-down' : 'sh-trend-neutral') }}">
                @if($overview['fans_growth'] > 0)
                    <i class="fas fa-arrow-up"></i>
                @elseif($overview['fans_growth'] < 0)
                    <i class="fas fa-arrow-down"></i>
                @else
                    <i class="fas fa-minus"></i>
                @endif
                {{ abs($overview['fans_growth']) }}% {{ __('admin.analytics.overview.vs_previous_month') }}
            </div>
        </div>

        <div class="sh-stat-card">
            <div class="sh-stat-icon-wrapper sh-icon-gold"><i class="fas fa-star"></i></div>
            <div class="sh-stat-label">{{ __('admin.analytics.overview.registered_models') }}</div>
            <div class="sh-stat-value" style="color: var(--admin-gold);">{{ number_format($overview['total_models']) }}</div>
            <div class="sh-stat-trend {{ $overview['models_growth'] > 0 ? 'sh-trend-up' : ($overview['models_growth'] < 0 ? 'sh-trend-down' : 'sh-trend-neutral') }}" style="{{ $overview['models_growth'] > 0 ? 'color: var(--admin-gold);' : '' }}">
                @if($overview['models_growth'] > 0)
                    <i class="fas fa-arrow-up"></i>
                @elseif($overview['models_growth'] < 0)
                    <i class="fas fa-arrow-down"></i>
                @else
                    <i class="fas fa-minus"></i>
                @endif
                {{ abs($overview['models_growth']) }}% {{ __('admin.analytics.overview.vs_previous_month') }}
            </div>
        </div>

        <div class="sh-stat-card">
            <div class="sh-stat-icon-wrapper sh-icon-revenue"><i class="fas fa-coins"></i></div>
            <div class="sh-stat-label">{{ __('admin.analytics.overview.tokens_moved') }}</div>
            <div class="sh-stat-value" style="color: #10b981;">{{ number_format($overview['total_tokens']) }}</div>
            <div class="sh-stat-trend {{ $overview['tokens_growth'] > 0 ? 'sh-trend-up' : ($overview['tokens_growth'] < 0 ? 'sh-trend-down' : 'sh-trend-neutral') }}">
                @if($overview['tokens_growth'] > 0)
                    <i class="fas fa-arrow-up"></i>
                @elseif($overview['tokens_growth'] < 0)
                    <i class="fas fa-arrow-down"></i>
                @else
                    <i class="fas fa-minus"></i>
                @endif
                {{ abs($overview['tokens_growth']) }}% {{ __('admin.analytics.overview.vs_previous_month') }}
            </div>
        </div>

        <div class="sh-stat-card">
            <div class="sh-stat-icon-wrapper sh-icon-streams"><i class="fas fa-video"></i></div>
            <div class="sh-stat-label">{{ __('admin.analytics.overview.live_now') }}</div>
            <div class="sh-stat-value">{{ $overview['active_streams'] }}</div>
            <div class="sh-stat-trend sh-trend-neutral">
                <span>{{ __('admin.analytics.overview.real_time') }}</span>
            </div>
        </div>
    </div>

    <!-- 2. Main Chart -->
    <div class="sh-chart-card">
        <div class="sh-chart-header">
            <h3 class="sh-chart-title">
                <i class="fas fa-chart-line text-warning"></i> {{ __('admin.analytics.charts.revenue_trend') }} <span class="sh-badge-live">{{ __('admin.analytics.charts.live_data') }}</span>
            </h3>
            <p class="sh-chart-subtitle">{{ __('admin.analytics.charts.revenue_subtitle') }}</p>
        </div>
        <div class="sh-chart-placeholder">
            <div style="text-align: center; z-index: 2;">
                <i class="fas fa-chart-area"
                    style="font-size: 4rem; color: var(--admin-gold); opacity: 0.2; margin-bottom: 20px;"></i>
                <div style="font-weight: 700; font-size: 1.1rem; color: #fff;">{{ __('admin.analytics.charts.real_time_viz') }}</div>
                <div style="font-size: 0.9rem; color: rgba(255,255,255,0.5); margin-top: 10px;">
                {{ __('admin.analytics.charts.projected_total') }} <span
                        style="color: var(--admin-gold); font-weight: 700;">{{ number_format(array_sum(array_column($revenueTrends, 'revenue'))) }} {{ __('admin.analytics.charts.tokens') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Metrics Details Grid -->
    <div class="sh-metrics-grid">
        <!-- Engagement Metrics -->
        <div class="sh-chart-card" style="margin-bottom: 0;">
            <div class="sh-chart-header">
                <h3 class="sh-chart-title"><i class="fas fa-bolt text-primary"></i> {{ __('admin.analytics.metrics.user_engagement') }}</h3>
                <p class="sh-chart-subtitle">{{ __('admin.analytics.metrics.engagement_subtitle') }}</p>
            </div>
            <ul class="sh-metric-list">
                <li class="sh-metric-item">
                    <span class="sh-metric-name">{{ __('admin.analytics.metrics.avg_session') }}</span>
                    <span class="sh-metric-data">{{ gmdate('H:i:s', $engagementMetrics['avg_stream_duration']) }}</span>
                </li>
                <li class="sh-metric-item">
                    <span class="sh-metric-name">{{ __('admin.analytics.metrics.avg_concurrency') }}</span>
                    <span class="sh-metric-data">{{ number_format($engagementMetrics['avg_viewers'], 0) }} {{ __('admin.analytics.metrics.viewers') }}</span>
                </li>
                <li class="sh-metric-item">
                    <span class="sh-metric-name">{{ __('admin.analytics.metrics.tip_volume') }}</span>
                    <span class="sh-metric-data"
                        style="color: var(--admin-gold);">{{ number_format($engagementMetrics['total_tips']) }} {{ __('admin.analytics.metrics.tips') }}</span>
                </li>
                <li class="sh-metric-item">
                    <span class="sh-metric-name">{{ __('admin.analytics.metrics.sub_conversion') }}</span>
                    <span class="sh-metric-data">{{ number_format($engagementMetrics['total_subscriptions']) }}
                        {{ __('admin.analytics.metrics.users') }}</span>
                </li>
            </ul>
        </div>

        <!-- Content Inventory -->
        <div class="sh-chart-card" style="margin-bottom: 0;">
            <div class="sh-chart-header">
                <h3 class="sh-chart-title"><i class="fas fa-photo-video text-danger"></i> {{ __('admin.analytics.metrics.content_inventory') }}</h3>
                <p class="sh-chart-subtitle">{{ __('admin.analytics.metrics.inventory_subtitle') }}</p>
            </div>
            <ul class="sh-metric-list">
                <li class="sh-metric-item">
                    <span class="sh-metric-name">{{ __('admin.analytics.metrics.published_photos') }}</span>
                    <span class="sh-metric-data">{{ number_format($contentStats['total_photos']) }}</span>
                </li>
                <li class="sh-metric-item">
                    <span class="sh-metric-name">{{ __('admin.analytics.metrics.published_videos') }}</span>
                    <span class="sh-metric-data">{{ number_format($contentStats['total_videos']) }}</span>
                </li>
                <li class="sh-metric-item">
                    <span class="sh-metric-name">{{ __('admin.analytics.metrics.live_broadcasts') }}</span>
                    <span class="sh-metric-data">{{ number_format($contentStats['total_streams']) }}</span>
                </li>
                <li class="sh-metric-item">
                    <span class="sh-metric-name">{{ __('admin.analytics.metrics.pending_moderation') }}</span>
                    <span class="sh-metric-data"
                        style="color: #fbbf24;">{{ $contentStats['pending_photos'] + $contentStats['pending_videos'] }}
                        {{ __('admin.analytics.metrics.items') }}</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- 4. Top Performers Table -->
    <div class="sh-table-card">
        <div class="sh-table-header-padding">
            <h3 class="sh-chart-title"><i class="fas fa-trophy text-warning"></i> {{ __('admin.analytics.top_models.title') }}</h3>
            <p class="sh-chart-subtitle">{{ __('admin.analytics.top_models.subtitle') }}</p>
        </div>

        <div class="table-responsive">
            <table class="sh-modern-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">{{ __('admin.analytics.top_models.rank') }}</th>
                        <th>{{ __('admin.analytics.top_models.model') }}</th>
                        <th>{{ __('admin.analytics.top_models.contact') }}</th>
                        <th class="text-right">{{ __('admin.analytics.top_models.accumulated_tokens') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topModels as $index => $model)
                        <tr>
                            <td>
                                @php $rankClass = ($index < 3) ? 'sh-rank-' . ($index + 1) : ''; @endphp
                                <div class="sh-rank {{ $rankClass }}">
                                    {{ $index + 1 }}
                                </div>
                            </td>
                            <td>
                                <div class="sh-user-link">
                                    <img src="{{ $model->profile?->avatar_url ?? asset('images/default-avatar.png') }}"
                                        class="sh-avatar" alt="Avatar"
                                        onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                                    <span style="font-weight: 600;">{{ $model->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span style="font-size: 13px; opacity: 0.6;">{{ $model->email }}</span>
                            </td>
                            <td class="text-right">
                                <span class="sh-revenue-text"><i class="fas fa-coins" style="font-size: 12px; margin-right: 4px; color: var(--admin-gold);"></i>{{ number_format($model->tokens) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 40px; color: rgba(255,255,255,0.4);">
                                {{ __('admin.analytics.top_models.no_data') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection