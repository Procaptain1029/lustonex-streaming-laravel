@props([
    'stats' => []
])

<div class="fan-stats-grid-premium">
    
    <div class="stat-card-premium tokens">
        <div class="card-bg-icon"><i class="fas fa-coins"></i></div>
        <div class="stat-header">
            <div class="stat-icon-box tokens">
                <i class="fas fa-coins"></i>
            </div>
            <a href="{{ route('fan.tokens.recharge') }}" class="mini-action-btn">
                <i class="fas fa-plus"></i>
            </a>
        </div>
        <div class="stat-info">
            <h4 class="stat-value-premium">{{ number_format($stats['tokens'] ?? 0) }}</h4>
            <p class="stat-label-premium">{{ __('fan.dashboard.stats.tokens') }}</p>
        </div>
    </div>

    
    <div class="stat-card-premium subs">
        <div class="card-bg-icon"><i class="fas fa-crown"></i></div>
        <div class="stat-header">
            <div class="stat-icon-box subs">
                <i class="fas fa-crown"></i>
            </div>
            <a href="{{ route('fan.subscriptions.index') }}" class="mini-action-btn">
                <i class="fas fa-cog"></i>
            </a>
        </div>
        <div class="stat-info">
            <h4 class="stat-value-premium">{{ $stats['subscriptions_count'] ?? 0 }}</h4>
            <p class="stat-label-premium">{{ __('fan.dashboard.stats.subscriptions') }}</p>
        </div>
    </div>

    
    <div class="stat-card-premium tips">
        <div class="card-bg-icon"><i class="fas fa-gift"></i></div>
        <div class="stat-header">
            <div class="stat-icon-box tips">
                <i class="fas fa-gift"></i>
            </div>
            @if(($stats['tips_this_week'] ?? 0) > 0)
                <span class="stat-trend positive">+{{ $stats['tips_this_week'] }}</span>
            @endif
        </div>
        <div class="stat-info">
            <h4 class="stat-value-premium">{{ number_format($stats['tips_sent'] ?? 0) }}</h4>
            <p class="stat-label-premium">{{ __('fan.dashboard.stats.tips') }}</p>
        </div>
    </div>

    
    <div class="stat-card-premium tickets">
        <div class="card-bg-icon"><i class="fas fa-ticket-alt"></i></div>
        <div class="stat-header">
            <div class="stat-icon-box tickets">
                <i class="fas fa-ticket-alt"></i>
            </div>
        </div>
        <div class="stat-info">
            <h4 class="stat-value-premium">{{ number_format($stats['tickets_balance'] ?? 0) }}</h4>
            <p class="stat-label-premium">{{ __('fan.dashboard.stats.tickets') }}</p>
        </div>
    </div>
</div>

<style>
.fan-stats-grid-premium {
    display: grid;
    /* Force 4 columns on desktop/tablet as requested */
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
}

.stat-card-premium {
    background: rgba(30, 30, 35, 0.6);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 24px;
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 160px;
}

.stat-card-premium:hover {
    transform: translateY(-8px);
    background: rgba(40, 40, 45, 0.8);
    border-color: rgba(212, 175, 55, 0.3);
    box-shadow: 0 15px 35px rgba(0,0,0,0.4);
}

.card-bg-icon {
    position: absolute;
    top: 50%;
    right: -10px;
    transform: translateY(-50%);
    font-size: 8rem;
    opacity: 0.03;
    z-index: 0;
    transition: all 0.4s ease;
}

.stat-card-premium:hover .card-bg-icon {
    transform: translateY(-50%) scale(1.1) rotate(-10deg);
    opacity: 0.05;
}

.stat-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    position: relative;
    z-index: 1;
}

.stat-icon-box {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.stat-icon-box.tokens { background: rgba(40, 167, 69, 0.15); color: #28a745; }
.stat-icon-box.subs { background: rgba(212, 175, 55, 0.15); color: var(--accent-gold); }
.stat-icon-box.tips { background: rgba(194, 24, 91, 0.15); color: #e91e63; }
.stat-icon-box.tickets { background: rgba(103, 58, 183, 0.15); color: #9c27b0; }

.mini-action-btn {
    width: 32px;
    height: 32px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 0.8rem;
    transition: all 0.3s ease;
    text-decoration: none;
}

.mini-action-btn:hover {
    background: var(--accent-gold);
    color: #000;
    border-color: var(--accent-gold);
}

.stat-info {
    position: relative;
    z-index: 1;
}

.stat-value-premium {
    font-family: 'Poppins', sans-serif;
    font-size: 2rem;
    font-weight: 800;
    color: #fff;
    margin: 0;
    line-height: 1;
}

.stat-label-premium {
    font-size: 0.85rem;
    color: rgba(255,255,255,0.5);
    margin: 8px 0 0 0;
    font-weight: 500;
}

.stat-trend {
    font-size: 0.7rem;
    font-weight: 800;
    padding: 3px 8px;
    border-radius: 6px;
}

.stat-trend.positive {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
}

@media (max-width: 768px) {
    .fan-stats-grid-premium {
        /* Force 2 columns on mobile */
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem; /* Tighter gap */
    }

    .stat-card-premium { 
        min-height: 120px; 
        padding: 1rem;
        border-radius: 18px;
    }

    .stat-header {
        margin-bottom: 0.5rem;
    }
    
    .stat-icon-box {
        width: 36px;
        height: 36px;
        font-size: 1rem;
        border-radius: 10px;
    }
    
    .mini-action-btn {
        width: 28px;
        height: 28px;
        font-size: 0.7rem;
    }

    .stat-value-premium { 
        font-size: 1.35rem; 
    }
    
    .stat-label-premium {
        font-size: 0.75rem;
        margin-top: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
}

@media (max-width: 480px) {
    .fan-stats-grid-premium {
        gap: 0.5rem;
    }

    .stat-card-premium {
        min-height: 100px;
        padding: 0.75rem;
        border-radius: 14px;
    }

    .stat-icon-box {
        width: 32px;
        height: 32px;
        font-size: 0.9rem;
        border-radius: 8px;
    }

    .stat-value-premium {
        font-size: 1.15rem;
    }

    .stat-label-premium {
        font-size: 0.7rem;
    }

    .card-bg-icon {
        font-size: 5rem;
    }
}
</style>
