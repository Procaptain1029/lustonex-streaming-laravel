    
<div class="stats-sidebar">
    
    <div class="sidebar-widget" style="max-width: 280px; margin: 0 auto 1.5rem auto; text-align: center;">
        <div class="widget-title" style="justify-content: center;"><i class="fas fa-chart-line"></i> {{ __('profiles.stats.title') }}</div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; justify-items: center;">
            <div>
                <div style="font-size: 1.25rem; font-weight: 800; color: #fff;">
                    {{ number_format($model->profile->views()->count()) }}</div>
                <div style="font-size: 0.7rem; color: rgba(255,255,255,0.4);">{{ __('profiles.stats.views') }}</div>
            </div>
            <div>
                <div style="font-size: 1.25rem; font-weight: 800; color: #fff;">{{ $photos->total() }}</div>
                <div style="font-size: 0.7rem; color: rgba(255,255,255,0.4);">{{ __('profiles.stats.files') }}</div>
            </div>
        </div>
        @if($model->ranks->first())
            <div
                style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; gap: 10px;">
                <i class="fas fa trophy" style="color: var(--accent-gold);"></i>
                <span style="font-size: 0.85rem; font-weight: 700;">{{ __('profiles.stats.ranking_global', ['position' => $model->ranks->first()->rank_position]) }}</span>
            </div>
        @endif
    </div>

    
    @php
        $isSubscribed = auth()->check() && auth()->user()->hasActiveSubscriptionTo($model->id);
    @endphp

    @if($isSubscribed)
        <div class="sidebar-widget"
            style="background: linear-gradient(135deg, rgba(46, 204, 113, 0.1) 0%, rgba(18, 18, 22, 0.75) 100%); padding: 1.25rem; text-align: center; border-color: rgba(46, 204, 113, 0.3); max-width: 280px; margin: 0 auto 1.5rem auto;">
            <div class="widget-title" style="font-size: 0.95rem; margin-bottom: 0.5rem; justify-content: center; color: var(--accent-green);">
                <i class="fas fa-check-circle"></i> {{ __('profiles.subscription.active') }}
            </div>
            <p style="font-size: 0.75rem; color: rgba(255,255,255,0.7); margin-bottom: 1rem; line-height: 1.3;">
                {{ __('profiles.subscription.active_desc', ['name' => $model->profile->display_name ?? $model->name]) }}
            </p>
            <div style="display: flex; justify-content: center; width: 100%;">
                <a href="{{ route('fan.subscriptions.index') }}" class="btn-profile" style="background: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.1); text-decoration: none; padding: 8px 24px; font-size: 0.9rem; border-radius: 8px;">
                    <i class="fas fa-cog"></i> {{ __('profiles.subscription.manage') }}
                </a>
            </div>
        </div>
    @else
        <div class="sidebar-widget"
            style="background: linear-gradient(135deg, rgba(212, 175, 55, 0.1) 0%, rgba(18, 18, 22, 0.75) 100%); padding: 1.25rem; text-align: center; max-width: 280px; margin: 0 auto 1.5rem auto;">
            <div class="widget-title" style="font-size: 0.95rem; margin-bottom: 0.5rem; justify-content: center;"><i class="fas fa-crown"></i> {{ __('profiles.subscription.subscribe_to', ['name' => $model->profile->display_name ?? $model->name]) }}</div>
            <p style="font-size: 0.75rem; color: rgba(255,255,255,0.7); margin-bottom: 1rem; line-height: 1.3;">{{ __('profiles.subscription.subscribe_desc') }}</p>
            @auth
                <form action="{{ route('profiles.subscribe', $model->id) }}" method="POST" style="margin: 0; width: 100%; display: flex; justify-content: center;" onsubmit="handleSubscribe(event, this)">
                    @csrf
                    <button type="submit" class="btn-profile btn-premium" style="padding: 8px 24px; font-size: 0.9rem;">
                        <i class="fas fa-key"></i> {{ __('profiles.actions.subscribe') }}
                    </button>
                </form>
            @else
                <div style="display: flex; justify-content: center; width: 100%;">
                    <a href="{{ route('login') }}" class="btn-profile btn-premium" style="text-decoration: none; padding: 8px 24px; font-size: 0.9rem;">
                        <i class="fas fa-key"></i> {{ __('profiles.actions.subscribe') }}
                    </a>
                </div>
            @endauth
        </div>
    @endif


</div>