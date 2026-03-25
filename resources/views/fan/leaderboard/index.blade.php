@extends('layouts.fan')

@section('title', __('fan.leaderboard.title'))



@section('content')
<style>
.leaderboard-container {
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.page-header {
    margin-bottom: 2rem;
}

/* Estilos de encabezado heredados del layout fan */

.stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: rgba(31, 31, 35, 0.95);
    border: 1px solid rgba(212, 175, 55, 0.2);
    border-radius: 12px;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stat-card.highlight {
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
}

.stat-content {
    display: flex;
    flex-direction: column;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--color-oro-sensual);
}

.stat-label {
    font-size: 0.85rem;
    opacity: 0.8;
}

.leaderboard-table {
    background: rgba(31, 31, 35, 0.95);
    border: 1px solid rgba(212, 175, 55, 0.2);
    border-radius: 16px;
    overflow: hidden;
}

.table-header {
    display: grid;
    grid-template-columns: 80px 1fr 100px 150px 120px;
    gap: 1rem;
    padding: 1rem 1.5rem;
    background: rgba(212, 175, 55, 0.1);
    font-weight: 700;
    color: var(--color-oro-sensual);
    border-bottom: 1px solid rgba(212, 175, 55, 0.2);
}

.table-row {
    display: grid;
    grid-template-columns: 80px 1fr 100px 150px 120px;
    gap: 1rem;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    transition: all 0.3s ease;
    align-items: center;
}

.table-row:hover {
    background: rgba(212, 175, 55, 0.05);
}

.table-row.current-user {
    background: rgba(212, 175, 55, 0.15);
    border-left: 3px solid var(--color-oro-sensual);
}

.table-row.top-1 {
    background: linear-gradient(90deg, rgba(255, 215, 0, 0.1), transparent);
}

.table-row.top-2 {
    background: linear-gradient(90deg, rgba(192, 192, 192, 0.1), transparent);
}

.table-row.top-3 {
    background: linear-gradient(90deg, rgba(205, 127, 50, 0.1), transparent);
}

.col-rank {
    font-weight: 700;
    font-size: 1.1rem;
}

.col-name {
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.you-badge {
    padding: 0.25rem 0.5rem;
    background: var(--gradient-gold);
    color: #000;
    border-radius: 4px;
    font-size: 0.7rem;
    font-weight: 700;
}

.col-level, .col-liga, .col-xp {
    color: rgba(255, 255, 255, 0.8);
}

@media (max-width: 768px) {
    .leaderboard-container {
        padding: 1rem;
    }

    .leaderboard-container {
        padding: 1rem;
    }

    /* Estilos responsivos de encabezado heredados */
    
    .table-header, .table-row {
        grid-template-columns: 60px 1fr 80px;
        font-size: 0.9rem;
    }
    
    .col-liga, .col-xp {
        display: none;
    }
}

@media (max-width: 480px) {
    /* Estilos responsivos heredados */
}
</style>
<div class="leaderboard-container">
    
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-medal"></i> {{ __('fan.leaderboard.title') }}
        </h1>
        <p class="page-subtitle">{{ __('fan.leaderboard.subtitle') }}</p>
    </div>

    
    <div class="stats-row">
        <div class="stat-card highlight">
            <div class="stat-icon"><i class="fas fa-hashtag"></i></div>
            <div class="stat-content">
                <span class="stat-value">#{{ $stats['your_rank'] }}</span>
                <span class="stat-label">{{ __('fan.leaderboard.your_rank') }}</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-star"></i></div>
            <div class="stat-content">
                <span class="stat-value">{{ number_format($stats['your_xp']) }}</span>
                <span class="stat-label">{{ __('fan.leaderboard.your_xp') }}</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-content">
                <span class="stat-value">{{ number_format($stats['total_fans']) }}</span>
                <span class="stat-label">{{ __('fan.leaderboard.total_fans') }}</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
            <div class="stat-content">
                <span class="stat-value">Top {{ $stats['top_percentage'] }}%</span>
                <span class="stat-label">{{ __('fan.leaderboard.percentile') }}</span>
            </div>
        </div>
    </div>

    
    <div class="leaderboard-table">
        <div class="table-header">
            <span class="col-rank">{{ __('fan.leaderboard.table.rank') }}</span>
            <span class="col-name">{{ __('fan.leaderboard.table.fan') }}</span>
            <span class="col-level">{{ __('fan.leaderboard.table.level') }}</span>
            <span class="col-liga">{{ __('fan.leaderboard.table.liga') }}</span>
            <span class="col-xp">{{ __('fan.leaderboard.table.xp') }}</span>
        </div>
        @foreach($topFans as $fan)
        <div class="table-row {{ $fan['is_current_user'] ? 'current-user' : '' }} {{ $fan['rank'] <= 3 ? 'top-' . $fan['rank'] : '' }}">
            <span class="col-rank">
                @if($fan['rank'] == 1)
                    <i class="fas fa-trophy" style="color: #FFD700;"></i>
                @elseif($fan['rank'] == 2)
                    <i class="fas fa-trophy" style="color: #C0C0C0;"></i>
                @elseif($fan['rank'] == 3)
                    <i class="fas fa-trophy" style="color: #CD7F32;"></i>
                @else
                    #{{ $fan['rank'] }}
                @endif
            </span>
            <span class="col-name">
                {{ $fan['name'] }}
                @if($fan['is_current_user'])
                    <span class="you-badge">{{ __('fan.leaderboard.table.you') }}</span>
                @endif
            </span>
            <span class="col-level">{{ $fan['level'] }}</span>
            <span class="col-liga">{{ $fan['liga'] }}</span>
            <span class="col-xp">{{ number_format($fan['xp']) }}</span>
        </div>
        @endforeach
    </div>
</div>
@endsection
