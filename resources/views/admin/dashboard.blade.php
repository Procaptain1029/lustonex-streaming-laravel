@extends('layouts.admin')

@section('title', __('admin.dashboard.title'))

@section('breadcrumb')
    <span class="breadcrumb-item active">{{ __('admin.dashboard.title') }}</span>
@endsection

@section('header-stats')
    <div class="header-stat">
        <i class="fas fa-user-tie header-stat-icon"></i>
        <div>
            <div class="header-stat-value">
                <p style="font-size: 0.75rem; font-weight: 700; color: rgba(255, 255, 255, 0.4);">
                    {{ $stats['total_models'] }} {{ __('admin.dashboard.stats.models') }}
            </div>
        </div>
    </div>
    <div class="header-stat">
        <i class="fas fa-users header-stat-icon"></i>
        <div>
            <div class="header-stat-value">
                <p style="font-size: 0.75rem; font-weight: 700; color: rgba(255, 255, 255, 0.4);">{{ $stats['total_fans'] }}
                    {{ __('admin.dashboard.stats.fans') }}</p>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        /* ----- Dashboard Professional Styling ----- */

        /* 1. Hero / Title */
        .page-header {
            margin-bottom: 32px;
        }


        /* 2. Metrics Grid & Cards */
        .sh-dashboard-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-bottom: 32px;
            padding: 0 0px;
        }

        .sh-stat-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            /* Adjusted gap */
            transition: all 0.2s ease-out;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .sh-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
            background: rgba(255, 255, 255, 0.03);
        }

        
        .sh-stat-card::after {
            display: none;
        }

        .sh-stat-icon-box {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            background: rgba(212, 175, 55, 0.1);
            color: var(--admin-gold);
            margin-bottom: 16px;
            /* Spacing from icon to text */
        }

        /* Layout adj: icon is now likely part of flow, user prompt didn't specify icon position change 
               but "Tarjeta" specs imply standard vertical flow or flex. 
               Let's keep the existing HTML structure but style accordingly. 
               HTML has icon-box then info-box. */

        .sh-stat-info {
            display: flex;
            flex-direction: column;
        }

        .sh-stat-label {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            color: rgba(255, 255, 255, 0.7);
            text-transform: none;
            /* Removing uppercase */
            letter-spacing: normal;
        }

        .sh-stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
            margin-bottom: 0;
        }

        /* 3. Secondary Grid (Content & Sidebar) */
        .sh-dashboard-grid-secondary {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            margin-bottom: 32px;
        }

        /* 4. Admin Cards / Containers (Graphs, Tables, Lists) */
        .sh-admin-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            padding: 24px;
            height: 100%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 32px;
            /* For spacing if stacked */
        }

        /* Remove bottom margin from grid items specifically if needed, but safe to keep */

        .sh-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            /* Updated */
        }

        .sh-card-title {
            font-family: 'Poppins', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: #dab843;
            margin-bottom: 0px;
            /* Header handles spacing */
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sh-card-title i {
            color: var(--admin-gold);
        }

        /* 5. Tables */
        .sh-modern-table {
            width: 100%;
            border-collapse: collapse;
            /* Changed from separate for border-bottom style */
            border-spacing: 0;
        }

        .sh-modern-table th {
            font-size: 14px;
            font-weight: 700;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.03);
            text-align: left;
            color: rgba(255, 255, 255, 0.8);
            text-transform: none;
            letter-spacing: normal;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .sh-modern-table tbody tr {
            transition: background 0.2s ease-out;
        }

        .sh-modern-table tbody tr:hover td {
            background: rgba(255, 255, 255, 0.03);
        }

        .sh-modern-table td {
            padding: 16px;
            font-size: 14px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            background: transparent;
            /* Reset */
            color: rgba(255, 255, 255, 0.9);
        }

        /* Reset rounded corners from previous design if using border-bottom style */
        .sh-modern-table td:first-child {
            border-radius: 0;
            border-left: none;
        }

        .sh-modern-table td:last-child {
            border-radius: 0;
            border-right: none;
        }

        .sh-model-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sh-model-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(212, 175, 55, 0.3);
        }

        /* 6. Status Pills */
        .sh-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .sh-status-live {
            background: rgba(239, 68, 68, 0.15);
            color: #ff4b4b;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .sh-status-ended {
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.4);
        }

        /* 7. Alerts / Revenue Display */
        .sh-revenue-display {
            text-align: center;
            padding: 24px;
            background: rgba(212, 175, 55, 0.05);
            border-radius: 12px;
            border: 1px solid rgba(212, 175, 55, 0.15);
        }

        .sh-revenue-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--admin-gold);
            margin: 10px 0;
        }

        /* 8. Action Buttons & List */
        .sh-actions-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            /* Kept tight */
        }

        .sh-action-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            /* Matches card radius */
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s ease-out;
        }

        .sh-action-btn:hover {
            transform: scale(1.02);
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--admin-gold);
            color: var(--admin-gold);
        }

        .sh-alert-pill {
            padding: 4px 10px;
            background: var(--admin-gold);
            color: #000;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        /* 9. Micro-interactions & Animations */
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

        .sh-stat-card,
        .sh-admin-card {
            animation: fadeIn 0.3s ease-out;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .sh-dashboard-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 992px) {
            .sh-dashboard-grid-secondary {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 20px !important;
            }
            .page-subtitle {
                font-size: 14px !important;
            }
            .sh-stat-card {
                padding: 16px;
            }
            .sh-stat-value {
                font-size: 24px;
            }
            .sh-stat-label {
                font-size: 14px;
            }
            .sh-revenue-value {
                font-size: 26px;
            }
        }

        @media (max-width: 480px) {
            .sh-dashboard-stats {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .sh-actions-list {
                grid-template-columns: 1fr;
            }
            
            .sh-stat-value {
                font-size: 20px;
                word-break: break-all;
            }

            .sh-stat-label {
                font-size: 12px;
            }

            .sh-stat-icon-box {
                width: 40px;
                height: 40px;
                margin-bottom: 8px;
            }
        }

        /* 10. Filters & Extra Alerts (Requested Base Styles) */
        .sh-filter-chip {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 14px;
            font-weight: 500;
            margin-right: 12px;
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            transition: all 0.2s ease;
            background: transparent;
        }

        .sh-filter-chip:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        .sh-filter-chip.active {
            border: 2px solid var(--admin-gold);
            font-weight: 600;
            color: #fff;
            background: rgba(212, 175, 55, 0.05);
        }

        .sh-alert-box {
            padding: 24px;
            border-radius: 12px;
            background: rgba(239, 68, 68, 0.05);
            border: 1px solid rgba(239, 68, 68, 0.15);
            margin-bottom: 32px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .sh-alert-box i {
            color: #ef4444;
            font-size: 24px;
        }

        .sh-alert-box p {
            font-size: 16px;
            line-height: 1.5;
            color: rgba(255, 255, 255, 0.9);
            margin: 0;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title">{{ __('admin.dashboard.operational_dashboard') }}</h1>
        <p class="page-subtitle">{{ __('admin.dashboard.realtime_monitoring') }}</p>
    </div>


    <div class="sh-dashboard-stats">
        <div class="sh-stat-card">
            <div class="sh-stat-icon-box">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="sh-stat-info">
                <span class="sh-stat-label">{{ __('admin.dashboard.stats.total_models') }}</span>
                <span class="sh-stat-value">{{ $stats['total_models'] }}</span>
            </div>
        </div>

        <div class="sh-stat-card">
            <div class="sh-stat-icon-box">
                <i class="fas fa-users"></i>
            </div>
            <div class="sh-stat-info">
                <span class="sh-stat-label">{{ __('admin.dashboard.stats.total_fans') }}</span>
                <span class="sh-stat-value">{{ $stats['total_fans'] }}</span>
            </div>
        </div>

        <div class="sh-stat-card">
            <div class="sh-stat-icon-box">
                <i class="fas fa-broadcast-tower"></i>
            </div>
            <div class="sh-stat-info">
                <span class="sh-stat-label">{{ __('admin.dashboard.stats.live_now') }}</span>
                <span class="sh-stat-value">{{ $stats['active_streams'] }}</span>
            </div>
        </div>

        <div class="sh-stat-card">
            <div class="sh-stat-icon-box">
                <i class="fas fa-crown"></i>
            </div>
            <div class="sh-stat-info">
                <span class="sh-stat-label">{{ __('admin.dashboard.stats.subscriptions') }}</span>
                <span class="sh-stat-value">{{ $stats['total_subscriptions'] }}</span>
            </div>
        </div>
    </div>

    <div class="sh-dashboard-grid-secondary">

        <div class="sh-admin-card hidden-mobile">
            <div class="sh-card-header">
                <h3 class="sh-card-title"> {{ __('admin.dashboard.recent_streams.title') }}</h3>
                <a href="{{ route('admin.streams.index') }}" style="font-size: 0.85rem; color: var(--admin-gold);">{{ __('admin.dashboard.recent_streams.view_all') }}</a>
            </div>

            @if($recentStreams->count() > 0)
                <div class="table-responsive">
                    <table class="sh-modern-table">
                        <thead>
                            <tr>
                                <th>{{ __('admin.dashboard.recent_streams.model') }}</th>
                                <th>{{ __('admin.dashboard.recent_streams.status') }}</th>
                                <th>{{ __('admin.dashboard.recent_streams.viewers') }}</th>
                                <th>{{ __('admin.dashboard.recent_streams.start') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentStreams as $stream)
                                <tr>
                                    <td>
                                        <div class="sh-model-info">
                                            <img src="{{ $stream->user->profile->avatar_url ?? asset('images/default-avatar.png') }}"
                                                class="sh-model-avatar" alt="">
                                            <span style="font-weight: 700;">{{ $stream->user->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($stream->status === 'live')
                                            <span class="sh-status-pill sh-status-live"><i class="fas fa-signal"></i> {{ __('admin.dashboard.recent_streams.live') }}</span>
                                        @else
                                            <span class="sh-status-pill sh-status-ended">{{ __('admin.dashboard.recent_streams.ended') }}</span>
                                        @endif
                                    </td>
                                    <td><span style="font-weight: 800;">{{ $stream->viewers_count }}</span></td>
                                    <td><span
                                            style="color: rgba(255,255,255,0.5); font-size: 0.85rem;">{{ $stream->started_at ? $stream->started_at->diffForHumans() : __('admin.dashboard.recent_streams.na') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="no-data">
                    <i class="fas fa-broadcast-tower"></i>
                    <p>{{ __('admin.dashboard.recent_streams.no_activity') }}</p>
                </div>
            @endif
        </div>


        <div style="display: flex; flex-direction: column; gap: 24px;">

            <div class="sh-admin-card">
                <h3 class="sh-card-title" style="margin-bottom: 20px;">{{ __('admin.dashboard.stats.total_revenue') }}</h3>
                <div class="sh-revenue-display">
                    <span class="sh-stat-label">{{ __('admin.dashboard.stats.global_platform') }}</span>
                    <div class="sh-revenue-value">${{ number_format($stats['total_revenue'], 2) }}</div>
                    <div style="color: #10b981; font-size: 0.8rem; font-weight: 700;">
                        <i class="fas fa-arrow-trend-up"></i> +12.5% {{ __('admin.dashboard.stats.this_month') }}
                    </div>
                </div>
            </div>


            <div class="sh-admin-card">
                <h3 class="sh-card-title" style="margin-bottom: 20px;">{{ __('admin.dashboard.stats.pending_review') }}
                </h3>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <a href="{{ route('admin.content.photos', ['status' => 'pending']) }}" class="sh-action-btn"
                        style="justify-content: space-between;">
                        <span style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-image"></i>
                            {{ __('admin.dashboard.content.photos') }}</span>
                        <span class="sh-alert-pill">{{ $stats['pending_photos'] }}</span>
                    </a>
                    <a href="{{ route('admin.content.videos', ['status' => 'pending']) }}" class="sh-action-btn"
                        style="justify-content: space-between;">
                        <span style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-video"></i>
                            {{ __('admin.dashboard.content.videos') }}</span>
                        <span class="sh-alert-pill">{{ $stats['pending_videos'] }}</span>
                    </a>
                </div>
            </div>


            <div class="sh-admin-card">
                <h3 class="sh-card-title" style="margin-bottom: 20px;"> {{ __('admin.dashboard.stats.quick_access') }}</h3>
                <div class="sh-actions-list">
                    <a href="{{ route('admin.users.create') }}" class="sh-action-btn">
                        <i class="fas fa-user-plus"></i> {{ __('admin.dashboard.quick_links.admin') }}
                    </a>
                    <a href="{{ route('admin.models.index') }}" class="sh-action-btn">
                        <i class="fas fa-user-tie"></i> {{ __('admin.dashboard.quick_links.models') }}
                    </a>
                    <a href="{{ route('admin.verification.index') }}" class="sh-action-btn">
                        <i class="fas fa-check-circle"></i> {{ __('admin.dashboard.quick_links.verification') }}
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="sh-action-btn">
                        <i class="fas fa-cog"></i> {{ __('admin.dashboard.quick_links.settings') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection