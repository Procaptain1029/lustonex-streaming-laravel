@props([
    'obligatoryMission' => null,
    'weeklyMissions' => []
])

<div class="fan-missions-premium">
    <div class="missions-premium-header">
        <h3 class="widget-title">
           {{ __('fan.dashboard.missions.title') }}
        </h3>
        <div class="missions-header-row">
            <p class="widget-subtitle">{{ __('fan.dashboard.missions.subtitle') }}</p>
            <a href="{{ route('fan.missions.index') }}" class="view-all-link">{{ __('fan.dashboard.missions.view_all') }}</a>
        </div>
    </div>
    
    <div class="missions-premium-stack">
        
        @if($obligatoryMission)
            <div class="mission-item-premium obligatory">
                <div class="mission-tag-obligatory">{{ __('fan.dashboard.missions.required') }}</div>
                <div class="mission-main">
                    <div class="mission-icon-box">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="mission-content">
                        <h4 class="m-title">{{ $obligatoryMission->title }}</h4>
                        <div class="m-progress-meta">
                            <div class="m-progress-bar-track">
                                <div class="m-progress-bar-fill" style="width: {{ $obligatoryMission->progress }}%"></div>
                            </div>
                            <span class="m-progress-text">{{ $obligatoryMission->current }}/{{ $obligatoryMission->target }}</span>
                        </div>
                    </div>
                </div>
                <div class="mission-reward-mini">
                    <i class="fas fa-level-up-alt"></i> {{ __('fan.dashboard.missions.unlock_level', ['level' => $obligatoryMission->next_level]) }}
                </div>
            </div>
        @endif
        
        
        @forelse($weeklyMissions as $mission)
            <div class="mission-item-premium weekly {{ $mission->completed ? 'completed' : '' }}">
                <div class="mission-main">
                    <div class="mission-icon-box">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    @if($mission->completed)
                        <div class="completed-check"><i class="fas fa-check"></i></div>
                    @endif
                    <div class="mission-content">
                        <h4 class="m-title">{{ $mission->title }}</h4>
                        <div class="m-progress-meta">
                            <div class="m-progress-bar-track">
                                <div class="m-progress-bar-fill" style="width: {{ $mission->progress }}%"></div>
                            </div>
                            <span class="m-progress-text">{{ $mission->current }}/{{ $mission->target }}</span>
                        </div>
                    </div>
                </div>
                <div class="mission-reward-mini">
                    <i class="fas fa-ticket-alt"></i> {{ $mission->ticket_reward }} {{ __('fan.dashboard.missions.tickets') }}
                </div>
            </div>
        @empty
            <div class="m-empty-state">
                <i class="fas fa-check-double mb-2"></i>
                <p>{{ __('fan.dashboard.missions.all_done') }}</p>
                <span>{{ __('fan.dashboard.missions.more_coming') }}</span>
            </div>
        @endforelse
    </div>
</div>

<style>
.fan-missions-premium {
    background: rgba(30, 30, 35, 0.4);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 24px;
    padding: 1.5rem;
}

.missions-premium-header {
    margin-bottom: 1.5rem;
}

.widget-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0 0 4px 0;
}

.widget-title i { color: var(--accent-gold); }

.missions-header-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
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

.widget-subtitle {
    font-size: 0.8rem;
    opacity: 0.5;
    margin: 0;
}

.missions-premium-stack {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.mission-item-premium {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 18px;
    padding: 1rem;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.mission-item-premium.obligatory {
    background: linear-gradient(135deg, rgba(212, 175, 55, 0.08), rgba(0, 0, 0, 0.2));
    border: 1px solid rgba(212, 175, 55, 0.3);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    /* Make it stand out more */
}

.mission-tag-obligatory {
    position: absolute;
    top: 0;
    right: 0;
    background: #e50914;
    color: #fff;
    font-size: 0.65rem;
    font-weight: 800;
    padding: 3px 12px;
    border-bottom-left-radius: 12px;
    box-shadow: -2px 2px 5px rgba(229, 9, 20, 0.3);
}

.mission-main {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 15px;
}

.mission-icon-box {
    width: 48px;
    height: 48px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: rgba(255,255,255,0.6);
    flex-shrink: 0; /* Prevent shrinking */
}

.mission-item-premium.obligatory .mission-icon-box {
    background: radial-gradient(circle, rgba(212, 175, 55, 0.2), rgba(0,0,0,0));
    border: 1px solid rgba(212, 175, 55, 0.2);
    color: var(--accent-gold);
    box-shadow: 0 0 10px rgba(212, 175, 55, 0.1);
}

.mission-content {
    flex: 1;
}

.m-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: #fff;
    margin: 0 0 6px 0;
}

.m-progress-meta {
    display: flex;
    align-items: center;
    gap: 10px;
}

.m-progress-bar-track {
    flex: 1;
    height: 6px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 3px;
    overflow: hidden;
}

.m-progress-bar-fill {
    height: 100%;
    background: var(--gradient-gold);
    border-radius: 3px;
}

.m-progress-text {
    font-size: 0.7rem;
    font-weight: 700;
    opacity: 0.4;
    white-space: nowrap;
}

.mission-reward-mini {
    background: rgba(212, 175, 55, 0.05);
    border-radius: 10px;
    padding: 6px 12px;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--accent-gold);
    display: flex;
    align-items: center;
    gap: 8px;
}

.mission-item-premium.completed {
    opacity: 0.6;
}

.completed-check {
    width: 20px;
    height: 20px;
    background: #28a745;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.6rem;
    position: absolute;
    top: 30px;
    left: 36px;
    z-index: 2;
    border: 2px solid #1e1e23;
}

.m-empty-state {
    text-align: center;
    padding: 2rem 1rem;
    color: rgba(255,255,255,0.3);
}

.m-empty-state p {
    font-weight: 700;
    color: rgba(255,255,255,0.5);
    margin-bottom: 2px;
}

.m-empty-state span { font-size: 0.75rem; }

@media (max-width: 768px) {
    .fan-missions-premium {
        padding: 1.25rem;
        border-radius: 18px;
    }

    .missions-premium-header {
        margin-bottom: 1rem;
    }

    .widget-subtitle {
        font-size: 0.75rem;
    }

    .missions-premium-stack {
        gap: 0.75rem;
    }

    .mission-item-premium {
        padding: 0.75rem;
        border-radius: 14px;
    }

    .mission-main {
        gap: 12px;
        margin-bottom: 10px;
    }

    .mission-icon-box {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        font-size: 1.1rem;
    }

    .m-title {
        font-size: 0.82rem;
    }

    .mission-reward-mini {
        padding: 5px 10px;
        font-size: 0.7rem;
        border-radius: 8px;
    }

    .mission-tag-obligatory {
        font-size: 0.6rem;
        padding: 2px 10px;
    }
}

@media (max-width: 480px) {
    .fan-missions-premium {
        padding: 1rem;
        border-radius: 14px;
    }

    .mission-icon-box {
        width: 34px;
        height: 34px;
        font-size: 0.95rem;
        border-radius: 8px;
    }

    .m-title {
        font-size: 0.78rem;
    }

    .m-progress-text {
        font-size: 0.65rem;
    }

    .mission-reward-mini {
        font-size: 0.65rem;
        gap: 6px;
    }

    .completed-check {
        width: 18px;
        height: 18px;
        font-size: 0.55rem;
        top: 24px;
        left: 30px;
    }
}
</style>
