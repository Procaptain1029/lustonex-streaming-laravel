@extends('layouts.model')

@section('title', __('model.photos.index.title_tag'))

@section('breadcrumb')
    <a href="{{ route('model.dashboard') }}" class="breadcrumb-item">{{ __('model.photos.index.breadcrumb_dashboard') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('model.photos.index.breadcrumb_active') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Model Photos Professional Styling ----- */

        .page-header {
            padding-top: 2rem;
            margin-bottom: 48px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            flex-wrap: wrap;
            gap: 24px;
        }

        /* Estilos de encabezado heredados del layout model */

        .sh-btn-primary {
            padding: 12px 28px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            background: var(--model-gold);
            color: #000;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s ease-out;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .sh-btn-primary:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 16px rgba(212, 175, 55, 0.2);
        }

        /* Filters Styles */
        .sh-filters-bar {
            display: flex;
            gap: 12px;
            margin-bottom: 32px;
            flex-wrap: wrap;
        }

        .sh-filter-chip {
            padding: 8px 16px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.02);
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .sh-filter-chip:hover,
        .sh-filter-chip.active {
            background: rgba(255, 255, 255, 0.1);
            border-color: #fff;
            color: #fff;
        }

        .sh-filter-count {
            background: rgba(255, 255, 255, 0.1);
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 11px;
        }

        /* Photos Grid */
        .sh-photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 24px;
            padding-bottom: 48px;
        }

        .sh-photo-card {
            border-radius: 12px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.02);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.2s ease-out;
            position: relative;
            cursor: pointer;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sh-photo-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .sh-photo-wrapper {
            aspect-ratio: 4 / 5;
            position: relative;
            overflow: hidden;
            background: #000;
        }

        .sh-photo-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .sh-photo-card:hover .sh-photo-img {
            transform: scale(1.05);
        }

        .sh-photo-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 35%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            padding: 12px 16px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }

        .sh-photo-title {
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 4px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .sh-photo-status {
            position: absolute;
            top: 12px;
            left: 12px;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            backdrop-filter: blur(4px);
            z-index: 2;
        }

        .status-badge-pending {
            background: rgba(255, 193, 7, 0.8);
            color: #000;
        }

        .status-badge-approved {
            background: rgba(40, 167, 69, 0.8);
            color: #fff;
        }

        .status-badge-vip {
            background: rgba(212, 175, 55, 0.9);
            color: #000;
        }

        .sh-photo-actions {
            position: absolute;
            top: 12px;
            right: 12px;
            display: flex;
            gap: 8px;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.2s ease;
            z-index: 2;
        }

        .sh-photo-card:hover .sh-photo-actions {
            opacity: 1;
            transform: translateY(0);
        }

        .sh-action-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            backdrop-filter: blur(4px);
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }

        .sh-action-icon:hover {
            background: #fff;
            color: #000;
        }

        .action-delete:hover {
            background: #dc3545;
            color: #fff;
        }

        .sh-empty-state {
            text-align: center;
            padding: 80px 20px;
            color: rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.02);
            border-radius: 20px;
            border: 1px dashed rgba(255, 255, 255, 0.1);
        }

        /* Modal Viewer */
        .sh-modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.95);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            backdrop-filter: blur(10px);
        }

        .sh-modal-content {
            max-width: 95vw;
            max-height: 95vh;
            position: relative;
        }

        .sh-modal-img {
            max-width: 100%;
            max-height: 90vh;
            border-radius: 8px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        .sh-close-modal {
            position: absolute;
            top: -40px;
            right: 0;
            color: #fff;
            font-size: 30px;
            cursor: pointer;
            background: none;
            border: none;
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
                padding-top: 0;
            }

            /* Estilos responsivos de encabezado heredados */

            .sh-btn-primary {
                width: 100%;
                justify-content: center;
            }

            .sh-photo-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 16px;
            }

            .sh-photo-actions {
                opacity: 1;
                transform: translateY(0);
            }

            /* Always visible on mobile */
        }

        /* Estilos responsivos heredados */
    </style>
@endsection

