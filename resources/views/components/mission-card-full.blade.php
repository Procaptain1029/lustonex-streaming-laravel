
@props([
    'mission' => null,
    'showClaim' => true
])

@if($mission)
<div class="mission-card-full {{ $mission['type'] ?? 'daily' }} {{ ($mission['completed'] ?? false) ? 'completed' : '' }}">
    <div class="mission-type-badge {{ $mission['type'] ?? 'daily' }}">
        @if(($mission['type'] ?? '') === 'obligatory')
            <i class="fas fa-exclamation-circle"></i> {{ __('components.mission_card.type_obligatory') }}
        @elseif(($mission['type'] ?? '') === 'daily')
            <i class="fas fa-calendar-day"></i> {{ __('components.mission_card.type_daily') }}
        @elseif(($mission['type'] ?? '') === 'weekly')
            <i class="fas fa-calendar-week"></i> {{ __('components.mission_card.type_weekly') }}
        @elseif(($mission['type'] ?? '') === 'monthly')
            <i class="fas fa-calendar-alt"></i> {{ __('components.mission_card.type_monthly') }}
        @endif
    </div>
    
    @if($mission['completed'] ?? false)
    <div class="mission-completed-overlay">
        <i class="fas fa-check-circle fa-3x"></i>
        <span>{{ __('components.mission_card.completed') }}</span>
        @if($showClaim)
        <button class="btn-claim" onclick="claimMission({{ $mission['id'] ?? 0 }})">
            <i class="fas fa-gift"></i> {{ __('components.mission_card.claim') }}
        </button>
        @endif
    </div>
    @endif
    
    <div class="mission-header">
        <div class="mission-icon-large">
            @if(($mission['type'] ?? '') === 'obligatory')
                <i class="fas fa-star"></i>
            @elseif(($mission['type'] ?? '') === 'daily')
                <i class="fas fa-bullseye"></i>
            @elseif(($mission['type'] ?? '') === 'weekly')
                <i class="fas fa-trophy"></i>
            @else
                <i class="fas fa-crown"></i>
            @endif
        </div>
        <div class="mission-title-section">
            <h4 class="mission-title-full">{{ $mission['title'] ?? 'Misión' }}</h4>
            <p class="mission-description-full">{{ $mission['description'] ?? '' }}</p>
        </div>
    </div>
    
    <div class="mission-progress-section">
        <div class="progress-bar-full">
            <div class="progress-fill-full" style="width: {{ $mission['progress'] ?? 0 }}%">
                <span class="progress-percentage">{{ number_format($mission['progress'] ?? 0, 1) }}%</span>
            </div>
        </div>
        <div class="progress-stats">
            <span class="progress-current">{{ $mission['current'] ?? 0 }} / {{ $mission['target'] ?? 0 }}</span>
            @if(isset($mission['expires_at']) && $mission['expires_at'])
            <span class="progress-expires">
                <i class="fas fa-clock"></i> {{ __('components.mission_card.expires', ['time' => \Carbon\Carbon::parse($mission['expires_at'])->diffForHumans()]) }}
            </span>
            @endif
        </div>
    </div>
    
    <div class="mission-rewards-section">
        <h5 class="rewards-title"><i class="fas fa-gift"></i> {{ __('components.mission_card.rewards') }}</h5>
        <div class="rewards-list">
            @if(isset($mission['reward_xp']) && $mission['reward_xp'] > 0)
            <div class="reward-item">
                <i class="fas fa-star"></i>
                <span>{{ $mission['reward_xp'] }} XP</span>
            </div>
            @endif
            @if(isset($mission['reward_tickets']) && $mission['reward_tickets'] > 0)
            <div class="reward-item">
                <i class="fas fa-ticket-alt"></i>
                <span>{{ $mission['reward_tickets'] }} Tickets</span>
            </div>
            @endif
            @if(isset($mission['reward_level']))
            <div class="reward-item special">
                <i class="fas fa-arrow-up"></i>
                <span>{{ __('components.mission_card.level_reward', ['level' => $mission['reward_level']]) }}</span>
            </div>
            @endif
        </div>
    </div>
