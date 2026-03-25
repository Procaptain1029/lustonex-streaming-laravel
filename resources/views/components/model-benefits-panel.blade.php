@props(['benefits', 'nextBenefit'])

<div class="model-benefits-panel">
    <div class="section-header">
        <h3><i class="fas fa-unlock-alt"></i> {{ __('components.model_benefits.title') }}</h3>
    </div>
    
    <div class="benefits-grid">
        @forelse($benefits as $benefit)
        <div class="benefit-card unlocked">
            <div class="benefit-icon">
                <i class="fas {{ $benefit['icon'] }}"></i>
            </div>
            <div class="benefit-content">
                <h4 class="benefit-name">{{ $benefit['name'] }}</h4>
                <p class="benefit-description">{{ $benefit['description'] }}</p>
                <span class="benefit-level">{{ __('components.model_benefits.level', ['number' => $benefit['level']]) }}</span>
            </div>
            <div class="benefit-status">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <i class="fas fa-lock fa-2x"></i>
            <p>{{ __('components.model_benefits.empty') }}</p>
        </div>
        @endforelse
        
        @if($nextBenefit)
        <div class="benefit-card locked">
            <div class="benefit-icon">
                <i class="fas {{ $nextBenefit['icon'] }}"></i>
            </div>
            <div class="benefit-content">
                <h4 class="benefit-name">{{ $nextBenefit['name'] }}</h4>
                <p class="benefit-description">{{ $nextBenefit['description'] }}</p>
                <span class="benefit-level">{{ __('components.model_benefits.requires_level', ['number' => $nextBenefit['level']]) }}</span>
            </div>
            <div class="benefit-status">
                <i class="fas fa-lock"></i>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
.model-benefits-panel {
    background: rgba(31, 31, 35, 0.95);
    border: 1px solid rgba(212, 175, 55, 0.2);
    border-radius: 16px;
    padding: 1.5rem;
}

.benefits-grid {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.benefit-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.benefit-card.unlocked {
    background: rgba(40, 167, 69, 0.1);
    border: 1px solid rgba(40, 167, 69, 0.3);
}

.benefit-card.locked {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.1);
    opacity: 0.6;
}

.benefit-card:hover {
    transform: translateX(3px);
}

.benefit-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.benefit-card.unlocked .benefit-icon {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.benefit-card.locked .benefit-icon {
    background: rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.5);
}

.benefit-content {
    flex: 1;
}

.benefit-name {
    font-size: 1rem;
    font-weight: 700;
    color: white;
    margin: 0 0 0.25rem 0;
}

.benefit-description {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.7);
    margin: 0 0 0.5rem 0;
}

.benefit-level {
    font-size: 0.8rem;
    padding: 0.25rem 0.75rem;
    background: rgba(212, 175, 55, 0.2);
    border-radius: 12px;
    color: var(--color-oro-sensual);
    display: inline-block;
}

.benefit-status {
    font-size: 1.5rem;
}

.benefit-card.unlocked .benefit-status {
    color: #28a745;
}

.benefit-card.locked .benefit-status {
    color: rgba(255, 255, 255, 0.3);
}

.empty-state {
    text-align: center;
    padding: 2rem;
    color: rgba(255, 255, 255, 0.5);
}

.empty-state i {
    margin-bottom: 1rem;
    opacity: 0.5;
}

@media (max-width: 768px) {
    .benefit-card {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .benefit-status {
        align-self: flex-end;
    }
}
</style>
