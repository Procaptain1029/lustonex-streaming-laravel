@extends('layouts.model')

@section('title', __('model.streams.create.title'))

@section('breadcrumb')
    <a href="{{ route('model.dashboard') }}" class="breadcrumb-item">Dashboard</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('model.streams.index') }}" class="breadcrumb-item">{{ __('model.streams.index.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('model.streams.create') }}" class="breadcrumb-item active">{{ __('model.streams.create.breadcrumb_new') }}</a>
@endsection

@section('styles')
    <style>
        .setup-container {
            padding: 1.5rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Glass Cards */
        .glass-card {
            background: rgba(31, 31, 35, 0.4);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(212, 175, 55, 0.1);
            border-radius: 24px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            position: relative;
        }

        .section-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.25rem;
            color: var(--model-gold);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid rgba(212, 175, 55, 0.1);
            padding-bottom: 1rem;
        }

        /* Custom Fields */
        .field-group {
            margin-bottom: 2rem;
        }

        .field-label {
            display: block;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
        }

        .glass-input,
        .glass-textarea {
            width: 100%;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            color: #fff;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .glass-input:focus {
            border-color: var(--model-gold);
            outline: none;
            background: rgba(0, 0, 0, 0.5);
        }

        /* OBS Config Blocks */
        .config-block {
            background: rgba(0, 0, 0, 0.4);
            border-radius: 18px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .config-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .config-label-text {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(212, 175, 55, 0.8);
            font-weight: 700;
        }

        .copy-panel {
            display: flex;
            gap: 10px;
            position: relative;
        }

        .copy-input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 12px 15px;
            color: #fff;
            font-family: 'Monaco', 'Consolas', monospace;
            font-size: 0.9rem;
            width: 100%;
            cursor: text;
        }

        .btn-copy-action {
            background: var(--model-gold);
            color: #000;
            border: none;
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-copy-action:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.4);
        }

        /* Step Indicators */
        .setup-steps {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .step-item {
            display: flex;
            gap: 1.5rem;
        }

        .step-badge {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(212, 175, 55, 0.1);
            color: var(--model-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            border: 1px solid rgba(212, 175, 55, 0.3);
            flex-shrink: 0;
        }

        .step-body h4 {
            color: #fff;
            margin-bottom: 0.5rem;
            font-family: 'Poppins', sans-serif;
        }

        .step-body p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        /* Connection Test */
        .test-zone {
            text-align: center;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .test-status {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .status-waiting {
            color: #ffc107;
        }

        .status-success {
            color: #28a745;
        }

        .pulse-amber {
            width: 10px;
            height: 10px;
            background: #ffc107;
            border-radius: 50%;
            animation: pulseAmber 2s infinite;
        }

        @keyframes pulseAmber {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(255, 193, 7, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(255, 193, 7, 0);
            }
        }

        .btn-main-start {
            background: var(--model-gold);
            color: #000;
            padding: 1.25rem 3.5rem;
            border-radius: 18px;
            font-weight: 800;
            font-size: 1.2rem;
            border: none;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: inline-flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-main-start:disabled {
            opacity: 0.4;
            filter: grayscale(1);
            cursor: not-allowed;
        }

        .btn-main-start:hover:not(:disabled) {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(212, 175, 55, 0.4);
        }

        .obs-help-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.05);
            padding: 6px 14px;
            border-radius: 30px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1.5rem;
        }

        /* --- RESPONSIVE DESIGN --- */

        /* Tablat (≤ 900px) */
        @media (max-width: 900px) {
            .setup-grid {
                grid-template-columns: 1fr !important;
                gap: 20px !important;
            }
        }

        /* Mobile (≤ 768px) */
        @media (max-width: 768px) {
            .setup-container {
                padding: 1rem 0.8rem;
            }

            .glass-card {
                padding: 1.25rem;
                border-radius: 16px;
                margin-bottom: 1.25rem;
            }

            .setup-grid > div {
                gap: 1.25rem !important;
            }

            .section-title {
                font-size: 1.05rem;
                margin-bottom: 1.25rem;
                padding-bottom: 0.75rem;
            }

            h1.page-title {
                font-size: 24px !important;
            }
            p.page-subtitle {
                font-size: 14px !important;
            }

            /* OBS Guide compact */
            .setup-steps {
                gap: 1.25rem;
            }

            .step-item {
                gap: 1rem;
            }

            .step-badge {
                width: 28px;
                height: 28px;
                font-size: 0.85rem;
            }

            .step-body h4 {
                font-size: 0.95rem;
                margin-bottom: 0.25rem;
            }

            .step-body p {
                font-size: 0.8rem;
                margin-bottom: 0;
            }

            /* Form Fields compact */
            .field-group {
                margin-bottom: 1.25rem;
            }

            .field-label {
                font-size: 0.8rem;
                margin-bottom: 0.5rem;
            }

            .glass-input, .glass-textarea {
                padding: 0.8rem 1rem;
                font-size: 0.95rem;
            }

            .glass-textarea {
                min-height: 80px;
            }

            .config-block {
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .config-label-text {
                font-size: 0.75rem;
            }

            .copy-input {
                padding: 10px 12px;
                font-size: 0.85rem;
            }

            .btn-main-start {
                padding: 1rem;
                font-size: 1rem;
                border-radius: 14px;
                width: 100%;
                justify-content: center;
            }

            .copy-panel {
                flex-direction: column;
                gap: 8px;
            }

            .copy-panel-row {
                display: flex;
                gap: 8px;
                width: 100%;
            }

            .btn-copy-action {
                height: 42px;
                border-radius: 8px;
                flex: 1;
            }

            .config-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
                margin-bottom: 0.75rem;
            }
        }

        /* Small Mobile (≤ 480px) */
        @media (max-width: 480px) {
            .glass-card {
                padding: 1rem;
                border-radius: 14px;
            }

            h1.page-title {
                font-size: 22px !important;
            }

            .section-title {
                font-size: 1rem;
                margin-bottom: 1rem;
                gap: 0.5rem;
            }

            .glass-input, .glass-textarea {
                padding: 0.75rem;
                font-size: 0.9rem;
            }

            .test-zone {
                padding: 1.25rem 1rem;
            }
            
            .obs-help-pill {
                padding: 5px 12px;
                font-size: 0.8rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="setup-container">
        <div style="margin-bottom: 3rem;">
            <h1 class="page-title" style="font-size: 28px; color: #d4af37; margin-bottom: 0.5rem; font-family: 'Poppins', sans-serif;">{{ __('model.streams.create.header') }}</h1>
            <p class="page-subtitle" style="color: #ffffff; font-size: 16px;">{{ __('model.streams.create.subtitle') }}</p>
        </div>

        <form action="{{ route('model.streams.store') }}" method="POST" id="mainSetupForm">
            @csrf

            <div class="setup-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">

                <div style="display: flex; flex-direction: column; gap: 2rem;">

                    <div class="glass-card">
                        <h3 class="section-title"><i class="fas fa-magic"></i> {{ __('model.streams.create.section_data') }}</h3>

                        <div class="field-group">
                            <label class="field-label">{{ __('model.streams.create.label_title') }}</label>
                            <input type="text" name="title" class="glass-input"
                                placeholder="{{ __('model.streams.create.placeholder_title') }}" value="{{ old('title') }}" required>
                        </div>

                        <div class="field-group">
                            <label class="field-label">{{ __('model.streams.create.label_description') }}</label>
                            <textarea name="description" class="glass-textarea" rows="4"
                                placeholder="{{ __('model.streams.create.placeholder_description') }}">{{ old('description') }}</textarea>
                        </div>
                    </div>


                    <div class="glass-card">
                        <h3 class="section-title"><i class="fas fa-terminal"></i> {{ __('model.streams.create.section_obs_guide') }}</h3>
                        <div class="setup-steps">
                            <div class="step-item">
                                <div class="step-badge">1</div>
                                <div class="step-body">
                                    <h4>{{ __('model.streams.create.step1_title') }}</h4>
                                    <p>{!! __('model.streams.create.step1_desc') !!}
                                    </p>
                                </div>
                            </div>
                            <div class="step-item">
                                <div class="step-badge">2</div>
                                <div class="step-body">
                                    <h4>{{ __('model.streams.create.step2_title') }}</h4>
                                    <p>{{ __('model.streams.create.step2_desc') }}</p>
                                </div>
                            </div>
                            <div class="step-item">
                                <div class="step-badge">3</div>
                                <div class="step-body">
                                    <h4>{{ __('model.streams.create.step3_title') }}</h4>
                                    <p>{{ __('model.streams.create.step3_desc') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div style="display: flex; flex-direction: column; gap: 2rem;">

                    <div class="glass-card" style="border-color: rgba(212, 175, 55, 0.3);">
                        <h3 class="section-title"><i class="fas fa-key"></i> {{ __('model.streams.create.section_credentials') }}</h3>

                        <div class="config-block">
                            <div class="config-header">
                                <span class="config-label-text">{{ __('model.streams.create.label_server_url') }}</span>
                            </div>
                            <div class="copy-panel">
                                <input type="text" value="rtmp://www.lustonex.com:1935/live" readonly class="copy-input"
                                    id="serverUrl">
                                <button type="button" class="btn-copy-action" onclick="copyVal('serverUrl', this)">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>

                        <div class="config-block">
                            <div class="config-header">
                                <span class="config-label-text">{{ __('model.streams.create.label_stream_key') }}</span>
                                <span style="font-size: 0.7rem; color: #ffc107; font-weight: 700;">{{ __('model.streams.create.warning_no_share') }}</span>
                            </div>
                            <div class="copy-panel">
                                <input type="password" value="{{ $profile->stream_key }}" readonly class="copy-input"
                                    id="streamKey">
                                <div class="copy-panel-row">
                                    <button type="button" class="btn-copy-action"
                                        style="background: rgba(255,255,255,0.1); color: #fff;"
                                        onclick="toggleVisibility('streamKey')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn-copy-action" onclick="copyVal('streamKey', this)">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                    <button type="button" class="btn-copy-action"
                                        style="background: rgba(13, 110, 253, 0.2); color: #007bff; border: 1px solid rgba(13, 110, 253, 0.3);"
                                        onclick="regenerateKey(this)" title="{{ __('model.streams.create.swal.regenerate_title') }}">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div
                            style="display: flex; align-items: center; gap: 10px; font-size: 0.8rem; color: rgba(255,255,255,0.4); padding: 0 0.5rem;">
                            <i class="fas fa-shield-alt" style="color: #28a745;"></i>
                            {{ __('model.streams.create.hint_key') }}
                        </div>
                    </div>


                    <div class="glass-card" style="flex: 1; display: flex; flex-direction: column;">
                        <h3 class="section-title"><i class="fas fa-signal"></i> {{ __('model.streams.create.section_status') }}</h3>

                        <div class="test-zone"
                            style="flex: 1; display: flex; flex-direction: column; justify-content: center;">
                            <div id="connectionStatus" class="test-status status-waiting">
                                <div class="pulse-amber"></div>
                                {{ __('model.streams.create.status_waiting') }}
                            </div>

                            <p style="color: rgba(255,255,255,0.4); font-size: 0.85rem; margin-bottom: 2rem;">
                                {{ __('model.streams.create.status_desc') }}
                            </p>

                            <div style="margin-top: auto;">
                                <button type="button" class="obs-help-pill" onclick="checkStatusManual()">
                                    <i class="fas fa-sync-alt"></i> {{ __('model.streams.create.btn_manual_check') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div style="text-align: center; margin-top: 4rem;">
                <button type="submit" class="btn-main-start" id="startBtn" disabled>
                    <i class="fas fa-lock"></i> {{ __('model.streams.create.btn_start') }}
                </button>
                <p style="color: rgba(255,255,255,0.3); font-size: 0.85rem; margin-top: 1rem;">
                    {{ __('model.streams.create.hint_start') }}
                </p>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        function copyVal(id, btn) {
            const input = document.getElementById(id);
            const originalType = input.type;
            input.type = 'text';
            input.select();
            document.execCommand('copy');
            input.type = originalType;

            const oldContent = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i>';
            btn.style.background = '#28a745';

            setTimeout(() => {
                btn.innerHTML = oldContent;
                btn.style.background = '';
            }, 2000);

            Swal.fire({
                icon: 'success',
                title: '{{ __('model.streams.create.swal.copied_title') }}',
                text: '{{ __('model.streams.create.swal.copied_text') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                background: '#1f1f23',
                color: '#fff'
            });
        }

        function toggleVisibility(id) {
            const input = document.getElementById(id);
            const btn = event.currentTarget;
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }

        function regenerateKey(btn) {
            Swal.fire({
                title: '{{ __('model.streams.create.swal.regenerate_title') }}',
                text: '{{ __('model.streams.create.swal.regenerate_text') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d4af37',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '{{ __('model.streams.create.swal.regenerate_confirm') }}',
                background: '#1f1f23',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    const oldContent = btn.innerHTML;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    btn.disabled = true;

                    fetch("{{ route('model.obs.generate-key') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('streamKey').value = data.stream_key;
                                Swal.fire({
                                    icon: 'success',
                                    title: '{{ __('model.streams.create.swal.regenerate_success_title') }}',
                                    text: '{{ __('model.streams.create.swal.regenerate_success_text') }}',
                                    background: '#1f1f23',
                                    color: '#fff'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: '{{ __('model.streams.create.swal.error_title') }}',
                                    text: data.message || '{{ __('model.streams.create.swal.error_text') }}',
                                    background: '#1f1f23',
                                    color: '#fff'
                                });
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            Swal.fire({
                                icon: 'error',
                                title: '{{ __('model.streams.create.swal.server_error_title') }}',
                                text: '{{ __('model.streams.create.swal.server_error_text') }}',
                                background: '#1f1f23',
                                color: '#fff'
                            });
                        })
                        .finally(() => {
                            btn.innerHTML = oldContent;
                            btn.disabled = false;
                        });
                }
            });
        }

        // Detección de señal real
        let checkInterval = null;
        const streamKeyToCheck = "{{ $profile->stream_key }}";

        function startAutoCheck() {
            if (checkInterval) clearInterval(checkInterval);

            checkInterval = setInterval(() => {
                checkStatusReal();
            }, 3000);
        }

        async function checkStatusReal() {
            try {
                const response = await fetch(`/api/rtmp/check-signal/${streamKeyToCheck}`);
                const data = await response.json();

                if (data.active) {
                    const statusBox = document.getElementById('connectionStatus');
                    const startBtn = document.getElementById('startBtn');

                    statusBox.innerHTML = '<i class="fas fa-check-circle" style="color: #28a745;"></i> {{ __('model.streams.create.status_success') }}';
                    statusBox.className = 'test-status status-success';

                    startBtn.disabled = false;
                    startBtn.innerHTML = '<i class="fas fa-broadcast-tower"></i> {{ __('model.streams.create.btn_start_live') }}';

                    // Detener el polling una vez detectado
                    clearInterval(checkInterval);

                    Swal.fire({
                        icon: 'success',
                        title: '{{ __('model.streams.create.swal.success_conn_title') }}',
                        text: '{{ __('model.streams.create.swal.success_conn_text') }}',
                        background: '#1f1f23',
                        color: '#fff',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000
                    });
                }
            } catch (error) {
                console.error('Error verificando señal:', error);
            }
        }

        function checkStatusManual() {
            const btn = event.currentTarget;
            const oldContent = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __('model.streams.create.swal.loading_check') }}';
            btn.disabled = true;

            checkStatusReal().finally(() => {
                setTimeout(() => {
                    btn.innerHTML = oldContent;
                    btn.disabled = false;
                }, 1000);
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            startAutoCheck();
        });
    </script>
@endsection