</div>
@endif

<style>
.mission-card-full {
    background: rgba(31, 31, 35, 0.95);
    border: 2px solid rgba(212, 175, 55, 0.2);
    border-radius: 16px;
    padding: 1.5rem;
    position: relative;
    transition: all 0.3s ease;
    overflow: hidden;
}

.mission-card-full:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    border-color: var(--color-oro-sensual);
}

.mission-card-full.obligatory {
    border-color: var(--color-rosa-vibrante);
}

.mission-card-full.completed {
    opacity: 0.8;
}

.mission-type-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.25rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    z-index: 5;
}

.mission-type-badge.obligatory {
    background: linear-gradient(135deg, var(--color-rosa-vibrante), var(--color-rosa-oscuro));
    color: white;
}

.mission-type-badge.daily {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.mission-type-badge.weekly {
    background: linear-gradient(135deg, #6f42c1, #e83e8c);
    color: white;
}

.mission-type-badge.monthly {
    background: linear-gradient(135deg, var(--color-oro-sensual), #f4e37d);
    color: #000;
}

.mission-completed-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.85);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    color: #28a745;
    border-radius: 16px;
    z-index: 10;
}

.mission-completed-overlay span {
    font-size: 1.3rem;
    font-weight: 700;
}

.btn-claim {
    padding: 0.75rem 1.5rem;
    background: var(--gradient-gold);
    color: #000;
    border: none;
    border-radius: 10px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-claim:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(212, 175, 55, 0.4);
}

.mission-header {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.mission-icon-large {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: var(--gradient-gold);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #000;
    flex-shrink: 0;
}

.mission-title-section {
    flex: 1;
}

.mission-title-full {
    font-family: var(--font-titles);
    font-size: 1.3rem;
    font-weight: 700;
    color: white;
    margin: 0 0 0.5rem 0;
}

.mission-description-full {
    font-size: 0.95rem;
    color: rgba(255, 255, 255, 0.7);
    margin: 0;
    line-height: 1.5;
}

.mission-progress-section {
    margin-bottom: 1.5rem;
}

.progress-bar-full {
    height: 20px;
    background: rgba(0, 0, 0, 0.3);
    border-radius: 10px;
    overflow: hidden;
    position: relative;
    margin-bottom: 0.75rem;
}

.progress-fill-full {
    height: 100%;
    background: linear-gradient(90deg, var(--color-oro-sensual), #f4e37d);
    border-radius: 10px;
    transition: width 0.5s ease-out;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding-right: 10px;
}

.progress-percentage {
    font-size: 0.75rem;
    font-weight: 700;
    color: #000;
}

.progress-stats {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.9rem;
}

.progress-current {
    color: var(--color-oro-sensual);
    font-weight: 700;
}

.progress-expires {
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.85rem;
}

.mission-rewards-section {
    padding-top: 1rem;
    border-top: 1px solid rgba(212, 175, 55, 0.2);
}

.rewards-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--color-oro-sensual);
    margin: 0 0 0.75rem 0;
}

.rewards-list {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.reward-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: rgba(212, 175, 55, 0.1);
    border-radius: 8px;
    color: var(--color-oro-sensual);
    font-weight: 600;
    font-size: 0.9rem;
}

.reward-item.special {
    background: linear-gradient(135deg, rgba(212, 175, 55, 0.2), rgba(244, 227, 125, 0.2));
    border: 1px solid var(--color-oro-sensual);
}

/* Responsive */
@media (max-width: 768px) {
    .mission-header {
        flex-direction: column;
        text-align: center;
    }
    
    .mission-icon-large {
        margin: 0 auto;
    }
    
    .progress-stats {
        flex-direction: column;
        gap: 0.5rem;
    }
}
</style>
