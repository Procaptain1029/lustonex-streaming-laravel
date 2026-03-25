@extends('layouts.model')

@section('title', __('model.profile.edit.title_tag'))

@section('breadcrumb')
    <a href="{{ route('model.dashboard') }}" class="breadcrumb-item">{{ __('model.profile.edit.breadcrumb_dashboard') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('model.profile.edit.breadcrumb_active') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Model Profile Premium Styling ----- */

        /* 0. Background Vibe */
        .content-wrapper {
            position: relative;
        }

        .content-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 600px;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.08) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        /* 1. Hero */
        .page-header {
            padding-top: 32px;
            margin-bottom: 28px;
            position: relative;
            z-index: 10;
        }

        /* Estilos de encabezado heredados del layout model */

        /* 2. Layout & Cards */
        .sh-profile-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 40px;
            max-width: 1200px;
            padding-bottom: 100px;
            position: relative;
            z-index: 10;
        }

        .sh-card {
            background: linear-gradient(145deg, rgba(30, 30, 35, 0.6), rgba(15, 15, 18, 0.9));
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 36px;
            margin-bottom: 32px;
            position: relative;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255,255,255,0.05);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .sh-card:hover {
            border-color: rgba(212, 175, 55, 0.2);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5), 0 0 20px rgba(212, 175, 55, 0.05);
            transform: translateY(-4px);
        }

        .sh-section-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 30px;
            color: #dab843;
            display: flex;
            align-items: center;
            gap: 12px;
            letter-spacing: 0.5px;
        }

        .sh-section-title i {
            color: var(--model-gold);
            font-size: 1.3rem;
            filter: drop-shadow(0 0 8px rgba(212, 175, 55, 0.4));
            transition: transform 0.3s ease;
        }

        .sh-card:hover .sh-section-title i {
            transform: scale(1.15) rotate(5deg);
        }

        .sh-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 28px;
        }

        /* 3. Photo Uploads */
        .sh-photo-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
            margin-bottom: 10px;
        }

        .sh-avatar-wrapper {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .sh-avatar-preview {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            background: #000;
            transition: border-color 0.3s;
            flex-shrink: 0;
        }

        .sh-avatar-wrapper:hover .sh-avatar-preview {
            border-color: rgba(212, 175, 55, 0.3);
        }

        .sh-upload-btn-container {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .sh-upload-btn {
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: 1px dashed rgba(212, 175, 55, 0.5);
            background: rgba(212, 175, 55, 0.05);
            color: var(--model-gold);
            transition: all 0.3s;
            text-align: center;
            letter-spacing: 0.5px;
        }

        .sh-upload-btn:hover {
            background: rgba(212, 175, 55, 0.15);
            border-color: var(--model-gold);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.1);
        }

        .sh-cover-preview {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 16px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.3);
            transition: border-color 0.3s;
        }

        .sh-cover-preview:hover {
            border-color: rgba(212, 175, 55, 0.3);
        }

        /* 4. Form Elements */
        .sh-form-group {
            margin-bottom: 24px;
        }

        .sh-label {
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 10px;
            display: block;
            color: rgba(255, 255, 255, 0.6);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sh-input,
        .sh-select,
        .sh-textarea {
            width: 100%;
            padding: 16px 20px;
            font-size: 15px;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            background: rgba(0, 0, 0, 0.4);
            color: #fff;
            transition: all 0.3s;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.2);
            box-sizing: border-box;
        }

        .sh-input::placeholder,
        .sh-textarea::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .sh-input:hover,
        .sh-select:hover,
        .sh-textarea:hover {
            border-color: rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.5);
        }

        .sh-input:focus,
        .sh-select:focus,
        .sh-textarea:focus {
            outline: none;
            border-color: var(--model-gold);
            background: rgba(0, 0, 0, 0.6);
            box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.1), inset 0 2px 4px rgba(0,0,0,0.2);
        }

        .sh-textarea {
            min-height: 140px;
            resize: vertical;
            line-height: 1.6;
        }

        /* 5. Checkboxes / Chips */
        .sh-chips-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 10px;
        }

        .sh-chip-checkbox {
            position: relative;
        }

        .sh-chip-checkbox input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
            z-index: 2;
        }

        .sh-chip-label {
            display: block;
            padding: 10px 12px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
        }

        .sh-chip-checkbox input:checked+.sh-chip-label {
            background: rgba(212, 175, 55, 0.15);
            border-color: var(--model-gold);
            color: var(--model-gold);
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.15);
            transform: translateY(-2px);
        }

        .sh-chip-checkbox:hover .sh-chip-label {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
        }

        /* 6. Social Inputs */
        .sh-social-group {
            position: relative;
            margin-bottom: 20px;
        }

        .sh-social-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.4);
            font-size: 18px;
            transition: color 0.3s;
        }

        .sh-social-input {
            padding-left: 56px !important;
        }

        .sh-social-input:focus ~ .sh-social-icon {
            color: var(--model-gold);
        }

        /* 7. Action Bar */
        .sh-action-bar {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .sh-btn-save {
            padding: 16px 48px;
            font-size: 16px;
            font-weight: 800;
            border-radius: 16px;
            background: linear-gradient(135deg, #d4af37, #ffdf73, #d4af37);
            background-size: 200% auto;
            color: #111;
            border: none;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.4);
            transition: all 0.4s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sh-btn-save:hover {
            background-position: right center;
            transform: translateY(-4px);
            box-shadow: 0 15px 40px rgba(212, 175, 55, 0.6);
        }

        .sh-btn-save:active {
            transform: translateY(0);
        }

        /* ==================== RESPONSIVE ==================== */

        /* Tablet */
        @media (max-width: 900px) {
            .sh-profile-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .sh-avatar-wrapper {
                flex-direction: column;
                text-align: center;
            }

            .sh-avatar-preview {
                width: 110px;
                height: 110px;
            }

            .sh-upload-btn-container {
                align-items: center;
                width: 100%;
            }

            .sh-upload-btn {
                width: 100%;
            }
        }

        /* Móvil grande (≤ 768px) */
        @media (max-width: 768px) {
            .page-header {
                padding-top: 16px;
                margin-bottom: 16px;
            }

            /* Estilos responsivos de encabezado heredados */

            .sh-card {
                padding: 20px 16px;
                margin-bottom: 16px;
                border-radius: 18px;
            }

            .sh-card:hover {
                transform: none; /* disable lift on mobile */
            }

            .sh-section-title {
                font-size: 16px;
                margin-bottom: 20px;
            }

            .sh-form-row {
                grid-template-columns: 1fr;
                gap: 14px;
                margin-bottom: 14px;
            }

            .sh-input,
            .sh-select,
            .sh-textarea {
                padding: 13px 16px;
                font-size: 14px;
                border-radius: 12px;
            }

            .sh-social-input {
                padding-left: 48px !important;
            }

            .sh-social-icon {
                left: 16px;
                font-size: 16px;
            }

            .sh-cover-preview {
                height: 140px;
                border-radius: 12px;
            }

            .sh-chips-grid {
                grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
                gap: 8px;
            }

            .sh-chip-label {
                padding: 9px 8px;
                font-size: 12px;
                border-radius: 10px;
            }

            /* Floating save button — respects device safe area */
            .sh-action-bar {
                position: fixed;
                bottom: 0;
                bottom: env(safe-area-inset-bottom, 0px);
                left: 0;
                right: 0;
                z-index: 100;
                margin-top: 0;
                padding: 12px 16px;
                padding-bottom: max(12px, env(safe-area-inset-bottom, 12px));
                background: rgba(11, 11, 13, 0.95);
                backdrop-filter: blur(14px);
                -webkit-backdrop-filter: blur(14px);
                border-top: 1px solid rgba(255, 255, 255, 0.07);
                justify-content: stretch;
            }

            .sh-btn-save {
                width: 100%;
                text-align: center;
                padding: 16px;
                font-size: 15px;
                box-shadow: 0 8px 24px rgba(0,0,0,0.4), 0 0 16px rgba(212, 175, 55, 0.2);
            }

            /* Extra padding so last content not hidden under button bar */
            .sh-profile-grid {
                padding-bottom: 90px;
            }
        }

        /* Móvil pequeño (≤ 480px) */
        @media (max-width: 480px) {
            /* Estilos responsivos heredados */

            .sh-card {
                padding: 16px 12px;
                border-radius: 14px;
            }

            .sh-input,
            .sh-select,
            .sh-textarea {
                padding: 11px 14px;
                font-size: 14px;
                border-radius: 10px;
            }

            .sh-social-input {
                padding-left: 44px !important;
            }

            .sh-avatar-preview {
                width: 90px;
                height: 90px;
            }

            .sh-cover-preview {
                height: 120px;
            }

            .sh-chips-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 7px;
            }

            .sh-chip-label {
                padding: 8px 6px;
                font-size: 11px;
            }

            .sh-label {
                font-size: 10px;
                letter-spacing: 0.5px;
            }

            .sh-form-group {
                margin-bottom: 16px;
            }
        }
    </style>
@endsection

@section('content')

    <div class="page-header">
        <h1 class="page-title">{{ __('model.profile.edit.header_title') }}</h1>
        <p class="page-subtitle">{{ __('model.profile.edit.header_subtitle') }}</p>
    </div>

    <form action="{{ route('model.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="sh-profile-grid">
            <!-- Main Content -->
            <div>
                <!-- Identity Section -->
                <div class="sh-card">
                    <div class="sh-section-title">
                        {{ __('model.profile.edit.section_public') }}
                    </div>

                    <div class="sh-form-group">
                        <label class="sh-label">{{ __('model.profile.edit.label_display_name') }}</label>
                        <input type="text" name="display_name" class="sh-input"
                            value="{{ old('display_name', $profile->display_name) }}" placeholder="{{ __('model.profile.edit.placeholder_display_name') }}">
                    </div>

                    <div class="sh-form-group">
                        <label class="sh-label">{{ __('model.profile.edit.label_bio') }}</label>
                        <textarea name="bio" class="sh-textarea"
                            placeholder="{{ __('model.profile.edit.placeholder_bio') }}">{{ old('bio', $profile->bio) }}</textarea>
                    </div>

                    <div class="sh-form-group">
                        <label class="sh-label">{{ __('model.profile.edit.label_subscription_price') }}</label>
                        <div style="position: relative;">
                            <input type="number" name="subscription_price" class="sh-input" style="padding-left: 40px;"
                                value="{{ old('subscription_price', $profile->subscription_price) }}" min="5" max="100">
                            <i class="fas fa-coins"
                                style="position: absolute; left: 16px; top: 16px; color: var(--model-gold);"></i>
                        </div>
                    </div>
                </div>

                <!-- Private Chat Configuration -->
                <div class="sh-card">
                    <div class="sh-section-title">
                         {{ __('model.profile.edit.section_chat') }}
                    </div>
                    <div class="sh-form-row">
                        <div class="sh-form-group" style="margin-bottom: 0;">
                            <label class="sh-label">{{ __('model.profile.edit.label_chat_unlock_price') }}</label>
                            <div style="position: relative;">
                                <input type="number" name="chat_unlock_price" class="sh-input" style="padding-left: 40px;"
                                    value="{{ old('chat_unlock_price', $profile->chat_unlock_price ?? 500) }}" min="10">
                                <i class="fas fa-coins"
                                    style="position: absolute; left: 16px; top: 16px; color: var(--model-gold);"></i>
                            </div>
                            <small style="opacity: 0.6; display: block; margin-top: 4px;">{{ __('model.profile.edit.hint_chat_unlock_price') }}</small>
                        </div>
                        <div class="sh-form-group" style="margin-bottom: 0;">
                            <label class="sh-label">{{ __('model.profile.edit.label_chat_unlock_duration') }}</label>
                            <div style="position: relative;">
                                <input type="number" name="chat_unlock_duration" class="sh-input" style="padding-left: 40px;"
                                    value="{{ old('chat_unlock_duration', $profile->chat_unlock_duration ?? 24) }}" min="1">
                                <i class="fas fa-clock"
                                    style="position: absolute; left: 16px; top: 16px; color: var(--model-gold);"></i>
                            </div>
                            <small style="opacity: 0.6; display: block; margin-top: 4px;">{{ __('model.profile.edit.hint_chat_unlock_duration') }}</small>
                        </div>
                    </div>
                </div>

                <!-- Details Section -->
                <div class="sh-card">
                    <div class="sh-section-title">
                       {{ __('model.profile.edit.section_physical') }}
                    </div>

                    <div class="sh-form-row">
                        <div class="sh-form-group" style="margin-bottom: 0;">
                            <label class="sh-label">{{ __('model.profile.edit.label_country') }}</label>
                            <input type="text" name="country" class="sh-input"
                                value="{{ old('country', $profile->country) }}">
                        </div>
                        <div class="sh-form-group" style="margin-bottom: 0;">
                            <label class="sh-label">{{ __('model.profile.edit.label_age') }}</label>
                            <input type="number" name="age" class="sh-input" value="{{ old('age', $profile->age) }}">
                        </div>
                    </div>

                    <div class="sh-form-row">
                        <div class="sh-form-group" style="margin-bottom: 0;">
                            <label class="sh-label">{{ __('model.profile.edit.label_ethnicity') }}</label>
                            <select name="ethnicity" class="sh-select">
                                <option value="">{{ __('model.options.select_default') }}</option>
                                @foreach(['blanca', 'latina', 'asiatica', 'negra', 'arabe', 'india', 'multietnica'] as $eth)
                                    <option value="{{ $eth }}" {{ old('ethnicity', $profile->ethnicity) === $eth ? 'selected' : '' }}>
                                        {{ __('model.options.ethnicity.' . $eth) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="sh-form-group" style="margin-bottom: 0;">
                            <label class="sh-label">{{ __('model.profile.edit.label_body_type') }}</label>
                            <select name="body_type" class="sh-select">
                                <option value="">{{ __('model.options.select_default') }}</option>
                                @foreach(['delgado', 'atletico', 'talla_mediana', 'con_curvas', 'bbw'] as $type)
                                    <option value="{{ $type }}" {{ old('body_type', $profile->body_type) === $type ? 'selected' : '' }}>
                                        {{ __('model.options.body_type.' . $type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="sh-form-row">
                        <div class="sh-form-group" style="margin-bottom: 0;">
                            <label class="sh-label">{{ __('model.profile.edit.label_eye_color') }}</label>
                            <select name="eye_color" class="sh-select">
                                <option value="">{{ __('model.options.select_default') }}</option>
                                @foreach(['cafe', 'azul', 'verde', 'gris', 'avellana', 'negro'] as $color)
                                    <option value="{{ $color }}" {{ old('eye_color', $profile->eye_color) === $color ? 'selected' : '' }}>
                                        {{ __('model.options.eye_color.' . $color) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="sh-form-group" style="margin-bottom: 0;">
                            <label class="sh-label">{{ __('model.profile.edit.label_hair_color') }}</label>
                            <select name="hair_color" class="sh-select">
                                <option value="">{{ __('model.options.select_default') }}</option>
                                @foreach(['rubio', 'moreno', 'negro', 'pelirrojo', 'colorido', 'canoso'] as $color)
                                    <option value="{{ $color }}" {{ old('hair_color', $profile->hair_color) === $color ? 'selected' : '' }}>
                                        {{ __('model.options.hair_color.' . $color) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Interests Section -->
                <div class="sh-card">
                    <div class="sh-section-title">
                        {{ __('model.profile.edit.section_interests') }}
                    </div>

                    <div class="sh-form-group">
                        <label class="sh-label" style="margin-bottom: 12px;">{{ __('model.profile.edit.label_tags') }}</label>
                        <div class="sh-chips-grid">
                            @php
                                $currentInterests = old('interests', $profile->interests ? json_decode($profile->interests, true) : []);
                                $availableInterests = ['romantico', 'aventurero', 'jugueton', 'sensual', 'dominante', 'sumiso', 'fetichista', 'roleplay', 'voyeur', 'exhibicionista'];
                            @endphp
                            @foreach($availableInterests as $interest)
                                <div class="sh-chip-checkbox">
                                    <input type="checkbox" name="interests[]" value="{{ $interest }}" {{ in_array($interest, $currentInterests) ? 'checked' : '' }}>
                                    <span class="sh-chip-label">{{ __('model.options.interests.' . $interest) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="sh-action-bar">
                    <button type="submit" class="sh-btn-save">
                        <i class="fas fa-check" style="margin-right: 8px;"></i> {{ __('model.profile.edit.save_button') }}
                    </button>
                </div>
            </div>

            <!-- Sidebar Images & Socials -->
            <div>
                <!-- Images -->
                <div class="sh-card">
                    <div class="sh-section-title">
                       {{ __('model.profile.edit.section_images') }}
                    </div>

                    <!-- Avatar -->
                    <div class="sh-avatar-wrapper" style="margin-bottom: 30px;">
                        <img id="avatar-preview" src="{{ $profile->avatar_url }}" class="sh-avatar-preview">
                        <div class="sh-upload-btn-container">
                            <label for="avatar" class="sh-upload-btn">
                                {{ __('model.profile.edit.btn_change_avatar') }}
                            </label>
                            <input type="file" id="avatar" name="avatar" hidden accept="image/*"
                                onchange="previewImage(this, 'avatar-preview')">
                            <span style="font-size: 12px; opacity: 0.5;">{{ __('model.profile.edit.avatar_hint') }}</span>
                        </div>
                    </div>

                    <!-- Cover -->
                    <div>
                        <label class="sh-label">{{ __('model.profile.edit.label_cover') }}</label>
                        <img id="cover-preview" src="{{ $profile->cover_image_url }}" class="sh-cover-preview">
                        <label for="cover_image" class="sh-upload-btn" style="display: block;">
                            {{ __('model.profile.edit.btn_upload_cover') }}
                        </label>
                        <input type="file" id="cover_image" name="cover_image" hidden accept="image/*"
                            onchange="previewImage(this, 'cover-preview')">
                    </div>
                </div>

                <!-- Socials -->
                <div class="sh-card">
                    <div class="sh-section-title">
                        {{ __('model.profile.edit.section_socials') }}
                    </div>

                    @php $socials = old('social_networks', $profile->social_networks ? json_decode($profile->social_networks, true) : []); @endphp

                    <div class="sh-social-group">
                        <i class="fab fa-instagram sh-social-icon"></i>
                        <input type="url" name="social_networks[instagram]" class="sh-input sh-social-input"
                            value="{{ $socials['instagram'] ?? '' }}" placeholder="{{ __('model.profile.edit.placeholder_instagram') }}">
                    </div>

                    <div class="sh-social-group">
                        <i class="fab fa-tiktok sh-social-icon"></i>
                        <input type="url" name="social_networks[tiktok]" class="sh-input sh-social-input"
                            value="{{ $socials['tiktok'] ?? '' }}" placeholder="{{ __('model.profile.edit.placeholder_tiktok') }}">
                    </div>

                    <div class="sh-social-group">
                        <i class="fab fa-twitter sh-social-icon"></i>
                        <input type="url" name="social_networks[twitter]" class="sh-input sh-social-input"
                            value="{{ $socials['twitter'] ?? '' }}" placeholder="{{ __('model.profile.edit.placeholder_x') }}">
                    </div>
                </div>

                <div class="sh-card">
                    <div class="sh-section-title">
                         {{ __('model.profile.edit.section_languages') }}
                    </div>
                    <div class="sh-chips-grid" style="grid-template-columns: 1fr 1fr;">
                        @php
                            $currentLangs = old('languages', $profile->languages ? json_decode($profile->languages, true) : []);
                            $availableLangs = ['es' => 'Español', 'en' => 'Inglés', 'pt' => 'Portugués', 'fr' => 'Francés'];
                        @endphp
                        @foreach($availableLangs as $code => $label)
                            <div class="sh-chip-checkbox">
                                <input type="checkbox" name="languages[]" value="{{ $code }}" {{ in_array($code, $currentLangs) ? 'checked' : '' }}>
                                <span class="sh-chip-label">{{ __('model.options.languages.' . $code) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('scripts')
    <script>
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById(previewId).setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection