@extends('layouts.admin')

@section('title', __('admin.token_packages.create_title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('admin.token-packages.index') }}" class="breadcrumb-item">{{ __('admin.token_packages.breadcrumb') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.token_packages.create_title') }}</span>
@endsection

@section('styles')
    <style>
        .sh-page-grid {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 30px;
            align-items: start;
            max-width: 1400px;
            margin: 0 auto;
        }

        .sh-form-column {
            min-width: 0;
        }

        .sh-guide-column {
            position: sticky;
            top: 30px;
        }

        .sh-guide-card {
            background: rgba(20, 20, 25, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 25px;
            backdrop-filter: blur(10px);
        }

        .sh-guide-title {
            color: #fff;
            font-size: 1rem;
            font-weight: 800;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sh-guide-section {
            margin-bottom: 25px;
        }

        .sh-guide-subtitle {
            color: var(--admin-gold);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 12px;
            letter-spacing: 1px;
        }

        .sh-guide-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sh-guide-list li {
            margin-bottom: 10px;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.5;
            display: flex;
            gap: 10px;
        }

        .sh-guide-list li i {
            color: var(--admin-gold);
            margin-top: 4px;
            font-size: 0.7rem;
        }

        .sh-code-badge {
            background: rgba(0, 0, 0, 0.3);
            padding: 2px 6px;
            border-radius: 4px;
            font-family: monospace;
            color: #fff;
            font-size: 0.8rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        @media (max-width: 1200px) {
            .sh-page-grid {
                grid-template-columns: 1fr 300px;
            }
        }

        @media (max-width: 992px) {
            .sh-page-grid {
                grid-template-columns: 1fr;
            }

            .sh-guide-column {
                position: static;
                order: 2;
            }

            .sh-guide-card {
                margin-top: 30px;
            }
        }

        .sh-form-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .sh-form-section {
            margin-bottom: 35px;
            padding-bottom: 25px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sh-form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .sh-section-title {
            font-size: 0.85rem;
            font-weight: 800;
            color: var(--admin-gold);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sh-section-title i {
            font-size: 1rem;
            opacity: 0.8;
        }

        .sh-form-group {
            margin-bottom: 25px;
        }

        .sh-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sh-input,
        .sh-select,
        .sh-textarea {
            width: 100%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 12px 18px;
            color: #fff;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .sh-input:focus,
        .sh-select:focus,
        .sh-textarea:focus {
            outline: none;
            border-color: var(--admin-gold);
            background: rgba(255, 255, 255, 0.05);
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.1);
        }

        .sh-input-group {
            display: flex;
            align-items: stretch;
        }

        .sh-input-addon {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-right: none;
            padding: 0 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.6);
            border-radius: 12px 0 0 12px;
            font-weight: 600;
        }

        .sh-input-group .sh-input {
            border-radius: 0 12px 12px 0;
        }

        .sh-form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 40px;
        }

        .sh-btn {
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: none;
            text-decoration: none;
        }

        .sh-btn-primary {
            background: linear-gradient(135deg, var(--admin-gold), #f4e37d);
            color: #000;
        }

        .sh-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
            color: #000;
        }

        .sh-btn-secondary {
            background: rgba(255, 255, 255, 0.03);
            color: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sh-btn-secondary:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
        }

        .sh-reward-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .sh-toggle {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            user-select: none;
        }

        .sh-toggle input {
            display: none;
        }

        .sh-toggle-track {
            width: 44px;
            height: 22px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            position: relative;
            transition: all 0.3s ease;
        }

        .sh-toggle-thumb {
            width: 16px;
            height: 16px;
            background: #fff;
            border-radius: 50%;
            position: absolute;
            top: 3px;
            left: 3px;
            transition: all 0.3s ease;
        }

        .sh-toggle input:checked+.sh-toggle-track {
            background: #10b981;
        }

        .sh-toggle input:checked+.sh-toggle-track .sh-toggle-thumb {
            left: 25px;
        }

        .sh-error-alert {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #ef4444;
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 24px;
        }
        
        .sh-error-alert ul { margin: 0; padding-left: 20px; }

        @media (max-width: 768px) {
            .sh-reward-grid {
                grid-template-columns: 1fr;
            }

            .sh-form-card {
                padding: 25px;
            }
        }

        @media (max-width: 600px) {
            .sh-form-card {

                padding: 20px;
                border-radius: 20px;
            }

            .sh-section-title {
                margin-bottom: 20px;
                font-size: 0.8rem;
            }

            .sh-form-group {
                margin-bottom: 20px;
            }

            .sh-input,
            .sh-select,
            .sh-textarea {
                padding: 12px 15px;
                font-size: 0.9rem;
            }

            .sh-form-actions {
                flex-direction: column-reverse;
                gap: 15px;
                margin-top: 30px;
            }

            .sh-btn {
                width: 100%;
                justify-content: center;
                padding: 15px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title">{{ __('admin.token_packages.create_header') }}</h1>
        <p class="page-subtitle">{{ __('admin.token_packages.create_subtitle') }}</p>
    </div>


    <div class="sh-page-grid">
        
        <div class="sh-form-column">
            <div class="sh-form-card">
                @if($errors->any())
                    <div class="sh-error-alert">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.token-packages.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="timezone" id="timezone_input">

                    
                    <div class="sh-form-section">
                        <h3 class="sh-section-title"><i class="fas fa-box"></i> {{ __('admin.token_packages.form.config_title') }}</h3>

                        <div class="sh-form-group">
                            <label class="sh-label">{{ __('admin.token_packages.form.name_label') }}</label>
                            <input type="text" name="name" class="sh-input" value="{{ old('name') }}"
                                placeholder="{{ __('admin.token_packages.form.name_placeholder') }}" required>
                        </div>

                        <div class="sh-reward-grid">
                            <div class="sh-form-group">
                                <label class="sh-label">{{ __('admin.token_packages.form.tokens_label') }}</label>
                                <div style="position: relative;">
                                    <input type="number" name="tokens" class="sh-input" value="{{ old('tokens') }}"
                                        min="1" style="padding-left: 45px;" required>
                                    <i class="fas fa-coins"
                                        style="position: absolute; left: 18px; top: 15px; color: var(--admin-gold);"></i>
                                </div>
                            </div>

                            <div class="sh-form-group">
                                <label class="sh-label">{{ __('admin.token_packages.form.bonus_label') }}</label>
                                <div style="position: relative;">
                                    <input type="number" name="bonus" class="sh-input" value="{{ old('bonus', 0) }}"
                                        min="0" style="padding-left: 45px;" required>
                                    <i class="fas fa-gift"
                                        style="position: absolute; left: 18px; top: 15px; color: #10b981;"></i>
                                </div>
                            </div>
                        </div>

                        <div class="sh-form-group">
                            <label class="sh-label">{{ __('admin.token_packages.form.price_label') }}</label>
                            <div class="sh-input-group">
                                <span class="sh-input-addon"><i class="fas fa-dollar-sign"></i></span>
                                <input type="number" step="0.01" name="price" class="sh-input" value="{{ old('price') }}" required min="0.01" placeholder="0.00">
                            </div>
                        </div>
                    </div>

                    
                    <div class="sh-form-section">
                        <h3 class="sh-section-title"><i class="fas fa-sliders-h"></i> {{ __('admin.token_packages.form.availability_title') }}</h3>

                        <div class="sh-reward-grid">
                            <div class="sh-form-group" style="display: flex; align-items: flex-end; padding-bottom: 22px;">
                                <label class="sh-toggle">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <div class="sh-toggle-track">
                                        <div class="sh-toggle-thumb"></div>
                                    </div>
                                    <div>
                                        <span class="sh-label" style="margin-bottom: 2px;">{{ __('admin.token_packages.form.active_label') }}</span>
                                        <span style="font-size: 0.75rem; color: rgba(255,255,255,0.4);">{{ __('admin.token_packages.form.active_desc') }}</span>
                                    </div>
                                </label>
                            </div>

                            <div class="sh-form-group" style="display: flex; align-items: flex-end; padding-bottom: 22px;">
                                <label class="sh-toggle">
                                    <input type="checkbox" id="is_limited_time" name="is_limited_time" value="1" {{ old('is_limited_time') ? 'checked' : '' }} onchange="toggleExpiresAt()">
                                    <div class="sh-toggle-track">
                                        <div class="sh-toggle-thumb"></div>
                                    </div>
                                    <div>
                                        <span class="sh-label" style="margin-bottom: 2px;">{{ __('admin.token_packages.form.limited_label') }}</span>
                                        <span style="font-size: 0.75rem; color: rgba(255,255,255,0.4);">{{ __('admin.token_packages.form.limited_desc') }}</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="sh-form-group" id="expires_at_container" style="{{ old('is_limited_time') ? '' : 'display: none;' }}">
                            <label class="sh-label">{{ __('admin.token_packages.form.expires_label') }}</label>
                            <input type="datetime-local" class="sh-input" id="expires_at" name="expires_at" value="{{ old('expires_at') }}">
                        </div>
                    </div>

                    <div class="sh-form-actions">
                        <a href="{{ route('admin.token-packages.index') }}" class="sh-btn sh-btn-secondary">{{ __('admin.token_packages.form.cancel') }}</a>
                        <button type="submit" class="sh-btn sh-btn-primary">
                            <i class="fas fa-save"></i> {{ __('admin.token_packages.form.create_btn') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        
        <div class="sh-guide-column">
            <div class="sh-guide-card">
                <h3 class="sh-guide-title"><i class="fas fa-book"></i> {{ __('admin.token_packages.guide.title') }}</h3>

                <div class="sh-guide-section">
                    <h4 class="sh-guide-subtitle">{{ __('admin.token_packages.guide.bonus_title') }}</h4>
                    <ul class="sh-guide-list">
                        <li>
                            <i class="fas fa-chevron-right"></i>
                            <div>{{ __('admin.token_packages.guide.bonus_desc') }}</div>
                        </li>
                    </ul>
                </div>

                <div class="sh-guide-section">
                    <h4 class="sh-guide-subtitle">{{ __('admin.token_packages.guide.popular_title') }}</h4>
                    <ul class="sh-guide-list">
                        <li><i class="fas fa-dot-circle"></i> <span><span class="sh-code-badge">{{ __('admin.token_packages.guide.pop_1_val') }}</span><br>{{ __('admin.token_packages.guide.pop_1_desc') }}</span></li>
                        <li><i class="fas fa-dot-circle"></i> <span><span class="sh-code-badge">{{ __('admin.token_packages.guide.pop_2_val') }}</span><br>{{ __('admin.token_packages.guide.pop_2_desc') }}</span></li>
                        <li><i class="fas fa-dot-circle"></i> <span><span class="sh-code-badge">{{ __('admin.token_packages.guide.pop_3_val') }}</span><br>{{ __('admin.token_packages.guide.pop_3_desc') }}</span></li>
                    </ul>
                </div>

                <div class="sh-guide-section">
                    <h4 class="sh-guide-subtitle">{{ __('admin.token_packages.guide.time_title') }}</h4>
                    <p style="color: rgba(255,255,255,0.6); font-size: 0.8rem; line-height: 1.5;">
                        {!! __('admin.token_packages.guide.time_desc') !!}
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function toggleExpiresAt() {
        const checkbox = document.getElementById('is_limited_time');
        const container = document.getElementById('expires_at_container');
        const input = document.getElementById('expires_at');
        
        if (checkbox.checked) {
            container.style.display = 'block';
            input.required = true;
            
            container.style.opacity = 0;
            setTimeout(() => {
                container.style.transition = 'opacity 0.3s ease';
                container.style.opacity = 1;
            }, 10);
        } else {
            container.style.opacity = 0;
            setTimeout(() => {
                container.style.display = 'none';
                input.required = false;
            }, 300);
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        toggleExpiresAt();
        
        // Populate timezone
        try {
            document.getElementById('timezone_input').value = Intl.DateTimeFormat().resolvedOptions().timeZone;
        } catch (e) {
            document.getElementById('timezone_input').value = 'UTC';
        }
    });
</script>
@endsection
