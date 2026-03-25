
@props([
    'xpAmount' => 0,
    'action' => 'acción'
])

@if($xpAmount > 0)
<div class="xp-reward-badge">
    <div class="xp-icon">
        <i class="fas fa-star"></i>
    </div>
    <div class="xp-content">
        <span class="xp-value">+{{ number_format($xpAmount) }} XP</span>
        <small class="xp-action">por {{ $action }}</small>
    </div>
</div>
@endif

<style>
.xp-reward-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    background: linear-gradient(135deg, rgba(212, 175, 55, 0.2), rgba(244, 227, 125, 0.2));
    border: 1px solid rgba(212, 175, 55, 0.4);
    border-radius: 20px;
    animation: xpBadgeAppear 0.5s ease-out;
}

@keyframes xpBadgeAppear {
    from {
        opacity: 0;
        transform: scale(0.8) translateY(-10px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

.xp-icon {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: var(--gradient-gold);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #000;
    font-size: 0.75rem;
    animation: xpIconPulse 2s infinite;
}

@keyframes xpIconPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.xp-content {
    display: flex;
    flex-direction: column;
    gap: 0.1rem;
}

.xp-value {
    font-weight: 700;
    color: var(--color-oro-sensual);
    font-size: 0.9rem;
}

.xp-action {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.7);
}
</style>
