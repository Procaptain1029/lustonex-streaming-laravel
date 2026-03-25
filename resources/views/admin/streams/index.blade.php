@extends('layouts.admin')

@section('title', __('admin.streams.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.streams.breadcrumb') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Stream Moderation Professional Styling ----- */

        /* 1. Hero / Title */
        .page-header {
            margin-bottom: 32px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            flex-wrap: wrap;
            gap: 20px;
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
            flex-wrap: wrap;
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
            min-width: 250px;
            position: relative;
        }

        .sh-search-box i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.4);
        }

        /* 4. Stream Grid */
        .sh-stream-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
        }

        .sh-stream-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.2s ease-out;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .sh-stream-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border-color: rgba(212, 175, 55, 0.2);
        }

        .sh-stream-preview {
            position: relative;
            width: 100%;
            aspect-ratio: 16/9;
            background: #000;
            overflow: hidden;
        }

        .sh-stream-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
            opacity: 0.9;
        }

        .sh-stream-card:hover .sh-stream-img {
            transform: scale(1.05);
            opacity: 1;
        }

        /* Live Indicator Pulse */
        .sh-live-indicator {
            position: absolute;
            top: 12px;
            left: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 4px 8px;
            background: rgba(239, 68, 68, 0.9);
            color: #fff;
            font-size: 11px;
            font-weight: 800;
            border-radius: 4px;
            z-index: 10;
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.4);
            animation: pulse-red 2s infinite;
        }

        @keyframes pulse-red {
            0% {
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
            }

            70% {
                box-shadow: 0 0 0 6px rgba(239, 68, 68, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
            }
        }

        .sh-viewer-count {
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
            z-index: 10;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* 5. Bottom Overlay */
        .sh-stream-overlay-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 50%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.95) 0%, rgba(0, 0, 0, 0.6) 60%, rgba(0, 0, 0, 0) 100%);
            padding: 16px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            z-index: 20;
        }

        .sh-stream-model-name {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 2px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .sh-stream-title {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 12px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sh-stream-meta-row {
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

        .sh-badge-live {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .sh-badge-ended {
            background: rgba(156, 163, 175, 0.2);
            color: #9ca3af;
            border: 1px solid rgba(156, 163, 175, 0.3);
        }

        .sh-badge-scheduled {
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .sh-action-buttons {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
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

        .sh-btn-stop {
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .sh-btn-stop:hover {
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
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 20px;
                gap: 12px;
            }

            .page-header .btn {

                padding: 8px 16px;
                font-size: 13px;
                width: 100%;
                justify-content: center;
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

            .sh-filter-input,
            .sh-search-box {
                width: 100%;
            }

            .sh-filter-input {
                padding: 10px 14px;
                font-size: 0.85rem;
            }

            .sh-stream-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .sh-stream-overlay-bottom {
                padding: 12px;
            }

            .sh-stream-model-name {
                font-size: 14px;
            }

            .sh-stream-title {
                font-size: 12px;
                margin-bottom: 8px;
            }

            .sh-badge {
                font-size: 10px;
                padding: 3px 6px;
            }

            .sh-stream-meta-row span[style*="font-size: 11px"] {
                font-size: 10px !important;
            }

            .sh-btn-icon-action {
                width: 28px;
                height: 28px;
                border-radius: 6px;
                font-size: 0.75rem;
            }

            .sh-live-indicator {
                font-size: 10px;
                padding: 3px 6px;
                gap: 4px;
            }

            .sh-viewer-count {
                font-size: 10px;
                padding: 3px 6px;
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

            .sh-stream-card {
                border-radius: 12px;
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
        <div>
            <h1 class="page-title">{{ __('admin.streams.title') }}</h1>
            <p class="page-subtitle">{{ __('admin.streams.subtitle') }}</p>
        </div>
        <a href="{{ route('admin.streams.moderate') }}" class="btn"
            style="background: var(--admin-gold); color: #000; box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);">
            <i class="fas fa-desktop" style="margin-right: 8px;"></i> {{ __('admin.streams.wall_button') }}
        </a>
    </div>

    <div class="sh-stats-row">
        <div class="sh-stat-mini-card">
            <div class="sh-stat-mini-icon" style="background: rgba(212, 175, 55, 0.1); color: var(--admin-gold);">
                <i class="fas fa-video"></i>
            </div>
            <div>
                <div style="font-size: 0.75rem; color: rgba(255,255,255,0.4); text-transform: uppercase; font-weight: 700;">
                    {{ __('admin.streams.stats.total') }}</div>
                <div style="font-size: 1.5rem; font-weight: 800;">{{ $stats['total'] }}</div>
            </div>
        </div>
        <div class="sh-stat-mini-card">
            <div class="sh-stat-mini-icon" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                <i class="fas fa-broadcast-tower"></i>
            </div>
            <div>
                <div style="font-size: 0.75rem; color: rgba(255,255,255,0.4); text-transform: uppercase; font-weight: 700;">
                    {{ __('admin.streams.stats.live') }}</div>
                <div style="font-size: 1.5rem; font-weight: 800;">{{ $stats['active'] }}</div>
            </div>
        </div>
        <div class="sh-stat-mini-card">
            <div class="sh-stat-mini-icon" style="background: rgba(156, 163, 175, 0.1); color: #9ca3af;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <div style="font-size: 0.75rem; color: rgba(255,255,255,0.4); text-transform: uppercase; font-weight: 700;">
                    {{ __('admin.streams.stats.ended') }}</div>
                <div style="font-size: 1.5rem; font-weight: 800;">{{ $stats['ended'] }}</div>
            </div>
        </div>
        <div class="sh-stat-mini-card">
            <div class="sh-stat-mini-icon" style="background: rgba(59, 130, 246, 0.1); color: #60a5fa;">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div style="font-size: 0.75rem; color: rgba(255,255,255,0.4); text-transform: uppercase; font-weight: 700;">
                    {{ __('admin.streams.stats.viewers') }}</div>
                <div style="font-size: 1.5rem; font-weight: 800;">{{ $stats['total_viewers'] }}</div>
            </div>
        </div>
    </div>

    <div class="sh-management-header">
        <div class="sh-filter-container">
            <a href="{{ route('admin.streams.index') }}"
                class="sh-filter-chip {{ !request('status') ? 'active' : '' }}">{{ __('admin.streams.filters.all') }}</a>
            <a href="{{ route('admin.streams.index', ['status' => 'live']) }}"
                class="sh-filter-chip {{ request('status') == 'live' ? 'active' : '' }}">{{ __('admin.streams.filters.live') }}</a>
            <a href="{{ route('admin.streams.index', ['status' => 'scheduled']) }}"
                class="sh-filter-chip {{ request('status') == 'scheduled' ? 'active' : '' }}">{{ __('admin.streams.filters.scheduled') }}</a>
            <a href="{{ route('admin.streams.index', ['status' => 'ended']) }}"
                class="sh-filter-chip {{ request('status') == 'ended' ? 'active' : '' }}">{{ __('admin.streams.filters.ended') }}</a>
        </div>

        <form method="GET" class="sh-search-row">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif

            <div class="sh-search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="sh-filter-input" placeholder="{{ __('admin.streams.filters.search_placeholder') }}"
                    value="{{ request('search') }}" style="width: 100%; padding-left: 40px;">
            </div>

            <button type="submit" class="btn"
                style="background: var(--admin-gold); color: #000;">{{ __('admin.streams.filters.filter_button') }}</button>
        </form>
    </div>

    @if($streams->count() > 0)
        <div class="sh-stream-grid">
            @foreach($streams as $stream)
                <div class="sh-stream-card">
                    <div class="sh-stream-preview">
                        @if($stream->thumbnail)
                            <img src="{{ asset('storage/' . $stream->thumbnail) }}" alt="Thumbnail" class="sh-stream-img">
                        @else
                            <div
                                style="width: 100%; height: 100%; background: #000; display: flex; align-items: center; justify-content: center; opacity: 0.8;">
                                <i class="fas fa-video" style="font-size: 3rem; color: rgba(255,255,255,0.2);"></i>
                            </div>
                        @endif

                        @if($stream->status === 'live')
                            <div class="sh-live-indicator">
                                <span style="width: 8px; height: 8px; background: #fff; border-radius: 50%;"></span>
                                {{ __('admin.streams.badges.live') }}
                            </div>
                        @endif

                        <div class="sh-viewer-count">
                            <i class="fas fa-eye" style="font-size: 10px;"></i>
                            {{ $stream->viewers_count ?? 0 }}
                        </div>

                        <div class="sh-stream-overlay-bottom">
                            <div class="sh-stream-model-name">{{ $stream->user->name ?? 'N/A' }}</div>
                            <div class="sh-stream-title">{{ $stream->title ?? __('admin.streams.actions.untitled') }}</div>

                            <div class="sh-stream-meta-row">
                                @if($stream->status === 'live')
                                    <span class="sh-badge sh-badge-live">{{ __('admin.streams.badges.live_badge') }}</span>
                                @elseif($stream->status === 'ended')
                                    <span class="sh-badge sh-badge-ended">{{ __('admin.streams.badges.ended') }}</span>
                                @else
                                    <span class="sh-badge sh-badge-scheduled">{{ __('admin.streams.badges.scheduled') }}</span>
                                @endif

                                <span style="font-size: 11px; color: rgba(255,255,255,0.6);">
                                    @if($stream->started_at && $stream->status === 'live')
                                        {{ $stream->started_at->diffInMinutes(now()) }} min
                                    @elseif($stream->started_at)
                                        {{ $stream->started_at->format('d/m H:i') }}
                                    @endif
                                </span>
                            </div>

                            <div class="sh-action-buttons">
                                @if($stream->status === 'live')
                                    <a href="{{ route('admin.streams.moderate') }}" class="sh-btn-icon-action sh-btn-view"
                                        title="{{ __('admin.streams.actions.view_mod') }}">
                                        <i class="fas fa-desktop"></i>
                                    </a>
                                    <form action="{{ route('admin.streams.end', $stream) }}" method="POST"
                                        onsubmit="return confirm('{{ __('admin.streams.actions.end_confirm') }}')" style="margin:0;">
                                        @csrf
                                        <button type="submit" class="sh-btn-icon-action sh-btn-stop" title="{{ __('admin.streams.actions.end_stream') }}">
                                            <i class="fas fa-stop"></i>
                                        </button>
                                    </form>
                                @else
                                    <span style="font-size: 12px; color: rgba(255,255,255,0.3); align-self: center;">{{ __('admin.streams.badges.historical') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="sh-pagination-container" style="margin-top: 40px; display: flex; justify-content: center;">
            {{ $streams->appends(request()->query())->links('custom.pagination') }}
        </div>
    @else
        <div style="padding: 100px; text-align: center; color: rgba(255,255,255,0.2);">
            <i class="fas fa-broadcast-tower" style="font-size: 4rem; opacity: 0.1; margin-bottom: 20px;"></i>
            <h3 style="color: #dab843; font-weight: 800; font-size: 24px; margin-bottom: 10px;">{{ __('admin.streams.empty.title') }}</h3>
            <p style="font-size: 16px;">{{ __('admin.streams.empty.desc') }}</p>
            <a href="{{ route('admin.streams.index') }}"
                style="margin-top: 24px; display: inline-block; color: var(--admin-gold); font-weight: 600;">{{ __('admin.streams.filters.clear') }}</a>
        </div>
    @endif
@endsection