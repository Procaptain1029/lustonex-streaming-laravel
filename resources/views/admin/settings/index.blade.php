@extends('layouts.admin')

@section('title', __('admin.settings.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.settings.breadcrumb') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Settings Professional Styling ----- */

        .sh-settings-layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 40px;
            padding-bottom: 120px;
            /* Space for sticky bar */
        }

        /* Sidebar Navigation */
        .sh-settings-sidebar {
            position: sticky;
            top: 100px;
            /* Adjust based on your header height */
            height: fit-content;
        }

        .sh-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            margin-bottom: 8px;
            border-radius: 8px;
            text-decoration: none;
            color: rgba(255, 255, 255, 0.6);
            font-size: 16px;
            font-weight: 600;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .sh-nav-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        .sh-nav-item.active {
            background: rgba(255, 255, 255, 0.08);
            /* Darker active background */
            color: #fff;
            border-left: 4px solid #111;
            /* Dark accent */
            padding-left: 16px;
            /* Adjust padding for border */
        }

        .sh-nav-item i {
            width: 20px;
            text-align: center;
        }

        /* Settings Sections */
        .sh-settings-section {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 32px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: box-shadow 0.2s ease-out, transform 0.2s ease-out;
            scroll-margin-top: 100px;
            /* For anchor scrolling */
        }

        .sh-settings-section:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

        .sh-section-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sh-section-icon {
            width: 40px;
            height: 40px;
            background: rgba(212, 175, 55, 0.1);
            color: var(--admin-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 1.2rem;
        }

        .sh-section-title {
            font-size: 22px;
            font-weight: 700;
            color: #dab843;
            margin: 0 0 4px 0;
        }

        .sh-section-desc {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.5);
            margin: 0;
        }

        /* Form Elements aligned with user request */
        .sh-form-group {
            margin-bottom: 24px;
        }

        .sh-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 8px;
        }

        .sh-input,
        .sh-select,
        .sh-textarea {
            width: 100%;
            background: rgba(0, 0, 0, 0.2);
            /* Darker background for input */
            border: 1px solid rgba(255, 255, 255, 0.1);
            /* Subtle border */
            border-radius: 8px;
            padding: 12px 16px;
            color: #fff;
            font-size: 16px;
            transition: all 0.2s ease;
        }

        .sh-input:focus,
        .sh-select:focus,
        .sh-textarea:focus {
            outline: none;
            border-color: #111;
            /* Focus color requested */
            background: rgba(0, 0, 0, 0.3);
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.05);
        }

        .sh-help {
            display: block;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.4);
            margin-top: 6px;
            line-height: 1.4;
        }

        /* Toggles / Switch */
        .sh-switch-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 16px;
            transition: background 0.2s;
        }

        .sh-switch-row:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .sh-switch-content {
            padding-right: 20px;
        }

        .sh-switch-title {
            font-weight: 600;
            font-size: 15px;
            color: #fff;
            display: block;
            margin-bottom: 4px;
        }

        .sh-switch-desc {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.5);
        }

        .sh-toggle {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 24px;
            flex-shrink: 0;
        }

        .sh-toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .sh-toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.2);
            transition: .3s;
            border-radius: 24px;
        }

        .sh-toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }

        input:checked+.sh-toggle-slider {
            background-color: var(--admin-gold);
        }

        input:checked+.sh-toggle-slider:before {
            transform: translateX(24px);
            background-color: #000;
        }

        /* Floating Save Bar */
        .sh-save-bar {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            background: #1a1a1a;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
            z-index: 1000;
            width: fit-content;
            animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from {
                transform: translate(-50%, 100%);
                opacity: 0;
            }

            to {
                transform: translate(-50%, 0);
                opacity: 1;
            }
        }

        .sh-btn-primary {
            background: #fff;
            color: #000;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: transform 0.2s;
            box-shadow: 0 2px 8px rgba(255, 255, 255, 0.2);
        }

        .sh-btn-primary:hover {
            transform: scale(1.02);
        }

        .sh-unsaved-text {
            color: rgba(255, 255, 255, 0.6);
            font-size: 13px;
        }

        .page-header {
            margin-bottom: 40px;
        }


        /* Responsive */
        @media (max-width: 768px) {
            .page-header {
                margin-bottom: 24px;
            }

            .sh-settings-layout {

                grid-template-columns: 1fr;
                gap: 20px;
                padding-bottom: 100px;
            }

            .sh-settings-sidebar {
                position: relative;
                top: 0;
                display: flex;
                overflow-x: auto;
                padding-bottom: 10px;
                margin-bottom: 0;
                -webkit-overflow-scrolling: touch;
            }

            .sh-settings-sidebar::-webkit-scrollbar {
                height: 3px;
            }

            .sh-settings-sidebar::-webkit-scrollbar-thumb {
                background: rgba(255, 255, 255, 0.1);
                border-radius: 3px;
            }

            .sh-nav-item {
                white-space: nowrap;
                margin-bottom: 0;
                margin-right: 8px;
                padding: 10px 16px;
                font-size: 14px;
                border-radius: 20px;
            }

            .sh-nav-item.active {
                border-left: none;
                padding-left: 16px;
                background: rgba(255, 255, 255, 0.1);
            }

            .sh-nav-item i {
                width: 16px;
                font-size: 13px;
            }

            .sh-settings-section {
                padding: 20px;
                margin-bottom: 20px;
                border-radius: 10px;
            }

            .sh-section-header {
                gap: 12px;
                margin-bottom: 20px;
                padding-bottom: 14px;
            }

            .sh-section-icon {
                width: 36px;
                height: 36px;
                border-radius: 8px;
                font-size: 1rem;
            }

            .sh-section-title {
                font-size: 18px;
            }

            .sh-section-desc {
                font-size: 13px;
            }

            .sh-form-group {
                margin-bottom: 20px;
            }

            .sh-label {
                font-size: 13px;
            }

            .sh-input,
            .sh-select,
            .sh-textarea {
                font-size: 14px;
                padding: 10px 14px;
            }

            /* Finance 2-col grid → 1 col */
            .sh-settings-section div[style*="grid-template-columns: 1fr 1fr"] {
                grid-template-columns: 1fr !important;
                gap: 16px !important;
            }

            .sh-switch-row {
                padding: 14px 16px;
                border-radius: 10px;
                margin-bottom: 12px;
            }

            .sh-switch-title {
                font-size: 14px;
            }

            .sh-switch-desc {
                font-size: 12px;
            }

            .sh-save-bar {
                left: 16px;
                right: 16px;
                bottom: 16px;
                transform: none;
                width: auto;
                border-radius: 12px;
                padding: 10px 16px;
                gap: 12px;
            }

            @keyframes slideUp {
                from {
                    transform: translateY(100%);
                    opacity: 0;
                }
                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }

            .sh-unsaved-text {
                font-size: 12px;
            }

            .sh-btn-primary {
                padding: 8px 18px;
                font-size: 13px;
            }
        }

        @media (max-width: 480px) {
            .sh-settings-section {

                padding: 16px;
                margin-bottom: 16px;
            }

            .sh-section-header {
                gap: 10px;
                margin-bottom: 16px;
                padding-bottom: 12px;
            }

            .sh-section-icon {
                width: 32px;
                height: 32px;
                font-size: 0.9rem;
            }

            .sh-section-title {
                font-size: 16px;
            }

            .sh-section-desc {
                font-size: 12px;
            }

            .sh-nav-item {
                padding: 8px 14px;
                font-size: 13px;
            }

            .sh-input,
            .sh-select,
            .sh-textarea {
                font-size: 13px;
                padding: 10px 12px;
            }

            .sh-switch-row {
                padding: 12px 14px;
                flex-wrap: wrap;
                gap: 10px;
            }

            .sh-switch-content {
                padding-right: 0;
            }

            .sh-save-bar {
                left: 12px;
                right: 12px;
                bottom: 12px;
                padding: 8px 14px;
                gap: 10px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title">{{ __('admin.settings.header_title') }}</h1>
        <p class="page-subtitle">{{ __('admin.settings.header_subtitle') }}</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" id="settingsForm">
        @csrf

        <div class="sh-settings-layout">
            <!-- Sidebar Navigation -->
            <aside class="sh-settings-sidebar">
                <a href="#general" class="sh-nav-item active" onclick="activateNav(this)">
                    <i class="fas fa-sliders-h"></i> {{ __('admin.settings.nav.general') }}
                </a>
                <a href="#finance" class="sh-nav-item" onclick="activateNav(this)">
                    <i class="fas fa-coins"></i> {{ __('admin.settings.nav.finance') }}
                </a>
                <a href="#media" class="sh-nav-item" onclick="activateNav(this)">
                    <i class="fas fa-photo-video"></i> {{ __('admin.settings.nav.media') }}
                </a>
                <a href="#security" class="sh-nav-item" onclick="activateNav(this)">
                    <i class="fas fa-shield-alt"></i> {{ __('admin.settings.nav.security') }}
                </a>
            </aside>

            <!-- Main Content -->
            <div class="sh-settings-content">

                <!-- General Section -->
                <section id="general" class="sh-settings-section">
                    <div class="sh-section-header">
                        <div class="sh-section-icon"><i class="fas fa-globe"></i></div>
                        <div>
                            <h2 class="sh-section-title">{{ __('admin.settings.general.title') }}</h2>
                            <p class="sh-section-desc">{{ __('admin.settings.general.desc') }}</p>
                        </div>
                    </div>

                    <div class="sh-form-group">
                        <label class="sh-label">{{ __('admin.settings.general.site_name') }}</label>
                        <input type="text" name="site_name" class="sh-input"
                            value="{{ old('site_name', $settings['site_name']) }}" required>
                    </div>

                    <div class="sh-form-group">
                        <label class="sh-label">{{ __('admin.settings.general.default_locale') }}</label>
                        <select name="default_locale" class="sh-select">
                            <option value="es" {{ old('default_locale', $settings['default_locale'] ?? 'es') == 'es' ? 'selected' : '' }}>{{ __('admin.settings.general.locales.es') }}</option>
                            <option value="en" {{ old('default_locale', $settings['default_locale'] ?? '') == 'en' ? 'selected' : '' }}>{{ __('admin.settings.general.locales.en') }}</option>
                            <option value="pt_BR" {{ old('default_locale', $settings['default_locale'] ?? '') == 'pt_BR' ? 'selected' : '' }}>{{ __('admin.settings.general.locales.pt_BR') }}</option>
                        </select>
                        <span class="sh-help">{{ __('admin.settings.general.locale_help') }}</span>
                    </div>

                    <div class="sh-form-group">
                        <label class="sh-label">{{ __('admin.settings.general.seo_desc') }}</label>
                        <textarea name="site_description" class="sh-textarea"
                            rows="3">{{ old('site_description', $settings['site_description']) }}</textarea>
                    </div>

                    <div class="sh-switch-row">
                        <div class="sh-switch-content">
                            <span class="sh-switch-title">{{ __('admin.settings.general.maintenance_mode') }}</span>
                            <span class="sh-switch-desc">{{ __('admin.settings.general.maintenance_mode_desc') }}</span>
                        </div>
                        <label class="sh-toggle">
                            <input type="hidden" name="maintenance_mode" value="0">
                            <input type="checkbox" name="maintenance_mode" value="1" {{ $settings['maintenance_mode'] ? 'checked' : '' }}>
                            <span class="sh-toggle-slider"></span>
                        </label>
                    </div>
                </section>

                <!-- Finance Section -->
                <section id="finance" class="sh-settings-section">
                    <div class="sh-section-header">
                        <div class="sh-section-icon"><i class="fas fa-wallet"></i></div>
                        <div>
                            <h2 class="sh-section-title">{{ __('admin.settings.finance.title') }}</h2>
                            <p class="sh-section-desc">{{ __('admin.settings.finance.desc') }}</p>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                        <div class="sh-form-group">
                            <label class="sh-label">{{ __('admin.settings.finance.commission_rate') }}</label>
                            <input type="number" name="commission_rate" class="sh-input"
                                value="{{ old('commission_rate', $settings['commission_rate']) }}" step="0.1" min="0"
                                max="100">
                        </div>

                        <div class="sh-form-group">
                            <label class="sh-label">{{ __('admin.settings.finance.min_withdrawal') }}</label>
                            <input type="number" name="min_withdrawal_amount" class="sh-input"
                                value="{{ old('min_withdrawal_amount', $settings['min_withdrawal_amount']) }}" step="1"
                                min="0">
                        </div>
                    </div>

                    <div class="sh-form-group">
                        <label class="sh-label">{{ __('admin.settings.finance.token_value') }}</label>
                        <input type="number" name="token_usd_rate" class="sh-input"
                            value="{{ old('token_usd_rate', $settings['token_usd_rate']) }}" step="0.001" min="0">
                        <span class="sh-help">{{ __('admin.settings.finance.token_help') }}</span>
                    </div>
                </section>

                <!-- Media Section -->
                <section id="media" class="sh-settings-section">
                    <div class="sh-section-header">
                        <div class="sh-section-icon"><i class="fas fa-play-circle"></i></div>
                        <div>
                            <h2 class="sh-section-title">{{ __('admin.settings.media.title') }}</h2>
                            <p class="sh-section-desc">{{ __('admin.settings.media.desc') }}</p>
                        </div>
                    </div>

                    <div class="sh-form-group">
                        <label class="sh-label">{{ __('admin.settings.media.stream_quality') }}</label>
                        <select name="stream_quality" class="sh-select">
                            <option value="sd" {{ $settings['stream_quality'] == 'sd' ? 'selected' : '' }}>{{ __('admin.settings.media.qualities.sd') }}</option>
                            <option value="hd" {{ $settings['stream_quality'] == 'hd' ? 'selected' : '' }}>{{ __('admin.settings.media.qualities.hd') }}</option>
                            <option value="fhd" {{ $settings['stream_quality'] == 'fhd' ? 'selected' : '' }}>{{ __('admin.settings.media.qualities.fhd') }}
                            </option>
                            <option value="4k" {{ $settings['stream_quality'] == '4k' ? 'selected' : '' }}>{{ __('admin.settings.media.qualities.4k') }}
                            </option>
                        </select>
                    </div>

                    <div class="sh-form-group">
                        <label class="sh-label">{{ __('admin.settings.media.upload_limit') }}</label>
                        <input type="number" name="max_upload_size" class="sh-input"
                            value="{{ old('max_upload_size', $settings['max_upload_size']) }}">
                    </div>
                </section>

                <!-- Security Section -->
                <section id="security" class="sh-settings-section">
                    <div class="sh-section-header">
                        <div class="sh-section-icon"><i class="fas fa-lock"></i></div>
                        <div>
                            <h2 class="sh-section-title">{{ __('admin.settings.security.title') }}</h2>
                            <p class="sh-section-desc">{{ __('admin.settings.security.desc') }}</p>
                        </div>
                    </div>

                    <div class="sh-switch-row">
                        <div class="sh-switch-content">
                            <span class="sh-switch-title">{{ __('admin.settings.security.allow_registrations') }}</span>
                            <span class="sh-switch-desc">{{ __('admin.settings.security.allow_registrations_desc') }}</span>
                        </div>
                        <label class="sh-toggle">
                            <input type="hidden" name="registration_enabled" value="0">
                            <input type="checkbox" name="registration_enabled" value="1" {{ $settings['registration_enabled'] ? 'checked' : '' }}>
                            <span class="sh-toggle-slider"></span>
                        </label>
                    </div>

                    <div class="sh-switch-row">
                        <div class="sh-switch-content">
                            <span class="sh-switch-title">{{ __('admin.settings.security.email_verification') }}</span>
                            <span class="sh-switch-desc">{{ __('admin.settings.security.email_verification_desc') }}</span>
                        </div>
                        <label class="sh-toggle">
                            <input type="hidden" name="email_verification_required" value="0">
                            <input type="checkbox" name="email_verification_required" value="1" {{ $settings['email_verification_required'] ? 'checked' : '' }}>
                            <span class="sh-toggle-slider"></span>
                        </label>
                    </div>
                </section>

            </div>
        </div>

        <!-- Floating Save Bar -->
        <div class="sh-save-bar">
            <span class="sh-unsaved-text"><i class="fas fa-info-circle"></i> {{ __('admin.settings.save.unsaved') }}</span>
            <button type="submit" class="sh-btn-primary">{{ __('admin.settings.save.button') }}</button>
        </div>

    </form>

    <script>
        function activateNav(element) {
            document.querySelectorAll('.sh-nav-item').forEach(el => el.classList.remove('active'));
            element.classList.add('active');
        }

        // Simple smooth scroll adjustment for sticky header if needed
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 120, // Offset for sticky header
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
@endsection