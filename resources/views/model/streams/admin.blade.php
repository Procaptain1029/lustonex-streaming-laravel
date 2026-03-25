@extends('layouts.model')

@section('title', __('model.streams.admin.title') . ' - ' . $stream->title)

@section('breadcrumb')
    <a href="{{ route('model.dashboard') }}" class="breadcrumb-item">{{ __('model.streams.admin.dashboard') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('model.streams.index') }}" class="breadcrumb-item">{{ __('model.streams.admin.my_streams') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('model.streams.admin.admin_prefix') }} {{ Str::limit($stream->title, 20) }}</span>
@endsection

@section('styles')
    <style>
        :root {
            --twitch-bg: #0e0e10;
            --twitch-panel: #18181b;
            --twitch-border: #222226;
            --accent-purple: #9146FF;
            --accent-gold: #d4af37;
            --text-main: #efeff1;
            --text-muted: #adadb8;
        }

        body {
            background-color: var(--twitch-bg);
            /* Ocultar scroll general en desktop si se puede manejar interno */
        }

        /* Ocultar header original y sidebar v2 para aprovechar 100vh, si lo deseamos. 
           Por ahora adaptamos el contenido dentro del layout principal */
        
        .admin-wrapper {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 100px); /* Ajustando un poco más el espacio vertical */
            padding: 1rem 0 0 0; /* Padding top para separar de la barra */
            margin: -1rem -2rem 0 -2rem; /* Reduce el margen negativo arriba */
            background: var(--twitch-bg);
            color: var(--text-main);
            overflow: hidden;
        }

        /* TOP STATS BAR */
        .top-stats-bar {
            background: var(--twitch-panel);
            border-bottom: 2px solid var(--twitch-border);
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 50px;
            flex-shrink: 0;
        }

        .top-stats-group {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .stat-icon { color: var(--text-muted); }
        .stat-value { color: var(--text-main); font-weight: 700; }
        .text-live-red { color: #f84949; }

        /* MAIN GRID */
        .twitch-grid {
            display: grid;
            grid-template-columns: 1fr 340px 340px;
            height: calc(100% - 50px);
            max-height: calc(100% - 50px);
        }

        @media (max-width: 1400px) {
            .twitch-grid { grid-template-columns: 1fr 300px 300px; }
        }

        @media (max-width: 1024px) {
            /* Colapsar de 3 a 2 columnas; Mover info a abajo si es necesario */
            .twitch-grid { 
                grid-template-columns: 1fr 300px; 
                grid-template-areas: 
                    "player feed"
                    "player chat";
            }
            .grid-feed { border-right: none !important; border-bottom: 2px solid var(--twitch-border) }
        }
        
        @media (max-width: 768px) {
            .admin-wrapper { overflow: auto; height: auto; margin: -1rem -1rem 0 -1rem; }
            .twitch-grid { 
                display: flex;
                flex-direction: column; 
                height: auto; 
            }
            .grid-column { height: 600px; } /* Altura fija para columnas de chat/feed en celular */
        }

        /* COLUMNS */
        .grid-column {
            display: flex;
            flex-direction: column;
            background: var(--twitch-panel);
            min-height: 0; /* needed for nested scrolling */
        }

        .grid-player {
            background: var(--twitch-bg);
            border-right: 2px solid var(--twitch-border);
        }

        .grid-feed {
            border-right: 2px solid var(--twitch-border);
        }

        .column-header {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--twitch-border);
            font-weight: 700;
            font-size: 0.9rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
            background: rgba(255,255,255,0.02);
        }

        /* PLAYER AREA */
        .player-container {
            position: relative;
            width: 100%;
            height: calc(100% - 140px); /* Leave room for shortcuts */
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #hlsMainPlayer {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .player-overlay {
            position: absolute;
            top: 1rem;
            left: 1rem;
            display: flex;
            gap: 0.5rem;
            z-index: 10;
        }

        .badge-live {
            background: #e91e63;
            color: #fff;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-weight: 800;
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        .badge-quality {
            background: rgba(0,0,0,0.6);
            color: #fff;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        /* SHORTCUTS / ATAJOS (Twitch style TILES) */
        .shortcuts-section {
            height: 140px;
            padding: 1rem;
            border-top: 1px solid var(--twitch-border);
            background: var(--twitch-bg);
            display: flex;
            gap: 1rem;
            flex-wrap: nowrap;
            overflow-x: auto;
        }

        .shortcut-tile {
            width: 120px;
            height: 100px;
            background: var(--twitch-panel);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 6px;
            padding: 0.75rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            cursor: pointer;
            transition: all 0.2s ease;
            flex-shrink: 0;
            text-decoration: none;
            color: var(--text-main);
            text-align: left;
        }

        .shortcut-tile:hover {
            background: rgba(255,255,255,0.05);
            transform: translateY(-2px);
            border-color: var(--text-muted);
        }

        .shortcut-tile.active-bg {
            background: var(--accent-purple);
            border-color: var(--accent-purple);
        }
        
        .shortcut-tile.active-bg:hover { background: #772ce8; }
        
        .shortcut-tile.danger-bg {
            background: #e91e63;
            border-color: #e91e63;
        }
        .shortcut-tile.danger-bg:hover { background: #d81b60; }

        .tile-icon { font-size: 1.25rem; }
        .tile-text { font-size: 0.8rem; font-weight: 600; line-height: 1.2; }

        /* FEED & CHAT LISTS */
        .list-body {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            scrollbar-width: thin;
            scrollbar-color: var(--twitch-border) transparent;
        }
        
        .list-body::-webkit-scrollbar { width: 6px; }
        .list-body::-webkit-scrollbar-track { background: transparent; }
        .list-body::-webkit-scrollbar-thumb { background: var(--twitch-border); border-radius: 3px; }

        /* ACTIONS FEED */
        .feed-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.03);
            border-left: 3px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 6px;
            transition: background 0.2s;
        }
        .feed-item:hover { background: rgba(255, 255, 255, 0.06); }
        .feed-item.type-menu, .feed-item.type-tip {
            border-left-color: var(--accent-gold);
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.05), rgba(0,0,0,0));
        }
        .feed-item.type-roulette {
            border-left-color: #e91e63;
            background: linear-gradient(135deg, rgba(233, 30, 99, 0.05), rgba(0,0,0,0));
        }
        .feed-item.type-chat {
            border-left-color: var(--accent-purple);
            background: linear-gradient(135deg, rgba(147, 51, 234, 0.05), rgba(0,0,0,0));
        }
        .feed-icon {
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
            flex-shrink: 0;
        }
        .feed-content {
            flex: 1;
            font-size: 0.8rem;
            line-height: 1.3;
        }
        .feed-user {
            font-weight: 700;
            color: #ddd;
        }
        .feed-amount {
            font-weight: 800;
        }
        .type-menu .feed-amount, .type-tip .feed-amount { color: var(--accent-gold); }
        .type-roulette .feed-amount { color: #e91e63; }
        .type-chat .feed-amount { color: var(--accent-purple); }

        .feed-time {
            font-size: 0.7rem;
            color: var(--text-muted);
            white-space: nowrap;
        }

        .btn-complete-action {
            background: rgba(255,255,255,0.1);
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 0.7rem;
            padding: 4px 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .btn-complete-action:hover { background: var(--accent-gold); color: #000; }

        /* CHAT STYLES */
        .chat-msg {
            padding: 0.4rem 0.6rem;
            border-radius: 8px;
            word-wrap: break-word;
            margin-bottom: 0.4rem;
            position: relative;
            background: rgba(255, 255, 255, 0.03);
            border-left: 3px solid rgba(255, 255, 255, 0.1);
            transition: background 0.2s;
        }

        .chat-msg.model-msg {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.05), rgba(0,0,0,0));
            border-left: 3px solid var(--accent-gold);
        }

        .chat-msg.model-reply {
            background: linear-gradient(135deg, rgba(147, 51, 234, 0.08), rgba(0,0,0,0));
            border-left: 3px solid var(--accent-purple);
        }

        .chat-msg:hover { background: rgba(255, 255, 255, 0.06); }

        .chat-user {
            font-weight: 700;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            gap: 4px;
            margin-bottom: 2px;
        }

        .chat-user.is-model {
            color: var(--accent-gold);
        }

        .chat-user.is-fan {
            color: #a0aec0;
        }

        .chat-text {
            color: #e2e8f0;
            font-size: 0.85rem;
            line-height: 1.3;
        }

        .reply-mention {
            color: var(--accent-purple);
            font-weight: 800;
            background: rgba(147, 51, 234, 0.2);
            padding: 1px 5px;
            border-radius: 4px;
            margin-right: 2px;
            font-size: 0.8rem;
        }

        .btn-reply-msg {
            background: transparent;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px 6px;
            border-radius: 4px;
            font-size: 0.8rem;
            transition: all 0.2s;
            opacity: 0;
            position: absolute;
            right: 0.4rem;
            top: 0.4rem;
        }

        .chat-msg:hover .btn-reply-msg {
            opacity: 1;
        }
        
        .btn-reply-msg:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }

        .chat-input-area {
            padding: 1rem;
            background: var(--twitch-panel);
            border-top: 1px solid var(--twitch-border);
        }

        .chat-input-wrapper {
            display: flex;
            background: var(--twitch-bg);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 6px;
            padding: 0.2rem;
        }

        .chat-input-wrapper:focus-within { border-color: var(--accent-purple); box-shadow: 0 0 0 1px var(--accent-purple); }

        .chat-input {
            flex: 1;
            background: transparent;
            border: none;
            color: var(--text-main);
            padding: 0.5rem;
            font-size: 0.85rem;
            outline: none;
        }

        .btn-send {
            background: var(--accent-purple);
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 0 1rem;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-send:hover { background: #772ce8; }
        
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: var(--text-muted);
            text-align: center;
            padding: 2rem;
        }
    </style>
@endsection

@section('content')
    <div class="admin-wrapper">
        <!-- TOP STATS BAR -->
        <div class="top-stats-bar">
            <div class="top-stats-group">
                <div class="stat-item">
                    <span class="stat-icon"><i class="fas fa-eye"></i></span>
                    <span class="stat-value" id="viewerCount">{{ number_format($stream->viewers_count) }}</span>
                    <span style="font-size: 0.7rem; color: var(--text-muted); font-weight: 400;">{{ __('model.streams.admin.viewers') }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-icon text-live-red"><i class="fas fa-circle"></i></span>
                    <span class="stat-value" id="streamDuration">--:--</span>
                    <span style="font-size: 0.7rem; color: var(--text-muted); font-weight: 400;">{{ __('model.streams.admin.session') }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-icon" style="color: var(--accent-gold)"><i class="fas fa-coins"></i></span>
                    <span class="stat-value">${{ number_format($sessionEarnings, 2) }}</span>
                    <span style="font-size: 0.7rem; color: var(--text-muted); font-weight: 400;">{{ __('model.streams.admin.tips') }}</span>
                </div>
            </div>
            
            <div class="top-stats-group" style="font-size: 0.75rem; border-left: 1px solid var(--twitch-border); padding-left: 1rem;">
                <div>
                    <span style="color: var(--text-muted);">RTMP:</span> 
                    <span style="font-family: monospace;">rtmp://127.0.0.1:1935/live</span>
                </div>
                <div>
                    <span style="color: var(--text-muted);">CLE:</span>
                    <span style="font-family: monospace; color: var(--accent-gold)">{{ Str::limit($stream->stream_key, 8) }}***</span>
                </div>
            </div>
        </div>

        <!-- 3 COLUMN GRID -->
        <div class="twitch-grid">
            
            <!-- COLUMN 1: PLAYER & SHORTCUTS -->
            <div class="grid-column grid-player">
                <div class="column-header">
                    <span>{{ __('model.streams.admin.preview_title') }}</span>
                </div>
                
                <div class="player-container">
                    <div class="player-overlay">
                        @if($stream->status === 'live' || $stream->status === 'paused')
                            <div class="badge-live">{{ __('model.streams.admin.status_live') }}</div>
                        @else
                            <div class="badge-live" style="background:#555">{{ __('model.streams.admin.status_offline') }}</div>
                        @endif
                        <div class="badge-quality">{{ __('model.streams.admin.quality') }}</div>
                    </div>

                    @if($stream->status === 'live' || $stream->status === 'paused')
                        <video id="hlsMainPlayer" controls autoplay muted playsinline
                            data-url="{{ asset('hls/live/' . $stream->stream_key . '.m3u8') }}">
                        </video>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-video-slash" style="font-size: 3rem; margin-bottom: 1rem; color: rgba(255,255,255,0.1)"></i>
                            <h3>{{ __('model.streams.admin.offline_title') }}</h3>
                            <p style="font-size: 0.8rem; margin-top: 0.5rem;">{{ __('model.streams.admin.offline_desc') }}</p>
                        </div>
                    @endif
                </div>

                <!-- TILES CONTROLS -->
                <div class="column-header" style="border-top: 1px solid var(--twitch-border);">
                    <span>{{ __('model.streams.admin.shortcuts') }}</span>
                </div>
                <div class="shortcuts-section">
                    @if($stream->status === 'live')
                        <form id="pauseForm" action="{{ route('model.streams.pause', $stream) }}" method="POST" style="display: none;">@csrf</form>
                        <button class="shortcut-tile" onclick="handlePause()">
                            <div class="tile-icon"><i class="fas fa-pause"></i></div>
                            <div class="tile-text">{{ __('model.streams.admin.pause') }}<br>stream</div>
                        </button>
                    @elseif($stream->status === 'paused')
                        <form action="{{ route('model.streams.resume', $stream) }}" method="POST" style="display:inline-block; margin: 0;">
                            @csrf
                            <button type="submit" class="shortcut-tile active-bg">
                                <div class="tile-icon"><i class="fas fa-play"></i></div>
                                <div class="tile-text">{{ __('model.streams.admin.resume') }}<br>stream</div>
                            </button>
                        </form>
                    @endif

                    <button class="shortcut-tile" onclick="refreshPlayer()">
                        <div class="tile-icon"><i class="fas fa-sync-alt"></i></div>
                        <div class="tile-text">{{ __('model.streams.admin.refresh_player') }}</div>
                    </button>

                    <form action="{{ route('model.streams.end', $stream) }}" method="POST" id="endStreamForm" style="margin: 0;">
                        @csrf
                        <button type="button" class="shortcut-tile danger-bg" onclick="confirmEndStream()">
                            <div class="tile-icon"><i class="fas fa-power-off"></i></div>
                            <div class="tile-text">{{ __('model.streams.admin.end_all') }}</div>
                        </button>
                    </form>
                </div>
            </div>

            <!-- COLUMN 2: ACTIVITY FEED -->
            <div class="grid-column grid-feed">
                <div class="column-header">
                    <span>{{ __('model.streams.admin.activity_feed') }}</span>
                    <i class="fas fa-ellipsis-v" style="color:var(--text-muted); cursor:pointer;"></i>
                </div>
                
                <div class="list-body" id="actionsContainer">
                     <div class="empty-state">
                         <i class="fas fa-spinner fa-spin" style="margin-bottom: 10px; font-size: 1.5rem;"></i>
                         <p style="font-size: 0.8rem; margin-top: 0.5rem">{{ __('model.streams.admin.loading_activities') }}</p>
                     </div>
                </div>
            </div>

            <!-- COLUMN 3: CHAT -->
            <div class="grid-column">
                <div class="column-header">
                    <span>{{ __('model.streams.admin.my_chat') }}</span>
                    
                </div>

                <div class="list-body" id="chatContainer" style="position: relative;">
                    @php $currentPinned = $stream->chatMessages->where('is_pinned', true)->first(); @endphp
                    <div id="pinnedMessageContainer" style="display: {{ $currentPinned ? 'block' : 'none' }}; padding: 0.5rem 0.75rem; background: linear-gradient(90deg, rgba(212, 175, 55, 0.15), rgba(0,0,0,0)); border-left: 3px solid var(--accent-gold); margin-bottom: 0.5rem; font-size: 0.8rem; position: sticky; top: 0; z-index: 10; backdrop-filter: blur(4px);">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2px;">
                            <span style="color: var(--accent-gold); font-weight: 700; font-size: 0.7rem; text-transform: uppercase;"><i class="fas fa-thumbtack"></i> {{ __('model.streams.admin.pinned') }}</span>
                            <button onclick="unpinCurrentMessage()" style="background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 0; font-size: 0.8rem;" title="{{ __('model.streams.admin.unpin') }}"><i class="fas fa-times"></i></button>
                        </div>
                        <div id="pinnedMessageText" style="color: #e2e8f0; word-break: break-word; font-weight: 600;">{{ $currentPinned ? $currentPinned->message : '' }}</div>
                    </div>

                    <div style="text-align: center; font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1rem;">
                        {{ __('model.streams.admin.chat_welcome') }}
                    </div>

                    @forelse($stream->chatMessages as $msg)
                        @php
                            $isModel = $msg->user_id === auth()->id();
                            $isReply = $isModel && Str::startsWith($msg->message, '@');
                            $msgClass = $isModel ? ($isReply ? 'model-reply' : 'model-msg') : '';
                            
                            $formattedMessage = e($msg->message);
                            if (Str::startsWith($msg->message, '@')) {
                                if (preg_match('/^@([^:]+):\s*(.*)$/', $msg->message, $matches)) {
                                    $formattedMessage = '<span class="reply-mention">@' . e($matches[1]) . '</span> ' . e($matches[2]);
                                } else {
                                    $parts = explode(' ', $msg->message, 2);
                                    if (count($parts) == 2) {
                                        $formattedMessage = '<span class="reply-mention">' . e($parts[0]) . '</span> ' . e($parts[1]);
                                    }
                                }
                            }
                        @endphp
                        <div class="chat-msg {{ $msgClass }}" data-message-id="{{ $msg->id }}">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 0.5rem; width: 100%;">
                                <div style="flex: 1; word-break: break-word;">
                                    <div class="chat-user {{ $isModel ? 'is-model' : 'is-fan' }}">
                                        @if($isModel)
                                            <i class="fas fa-crown"></i>
                                            <span>{{ $msg->user->name }}</span>
                                            <span style="background: var(--accent-gold); color: #000; padding: 1px 4px; border-radius: 4px; font-size: 0.6rem; font-weight: bold; margin-left: 2px;">{{ __('model.streams.admin.badge_model') }}</span>
                                        @else
                                            <i class="fas fa-user-circle"></i>
                                            <span>{{ $msg->user->name }}</span>
                                        @endif
                                    </div>
                                    <div class="chat-text">{!! $formattedMessage !!}</div>
                                </div>
                                <div style="display:flex; flex-direction:column; align-items:flex-end; gap:4px; margin-top:-2px;">
                                    @if($isModel && !$isReply)
                                        <button onclick="pinMessage({{ $msg->id }})" 
                                                class="btn-reply-msg" 
                                                style="position: relative; right: auto; top: auto; opacity: 1; background: rgba(212, 175, 55, 0.1); color: var(--accent-gold);"
                                                title="Fijar mensaje">
                                            <i class="fas fa-thumbtack"></i> {{ __('model.streams.admin.btn_pin') }}
                                        </button>
                                    @endif
                                    @if(!$isModel)
                                        <button onclick="replyToMessage('{{ $msg->user->name }}', {{ $msg->id }})" 
                                                class="btn-reply-msg" 
                                                style="position: relative; right: auto; top: auto; opacity: 1; min-width:85px"
                                                title="Responder a {{ $msg->user->name }}">
                                            <i class="fas fa-reply"></i> {{ __('model.streams.admin.btn_reply') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                    @empty
                        <div class="empty-state" style="margin-top:2rem">
                            <i class="fas fa-comments" style="font-size: 2.5rem; color: rgba(255,255,255,0.1); margin-bottom:1rem"></i>
                            <p style="font-weight: 600;">{{ __('model.streams.admin.chat_empty') }}</p>
                            <p style="font-size: 0.8rem; margin-top: 0.5rem">{{ __('model.streams.admin.chat_empty_desc') }}</p>
                        </div>
                    @endforelse
                </div>

                <div class="chat-input-area">
                    <div class="chat-input-wrapper">
                        <input type="text" id="chatReplyInput" class="chat-input" placeholder="{{ __('model.streams.admin.placeholder_send') }}" onkeypress="if(event.key === 'Enter') sendChatReply()">
                        <button class="btn-send" onclick="sendChatReply()">{{ __('model.streams.admin.btn_send') }}</button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script>
        let hls = null;
        let streamId = {{ $stream->id }};
        let lastMessageId = {{ $stream->chatMessages->last()->id ?? 0 }};
        let currentUserId = {{ auth()->id() }};
        let pauseMode = '{{ auth()->user()->profile->pause_mode ?? 'none' }}';

        function initHls() {
            const video = document.getElementById('hlsMainPlayer');
            if (!video) return;

            const url = video.dataset.url;

            if (Hls.isSupported()) {
                if (hls) hls.destroy();
                hls = new Hls({
                    lowLatencyMode: true,
                    backBufferLength: 60,
                    manifestLoadingMaxRetry: 10,
                    manifestLoadingRetryDelay: 1000
                });
                hls.loadSource(url);
                hls.attachMedia(video);
                hls.on(Hls.Events.MANIFEST_PARSED, () => video.play());

                hls.on(Hls.Events.ERROR, (event, data) => {
                    if (data.fatal) {
                        console.warn('HLS Error:', data.type);
                        if (data.type === Hls.ErrorTypes.NETWORK_ERROR) {
                            hls.startLoad();
                        } else if (data.type === Hls.ErrorTypes.MEDIA_ERROR) {
                            hls.recoverMediaError();
                        }
                    }
                });
            }
            else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                video.src = url;
                video.play();
            }
        }

        function refreshPlayer() {
            initHls();
            Swal.fire({
                icon: 'info',
                title: '{{ __('model.streams.admin.swal.refresh_title') }}',
                text: '{{ __('model.streams.admin.swal.refresh_text') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                background: '#1f1f23',
                color: '#fff'
            });
        }

        // Reply to specific message
        function replyToMessage(userName, messageId) {
            const input = document.getElementById('chatReplyInput');
            input.value = `@${userName}: `;
            input.focus();

            // Scroll to message briefly to show context
            const messageEl = document.querySelector(`[data-message-id="${messageId}"]`);
            if (messageEl) {
                messageEl.style.background = 'rgba(212, 175, 55, 0.1)';
                setTimeout(() => {
                    messageEl.style.background = '';
                }, 1500);
            }
        }

        // Send chat reply
        async function sendChatReply() {
            const input = document.getElementById('chatReplyInput');
            const message = input.value.trim();

            if (!message) return;

            try {
                const response = await fetch(`/model/streams/${streamId}/chat/reply`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message })
                });

                const data = await response.json();

                if (data.success) {
                    input.value = '';
                    // Add message to chat immediately
                    addMessageToChat(data.chat_message, true);
                } else {
                    alert(data.message || 'Error al enviar mensaje');
                }
            } catch (error) {
                console.error('Error sending reply:', error);
                alert('Error al enviar mensaje');
            }
        }

        // Complete action
        async function completeAction(streamId, tipId) {
            try {
                const response = await fetch(`/model/streams/${streamId}/actions/${tipId}/complete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Remove from pending with animation
                    const actionCard = document.querySelector(`[data-action-id="${tipId}"]`);
                    if (actionCard) {
                        actionCard.style.opacity = '0';
                        actionCard.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            actionCard.remove();
                            // Refresh actions list without reloading page
                            refreshActionsList(streamId);
                        }, 300);
                    }

                    Swal.fire({
                        icon: 'success',
                        title: '{{ __('model.streams.admin.swal.completed') }}',
                        text: data.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        background: '#1f1f23',
                        color: '#fff'
                    });
                    
                    fetchActivitiesFeed();
                } else {
                    alert(data.message || 'Error al completar acción');
                }
            } catch (error) {
                console.error('Error completing action:', error);
                alert('Error al completar acción');
            }
        }

        // Refresh dynamic feed without reloading page
        async function fetchActivitiesFeed() {
            try {
                const response = await fetch(`/model/streams/${streamId}/feed`, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                });
                
                if(!response.ok) return;

                const data = await response.json();

                if (data.success) {
                    const container = document.getElementById('actionsContainer');
                    
                    if (data.feed.length > 0) {
                        // Solo actualizamos si cambiaron las actividades comparando la cantidad...
                        // Sería mejor chequear el ID, pero para simplificar re-dibujamos todo
                        // si es diferente, o cada vez, pero usando un Set para no recargar DOM innecesariamente es mejor
                        container.innerHTML = '';
                        
                        data.feed.forEach(item => {
                            const isRoulette = item.type === 'roulette';
                            const isChat = item.type === 'chat';
                            const iconClass = isRoulette ? 'fa-dharmachakra' : (isChat ? 'fa-lock-open' : 'fa-star');
                            
                            const div = document.createElement('div');
                            div.className = `feed-item type-${item.type}`;
                            
                            let msgLabel = '';
                            if(isChat) msgLabel = '<span style="color:var(--text-muted)">Desbloqueó chat</span>';
                            else if(isRoulette) msgLabel = `<span style="color:var(--text-muted)">giró -</span> "${item.message}"`;
                            else msgLabel = `<span style="color:var(--text-muted)">envió -</span> "${item.message}"`;

                            let actionBtn = '';
                            if(!item.completed && item.type !== 'chat') {
                                actionBtn = `<button onclick="completeAction(${streamId}, ${item.raw_id})" class="btn-complete-action"><i class="fas fa-check"></i></button>`;
                            }

                            div.innerHTML = `
                                <div class="feed-icon {type-${item.type}}"><i class="fas ${iconClass}"></i></div>
                                <div class="feed-content">
                                    <span class="feed-user">${item.fan_name}</span> 
                                    <span class="feed-amount">${item.amount} Tk</span><br>
                                    ${msgLabel}
                                </div>
                                ${actionBtn}
                                <div class="feed-time">${item.timestamp}</div>
                            `;
                            container.appendChild(div);
                        });
                    } else {
                        container.innerHTML = `
                            <div class="empty-state">
                                <p style="font-weight: 600;">{{ __('model.streams.admin.activity_empty') }}</p>
                                <p style="font-size: 0.8rem; margin-top: 0.5rem">{{ __('model.streams.admin.activity_empty_desc') }}</p>
                            </div>
                        `;
                    }
                }
            } catch (error) {
                console.debug('Error refreshing feed:', error.message);
            }
        }

        // Formatear menciones
        function formatAdminChatMessage(text) {
            if (text.startsWith('@')) {
                const match = text.match(/^@([^:]+):\s*(.*)/);
                if (match) {
                    return `<span class="reply-mention">@${match[1]}</span> ${match[2]}`;
                }
                const parts = text.split(' ');
                if (parts.length >= 2) {
                    const mention = parts.shift();
                    return `<span class="reply-mention">${mention}</span> ` + parts.join(' ');
                }
            }
            return text;
        }

        // Add message to chat
        function addMessageToChat(msg, isModel = false) {
            const container = document.getElementById('chatContainer');
            
            // Si el mensaje ya existe en el DOM (evitar duplicados por polling + optimistic UI), salir
            if (container.querySelector(`[data-message-id="${msg.id}"]`)) {
                return;
            }

            // Remover estado vacío si existe
            const emptyChat = container.querySelector('.empty-state') || container.querySelector('div[style*="text-align: center"]');
            if (emptyChat) emptyChat.remove();

            const isReply = isModel && msg.message.startsWith('@');
            let msgClass = '';
            if (isModel) {
                msgClass = isReply ? 'model-reply' : 'model-msg';
            }

            const div = document.createElement('div');
            div.className = 'chat-msg ' + msgClass;
            div.setAttribute('data-message-id', msg.id);

            const replyButton = !isModel ? `
                        <button onclick="replyToMessage('${msg.user.name}', ${msg.id})" 
                                class="btn-reply-msg" 
                                style="position: relative; right: auto; top: auto; opacity: 1; min-width:85px"
                                title="{{ __('model.streams.admin.btn_reply') }} ${msg.user.name}">
                            <i class="fas fa-reply"></i> {{ __('model.streams.admin.btn_reply') }}
                        </button>
                    ` : '';

            const pinButton = (isModel && !isReply) ? `
                        <button onclick="pinMessage(${msg.id})" 
                                class="btn-reply-msg" 
                                style="position: relative; right: auto; top: auto; opacity: 1; background: rgba(212, 175, 55, 0.1); color: var(--accent-gold);"
                                title="{{ __('model.streams.admin.btn_pin') }}">
                            <i class="fas fa-thumbtack"></i> {{ __('model.streams.admin.btn_pin') }}
                        </button>
                    ` : '';

            const roleBadge = isModel 
                ? '<span style="background: var(--accent-gold); color: #000; padding: 1px 4px; border-radius: 4px; font-size: 0.6rem; font-weight: bold; margin-left: 2px;">{{ __('model.streams.admin.badge_model') }}</span>' 
                : '';
            
            const iconHtml = isModel
                ? '<i class="fas fa-crown"></i>'
                : '<i class="fas fa-user-circle"></i>';

            const userClass = isModel ? 'is-model' : 'is-fan';
            const formattedMsg = formatAdminChatMessage(msg.message);

            div.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 0.5rem; width: 100%;">
                    <div style="flex: 1; word-break: break-word;">
                        <div class="chat-user ${userClass}">
                            ${iconHtml}
                            <span>${msg.user.name}</span>
                            ${roleBadge}
                        </div>
                        <div class="chat-text">${formattedMsg}</div>
                    </div>
                    <div style="display:flex; flex-direction:column; align-items:flex-end; gap:4px; margin-top:-2px;">
                        ${pinButton}
                        ${replyButton}
                    </div>
                </div>
            `;
            container.appendChild(div);
            container.scrollTop = container.scrollHeight;
        }

        // Fetch new messages periodically
        async function fetchNewMessages() {
            try {
                const response = await fetch(`/model/streams/${streamId}/chat/new?last_id=${lastMessageId}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                if (!response.ok) return; // Si hay error auth o redirecciones, silenciar

                const data = await response.json();
                
                if (data.success && data.messages.length > 0) {
                    data.messages.forEach(msg => {
                        const isModel = msg.user_id === currentUserId;
                        addMessageToChat(msg, isModel);
                        lastMessageId = msg.id;
                    });
                }
            } catch (error) {
                // Silenciamos los errores de parsing repetitivos causados por redirecciones de auth a HTML
                console.debug("Polling update:", error.message);
            }
        }

        // UPDATE STATS (Polling)
        async function updateStreamData() {
            try {
                const response = await fetch(`/api/stream/${streamId}/info`);
                const data = await response.json();

                if (data.status === 'live' || data.status === 'paused') {
                    document.getElementById('viewerCount').innerText = data.viewers_count.toLocaleString();
                    updateDuration(data.started_at);
                } else if (data.status === 'ended') {
                    location.reload(); // Finalizar si el servidor detecta fin
                }
            } catch (error) {
                console.error('Error polling data:', error);
            }
        }

        async function pinMessage(messageId) {
            try {
                const response = await fetch(`/model/streams/${streamId}/chat/${messageId}/pin`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const data = await response.json();
                if (data.success && data.is_pinned) {
                    const pinnedContainer = document.getElementById('pinnedMessageContainer');
                    const pinnedText = document.getElementById('pinnedMessageText');
                    
                    pinnedText.innerText = data.message.content;
                    pinnedContainer.style.display = 'block';

                    Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: '{{ __('model.streams.admin.pinned') }}', showConfirmButton: false, timer: 1500, background: '#1f1f23', color: '#fff' });
                } else if(data.success && !data.is_pinned) {
                     unpinCurrentMessage(true); // if API unpinned it directly because it was exactly that one
                }
            } catch (error) {
                console.error('Error pinning message:', error);
            }
        }

        async function unpinCurrentMessage(fromApi = false) {
            const pinnedContainer = document.getElementById('pinnedMessageContainer');
            pinnedContainer.style.display = 'none';
            document.getElementById('pinnedMessageText').innerText = '';
            
            if(!fromApi) {
                try {
                    await fetch(`/model/streams/${streamId}/chat/unpin`, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                } catch (error) {
                    console.error('Error unpinning:', error);
                }
            }
        }

        function updateDuration(startAt) {
            const start = new Date(startAt);
            const now = new Date();
            const diff = Math.floor((now - start) / 1000);

            const hours = Math.floor(diff / 3600);
            const mins = Math.floor((diff % 3600) / 60);
            const secs = diff % 60;

            const pad = (n) => n.toString().padStart(2, '0');
            document.getElementById('streamDuration').innerText =
                `${hours > 0 ? pad(hours) + ':' : ''}${pad(mins)}:${pad(secs)}`;
        }

        function handlePause() {
            if (pauseMode === 'none') {
                Swal.fire({
                    title: '{{ __('model.streams.admin.swal_pause.title') }}',
                    text: "{{ __('model.streams.admin.swal_pause.text_none') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d4af37',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '{{ __('model.streams.admin.swal_pause.btn_anyway') }}',
                    cancelButtonText: '{{ __('model.streams.admin.swal_pause.btn_settings') }}',
                    background: '#1f1f23',
                    color: '#fff'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('pauseForm').submit();
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        window.location.href = "{{ route('model.streams.settings') }}";
                    }
                });
            } else {
                // Si ya tiene configurado algo, pausamos directamente o preguntamos brevemente
                Swal.fire({
                    title: '{{ __('model.streams.admin.swal_pause.title') }}?',
                    text: "{{ __('model.streams.admin.swal_pause.text_mode') }}",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d4af37',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '{{ __('model.streams.admin.swal_pause.btn_confirm') }}',
                    cancelButtonText: '{{ __('model.streams.admin.swal_pause.btn_cancel') }}',
                    background: '#1f1f23',
                    color: '#fff'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('pauseForm').submit();
                    }
                });
            }
        }

        function confirmEndStream() {
            Swal.fire({
                title: '{{ __('model.streams.admin.swal_end.title') }}',
                text: "{{ __('model.streams.admin.swal_end.text') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '{{ __('model.streams.admin.swal_end.btn_confirm') }}',
                cancelButtonText: '{{ __('model.streams.admin.swal_end.btn_cancel') }}',
                background: '#1f1f23',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('endStreamForm').submit();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            initHls();
            
            // Actualizar datos del stream (vista, estado, on/off)
            setInterval(updateStreamData, 5000);


            // Actualizar feed de actividades
            fetchActivitiesFeed();
            setInterval(fetchActivitiesFeed, 3000);

            // Actualizar mensajes nuevos de chat (polling)
            setInterval(fetchNewMessages, 2500);

            // Auto-scroll chat al cargar
            const chat = document.getElementById('chatContainer');
            if(chat) chat.scrollTop = chat.scrollHeight;
        });
    </script>
@endsection