@extends('layouts.admin')

@section('title', __('admin.streams.moderate.title'))

@section('styles')
    <style>
        /* ----- Stream Moderation Wall Styling ----- */

        .mod-container {
            padding-bottom: 40px;
        }

        /* Hero / Header */
        .mod-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 40px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .mod-title h1 {
            margin: 0;
        }

        .mod-title p {
            margin: 0;
            max-width: 600px;
        }

        .btn-mod-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-mod-primary:hover {
            background: rgba(212, 175, 55, 0.1) !important;
            transform: translateY(-2px);
        }

        /* Grid */
        .mod-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
        }

        .mod-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .mod-card:hover {
            transform: translateY(-5px);
            border-color: rgba(212, 175, 55, 0.3);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        }

        .mod-card-link {
            display: block;
            width: 100%;
            text-decoration: none;
            cursor: pointer;
        }

        .mod-visual {
            position: relative;
            aspect-ratio: 16/9;
            background: #000;
            overflow: hidden;
        }

        .mod-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.9;
            transition: opacity 0.3s;
        }

        .mod-card:hover .mod-video {
            opacity: 1;
        }

        .mod-live-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.5px;
            z-index: 10;
            background: rgba(239, 68, 68, 0.9);
            color: #fff;
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

        .mod-overlay-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 40px 16px 16px 16px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0) 100%);
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }

        .mod-name {
            font-size: 16px;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.8);
        }

        .mod-stats-row {
            display: flex;
            gap: 12px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 4px;
        }

        .mod-stats-row i {
            color: var(--admin-gold);
            margin-right: 4px;
        }

        .mod-actions-bar {
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.02);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .btn-stop-mini {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #ef4444;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-stop-mini:hover {
            background: #ef4444;
            color: #fff;
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .empty-state {
            text-align: center;
            padding: 5rem;
            background: rgba(255, 255, 255, 0.02);
            border: 2px dashed rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            margin-top: 2rem;
        }

        .empty-state i {
            font-size: 4rem;
            color: rgba(255, 255, 255, 0.1);
            margin-bottom: 24px;
        }

        /* Modal */
        #modModal {
            backdrop-filter: blur(10px);
        }

        .mod-modal-content {
            display: flex;
            flex-direction: column;
            width: 90%;
            max-width: 1000px;
            background: #000;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.6);
        }

        @media (max-width: 768px) {
            .mod-container {
                padding-top: 20px;
                padding-bottom: 24px;
            }

            .mod-header {
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 24px;
                gap: 12px;
            }

            .mod-title h1 {
                font-size: 28px;
                margin-bottom: 8px;
            }

            .mod-title p {
                font-size: 14px;
            }

            .btn-mod-primary {
                padding: 8px 16px;
                font-size: 13px;
                width: 100%;
                justify-content: center;
            }

            .mod-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .mod-card {
                border-radius: 12px;
            }

            .mod-overlay-info {
                padding: 30px 12px 12px 12px;
            }

            .mod-name {
                font-size: 14px;
            }

            .mod-stats-row {
                font-size: 11px;
                gap: 10px;
            }

            .mod-live-badge {
                font-size: 10px;
                padding: 3px 8px;
                border-radius: 4px;
                top: 8px;
                left: 8px;
            }

            .mod-actions-bar {
                padding: 10px 12px;
            }

            .btn-stop-mini {
                width: 32px;
                height: 32px;
                border-radius: 6px;
                font-size: 0.8rem;
            }

            .empty-state {
                padding: 3rem 1.5rem;
                border-radius: 16px;
            }

            .empty-state i {
                font-size: 3rem;
                margin-bottom: 16px;
            }

            .empty-state h2 {
                font-size: 20px !important;
            }

            .empty-state p {
                font-size: 14px !important;
            }

            /* Modal mobile */
            .mod-modal-content {
                width: 95%;
                border-radius: 12px;
            }

            #modModal div[style*="padding: 16px 24px"] {
                padding: 12px 16px !important;
            }

            #modModal h3 {
                font-size: 14px !important;
            }

            #modModal .btn-stop-mini[style*="width: auto"] {
                padding: 6px 12px !important;
                font-size: 12px !important;
                height: 32px !important;
            }
        }

        @media (max-width: 480px) {
            .mod-container {
                padding-top: 12px;
            }

            .mod-title h1 {
                font-size: 24px;
            }

            .mod-title p {
                font-size: 13px;
            }

            .mod-card {
                border-radius: 10px;
            }

            .empty-state {
                padding: 2.5rem 1rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="mod-container">
        <div class="mod-header">
            <div class="mod-title">
                <h1 class="page-title">{{ __('admin.streams.moderate.header') }}</h1>
                <p class="page-subtitle">{{ __('admin.streams.moderate.subtitle') }}</p>
            </div>
            <a href="{{ route('admin.streams.index') }}" class="btn-mod-primary"
                style="background: transparent; border: 1px solid rgba(255,255,255,0.2); color: #fff;">
                <i class="fas fa-list"></i> {{ __('admin.streams.list_button') }}
            </a>
        </div>

        @if($activeStreams->count() > 0)
            <div class="mod-grid">
                @foreach($activeStreams as $stream)
                    <div class="mod-card">
                        <div class="mod-card-link"
                            onclick="openModModal('{{ $stream->id }}', '{{ route('streams.show', $stream) }}?mode=moderation', '{{ $stream->user->name }}')">
                            <div class="mod-visual">
                                <video id="player-{{ $stream->id }}" class="mod-video" muted autoplay playsinline loop
                                    poster="{{ $stream->thumbnail ? asset('storage/' . $stream->thumbnail) : '' }}"
                                    data-url="{{ asset('hls/live/' . $stream->user->profile->stream_key . '/index.m3u8') }}">
                                </video>

                                <div class="mod-live-badge">{{ __('admin.streams.badges.live') }}</div>

                                <div class="mod-overlay-info">
                                    <span class="mod-name">{{ $stream->user->profile->display_name ?? $stream->user->name }}</span>
                                    <div class="mod-stats-row">
                                        <span><i class="fas fa-eye"></i> {{ number_format($stream->viewers_count) }}</span>
                                        <span><i class="fas fa-clock"></i>
                                            {{ $stream->started_at->diffForHumans(null, true) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mod-actions-bar">
                            <form action="{{ route('admin.streams.end', $stream) }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit" class="btn-stop-mini" title="{{ __('admin.streams.actions.end_trans') }}"
                                    onclick="return confirm('{{ __('admin.streams.actions.end_confirm_trans') }}')">
                                    <i class="fas fa-stop"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-video-slash"></i>
                <h2 style="color: #fff; font-size: 24px; font-weight: 700; margin-bottom: 16px;">{{ __('admin.streams.empty.mod_title') }}
                </h2>
                <p style="color: rgba(255,255,255,0.5); font-size: 16px;">{{ __('admin.streams.empty.mod_desc') }}
                </p>
            </div>
        @endif
    </div>


    <div id="modModal"
        style="display: none; position: fixed; inset: 0; z-index: 1000; background: rgba(0,0,0,0.9); justify-content: center; align-items: center;">
        <div class="mod-modal-content">

            <div
                style="padding: 16px 24px; display: flex; justify-content: space-between; align-items: center; background: #111; border-bottom: 1px solid rgba(255,255,255,0.1);">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <h3 id="modModalTitle" style="margin: 0; color: white; font-size: 18px; font-weight: 700;">{{ __('admin.streams.actions.moderating') }}
                    </h3>
                    <span
                        style="background: #ef4444; color: #fff; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 800;">{{ __('admin.streams.badges.live') }}</span>
                </div>

                <div style="display: flex; gap: 16px; align-items: center;">
                    <form id="modFormStop" action="" method="POST" style="display: inline; margin:0;">
                        @csrf
                        <button type="submit" class="btn-stop-mini"
                            style="width: auto; padding: 8px 16px; gap: 8px; height: 36px; font-size: 13px; font-weight: 600;"
                            onclick="return confirm('{{ __('admin.streams.actions.end_confirm_trans') }}')">
                            <i class="fas fa-stop"></i> {{ __('admin.streams.actions.end_stream') }}
                        </button>
                    </form>

                    <button onclick="closeModModal()"
                        style="background: rgba(255,255,255,0.1); border: none; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div style="position: relative; aspect-ratio: 16/9; background: #000;">
                <iframe id="modIframe" src="" style="width: 100%; height: 100%; border: none;"></iframe>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const players = document.querySelectorAll('video[id^="player-"]');

            players.forEach(video => {
                const url = video.dataset.url;

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
                    hls.loadSource(url);
                    hls.attachMedia(video);
                    hls.on(Hls.Events.MANIFEST_PARSED, function () {
                        video.play().catch(e => console.log("Autoplay prevented:", e));
                    });
                } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                    video.src = url;
                    video.addEventListener('loadedmetadata', function () {
                        video.play().catch(e => console.log("Autoplay prevented:", e));
                    });
                }
            });
        });

        function openModModal(streamId, url, userName) {
            const modal = document.getElementById('modModal');
            const iframe = document.getElementById('modIframe');
            const title = document.getElementById('modModalTitle');
            const formStop = document.getElementById('modFormStop');

            title.textContent = '{{ __('admin.streams.actions.moderating') }}: ' + userName;
            iframe.src = url;

            // Update actions forms
            formStop.action = "/admin/streams/" + streamId + "/end";

            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeModModal() {
            const modal = document.getElementById('modModal');
            const iframe = document.getElementById('modIframe');

            modal.style.display = 'none';
            iframe.src = '';
            document.body.style.overflow = 'auto';
        }

        // Close modal on Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeModModal();
        });

    </script>
@endsection