@extends('layouts.model')

@section('title', __('model.missions.title'))

@section('breadcrumb')
    <a href="{{ route('model.dashboard') }}" class="breadcrumb-item">{{ __('model.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('model.missions.breadcrumb') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Model Missions Professional Styling ----- */

        .page-header {
            padding-top: 24px;
            margin-bottom: 32px;
        }

        /* Estilos de encabezado heredados del layout model */

        /* Stats Grid */
        .sh-stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .sh-stat-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            backdrop-filter: blur(10px);
            transition: transform 0.2s;
        }

        .sh-stat-card:hover {
            transform: translateY(-4px);
            border-color: rgba(212, 175, 55, 0.2);
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
        }

        .sh-stat-content {
            display: flex;
            flex-direction: column;
        }

        .sh-stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
        }

        .sh-stat-label {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Sections */
        .sh-section-title {
            font-size: 24px;
            font-weight: 700;
            color: #dab843;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sh-section-title i {
            color: var(--model-gold);
            opacity: 0.8;
        }

        .sh-missions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
            margin-bottom: 48px;
        }

        /* Mission Card */
        .sh-mission-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 24px;
            display: flex;
            gap: 20px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .sh-mission-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .sh-mission-card.completed {
            opacity: 0.7;
            background: rgba(40, 167, 69, 0.05);
            border-color: rgba(40, 167, 69, 0.2);
        }

        .sh-mission-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: var(--model-gold);
            flex-shrink: 0;
        }

        .sh-mission-card.completed .sh-mission-icon {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }

        .sh-mission-body {
            flex: 1;
        display: flex;
            flex-direction: column;
        }

        .sh-mission-title {
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 6px;
            line-height: 1.3;
        }

        .sh-mission-desc {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 16px;
            line-height: 1.5;
        }

        /* Progress Bar */
        .sh-progress-wrapper {
            margin-bottom: 16px;
        }

        .sh-progress-bar {
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .sh-progress-fill {
            height: 100%;
            background: var(--model-gold);
            border-radius: 4px;
            transition: width 0.5s ease;
        }

        .sh-progress-text {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 600;
            display: flex;
            justify-content: space-between;
        }

        /* Rewards & Actions */
        .sh-mission-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: auto;
        }

        .sh-rewards {
            display: flex;
            gap: 12px;
        }

        .sh-reward-badge {
            font-size: 12px;
            font-weight: 700;
            color: var(--model-gold);
            background: rgba(212, 175, 55, 0.1);
            padding: 4px 8px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .sh-btn-claim {
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 700;
            border-radius: 8px;
            background: var(--model-gold);
            color: #000;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 10px rgba(212, 175, 55, 0.2);
        }

        .sh-btn-claim:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(212, 175, 55, 0.3);
        }

        .sh-status-badge {
            font-size: 12px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
        }

        .sh-status-badge.completed {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }

        .sh-status-badge.progress {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
        }

        @media (max-width: 768px) {
            .page-header {
                padding-top: 16px;
                margin-bottom: 24px;
            }
            .page-header {
                padding-top: 16px;
                margin-bottom: 24px;
            }

            /* Estilos responsivos de encabezado heredados */
            .sh-stats-row { 
                grid-template-columns: 1fr 1fr; 
                gap: 16px;
            }
            .sh-stat-card {
                padding: 16px;
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            .sh-stat-icon {
                width: 40px;
                height: 40px;
                font-size: 16px;
            }
            .sh-stat-value {
                font-size: 20px;
            }
            .sh-section-title {
                font-size: 20px;
                margin-bottom: 16px;
            }
            .sh-mission-card {
                padding: 16px;
                gap: 16px;
            }
            .sh-mission-icon {
                width: 48px;
                height: 48px;
                font-size: 20px;
            }
            .sh-mission-title {
                font-size: 16px;
            }
            .sh-mission-desc {
                font-size: 13px;
                margin-bottom: 12px;
            }
            .sh-progress-wrapper {
                margin-bottom: 12px;
            }
            .sh-rewards {
                flex-wrap: wrap;
                gap: 8px;
                margin-bottom: 12px;
            }
            .sh-reward-badge {
                font-size: 11px;
                padding: 4px 6px;
            }
            .sh-mission-footer { 
                flex-direction: column; 
                align-items: stretch; 
                gap: 12px; 
            }
            .sh-status-badge {
                text-align: center;
            }
            .sh-btn-claim { 
                width: 100%; 
            }
        }

        /* Estilos responsivos heredados */
    </style>
@endsection

@section('content')

    <div class="page-header">
        <h1 class="page-title">{{ __('model.missions.title') }}</h1>
        <p class="page-subtitle">{{ __('model.missions.subtitle') }}</p>
    </div>

    <!-- Stats Row -->
    <div class="sh-stats-row">
        <div class="sh-stat-card">
            <div class="sh-stat-icon"><i class="fas fa-list-check"></i></div>
            <div class="sh-stat-content">
                <span class="sh-stat-value">{{ $stats['total_missions'] }}</span>
                <span class="sh-stat-label">{{ __('model.missions.stats.active') }}</span>
            </div>
        </div>
        <div class="sh-stat-card">
            <div class="sh-stat-icon" style="color: #28a745; background: rgba(40,167,69,0.1);"><i class="fas fa-check-circle"></i></div>
            <div class="sh-stat-content">
                <span class="sh-stat-value">{{ $stats['completed_today'] }}</span>
                <span class="sh-stat-label">{{ __('model.missions.stats.completed') }}</span>
            </div>
        </div>
        <div class="sh-stat-card">
            <div class="sh-stat-icon"><i class="fas fa-star"></i></div>
            <div class="sh-stat-content">
                <span class="sh-stat-value">+{{ $stats['xp_earned_today'] }}</span>
                <span class="sh-stat-label">{{ __('model.missions.stats.xp_today') }}</span>
            </div>
        </div>
        <div class="sh-stat-card">
            <div class="sh-stat-icon" style="color: #e83e8c; background: rgba(232, 62, 140, 0.1);"><i class="fas fa-ticket-alt"></i></div>
            <div class="sh-stat-content">
                <span class="sh-stat-value">{{ $stats['tickets_balance'] }}</span>
                <span class="sh-stat-label">{{ __('model.missions.stats.tickets') }}</span>
            </div>
        </div>
    </div>

    <!-- Obligatory Missions -->
    @if($obligatoryMissions->count() > 0)
        <div style="margin-bottom: 40px;">
            <h2 class="sh-section-title">{{ __('model.missions.sections.high_priority') }}</h2>
            <div class="sh-missions-grid">
                @foreach($obligatoryMissions as $mission)
                    <div class="sh-mission-card {{ $mission['completed'] ? 'completed' : '' }}">
                        <div class="sh-mission-icon">
                            <i class="fas {{ $mission['icon'] }}"></i>
                        </div>
                        <div class="sh-mission-body">
                            <h3 class="sh-mission-title">{{ $mission['title'] }}</h3>
                            <p class="sh-mission-desc">{{ $mission['description'] }}</p>

                            <div class="sh-progress-wrapper">
                                 <div class="sh-progress-bar">
                                    <div class="sh-progress-fill" style="width: {{ ($mission['current'] / $mission['target']) * 100 }}%"></div>
                                 </div>
                                 <div class="sh-progress-text">
                                     <span>{{ __('model.missions.card.progress') }}</span>
                                     <span>{{ $mission['current'] }}/{{ $mission['target'] }}</span>
                                 </div>
                            </div>

                            <div class="sh-mission-footer">
                                <div class="sh-rewards">
                                    <span class="sh-reward-badge"><i class="fas fa-star"></i> +{{ $mission['xp_reward'] }}</span>
                                    <span class="sh-reward-badge"><i class="fas fa-ticket-alt"></i> +{{ $mission['ticket_reward'] }}</span>
                                </div>

                                @if($mission['completed'])
                                    <span class="sh-status-badge completed">
                                        <i class="fas fa-check"></i> {{ __('model.missions.card.completed') }}
                                    </span>
                                @elseif($mission['can_claim'] ?? false)
                                    <button class="sh-btn-claim" onclick="claimMission({{ $mission['id'] }})">
                                        {{ __('model.missions.card.claim') }}
                                    </button>
                                @else
                                    <span class="sh-status-badge progress">{{ __('model.missions.card.in_progress') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Daily Missions -->
    <div style="margin-bottom: 40px;">
        <h2 class="sh-section-title"> {{ __('model.missions.sections.daily') }}</h2>
        <div class="sh-missions-grid">
            @foreach($dailyMissions as $mission)
                <div class="sh-mission-card {{ $mission['completed'] ? 'completed' : '' }}">
                    <div class="sh-mission-icon">
                        <i class="fas {{ $mission['icon'] }}"></i>
                    </div>
                    <div class="sh-mission-body">
                        <h3 class="sh-mission-title">{{ $mission['title'] }}</h3>
                        <p class="sh-mission-desc">{{ $mission['description'] }}</p>

                        <div class="sh-progress-wrapper">
                             <div class="sh-progress-bar">
                                <div class="sh-progress-fill" style="width: {{ ($mission['current'] / $mission['target']) * 100 }}%"></div>
                             </div>
                             <div class="sh-progress-text">
                                 <span>{{ __('model.missions.card.progress') }}</span>
                                 <span>{{ $mission['current'] }}/{{ $mission['target'] }}</span>
                             </div>
                        </div>

                        <div class="sh-mission-footer">
                            <div class="sh-rewards">
                                <span class="sh-reward-badge"><i class="fas fa-star"></i> +{{ $mission['xp_reward'] }}</span>
                                <span class="sh-reward-badge"><i class="fas fa-ticket-alt"></i> +{{ $mission['ticket_reward'] }}</span>
                            </div>

                            @if($mission['completed'])
                                <span class="sh-status-badge completed">
                                    <i class="fas fa-check"></i> {{ __('model.missions.card.completed') }}
                                </span>
                            @elseif($mission['can_claim'] ?? false)
                                <button class="sh-btn-claim" onclick="claimMission({{ $mission['id'] }})">
                                    {{ __('model.missions.card.claim') }}
                                </button>
                            @else
                                <span class="sh-status-badge progress">{{ __('model.missions.card.in_progress') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Weekly Missions -->
    <div style="margin-bottom: 40px;">
        <h2 class="sh-section-title"> {{ __('model.missions.sections.weekly') }}</h2>
        <div class="sh-missions-grid">
            @foreach($weeklyMissions as $mission)
                 <div class="sh-mission-card {{ $mission['completed'] ? 'completed' : '' }}">
                    <div class="sh-mission-icon">
                        <i class="fas {{ $mission['icon'] }}"></i>
                    </div>
                    <div class="sh-mission-body">
                        <h3 class="sh-mission-title">{{ $mission['title'] }}</h3>
                        <p class="sh-mission-desc">{{ $mission['description'] }}</p>

                        <div class="sh-progress-wrapper">
                             <div class="sh-progress-bar">
                                <div class="sh-progress-fill" style="width: {{ ($mission['current'] / $mission['target']) * 100 }}%"></div>
                             </div>
                             <div class="sh-progress-text">
                                 <span>{{ __('model.missions.card.progress') }}</span>
                                 <span>{{ $mission['current'] }}/{{ $mission['target'] }}</span>
                             </div>
                        </div>

                        <div class="sh-mission-footer">
                            <div class="sh-rewards">
                                <span class="sh-reward-badge"><i class="fas fa-star"></i> +{{ $mission['xp_reward'] }}</span>
                                <span class="sh-reward-badge"><i class="fas fa-ticket-alt"></i> +{{ $mission['ticket_reward'] }}</span>
                            </div>

                            @if($mission['completed'])
                                <span class="sh-status-badge completed">
                                    <i class="fas fa-check"></i> {{ __('model.missions.card.completed') }}
                                </span>
                            @elseif($mission['can_claim'] ?? false)
                                <button class="sh-btn-claim" onclick="claimMission({{ $mission['id'] }})">
                                    {{ __('model.missions.card.claim') }}
                                </button>
                            @else
                                <span class="sh-status-badge progress">{{ __('model.missions.card.in_progress') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Monthly Missions -->
    <div style="margin-bottom: 40px;">
        <h2 class="sh-section-title"> {{ __('model.missions.sections.monthly') }}</h2>
        <div class="sh-missions-grid">
            @foreach($monthlyMissions as $mission)
                 <div class="sh-mission-card {{ $mission['completed'] ? 'completed' : '' }}">
                    <div class="sh-mission-icon">
                        <i class="fas {{ $mission['icon'] }}"></i>
                    </div>
                    <div class="sh-mission-body">
                        <h3 class="sh-mission-title">{{ $mission['title'] }}</h3>
                        <p class="sh-mission-desc">{{ $mission['description'] }}</p>

                        <div class="sh-progress-wrapper">
                             <div class="sh-progress-bar">
                                <div class="sh-progress-fill" style="width: {{ ($mission['current'] / $mission['target']) * 100 }}%"></div>
                             </div>
                             <div class="sh-progress-text">
                                 <span>{{ __('model.missions.card.progress') }}</span>
                                 <span>{{ $mission['current'] }}/{{ $mission['target'] }}</span>
                             </div>
                        </div>

                        <div class="sh-mission-footer">
                            <div class="sh-rewards">
                                <span class="sh-reward-badge"><i class="fas fa-star"></i> +{{ $mission['xp_reward'] }}</span>
                                <span class="sh-reward-badge"><i class="fas fa-ticket-alt"></i> +{{ $mission['ticket_reward'] }}</span>
                            </div>

                            @if($mission['completed'])
                                <span class="sh-status-badge completed">
                                    <i class="fas fa-check"></i> {{ __('model.missions.card.completed') }}
                                </span>
                            @elseif($mission['can_claim'] ?? false)
                                <button class="sh-btn-claim" onclick="claimMission({{ $mission['id'] }})">
                                    {{ __('model.missions.card.claim') }}
                                </button>
                            @else
                                <span class="sh-status-badge progress">{{ __('model.missions.card.in_progress') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection

@section('scripts')
    <script>
    function claimMission(missionId) {
        const btn = event.currentTarget;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        btn.disabled = true;

        fetch(`/model/missions/${missionId}/claim`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                btn.innerHTML = '<i class="fas fa-check"></i> {{ __('model.missions.card.claimed') }}';
                // Reload to update stats and move status
                setTimeout(() => location.reload(), 800);
            } else {
                alert("{{ __('model.missions.card.claim_error') }} " + (data.message || "{{ __('model.missions.card.try_again') }}"));
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }
    </script>
@endsection