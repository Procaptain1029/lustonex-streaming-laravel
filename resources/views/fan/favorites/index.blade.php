@extends('layouts.fan')

@section('title', 'Mis Favoritas')



@section('content')
<style>
.favorites-container {
    padding: 0rem 2rem 2rem 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

/* Header */
.fav-page-header {
    margin-bottom: 2.5rem;
}

/* Estilos de encabezado heredados del layout fan */

/* Stats Row */
.fav-stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 2rem;
}

.fav-stat-card {
    background: rgba(30, 30, 35, 0.6);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: 18px;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
}

.fav-stat-card:hover {
    border-color: rgba(212, 175, 55, 0.3);
    background: rgba(40, 40, 45, 0.8);
}

.fav-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.fav-stat-icon.gold { background: rgba(212, 175, 55, 0.12); color: var(--color-oro-sensual); }
.fav-stat-icon.red { background: rgba(220, 53, 69, 0.12); color: #dc3545; }
.fav-stat-icon.blue { background: rgba(59, 130, 246, 0.12); color: #3b82f6; }

.fav-stat-icon.red i {
    animation: pulse-live 2s infinite;
}

@keyframes pulse-live {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.4; }
}

.fav-stat-value {
    font-family: var(--font-titles);
    font-size: 1.6rem;
    font-weight: 800;
    color: #fff;
    line-height: 1;
}

.fav-stat-label {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.5);
    margin-top: 2px;
}

/* Filters */
.fav-filters {
    display: flex;
    gap: 0.75rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.fav-filter-btn {
    padding: 0.6rem 1.25rem;
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 10px;
    color: rgba(255, 255, 255, 0.6);
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    font-size: 0.9rem;
}

.fav-filter-btn:hover {
    background: rgba(212, 175, 55, 0.08);
    border-color: rgba(212, 175, 55, 0.25);
    color: var(--color-oro-sensual);
}

.fav-filter-btn.active {
    background: var(--gradient-gold);
    border-color: var(--color-oro-sensual);
    color: #000;
}

.fav-filter-btn i {
    font-size: 0.7rem;
}

/* Model Cards Grid (Welcome Style) */
.fav-models-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    width: 100%;
}

.fav-model-card {
    flex: 1 1 200px;
    max-width: 250px;
    border-radius: 12px;
    overflow: hidden;
    background: rgba(31, 31, 35, 0.5);
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    position: relative;
    border: 1px solid rgba(255, 255, 255, 0.05);
    display: block;
    text-decoration: none;
}

.fav-model-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.2);
    border-color: rgba(212, 175, 55, 0.3);
    z-index: 2;
}

.fav-card-image-wrap {
    aspect-ratio: 4/5;
    position: relative;
    background: #000;
    overflow: hidden;
}

.fav-card-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.fav-model-card:hover .fav-card-img {
    transform: scale(1.05);
}

.fav-live-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #ff3b30;
    color: #fff;
    font-size: 9px;
    font-weight: 700;
    padding: 4px 8px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    gap: 4px;
    z-index: 5;
    box-shadow: 0 2px 4px rgba(0,0,0,0.3);
    letter-spacing: 0.5px;
}

.fav-heart-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(233, 59, 118, 0.85);
    backdrop-filter: blur(4px);
    color: #fff;
    font-size: 10px;
    font-weight: 600;
    padding: 4px 8px;
    border-radius: 4px;
    z-index: 5;
}

.fav-card-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 40%;
    background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 14px;
}

.fav-card-name {
    color: #fff;
    font-size: 16px;
    font-weight: 700;
    margin: 0 0 3px 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    gap: 6px;
}

.fav-card-location {
    color: rgba(255, 255, 255, 0.7);
    font-size: 12px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 4px;
}

/* Hover action overlay */
.fav-action-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.fav-model-card:hover .fav-action-overlay {
    opacity: 1;
}

