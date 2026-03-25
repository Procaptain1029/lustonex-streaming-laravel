@props(['missions'])

<div class="model-missions-preview">
    <div class="section-header">
        <h3> {{ __('components.model_missions.title') }}</h3>
        <a href="{{ route('model.missions.index') }}" class="btn-ver-todas btn-mobile-hide">
            {{ __('components.model_missions.view_all') }} <i class="fas fa-arrow-right"></i>
        </a>
    </div>
    
    <div class="missions-grid">
        @forelse($missions as $mission)
        <div class="mission-card">
            <div class="mission-icon">
                <i class="fas {{ $mission['icon'] ?? 'fa-star' }}"></i>
            </div>
            <div class="mission-content">
                <h4 class="mission-title">{{ $mission['title'] }}</h4>
                <p class="mission-description">{{ $mission['description'] }}</p>
                
                <div class="mission-progress">
                    <div class="progress-bar-mini">
                        <div class="progress-fill-mini" style="width: {{ ($mission['current'] / $mission['target']) * 100 }}%"></div>
                    </div>
                    <span class="progress-text">{{ $mission['current'] }}/{{ $mission['target'] }}</span>
                </div>
                
                <div class="mission-rewards">
                    <span class="reward-item">
                        <i class="fas fa-star"></i> +{{ $mission['xp_reward'] }} XP
                    </span>
                    @if($mission['ticket_reward'] > 0)
                    <span class="reward-item">
                        <i class="fas fa-ticket-alt"></i> +{{ $mission['ticket_reward'] }} {{ __('components.model_missions.tickets') }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <i class="fas fa-clipboard-list fa-3x"></i>
            <p>{{ __('components.model_missions.empty') }}</p>
        </div>
        @endforelse
    </div>
</div>

<style>
.model-missions-preview {
    background: rgba(31, 31, 35, 0.95);
    border: 1px solid rgba(212, 175, 55, 0.2);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.section-header h3 {
    font-family: var(--font-titles);
    font-size: 1.3rem;
    color: var(--color-oro-sensual);
    margin: 0;
}

        .btn-ver-todas {
            background: none;
            border: none;
            padding: 0;
            color:  #fbd304;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-decoration: none;
            text-transform: uppercase;
            transition: color 0.3s ease, text-shadow 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-ver-todas:hover {
            color: var(--color-oro-sensual);
            text-shadow: 0 0 10px rgba(212, 175, 55, 0.8), 0 0 20px rgba(212, 175, 55, 0.4);
        }

.missions-grid {
    display: grid;
    gap: 1rem;
}

.mission-card {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: rgba(11, 11, 13, 0.5);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 12px;
    transition: all 0.3s ease;
}

.mission-card:hover {
    border-color: rgba(212, 175, 55, 0.3);
    transform: translateX(5px);
}

.mission-icon {
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

.mission-content {
    flex: 1;
}

.mission-title {
    font-size: 1rem;
    font-weight: 700;
    color: white;
    margin: 0 0 0.25rem 0;
}

.mission-description {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.7);
    margin: 0 0 0.75rem 0;
}

.mission-progress {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
}

.progress-bar-mini {
    flex: 1;
    height: 8px;
    background: rgba(0, 0, 0, 0.3);
    border-radius: 4px;
    overflow: hidden;
}

.progress-fill-mini {
    height: 100%;
    background: var(--gradient-gold);
    border-radius: 4px;
    transition: width 0.5s ease;
}

.progress-text {
    font-size: 0.85rem;
    color: var(--color-oro-sensual);
    font-weight: 600;
    white-space: nowrap;
}

.mission-rewards {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.reward-item {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.8);
}

.reward-item i {
    color: var(--color-oro-sensual);
}

.empty-state {
    text-align: center;
    padding: 3rem 2rem;
    color: rgba(255, 255, 255, 0.5);
}

.empty-state i {
    margin-bottom: 1rem;
    opacity: 0.5;
}

    @media (max-width: 769px) {
        .btn-mobile-hide {
            display: none !important;
        }

        .section-header h3 {
        font-size: 1.1rem;
    }

    .view-all-btn {
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
    }

    .mission-card {
        display: grid;
        grid-template-columns: 48px 1fr;
        gap: 4px 12px;
        padding: 1.25rem;
    }
    
    .mission-content {
        display: contents;
    }

    .mission-icon {
        grid-column: 1;
        grid-row: 1;
        width: 48px;
        height: 48px;
        font-size: 1.1rem;
    }

    .mission-title {
        grid-column: 2;
        grid-row: 1;
        align-self: center;
        font-size: 1rem;
        margin: 0;
        line-height: 1.3;
    }

    .mission-description {
        grid-column: 1 / -1;
        font-size: 0.85rem;
        margin: 12px 0 8px 0;
        color: rgba(255, 255, 255, 0.75);
    }
    
    .mission-progress {
        grid-column: 1 / -1;
        margin-bottom: 12px;
    }

    .mission-rewards {
        grid-column: 1 / -1;
        gap: 0.75rem;
    }

    .reward-item {
        background: rgba(255, 255, 255, 0.05);
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.75rem;
    }
}
</style>
