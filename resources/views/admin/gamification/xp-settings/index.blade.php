@extends('layouts.admin')

@section('title', __('admin.gamification.xp_settings.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item">{{ __('admin.gamification.xp_settings.breadcrumb_parent') }}</span>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.gamification.xp_settings.breadcrumb') }}</span>
@endsection

@section('styles')
<style>

    .xp-card {
        max-width: 700px;
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0,0,0,0.25);
    }
    .xp-header {
        padding: 22px 28px;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        display: flex; align-items: center; gap: 12px;
    }
    .xp-header i { color: var(--admin-gold); font-size: 1.1rem; }
    .xp-header h2 { color: #fff; font-size: 15px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; margin: 0; }
    .xp-body { padding: 28px; display: flex; flex-direction: column; gap: 20px; }
    .xp-row {
        display: grid;
        grid-template-columns: 1fr auto;
        align-items: center;
        gap: 20px;
        padding: 16px 20px;
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 12px;
    }
    .xp-label { color: #fff; font-weight: 600; font-size: 15px; }
    .xp-desc { color: rgba(255,255,255,0.45); font-size: 12px; margin-top: 3px; }
    .xp-input-wrap { display: flex; align-items: center; gap: 8px; }
    .xp-input {
        width: 80px;
        background: rgba(0,0,0,0.3);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 8px;
        padding: 10px 12px;
        color: #fff;
        font-size: 16px;
        font-weight: 700;
        text-align: center;
        transition: all .2s;
    }
    .xp-input:focus { outline: none; border-color: var(--admin-gold); box-shadow: 0 0 0 2px rgba(212,175,55,.15); }
    .xp-unit { color: rgba(255,255,255,0.4); font-size: 13px; white-space: nowrap; }
    .xp-footer {
        padding: 20px 28px;
        border-top: 1px solid rgba(255,255,255,0.06);
        display: flex; justify-content: flex-end; gap: 12px;
    }
    .btn-save {
        padding: 12px 28px;
        border-radius: 12px;
        background: var(--gradient-gold);
        color: #000 !important;
        font-weight: 800;
        font-size: 0.9rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.2);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }

    .btn-save:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 25px rgba(212, 175, 55, 0.3);
        color: #000 !important;
    }
    .note-box {
        max-width: 700px; margin-top: 20px;
        padding: 14px 18px;
        background: rgba(59,130,246,.08);
        border: 1px solid rgba(59,130,246,.2);
        border-radius: 10px;
        color: rgba(255,255,255,.7);
        font-size: 13px;
        line-height: 1.6;
    }
    .note-box i { color: #3b82f6; margin-right: 6px; }

    @media (max-width: 768px) {
        div[style*="display: grid"] {

            grid-template-columns: 1fr !important;
            gap: 20px !important;
        }

        .xp-card {
            max-width: 100%;
        }

        .xp-row {
            grid-template-columns: 1fr;
            gap: 12px;
            padding: 16px;
        }

        .xp-input-wrap {
            justify-content: space-between;
            width: 100%;
            background: rgba(0,0,0,0.15);
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid rgba(255,255,255,0.05);
        }

        .xp-input {
            width: 100px;
        }

        .xp-footer {
            flex-direction: column;
        }

        .btn-save {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .xp-header {

            padding: 16px 20px;
        }
        .xp-body {
            padding: 20px 16px;
            gap: 16px;
        }
        .xp-label {
            font-size: 14px;
        }
        .xp-desc {
            font-size: 11px;
        }
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title"> {{ __('admin.gamification.xp_settings.title') }}</h1>
    <p class="page-subtitle">{{ __('admin.gamification.xp_settings.subtitle') }}</p>
</div>



<form action="{{ route('admin.gamification.xp-settings.update') }}" method="POST">
    @csrf
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap: 30px; align-items: start;">
        {{-- TARJETA: XP PARA FANS --}}
        <div class="xp-card">
            <div class="xp-header" style="border-bottom: 1px solid rgba(56, 189, 248, 0.2);">
                <i class="fas fa-user-circle" style="color: #38bdf8;"></i>
                <h2>{{ __('admin.gamification.xp_settings.fans.title') }}</h2>
            </div>
            <div class="xp-body">
                <div class="xp-row">
                    <div>
                        <div class="xp-label"><i class="fas fa-shopping-cart" style="color:#38bdf8; margin-right:6px;"></i> {{ __('admin.gamification.xp_settings.fans.tokens_purchased') }}</div>
                        <div class="xp-desc">{{ __('admin.gamification.xp_settings.fans.tokens_purchased_desc') }}</div>
                    </div>
                    <div class="xp-input-wrap">
                        <input type="number" name="fan_tokens_purchased" class="xp-input" min="0" max="1000"
                            value="{{ old('fan_tokens_purchased', $settings['fan_tokens_purchased']) }}" required>
                        <span class="xp-unit">{{ __('admin.gamification.xp_settings.units.base_percent') }}</span>
                    </div>
                </div>

                <div class="xp-row">
                    <div>
                        <div class="xp-label"><i class="fas fa-coins" style="color:var(--admin-gold); margin-right:6px;"></i> {{ __('admin.gamification.xp_settings.fans.tip_sent') }}</div>
                        <div class="xp-desc">{{ __('admin.gamification.xp_settings.fans.tip_sent_desc') }}</div>
                    </div>
                    <div class="xp-input-wrap">
                        <input type="number" name="fan_tip_sent" class="xp-input" min="0" max="1000"
                            value="{{ old('fan_tip_sent', $settings['fan_tip_sent']) }}" required>
                        <span class="xp-unit">{{ __('admin.gamification.xp_settings.units.base_percent') }}</span>
                    </div>
                </div>

                <div class="xp-row">
                    <div>
                        <div class="xp-label"><i class="fas fa-star" style="color:#818cf8; margin-right:6px;"></i> {{ __('admin.gamification.xp_settings.fans.subscription') }}</div>
                        <div class="xp-desc">{{ __('admin.gamification.xp_settings.fans.subscription_desc') }}</div>
                    </div>
                    <div class="xp-input-wrap">
                        <input type="number" name="fan_subscription" class="xp-input" min="0" max="1000"
                            value="{{ old('fan_subscription', $settings['fan_subscription']) }}" required>
                        <span class="xp-unit">{{ __('admin.gamification.xp_settings.units.fixed_xp') }}</span>
                    </div>
                </div>

                <div class="xp-row">
                    <div>
                        <div class="xp-label"><i class="fas fa-comment" style="color:#34d399; margin-right:6px;"></i> {{ __('admin.gamification.xp_settings.fans.chat_message') }}</div>
                        <div class="xp-desc">{{ __('admin.gamification.xp_settings.fans.chat_message_desc') }}</div>
                    </div>
                    <div class="xp-input-wrap">
                        <input type="number" name="fan_chat_message" class="xp-input" min="0" max="100"
                            value="{{ old('fan_chat_message', $settings['fan_chat_message']) }}" required>
                        <span class="xp-unit">{{ __('admin.gamification.xp_settings.units.fixed_xp') }}</span>
                    </div>
                </div>

                <div class="xp-row">
                    <div>
                        <div class="xp-label"><i class="fas fa-video" style="color:#f472b6; margin-right:6px;"></i> {{ __('admin.gamification.xp_settings.fans.stream_view') }}</div>
                        <div class="xp-desc">{{ __('admin.gamification.xp_settings.fans.stream_view_desc') }}</div>
                    </div>
                    <div class="xp-input-wrap">
                        <input type="number" name="fan_stream_view" class="xp-input" min="0" max="100"
                            value="{{ old('fan_stream_view', $settings['fan_stream_view']) }}" required>
                        <span class="xp-unit">{{ __('admin.gamification.xp_settings.units.fixed_xp') }}</span>
                    </div>
                </div>
            </div>
            <div class="xp-footer">
                <button type="submit" class="btn-save" style="background: #38bdf8;">
                    <i class="fas fa-save" style="margin-right:6px; color:#000;"></i> {{ __('admin.gamification.xp_settings.save') }}
                </button>
            </div>
        </div>

        {{-- TARJETA: XP PARA MODELOS --}}
        <div class="xp-card">
            <div class="xp-header" style="border-bottom: 1px solid rgba(212, 175, 55, 0.2);">
                <i class="fas fa-star" style="color: var(--admin-gold);"></i>
                <h2 style="color: var(--admin-gold);">{{ __('admin.gamification.xp_settings.models.title') }}</h2>
            </div>
            <div class="xp-body">
                <div class="xp-row">
                    <div>
                        <div class="xp-label"><i class="fas fa-coins" style="color:var(--admin-gold); margin-right:6px;"></i> {{ __('admin.gamification.xp_settings.models.tip_received') }}</div>
                        <div class="xp-desc">{{ __('admin.gamification.xp_settings.models.tip_received_desc') }}</div>
                    </div>
                    <div class="xp-input-wrap">
                        <input type="number" name="model_tip_received" class="xp-input" min="0" max="1000"
                            value="{{ old('model_tip_received', $settings['model_tip_received']) }}" required>
                        <span class="xp-unit">{{ __('admin.gamification.xp_settings.units.reward_percent') }}</span>
                    </div>
                </div>

                <div class="xp-row">
                    <div>
                        <div class="xp-label"><i class="fas fa-user-plus" style="color:#818cf8; margin-right:6px;"></i> {{ __('admin.gamification.xp_settings.models.new_subscriber') }}</div>
                        <div class="xp-desc">{{ __('admin.gamification.xp_settings.models.new_subscriber_desc') }}</div>
                    </div>
                    <div class="xp-input-wrap">
                        <input type="number" name="model_new_subscriber" class="xp-input" min="0" max="1000"
                            value="{{ old('model_new_subscriber', $settings['model_new_subscriber']) }}" required>
                        <span class="xp-unit">{{ __('admin.gamification.xp_settings.units.fixed_xp') }}</span>
                    </div>
                </div>

                <div class="xp-row">
                    <div>
                        <div class="xp-label"><i class="fas fa-comment" style="color:#34d399; margin-right:6px;"></i> {{ __('admin.gamification.xp_settings.models.chat_message') }}</div>
                        <div class="xp-desc">{{ __('admin.gamification.xp_settings.models.chat_message_desc') }}</div>
                    </div>
                    <div class="xp-input-wrap">
                        <input type="number" name="model_chat_message" class="xp-input" min="0" max="100"
                            value="{{ old('model_chat_message', $settings['model_chat_message']) }}" required>
                        <span class="xp-unit">{{ __('admin.gamification.xp_settings.units.fixed_xp') }}</span>
                    </div>
                </div>

                <div class="xp-row">
                    <div>
                        <div class="xp-label"><i class="fas fa-video" style="color:#f472b6; margin-right:6px;"></i> {{ __('admin.gamification.xp_settings.models.stream_view') }}</div>
                        <div class="xp-desc">{{ __('admin.gamification.xp_settings.models.stream_view_desc') }}</div>
                    </div>
                    <div class="xp-input-wrap">
                        <input type="number" name="model_stream_view" class="xp-input" min="0" max="100"
                            value="{{ old('model_stream_view', $settings['model_stream_view']) }}" required>
                        <span class="xp-unit">{{ __('admin.gamification.xp_settings.units.fixed_xp') }}</span>
                    </div>
                </div>
            </div>
            <div class="xp-footer">
                <button type="submit" class="btn-save">
                    <i class="fas fa-save" style="margin-right:6px; color:#000;"></i> {{ __('admin.gamification.xp_settings.save') }}
                </button>
            </div>
        </div>
    </div>
</form>

<div class="note-box">
    <i class="fas fa-info-circle"></i>
    <strong>{{ __('admin.gamification.xp_settings.note') }}</strong> {!! __('admin.gamification.xp_settings.note_desc') !!}
</div>
@endsection
