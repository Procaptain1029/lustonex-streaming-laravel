@props([
    'userProgress' => null,
    'currentLevel' => null,
    'nextLevel' => null,
    'xpPercentage' => 0,
    'currentXP' => 0,
    'requiredXP' => 0
])

<div class="fan-xp-premium-panel">
    <div class="xp-panel-header">
        <h3 class="panel-title-premium">
             {{ __('fan.dashboard.xp.title') }}
        </h3>
        @if($currentLevel)
            <span class="liga-badge">{{ strtoupper($currentLevel->name ?? 'Gris') }}</span>
        @endif
    </div>
    
    <div class="xp-core-content">
        
        <div class="level-visual-area">
            <div class="liga-icon-container">
                @if($currentLevel)
                    <div class="icon-glow"></div>
                    <img src="{{ auth()->user()->getLigaIcon() }}" alt="Liga" class="liga-floating-img">
                    <div class="level-orb">
                        <span>{{ $currentLevel->level_number }}</span>
                    </div>
                @else
                    <div class="liga-placeholder-box">
                        <i class="fas fa-shield-alt fa-3x"></i>
                    </div>
                @endif
            </div>
            
            <div class="level-text-info">
                @if($nextLevel)
                    <div class="xp-count-label">
                        <span class="current-xp">{{ number_format($currentXP) }}</span>
                        <span class="target-xp">/ {{ number_format($requiredXP) }} XP</span>
                    </div>
                    
                    @if($currentXP >= $requiredXP)
                        <p class="xp-needed" style="color: #4ade80;">
                            <i class="fas fa-check-circle"></i> {!! __('fan.dashboard.xp.completed') !!}
                        </p>
                    @else
                        <p class="xp-needed">{!! __('fan.dashboard.xp.needed', ['xp' => number_format($requiredXP - $currentXP)]) !!}</p>
                    @endif
                @else
                    <h4 class="max-level-text">{{ __('fan.dashboard.xp.max_level') }}</h4>
                    <p class="xp-needed">{{ __('fan.dashboard.xp.legend') }}</p>
                @endif
            </div>
        </div>
        
        
        <div class="xp-progress-container">
            <div class="premium-progress-track">
                <div class="premium-progress-fill" style="width: {{ $xpPercentage }}%"></div>
                <span class="progress-percentage-label">{{ round($xpPercentage) }}%</span>
            </div>
        </div>
        
        
        @if($nextLevel)
            <div class="premium-reward-strip">
                <div class="reward-icon-box">
                    <i class="fas fa-gift"></i>
                </div>
                <div class="reward-text">
                    <span class="label">{{ __('fan.dashboard.xp.reward_label') }}</span>
                    <span class="value">{{ $nextLevel->level_number * 10 }} {{ __('fan.dashboard.xp.tokens_bonus') }}</span>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.fan-xp-premium-panel {
    background: rgba(20, 20, 25, 0.7);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 28px;
    padding: 2rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0,0,0,0.4);
}

.fan-xp-premium-panel::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 150px;
    height: 150px;
    background: radial-gradient(circle, rgba(212, 175, 55, 0.05) 0%, transparent 70%);
    pointer-events: none;
}

.xp-panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.panel-title-premium {
    font-family: 'Poppins', sans-serif;
    font-size: 1.15rem;
    font-weight: 700;
    color: #dab843;
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 0;
}

.panel-title-premium i {
    color: var(--accent-gold);
    text-shadow: 0 0 10px rgba(212, 175, 55, 0.5);
}

.liga-badge {
    background: rgba(212, 175, 55, 0.1);
    color: var(--accent-gold);
    padding: 6px 14px;
    border-radius: 10px;
    font-size: 0.75rem;
    font-weight: 800;
    letter-spacing: 1px;
    border: 1px solid rgba(212, 175, 55, 0.2);
}

.level-visual-area {
    display: flex;
    align-items: center;
    gap: 2rem;
    margin-bottom: 2rem;
}

