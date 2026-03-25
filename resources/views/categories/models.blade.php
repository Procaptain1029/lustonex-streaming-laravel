@extends('layouts.public')

@php
    $title = $categoryInfo['title'] . ' - Lustonex';
@endphp

@section('content')
 <style>
        /* ----- Premium Categories Styling ----- */
        .category-page-wrapper {
            min-height: 100vh;
            background: #0b0b0d;
            padding-bottom: 60px;
        }

        .category-header {
            padding-bottom: 48px;
            padding-left: 24px;
            padding-right: 24px;
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
        }

        .category-header-content {
            position: relative;
            z-index: 2;
        }

        .category-bg-icon {
            position: absolute;
            right: 5%;
            top: 20%;
            font-size: 200px;
            color: rgba(212, 175, 55, 0.03);
            pointer-events: none;
            z-index: 1;
            transform: rotate(-15deg);
        }

        .sh-category-title-wrapper {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }

        .sh-category-icon {
            font-size: 32px;
            color: var(--color-oro-sensual);
            filter: drop-shadow(0 0 10px rgba(212, 175, 55, 0.3));
        }

        .sh-category-title {
            font-family: 'Poppins', sans-serif !important;
            font-size: 28px !important;
            font-weight: 700 !important;
            line-height: 1.2 !important;
            color: #dab843 !important;
            margin: 0 !important;
        }

        .sh-category-description {
            font-size: 16px !important;
            color: rgba(255, 255, 255, 0.85) !important;
            max-width: 620px;
            margin-bottom: 32px;
            line-height: 1.6;
        }

        /* Stats & Filter Chips */
        .sh-stats-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 10px;
        }

        .sh-stat-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.03);
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            backdrop-filter: blur(5px);
        }

        .sh-stat-chip:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .sh-stat-chip i {
            color: var(--color-oro-sensual);
        }

        /* Models Grid */
        .sh-models-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 24px;
            padding: 0 24px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .sh-model-card {
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

        .sh-model-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.2);
            border-color: rgba(212, 175, 55, 0.3);
            z-index: 2;
        }

        .sh-card-image-wrapper {
            aspect-ratio: 4/5;
            position: relative;
            background: #000;
            overflow: hidden;
        }

        .sh-card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .sh-model-card:hover .sh-card-image {
            transform: scale(1.05);
        }

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

        .sh-badge-new {
            top: 12px;
            right: 12px;
            background: #8FCFA8; /* Jade profundo */
            color: #1a3d2c; /* Contrast for Jade */
        }

        .sh-badge-favorite {
            top: 12px;
            right: 12px;
            background: #E88A9A; /* Coral premium */
        }

        .sh-badge-vip {
            top: 12px;
            right: 12px;
            background: #9D81B1; /* Lavanda profundo/Vip */
        }

        .sh-badge-category {
            top: 12px;
            right: 12px;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
        }

        .sh-card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 40%;
            background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 16px;
        }

        .sh-model-name {
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            margin: 0 0 4px 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .sh-model-location {
            color: rgba(255, 255, 255, 0.7);
            font-size: 12px;
            font-weight: 500;
            display: flex; 
            align-items: center; 
            gap: 4px;
        }

        /* No Results */
        .sh-no-results {
            grid-column: 1 / -1;
            text-align: center;
            padding: 80px 20px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 20px;
            border: 1px dashed rgba(255, 255, 255, 0.1);
            width: 100%;
        }

        .sh-cta-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 30px;
            background: var(--color-oro-sensual);
            color: #000;
            font-weight: 700;
            border-radius: 50px;
            text-decoration: none;
            margin-top: 24px;
            transition: all 0.3s ease;
        }

        .sh-cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
        }

        @media (max-width: 768px) {
            .category-page-wrapper {
                padding-bottom: 40px;
            }

            .category-header {
                padding-top: 24px;
                padding-bottom: 24px;
                padding-left: 16px;
                padding-right: 16px;
                text-align: left;
            }
            
            .sh-category-title-wrapper {
                gap: 12px;
                margin-bottom: 16px;
            }

            .sh-category-icon { font-size: 24px; }
            .sh-category-title { font-size: 24px; }
            .sh-category-description { font-size: 14px; margin-bottom: 20px; }
            
            .sh-models-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
                padding: 0 16px;
            }

            .sh-category-bg-icon { display: none; }
            
            /* Card compact style for mobile */
            .sh-card-overlay { padding: 10px; height: 50%; }
            .sh-model-name { font-size: 14px; margin-bottom: 2px; }
            .sh-model-location { font-size: 11px; }
            .sh-stat-chip { padding: 6px 12px; font-size: 12px; }
        }

        @media (max-width: 480px) {
            .category-header {
                padding-left: 12px;
                padding-right: 12px;
                padding-top: 20px;
                padding-bottom: 20px;
            }
            
            .sh-category-title { font-size: 20px; }
            .sh-category-description { font-size: 13px; margin-bottom: 16px; }
            
            .sh-stats-bar {
                gap: 8px;
            }

            .sh-stat-chip { 
                padding: 4px 10px; 
                font-size: 11px; 
            }

            .sh-models-grid {
                gap: 10px;
                padding: 0 12px;
            }

            .sh-card-overlay { padding: 8px; }
            .sh-model-name { font-size: 13px; }
            .sh-model-location { font-size: 10px; }
            
            /* Adjust badges for mobile to prevent overlapping */
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
            .sh-badge-new, .sh-badge-favorite, .sh-badge-vip, .sh-badge-category {
                top: 8px;
                right: 8px;
            }
        }
    </style>
    <div class="category-page-wrapper">
        
        <div class="category-header">
            <i class="{{ $categoryInfo['icon'] }} category-bg-icon"></i>

            <div class="category-header-content">
                <div class="sh-category-title-wrapper">
                    
                    <h1 class="sh-category-title">{{ $categoryInfo['title'] }}</h1>
                </div>

                <p class="sh-category-description">
                    {{ $categoryInfo['description'] }}
                </p>

                <div class="sh-stats-bar">
                    <div class="sh-stat-chip">
                        <i class="fas fa-users"></i>
                        <span><strong>{{ $models->total() }}</strong> {{ __('categories.models_count') }}</span>
                    </div>
                    <div class="sh-stat-chip">
                        <i class="fas fa-layer-group"></i>
                        <span>{{ __('categories.page') }} {{ $models->currentPage() }}</span>
                    </div>
                    @if(isset($categoryInfo['title']))
                        <div class="sh-stat-chip" style="border-color: {{ $categoryInfo['color'] ?? 'rgba(255,255,255,0.1)' }};">
                            <i class="fas fa-tag"></i>
                            <span>{{ $categoryInfo['title'] }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div id="models-grid-container">
            @include('categories.partials.grid-categories')
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const gridContainer = document.getElementById('models-grid-container');
        const countSpan = document.querySelector('.sh-stat-chip span strong');
        const pageSpan = document.querySelectorAll('.sh-stat-chip span')[1]; 
        const headerTitle = document.querySelector('.sh-filter-title, .sh-category-title');
        const headerDesc = document.querySelector('.sh-filter-description, .sh-category-description');

        // Function to animate cards
        function animateCards() {
            const cards = document.querySelectorAll('.sh-model-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'opacity 0.5s ease, transform 0.5s ease, box-shadow 0.3s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 30);
            });
        }

        // Initial animation
        animateCards();

        // AJAX function
        async function loadContent(url, pushState = true) {
            try {
                gridContainer.style.opacity = '0.5';
                gridContainer.style.pointerEvents = 'none';

                const response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) throw new Error('Network response was not ok');

                const html = await response.text();
                
                // Update grid
                gridContainer.innerHTML = html;
                gridContainer.style.opacity = '1';
                gridContainer.style.pointerEvents = 'all';

                // Get new data from the partial
                const newData = document.getElementById('ajax-results-data');
                if (newData) {
                    if (countSpan) countSpan.textContent = newData.dataset.total;
                    if (pageSpan) pageSpan.textContent = `Página ${newData.dataset.currentPage}`;
                    if (headerTitle) headerTitle.textContent = newData.dataset.title;
                    if (headerDesc) headerDesc.textContent = newData.dataset.description;
                    document.title = `${newData.dataset.title} - Lustonex`;
                }

                // Update URL
                if (pushState) {
                    history.pushState({ url }, '', url);
                    if (typeof updateSidebarActiveStates === 'function') {
                        updateSidebarActiveStates();
                    }
                }

                // Re-animate
                animateCards();
                
                // Scroll to top of grid smoothly
                window.scrollTo({ top: 0, behavior: 'smooth' });

            } catch (error) {
                console.error('Fetch error:', error);
                window.location.href = url; // Fallback to normal load
            }
        }

        // Intercept sidebar filter clicks
        document.addEventListener('click', function(e) {
            const filterLink = e.target.closest('.sidebar-v2 .filter-item, .sidebar-v2 .nav-item');
            
            if (filterLink && filterLink.href && !filterLink.href.includes('#')) {
                // EXCLUDE HOME PAGE FROM AJAX
                const url = new URL(filterLink.href);
                if (url.pathname === '/' || url.pathname === '') return;

                e.preventDefault();
                loadContent(filterLink.href);
            }

            // Intercept pagination clicks
            const paginationLink = e.target.closest('.sh-pagination-wrapper a');
            if (paginationLink && paginationLink.href) {
                e.preventDefault();
                loadContent(paginationLink.href);
            }
        });

        // Handle Back/Forward buttons
        window.addEventListener('popstate', function(e) {
            if (e.state && e.state.url) {
                loadContent(e.state.url, false);
            } else {
                window.location.reload();
            }
        });
    });
</script>
@endpush