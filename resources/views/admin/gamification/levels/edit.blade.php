@extends('layouts.admin')

@section('title', isset($level) ? __('admin.gamification.levels.edit.title') : __('admin.gamification.levels.create.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item">{{ __('admin.gamification-2.title') }}</span>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('admin.gamification.levels.index') }}" class="breadcrumb-item">{{ __('admin.gamification-2.levels.index.title_header') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ isset($level) ? __('admin.gamification-2.levels.index.table.edit') : __('admin.gamification.levels.index.create_button') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Levels Form Professional Styling ----- */

        .page-header {
            padding-top: 64px;
            margin-bottom: 40px;
        }


        .sh-form-container {
            max-width: 900px;
            margin: 0 auto 50px auto;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .sh-section-header {
            padding: 25px 30px;
            background: rgba(255, 255, 255, 0.01);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .sh-section-header i {
            color: var(--admin-gold);
            font-size: 1.2rem;
        }

        .sh-section-title {
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sh-form-body {
            padding: 30px;
        }

        .sh-form-group {
            margin-bottom: 24px;
        }

        .sh-form-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .sh-input {
            width: 100%;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 14px 16px;
            color: #fff;
            font-size: 15px;
            transition: all 0.2s ease;
        }

        .sh-input:focus {
            outline: none;
            border-color: var(--admin-gold);
            background: rgba(0, 0, 0, 0.4);
            box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.1);
        }

        .sh-helper-text {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.4);
            margin-top: 6px;
            display: block;
        }

        .sh-rewards-panel {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 24px;
            margin-top: 10px;
        }

        .sh-form-actions {
            padding: 25px 30px;
            background: rgba(255, 255, 255, 0.01);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }

        .sh-btn-save {
            flex: 1;
            padding: 14px 28px;
            border-radius: 12px;
            background: var(--gradient-gold);
            color: #000 !important;
            font-weight: 800;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.2);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .sh-btn-save:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.3);
            color: #000 !important;
        }

        .sh-btn-cancel {
            padding: 14px 24px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.7);
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .sh-btn-cancel:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.2);
        }

        @media (max-width: 600px) {
            .sh-form-body {

                padding: 20px;
            }

            .sh-form-actions {
                flex-direction: column-reverse;
            }

            .sh-btn-save,
            .sh-btn-cancel {
                width: 100%;
                text-align: center;
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title">{{ isset($level) ? __('admin.gamification-2.levels.edit.title') : __('admin.gamification.levels.create.title') }}</h1>
        <p class="page-subtitle">{{ __('admin.gamification-2.levels.create.subtitle') }}</p>
    </div>

    <div class="sh-form-container">
        <form
            action="{{ isset($level) ? route('admin.gamification.levels.update', $level->id) : route('admin.gamification.levels.store') }}"
            method="POST">
            @csrf
            @if(isset($level)) @method('PUT') @endif

            <div class="sh-section-header">
                <i class="fas fa-layer-group"></i>
                <h2 class="sh-section-title">{{ __('admin.gamification-2.levels.form.basic_config') }}</h2>
            </div>

            <div class="sh-form-body">
                <div class="sh-form-group">
                    <label class="sh-form-label">{{ __('admin.gamification-2.levels.form.name') }}</label>
                    <input type="text" name="name" class="sh-input" placeholder="{{ __('admin.gamification-2.levels.form.name_placeholder') }}"
                        value="{{ old('name', $level->name ?? '') }}" required>
                    <span class="sh-helper-text">{{ __('admin.gamification-2.levels.form.name_helper') }}</span>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                    <div class="sh-form-group">
                        <label class="sh-form-label">{{ __('admin.gamification-2.levels.form.level_number') }}</label>
                        <input type="number" name="level_number" class="sh-input" placeholder="0 - 20"
                            value="{{ old('level_number', $level->level_number ?? '') }}" required>
                    </div>
                    <div class="sh-form-group">
                        <label class="sh-form-label">{{ __('admin.gamification-2.levels.form.xp_required') }}</label>
                        <input type="number" name="xp_required" class="sh-input" placeholder="Ej: 5000"
                            value="{{ old('xp_required', $level->xp_required ?? '') }}" required>
                    </div>
                </div>
            </div>

            <div class="sh-section-header">
                <i class="fas fa-gift"></i>
                <h2 class="sh-section-title">{{ __('admin.gamification-2.levels.form.rewards_section') }}</h2>
            </div>

            <div class="sh-form-body" style="padding-top: 20px;">
                <div class="sh-rewards-panel">
                    <div class="sh-form-group" style="margin-bottom: 0;">
                        <label class="sh-form-label">{{ __('admin.gamification-2.levels.form.bonus_tokens') }}</label>
                        <div style="position: relative;">
                            <i class="fas fa-coins"
                                style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--admin-gold);"></i>
                            <input type="number" name="reward_tokens" class="sh-input" placeholder="0"
                                value="{{ old('reward_tokens', isset($level) ? (($level->rewards_json['tokens'] ?? 0)) : 0) }}"
                                style="padding-left: 45px;">
                        </div>
                        <span class="sh-helper-text">{{ __('admin.gamification-2.levels.form.tokens_helper') }}</span>
                    </div>
                </div>
            </div>

            <div class="sh-form-actions">
                <a href="{{ route('admin.gamification.levels.index') }}" class="sh-btn-cancel">{{ __('admin.gamification-2.levels.form.cancel') }}</a>
                <button type="submit" class="sh-btn-save">
                    <i class="fas fa-check" style="margin-right: 6px;"></i>
                    {{ isset($level) ? __('admin.gamification-2.levels.form.submit_edit') : __('admin.gamification.levels.form.submit_create') }}
                </button>
            </div>
        </form>
    </div>
@endsection