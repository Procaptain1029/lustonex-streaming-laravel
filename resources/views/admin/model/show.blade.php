@extends('layouts.admin')

@section('title', __('admin.models-2.show.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('admin.models.index') }}" class="breadcrumb-item">{{ __('admin.models-2.index.breadcrumb') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ $model->name }}</span>
@endsection

@section('styles')
    <style>
        .sh-profile-container {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 30px;
        }

        /* Left Column: Profile Card */
        .sh-profile-card {
            background: rgba(30, 30, 35, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
            overflow: hidden;
            position: relative;
        }

        .sh-profile-cover {
            height: 140px;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.2), rgba(0, 0, 0, 0.9));
            position: relative;
        }

        .sh-profile-avatar {
            width: 110px;
            height: 110px;
            border-radius: 20px;
            border: 4px solid #1e1e24;
            position: absolute;
            top: 85px;
            left: 50%;
            transform: translateX(-50%);
            object-fit: cover;
            background: #000;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .sh-profile-info {
            padding: 50px 25px 30px;
            text-align: center;
        }

        .sh-user-name {
            font-size: 1.4rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 5px;
        }

        .sh-user-email {
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .sh-badge-role {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: rgba(168, 85, 247, 0.1);
            color: #a855f7;
            border: 1px solid rgba(168, 85, 247, 0.2);
        }

        .sh-info-list {
            margin-top: 30px;
            text-align: left;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .sh-info-item {
            display: flex;
            justify-content: space-between;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sh-info-item:last-child {
            border-bottom: none;
        }

        .sh-label {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.4);
        }

        .sh-value {
            font-size: 0.9rem;
            color: #fff;
            font-weight: 600;
        }

        .sh-actions-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 25px;
        }

        .btn-action {
            padding: 10px;
            border-radius: 12px;
            text-align: center;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            color: #fff;
            font-size: 0.8rem;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-action:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-2px);
        }

        /* Right Column: Content */
        .sh-content-section h3 {
            font-size: 1.1rem;
            color: #fff;
            margin-bottom: 20px;
            border-left: 3px solid var(--admin-gold);
            padding-left: 15px;
        }

        .sh-stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .sh-stat-card {
            background: rgba(30, 30, 35, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 18px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .sh-stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .sh-verification-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 16px;
            margin-bottom: 30px;
        }

        .sh-verification-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .status-pending {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.2);
        }

        .status-approved {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .status-rejected {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        @media (max-width: 992px) {
            .sh-profile-container {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .sh-profile-cover {
                height: 120px;
            }

            .sh-profile-avatar {
                width: 90px;
                height: 90px;
                top: 75px;
            }
            
            .sh-profile-info {
                padding: 60px 20px 25px;
            }

            .sh-actions-grid {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }
        }

        @media (max-width: 768px) {
            .sh-stats-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 15px;
            }
            .sh-stat-card {
                padding: 15px;
            }
            .sh-stat-icon {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }
        }

        @media (max-width: 480px) {
            .sh-profile-card {
                border-radius: 16px;
            }
            .sh-profile-cover {
                height: 100px;
            }
            .sh-profile-avatar {
                width: 80px;
                height: 80px;
                top: 60px;
                border-width: 3px;
            }
            .sh-profile-info {
                padding: 50px 15px 20px;
            }
            .sh-user-name {
                font-size: 1.2rem;
            }
            .sh-stats-grid {
                grid-template-columns: 1fr !important;
            }
            .sh-content-section h3 {
                font-size: 1rem;
            }
            .sh-verification-card {
                padding: 15px;
            }
            .sh-verification-card > div {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start !important;
            }
        }
    </style>
@endsection

@section('content')
    <div class="sh-profile-container">
        
        <div class="sh-profile-card">
            <div class="sh-profile-cover"></div>
            <img src="{{ $model->profile?->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($model->name) . '&background=random&color=fff' }}"
                class="sh-profile-avatar" alt="{{ $model->name }}"
                onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($model->name) }}'">

            <div class="sh-profile-info">
                <h2 class="sh-user-name" style="margin-top: 20px;">{{ $model->name }}</h2>
                <p class="sh-user-email">{{ $model->email }}</p>
                <span class="sh-badge-role">{{ __('admin.models-2.show.role') }}</span>

                <div class="sh-info-list">
                    <div class="sh-info-item">
                        <span class="sh-label">{{ __('admin.models-2.show.info.status') }}</span>
                        <span class="sh-value" style="color: {{ $model->is_active ? '#10b981' : '#ef4444' }}">
                            <i class="fas fa-circle" style="font-size: 8px;"></i>
                            {{ $model->is_active ? __('admin.models-2.show.info.active') : __('admin.models-2.show.info.suspended') }}
                        </span>
                    </div>
                    <div class="sh-info-item">
                        <span class="sh-label">{{ __('admin.models-2.show.info.verification') }}</span>
                        <span class="sh-value">
                            @php
                                $status = $model->profile?->verification_status ?? 'pending';
                                $labels = [
                                    'pending' => __('admin.models-2.index.table.status.pending'),
                                    'under_review' => __('admin.models-2.index.table.status.under_review'),
                                    'approved' => __('admin.models-2.index.table.status.approved'),
                                    'rejected' => __('admin.models-2.index.table.status.rejected')
                                ];
                            @endphp
                            {{ $labels[$status] ?? __('admin.models-2.index.table.status.default') }}
                        </span>
                    </div>
                    <div class="sh-info-item">
                        <span class="sh-label">{{ __('admin.models-2.show.info.member_since') }}</span>
                        <span class="sh-value">{{ $model->created_at?->format('d M, Y') ?? 'N/A' }}</span>
                    </div>
                    <div class="sh-info-item">
                        <span class="sh-label">{{ __('admin.models-2.show.info.last_activity') }}</span>
                        <span class="sh-value">{{ $model->updated_at?->diffForHumans() ?? 'N/A' }}</span>
                    </div>
                    @if($model->profile && $model->profile->is_streaming)
                        <div class="sh-info-item">
                            <span class="sh-label">{{ __('admin.models-2.show.info.stream_status') }}</span>
                            <span class="sh-value" style="color: #ff4d4d;">
                                <i class="fas fa-circle" style="font-size: 8px;"></i> {{ __('admin.models-2.show.info.live') }}
                            </span>
                        </div>
                    @endif
                </div>

                <div class="sh-actions-grid">
                    
                   
                    <a href="{{ route('admin.models.index') }}" class="btn-action"
                        style="background: rgba(255,255,255,0.05); width: 100%;">
                        <i class="fas fa-arrow-left"></i> {{ __('admin.models-2.show.info.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>

        
        <div class="sh-content-section">
            
            <h3><i class="fas fa-chart-bar"></i> {{ __('admin.models-2.show.stats.title') }}</h3>
            <div class="sh-stats-grid">
                
                <div class="sh-stat-card">
                    <div class="sh-stat-icon" style="background: rgba(212, 175, 55, 0.1); color: var(--admin-gold);">
                        <i class="fas fa-users"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.8rem; opacity: 0.5;">{{ __('admin.models-2.show.stats.subscribers') }}</div>
                        <div style="font-size: 1.5rem; font-weight: 800; color: #fff; line-height: 1;">
                            {{ number_format($stats['subscribers'] ?? 0) }}
                        </div>
                    </div>
                </div>

                
                <div class="sh-stat-card">
                    <div class="sh-stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.8rem; opacity: 0.5;">{{ __('admin.models-2.show.stats.total_earnings') }}</div>
                        <div style="font-size: 1.2rem; font-weight: 700; color: #fff;">
                            ${{ number_format($stats['total_earnings'] ?? 0, 2) }}
                        </div>
                    </div>
                </div>

                
                <div class="sh-stat-card">
                    <div class="sh-stat-icon" style="background: rgba(168, 85, 247, 0.1); color: #a855f7;">
                        <i class="fas fa-photo-video"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.8rem; opacity: 0.5;">{{ __('admin.models-2.show.stats.content') }}</div>
                        <div style="font-size: 1.5rem; font-weight: 800; color: #fff; line-height: 1;">
                            {{ number_format($stats['total_content'] ?? 0) }}
                        </div>
                    </div>
                </div>
            </div>

            
            @if($model->profile)
                <h3><i class="fas fa-shield-check"></i> {{ __('admin.models-2.show.verification.title') }}</h3>
                <div class="sh-verification-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <span class="sh-verification-status status-{{ $model->profile->verification_status ?? 'pending' }}">
                            <i
                                class="fas fa-{{ ($model->profile->verification_status ?? 'pending') === 'approved' ? 'check-circle' : 'clock' }}"></i>
                            {{ $labels[$model->profile->verification_status ?? 'pending'] ?? __('admin.models-2.index.table.status.default') }}
                        </span>
                        @if(($model->profile->verification_status ?? 'pending') !== 'approved')
                            <a href="{{ route('admin.verification.show', $model->id) }}" class="btn-action"
                                style="padding: 8px 16px;">
                                <i class="fas fa-eye"></i> {{ __('admin.models-2.show.verification.review') }}
                            </a>
                        @endif
                    </div>
                    @if($model->profile->verification_notes)
                        <div
                            style="background: rgba(255,255,255,0.02); padding: 12px; border-radius: 8px; font-size: 0.85rem; color: rgba(255,255,255,0.6);">
                            <strong style="color: rgba(255,255,255,0.8);">{{ __('admin.models-2.show.verification.notes') }}</strong> {{ $model->profile->verification_notes }}
                        </div>
                    @endif
                </div>
            @endif

            
            <h3><i class="fas fa-folder-open"></i> {{ __('admin.models-2.show.content_summary.title') }}</h3>
            <div class="sh-stats-grid" style="grid-template-columns: repeat(2, 1fr);">
                <div class="sh-stat-card">
                    <div class="sh-stat-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                        <i class="fas fa-images"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.8rem; opacity: 0.5;">{{ __('admin.models-2.show.content_summary.photos') }}</div>
                        <div style="font-size: 1.5rem; font-weight: 800; color: #fff; line-height: 1;">
                            {{ number_format($stats['photos_count'] ?? 0) }}
                        </div>
                    </div>
                </div>

                <div class="sh-stat-card">
                    <div class="sh-stat-icon" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                        <i class="fas fa-video"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.8rem; opacity: 0.5;">{{ __('admin.models-2.show.content_summary.videos') }}</div>
                        <div style="font-size: 1.5rem; font-weight: 800; color: #fff; line-height: 1;">
                            {{ number_format($stats['videos_count'] ?? 0) }}
                        </div>
                    </div>
                </div>

                <div class="sh-stat-card">
                    <div class="sh-stat-icon" style="background: rgba(255, 193, 7, 0.1); color: #ffc107;">
                        <i class="fas fa-broadcast-tower"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.8rem; opacity: 0.5;">{{ __('admin.models-2.show.content_summary.total_streams') }}</div>
                        <div style="font-size: 1.5rem; font-weight: 800; color: #fff; line-height: 1;">
                            {{ number_format($stats['streams_count'] ?? 0) }}
                        </div>
                    </div>
                </div>

                <div class="sh-stat-card">
                    <div class="sh-stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                        <i class="fas fa-coins"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.8rem; opacity: 0.5;">{{ __('admin.models-2.show.content_summary.tips_received') }}</div>
                        <div style="font-size: 1.2rem; font-weight: 700; color: #fff;">
                            {{ number_format($stats['tips_count'] ?? 0) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
