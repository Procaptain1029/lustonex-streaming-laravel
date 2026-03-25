@props([
    'favorites' => []
])

<div class="fan-favorites-premium">
    <div class="favorites-premium-header">
        <h3 class="widget-title">
            {{ __('fan.dashboard.favorites.title') }}
            @if(count($favorites) > 0)
                <span class="count-pill">{{ count($favorites) }}</span>
            @endif
        </h3>
        <a href="{{ route('home') }}" class="mini-explore-link">
            {{ __('fan.dashboard.favorites.explore_more') }} <i class="fas fa-chevron-right"></i>
        </a>
    </div>
    
    <div class="favorites-premium-grid">
        @forelse($favorites as $model)
            <div class="fav-card-premium">
                <div class="fav-card-visual">
                    <img src="{{ $model->profile->avatar_url ?? asset('avatar/default.jpg') }}" 
                         alt="{{ $model->name }}" 
                         class="fav-avatar">
                    
                    <div class="fav-status-overlay {{ $model->profile->is_streaming ? 'live' : 'offline' }}">
                        @if($model->profile->is_streaming)
                            <span class="live-dot"></span> {{ __('fan.dashboard.favorites.live') }}
                        @else
                            {{ __('fan.dashboard.favorites.offline') }}
                        @endif
                    </div>

                    <div class="fav-actions-overlay">
                        <a href="{{ route('profiles.show', $model->id) }}" class="btn-fav-view" title="{{ __('fan.dashboard.favorites.view_profile') }}">
                            <i class="fas fa-play"></i>
                        </a>
                    </div>
                </div>
                
                <div class="fav-card-info">
                    <h4 class="fav-name">{{ $model->profile->display_name ?? $model->name }}</h4>
                    <p class="fav-meta">
                        @if($model->profile->is_streaming)
                            <span class="streaming-text">{{ __('fan.dashboard.favorites.streaming_now') }}</span>
                        @else
                            {{ $model->profile->last_seen ?? __('fan.dashboard.favorites.offline_text') }}
                        @endif
                    </p>
                </div>
            </div>
        @empty
            <div class="fav-empty-premium">
                <div class="empty-glow"></div>
                <i class="fas fa-star-half-alt"></i>
                <p>{{ __('fan.dashboard.favorites.empty_list') }}</p>
                <a href="{{ route('home') }}" class="btn-gold-sm">{{ __('fan.dashboard.favorites.find_models') }}</a>
            </div>
        @endforelse
    </div>
</div>

<style>
.fan-favorites-premium {
    background: rgba(20, 20, 25, 0.4);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 28px;
    padding: 1.5rem;
}

.favorites-premium-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.widget-title {
    color: #d4af37 !important;
}

.count-pill {
    background: rgba(212, 175, 55, 0.1);
    color: var(--accent-gold);
    padding: 2px 8px;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 800;
    margin-left: 8px;
}

.mini-explore-link {
    font-size: 0.75rem;
    color: rgba(255,255,255,0.4);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.mini-explore-link:hover {
    color: var(--accent-gold);
}

.favorites-premium-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    gap: 1rem;
}

.fav-card-premium {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 20px;
    padding: 8px;
    transition: all 0.3s ease;
}

.fav-card-premium:hover {
    background: rgba(255, 255, 255, 0.06);
    transform: translateY(-5px);
    border-color: rgba(212, 175, 55, 0.2);
}

.fav-card-visual {
    position: relative;
    width: 100%;
    aspect-ratio: 1;
    border-radius: 16px;
    overflow: hidden;
}

.fav-avatar {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.fav-card-premium:hover .fav-avatar {
    transform: scale(1.1);
}

.fav-status-overlay {
    position: absolute;
    top: 8px;
    left: 8px;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 0.6rem;
    font-weight: 900;
    backdrop-filter: blur(4px);
}

.fav-status-overlay.live {
    background: rgba(220, 53, 69, 0.8);
    color: #fff;
}

.fav-status-overlay.offline {
    background: rgba(0, 0, 0, 0.6);
    color: rgba(255,255,255,0.5);
}

.live-dot {
    display: inline-block;
    width: 6px;
    height: 6px;
    background: #fff;
    border-radius: 50%;
    margin-right: 4px;
    animation: pulse-dot 1.5s infinite;
}

@keyframes pulse-dot {
    0% { opacity: 1; }
    50% { opacity: 0.4; }
    100% { opacity: 1; }
}

.fav-actions-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
}

.fav-card-premium:hover .fav-actions-overlay {
    opacity: 1;
}

.btn-fav-view {
    width: 40px;
    height: 40px;
    background: var(--gradient-gold);
    color: #000;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    font-size: 0.9rem;
    box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
    transform: translateY(10px);
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.fav-card-premium:hover .btn-fav-view {
    transform: translateY(0);
}

.fav-card-info {
    padding: 10px 4px 4px 4px;
    text-align: center;
}

.fav-name {
    font-size: 0.85rem;
    font-weight: 700;
    color: #fff;
    margin: 0 0 2px 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.fav-meta {
    font-size: 0.7rem;
    opacity: 0.5;
    margin: 0;
}

.streaming-text {
    color: #ef4444;
    font-weight: 700;
}

.fav-empty-premium {
    grid-column: 1 / -1;
    text-align: center;
    padding: 3rem 1rem;
    position: relative;
    overflow: hidden;
}

.empty-glow {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100px;
    height: 100px;
    background: var(--accent-gold);
    filter: blur(50px);
    opacity: 0.1;
}

.fav-empty-premium i {
    font-size: 2.5rem;
    color: rgba(255,255,255,0.1);
    margin-bottom: 1rem;
    display: block;
}

.fav-empty-premium p {
    font-size: 0.9rem;
    color: rgba(255,255,255,0.4);
    margin-bottom: 1.5rem;
}

.btn-gold-sm {
    background: var(--gradient-gold);
    color: #000;
    padding: 8px 16px;
    border-radius: 10px;
    font-size: 0.75rem;
    font-weight: 800;
    text-decoration: none;
    display: inline-block;
}
@media (max-width: 768px) {
    .fan-favorites-premium {
        padding: 1rem 0.5rem;
        border-radius: 20px;
    }

    .favorites-premium-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
    }

    .fav-card-premium {
        padding: 6px;
        border-radius: 16px;
    }

    .fav-card-visual {
        border-radius: 12px;
    }

    .fav-name {
        font-size: 0.75rem;
    }

    .fav-meta {
        font-size: 0.65rem;
    }

    .fav-status-overlay {
        top: 5px;
        left: 5px;
        padding: 2px 6px;
        font-size: 0.55rem;
    }

    .btn-fav-view {
        width: 32px;
        height: 32px;
        font-size: 0.75rem;
    }
}

@media (max-width: 480px) {
    .fan-favorites-premium {
        padding: 0.75rem 0.5rem;
        border-radius: 16px;
    }

    .favorites-premium-header {
        margin-bottom: 1rem;
    }

    .widget-title {
        font-size: 1rem;
    }

    .favorites-premium-grid {
        gap: 0.5rem;
    }

    .fav-card-premium {
        padding: 4px;
        border-radius: 12px;
    }

    .fav-card-visual {
        border-radius: 10px;
    }

    .fav-card-info {
        padding: 8px 2px 2px 2px;
    }

    .fav-name {
        font-size: 0.7rem;
    }

    .fav-empty-premium {
        padding: 2rem 0.75rem;
    }

    .fav-empty-premium i {
        font-size: 2rem;
    }
}
</style>
