<div class="sh-models-grid" id="models-grid-content">
    @forelse($models as $model)
        <a href="{{ route('profiles.show', ['model' => $model->id]) }}" class="sh-model-card">
            <div class="sh-card-image-wrapper">
                @if($model->profile && $model->profile->avatar)
                    <img src="{{ $model->profile->avatar_url }}" alt="{{ $model->name }}" class="sh-card-image" loading="lazy">
                @else
                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #1a1a1a;">
                        <i class="fas fa-user" style="font-size: 48px; color: rgba(255,255,255,0.1);"></i>
                    </div>
                @endif

                @if($model->profile->is_streaming)
                    <div class="sh-badge-premium sh-badge-live">
                        <i class="fas fa-circle" style="font-size: 6px;"></i> {{ __('categories.live') }}
                    </div>
                @endif
                
                <div class="sh-badge-premium 
                    @if(isset($categoryInfo['id']) && $categoryInfo['id'] === 'new_models') sh-badge-new
                    @elseif(isset($categoryInfo['id']) && $categoryInfo['id'] === 'favorite_models') sh-badge-favorite
                    @elseif(isset($categoryInfo['id']) && $categoryInfo['id'] === 'weekly_vip') sh-badge-vip
                    @else sh-badge-category
                    @endif" 
                    @if(!in_array($categoryInfo['id'] ?? '', ['new_models', 'favorite_models', 'weekly_vip'])) style="background: {{ $categoryInfo['color'] ?? 'rgba(0,0,0,0.6)' }};" @endif>
                    <i class="{{ $categoryInfo['icon'] }}"></i>
                    @if(isset($categoryInfo['id']) && $categoryInfo['id'] === 'new_models')
                        {{ __('categories.new_badge') }}
                    @elseif(isset($categoryInfo['id']) && $categoryInfo['id'] === 'favorite_models')
                        {{ __('categories.favorite_badge') }}
                    @elseif(isset($categoryInfo['id']) && $categoryInfo['id'] === 'weekly_vip')
                        {{ __('categories.vip_badge') }}
                    @else
                        {{ strtoupper($categoryInfo['title'] ?? '') }}
                    @endif
                </div>

                <div class="sh-card-overlay">
                    <h3 class="sh-model-name">
                        {{ $model->profile->display_name ?? $model->name }}
                        @if($model->is_verified)
                            <i class="fas fa-check-circle" style="color: #1da1f2; font-size: 14px;" title="{{ __('categories.verified') }}"></i>
                        @endif
                    </h3>
                    <div class="sh-model-location">
                        <span class="fi fi-{{ $model->profile->country }}"></span> 
                        {{ $model->profile->city ?? 'Internacional' }}
                    </div>
                </div>
            </div>
        </a>
    @empty
        <div class="sh-no-results">
            <i class="fas fa-search" style="font-size: 48px; color: var(--color-oro-sensual); margin-bottom: 20px; opacity: 0.5;"></i>
            <h3 style="color: #fff; font-size: 24px; margin-bottom: 12px;">{{ __('categories.no_results') }}</h3>
            <p style="color: rgba(255,255,255,0.6); margin-bottom: 24px;">{{ __('categories.no_results_desc') }}</p>
            <a href="{{ url('/') }}" class="sh-cta-button">
                {{ __('categories.view_all') }}
            </a>
        </div>
    @endforelse
</div>

@if($models->hasPages())
    <div class="sh-pagination-wrapper" style="margin-top: 48px; display: flex; justify-content: center;">
        {{ $models->links('custom.pagination') }}
    </div>
@endif

<div id="ajax-results-data" style="display: none;" 
     data-total="{{ $models->total() }}" 
     data-current-page="{{ $models->currentPage() }}"
     data-title="{{ $categoryInfo['title'] }}"
     data-description="{{ $categoryInfo['description'] }}">
</div>
