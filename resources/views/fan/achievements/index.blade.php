@extends('layouts.fan')

@section('title', __('fan.achievements.title'))


@section('content')
<style>
.achievements-container {
    padding: 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

.page-header {
    margin-bottom: 2rem;
}

/* Estilos de encabezado heredados del layout public */

.stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: rgba(31, 31, 35, 0.95);
    border: 1px solid rgba(212, 175, 55, 0.2);
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: var(--gradient-gold);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #000;
}

.stat-content {
    display: flex;
    flex-direction: column;
}

.stat-value {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--color-oro-sensual);
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.8;
}

.achievements-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
}

.achievement-card {
    background: rgba(31, 31, 35, 0.95);
    border: 2px solid rgba(212, 175, 55, 0.2);
    border-radius: 16px;
    padding: 1.5rem;
    position: relative;
    transition: all 0.3s ease;
}

.achievement-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
}

.achievement-card.locked {
    opacity: 0.6;
    filter: grayscale(50%);
}

.achievement-card.unlocked {
    border-color: var(--color-oro-sensual);
}

.achievement-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: var(--gradient-gold);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #000;
    margin: 0 auto 1rem;
}

.achievement-content {
    text-align: center;
}

.achievement-name {
    font-family: var(--font-titles);
    font-size: 1.2rem;
    font-weight: 700;
    color: white;
    margin: 0 0 0.5rem 0;
}

.achievement-description {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.7);
    margin: 0 0 1rem 0;
}

.achievement-progress {
    margin-top: 1rem;
}

.progress-bar-small {
    height: 8px;
    background: rgba(0, 0, 0, 0.3);
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.progress-fill-small {
    height: 100%;
    background: var(--gradient-gold);
    transition: width 0.5s ease;
}

.progress-text-small {
    font-size: 0.85rem;
    color: var(--color-oro-sensual);
    font-weight: 600;
}

.achievement-unlocked-badge {
    color: #28a745;
    font-weight: 600;
    font-size: 0.9rem;
}

.rarity-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
}

.rarity-badge.rarity-common {
    background: #6c757d;
    color: white;
}

.rarity-badge.rarity-rare {
    background: #007bff;
    color: white;
}

.rarity-badge.rarity-epic {
    background: #6f42c1;
    color: white;
}

.rarity-badge.rarity-legendary {
    background: linear-gradient(135deg, var(--color-oro-sensual), #f4e37d);
    color: #000;
}

@media (max-width: 768px) {
    .achievements-container {
        padding: 1rem;
    }
    
    /* Estilos responsivos de encabezado heredados */
    .achievements-grid {
        grid-template-columns: 1fr;
    }
}
</style>
<div class="achievements-container">
    
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-trophy"></i> {{ __('fan.achievements.title') }}
        </h1>
        <p class="page-subtitle">{{ __('fan.achievements.subtitle') }}</p>
    </div>

    
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-trophy"></i></div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['unlocked'] }}/{{ $stats['total'] }}</span>
                <span class="stat-label">{{ __('fan.achievements.unlocked_label') }}</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-percent"></i></div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['completion_percentage'] }}%</span>
                <span class="stat-label">{{ __('fan.achievements.completed_label') }}</span>
            </div>
        </div>
    </div>

    
    <div class="achievements-grid">
        @foreach($achievements as $achievement)
        <div class="achievement-card {{ $achievement['unlocked'] ? 'unlocked' : 'locked' }} rarity-{{ $achievement['rarity'] }}">
            <div class="achievement-icon">
                <i class="fas {{ $achievement['icon'] }}"></i>
            </div>
            <div class="achievement-content">
                <h4 class="achievement-name">{{ $achievement['name'] }}</h4>
                <p class="achievement-description">{{ $achievement['description'] }}</p>
                @if(!$achievement['unlocked'])
                <div class="achievement-progress">
                    <div class="progress-bar-small">
                        <div class="progress-fill-small" style="width: {{ ($achievement['progress'] / $achievement['target']) * 100 }}%"></div>
                    </div>
                    <span class="progress-text-small">{{ $achievement['progress'] }}/{{ $achievement['target'] }}</span>
                </div>
                @else
                <div class="achievement-unlocked-badge">
                    <i class="fas fa-check-circle"></i> {{ __('fan.achievements.unlocked_status') }}
                </div>
                @endif
            </div>
            <div class="rarity-badge rarity-{{ $achievement['rarity'] }}">
                {{ __('fan.achievements.rarity.' . $achievement['rarity']) }}
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
