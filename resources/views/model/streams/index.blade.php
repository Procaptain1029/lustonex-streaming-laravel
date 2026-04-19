@extends('layouts.model')

@section('title', __('model.streams.index.title'))

@section('breadcrumb')
    <a href="{{ route('model.dashboard') }}" class="breadcrumb-item">{{ __('model.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('model.streams.index.title') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Model Streams Professional Styling ----- */

        .page-header {
            padding-top: 32px;
            margin-bottom: 28px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            flex-wrap: wrap;
            gap: 16px;
        }

        /* Estilos de encabezado heredados del layout model */

        /* Estilos de subtítulo heredados */

        .sh-btn-create {
            padding: 12px 28px;
            font-size: 16px;
            font-weight: 700;
            border-radius: 12px;
            background: var(--model-gold);
            color: #000;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.2);
            white-space: nowrap;
        }

        .sh-btn-create:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.3);
            color: #000;
            background: var(--model-gold);
        }

        /* Active Stream Hero */
        .sh-active-hero {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.2), rgba(0, 0, 0, 0.8));
            backdrop-filter: blur(20px);
            border: 1px solid rgba(220, 53, 69, 0.4);
            border-radius: 24px;
            padding: 32px;
            margin-bottom: 40px;
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 32px;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .sh-active-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(220, 53, 69, 0.8), transparent);
        }

        .sh-live-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #dc3545;
            color: #fff;
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 16px;
            box-shadow: 0 0 15px rgba(220, 53, 69, 0.5);
        }

        .sh-live-pulse {
            width: 8px;
            height: 8px;
            background: #fff;
            border-radius: 50%;
            animation: pulse 1.5s infinite;
        }

        /* Stats Grid — 3 cols desktop */
        .sh-stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 32px;
        }

        .sh-stat-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: transform 0.2s;
            backdrop-filter: blur(10px);
            min-width: 0;
        }

        .sh-stat-card:hover {
            transform: translateY(-4px);
            border-color: rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.04);
        }

        .sh-stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            flex-shrink: 0;
        }

        /* Filter Chips */
        .sh-filters {
            display: flex;
            gap: 10px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .sh-filter-chip {
            padding: 8px 20px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            background: transparent;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .sh-filter-chip:hover,
        .sh-filter-chip.active {
            background: #fff;
            color: #000;
            border-color: #fff;
        }

        /* Streams List (Horizontal) */
        .sh-streams-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 40px;
        }

        .sh-stream-item {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            text-decoration: none;
            color: inherit;
        }

        .sh-stream-item:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(212, 175, 55, 0.2);
            transform: translateX(8px);
        }

        .sh-item-main {
            display: flex;
            align-items: center;
            gap: 24px;
            flex: 1;
            min-width: 0;
        }

        .sh-status-pill {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .sh-status-pill.live { 
            background: rgba(220, 53, 69, 0.1); 
            color: #ff4757; 
            border: 1px solid rgba(220, 53, 69, 0.2);
            box-shadow: 0 0 10px rgba(220, 53, 69, 0.1);
        }
        
        .sh-status-pill.ended { 
            background: rgba(255, 255, 255, 0.05); 
            color: rgba(255, 255, 255, 0.4); 
            border: 1px solid rgba(255, 255, 255, 0.1); 
        }

        .sh-item-info {
            flex: 1;
            min-width: 0;
        }

        .sh-item-title {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            margin: 0 0 4px 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sh-item-meta {
            display: flex;
            gap: 20px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.4);
        }

        .sh-item-meta span {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .sh-item-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .sh-empty-state {
            text-align: center;
            padding: 60px 20px;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 20px;
            border: 2px dashed rgba(255, 255, 255, 0.1);
        }

        @keyframes pulse {
            0%   { opacity: 1; }
            50%  { opacity: 0.5; }
            100% { opacity: 1; }
        }

        /* ---- Tablet (≤ 900px) ---- */
        @media (max-width: 900px) {
            .sh-active-hero {
                grid-template-columns: 1fr;
                padding: 20px;
                gap: 20px;
                margin-bottom: 28px;
            }

            .page-header {
                flex-direction: column;
                align-items: stretch;
                padding-top: 20px;
                margin-bottom: 20px;
            }

            .sh-btn-create {
                width: 100%;
                justify-content: center;
            }

            .sh-stats-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 10px;
                margin-bottom: 20px;
            }

            .sh-stat-card {
                flex-direction: column;
                align-items: flex-start;
                padding: 14px 12px;
                gap: 8px;
            }

            .sh-stat-icon {
                width: 36px;
                height: 36px;
                font-size: 15px;
            }
        }

        /* ---- Móvil (≤ 768px) ---- */
        @media (max-width: 768px) {
            /* Estilos responsivos de encabezado heredados */

            /* Active hero buttons stack */
            .sh-active-hero-buttons {
                flex-direction: column !important;
                gap: 10px !important;
            }

            .sh-active-hero-buttons .sh-btn-create {
                width: 100%;
                justify-content: center;
            }

            /* Live hero stats */
            .sh-hero-stats {
                gap: 16px !important;
            }

            /* Streams: List column improvements */
            .sh-streams-list {
                gap: 10px;
            }

            .sh-stream-item {
                flex-direction: column;
                align-items: stretch;
                padding: 16px;
                gap: 16px;
            }

            .sh-stream-item:hover {
                transform: translateY(-4px);
            }

            .sh-item-main {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .sh-item-meta {
                flex-direction: row;
                gap: 16px;
                flex-wrap: wrap;
            }

            .sh-item-actions {
                justify-content: flex-end;
                border-top: 1px solid rgba(255, 255, 255, 0.05);
                padding-top: 12px;
            }

            .sh-empty-state {
                padding: 40px 16px;
            }

            .sh-filters {
                gap: 8px;
                margin-bottom: 16px;
            }

            .sh-filter-chip {
                padding: 6px 14px;
                font-size: 12px;
            }
        }

        /* ---- Móvil pequeño (≤ 480px) ---- */
        @media (max-width: 480px) {
            /* Estilos responsivos heredados */

            .sh-stats-grid {
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .sh-stat-card {
                flex-direction: row;
                align-items: center;
                padding: 12px;
                gap: 12px;
            }

            .sh-stat-icon {
                width: 36px;
                height: 36px;
            }
        }
    </style>
@endsection

@section('content')

    <div class="page-header">
        <div>
            <h1 class="page-title">{{ __('model.streams.index.title') }}</h1>
            <p class="page-subtitle">{{ __('model.streams.index.subtitle') }}</p>
        </div>
        <a href="{{ route('model.streams.go-live') }}" class="sh-btn-create">
            <i class="fas fa-video"></i> {{ __('model.streams.index.btn_create') }}
        </a>
    </div>

    @if($activeStream)
        <div class="sh-active-hero">
            <div>
                <div class="sh-live-pill">
                    @if($activeStream->status === 'pending')
                        <span class="sh-live-pulse" style="background:#f59e0b;"></span> {{ __('model.streams.index.preparing_now') }}
                    @else
                        <span class="sh-live-pulse"></span> {{ __('model.streams.index.live_now') }}
                    @endif
                </div>
                <h2 style="font-size: 28px; font-weight: 700; color: #fff; margin-bottom: 24px; line-height: 1.2;">
                    {{ $activeStream->title }}
                </h2>

                <div class="sh-hero-stats" style="display: flex; gap: 24px; margin-bottom: 24px; flex-wrap: wrap;">
                    <div>
                        <div style="font-size: 22px; font-weight: 800; color: #fff;">
                            {{ number_format($activeStream->viewers_count) }}</div>
                        <div style="font-size: 11px; text-transform: uppercase; color: rgba(255,255,255,0.5);">{{ __('model.streams.index.viewers') }}
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 22px; font-weight: 800; color: #fff;">
                            @if($activeStream->started_at)
                                {{ $activeStream->started_at->diffForHumans(null, true) }}
                            @else
                                —
                            @endif
                        </div>
                        <div style="font-size: 11px; text-transform: uppercase; color: rgba(255,255,255,0.5);">{{ __('model.streams.index.elapsed_time') }}</div>
                    </div>
                </div>

                <div class="sh-active-hero-buttons" style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <a href="{{ route('model.streams.admin', $activeStream) }}" class="sh-btn-create"
                        style="background: #fff; color: #000;">
                        <i class="fas fa-cog"></i> {{ __('model.streams.index.manage') }}
                    </a>
                    <form action="{{ route('model.streams.end', $activeStream) }}" method="POST">
                        @csrf
                        <button type="submit" class="sh-btn-create"
                            style="background: rgba(220,53,69,0.1); color: #dc3545; border: 1px solid rgba(220,53,69,0.3); box-shadow: none;"
                            onclick="return confirm('{{ __('model.streams.index.confirm_end') }}')">
                            <i class="fas fa-stop"></i> {{ __('model.streams.index.end') }}
                        </button>
                    </form>
                </div>
            </div>

            <div
                style="aspect-ratio: 16/9; background: #000; border-radius: 16px; overflow: hidden; border: 1px solid rgba(255,255,255,0.1); position: relative;">
                <video id="miniLivePlayer" muted autoplay playsinline
                    style="width: 100%; height: 100%; object-fit: cover;"></video>
                <div
                    style="position: absolute; top: 12px; right: 12px; background: rgba(0,0,0,0.6); padding: 4px 8px; border-radius: 6px; font-size: 10px; font-weight: 700; color: #fff;">
                    {{ __('model.streams.index.preview') }}</div>
            </div>
        </div>
    @endif

    <div class="sh-stats-grid">
        <div class="sh-stat-card">
            <div class="sh-stat-icon" style="background: rgba(212, 175, 55, 0.1); color: var(--model-gold);">
                <i class="fas fa-broadcast-tower"></i>
            </div>
            <div>
                <div style="font-size: 24px; font-weight: 800; color: #fff;">{{ $streams->total() }}</div>
                <div style="font-size: 12px; color: rgba(255,255,255,0.5); text-transform: uppercase;">{{ __('model.streams.index.total_streams') }}
                </div>
            </div>
        </div>
        <div class="sh-stat-card">
            <div class="sh-stat-icon" style="background: rgba(0, 123, 255, 0.1); color: #0d6efd;">
                <i class="fas fa-eye"></i>
            </div>
            <div>
                <div style="font-size: 24px; font-weight: 800; color: #fff;">
                    {{ number_format($streams->sum('viewers_count')) }}</div>
                <div style="font-size: 12px; color: rgba(255,255,255,0.5); text-transform: uppercase;">{{ __('model.streams.index.historical_audience') }}
                </div>
            </div>
        </div>
        <div class="sh-stat-card">
            <div class="sh-stat-icon" style="background: rgba(40, 167, 69, 0.1); color: #198754;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div>
                <div style="font-size: 24px; font-weight: 800; color: #fff;">
                    {{ $streams->count() > 0 ? $streams->first()->created_at->format('d M') : '-' }}</div>
                <div style="font-size: 12px; color: rgba(255,255,255,0.5); text-transform: uppercase;">{{ __('model.streams.index.last_broadcast') }}</div>
            </div>
        </div>
    </div>

    <div class="sh-filters">
        <a href="{{ route('model.streams.index') }}"
            class="sh-filter-chip {{ !request('status') ? 'active' : '' }}">
            {{ __('model.streams.index.filter_all') }}
        </a>
        <a href="{{ route('model.streams.index', ['status' => 'live']) }}"
            class="sh-filter-chip {{ request('status') == 'live' ? 'active' : '' }}">
            {{ __('model.streams.index.filter_live') }}
        </a>
        <a href="{{ route('model.streams.index', ['status' => 'ended']) }}"
            class="sh-filter-chip {{ request('status') == 'ended' ? 'active' : '' }}">
            {{ __('model.streams.index.filter_ended') }}
        </a>
    </div>

    @if($streams->count() > 0)
        <div class="sh-streams-list">
            @foreach($streams as $stream)
                <div class="sh-stream-item">
                    <a href="{{ route('model.streams.show', $stream) }}" class="sh-item-main" style="text-decoration: none;">
                        <div class="sh-item-status">
                            <span class="sh-status-pill {{ $stream->status == 'live' ? 'live' : 'ended' }}">
                                {{ $stream->status == 'live' ? __('model.streams.index.status_live') : __('model.streams.index.status_ended') }}
                            </span>
                        </div>
                        
                        <div class="sh-item-info">
                            <h3 class="sh-item-title" title="{{ $stream->title }}">{{ $stream->title }}</h3>
                            <div class="sh-item-meta">
                                <span>
                                    <i class="fas fa-calendar" style="color: var(--model-gold);"></i>
                                    {{ $stream->created_at->format('d M, Y') }}
                                </span>
                                <span>
                                    <i class="fas fa-clock" style="color: var(--model-gold);"></i>
                                    {{ $stream->formatted_duration }}
                                </span>
                            </div>
                        </div>
                    </a>

                    <div class="sh-item-actions">
                        <a href="{{ route('model.streams.show', $stream) }}" class="sh-btn-icon" title="{{ __('model.streams.index.view_details') }}">
                            <i class="fas fa-chart-line"></i>
                        </a>
                        
                        @if($stream->status != 'ended')
                            <a href="{{ route('model.streams.admin', $stream) }}" class="sh-btn-icon" title="{{ __('model.streams.index.manage') }}">
                                <i class="fas fa-cog"></i>
                            </a>
                        @endif

                        <form action="{{ route('model.streams.destroy', $stream) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="sh-btn-icon delete"
                                onclick="return confirm('{{ __('model.streams.index.confirm_delete') }}')" title="{{ __('model.streams.index.end') }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 40px;">
            {{ $streams->links('custom.pagination') }}
        </div>
    @else
        <div class="sh-empty-state">
            <div style="font-size: 48px; color: rgba(255,255,255,0.1); margin-bottom: 20px;">
                <i class="fas fa-video-slash"></i>
            </div>
            <h3 style="color: #dfc04e; margin-bottom: 8px;">{{ __('model.streams.index.empty_title') }}</h3>
            <p style="color: rgba(255,255,255,0.5); margin-bottom: 0;">{{ __('model.streams.index.empty_subtitle') }}</p>
        </div>
    @endif

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if($activeStream && $activeStream->status !== 'pending')
                const video = document.getElementById('miniLivePlayer');
                const streamUrl = "{{ asset('hls/live/' . auth()->user()->profile->stream_key . '/index.m3u8') }}";

                if (Hls.isSupported()) {
                    const hls = new Hls({
                        lowLatencyMode: true,
                        liveSyncDurationCount: 2,
                        liveMaxLatencyDurationCount: 4,
                        maxBufferLength: 3,
                        maxMaxBufferLength: 6,
                        backBufferLength: 10,
                        highBufferWatchdogPeriod: 1,
                    });
                    hls.loadSource(streamUrl);
                    hls.attachMedia(video);
                    hls.on(Hls.Events.MANIFEST_PARSED, function () {
                        video.play().catch(e => console.log("Autoplay blocked or error:", e));
                    });
                } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                    video.src = streamUrl;
                    video.addEventListener('loadedmetadata', function () {
                        video.play().catch(e => console.log("Autoplay blocked or error:", e));
                    });
                }
            @endif
        });
    </script>
@endsection