<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @section('title', __('search.title') . ' - Lustonex')

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Raleway:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    
    <link rel="stylesheet" href="{{ asset('css/premium-design.css') }}">
    <style>
        /* Ultra-Premium Badges */
        @keyframes sh-fade-in {
            from { opacity: 0; transform: translateY(2px); }
            to { opacity: 0.95; transform: translateY(0); }
        }

        .sh-badge-premium {
            position: absolute;
            z-index: 10;
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
            border: none;
            box-shadow: none;
            opacity: 0.95;
            transition: opacity 120ms ease-in-out, transform 120ms ease-in-out;
            animation: sh-fade-in 160ms ease-out both;
            color: #fff;
            pointer-events: none;
        }

        .sh-badge-premium:hover {
            opacity: 0.85;
        }

        .sh-badge-premium i {
            font-size: 11px;
            font-weight: 300;
        }

        .sh-badge-live {
            top: 12px;
            left: 12px;
            background: #C44545; /* Carmesí oscuro */
        }

        @media (max-width: 768px) {
            .sh-badge-premium {
                padding: 0 5px;
                font-size: 9px;
                height: 18px;
                border-radius: 4px;
                gap: 3px;
            }
            .sh-badge-premium i {
                font-size: 9px !important;
            }
            .sh-badge-live {
                top: 8px;
                left: 8px;
            }
        }
    </style>
</head>

<body>
    
    @include('components.sidebar-premium')

    @include('components.header-unified')

    
    <div class="main-content" id="mainContent">
        <div class="container" style="padding: 2rem;">
            
            <div class="search-results-header">
                <h1 class="search-title">{{ __('search.title') }}</h1>
                <p class="search-subtitle">{{ __('search.summary', ['total' => $models->total()]) }}</p>
            </div>

            @if($models->count() > 0)
                
                <div class="grid-models" id="models-grid">
                    @foreach($models as $model)
                        <div class="card-model">
                            
                            <div class="model-avatar-container">
                                <a href="{{ route('profiles.show', $model) }}">
                                    @if($model->profile && $model->profile->avatar)
                                        <img src="{{ $model->profile->avatar_url }}" alt="{{ $model->name }}" class="model-avatar">
                                    @else
                                        <div class="model-avatar default-avatar">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    @endif
                                </a>

                                
                                @if($model->profile)
                                    @if($model->profile->is_streaming)
                                        <div class="sh-badge-premium sh-badge-live">
                                            <i class="fas fa-circle" style="font-size: 6px;"></i> {{ __('search.status.live') }}
                                        </div>
                                    @elseif($model->profile->is_online)
                                        <div class="model-badge badge-online">{{ __('search.status.online') }}</div>
                                    @else
                                        <div class="model-badge badge-offline">{{ __('search.status.offline') }}</div>
                                    @endif
                                @endif
                            </div>

                            
                            <div class="model-info">
                                <h3 class="model-name">
                                    <a href="{{ route('profiles.show', $model) }}">
                                        {{ $model->profile->display_name ?? $model->name }}
                                    </a>
                                </h3>

                                @if($model->profile)
                                    <div class="model-details">
                                        @if($model->profile->age)
                                            <span class="model-age">{{ __('search.card.age', ['age' => $model->profile->age]) }}</span>
                                        @endif
                                        @if($model->profile->country)
                                            <span class="model-country">
                                                <i class="fas fa-map-marker-alt"></i>
                                                {{ $model->profile->country }}
                                            </span>
                                        @endif
                                    </div>

                                    @if($model->profile->bio)
                                        <p class="model-bio">{{ Str::limit($model->profile->bio, 100) }}</p>
                                    @endif

                                    
                                    <div class="model-tags">
                                        @if($model->profile->ethnicity)
                                            <span class="model-tag">{{ $model->profile->ethnicity }}</span>
                                        @endif
                                        @if($model->profile->body_type)
                                            <span class="model-tag">{{ $model->profile->body_type }}</span>
                                        @endif
                                        @if($model->profile->hair_color)
                                            <span class="model-tag">{{ $model->profile->hair_color }}</span>
                                        @endif
                                    </div>

                                    
                                    @if($model->profile->subscription_price > 0)
                                        <div class="model-price">
                                            <i class="fas fa-crown"></i>
                                            ${{ $model->profile->subscription_price }}/mes
                                        </div>
                                    @endif
                                @endif
                            </div>

                            
                            <div class="model-actions">
                                <a href="{{ route('profiles.show', $model) }}" class="btn-view-profile">
                                    <i class="fas fa-eye"></i>
                                    {{ __('search.card.view_profile') }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                
                <div class="pagination-container">
                    {{ $models->links() }}
                </div>
            @else
                
                <div class="no-results">
                    <div class="no-results-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h2 class="no-results-title">{{ __('search.no_results.title') }}</h2>
                    <p class="no-results-desc">{{ __('search.no_results.desc') }}</p>
                </div>
            @endif
        </div>
    </div>

    
    <script>
        // Funcionalidad del buscador



    </script>

    
    @include('components.sidebar-header-scripts')
    @include('components.search-scripts')
</body>

</html>