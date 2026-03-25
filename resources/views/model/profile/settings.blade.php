@extends('layouts.model')

@section('title', __('model.profile.settings.title_tag'))

@section('breadcrumb')
    <a href="{{ route('model.dashboard') }}" class="breadcrumb-item">{{ __('model.profile.settings.breadcrumb_dashboard') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('model.profile.settings.breadcrumb_active') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Model Settings Professional Styling ----- */

        /* === Page Header === */
        .page-header {
            padding-top: 32px;
            margin-bottom: 28px;
        }

        /* Estilos de encabezado heredados del layout model */

        /* === Settings Grid === */
        .sh-settings-grid {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 28px;
            align-items: start;
            padding-bottom: 80px; /* extra space so sticky save button never overlaps */
        }

        .sh-settings-sidebar { order: 1; }
        .sh-settings-form    { order: 2; }

        /* === Cards === */
        .sh-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 18px;
            padding: 26px;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
            box-sizing: border-box;
        }

        /* === Section Title === */
        .sh-section-title {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #dab843;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 14px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sh-section-title i {
            color: var(--model-gold);
        }

        /* === Mini Stats (Sidebar) === */
        .sh-mini-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 20px;
        }

        .sh-mini-stat {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 14px;
            text-align: center;
            min-width: 0;
            box-sizing: border-box;
        }

        .sh-mini-val {
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 4px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .sh-mini-lbl {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: rgba(255, 255, 255, 0.5);
        }

        /* === Benefits === */
        .sh-benefits-title {
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 10px;
        }

        .sh-benefit-item {
            display: flex;
            gap: 12px;
            padding: 14px;
            background: rgba(40, 167, 69, 0.05);
            border: 1px solid rgba(40, 167, 69, 0.1);
            border-radius: 12px;
            margin-bottom: 10px;
            align-items: flex-start;
        }

        .sh-benefit-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(40, 167, 69, 0.12);
            color: #28a745;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 13px;
        }

        .sh-benefit-name {
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 2px;
        }

        .sh-benefit-desc {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.4;
        }

        /* === Group Labels === */
        .sh-group-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--model-gold);
            font-weight: 700;
            margin: 20px 0 10px 0;
            opacity: 0.85;
        }

        /* === Setting Rows === */
        .sh-setting-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 18px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            margin-bottom: 8px;
            transition: all 0.2s;
            gap: 12px;
        }

        .sh-setting-row:hover {
            background: rgba(255, 255, 255, 0.055);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .sh-setting-info {
            flex: 1;
            min-width: 0;
            padding-right: 12px;
        }

        .sh-setting-name {
            font-size: 15px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 3px;
            word-break: break-word;
            overflow-wrap: break-word;
        }

        .sh-setting-desc {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.4;
            word-break: break-word;
            overflow-wrap: break-word;
        }

        /* === Switch === */
        .sh-switch {
            position: relative;
            display: inline-block;
            width: 46px;
            height: 26px;
            flex-shrink: 0;
        }

        .sh-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .sh-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.15);
            transition: .3s;
            border-radius: 26px;
        }

        .sh-slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background-color: #fff;
            transition: .3s;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.25);
        }

        .sh-switch input:checked + .sh-slider {
            background-color: var(--model-gold);
        }

        .sh-switch input:checked + .sh-slider:before {
            transform: translateX(20px);
        }

        /* === Save Button === */
        .sh-save-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-top: 24px;
        }

        .sh-btn-save {
            background: var(--model-gold);
            color: #000;
            font-weight: 700;
            padding: 13px 36px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.25);
            transition: all 0.3s;
        }

        .sh-btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.35);
        }

        .sh-btn-save:active {
            transform: translateY(0);
        }

        /* ==================== RESPONSIVE ==================== */

        /* Tablet */
        @media (max-width: 1024px) {
            .sh-settings-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            /* Formulario primero, sidebar debajo */
            .sh-settings-sidebar { order: 2; }
            .sh-settings-form    { order: 1; }

            /* Only 2 stat boxes — keep 2 columns */
            .sh-mini-stats {
                grid-template-columns: 1fr 1fr;
            }
        }

        /* Móvil grande */
        @media (max-width: 768px) {
            /* Estilos responsivos de encabezado heredados */

            .sh-card {
                padding: 18px;
                border-radius: 14px;
                margin-bottom: 14px;
            }

            .sh-section-title {
                font-size: 15px;
                margin-bottom: 16px;
            }

            .sh-setting-row {
                padding: 12px 14px;
            }

            .sh-setting-name {
                font-size: 14px;
            }

            .sh-setting-desc {
                font-size: 12px;
            }

            /* Switch más grande para táctil */
            .sh-switch {
                width: 50px;
                height: 28px;
            }

            .sh-slider:before {
                height: 22px;
                width: 22px;
            }

            .sh-switch input:checked + .sh-slider:before {
                transform: translateX(22px);
            }

            /* 2 stat boxes — always 2 columns */
            .sh-mini-stats {
                grid-template-columns: 1fr 1fr;
            }

            /* Botón guardar sticky en móvil */
            .sh-save-wrapper {
                position: sticky;
                bottom: 0;
                background: rgba(11, 11, 13, 0.95);
                backdrop-filter: blur(14px);
                -webkit-backdrop-filter: blur(14px);
                padding: 12px 18px;
                margin: 20px -18px 0 -18px;
                border-top: 1px solid rgba(255, 255, 255, 0.07);
                z-index: 20;
            }

            .sh-btn-save {
                width: 100%;
                justify-content: center;
                font-size: 15px;
                padding: 14px;
            }
        }

        /* Móvil pequeño */
        @media (max-width: 480px) {
            /* Estilos responsivos heredados */

            .sh-card {
                padding: 14px;
                border-radius: 12px;
            }

            .sh-mini-stats {
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }

            .sh-group-label {
                margin: 16px 0 8px 0;
                font-size: 10px;
            }

            .sh-setting-row {
                padding: 11px 12px;
                margin-bottom: 6px;
            }

            .sh-benefit-item {
                padding: 10px;
                gap: 8px;
            }

            .sh-benefit-icon {
                width: 26px;
                height: 26px;
                font-size: 11px;
            }

            .sh-save-wrapper {
                margin-left: -14px;
                margin-right: -14px;
                padding-left: 14px;
                padding-right: 14px;
            }
        }
    </style>
