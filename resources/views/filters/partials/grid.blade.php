<div class="sh-models-grid" id="models-grid-content">
    @forelse($models as $model)
        <a href="{{ route('profiles.show', ['model' => $model->id]) }}" class="sh-model-card">
            <div class="sh-card-image-wrapper">
                
                <div class="sh-criteria-badges">
                    @if(isset($categoryInfo['criteria']))
                        @foreach($categoryInfo['criteria'] as $criterion)
                            <div class="sh-criteria-badge {{ 'badge-' . ($criterion['type'] ?? 'default') }}">
                                <i class="{{ $criterion['icon'] }}" style="font-size: 10px;"></i>
                                {{ $criterion['label'] }}
                            </div>
                        @endforeach
                    @else
                        <div class="sh-criteria-badge badge-default">
                            <i class="{{ $categoryInfo['icon'] }}" style="font-size: 10px;"></i>
                            {{ strtoupper($categoryInfo['color'] ?? '') }}
                        </div>
                    @endif
                </div>

                @if(isset($model->profile) && $model->profile->is_streaming)
                    <div class="sh-badge-premium sh-badge-live">
                        <i class="fas fa-circle" style="font-size: 6px;"></i> {{ __('categories.live') }}
                    </div>
                @endif

                @if($model->profile && $model->profile->avatar)
                    <img src="{{ $model->profile->avatar_url }}" alt="{{ $model->name }}" class="sh-card-image" loading="lazy">
                @else
                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #1a1a1a;">
                        <i class="fas fa-user" style="font-size: 48px; color: rgba(255,255,255,0.1);"></i>
                    </div>
                @endif

                <div class="sh-card-overlay">
                    <h3 class="sh-model-name">
                        {{ $model->profile->display_name ?? $model->name }}
                    </h3>
                    <div class="sh-model-details">
                        @if($model->profile)
                            <span class="fi fi-{{ $model->profile->country }}"></span>
                            <span>{{ $model->profile->age_display ?? '' }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </a>
    @empty
        <div class="sh-no-results">
            <i class="fas fa-search" style="font-size: 48px; color: var(--color-oro-sensual); margin-bottom: 20px; opacity: 0.5;"></i>
            <h3 style="color: #fff; font-size: 24px; margin-bottom: 12px;">{{ __('categories.no_results') }}</h3>
            <p style="color: rgba(255,255,255,0.6); margin-bottom: 24px;">
                {{ __('categories.no_results_filters_desc') }}
            </p>
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

{{-- Data for AJAX updates --}}
<div id="ajax-results-data" style="display: none;" 
     data-total="{{ $models->total() }}" 
     data-current-page="{{ $models->currentPage() }}"
     data-title="{{ $categoryInfo['title'] }}"
     data-description="{{ $categoryInfo['description'] }}">
</div>
