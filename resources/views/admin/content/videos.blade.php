@extends('layouts.admin')

@section('title', __('admin.content.videos.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.content.videos.title') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Video Moderation Professional Styling ----- */

        /* 1. Hero / Title */
        .page-header {
            margin-bottom: 32px;
        }


        /* 2. Stats Row */
        .sh-stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .sh-stat-mini-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: transform 0.2s ease;
        }

        .sh-stat-mini-card:hover {
            transform: translateY(-2px);
        }

        .sh-stat-mini-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        /* 3. Management Header & Filters */
        .sh-management-header {
            display: flex;
            flex-direction: column;
            gap: 24px;
            margin-bottom: 32px;
        }

        .sh-filter-container {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .sh-filter-chip {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 14px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.2s ease;
            background: transparent;
        }

        .sh-filter-chip:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        .sh-filter-chip.active {
            border: 2px solid var(--admin-gold);
            font-weight: 600;
            color: #fff;
            background: rgba(212, 175, 55, 0.05);
        }

        .sh-search-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            gap: 20px;
        }

        .sh-filter-input {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 10px 15px;
            color: #fff;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .sh-filter-input:focus {
            outline: none;
            border-color: var(--admin-gold);
            background: rgba(255, 255, 255, 0.05);
        }

        .sh-search-box {
            flex: 1;
            max-width: 400px;
            position: relative;
        }

        .sh-search-box i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.4);
        }

        /* 4. Video Grid */
        .sh-video-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 24px;
        }

        .sh-video-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.2s ease-out;
            position: relative;
            aspect-ratio: 4/5;
        }

        .sh-video-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border-color: rgba(212, 175, 55, 0.2);
        }

        .sh-video-preview {
            width: 100%;
            height: 100%;
            position: relative;
            cursor: pointer;
        }

        .sh-video-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .sh-video-card:hover .sh-video-img {
            transform: scale(1.05);
        }

        .sh-play-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 3rem;
            color: #fff;
            opacity: 0.7;
            transition: all 0.3s ease;
            text-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            z-index: 10;
            pointer-events: none;
        }

        .sh-video-card:hover .sh-play-icon {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1.1);
            color: var(--admin-gold);
        }

        .sh-duration-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 4px;
            backdrop-filter: blur(4px);
            z-index: 5;
        }

        /* 5. Bottom Overlay */
        .sh-video-overlay-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 45%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.95) 0%, rgba(0, 0, 0, 0.6) 50%, rgba(0, 0, 0, 0) 100%);
            padding: 16px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            z-index: 20;
        }

        .sh-video-model-name {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 4px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .sh-video-meta-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .sh-badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            backdrop-filter: blur(4px);
        }

        .sh-badge-pending {
            background: rgba(245, 158, 11, 0.3);
            color: #fcd34d;
            border: 1px solid rgba(245, 158, 11, 0.4);
        }

        .sh-badge-approved {
            background: rgba(16, 185, 129, 0.3);
            color: #6ee7b7;
            border: 1px solid rgba(16, 185, 129, 0.4);
        }

        .sh-badge-rejected {
            background: rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.4);
        }

        .sh-action-buttons {
            display: flex;
            gap: 8px;
            justify-content: space-between;
        }

        .sh-btn-icon-action {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            backdrop-filter: blur(5px);
        }

        .sh-btn-approve {
            background: rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .sh-btn-approve:hover {
            background: #10b981;
            color: #fff;
            transform: scale(1.1);
        }

        .sh-btn-reject {
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .sh-btn-reject:hover {
            background: #ef4444;
            color: #fff;
            transform: scale(1.1);
        }

        .sh-btn-view {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sh-btn-view:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        /* Video Modal */
        .sh-video-modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.95);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            backdrop-filter: blur(10px);
        }

        .sh-video-modal.active {
            display: flex;
            animation: fadeIn 0.3s ease-out;
        }

        .sh-modal-content {
            position: relative;
            width: 90%;
            max-width: 1000px;
            background: #000;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        .sh-modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #fff;
            font-size: 1.5rem;
            z-index: 10;
            cursor: pointer;
            background: rgba(0, 0, 0, 0.5);
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
        }

        .sh-modal-close:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(90deg);
        }

        .sh-modal-video {
            width: 100%;
            max-height: 80vh;
            outline: none;
        }

        .sh-modal-footer {
            padding: 24px;
            background: #111;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .page-header {
                margin-bottom: 20px;
            }


            .sh-stats-row {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
                margin-bottom: 24px;
            }

            .sh-stat-mini-card {
                padding: 14px;
                gap: 10px;
                border-radius: 10px;
            }

            .sh-stat-mini-icon {
                width: 36px;
                height: 36px;
                font-size: 1rem;
                border-radius: 10px;
            }

            .sh-stat-mini-card div[style*="font-size: 1.5rem"] {
                font-size: 1.2rem !important;
            }

            .sh-stat-mini-card div[style*="font-size: 0.75rem"] {
                font-size: 0.65rem !important;
            }

            .sh-management-header {
                gap: 16px;
                margin-bottom: 24px;
            }

            .sh-filter-container {
                gap: 8px;
                flex-wrap: wrap;
            }

            .sh-filter-chip {
                padding: 6px 14px;
                font-size: 13px;
                white-space: nowrap;
            }

            .sh-search-row {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .sh-search-box {
                max-width: 100%;
            }

            .sh-filter-input {
                padding: 10px 14px;
                font-size: 0.85rem;
            }

            .sh-video-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .sh-video-overlay-bottom {
                padding: 10px;
                height: 50%;
            }

            .sh-video-model-name {
                font-size: 13px;
            }

            .sh-badge {
                font-size: 9px;
                padding: 3px 6px;
            }

            .sh-video-meta-row span[style*="font-size: 11px"] {
                font-size: 9px !important;
            }

            .sh-btn-icon-action {
                width: 28px;
                height: 28px;
                border-radius: 6px;
                font-size: 0.7rem;
            }

            .sh-play-icon {
                font-size: 2rem;
            }

            .sh-duration-badge {
                font-size: 10px;
                padding: 3px 6px;
                top: 8px;
                right: 8px;
            }

            .sh-modal-content {
                width: 95%;
                border-radius: 12px;
            }

            .sh-modal-footer {
                padding: 16px;
            }
        }

        @media (max-width: 480px) {
            .page-header {
                margin-bottom: 16px;
            }

            .sh-stats-row {

                grid-template-columns: 1fr 1fr;
                gap: 10px;
                margin-bottom: 20px;
            }

            .sh-stat-mini-card {
                padding: 12px;
                gap: 8px;
            }

            .sh-stat-mini-icon {
                width: 32px;
                height: 32px;
                font-size: 0.9rem;
            }

            .sh-filter-chip {
                padding: 5px 12px;
                font-size: 12px;
                border-radius: 16px;
            }

            .sh-video-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .sh-video-card {
                aspect-ratio: 16/9;
            }

            .sh-play-icon {
                font-size: 2.5rem;
            }

            .sh-video-overlay-bottom {
                padding: 12px;
            }

            .sh-video-model-name {
                font-size: 14px;
            }

            .sh-btn-icon-action {
                width: 30px;
                height: 30px;
            }

            /* Empty state */
            div[style*="padding: 100px"] {
                padding: 60px 20px !important;
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title">{{ __('admin.content.videos.title') }}</h1>
        <p class="page-subtitle">{{ __('admin.content.videos.subtitle') }}</p>
    </div>

    <div class="sh-stats-row">
        <div class="sh-stat-mini-card">
            <div class="sh-stat-mini-icon" style="background: rgba(212, 175, 55, 0.1); color: var(--admin-gold);">
                <i class="fas fa-video"></i>
            </div>
            <div>
                <div style="font-size: 0.75rem; color: rgba(255,255,255,0.4); text-transform: uppercase; font-weight: 700;">
                    {{ __('admin.content.videos.total') }}</div>
                <div style="font-size: 1.5rem; font-weight: 800;">{{ $videos->total() }}</div>
            </div>
        </div>
        <div class="sh-stat-mini-card">
            <div class="sh-stat-mini-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <div style="font-size: 0.75rem; color: rgba(255,255,255,0.4); text-transform: uppercase; font-weight: 700;">
                    {{ __('admin.content.status.pending') }}</div>
                <div style="font-size: 1.5rem; font-weight: 800;">
                    {{ \App\Models\Video::where('status', 'pending')->count() }}</div>
            </div>
        </div>
        <div class="sh-stat-mini-card">
            <div class="sh-stat-mini-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <div style="font-size: 0.75rem; color: rgba(255,255,255,0.4); text-transform: uppercase; font-weight: 700;">
                    {{ __('admin.content.status.approved_masc') }}</div>
                <div style="font-size: 1.5rem; font-weight: 800;">
                    {{ \App\Models\Video::where('status', 'approved')->count() }}</div>
            </div>
        </div>
    </div>

    <div class="sh-management-header">
        <div class="sh-filter-container">
            <a href="{{ route('admin.content.videos') }}"
                class="sh-filter-chip {{ !request('status') ? 'active' : '' }}">{{ __('admin.content.filters.all_masc') }}</a>
            <a href="{{ route('admin.content.videos', ['status' => 'pending']) }}"
                class="sh-filter-chip {{ request('status') == 'pending' ? 'active' : '' }}">{{ __('admin.content.status.pending') }}</a>
            <a href="{{ route('admin.content.videos', ['status' => 'approved']) }}"
                class="sh-filter-chip {{ request('status') == 'approved' ? 'active' : '' }}">{{ __('admin.content.status.approved_masc') }}</a>
            <a href="{{ route('admin.content.videos', ['status' => 'rejected']) }}"
                class="sh-filter-chip {{ request('status') == 'rejected' ? 'active' : '' }}">{{ __('admin.content.status.rejected_masc') }}</a>
        </div>

        <form method="GET" class="sh-search-row">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif

            <input type="text" name="model" value="{{ request('model') }}" placeholder="{{ __('admin.content.filters.filter_by_model') }}"
                class="sh-filter-input" style="flex:1;">

            <div class="sh-search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="sh-filter-input" placeholder="{{ __('admin.content.filters.search_by_title') }}"
                    value="{{ request('search') }}" style="width: 100%; padding-left: 40px;">
            </div>

            <button type="submit" class="btn btn-primary"
                style="background: var(--admin-gold); color: #000;">{{ __('admin.content.filters.filter_btn') }}</button>
        </form>
    </div>

    @if($videos->count() > 0)
        <div class="sh-video-grid">
            @foreach($videos as $video)
                <div class="sh-video-card">
                    <div class="sh-video-preview" onclick="playVideo('{{ $video->url }}', '{{ $video->title }}')">
                        @if($video->thumbnail)
                            <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="sh-video-img">
                        @else
                            <div
                                style="width: 100%; height: 100%; background: #000; display: flex; align-items: center; justify-content: center; opacity: 0.8;">
                                <i class="fas fa-film" style="font-size: 3rem; color: rgba(255,255,255,0.2);"></i>
                            </div>
                        @endif

                        <div class="sh-play-icon">
                            <i class="fas fa-play-circle"></i>
                        </div>

                        @if($video->duration > 0)
                            <div class="sh-duration-badge">{{ $video->formatted_duration }}</div>
                        @endif

                        <div class="sh-video-overlay-bottom">
                            <div class="sh-video-model-name">{{ $video->user->name }}</div>

                            <div class="sh-video-meta-row">
                                @php
                                    $badgeClass = $video->status === 'pending' ? 'sh-badge-pending' : ($video->status === 'approved' ? 'sh-badge-approved' : 'sh-badge-rejected');
                                    $statusMap = ['pending' => __('admin.content.status.single_pending'), 'approved' => __('admin.content.status.single_approved_masc'), 'rejected' => __('admin.content.status.single_rejected_masc')];
                                @endphp
                                <span class="sh-badge {{ $badgeClass }}">{{ $statusMap[$video->status] ?? $video->status }}</span>

                                <span
                                    style="font-size: 11px; color: rgba(255,255,255,0.6);">{{ $video->created_at->diffForHumans() }}</span>
                            </div>

                            <div class="sh-action-buttons">
                                @if($video->status === 'pending')
                                    <button type="button" onclick="event.stopPropagation(); moderateVideo('approve', {{ $video->id }})"
                                        class="sh-btn-icon-action sh-btn-approve" title="Aprobar">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" onclick="event.stopPropagation(); moderateVideo('reject', {{ $video->id }})"
                                        class="sh-btn-icon-action sh-btn-reject" title="Rechazar">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @endif
                                <button type="button"
                                    onclick="event.stopPropagation(); playVideo('{{ $video->url }}', '{{ $video->title }}')"
                                    class="sh-btn-icon-action sh-btn-view" title="{{ __('admin.content.actions.view') }}">
                                    <i class="fas fa-play"></i>
                                </button>
                                @if($video->status !== 'pending')
                                    <form action="{{ route('admin.videos.delete', $video) }}" method="POST"
                                        onsubmit="return confirm('{{ __('admin.content.videos.delete_confirm') }}')" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="sh-btn-icon-action sh-btn-reject" onclick="event.stopPropagation()"
                                            title="{{ __('admin.content.actions.delete') }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="sh-pagination-container" style="margin-top: 40px; display: flex; justify-content: center;">
            {{ $videos->appends(request()->query())->links('custom.pagination') }}
        </div>
    @else
        <div style="padding: 100px; text-align: center; color: rgba(255,255,255,0.2);">
            <i class="fas fa-film" style="font-size: 4rem; opacity: 0.1; margin-bottom: 20px;"></i>
            <h3 style="color: #dab843; font-weight: 800; font-size: 24px; margin-bottom: 10px;">{{ __('admin.content.videos.no_videos_title') }}</h3>
            <p style="font-size: 16px;">{{ __('admin.content.videos.no_videos_desc') }}</p>
            <a href="{{ route('admin.content.videos') }}"
                style="margin-top: 24px; display: inline-block; color: var(--admin-gold); font-weight: 600;">{{ __('admin.content.filters.clear_filters') }}</a>
        </div>
    @endif

    <div id="videoModal" class="sh-video-modal" onclick="closeVideoModal()">
        <div class="sh-modal-content" onclick="event.stopPropagation()">
            <div class="sh-modal-close" onclick="closeVideoModal()">
                <i class="fas fa-times"></i>
            </div>
            <video id="modalVideo" src="" controls class="sh-modal-video"></video>
            <div class="sh-modal-footer">
                <h3 id="modalVideoTitle" style="color: var(--admin-gold); margin: 0; font-size: 1.1rem; font-weight: 700;">
                </h3>
            </div>
        </div>
    </div>

    <script>
        function playVideo(url, title) {
            const modal = document.getElementById('videoModal');
            const video = document.getElementById('modalVideo');
            const titleBox = document.getElementById('modalVideoTitle');

            video.src = url;
            titleBox.textContent = title || '{{ __('admin.content.misc.untitled') }}';
            modal.classList.add('active');
            video.play();
        }

        function closeVideoModal() {
            const modal = document.getElementById('videoModal');
            const video = document.getElementById('modalVideo');

            modal.classList.remove('active');
            video.pause();
            video.src = '';
        }

        function moderateVideo(action, id) {
            const url = action === 'approve'
                ? "{{ route('admin.videos.approve', ':id') }}"
                : "{{ route('admin.videos.reject', ':id') }}";

            const finalUrl = url.replace(':id', id);

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = finalUrl;

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = "{{ csrf_token() }}";

            form.appendChild(csrf);
            document.body.appendChild(form);
            form.submit();
        }

        // Close modal on Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeVideoModal();
        });
    </script>
@endsection