@endsection

@section('content')

    <div class="page-header">
        <h1 class="page-title">{{ __('model.profile.settings.header_title') }}</h1>
        <p class="page-subtitle">{{ __('model.profile.settings.header_subtitle') }}</p>
    </div>

    <div class="sh-settings-grid">

        <!-- Sidebar: Status & Benefits -->
        <div class="sh-settings-sidebar">
            @if($userProgress && $currentLevel)
                <x-model-xp-panel :userProgress="$userProgress" :currentLevel="$currentLevel" :nextLevel="null"
                    :xpPercentage="0" :currentXP="$userProgress->current_xp" :requiredXP="$currentLevel->xp_required" />
            @endif

            <div class="sh-card">
                <h3 class="sh-section-title"> {{ __('model.profile.settings.section_status') }}</h3>
                <div class="sh-mini-stats">
                    <div class="sh-mini-stat">
                        <div class="sh-mini-val">#{{ $gamificationStats['current_rank'] }}</div>
                        <div class="sh-mini-lbl">{{ __('model.profile.settings.label_ranking') }}</div>
                    </div>
                    <div class="sh-mini-stat">
                        <div class="sh-mini-val">{{ number_format($gamificationStats['total_xp']) }}</div>
                        <div class="sh-mini-lbl">{{ __('model.profile.settings.label_total_xp') }}</div>
                    </div>
                </div>

                <div style="margin-top: 20px;">
                    <h4 class="sh-benefits-title">{{ __('model.profile.settings.section_benefits') }}</h4>
                    @forelse($unlockedBenefits as $benefit)
                        <div class="sh-benefit-item">
                            <div class="sh-benefit-icon"><i class="fas {{ $benefit['icon'] }}"></i></div>
                            <div>
                                <div class="sh-benefit-name">{{ $benefit['name'] }}</div>
                                <div class="sh-benefit-desc">{{ $benefit['description'] }}</div>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 20px; opacity: 0.5;">
                            <i class="fas fa-lock" style="font-size: 22px; margin-bottom: 8px; display: block;"></i>
                            <div style="font-size: 13px;">{{ __('model.profile.settings.empty_benefits') }}</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Main Settings Form -->
        <div class="sh-settings-form">
            <form action="{{ route('model.profile.updateSettings') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Notifications -->
                <div class="sh-card">
                    <h3 class="sh-section-title"> {{ __('model.profile.settings.section_notifications') }}</h3>

                    <div class="sh-group-label">{{ __('model.profile.settings.group_gamification') }}</div>

                    <div class="sh-setting-row">
                        <div class="sh-setting-info">
                            <div class="sh-setting-name">{{ __('model.profile.settings.name_level_up') }}</div>
                            <div class="sh-setting-desc">{{ __('model.profile.settings.desc_level_up') }}</div>
                        </div>
                        <label class="sh-switch">
                            <input type="checkbox" name="notifications[level_up]" value="1" {{ $settings['notifications']['level_up'] ? 'checked' : '' }}>
                            <span class="sh-slider"></span>
                        </label>
                    </div>

                    <div class="sh-setting-row">
                        <div class="sh-setting-info">
                            <div class="sh-setting-name">{{ __('model.profile.settings.name_achievements') }}</div>
                            <div class="sh-setting-desc">{{ __('model.profile.settings.desc_achievements') }}</div>
                        </div>
                        <label class="sh-switch">
                            <input type="checkbox" name="notifications[achievements]" value="1" {{ $settings['notifications']['achievements'] ? 'checked' : '' }}>
                            <span class="sh-slider"></span>
                        </label>
                    </div>

                    <div class="sh-group-label">{{ __('model.profile.settings.group_finance') }}</div>

                    <div class="sh-setting-row">
                        <div class="sh-setting-info">
                            <div class="sh-setting-name">{{ __('model.profile.settings.name_tips') }}</div>
                            <div class="sh-setting-desc">{{ __('model.profile.settings.desc_tips') }}</div>
                        </div>
                        <label class="sh-switch">
                            <input type="checkbox" name="notifications[tips]" value="1" {{ $settings['notifications']['tips'] ? 'checked' : '' }}>
                            <span class="sh-slider"></span>
                        </label>
                    </div>

                    <div class="sh-setting-row">
                        <div class="sh-setting-info">
                            <div class="sh-setting-name">{{ __('model.profile.settings.name_new_subscribers') }}</div>
                            <div class="sh-setting-desc">{{ __('model.profile.settings.desc_new_subscribers') }}</div>
                        </div>
                        <label class="sh-switch">
                            <input type="checkbox" name="notifications[new_subscribers]" value="1" {{ $settings['notifications']['new_subscribers'] ? 'checked' : '' }}>
                            <span class="sh-slider"></span>
                        </label>
                    </div>
                </div>

                <!-- Privacy -->
                <div class="sh-card">
                    <h3 class="sh-section-title"> {{ __('model.profile.settings.section_privacy') }}</h3>

                    <div class="sh-setting-row">
                        <div class="sh-setting-info">
                            <div class="sh-setting-name">{{ __('model.profile.settings.name_show_online') }}</div>
                            <div class="sh-setting-desc">{{ __('model.profile.settings.desc_show_online') }}</div>
                        </div>
                        <label class="sh-switch">
                            <input type="checkbox" name="privacy[show_online_status]" value="1" {{ $settings['privacy']['show_online_status'] ? 'checked' : '' }}>
                            <span class="sh-slider"></span>
                        </label>
                    </div>

                    <div class="sh-setting-row">
                        <div class="sh-setting-info">
                            <div class="sh-setting-name">{{ __('model.profile.settings.name_public_ranking') }}</div>
                            <div class="sh-setting-desc">{{ __('model.profile.settings.desc_public_ranking') }}</div>
                        </div>
                        <label class="sh-switch">
                            <input type="checkbox" name="privacy[show_in_leaderboard]" value="1" {{ $settings['privacy']['show_in_leaderboard'] ? 'checked' : '' }}>
                            <span class="sh-slider"></span>
                        </label>
                    </div>

                    <div class="sh-setting-row">
                        <div class="sh-setting-info">
                            <div class="sh-setting-name">{{ __('model.profile.settings.name_direct_messages') }}</div>
                            <div class="sh-setting-desc">{{ __('model.profile.settings.desc_direct_messages') }}</div>
                        </div>
                        <label class="sh-switch">
                            <input type="checkbox" name="privacy[allow_messages]" value="1" {{ $settings['privacy']['allow_messages'] ? 'checked' : '' }}>
                            <span class="sh-slider"></span>
                        </label>
                    </div>
                </div>

                <!-- Save -->
                <div class="sh-save-wrapper">
                    <button type="submit" class="sh-btn-save">
                        <i class="fas fa-save"></i> {{ __('model.profile.settings.save_button') }}
                    </button>
                </div>

            </form>
        </div>
    </div>

@endsection