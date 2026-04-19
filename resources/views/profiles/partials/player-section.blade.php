@php
    $fanPlayerVisible = $fanLivePlayback
        ?? (isset($activeStream) && $activeStream && in_array($activeStream->status, ['live', 'paused'], true));
@endphp
<div class="player-section">

    <div class="stage-card">
        <div class="player-window">
            <div class="player-aspect-ratio shadow-2xl relative overflow-hidden group">
                @auth
                    @if($fanPlayerVisible && $model->profile)
                        <div id="rouletteOverlay" class="roulette-overlay">
                            <div class="roulette-wheel-container">
                                <div id="rouletteWheel" class="roulette-wheel">
                                    <div class="wheel-label" style="--i:0;"><span>Beso</span></div>
                                    <div class="wheel-label" style="--i:1;"><span>Pies</span></div>
                                    <div class="wheel-label" style="--i:2;"><span>Baile</span></div>
                                    <div class="wheel-label" style="--i:3;"><span>Saludo</span></div>
                                    <div class="wheel-label" style="--i:4;"><span>Outfit</span></div>
                                    <div class="wheel-label" style="--i:5;"><span>Guiño</span></div>
                                    <div class="wheel-label" style="--i:6;"><span>Corazón</span></div>
                                    <div class="wheel-label" style="--i:7;"><span>Voz</span></div>
                                </div>
                                <div class="roulette-pointer"></div>
                                <div class="roulette-center">
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="player-floating-actions">
                            <button class="player-fab player-fab-tip" onclick="openTipModal()" title="Enviar Propina">
                                <i class="fas fa-gift"></i>
                                <span class="fab-label">Propina</span>
                            </button>
                            <button class="player-fab player-fab-roulette" onclick="spinRoulette()" title="Girar Ruleta">
                                <i class="fas fa-dice"></i>
                                <span class="fab-label">Ruleta</span>
                            </button>
                        </div>
                    @endif
                @endauth

                @if($activeStream && $activeStream->status === 'paused')
                    <div class="pause-overlay">
                        @if($model->profile->pause_mode === 'image' && $model->profile->pause_image)
                            <img src="{{ asset('storage/' . $model->profile->pause_image) }}" class="pause-media">
                        @elseif($model->profile->pause_mode === 'video' && $model->profile->pause_video)
                            <video src="{{ asset('storage/' . $model->profile->pause_video) }}" class="pause-media" autoplay
                                muted loop playsinline></video>
                        @endif
                        <div class="pause-content">
                            <div class="pause-message">
                                <h3><i class="fas fa-pause-circle"></i> Transmisión Pausada</h3>
                                <p>Enseguida volvemos...</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if($fanPlayerVisible && $model->profile)
                    @php
                        // URL del HLS servido por Laravel desde public/hls/live/
                        $hlsUrl = asset('hls/live/' . $model->profile->stream_key . '/index.m3u8');
                    @endphp
                    <div id="profilePlaybackModeBadge"
                        style="position:absolute; top:12px; left:12px; z-index:30; background:rgba(0,0,0,0.7); color:#fff; font-size:11px; font-weight:700; padding:6px 10px; border-radius:999px; border:1px solid rgba(255,255,255,0.2);">
                        Mode: Connecting...
                    </div>
                    <div id="profileStreamLoadingOverlay" style="position:absolute; inset:0; z-index:35; display:flex; align-items:center; justify-content:center; background:rgba(0,0,0,0.45); pointer-events:none;">
                        <div style="display:flex; flex-direction:column; align-items:center; gap:10px; background:rgba(0,0,0,0.65); border:1px solid rgba(255,255,255,0.25); border-radius:14px; padding:14px 18px; color:#fff;">
                            <i class="fas fa-spinner fa-spin" style="font-size:20px; color:#d4af37;"></i>
                            <span style="font-size:12px; font-weight:700; letter-spacing:.2px;">Connecting stream...</span>
                        </div>
                    </div>
                    <video id="hlsProfilePlayer" class="w-full h-full object-contain" data-url="{{ $hlsUrl }}"
                        autoplay muted playsinline></video>

                    <!-- Custom bottom bar: volume + fullscreen only (no play/pause — autoplay) -->
                    <div class="player-custom-controls pc-only-control">
                        <div class="controls-left">
                            <div class="player-volume-group">
                                <button id="playerMuteBtn" class="player-control-btn vol-btn">
                                    <i class="fas fa-volume-up"></i>
                                </button>
                                <div class="vol-slider-container">
                                    <input type="range" id="playerVolumeSlider" class="player-vol-slider" min="0" max="1" step="0.05" value="1">
                                </div>
                            </div>
                        </div>

                        <div class="controls-right">
                            <button id="playerFullscreenBtn" class="player-control-btn">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                    </div>
                @else
                    <div class="offline-placeholder"
                        style="background: url('{{ $model->profile->cover_image_url }}') no-repeat center center/cover;">
                        
                        <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(8px);">
                        </div>

                        <div
                            style="position: relative; z-index: 10; display: flex; flex-direction: column; align-items: center; gap: 15px; height: 100%; justify-content: center;">
                            
                            <div style="padding: 4px; border: 2px solid rgba(255,255,255,0.1); border-radius: 50%;">
                                <img src="{{ $model->profile->avatar_url }}"
                                    onerror="this.onerror=null;this.src='{{ asset('images/placeholder-avatar.svg') }}'"
                                    style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid #fff;">
                            </div>

                            <div
                                style="background: #fff; color: #000; padding: 4px 12px; border-radius: 20px; font-weight: 800; font-size: 0.7rem; text-transform: uppercase;">
                                Fuera de Línea
                            </div>

                            <p style="color: rgba(255,255,255,0.6); font-size: 0.9rem; margin: 0;">
                                Estuvo en línea hace
                                {{ $model->last_seen_at ? $model->last_seen_at->diffForHumans() : 'un tiempo' }}
                            </p>

                           
                        </div>
                    </div>
                @endif
            </div> 
        </div> 
    </div> 
</div> 