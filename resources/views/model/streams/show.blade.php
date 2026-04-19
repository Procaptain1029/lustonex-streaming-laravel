@extends('layouts.model')

@section('title', $stream->title)

@section('breadcrumb')
    <a href="{{ route('model.dashboard') }}" class="breadcrumb-item">{{ __('model.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('model.streams.index') }}" class="breadcrumb-item">{{ __('model.streams.index.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ $stream->title }}</span>
@endsection

@section('styles')
    <style>
        /* Modern Stream UI Enhancements */
        .sh-card-premium {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .sh-card-premium:hover {
            border-color: rgba(212, 175, 55, 0.2);
            background: rgba(255, 255, 255, 0.05);
        }

        .sh-section-header {
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #fff;
            font-size: 1.1rem;
            font-weight: 700;
        }

        .sh-section-header i {
            font-size: 1rem;
            opacity: 0.8;
        }

        /* Stream Controls */
        .btn-control {
            width: 100%;
            padding: 0.85rem;
            border-radius: 12px;
            border: 1px solid transparent;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .btn-pause { background: rgba(255, 193, 7, 0.1); color: #ffc107; border-color: rgba(255, 193, 7, 0.2); }
        .btn-pause:hover { background: rgba(255, 193, 7, 0.2); transform: translateY(-2px); }

        .btn-resume { background: rgba(40, 167, 69, 0.1); color: #28a745; border-color: rgba(40, 167, 69, 0.2); }
        .btn-resume:hover { background: rgba(40, 167, 69, 0.2); transform: translateY(-2px); }

        .btn-end { background: rgba(220, 53, 69, 0.1); color: #dc3545; border-color: rgba(220, 53, 69, 0.2); }
        .btn-end:hover { background: rgba(220, 53, 69, 0.2); transform: translateY(-2px); box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2); }

        .btn-view { background: rgba(255, 255, 255, 0.05); color: #fff; border-color: rgba(255, 255, 255, 0.1); }
        .btn-view:hover { background: rgba(255, 255, 255, 0.1); transform: translateY(-2px); }

        /* OBS Setup */
        .obs-setup-step {
            background: rgba(255, 255, 255, 0.02);
            border-radius: 14px;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.03);
        }

        .obs-setup-step h4 {
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
            color: var(--model-gold);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .obs-setup-step p {
            font-size: 0.85rem;
            opacity: 0.6;
            line-height: 1.4;
            margin-bottom: 0.75rem;
        }

        /* Activity Feeds */
        .msg-bubble {
            background: rgba(255, 255, 255, 0.02);
            padding: 0.75rem 1rem;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.03);
            margin-bottom: 0.75rem;
            transition: all 0.2s;
        }

        .msg-bubble:hover {
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .tip-item-premium {
            background: rgba(40, 167, 69, 0.03);
            border: 1px solid rgba(40, 167, 69, 0.1);
            padding: 0.85rem;
            border-radius: 12px;
            margin-bottom: 0.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.2s;
        }

        .tip-item-premium:hover {
            background: rgba(40, 167, 69, 0.06);
            border-color: rgba(40, 167, 69, 0.2);
        }

        .token-badge {
            color: var(--model-gold);
            font-weight: 800;
            font-size: 0.9rem;
            background: rgba(212, 175, 55, 0.1);
            padding: 0.35rem 0.75rem;
            border-radius: 8px;
            border: 1px solid rgba(212, 175, 55, 0.2);
            font-family: 'Poppins', sans-serif;
        }

        .live-pulse {
            width: 8px;
            height: 8px;
            background: #dc3545;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 rgba(220, 53, 69, 0.4);
            animation: pulse-red 2s infinite;
        }

        @keyframes pulse-red {
            0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
            100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
        }

        #chat-messages::-webkit-scrollbar, #tip-list::-webkit-scrollbar {
            width: 4px;
        }
        #chat-messages::-webkit-scrollbar-thumb, #tip-list::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        @media (max-width: 992px) {
            .streaming-grid {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endsection

@section('content')
 @include('components.sidebar-header-scripts')
    @include('components.search-scripts')
        <div style="padding: 1rem 0;">
            
            <div class="sh-card-premium" style="padding: 1rem 1.5rem; margin-bottom: 1.25rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <div style="flex: 1; min-width: 250px;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.25rem;">
                            <a href="{{ route('model.streams.index') }}" 
                               style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.05); border-radius: 50%; color: #fff; text-decoration: none; transition: all 0.2s ease;"
                               onmouseover="this.style.background='rgba(255,255,255,0.1)'"
                               onmouseout="this.style.background='rgba(255,255,255,0.05)'">
                                <i class="fas fa-arrow-left" style="font-size: 0.9rem;"></i>
                            </a>
                            <h1 style="font-family: var(--font-titles); font-size: 1.25rem; color: {{ $stream->status == 'ended' ? '#6c757d' : '#fff' }}; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                @if($stream->status == 'live')
                                    <span class="live-pulse"></span>
                                @endif
                                <i class="fas {{ $stream->status == 'ended' ? 'fa-history' : 'fa-broadcast-tower' }}" style="color: {{ $stream->status == 'ended' ? '#6c757d' : '#dc3545' }}; font-size: 1rem;"></i>
                                {{ $stream->title }}
                            </h1>
                        </div>
                        @if($stream->description)
                            <p style="color: rgba(255, 255, 255, 0.4); font-size: 0.85rem; margin: 0 0 0 2.75rem;">{{ Str::limit($stream->description, 100) }}</p>
                        @endif
                    </div>

                    <div style="display: flex; gap: 0.75rem;">
                        @if($stream->status == 'ended')
                            <span style="background: rgba(108, 117, 125, 0.1); color: #adb5bd; border: 1px solid rgba(108, 117, 125, 0.2); padding: 4px 12px; border-radius: 30px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;">Finalizado</span>
                        @elseif($stream->status == 'live')
                            <span style="background: rgba(220, 53, 69, 0.1); color: #ff4757; border: 1px solid rgba(220, 53, 69, 0.2); padding: 4px 12px; border-radius: 30px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;">En Vivo</span>
                        @else
                            <span style="background: rgba(255, 193, 7, 0.1); color: #ffc107; border: 1px solid rgba(255, 193, 7, 0.2); padding: 4px 12px; border-radius: 30px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;">Pendiente</span>
                        @endif
                    </div>
                </div>
            </div>

            
            <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                <div class="sh-card-premium" style="padding: 1.25rem 0.75rem; text-align: center;">
                    <div style="margin-bottom: 0.5rem; background: rgba(0, 123, 255, 0.1); width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-inline: auto;">
                        <i class="fas fa-users" style="color: #007bff; font-size: 1.1rem;"></i>
                    </div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #fff;">{{ number_format($stream->viewers_count) }}</div>
                    <div style="text-transform: uppercase; font-size: 0.6rem; font-weight: 700; color: rgba(255,255,255,0.3);">Audiencia Peak</div>
                </div>

                <div class="sh-card-premium" style="padding: 1.25rem 0.75rem; text-align: center; border-color: rgba(212, 175, 55, 0.2);">
                    <div style="margin-bottom: 0.5rem; background: rgba(212, 175, 55, 0.1); width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-inline: auto;">
                        <i class="fas fa-coins" style="color: var(--model-gold); font-size: 1.1rem;"></i>
                    </div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: var(--model-gold);">{{ number_format($stream->total_earnings, 0) }}</div>
                    <div style="text-transform: uppercase; font-size: 0.6rem; font-weight: 700; color: rgba(212, 175, 55, 0.4);">Tokens Totales</div>
                </div>

                <div class="sh-card-premium" style="padding: 1.25rem 0.75rem; text-align: center;">
                    <div style="margin-bottom: 0.5rem; background: rgba(111, 66, 193, 0.1); width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-inline: auto;">
                        <i class="fas fa-comments" style="color: #6f42c1; font-size: 1.1rem;"></i>
                    </div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #fff;">{{ $stream->chatMessages->count() }}</div>
                    <div style="text-transform: uppercase; font-size: 0.6rem; font-weight: 700; color: rgba(255,255,255,0.3);">Mensajes Chat</div>
                </div>

                <div class="sh-card-premium" style="padding: 1.25rem 0.75rem; text-align: center;">
                    <div style="margin-bottom: 0.5rem; background: rgba(255, 193, 7, 0.1); width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-inline: auto;">
                        <i class="fas fa-clock" style="color: #ffc107; font-size: 1.1rem;"></i>
                    </div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #fff;">{{ $stream->formatted_duration }}</div>
                    <div style="text-transform: uppercase; font-size: 0.6rem; font-weight: 700; color: rgba(255,255,255,0.3);">Duración</div>
                </div>
            </div>

            <div class="streaming-grid" style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                @if($stream->status != 'ended')
                <div class="sh-card-premium" style="padding: 1.25rem;">
                    <h3 class="sh-section-header">
                        <i class="fas fa-broadcast-tower"></i>
                        {{ __('model.streams.show.section_obs') }}
                    </h3>

                    <div id="obs-setup-container">
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                            <div class="obs-setup-step">
                                <h4><i class="fas fa-download"></i> {{ __('model.streams.show.step1_title') }}</h4>
                                <p>{{ __('model.streams.show.step1_desc') }}</p>
                                <a href="https://obsproject.com/" target="_blank" class="btn-control btn-view">
                                    <i class="fas fa-external-link-alt"></i>
                                    {{ __('model.streams.show.btn_download') }}
                                </a>
                            </div>
                            <div class="obs-setup-step">
                                <h4><i class="fas fa-cog"></i> {{ __('model.streams.show.step2_title') }}</h4>
                                <p>{{ __('model.streams.show.step2_desc') }}</p>
                                <button onclick="generateOBSConfig()" id="generateConfigBtn" class="btn-control btn-resume" style="background: var(--model-gold); color: #000; border: none;">
                                    <i class="fas fa-key"></i>
                                    {{ __('model.streams.show.btn_generate') }}
                                </button>
                            </div>
                        </div>
                        <div id="obs-instructions" style="display: none; margin-top: 1rem;"></div>
                        <div id="go-live-container"></div>
                    </div>
                </div>
                @endif

                @if($stream->status != 'ended')
                <div class="sh-card-premium" style="padding: 1.25rem;">
                    <h3 class="sh-section-header">
                        <i class="fas fa-gamepad"></i>
                        {{ __('model.streams.show.section_controls') }}
                    </h3>

                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        @if($stream->status === 'live')
                            <form action="{{ route('model.streams.pause', $stream) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-control btn-pause">
                                    <i class="fas fa-pause"></i>
                                    {{ __('model.streams.show.btn_pause') }}
                                </button>
                            </form>
                        @elseif($stream->status === 'paused')
                            <form action="{{ route('model.streams.resume', $stream) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-control btn-resume">
                                    <i class="fas fa-play"></i>
                                    {{ __('model.streams.show.btn_resume') }}
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('model.streams.end', $stream) }}" method="POST">
                            @csrf
                            <button type="submit" onclick="return confirm('¿Estás seguro de que quieres finalizar el stream?')" class="btn-control btn-end">
                                <i class="fas fa-stop"></i>
                                {{ __('model.streams.show.btn_end') }}
                            </button>
                        </form>

                        <a href="{{ route('streams.show', $stream) }}" target="_blank" class="btn-control btn-view">
                            <i class="fas fa-eye"></i>
                            {{ __('model.streams.show.btn_view_as_viewer') }}
                        </a>
                    </div>
                </div>
                @else
                <div class="sh-card-premium" style="padding: 1.5rem;">
                    <div style="display: flex; align-items: start; gap: 1rem; margin-bottom: 1.25rem;">
                        <div style="width: 40px; height: 40px; background: rgba(212, 175, 55, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fas fa-info-circle" style="color: var(--model-gold); font-size: 1.1rem;"></i>
                        </div>
                        <div>
                            <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.25rem; color: #fff;">Resumen de la Sesión</h3>
                            <p style="color: rgba(255, 255, 255, 0.4); font-size: 0.85rem; line-height: 1.4;">Resumen de interacción y tokens obtenidos.</p>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1.25rem;">
                        <div style="background: rgba(255,255,255,0.02); padding: 0.75rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.03);">
                            <div style="font-size: 0.6rem; color: rgba(255,255,255,0.3); text-transform: uppercase; font-weight: 700; margin-bottom: 0.25rem;">
                                <i class="fas fa-calendar-alt"></i> Inicio
                            </div>
                            <div style="font-weight: 700; font-size: 0.85rem; color: #fff;">{{ $stream->started_at ? $stream->started_at->format('d M, H:i') : 'N/A' }}</div>
                        </div>
                        <div style="background: rgba(255,255,255,0.02); padding: 0.75rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.03);">
                            <div style="font-size: 0.6rem; color: rgba(255,255,255,0.3); text-transform: uppercase; font-weight: 700; margin-bottom: 0.25rem;">
                                <i class="fas fa-clock"></i> Término
                            </div>
                            <div style="font-weight: 700; font-size: 0.85rem; color: #fff;">{{ $stream->ended_at ? $stream->ended_at->format('d M, H:i') : 'En curso' }}</div>
                        </div>
                    </div>

                    <a href="{{ route('model.streams.index') }}" class="btn-control btn-view" style="width: 100%;">
                        <i class="fas fa-arrow-left"></i> Volver a la lista
                    </a>
                </div>
                @endif
            </div>

            <div class="streaming-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="sh-card-premium" style="padding: 1.25rem; overflow: hidden;">
                    <h3 class="sh-section-header">
                        <i class="fas fa-comments" style="color: #6f42c1;"></i>
                        {{ __('model.streams.show.section_chat') }}
                    </h3>

                    <div id="chat-messages" style="height: 350px; overflow-y: auto; padding-right: 0.5rem;">
                        @php
                            $msgList = $stream->status == 'ended' ? $stream->chatMessages : $stream->chatMessages()->visible()->with('user')->latest()->take(20)->get()->reverse();
                        @endphp
                        @forelse($msgList as $message)
                            <div class="msg-bubble">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.25rem;">
                                    <span style="color: var(--model-gold); font-weight: 700; font-size: 0.8rem;">{{ $message->user->name }}</span>
                                    <span style="color: rgba(255,255,255,0.2); font-size: 0.65rem;">{{ $message->created_at->format('H:i') }}</span>
                                </div>
                                <div style="color: rgba(255,255,255,0.85); font-size: 0.85rem; line-height: 1.4;">{{ $message->message }}</div>
                            </div>
                        @empty
                            <div style="height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; opacity: 0.3;">
                                <i class="fas fa-comments" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                                <p style="font-size: 0.9rem;">Sin mensajes</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="sh-card-premium" style="padding: 1.25rem;">
                    <h3 class="sh-section-header">
                        <i class="fas fa-dollar-sign" style="color: #28a745;"></i>
                        {{ __('model.streams.show.section_tips') }}
                    </h3>

                    <div id="tip-list" style="height: 350px; overflow-y: auto; padding-right: 0.5rem;">
                        @php
                            $tipsList = $stream->status == 'ended' ? $stream->tips : $stream->tips()->with('fan')->latest()->take(10)->get();
                        @endphp
                        @forelse($tipsList as $tip)
                            <div class="tip-item-premium">
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <div style="width: 32px; height: 32px; background: rgba(255,255,255,0.05); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.5); font-size: 0.8rem;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 700; color: #fff; font-size: 0.8rem;">{{ $tip->fan->name }}</div>
                                        <div style="color: rgba(255,255,255,0.4); font-size: 0.65rem;">{{ $tip->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                                <div class="token-badge">{{ number_format($tip->amount, 0) }} TK</div>
                            </div>
                        @empty
                            <div style="height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; opacity: 0.3;">
                                <i class="fas fa-receipt" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                                <p style="font-size: 0.9rem;">Sin propinas</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
 </div>
        </div>
    </div>

    
    <script>
        // Inicializar variables globales
        let obsStreamingManager = null;

        // Header scroll effect
        window.addEventListener('scroll', function () {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Sidebar toggle function (if needed)
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar) {
                sidebar.classList.toggle('open');
            }
        }

        // Inicializar OBS Manager cuando se carga la página
        document.addEventListener('DOMContentLoaded', function () {
            initOBSManager();
        });

        // Inicializar OBS Manager
        function initOBSManager() {
            if (!obsStreamingManager) {
                obsStreamingManager = new OBSStreamingManager();
            }
            console.log('✅ OBS Manager inicializado');
        }

        // Generar configuración OBS
        async function generateOBSConfig() {
            try {


                if (!obsStreamingManager) {
                    obsStreamingManager = new OBSStreamingManager();
                }

                const config = await obsStreamingManager.generateOBSConfig({{ $stream->id }});

                // Mostrar instrucciones
                obsStreamingManager.showOBSInstructions(config);
                document.getElementById('obs-instructions').style.display = 'block';

                // Iniciar monitoreo de conexión
                obsStreamingManager.startConnectionMonitoring({{ $stream->id }});

                // Actualizar botón
                const btn = document.getElementById('generateConfigBtn');
                if (config.is_existing) {
                    btn.innerHTML = '<i class="fas fa-check"></i> Configuración Existente';
                    btn.style.background = 'rgba(40, 167, 69, 0.3)';

                } else {
                    btn.innerHTML = '<i class="fas fa-check"></i> Configuración Generada';
                    btn.style.background = 'rgba(40, 167, 69, 0.3)';

                }

            } catch (error) {
                console.error('Error generando configuración OBS:', error);

            }
        }

        // Función obsoleta - mantener para compatibilidad
        async function getDevices() {
            try {
                // Solicitar permisos primero para obtener etiquetas de dispositivos
                await navigator.mediaDevices.getUserMedia({ video: true, audio: true })
                    .then(stream => {
                        // Detener el stream temporal
                        stream.getTracks().forEach(track => track.stop());
                    })
                    .catch(() => {
                        console.log('Permisos no concedidos, continuando sin etiquetas');
                    });

                const devices = await navigator.mediaDevices.enumerateDevices();

                const cameraSelect = document.getElementById('cameraSelect');
                const microphoneSelect = document.getElementById('microphoneSelect');

                if (!cameraSelect || !microphoneSelect) {
                    console.error('Elementos de selección no encontrados');
                    return;
                }

                // Limpiar opciones
                cameraSelect.innerHTML = '';
                microphoneSelect.innerHTML = '';

                // Agregar cámaras
                const cameras = devices.filter(device => device.kind === 'videoinput');
                if (cameras.length === 0) {
                    cameraSelect.innerHTML = '<option>No se encontraron cámaras</option>';

                } else {
                    cameras.forEach((camera, index) => {
                        const option = document.createElement('option');
                        option.value = camera.deviceId;
                        option.text = camera.label || `Cámara ${index + 1}`;
                        cameraSelect.appendChild(option);
                    });

                }

                // Agregar micrófonos
                const microphones = devices.filter(device => device.kind === 'audioinput');
                if (microphones.length === 0) {
                    microphoneSelect.innerHTML = '<option>No se encontraron micrófonos</option>';
                } else {
                    microphones.forEach((microphone, index) => {
                        const option = document.createElement('option');
                        option.value = microphone.deviceId;
                        option.text = microphone.label || `Micrófono ${index + 1}`;
                        microphoneSelect.appendChild(option);
                    });
                }
            } catch (error) {
                console.error('Error obteniendo dispositivos:', error);


                // Fallback: agregar opciones por defecto
                const cameraSelect = document.getElementById('cameraSelect');
                const microphoneSelect = document.getElementById('microphoneSelect');

                if (cameraSelect) {
                    cameraSelect.innerHTML = '<option value="">Cámara por defecto</option>';
                }
                if (microphoneSelect) {
                    microphoneSelect.innerHTML = '<option value="">Micrófono por defecto</option>';
                }
            }
        }

        // Iniciar streaming SSE
        async function startCamera() {
            try {


                // Inicializar SSE streaming manager
                if (!sseStreamingManager) {
                    sseStreamingManager = new SSEStreamingManager();
                }

                const localVideo = document.getElementById('localVideo');
                if (!localVideo) {
                    throw new Error('Elemento de video no encontrado');
                }

                // Iniciar broadcast SSE
                const result = await sseStreamingManager.startBroadcast({{ $stream->id }}, localVideo);

                // Actualizar UI
                updateCameraStatus('live');


                isStreaming = true;

            } catch (error) {
                console.error('Error iniciando streaming SSE:', error);

                let errorMessage = error.message || 'Error al iniciar el streaming';


                updateCameraStatus('error');
            }
        }

        // Función para actualizar el estado de la cámara
        function updateCameraStatus(status) {
            const cameraStatus = document.getElementById('camera-status');
            const startBtn = document.getElementById('startCamera');
            const stopBtn = document.getElementById('stopCamera');
            const muteBtn = document.getElementById('toggleMute');

            if (!cameraStatus || !startBtn || !stopBtn || !muteBtn) return;

            switch (status) {
                case 'live':
                    cameraStatus.innerHTML = '<i class="fas fa-circle" style="color: #dc3545;"></i> Transmitiendo en vivo';
                    startBtn.style.display = 'none';
                    stopBtn.style.display = 'flex';
                    muteBtn.style.display = 'flex';
                    break;
                case 'disconnected':
                    cameraStatus.innerHTML = '<i class="fas fa-camera"></i> Cámara desconectada';
                    startBtn.style.display = 'flex';
                    stopBtn.style.display = 'none';
                    muteBtn.style.display = 'none';
                    break;
                case 'error':
                    cameraStatus.innerHTML = '<i class="fas fa-exclamation-triangle" style="color: #dc3545;"></i> Error de cámara';
                    startBtn.style.display = 'flex';
                    stopBtn.style.display = 'none';
                    muteBtn.style.display = 'none';
                    break;
            }
        }

        // Detener streaming SSE
        async function stopCamera() {
            try {
                if (sseStreamingManager) {
                    await sseStreamingManager.stopBroadcast();
                }

                const localVideo = document.getElementById('localVideo');
                if (localVideo) {
                    localVideo.srcObject = null;
                    localVideo.innerHTML = '';
                }

                // Actualizar UI
                updateCameraStatus('disconnected');


                isStreaming = false;

            } catch (error) {
                console.error('Error deteniendo streaming SSE:', error);

            }
        }

        // Toggle mute/unmute
        function toggleMute() {
            if (localStream) {
                const audioTrack = localStream.getAudioTracks()[0];
                if (audioTrack) {
                    audioTrack.enabled = !audioTrack.enabled;
                    isAudioMuted = !audioTrack.enabled;

                    const toggleButton = document.getElementById('toggleMute');
                    if (isAudioMuted) {
                        toggleButton.innerHTML = '<i class="fas fa-microphone-slash"></i> Audio OFF';
                        toggleButton.className = 'btn-camera btn-toggle-audio muted';
                    } else {
                        toggleButton.innerHTML = '<i class="fas fa-microphone"></i> Audio ON';
                        toggleButton.className = 'btn-camera btn-toggle-audio';
                    }
                }
            }
        }

        function hideMessage(messageId) {
            if (confirm('¿Ocultar este mensaje del chat?')) {
                fetch(`/chat/${messageId}/hide`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.querySelector(`[data-message-id="${messageId}"]`).remove();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        // Close sidebar when clicking outside (solo en mobile)
        document.addEventListener('click', function (event) {
            if (window.innerWidth <= 1024) {
                const sidebar = document.getElementById('sidebar');
                const target = event.target;

                if (!sidebar.contains(target) && !target.closest('[onclick="toggleSidebar()"]')) {
                    sidebar.classList.remove('open');
                }
            }
        });



        // Verificar compatibilidad del navegador
        function checkBrowserCompatibility() {
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                console.error('Tu navegador no es compatible con streaming. Usa Chrome, Firefox o Safari moderno.');
                return false;
            }

            if (!window.MediaRecorder) {
                console.warn('Funcionalidad de grabación no disponible en tu navegador.');
            }

            return true;
        }

        // Limpiar al salir de la página
        window.addEventListener('beforeunload', function () {
            if (localStream) {
                localStream.getTracks().forEach(track => track.stop());
            }
        });

        // Función de prueba de cámara
        async function testCamera() {
            try {


                // Probar acceso básico
                const testStream = await navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: true
                });

                // Mostrar información de los tracks
                const videoTracks = testStream.getVideoTracks();
                const audioTracks = testStream.getAudioTracks();

                let message = `✅ Cámara: ${videoTracks.length} dispositivo(s) encontrado(s)\n`;
                message += `✅ Audio: ${audioTracks.length} dispositivo(s) encontrado(s)\n`;

                if (videoTracks.length > 0) {
                    const videoTrack = videoTracks[0];
                    const settings = videoTrack.getSettings();
                    message += `📹 Resolución: ${settings.width}x${settings.height}\n`;
                    message += `🎥 FPS: ${settings.frameRate || 'N/A'}`;
                }

                // Detener el stream de prueba
                testStream.getTracks().forEach(track => track.stop());

                // Actualizar lista de dispositivos
                await getDevices();



            } catch (error) {
                console.error('Error en prueba de cámara:', error);

                let errorMessage = 'Error en la prueba: ';

                if (error.name === 'NotAllowedError') {
                    errorMessage += 'Permisos denegados. Haz clic en "Permitir" cuando el navegador te lo pida.';
                } else if (error.name === 'NotFoundError') {
                    errorMessage += 'No se encontraron dispositivos de cámara o micrófono.';
                } else if (error.name === 'NotReadableError') {
                    errorMessage += 'Dispositivos en uso por otra aplicación.';
                } else {
                    errorMessage += error.message || 'Error desconocido';
                }


            }
        }

        // Guardar configuración de streaming
        function saveStreamConfig() {
            const cameraSelect = document.getElementById('cameraSelect');
            const microphoneSelect = document.getElementById('microphoneSelect');
            const qualitySelect = document.getElementById('qualitySelect');
            const saveBtn = document.getElementById('saveConfigBtn');

            if (!cameraSelect || !microphoneSelect || !qualitySelect) {

                return;
            }

            const config = {
                camera_id: cameraSelect.value,
                camera_label: cameraSelect.options[cameraSelect.selectedIndex].text,
                microphone_id: microphoneSelect.value,
                microphone_label: microphoneSelect.options[microphoneSelect.selectedIndex].text,
                quality: qualitySelect.value
            };

            // Guardar en localStorage
            localStorage.setItem('streamConfig', JSON.stringify(config));

            // Feedback visual
            saveBtn.innerHTML = '<i class="fas fa-check"></i> Guardado';
            saveBtn.style.background = 'rgba(40, 167, 69, 0.3)';
            saveBtn.style.color = '#28a745';

            setTimeout(() => {
                saveBtn.innerHTML = '<i class="fas fa-save"></i> Guardar Configuración';
                saveBtn.style.background = 'rgba(40, 167, 69, 0.2)';
                saveBtn.style.color = '#28a745';
            }, 2000);


        }

        // Cargar configuración guardada
        function loadStreamConfig() {
            try {
                const savedConfig = localStorage.getItem('streamConfig');
                const configStatus = document.getElementById('config-status');

                if (!savedConfig) {
                    if (configStatus) {
                        configStatus.innerHTML = '<i class="fas fa-info-circle"></i> Sin configuración guardada';
                        configStatus.style.color = 'rgba(255, 255, 255, 0.5)';
                    }
                    return;
                }

                const config = JSON.parse(savedConfig);

                const cameraSelect = document.getElementById('cameraSelect');
                const microphoneSelect = document.getElementById('microphoneSelect');
                const qualitySelect = document.getElementById('qualitySelect');

                // Aplicar configuración guardada
                if (cameraSelect && config.camera_id) {
                    cameraSelect.value = config.camera_id;
                }

                if (microphoneSelect && config.microphone_id) {
                    microphoneSelect.value = config.microphone_id;
                }

                if (qualitySelect && config.quality) {
                    qualitySelect.value = config.quality;
                }

                // Actualizar indicador de estado
                if (configStatus) {
                    configStatus.innerHTML = '<i class="fas fa-check-circle"></i> Configuración cargada';
                    configStatus.style.color = '#28a745';
                }



            } catch (error) {
                console.error('Error cargando configuración:', error);
                const configStatus = document.getElementById('config-status');
                if (configStatus) {
                    configStatus.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Error cargando configuración';
                    configStatus.style.color = '#dc3545';
                }
            }
        }

        // Verificar compatibilidad al cargar
        document.addEventListener('DOMContentLoaded', function () {
            if (checkBrowserCompatibility()) {


                // Cargar configuración guardada después de detectar dispositivos
                setTimeout(() => {
                    loadStreamConfig();
                }, 3000);
            }
        });
    </script>

    
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script src="{{ asset('js/obs-streaming.js') }}"></script>

    
   
@endsection