@section('content')

    <div class="page-header">
        <div>
            <h1 class="page-title">{{ __('model.photos.index.header_title') }}</h1>
            <p class="page-subtitle">{{ __('model.photos.index.header_subtitle') }}</p>
        </div>
        <a href="{{ route('model.photos.create') }}" class="sh-btn-primary">
            <i class="fas fa-camera"></i> {{ __('model.photos.index.upload_button') }}
        </a>
    </div>

    <!-- Filters / Stats Chips -->
    <div class="sh-filters-bar">
        <a href="{{ route('model.photos.index') }}"
            class="sh-filter-chip {{ !request('status') && !request('visibility') ? 'active' : '' }}">
            {{ __('model.photos.index.filter_all') }} <span class="sh-filter-count">{{ $photos->total() }}</span>
        </a>
        <a href="{{ route('model.photos.index', ['visibility' => 'public']) }}"
            class="sh-filter-chip {{ request('visibility') == 'public' ? 'active' : '' }}">
            <i class="fas fa-globe" style="font-size: 12px;"></i> {{ __('model.photos.index.filter_public') }}
        </a>
        <a href="{{ route('model.photos.index', ['visibility' => 'private']) }}"
            class="sh-filter-chip {{ request('visibility') == 'private' ? 'active' : '' }}"
            style="color: var(--model-gold);">
            <i class="fas fa-crown" style="font-size: 12px;"></i> {{ __('model.photos.index.filter_vip') }}
        </a>
        <a href="{{ route('model.photos.index', ['status' => 'pending']) }}"
            class="sh-filter-chip {{ request('status') == 'pending' ? 'active' : '' }}" style="color: #ffc107;">
            <i class="fas fa-clock" style="font-size: 12px;"></i> {{ __('model.photos.index.filter_pending') }}
        </a>
    </div>

    @if($photos->count() > 0)
        <div class="sh-photo-grid">
            @foreach($photos as $photo)
                <div class="sh-photo-card" onclick="openPhoto('{{ $photo->url }}')">
                    <div class="sh-photo-wrapper">
                        <img src="{{ $photo->thumbnail_url }}" alt="{{ $photo->title }}" class="sh-photo-img" loading="lazy">

                        @if($photo->status === 'pending')
                            <div class="sh-photo-status status-badge-pending">
                                <i class="fas fa-clock" style="font-size: 9px;"></i> {{ __('model.photos.index.status_pending') }}
                            </div>
                        @else
                            <div class="sh-photo-status {{ $photo->is_public ? 'status-badge-approved' : 'status-badge-vip' }}">
                                {{ $photo->is_public ? __('model.photos.index.status_public') : __('model.photos.index.status_vip') }}
                            </div>
                        @endif

                        <div class="sh-photo-actions" onclick="event.stopPropagation()">
                            <form action="{{ route('model.photos.destroy', $photo) }}" method="POST" style="display: inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="sh-action-icon action-delete"
                                    onclick="return confirm('{{ __('model.photos.index.delete_confirm') }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>

                        <div class="sh-photo-overlay">
                            <div class="sh-photo-title">{{ $photo->title ?? __('model.photos.index.no_title') }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($photos->hasPages())
            <div style="margin-top: 32px;">
                {{ $photos->links('custom.pagination') }}
            </div>
        @endif

    @else
        <div class="sh-empty-state">
            <i class="fas fa-images" style="font-size: 48px; margin-bottom: 24px; opacity: 0.5;"></i>
            <h3 style="color: #dfc04e; margin-bottom: 12px;">{{ __('model.photos.index.empty_title') }}</h3>
            <p>{{ __('model.photos.index.empty_subtitle') }}</p>
        </div>
    @endif

    <!-- Photo Modal -->
    <div id="photoModal" class="sh-modal-backdrop" onclick="closePhoto()">
        <div class="sh-modal-content" onclick="event.stopPropagation()">
            <button class="sh-close-modal" onclick="closePhoto()"><i class="fas fa-times"></i></button>
            <img id="modalImage" src="" alt="" class="sh-modal-img">
        </div>
    </div>

    <script>
        function openPhoto(url) {
            const modal = document.getElementById('photoModal');
            const img = document.getElementById('modalImage');

            img.src = url;
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closePhoto() {
            const modal = document.getElementById('photoModal');
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', function (event) {
            if (event.key === "Escape") {
                closePhoto();
            }
        });
    </script>

@endsection