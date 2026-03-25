@props(['topModels', 'userRank'])

<div class="model-ranking-preview">
    <div class="section-header">
        <h3><i class="fas fa-medal"></i> {{ __('components.model_ranking.title') }}</h3>
        <a href="{{ route('model.leaderboard.index') }}" class="view-all-btn">
            {{ __('components.model_ranking.view_all') }} <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    <div class="user-rank-card">
        <div class="rank-position">
            <i class="fas fa-hashtag"></i>
            <span>{{ $userRank }}</span>
        </div>
        <div class="rank-info">
            <span class="rank-label">{{ __('components.model_ranking.your_position') }}</span>
            <span class="rank-encouragement">
                @if($userRank <= 10)
                    {{ __('components.model_ranking.top_10') }}
                @elseif($userRank <= 50)
                    {{ __('components.model_ranking.top_50') }}
                @else
                    {{ __('components.model_ranking.keep_going') }}
                @endif
            </span>
        </div>
    </div>

    

    <div class="ranking-list">
        @if($topModels->count() > 0)
            @foreach($topModels as $index => $model)
                <div class="rank-item {{ $model->id === auth()->id() ? 'is-current-user' : '' }}">
                    <div class="rank-number">
                        @if($index === 0)
                            <i class="fas fa-trophy" style="color: #FFD700;"></i>
                        @elseif($index === 1)
                            <i class="fas fa-trophy" style="color: #C0C0C0;"></i>
                        @elseif($index === 2)
                            <i class="fas fa-trophy" style="color: #CD7F32;"></i>
                        @else
                            #{{ $index + 1 }}
                        @endif
                    </div>
                    <div class="rank-avatar">
                        <img src="{{ $model->profile->avatar_url ?? '/images/default-avatar.png' }}" alt="{{ $model->name }}">
                    </div>
                    <div class="rank-details">
                        <span class="rank-name">
                            {{ $model->name }}
                            @if($model->id === auth()->id())
                                <span class="you-badge">{{ __('components.model_ranking.you_badge') }}</span>
                            @endif
                        </span>
                    </div>
                    <div class="rank-xp">
                        {{ number_format($model->erank ?? 0, 0) }}
                    </div>
                </div>
            @endforeach
        @else
            <div style="text-align: center; padding: 2rem; color: rgba(255,255,255,0.5);">
                <i class="fas fa-trophy" style="font-size: 2rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                <p>{{ __('components.model_ranking.empty') }}</p>
            </div>
        @endif
    </div>
</div>

<style>
    .model-ranking-preview {
        background: rgba(31, 31, 35, 0.95);
        border: 1px solid rgba(212, 175, 55, 0.2);
        border-radius: 16px;
        padding: 1.5rem;
    }

    .user-rank-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.2), rgba(244, 227, 125, 0.1));
        border: 1px solid rgba(212, 175, 55, 0.3);
        border-radius: 12px;
        margin-bottom: 1.5rem;
    }

    .rank-position {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--gradient-gold);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 700;
        color: #000;
    }

    .rank-info {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .rank-label {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.7);
    }

    .rank-encouragement {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--color-oro-sensual);
    }

    .ranking-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .rank-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem;
        background: rgba(11, 11, 13, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .rank-item:hover {
        border-color: rgba(212, 175, 55, 0.3);
        transform: translateX(3px);
    }

    .rank-item.is-current-user {
        background: rgba(212, 175, 55, 0.15);
        border-color: rgba(212, 175, 55, 0.4);
    }

    .rank-number {
        width: 40px;
        text-align: center;
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--color-oro-sensual);
    }

    .rank-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid rgba(212, 175, 55, 0.3);
    }

    .rank-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .rank-details {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .rank-name {
        font-weight: 600;
        color: white;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .you-badge {
        padding: 0.125rem 0.5rem;
        background: var(--gradient-gold);
        color: #000;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 700;
    }

    .rank-level {
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.6);
    }

    .rank-xp {
        font-weight: 700;
        color: var(--color-oro-sensual);
        font-size: 0.95rem;
    }

    @media (max-width: 768px) {
        .rank-item {
            gap: 0.5rem;
            padding: 0.5rem;
        }

        .rank-number {
            width: 30px;
            font-size: 0.9rem;
        }

        .rank-avatar {
            width: 35px;
            height: 35px;
        }

        .rank-xp {
            font-size: 0.85rem;
        }
    }
</style>