.fav-play-btn {
    width: 48px;
    height: 48px;
    background: var(--gradient-gold);
    color: #000;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
    transform: translateY(10px);
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.fav-model-card:hover .fav-play-btn {
    transform: translateY(0);
}

/* Empty State */
.fav-empty-state {
    text-align: center;
    padding: 5rem 2rem;
    background: rgba(255, 255, 255, 0.02);
    border: 1px dashed rgba(212, 175, 55, 0.25);
    border-radius: 24px;
}

.fav-empty-icon {
    font-size: 3.5rem;
    color: var(--color-oro-sensual);
    opacity: 0.4;
    margin-bottom: 1.5rem;
}

.fav-empty-state h2 {
    font-family: var(--font-titles);
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.75rem;
}

.fav-empty-state p {
    color: rgba(255,255,255,0.5);
    max-width: 400px;
    margin: 0 auto 2rem;
    font-size: 0.95rem;
}

.btn-explore {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 28px;
    background: var(--gradient-gold);
    color: #000;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.95rem;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
}

.btn-explore:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);
}

/* Responsive - Tablet */
@media (max-width: 1024px) {
    .fav-model-card {
        flex: 1 1 180px;
        max-width: calc(25% - 15px);
    }
}

/* Responsive - Mobile */
@media (max-width: 768px) {
    .favorites-container {
        padding: 0.25rem 0.75rem 1rem;
    }

    .fav-page-header {
        margin-bottom: 1.5rem;
        text-align: center;
    }

    /* Estilos responsivos de encabezado heredados */

    .fav-stats-row {
        gap: 0.5rem;
        margin-bottom: 1.25rem;
    }

    .fav-stat-card {
        flex-direction: column;
        padding: 0.75rem 0.5rem;
        text-align: center;
        gap: 0.4rem;
        border-radius: 14px;
    }

    .fav-stat-icon {
        width: 36px;
        height: 36px;
        font-size: 0.9rem;
        border-radius: 10px;
    }

    .fav-stat-value {
        font-size: 1.1rem;
    }

    .fav-stat-label {
        font-size: 0.65rem;
        white-space: nowrap;
    }

    .fav-filters {
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 1.25rem;
    }

    .fav-filter-btn {
        padding: 0.45rem 0.9rem;
        font-size: 0.8rem;
        border-radius: 8px;
    }

    .fav-models-grid {
        gap: 12px;
    }

    .fav-model-card {
        flex: 1 1 calc(50% - 6px);
        max-width: calc(50% - 6px);
    }

    .fav-card-overlay {
        padding: 10px;
    }

    .fav-card-name {
        font-size: 13px;
    }

    .fav-card-location {
        font-size: 10px;
    }

    .fav-heart-badge {
        font-size: 8px;
        padding: 3px 6px;
        top: 6px;
        right: 6px;
    }

    .fav-live-badge {
        font-size: 8px;
        padding: 3px 6px;
        top: 6px;
        left: 6px;
    }

        .fav-play-btn {
        width: 36px;
        height: 36px;
        font-size: 0.85rem;
    }

    .fav-empty-state {
        padding: 3rem 1rem;
        border-radius: 18px;
    }

    .fav-empty-icon {
        font-size: 2.5rem;
    }

    .fav-empty-state h2 {
        font-size: 1.2rem;
    }

    .fav-empty-state p {
        font-size: 0.85rem;
    }
}

