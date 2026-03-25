
@props([
    'gamificationStats' => [],
    'generalStats' => []
])

<div class="fan-profile-stats">
    
    <div class="stats-section">
        <h3 class="stats-section-title">
            <i class="fas fa-gamepad"></i> {{ __('fan.profile.stats.gamification_title') }}
        </h3>
        <div class="stats-grid">
            <div class="stat-card primary">
                <div class="stat-icon"><i class="fas fa-star"></i></div>
                <div class="stat-content">
                    <span class="stat-value">{{ number_format($gamificationStats['total_xp'] ?? 0) }}</span>
                    <span class="stat-label">{{ __('fan.profile.stats.total_xp') }}</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-level-up-alt"></i></div>
                <div class="stat-content">
                    <span class="stat-value">{{ $gamificationStats['level'] ?? 0 }}</span>
                    <span class="stat-label">{{ __('fan.profile.stats.current_level') }}</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-trophy"></i></div>
                <div class="stat-content">
                    <span class="stat-value">{{ $gamificationStats['liga'] ?? 'Gris' }}</span>
                    <span class="stat-label">{{ __('fan.profile.stats.league') }}</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-ticket-alt"></i></div>
                <div class="stat-content">
                    <span class="stat-value">{{ number_format($gamificationStats['tickets_balance'] ?? 0) }}</span>
                    <span class="stat-label">{{ __('fan.profile.stats.raffle_tickets') }}</span>
                </div>
            </div>
        </div>
        
        
        <div class="xp-breakdown">
            <h4 class="breakdown-title">{{ __('fan.profile.stats.xp_breakdown') }}</h4>
            <div class="breakdown-items">
                <div class="breakdown-item">
                    <span class="breakdown-label"><i class="fas fa-coins"></i> {{ __('fan.profile.stats.from_tokens') }}</span>
                    <span class="breakdown-value">{{ number_format($gamificationStats['xp_from_tokens'] ?? 0) }} XP</span>
                </div>
                <div class="breakdown-item">
                    <span class="breakdown-label"><i class="fas fa-heart"></i> {{ __('fan.profile.stats.from_tips') }}</span>
                    <span class="breakdown-value">{{ number_format($gamificationStats['xp_from_tips'] ?? 0) }} XP</span>
                </div>
                <div class="breakdown-item">
                    <span class="breakdown-label"><i class="fas fa-crown"></i> {{ __('fan.profile.stats.from_subscriptions') }}</span>
                    <span class="breakdown-value">{{ number_format($gamificationStats['xp_from_subscriptions'] ?? 0) }} XP</span>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="stats-section">
        <h3 class="stats-section-title">
            <i class="fas fa-chart-bar"></i> {{ __('fan.profile.stats.general_title') }}
        </h3>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-coins"></i></div>
                <div class="stat-content">
                    <span class="stat-value">{{ number_format($generalStats['tokens_balance'] ?? 0) }}</span>
                    <span class="stat-label">{{ __('fan.profile.stats.available_tokens') }}</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-paper-plane"></i></div>
                <div class="stat-content">
                    <span class="stat-value">{{ number_format($generalStats['total_tips_sent'] ?? 0) }}</span>
                    <span class="stat-label">{{ __('fan.profile.stats.tips_sent') }}</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-fire"></i></div>
                <div class="stat-content">
                    <span class="stat-value">{{ number_format($generalStats['total_tokens_spent'] ?? 0) }}</span>
                    <span class="stat-label">{{ __('fan.profile.stats.tokens_spent') }}</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-crown"></i></div>
                <div class="stat-content">
                    <span class="stat-value">{{ $generalStats['active_subscriptions'] ?? 0 }}</span>
                    <span class="stat-label">{{ __('fan.profile.stats.active_subscriptions') }}</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                <div class="stat-content">
                    <span class="stat-value">{{ $generalStats['member_since'] ?? __('fan.tokens.date_not_available') }}</span>
                    <span class="stat-label">{{ __('fan.profile.stats.member_since') }}</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                <div class="stat-content">
                    <span class="stat-value">{{ $generalStats['days_active'] ?? 0 }}</span>
                    <span class="stat-label">{{ __('fan.profile.stats.days_active') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.fan-profile-stats {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.stats-section {
    background: rgba(31, 31, 35, 0.95);
    border: 1px solid rgba(212, 175, 55, 0.2);
    border-radius: 16px;
    padding: 1.5rem;
}

.stats-section-title {
    font-family: var(--font-titles);
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--color-oro-sensual);
    margin: 0 0 1.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
}

.stat-card:hover {
    background: rgba(212, 175, 55, 0.1);
    border-color: rgba(212, 175, 55, 0.3);
    transform: translateY(-2px);
}

.stat-card.primary {
    background: linear-gradient(135deg, rgba(212, 175, 55, 0.2), rgba(244, 227, 125, 0.2));
    border-color: var(--color-oro-sensual);
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: var(--gradient-gold);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: #000;
    flex-shrink: 0;
}

.stat-content {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.stat-value {
    font-family: var(--font-titles);
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
}

.stat-label {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.7);
}

.xp-breakdown {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(212, 175, 55, 0.2);
}

.breakdown-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--color-oro-sensual);
    margin: 0 0 1rem 0;
}

.breakdown-items {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.breakdown-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    background: rgba(255, 255, 255, 0.03);
    border-radius: 8px;
}

.breakdown-label {
    font-size: 0.95rem;
    color: rgba(255, 255, 255, 0.8);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.breakdown-value {
    font-weight: 700;
    color: var(--color-oro-sensual);
}

/* Responsive */
@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>
