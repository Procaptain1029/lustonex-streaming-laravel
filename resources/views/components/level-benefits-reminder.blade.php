
@props([
    'currentLevel' => 0,
    'benefit' => null,
    'type' => 'info' // 'info', 'success', 'warning'
])

@if($benefit)
<div class="level-benefits-reminder {{ $type }}">
    <div class="benefit-icon-wrapper">
        @if($currentLevel >= ($benefit['required_level'] ?? 0))
            <i class="fas fa-check-circle"></i>
        @else
            <i class="fas fa-lock"></i>
        @endif
    </div>
    <div class="benefit-text">
        @if($currentLevel >= ($benefit['required_level'] ?? 0))
            <strong>{{ __('components.level_reminder.active') }}</strong> {{ $benefit['description'] }}
        @else
            <strong>{{ __('components.level_reminder.next', ['level' => $benefit['required_level']]) }}</strong> {{ $benefit['description'] }}
        @endif
    </div>
</div>
@endif

<style>
.level-benefits-reminder {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    border-radius: 10px;
    border-left: 3px solid;
    margin-bottom: 1rem;
}

.level-benefits-reminder.info {
    background: rgba(23, 162, 184, 0.1);
    border-color: #17a2b8;
}

.level-benefits-reminder.success {
    background: rgba(40, 167, 69, 0.1);
    border-color: #28a745;
}

.level-benefits-reminder.warning {
    background: rgba(255, 193, 7, 0.1);
    border-color: #ffc107;
}

.benefit-icon-wrapper {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}

.level-benefits-reminder.info .benefit-icon-wrapper {
    background: rgba(23, 162, 184, 0.2);
    color: #17a2b8;
}

.level-benefits-reminder.success .benefit-icon-wrapper {
    background: rgba(40, 167, 69, 0.2);
    color: #28a745;
}

.level-benefits-reminder.warning .benefit-icon-wrapper {
    background: rgba(255, 193, 7, 0.2);
    color: #ffc107;
}

.benefit-text {
    flex: 1;
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.9);
    line-height: 1.4;
}

.benefit-text strong {
    color: white;
}
</style>