@media (max-width: 480px) {
    /* Estilos responsivos heredados */
}
</style>
<div class="favorites-container">
    
    <div class="fav-page-header">
        <h1 class="page-title">
           {{ __('fan.dashboard.favorites.page_title') }}
        </h1>
        <p class="page-subtitle">{{ __('fan.dashboard.favorites.page_subtitle') }}</p>
    </div>

    
    <div class="fav-stats-row">
        <div class="fav-stat-card">
            <div class="fav-stat-icon gold"><i class="fas fa-star"></i></div>
            <div>
                <div class="fav-stat-value">{{ $stats['total_favorites'] }}</div>
                <div class="fav-stat-label">{{ __('fan.dashboard.favorites.title') }}</div>
            </div>
        </div>
        <div class="fav-stat-card">
            <div class="fav-stat-icon red"><i class="fas fa-circle"></i></div>
            <div>
                <div class="fav-stat-value">{{ $stats['online_now'] }}</div>
                <div class="fav-stat-label">{{ __('fan.dashboard.favorites.live') }}</div>
            </div>
        </div>
        <div class="fav-stat-card">
            <div class="fav-stat-icon blue"><i class="fas fa-bell"></i></div>
            <div>
                <div class="fav-stat-value">{{ $stats['new_content'] }}</div>
                <div class="fav-stat-label">{{ __('fan.dashboard.favorites.streaming_now') }}</div>
            </div>
        </div>
    </div>

    
    <div class="fav-filters">
        <button class="fav-filter-btn active" data-filter="all">
            <i class="fas fa-th"></i> {{ __('fan.dashboard.recent_activity') }}
        </button>
        <button class="fav-filter-btn" data-filter="online">
            <i class="fas fa-circle"></i> {{ __('fan.dashboard.favorites.live') }}
        </button>
        <button class="fav-filter-btn" data-filter="offline">
            <i class="fas fa-moon"></i> {{ __('fan.dashboard.favorites.offline') }}
        </button>
    </div>

    
    @if($favorites->count() > 0)
        <div class="fav-models-grid">
            @foreach($favorites as $model)
                <a href="{{ route('profiles.show', $model->id) }}" class="fav-model-card">
                    <div class="fav-card-image-wrap">
                        @if($model->profile && $model->profile->avatar)
                            <img src="{{ $model->profile->avatar_url }}" alt="{{ $model->name }}" class="fav-card-img" loading="lazy">
                        @else
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #1a1a1a;">
                                <i class="fas fa-user" style="font-size: 48px; color: rgba(255,255,255,0.1);"></i>
                            </div>
                        @endif

                        @if($model->profile->is_streaming)
                            <div class="fav-live-badge">
                                <i class="fas fa-circle" style="font-size: 5px;"></i> EN VIVO
                            </div>
                        @endif

                        <div class="fav-heart-badge">
                            <i class="fas fa-heart"></i> FAV
                        </div>

                        <div class="fav-action-overlay">
                            <div class="fav-play-btn">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>

                        <div class="fav-card-overlay">
                            <h3 class="fav-card-name">
                                {{ $model->profile->display_name ?? $model->name }}
                                @if($model->is_verified)
                                    <i class="fas fa-check-circle" style="color: #1da1f2; font-size: 13px;"></i>
                                @endif
                            </h3>
                            <div class="fav-card-location">
                                <span class="fi fi-{{ $model->profile->country ?? 'us' }}"></span>
                                {{ $model->profile->city ?? 'Internacional' }}
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="fav-empty-state">
            <div class="fav-empty-icon">
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h2>{{ __('fan.dashboard.favorites.empty_list') }}</h2>
            <p>{{ __('fan.dashboard.favorites.find_models_hint') ?? 'Explora modelos, dale favorita y recibe notificaciones cuando entren en vivo.' }}</p>
            <a href="{{ route('home') }}" class="btn-explore">
                <i class="fas fa-search"></i> {{ __('fan.dashboard.favorites.find_models') }}
            </a>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.querySelectorAll('.fav-filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.fav-filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        const filter = this.dataset.filter;
        const cards = document.querySelectorAll('.fav-model-card');
        
        cards.forEach(card => {
            const isLive = card.querySelector('.fav-live-badge') !== null;
            
            if (filter === 'all') {
                card.style.display = '';
            } else if (filter === 'online') {
                card.style.display = isLive ? '' : 'none';
            } else if (filter === 'offline') {
                card.style.display = isLive ? 'none' : '';
            }
        });
    });
});
</script>
@endsection
