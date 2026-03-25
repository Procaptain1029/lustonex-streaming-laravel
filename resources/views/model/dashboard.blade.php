@extends('layouts.model')

@section('title', __('model.dashboard.title'))

@section('breadcrumb')
    <a href="{{ route('model.dashboard') }}" class="breadcrumb-item active">{{ __('model.dashboard.title') }}</a>
@endsection

@section('styles')
    <style>
        /* ----- Model Dashboard Professional Styling ----- */

        .dashboard-container {
            padding: 2rem 2rem 4rem 2rem;
            max-width: 1400px;
            margin: 0 auto;
            padding-top: 24px;
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

        /* 1. Hero & Welcome */
        .sh-welcome-hero {
            margin-bottom: 48px;
        }

        /* Las clases .page-title y .page-subtitle se heredan del layout model */

        /* 2. Grid Layout */
        .sh-dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 24px;
            padding-bottom: 40px;
        }

        /* 3. Cards */
        .sh-card {
            background: rgba(30, 30, 35, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.2s ease-out;
        }

        .sh-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
            border-color: rgba(212, 175, 55, 0.3);
            background: rgba(40, 40, 45, 0.8);
        }

        .sh-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .sh-card-title {
            font-size: 20px;
            font-weight: 700;
            color: #dfc04e;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sh-card-title i {
            color: var(--model-gold);
        }

        /* 4. Stats Cards (Sidebar) */
        .sh-stats-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .sh-stat-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 20px;
            transition: all 0.2s ease-out;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .sh-stat-card:hover {
            transform: translateY(-4px);
            background: rgba(40, 40, 45, 0.8);
            border-color: rgba(212, 175, 55, 0.3);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

        .sh-stat-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sh-stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #fff;
        }

        .sh-stat-label {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 600;
        }

        .sh-stat-icon {
            font-size: 24px;
            color: var(--model-gold);
            opacity: 0.8;
            background: rgba(212, 175, 55, 0.1);
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
        }

        /* 5. Quick Actions */
        .sh-actions-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 30px;
        }

        .sh-action-btn {
            background: rgba(30, 30, 35, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
            text-decoration: none;
            color: #fff;
            transition: all 0.2s ease-out;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            height: 100%;
        }

        .sh-action-btn:hover {
            background: rgba(40, 40, 45, 0.8);
            transform: translateY(-4px);
            border-color: rgba(212, 175, 55, 0.3);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

        .sh-action-btn i {
            font-size: 28px;
            color: var(--model-gold);
            transition: transform 0.3s;
        }

        .sh-action-btn:hover i {
            transform: scale(1.1);
        }

        .sh-action-btn span {
            font-size: 14px;
            font-weight: 600;
        }

        .sh-action-btn.primary {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.2), rgba(0, 0, 0, 0));
            border: 1px solid rgba(212, 175, 55, 0.3);
        }

        .sh-action-btn.primary:hover {
            border-color: var(--model-gold);
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.15);
        }

        /* 6. Activity Feed */
        .sh-activity-list {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .sh-activity-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sh-activity-item:last-child {
            border-bottom: none;
        }

        .sh-activity-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sh-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #fff;
            font-weight: 700;
        }

        .sh-activity-text {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
        }

        .sh-activity-meta {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 2px;
        }

        .sh-activity-amount {
            font-size: 16px;
            font-weight: 700;
            color: var(--model-gold);
        }

        .sh-activity-split {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        @media (max-width: 1200px) {
            .sh-dashboard-grid {
                grid-template-columns: 1fr;
            }

            .sh-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 1rem 0.75rem;
                padding-top: 12px;
            }

            .sh-welcome-hero {
                margin-bottom: 28px;
            }

            .sh-welcome-title {
                font-size: 28px;
                margin-bottom: 16px;
            }

            .sh-welcome-subtitle {
                font-size: 16px;
                margin-bottom: 18px;
                color: #fff;
            }

            .sh-dashboard-grid {
                gap: 16px;
            }

            .sh-card {
                padding: 16px;
                border-radius: 12px;
            }

            .sh-stats-grid {
                grid-template-columns: 1fr;
            }

            .sh-actions-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .sh-activity-split {
                grid-template-columns: 1fr;
                gap: 16px;
            }
        }

        @media (max-width: 480px) {
            .dashboard-container {
                padding: 0.75rem;
                padding-top: 8px;
            }

            .sh-welcome-hero {
                margin-bottom: 20px;
            }

            .sh-welcome-title {
                font-size: 24px;
                margin-bottom: 10px;
            }

            .sh-welcome-subtitle {
                font-size: 14px;
                margin-bottom: 14px;
                color: #fff;
            }

            .sh-actions-grid {
                gap: 8px;
            }

            .sh-action-btn {
                padding: 16px 12px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="dashboard-container">

        <!-- Hero -->
        <div class="sh-welcome-hero">
            <h1 class="page-title">{!! __('model.dashboard.welcome', ['name' => e(auth()->user()->name)]) !!}</h1>
            <p class="page-subtitle">
                {{ __('model.dashboard.subtitle') }}
            </p>
        </div>

        <div class="sh-dashboard-grid">
            <!-- Main Content -->
            <div>
                <!-- Quick Actions -->
                <div class="sh-actions-grid">
                    @if($profile->verification_status === 'approved')
                        <a href="{{ route('model.streams.create') }}" class="sh-action-btn primary">
                            <i class="fas fa-broadcast-tower"></i>
                            <span>{{ __('model.dashboard.actions.stream') }}</span>
                        </a>
                        <a href="{{ route('model.photos.create') }}" class="sh-action-btn">
                            <i class="fas fa-camera"></i>
                            <span>{{ __('model.dashboard.actions.upload_photo') }}</span>
                        </a>
                        <a href="{{ route('model.videos.create') }}" class="sh-action-btn">
                            <i class="fas fa-video"></i>
                            <span>{{ __('model.dashboard.actions.upload_video') }}</span>
                        </a>
                        <a href="{{ route('model.profile.edit') }}" class="sh-action-btn">
                            <i class="fas fa-user-edit"></i>
                            <span>{{ __('model.dashboard.actions.edit_profile') }}</span>
                        </a>
                    @else
                        <div class="sh-action-btn" style="opacity: 0.5; cursor: not-allowed;">
                            <i class="fas fa-lock"></i>
                            <span>{{ __('model.dashboard.actions.stream') }}</span>
                        </div>
                    @endif
                </div>

                <!-- Recent Activity (Split) -->
                <div class="sh-activity-split">
                    <!-- Tips -->
                    <div class="sh-card">
                        <div class="sh-card-header">
                            <h3 class="sh-card-title"> {{ __('model.dashboard.recent_activity.tips_title') }}</h3>
                        </div>
                        <div class="sh-activity-list">
                            @forelse($stats['recent_tips']->take(5) as $tip)
                                <div class="sh-activity-item">
                                    <div class="sh-activity-user">
                                        <div class="sh-user-avatar"
                                            style="background: rgba(212,175,55,0.2); color: var(--model-gold);">
                                            {{ substr($tip->fan->name ?? 'A', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="sh-activity-text">{{ $tip->fan->name ?? __('model.dashboard.recent_activity.fan_default') }}</div>
                                            <div class="sh-activity-meta">{{ $tip->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                    <div class="sh-activity-amount">+{{ $tip->amount }}</div>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 20px; opacity: 0.5;">{{ __('model.dashboard.recent_activity.empty_tips') }}</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Subscribers -->
                    <div class="sh-card">
                        <div class="sh-card-header">
                            <h3 class="sh-card-title"> {{ __('model.dashboard.recent_activity.subscribers_title') }}</h3>
                        </div>
                        <div class="sh-activity-list">
                            @forelse($stats['recent_subscribers']->take(5) as $sub)
                                <div class="sh-activity-item">
                                    <div class="sh-activity-user">
                                        <div class="sh-user-avatar" style="background: rgba(255,255,255,0.1);">
                                            {{ substr($sub->fan->name ?? 'A', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="sh-activity-text">{{ $sub->fan->name ?? __('model.dashboard.recent_activity.fan_default') }}</div>
                                            <div class="sh-activity-meta">{{ $sub->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                    <div class="sh-activity-amount" style="color: #fff; font-size: 14px;">VIP</div>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 20px; opacity: 0.5;">{{ __('model.dashboard.recent_activity.empty_subscribers') }}</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                @if($profile->verification_status === 'approved')
                    <div class="sh-card" style="margin-top: 24px;">
                        <x-model-missions-preview :missions="$activeMissions" />
                    </div>
                @endif

            </div>

            <!-- Sidebar Stats -->
            <div>
                <div class="sh-card">
                    <div class="sh-card-header">
                        <h3 class="sh-card-title"> {{ __('model.dashboard.stats.title') }}</h3>
                    </div>
                    <div class="sh-stats-grid">
                        <div class="sh-stat-card">
                            <div class="sh-stat-info">
                                <span class="sh-stat-value">{{ number_format($stats['total_earnings'] ?? 0) }}</span>
                                <span class="sh-stat-label">{{ __('model.dashboard.stats.total_earnings') }}</span>
                            </div>
                            <div class="sh-stat-icon"><i class="fas fa-coins"></i></div>
                        </div>

                        <div class="sh-stat-card">
                            <div class="sh-stat-info">
                                <span class="sh-stat-value">{{ $stats['total_subscribers'] }}</span>
                                <span class="sh-stat-label">{{ __('model.dashboard.stats.subscribers') }}</span>
                            </div>
                            <div class="sh-stat-icon"><i class="fas fa-users"></i></div>
                        </div>

                        <div class="sh-stat-card">
                            <div class="sh-stat-info">
                                <span class="sh-stat-value">{{ $stats['total_photos'] + $stats['total_videos'] }}</span>
                                <span class="sh-stat-label">{{ __('model.dashboard.stats.total_content') }}</span>
                            </div>
                            <div class="sh-stat-icon"><i class="fas fa-photo-video"></i></div>
                        </div>

                        @if(isset($userRank))
                            <div class="sh-stat-card">
                                <div class="sh-stat-info">
                                    <span class="sh-stat-value">#{{ $userRank }}</span>
                                    <span class="sh-stat-label">{{ __('model.dashboard.stats.global_ranking') }}</span>
                                </div>
                                <div class="sh-stat-icon"><i class="fas fa-trophy"></i></div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="sh-card"
                    style="background: linear-gradient(135deg, rgba(212,175,55,0.05), rgba(0,0,0,0)); border-color: rgba(212,175,55,0.2);">
                    <div style="display: flex; gap: 12px; margin-bottom: 12px; align-items: center;">
                        <i class="fas fa-shield-alt" style="font-size: 24px; color: var(--model-gold);"></i>
                        <h4 style="margin: 0; font-size: 16px; color: #dfc04e;">{{ __('model.dashboard.security.title') }}</h4>
                    </div>
                    <p style="font-size: 13px; opacity: 0.7; line-height: 1.5; margin-bottom: 16px;">
                        {{ __('model.dashboard.security.desc') }}
                    </p>
                    <a href="#"
                        style="font-size: 13px; color: var(--model-gold); font-weight: 600; text-decoration: none;">
                        {{ __('model.dashboard.security.link') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection