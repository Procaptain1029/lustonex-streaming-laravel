@extends('layouts.model')

@section('title', __('model.videos.index.title'))

@section('breadcrumb')
    <a href="{{ route('model.dashboard') }}" class="breadcrumb-item">Dashboard</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('model.videos.index.breadcrumb') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Model Videos Professional Styling ----- */

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

        /* Stats / Filters Styling */
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

        /* Video Grid */
        .sh-video-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 24px;
            padding-bottom: 48px;
        }

        .sh-video-card {
            border-radius: 12px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.02);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.2s ease-out;
            position: relative;
            cursor: pointer;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sh-video-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .sh-video-thumb-wrapper {
            aspect-ratio: 16 / 9;
            position: relative;
            overflow: hidden;
            background: #000;
        }

        .sh-video-thumb {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .sh-video-card:hover .sh-video-thumb {
            transform: scale(1.05);
        }

        .sh-video-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            padding: 16px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }

        .sh-video-title {
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 4px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .sh-video-meta {
            font-size: 12px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sh-play-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.8);
            width: 48px;
            height: 48px;
            background: rgba(212, 175, 55, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-size: 18px;
            opacity: 0;
            transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .sh-video-card:hover .sh-play-icon {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }

        .sh-video-status {
            position: absolute;
            top: 12px;
            left: 12px;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            backdrop-filter: blur(4px);
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

        .sh-video-actions {
            position: absolute;
            top: 12px;
            right: 12px;
            display: flex;
            gap: 8px;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.2s ease;
        }

        .sh-video-card:hover .sh-video-actions {
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

        /* Video Modal */
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
            width: 100%;
            max-width: 900px;
            padding: 20px;
            position: relative;
        }

        .sh-close-modal {
            position: absolute;
            top: -40px;
            right: 20px;
            color: #fff;
            font-size: 30px;
            cursor: pointer;
            background: none;
            border: none;
        }

        .sh-video-wrapper {
            width: 100%;
            aspect-ratio: 16/9;
            background: #000;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
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

            .sh-video-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 16px;
            }

            .sh-video-title {
                font-size: 14px;
            }

            .sh-video-actions {
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
            <h1 class="page-title">{{ __('model.videos.index.title') }}</h1>
            <p class="page-subtitle">{{ __('model.videos.index.subtitle') }}</p>
        </div>
        <a href="{{ route('model.videos.create') }}" class="sh-btn-primary">
            <i class="fas fa-upload"></i> {{ __('model.videos.index.btn_upload') }}
        </a>
    </div>

    <!-- Filters / Stats Chips -->
    <div class="sh-filters-bar">
        <a href="{{ route('model.videos.index') }}"
            class="sh-filter-chip {{ !request('status') && !request('visibility') ? 'active' : '' }}">
            {{ __('model.videos.index.filter_all') }} <span class="sh-filter-count">{{ $totalVideos }}</span>
        </a>
        <a href="{{ route('model.videos.index', ['visibility' => 'public']) }}"
            class="sh-filter-chip {{ request('visibility') == 'public' ? 'active' : '' }}">
            <i class="fas fa-globe" style="font-size: 12px;"></i> {{ __('model.videos.index.filter_public') }}
        </a>
        <a href="{{ route('model.videos.index', ['visibility' => 'private']) }}"
            class="sh-filter-chip {{ request('visibility') == 'private' ? 'active' : '' }}"
            style="color: var(--model-gold);">
            <i class="fas fa-crown" style="font-size: 12px;"></i> {{ __('model.videos.index.filter_vip') }}
        </a>
        <a href="{{ route('model.videos.index', ['status' => 'pending']) }}"
            class="sh-filter-chip {{ request('status') == 'pending' ? 'active' : '' }}" style="color: #ffc107;">
            <i class="fas fa-clock" style="font-size: 12px;"></i> {{ __('model.videos.index.filter_pending') }}
        </a>
    </div>

    @if($videos->count() > 0)
        <div class="sh-video-grid">
            @foreach($videos as $video)
                <div class="sh-video-card">
                    <div class="sh-video-thumb-wrapper" onclick="openVideo('{{ $video->url }}')">
                        @if($video->thumbnail)
                            <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="sh-video-thumb">
                        @else
                            <div class="sh-video-thumb"
                                style="background: #111; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-film" style="font-size: 24px; opacity: 0.3;"></i>
                            </div>
                        @endif

                        <div class="sh-play-icon"><i class="fas fa-play"></i></div>

                        <div class="sh-video-status {{ $video->is_public ? 'status-badge-approved' : 'status-badge-vip' }}">
                            {{ $video->is_public ? __('model.videos.index.status_public') : __('model.videos.index.status_vip') }}
                        </div>

                        <div class="sh-video-actions" onclick="event.stopPropagation()">
                            <form action="{{ route('model.videos.destroy', $video) }}" method="POST" style="display: inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="sh-action-icon action-delete"
                                    onclick="return confirm('{{ __('model.videos.index.confirm_delete') }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>

                        <div class="sh-video-overlay">
                            <div class="sh-video-title">{{ $video->title }}</div>
                            <div class="sh-video-meta">
                                <span><i class="fas fa-eye"></i> {{ number_format($video->views) }}</span>
                                <span>{{ $video->formatted_duration }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($videos->hasPages())
            <div style="margin-top: 32px;">
                {{ $videos->links('custom.pagination') }}
            </div>
        @endif

    @else
        <div class="sh-empty-state">
            <i class="fas fa-video" style="font-size: 48px; margin-bottom: 24px; opacity: 0.5;"></i>
            <h3 style="color: #dfc04e; margin-bottom: 12px;">{{ __('model.videos.index.empty_title') }}</h3>
            <p>{{ __('model.videos.index.empty_subtitle') }}</p>
        </div>
    @endif

    <!-- Video Modal -->
    <div id="videoModal" class="sh-modal-backdrop" onclick="closeVideo()">
        <div class="sh-modal-content" onclick="event.stopPropagation()">
            <button class="sh-close-modal" onclick="closeVideo()">&times;</button>
            <div class="sh-video-wrapper">
                <video id="mainPlayer" controls style="width: 100%; height: 100%;">
                    <source id="videoSource" src="" type="video/mp4">
                </video>
            </div>
        </div>
    </div>

    <script>
        function openVideo(url) {
            const modal = document.getElementById('videoModal');
            const player = document.getElementById('mainPlayer');
            const source = document.getElementById('videoSource');

            source.src = url;
            player.load();
            modal.style.display = 'flex';
            player.play();
            document.body.style.overflow = 'hidden';
        }

        function closeVideo() {
            const modal = document.getElementById('videoModal');
            const player = document.getElementById('mainPlayer');

            player.pause();
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', function (event) {
            if (event.key === "Escape") {
                closeVideo();
            }
        });
    </script>

@endsection