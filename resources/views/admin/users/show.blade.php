@extends('layouts.admin')

@section('title', __('admin.users.show.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('admin.users.index') }}" class="breadcrumb-item">{{ __('admin.users.breadcrumb') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ $user->name }}</span>
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
            /* Overlaps cover (140px height) correctly */
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
        }

        .role-fan {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .role-admin {
            background: rgba(212, 175, 55, 0.1);
            color: var(--admin-gold);
            border: 1px solid rgba(212, 175, 55, 0.2);
        }

        .role-model {
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

        .sh-level-progress {
            margin-top: 5px;
            height: 6px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
            overflow: hidden;
        }

        .sh-level-fill {
            height: 100%;
            background: var(--admin-gold);
            border-radius: 3px;
        }

        /* Missions List */
        .sh-missions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 15px;
        }

        .sh-mission-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 16px;
            display: flex;
            gap: 15px;
            align-items: flex-start;
        }

        .sh-mission-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.5);
        }

        .sh-mission-card.completed .sh-mission-icon {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        @media (max-width: 992px) {
            .sh-profile-container {
                grid-template-columns: 1fr;
            }

            .sh-stats-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sh-profile-card {
                border-radius: 16px;
            }

            .sh-profile-cover {
                height: 100px;
            }

            .sh-profile-avatar {
                width: 80px;
                height: 80px;
                border-radius: 16px;
                top: 60px;
                border-width: 3px;
            }

            .sh-profile-info {
                padding: 35px 20px 24px;
            }

            .sh-user-name {
                font-size: 1.2rem;
            }

            .sh-user-email {
                font-size: 0.8rem;
                margin-bottom: 16px;
            }

            .sh-badge-role {
                padding: 5px 14px;
                font-size: 11px;
            }

            .sh-info-list {
                margin-top: 20px;
                gap: 12px;
            }

            .sh-info-item {
                padding-bottom: 10px;
            }

            .sh-label {
                font-size: 12px;
            }

            .sh-value {
                font-size: 13px;
            }

            .sh-actions-grid {
                gap: 8px;
                margin-top: 20px;
            }

            .btn-action {
                padding: 8px;
                font-size: 12px;
                border-radius: 10px;
            }

            .sh-stat-card {
                padding: 16px;
                border-radius: 14px;
                gap: 12px;
            }

            .sh-stat-icon {
                width: 42px;
                height: 42px;
                border-radius: 12px;
                font-size: 1.2rem;
            }

            .sh-content-section h3 {
                font-size: 1rem;
                margin-bottom: 16px;
                padding-left: 12px;
            }

            .sh-missions-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .sh-mission-card {
                padding: 12px;
                border-radius: 12px;
                gap: 12px;
            }

            .sh-mission-icon {
                width: 34px;
                height: 34px;
                border-radius: 8px;
            }
        }

        @media (max-width: 480px) {
            .sh-profile-cover {
                height: 80px;
            }

            .sh-profile-avatar {
                width: 64px;
                height: 64px;
                border-radius: 14px;
                top: 48px;
            }

            .sh-profile-info {
                padding: 28px 16px 20px;
            }

            .sh-user-name {
                font-size: 1.1rem;
            }

            .sh-actions-grid {
                grid-template-columns: 1fr;
            }

            .btn-action[style*="grid-column: span 2"] {
                grid-column: span 1 !important;
            }

            .sh-stat-card {
                padding: 14px;
                border-radius: 12px;
            }

            .sh-stat-icon {
                width: 36px;
                height: 36px;
                font-size: 1rem;
            }

            .sh-mission-card {
                padding: 10px;
            }

            .sh-mission-icon {
                width: 30px;
                height: 30px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="sh-profile-container">
        
        <div class="sh-profile-card">
            <div class="sh-profile-cover"></div>
            <img src="{{ $user->profile->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&color=fff' }}"
                class="sh-profile-avatar" alt="{{ $user->name }}"
                onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}'">

            <div class="sh-profile-info">
                <h2 class="sh-user-name" style="margin-top: 20px;">{{ $user->name }}</h2>
                <p class="sh-user-email">{{ $user->email }}</p>
                <span class="sh-badge-role role-{{ $user->role }}">{{ $user->role }}</span>

                <div class="sh-info-list">
                    <div class="sh-info-item">
                        <span class="sh-label">{{ __('admin.users.show.profile.status') }}</span>
                        <span class="sh-value" style="color: {{ $user->is_active ? '#10b981' : '#ef4444' }}">
                            <i class="fas fa-circle" style="font-size: 8px;"></i>
                            {{ $user->is_active ? __('admin.users.show.profile.active') : __('admin.users.show.profile.suspended') }}
                        </span>
                    </div>
                    <div class="sh-info-item">
                        <span class="sh-label">{{ __('admin.users.show.profile.member_since') }}</span>
                        <span class="sh-value">{{ $user->created_at->format('d M, Y') }}</span>
                    </div>
                    <div class="sh-info-item">
                        <span class="sh-label">{{ __('admin.users.show.profile.last_access') }}</span>
                        <span class="sh-value">{{ $user->updated_at->diffForHumans() }}</span>
                    </div>
                </div>

                <div class="sh-actions-grid">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-action">
                        <i class="fas fa-edit"></i> {{ __('admin.users.show.profile.actions.edit') }}
                    </a>
                    <a href="{{ route('admin.gamification.debugger', $user->id) }}" class="btn-action">
                        <i class="fas fa-magic"></i> {{ __('admin.users.show.profile.actions.debug') }}
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn-action"
                        style="grid-column: span 2; background: rgba(255,255,255,0.05);">
                        <i class="fas fa-arrow-left"></i> {{ __('admin.users.show.profile.actions.back') }}
                    </a>
                </div>
            </div>
        </div>

        
        <div class="sh-content-section">
            
            <h3><i class="fas fa-gamepad"></i> {{ __('admin.users.show.stats.title') }}</h3>
            <div class="sh-stats-grid">
                
                <div class="sh-stat-card">
                    <div class="sh-stat-icon" style="background: rgba(212, 175, 55, 0.1); color: var(--admin-gold);">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.8rem; opacity: 0.5;">{{ __('admin.users.show.stats.level') }}</div>
                        <div style="font-size: 1.5rem; font-weight: 800; color: #fff; line-height: 1;">
                            {{ $user->progress->currentLevel->level_number ?? 0 }}
                        </div>
                    </div>
                </div>

                
                <div class="sh-stat-card">
                    <div class="sh-stat-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.8rem; opacity: 0.5;">{{ __('admin.users.show.stats.experience') }}</div>
                        <div style="font-size: 1.2rem; font-weight: 700; color: #fff;">
                            {{ number_format($user->progress->current_xp ?? 0) }} XP
                        </div>
                        @php
                            // Simple progress calculation if next level exists
                            $currentLevelNum = $user->progress->currentLevel->level_number ?? 0;
                            $nextLevel = \App\Models\Level::where('level_number', '>', $currentLevelNum)->orderBy('level_number')->first();
                            $percent = 0;
                            if ($nextLevel && isset($user->progress)) {
                                // Calculate based on range between current and next level, or absolute if simplest
                                $xpRequired = $nextLevel->xp_required;
                                $percent = $xpRequired > 0 ? ($user->progress->current_xp / $xpRequired) * 100 : 0;
                            }
                        @endphp
                        @if($nextLevel)
                            <div class="sh-level-progress"
                                title="{{ number_format($percent) }}{{ __('admin.users.show.stats.xp_to_next_level') }} {{ $nextLevel->level_number }}">
                                <div class="sh-level-fill" style="width: {{ min($percent, 100) }}%"></div>
                            </div>
                        @endif
                    </div>
                </div>

                
                <div class="sh-stat-card">
                    <div class="sh-stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.8rem; opacity: 0.5;">{{ __('admin.users.show.stats.tickets') }}</div>
                        <div style="font-size: 1.5rem; font-weight: 800; color: #fff; line-height: 1;">
                            {{ number_format($user->progress->tickets_balance ?? 0) }}
                        </div>
                    </div>
                </div>
            </div>

            
            <h3><i class="fas fa-tasks"></i> {{ __('admin.users.show.missions.title') }}</h3>
            @if($user->missions && $user->missions->count() > 0)
                <div class="sh-missions-grid">
                    @foreach($user->missions as $mission)
                        <div class="sh-mission-card {{ $mission->pivot->completed ? 'completed' : '' }}">
                            <div class="sh-mission-icon">
                                <i class="fas {{ $mission->pivot->completed ? 'fa-check' : 'fa-hourglass' }}"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; font-size: 0.9rem; color: #fff;">
                                    {{ $mission->name }}
                                </div>
                                <div style="font-size: 0.75rem; color: rgba(255,255,255,0.4); margin-top: 4px;">
                                    @if($mission->pivot->completed)
                                        {{ __('admin.users.show.missions.completed') }}
                                        {{ $mission->pivot->completed_at ? \Carbon\Carbon::parse($mission->pivot->completed_at)->format('d M') : '' }}
                                    @else
                                        {{ __('admin.users.show.missions.progress') }} {{ $mission->pivot->progress }} / {{ $mission->target ?? '?' }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 40px; background: rgba(255,255,255,0.02); border-radius: 16px;">
                    <i class="fas fa-clipboard-list"
                        style="font-size: 2rem; color: rgba(255,255,255,0.2); margin-bottom: 15px;"></i>
                    <p style="color: rgba(255,255,255,0.4);">{{ __('admin.users.show.missions.empty') }}</p>
                </div>
            @endif
        </div>
    </div>
@endsection