.liga-icon-container {
    position: relative;
    width: 100px;
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon-glow {
    position: absolute;
    width: 80%;
    height: 80%;
    background: var(--accent-gold);
    filter: blur(30px);
    opacity: 0.15;
    animation: icon-pulse 3s infinite alternate;
}

@keyframes icon-pulse {
    from { transform: scale(0.9); opacity: 0.1; }
    to { transform: scale(1.2); opacity: 0.2; }
}

.liga-floating-img {
    width: 85px;
    height: 85px;
    object-fit: contain;
    z-index: 2;
    animation: floating-anim 4s ease-in-out infinite;
}

@keyframes floating-anim {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.level-orb {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 36px;
    height: 36px;
    background: var(--gradient-gold);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #000;
    font-weight: 800;
    font-size: 1rem;
    border: 3px solid #141419;
    box-shadow: 0 4px 10px rgba(0,0,0,0.5);
    z-index: 3;
}

.level-text-info {
    flex: 1;
}

.xp-count-label {
    margin-bottom: 6px;
}

.current-xp {
    font-size: 1.85rem;
    font-weight: 800;
    color: #fff;
}

.target-xp {
    font-size: 1.1rem;
    opacity: 0.4;
    font-weight: 600;
}

.xp-needed {
    font-size: 0.9rem;
    color: rgba(255,255,255,0.6);
    margin: 0;
}

.xp-needed strong {
    color: var(--accent-gold);
}

.max-level-text {
    font-size: 1.5rem;
    font-weight: 900;
    background: var(--gradient-gold);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 5px;
}

.xp-progress-container {
    margin-bottom: 2rem;
}

.premium-progress-track {
    height: 22px;
    background: rgba(255,255,255,0.05);
    border-radius: 12px;
    position: relative;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.5);
    overflow: hidden;
}

.premium-progress-fill {
    height: 100%;
    background: var(--gradient-gold);
    border-radius: 12px;
    position: relative;
    box-shadow: 0 0 15px rgba(212, 175, 55, 0.4);
    transition: width 1.5s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.progress-percentage-label {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 0.7rem;
    font-weight: 800;
    color: #fff;
    text-shadow: 0 1px 3px rgba(0,0,0,0.5);
    z-index: 2;
}

.premium-reward-strip {
    background: rgba(255, 255, 255, 0.03);
    border-radius: 16px;
    padding: 1rem;
    display: flex;
    align-items: center;
    gap: 15px;
    border: 1px solid rgba(255,255,255,0.05);
}

.reward-icon-box {
    width: 40px;
    height: 40px;
    background: rgba(212, 175, 55, 0.1);
    color: var(--accent-gold);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-size: 1.1rem;
}

.reward-text {
    display: flex;
    flex-direction: column;
}

.reward-text .label {
    font-size: 0.75rem;
    opacity: 0.5;
}

.reward-text .value {
    font-size: 0.95rem;
    font-weight: 700;
    color: #fff;
}

@media (max-width: 768px) {
    .fan-xp-premium-panel {
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    }

    .xp-panel-header {
        margin-bottom: 1.5rem;
    }

    .panel-title-premium {
        font-size: 1rem;
    }

    .xp-progress-container {
        margin-bottom: 1.5rem;
    }

    .premium-reward-strip {
        border-radius: 12px;
        padding: 0.75rem;
    }
}

@media (max-width: 600px) {
    .fan-xp-premium-panel {
        padding: 1.25rem;
        border-radius: 16px;
    }
    
    .xp-panel-header {
        margin-bottom: 1.25rem;
    }

    .panel-title-premium {
        font-size: 0.95rem;
        gap: 8px;
    }
    
    .level-visual-area {
        flex-direction: row; 
        align-items: center;
        gap: 1rem;
        text-align: left;
        margin-bottom: 1.25rem;
    }
    
    .liga-icon-container {
        width: 70px;
        height: 70px;
    }
    
    .liga-floating-img {
        width: 58px;
        height: 58px;
    }
    
    .level-orb {
        width: 28px;
        height: 28px;
        font-size: 0.8rem;
    }

    .xp-count-label {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .current-xp { 
        font-size: 1.3rem; 
        line-height: 1.1;
    }
    
    .target-xp {
        font-size: 0.8rem;
    }
    
    .xp-needed {
        font-size: 0.78rem;
    }

    .xp-progress-container {
        margin-bottom: 1.25rem;
    }

    .premium-reward-strip {
        border-radius: 10px;
        padding: 0.65rem;
        gap: 10px;
    }

    .reward-icon-box {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        font-size: 0.95rem;
    }

    .reward-text .label {
        font-size: 0.7rem;
    }

    .reward-text .value {
        font-size: 0.85rem;
    }
}
</style>
