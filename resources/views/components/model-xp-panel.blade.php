@props(['userProgress', 'currentLevel', 'nextLevel', 'xpPercentage', 'currentXP', 'requiredXP'])

@if($currentLevel)
<div class="model-xp-panel">
    <div class="xp-header">
        <div class="level-badge">
            <div class="liga-icon">
                @php
                    $ligaIcons = [
                        'Bronce' => 'fa-medal',
                        'Plata' => 'fa-trophy',
                        'Oro' => 'fa-crown',
                        'Platino' => 'fa-gem',
                        'Diamante' => 'fa-star'
                    ];
                    $ligaIcon = $ligaIcons[$currentLevel->liga ?? 'Bronce'] ?? 'fa-medal';
                @endphp
                <i class="fas {{ $ligaIcon }}"></i>
            </div>
            <div class="level-info">
                <span class="level-number">{{ __('components.model_xp.level', ['number' => $currentLevel->level_number ?? 0]) }}</span>
                <span class="liga-name">{{ $currentLevel->liga ?? 'Bronce' }}</span>
            </div>
        </div>
        
        <div class="xp-stats">
            <span class="xp-current">{{ number_format($currentXP ?? 0) }}</span>
            <span class="xp-separator">/</span>
            <span class="xp-required">{{ number_format($requiredXP ?? 100) }} XP</span>
        </div>
    </div>
    
    <div class="xp-progress-container">
        <div class="xp-progress-bar">
            <div class="xp-progress-fill" style="width: {{ $xpPercentage }}%">
                <span class="xp-percentage">{{ round($xpPercentage) }}%</span>
            </div>
        </div>
    </div>
    
    @if($nextLevel)
    <div class="next-level-info">
        <i class="fas fa-arrow-up"></i>
        <span>{{ __('components.model_xp.next_level', ['name' => $nextLevel->name]) }}</span>
        @if($nextLevel->rewards_json)
            @php
                $rewards = is_array($nextLevel->rewards_json) ? $nextLevel->rewards_json : json_decode($nextLevel->rewards_json, true);
            @endphp
            <span class="reward-preview">
                @if(isset($rewards['commission_rate']))
                    <i class="fas fa-percentage"></i> {{ __('components.model_xp.commission', ['rate' => $rewards['commission_rate']]) }}
                @endif
            </span>
        @endif
    </div>
    @endif
</div>

@else
<div class="model-xp-panel">
    <div class="xp-header">
        <div class="level-badge">
            <div class="liga-icon">
                <i class="fas fa-medal"></i>
            </div>
            <div class="level-info">
                <span class="level-number">{{ __('components.model_xp.level', ['number' => 0]) }}</span>
                <span class="liga-name">{{ __('components.model_xp.novice') }}</span>
            </div>
        </div>
        
        <div class="xp-stats">
            <span class="xp-current">0</span>
            <span class="xp-separator">/</span>
            <span class="xp-required">100 XP</span>
        </div>
    </div>
    
    <div class="xp-progress-container">
        <div class="xp-progress-bar">
            <div class="xp-progress-fill" style="width: 0%">
                <span class="xp-percentage">0%</span>
            </div>
        </div>
    </div>
    
    <div class="next-level-info">
        <i class="fas fa-info-circle"></i>
        <span>{{ __('components.model_xp.complete_missions') }}</span>
    </div>
</div>
@endif

<style>
.model-xp-panel {
    background: linear-gradient(135deg, rgba(212, 175, 55, 0.15), rgba(244, 227, 125, 0.05));
    border: 1px solid rgba(212, 175, 55, 0.3);
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1rem;
    position: relative;
    overflow: hidden;
}

.model-xp-panel::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at top right, rgba(212, 175, 55, 0.1), transparent);
    pointer-events: none;
}

.xp-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    position: relative;
    z-index: 1;
}

.level-badge {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.liga-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--gradient-gold);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: #000;
    box-shadow: 0 5px 15px rgba(212, 175, 55, 0.4);
    animation: pulse-glow 3s ease-in-out infinite;
}

@keyframes pulse-glow {
    0%, 100% {
        box-shadow: 0 10px 30px rgba(212, 175, 55, 0.4);
        transform: scale(1);
    }
    50% {
        box-shadow: 0 15px 40px rgba(212, 175, 55, 0.6);
        transform: scale(1.05);
    }
}

.level-info {
    display: flex;
    flex-direction: column;
}

.level-number {
    font-size: 1.25rem;
    font-weight: 700;
    font-family: var(--font-titles);
    color: var(--color-oro-sensual);
    line-height: 1;
}

.liga-name {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.8);
    margin-top: 0.125rem;
}

.xp-stats {
    display: flex;
    align-items: baseline;
    gap: 0.5rem;
    font-family: var(--font-titles);
}

.xp-current {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--color-oro-sensual);
}

.xp-separator {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.5);
}

.xp-required {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.7);
}

.xp-progress-container {
    position: relative;
    z-index: 1;
    margin-bottom: 1rem;
}

.xp-progress-bar {
    height: 20px;
    background: rgba(0, 0, 0, 0.3);
    border-radius: 10px;
    overflow: hidden;
    position: relative;
    box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.3);
}

.xp-progress-fill {
    height: 100%;
    background: var(--gradient-gold);
    border-radius: 10px;
    transition: width 1s ease-out;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding-right: 0.75rem;
    position: relative;
    overflow: hidden;
}

.xp-progress-fill::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.xp-percentage {
    font-size: 0.75rem;
    font-weight: 700;
    color: #000;
    position: relative;
    z-index: 1;
}

.next-level-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    background: rgba(0, 0, 0, 0.2);
    border-radius: 8px;
    font-size: 0.85rem;
    position: relative;
    z-index: 1;
}

.next-level-info i {
    color: var(--color-oro-sensual);
}

.next-level-info strong {
    color: var(--color-oro-sensual);
}

.reward-preview {
    margin-left: auto;
    padding: 0.5rem 1rem;
    background: rgba(212, 175, 55, 0.2);
    border-radius: 8px;
    font-size: 0.9rem;
    color: var(--color-oro-sensual);
}

@media (max-width: 768px) {
    .model-xp-panel {
        padding: 1.5rem;
    }
    
    .xp-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .level-number {
        font-size: 1.5rem;
    }
    
    .xp-current {
        font-size: 1.5rem;
    }
    
    .next-level-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .reward-preview {
        margin-left: 0;
    }
}
</style>
