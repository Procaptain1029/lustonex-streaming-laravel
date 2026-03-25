<style>
    /* Base Styles (Desktop) */
    .profile-hero-section {
        position: relative;
        margin-bottom: 2rem;
    }

    .profile-hero {
        position: relative;
        margin-bottom: 15px;
    }

    .hero-cover-wrapper {
        height: 350px;
        width: 100%;
        border-radius: 24px;
        overflow: hidden;
        position: relative;
    }

    .hero-cover {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .hero-content {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 2rem;
        background: linear-gradient(to top, rgba(13, 13, 17, 0.9), transparent);
    }

    .hero-avatar-area {
        position: absolute;
        bottom: -50px;
        left: 30px;
        z-index: 10;
    }

    .profile-avatar-premium {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        border: 4px solid #121216;
        object-fit: cover;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    .profile-level-badge {
        background: var(--accent-gold);
        color: #000;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 800;
        font-size: 0.7rem;
        position: absolute;
        bottom: 0;
        right: 0;
        z-index: 15;
    }

    .profile-info-block {
        padding-left: 190px;
    }

    /* Guest View Layout */
    .guest-profile-header {
        width: 100%;
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 15px;
    }

    .guest-info-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .display-name {
        font-size: 1.5rem;
        line-height: 1;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .guest-badges {
        display: flex;
        align-items: center;
        gap: 8px;
        border-left: 1px solid rgba(255, 255, 255, 0.2);
        padding-left: 15px;
        height: 24px;
    }

    .guest-actions {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-left: auto;
    }

    .badge-premium-sh {
        height: 20px;
        padding: 0 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        line-height: 1.1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        color: #fff;
        border: none;
    }

    .badge-premium-sh i {
        font-size: 11px;
        font-weight: 300;
    }

    .sh-jade { background: #8FCFA8; color: #1a3d2c; }
    .sh-crimson { background: #C44545; }
    .sh-coral { background: #E88A9A; }
    .sh-lavender { background: #9D81B1; }
    .sh-live-pulse {
        width: 6px;
        height: 6px;
        background: currentColor;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    .btn-subscribe-gold {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(45deg, #d4af37, #f7e98d);
        color: #000;
        border: none;
        padding: 6px 16px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 0.9rem;
        cursor: pointer;
    }

    .heart-stat {
        display: flex;
        align-items: center;
        gap: 5px;
        color: #ff4d4d;
        font-weight: bold;
        font-size: 1.1rem;
    }

    /* Auth View Layout */
    .info-content {
        margin-bottom: 1.5rem;
    }

    .model-username {
        color: rgba(255, 255, 255, 0.5);
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .badge-container {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .action-deck {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    /* Mobile Optimization */
    @media (max-width: 768px) {
        .profile-hero {
            margin-bottom: 45px;
        }

        /* Reduced from 80px */
        .hero-cover-wrapper {
            height: 180px;
        }

        .hero-avatar-area {
            left: 50%;
            transform: translateX(-50%);
            bottom: -35px;
            /* Moved up from -60px */
        }

        .profile-avatar-premium {
            width: 110px;
            height: 110px;
        }

        .profile-info-block {
            padding-left: 0;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Guest Mobile */
        .guest-profile-header {
            flex-direction: column;
            gap: 12px;
            padding-bottom: 15px;
        }

        .guest-info-group {
            justify-content: center;
        }

        .display-name {
            font-size: 1.35rem;
            justify-content: center;
        }

        .guest-badges {
            border-left: none;
            padding-left: 0;
            justify-content: center;
            flex-wrap: wrap;
        }

        .guest-actions {
            margin-left: 0;
            width: 100%;
            justify-content: center;
            flex-direction: column;
            gap: 12px;
        }

        .btn-subscribe-gold {
            width: 100%;
            justify-content: center;
            padding: 10px;
        }

        /* Auth Mobile */
        .info-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .badge-container {
            justify-content: center;
        }

        .action-deck {
            flex-wrap: wrap;
            justify-content: center;
            width: 100%;
        }

        .action-deck .btn-profile {
            flex: 1;
            justify-content: center;
            min-width: 120px;
        }

        /* Make subscribe button full width on mobile auth view too */
        .action-deck form {
            width: 100%;
            flex: 1 1 100%;
        }

        .action-deck form button {
            width: 100%;
        }
    }
</style>

<div class="profile-hero-section">
    <div class="profile-hero">
        <div class="hero-cover-wrapper">
            @if($model->profile && $model->profile->cover_image)
                <img src="{{ $model->profile->cover_image_url }}" class="hero-cover" onclick="openPhotoModal('{{ $model->profile->cover_image_url }}', null, false, 0)" style="cursor: pointer;">
            @else
                <div class="hero-cover" style="background: linear-gradient(135deg, #1e1e24 0%, #121216 100%);"></div>
            @endif

            <div class="hero-content">
                
            </div>
        </div>

        <div class="hero-avatar-area">
            <img src="{{ $model->profile->avatar_url ?? asset('images/default-avatar.jpg') }}"
                class="profile-avatar-premium" onclick="openPhotoModal('{{ $model->profile->avatar_url ?? asset('images/default-avatar.jpg') }}', null, false, 0)" style="cursor: pointer;">
            @if($model->progress)
                
            @endif
        </div>
    </div>

    
    <div class="profile-info-block">
        @guest
            <div class="guest-profile-header">
                
                <div class="guest-info-group">
                    <h1 class="display-name">
                        {{ $model->profile->display_name ?? $model->name }}
                        @if($model->profile && $model->profile->verification_status == 'approved')
                            <i class="fas fa-check-circle" style="color: #3b82f6; font-size: 1.25rem;"></i>
                        @endif
                    </h1>
                </div>

                
                <div class="guest-badges">
                    @if($model->isNew())
                        <span class="badge-premium-sh sh-jade">
                            <i class="far fa-star"></i> {{ __('profiles.badges.new') }}
                        </span>
                    @endif
                    @if($model->isVIP())
                        <span class="badge-premium-sh sh-lavender">
                            <i class="far fa-crown"></i> {{ __('profiles.badges.vip') }}
                        </span>
                    @endif
                    <span class="badge-premium-sh sh-coral">
                        <i class="far fa-heart"></i> {{ __('profiles.badges.favorite') }}
                    </span>
                </div>

                
                <div class="guest-actions">
                    <form action="{{ route('profiles.subscribe', $model->id) }}" method="POST"
                        style="margin: 0; width: 100%; flex: 1;">
                        @csrf
                        <button type="submit" class="btn-subscribe-gold" style="width: 100%;">
                            <i class="fas fa-star"></i> {{ __('profiles.actions.subscribe') }}
                        </button>
                    </form>

                    
                    <div class="heart-stat">
                        <i class="fas fa-heart"></i>
                        <span>{{ $model->favorited_by_count ?? 0 }}</span>
                    </div>
                </div>
            </div>
        @else
            
            <div class="info-content">
                <h1 class="display-name">
                    {{ $model->profile->display_name ?? $model->name }}
                    @if($model->profile && $model->profile->verification_status == 'approved')
                        <i class="fas fa-check-circle" style="color: #3b82f6; font-size: 1.25rem;"></i>
                    @endif
                    <div class="guest-badges" style="height: auto; border: none; padding: 0;">
                        @if($model->isNew())
                            <span class="badge-premium-sh sh-jade">
                                <i class="far fa-star"></i> {{ __('profiles.badges.new') }}
                            </span>
                        @endif
                        @if($model->isVIP())
                            <span class="badge-premium-sh sh-lavender">
                                <i class="far fa-crown"></i> {{ __('profiles.badges.vip') }}
                            </span>
                        @endif
                        <span class="badge-premium-sh sh-coral">
                            <i class="far fa-heart"></i> {{ __('profiles.badges.favorite') }}
                        </span>
                        @if($model->profile && $model->profile->is_streaming)
                            <span class="badge-premium-sh sh-crimson">
                                <div class="sh-live-pulse"></div>
                                {{ __('profiles.badges.live') }}
                            </span>
                        @endif
                    </div>
                </h1>



            </div>


            <div class="action-deck">
                @if($isOwner)
                 
                @elseif(auth()->check() && auth()->user()->isAdmin())
                    
                   
                @else
                    
                    @if($hasSubscription)
                        <button class="btn-profile"
                            style="background: rgba(0, 255, 136, 0.1); border-color: rgba(0, 255, 136, 0.3); color: #00ff88; cursor: default; margin-left: auto;">
                            <i class="fas fa-check-circle"></i> {{ __('profiles.actions.subscribed') }}
                        </button>
                    @else
                        <form action="{{ route('profiles.subscribe', $model->id) }}" method="POST" style="margin: 0; margin-left: auto;" onsubmit="handleSubscribe(event, this)">
                            @csrf
                            <button type="submit" class="btn-profile btn-premium" style="justify-content: center; padding: 8px 16px; font-size: 0.9rem;">
                                <i class="fas fa-key"></i> {{ __('profiles.actions.subscribe') }}
                            </button>
                        </form>
                    @endif

                    @if($model->profile && $model->profile->is_streaming)
                        <button class="btn-profile" onclick="openTipModal()"><i class="fas fa-gift"></i> {{ __('profiles.actions.tip') }}</button>
                    @endif
                    
                    <button
                        class="btn-profile btn-heart {{ auth()->check() && auth()->user()->hasFavorite($model->id) ? 'active' : '' }}"
                        onclick="toggleFavorite({{ $model->id }}, this)">
                        <i class="fas fa-heart"></i>
                    </button>
                @endif
            </div>
        @endguest
    </div>
</div>