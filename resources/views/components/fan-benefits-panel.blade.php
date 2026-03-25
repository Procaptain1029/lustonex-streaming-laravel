@props([
    'unlockedBenefits' => [],
    'nextBenefit' => null
])

<div class="fan-benefits-premium">
    <div class="benefits-premium-header">
        <h3 class="widget-title">
            <i class="fas fa-gem"></i> {{ __('components.fan_benefits.title') }}
        </h3>
        <p class="widget-subtitle">{{ __('components.fan_benefits.subtitle') }}</p>
    </div>
    
    <div class="benefits-premium-list">
        @forelse($unlockedBenefits as $benefit)
            <div class="benefit-card-mini unlocked">
                <div class="b-icon-wrap">
                    <i class="fas {{ $benefit['icon'] }}"></i>
                </div>
                <div class="b-info">
                    <p class="b-name">{{ $benefit['name'] }}</p>
                    <span class="b-status unlocked">{{ __('components.fan_benefits.active') }}</span>
                </div>
            </div>
        @empty
            <div class="b-empty-state">
                <p>{{ __('components.fan_benefits.empty') }}</p>
                <span>{{ __('components.fan_benefits.level_up') }}</span>
            </div>
        @endforelse
        
        @if($nextBenefit)
            <div class="benefit-card-mini locked">
                <div class="b-icon-wrap">
                    <i class="fas fa-lock"></i>
                </div>
                <div class="b-info">
                    <p class="b-name">{{ $nextBenefit['name'] }}</p>
                    <span class="b-status locked">{{ __('components.fan_benefits.level', ['number' => $nextBenefit['level']]) }}</span>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.fan-benefits-premium {
    background: rgba(30, 30, 35, 0.4);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 24px;
    padding: 1.5rem;
}

.benefits-premium-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.benefit-card-mini {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: rgba(255, 255, 255, 0.03);
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.05);
    transition: all 0.3s ease;
}

.benefit-card-mini:hover {
    background: rgba(255, 255, 255, 0.06);
    border-color: rgba(255, 255, 255, 0.1);
}

.b-icon-wrap {
    width: 36px;
    height: 36px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    color: rgba(255,255,255,0.6);
}

.benefit-card-mini.unlocked .b-icon-wrap {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
}

.b-info {
    flex: 1;
}

.b-name {
    font-size: 0.85rem;
    font-weight: 600;
    color: #fff;
    margin: 0;
}

.b-status {
    font-size: 0.65rem;
    font-weight: 800;
}

.b-status.unlocked { color: #28a745; }
.b-status.locked { color: rgba(255, 255, 255, 0.3); }

.benefit-card-mini.locked {
    opacity: 0.5;
    background: rgba(0, 0, 0, 0.2);
}

.b-empty-state {
    text-align: center;
    padding: 1.5rem;
    color: rgba(255,255,255,0.2);
}

.b-empty-state p { font-size: 0.85rem; margin-bottom: 2px; }
.b-empty-state span { font-size: 0.7rem; }

@media (max-width: 768px) {
    .fan-benefits-premium {
        padding: 1.25rem;
        border-radius: 18px;
    }

    .benefits-premium-header {
        margin-bottom: 1rem;
    }

    .benefits-premium-list {
        gap: 0.5rem;
    }

    .benefit-card-mini {
        gap: 10px;
        padding: 10px;
        border-radius: 12px;
    }

    .b-icon-wrap {
        width: 32px;
        height: 32px;
        font-size: 0.8rem;
        border-radius: 8px;
    }

    .b-name {
        font-size: 0.8rem;
    }

    .b-status {
        font-size: 0.6rem;
    }
}

@media (max-width: 480px) {
    .fan-benefits-premium {
        padding: 1rem;
        border-radius: 14px;
    }

    .benefit-card-mini {
        gap: 8px;
        padding: 8px;
        border-radius: 10px;
    }

    .b-icon-wrap {
        width: 28px;
        height: 28px;
        font-size: 0.75rem;
    }

    .b-name {
        font-size: 0.75rem;
    }

    .b-empty-state {
        padding: 1rem;
    }
}
</style>
