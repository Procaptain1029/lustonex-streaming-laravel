@extends('layouts.admin')

@section('title', __('admin.gamification.missions.edit.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('admin.gamification.missions.index') }}" class="breadcrumb-item">{{ __('admin.gamification-2.missions.index.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.gamification-2.missions.index.table.edit') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Mission Form Professional Styling ----- */
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

        .sh-select option {
            background: #0B0B0D;
            color: #fff;
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
        }

        .sh-btn-primary {
            background: var(--gradient-gold);
            color: #000;
        }

        .sh-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
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

        /* Grid for rewards */
        .sh-reward-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* Custom Checkbox */
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

        @media (max-width: 768px) {
            .sh-form-card {

                padding: 25px;
                border-radius: 20px;
            }

            .sh-reward-grid {
                grid-template-columns: 1fr;
                gap: 15px;
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
                gap: 12px;
                margin-top: 30px;
            }

            .sh-btn {
                width: 100%;
                justify-content: center;
                padding: 14px;
            }

            .sh-guide-card {
                padding: 20px;
                border-radius: 16px;
            }

            .sh-guide-title {
                font-size: 0.9rem;
                margin-bottom: 16px;
            }

            .sh-guide-list li {
                font-size: 0.8rem;
            }
        }

        @media (max-width: 480px) {
            .sh-form-card {
                padding: 20px;
                border-radius: 16px;
            }


            .sh-section-title {
                font-size: 0.75rem;
                gap: 8px;
            }

            .sh-label {
                font-size: 0.7rem;
            }

            .sh-input,
            .sh-select,
            .sh-textarea {
                padding: 10px 12px;
                font-size: 0.85rem;
            }

            .sh-btn {
                padding: 12px;
                font-size: 0.85rem;
            }

            .sh-guide-card {
                padding: 16px;
                border-radius: 12px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title">{{ __('admin.gamification-2.missions.edit.title') }}</h1>
        <p class="page-subtitle">{{ __('admin.gamification-2.missions.create.subtitle') }}: {{ $mission->name }}</p>
    </div>

    <div class="sh-page-grid">

        <div class="sh-form-column">
            <div class="sh-form-card">
                <form action="{{ route('admin.gamification.missions.update', $mission) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="sh-form-section">
                        <h3 class="sh-section-title"><i class="fas fa-cog"></i> {{ __('admin.gamification-2.missions.form.basic_config') }}</h3>

                        <div class="sh-form-group">
                            <label class="sh-label">{{ __('admin.gamification-2.missions.form.name') }}</label>
                            <input type="text" name="name" class="sh-input"
                                value="{{ old('name', $mission->name) }}" required>
                        </div>

                        <div class="sh-form-group">
                            <label class="sh-label">{{ __('admin.gamification-2.missions.form.description') }}</label>
                            <textarea name="description" class="sh-textarea" rows="3"
                                placeholder="{{ __('admin.gamification-2.missions.form.description_placeholder') }}">{{ old('description', $mission->description) }}</textarea>
                        </div>

                        <div class="sh-reward-grid">
                            <div class="sh-form-group">
                                <label class="sh-label">{{ __('admin.gamification-2.missions.form.type') }}</label>
                                <select name="type" class="sh-select" required>
                                    <option value="WEEKLY"
                                        {{ old('type', $mission->type) == 'WEEKLY' ? 'selected' : '' }}>{{ __('admin.gamification-2.missions.form.types.weekly') }}</option>
                                    <option value="LEVEL_UP"
                                        {{ old('type', $mission->type) == 'LEVEL_UP' ? 'selected' : '' }}>{{ __('admin.gamification-2.missions.form.types.level_up') }}</option>
                                    <option value="PARALLEL"
                                        {{ old('type', $mission->type) == 'PARALLEL' ? 'selected' : '' }}>{{ __('admin.gamification-2.missions.form.types.parallel') }}</option>
                                </select>
                            </div>

                            <div class="sh-form-group">
                                <label class="sh-label">{{ __('admin.gamification-2.missions.form.role_target') }}</label>
                                <select name="role" class="sh-select" required>
                                    <option value="both"
                                        {{ old('role', $mission->role) == 'both' ? 'selected' : '' }}>{{ __('admin.gamification-2.missions.form.roles.both') }}</option>
                                    <option value="fan"
                                        {{ old('role', $mission->role) == 'fan' ? 'selected' : '' }}>{{ __('admin.gamification-2.missions.form.roles.fan') }}</option>
                                    <option value="model"
                                        {{ old('role', $mission->role) == 'model' ? 'selected' : '' }}>{{ __('admin.gamification-2.missions.form.roles.model') }}
                                    </option>
                                </select>
                            </div>

                            <div class="sh-form-group">
                                <label class="sh-label">{{ __('admin.gamification-2.missions.form.required_level') }}</label>
                                <select name="level_id" class="sh-select">
                                    <option value="">{{ __('admin.gamification-2.missions.form.no_level') }}</option>
                                    @foreach($levels as $level)
                                        <option value="{{ $level->id }}"
                                            {{ old('level_id', $mission->level_id) == $level->id ? 'selected' : '' }}>
                                            {{ __('admin.gamification-2.missions.form.level_prefix') }} {{ $level->level_number }}: {{ $level->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="sh-form-group" style="display: flex; align-items: flex-end; padding-bottom: 12px;">
                                <label class="sh-toggle">
                                    <input type="checkbox" name="is_active" value="1"
                                        {{ old('is_active', $mission->is_active) ? 'checked' : '' }}>
                                    <div class="sh-toggle-track">
                                        <div class="sh-toggle-thumb"></div>
                                    </div>
                                    <span class="sh-label" style="margin-bottom: 0;">{{ __('admin.gamification-2.missions.form.is_active') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="sh-form-section">
                        <h3 class="sh-section-title"><i class="fas fa-bullseye"></i> {{ __('admin.gamification-2.missions.form.goals_section') }}</h3>

                        <div class="sh-reward-grid">
                            <div class="sh-form-group">
                                <label class="sh-label">{{ __('admin.gamification-2.missions.form.target_action') }}</label>
                                <input type="text" name="target_action" class="sh-input"
                                    value="{{ old('target_action', $mission->target_action) }}" required>
                                <small
                                    style="color: rgba(255,255,255,0.3); font-size: 0.7rem; margin-top: 5px; display: block;">{{ __('admin.gamification-2.missions.form.target_action_helper') }}</small>
                            </div>

                            <div class="sh-form-group">
                                <label class="sh-label">{{ __('admin.gamification-2.missions.form.goal_amount') }}</label>
                                <input type="number" name="goal_amount" class="sh-input"
                                    value="{{ old('goal_amount', $mission->goal_amount) }}" min="1" required>
                            </div>
                        </div>
                    </div>

                    <div class="sh-form-section">
                        <h3 class="sh-section-title"><i class="fas fa-gift"></i> {{ __('admin.gamification-2.missions.form.rewards_section') }}</h3>

                        <div class="sh-reward-grid">
                            <div class="sh-form-group">
                                <label class="sh-label">{{ __('admin.gamification-2.missions.form.reward_xp') }}</label>
                                <div style="position: relative;">
                                    <input type="number" name="reward_xp" class="sh-input"
                                        value="{{ old('reward_xp', $mission->reward_xp) }}" min="0"
                                        style="padding-left: 45px;" required>
                                    <i class="fas fa-bolt"
                                        style="position: absolute; left: 18px; top: 15px; color: var(--admin-gold);"></i>
                                </div>
                            </div>

                            <div class="sh-form-group">
                                <label class="sh-label">{{ __('admin.gamification-2.missions.form.reward_tickets') }}</label>
                                <div style="position: relative;">
                                    <input type="number" name="reward_tickets" class="sh-input"
                                        value="{{ old('reward_tickets', $mission->reward_tickets) }}" min="0"
                                        style="padding-left: 45px;" required>
                                    <i class="fas fa-ticket-alt"
                                        style="position: absolute; left: 18px; top: 15px; color: var(--admin-gold);"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Logro al completar --}}
                        <div class="sh-form-group">
                            <label class="sh-label">
                                <i class="fas fa-trophy" style="color: #fbbf24; margin-right: 5px;"></i>
                                {{ __('admin.gamification-2.missions.form.achievement') }}
                            </label>
                            <select name="achievement_id" class="sh-select">
                                <option value="">{{ __('admin.gamification-2.missions.form.no_achievement') }}</option>
                                @foreach($achievements as $achievement)
                                    <option value="{{ $achievement->id }}"
                                        {{ old('achievement_id', $mission->achievement_id) == $achievement->id ? 'selected' : '' }}>
                                        {{ $achievement->name }}
                                        @if($achievement->rarity) ({{ $achievement->rarity }}) @endif
                                    </option>
                                @endforeach
                            </select>
                            <small style="color: rgba(255,255,255,0.35); font-size: 0.7rem; margin-top: 5px; display: block;">
                                {{ __('admin.gamification-2.missions.form.achievement_helper') }}
                            </small>
                        </div>

                        {{-- Insignia al completar --}}
                        <div class="sh-form-group" style="margin-bottom: 0;">
                            <label class="sh-label">
                                <i class="fas fa-medal" style="color: #818cf8; margin-right: 5px;"></i>
                                {{ __('admin.gamification-2.missions.form.badge') }}
                            </label>
                            <select name="badge_id" class="sh-select">
                                <option value="">{{ __('admin.gamification-2.missions.form.no_badge') }}</option>
                                @foreach($badges as $badge)
                                    <option value="{{ $badge->id }}"
                                        {{ old('badge_id', $mission->badge_id) == $badge->id ? 'selected' : '' }}>
                                        {{ $badge->name }} ({{ $badge->type }})
                                    </option>
                                @endforeach
                            </select>
                            <small style="color: rgba(255,255,255,0.35); font-size: 0.7rem; margin-top: 5px; display: block;">
                                {{ __('admin.gamification-2.missions.form.badge_helper') }}
                            </small>
                        </div>
                    </div>

                    <div class="sh-form-actions">
                        <a href="{{ route('admin.gamification.missions.index') }}"
                            class="sh-btn-cancel">{{ __('admin.gamification-2.missions.form.cancel') }}</a>
                        <button type="submit" class="sh-btn-save">
                            <i class="fas fa-save"></i> {{ __('admin.gamification-2.missions.form.submit_edit') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="sh-guide-column">
            <div class="sh-guide-card">
                <h3 class="sh-guide-title"><i class="fas fa-book"></i> {{ __('admin.gamification-2.missions.guide.title') }}</h3>

                <div class="sh-guide-section">
                    <h4 class="sh-guide-subtitle">{{ __('admin.gamification-2.missions.guide.types_title') }}</h4>
                    <ul class="sh-guide-list">
                        <li>
                            <i class="fas fa-chevron-right"></i>
                            <div><span class="sh-code-badge">WEEKLY</span><br>{{ __('admin.gamification-2.missions.guide.types.weekly') }}</div>
                        </li>
                        <li>
                            <i class="fas fa-chevron-right"></i>
                            <div><span class="sh-code-badge">LEVEL_UP</span><br>{{ __('admin.gamification-2.missions.guide.types.level_up') }}</div>
                        </li>
                        <li>
                            <i class="fas fa-chevron-right"></i>
                            <div><span class="sh-code-badge">PARALLEL</span><br>{{ __('admin.gamification-2.missions.guide.types.parallel') }}</div>
                        </li>
                    </ul>
                </div>

                <div class="sh-guide-section">
                    <h4 class="sh-guide-subtitle">{{ __('admin.gamification-2.missions.guide.actions_title') }}</h4>
                    <ul class="sh-guide-list">
                        <li><i class="fas fa-dot-circle"></i> <span><span class="sh-code-badge">stream_watched</span><br>{{ __('admin.gamification-2.missions.guide.actions.stream_watched') }}</span></li>
                        <li><i class="fas fa-dot-circle"></i> <span><span
                                    class="sh-code-badge">chat_message_sent</span><br>{{ __('admin.gamification-2.missions.guide.actions.chat_message_sent') }}</span></li>
                        <li><i class="fas fa-dot-circle"></i> <span><span class="sh-code-badge">tip_sent</span><br>{{ __('admin.gamification-2.missions.guide.actions.tip_sent') }}</span></li>
                        <li><i class="fas fa-dot-circle"></i> <span><span
                                    class="sh-code-badge">subscription_purchased</span><br>{{ __('admin.gamification-2.missions.guide.actions.subscription_purchased') }}</span>
                        </li>
                        <li><i class="fas fa-dot-circle"></i> <span><span
                                    class="sh-code-badge">profile_updated</span><br>{{ __('admin.gamification-2.missions.guide.actions.profile_updated') }}</span></li>
                        <li><i class="fas fa-dot-circle"></i> <span><span
                                    class="sh-code-badge">photo_uploaded</span><br>{{ __('admin.gamification-2.missions.guide.actions.photo_uploaded') }}</span></li>
                    </ul>
                </div>

                <div class="sh-guide-section">
                    <h4 class="sh-guide-subtitle">{{ __('admin.gamification-2.missions.guide.tips_title') }}</h4>
                    <p style="color: rgba(255,255,255,0.6); font-size: 0.8rem; line-height: 1.5;">
                        {!! __('admin.gamification-2.missions.guide.tips_text') !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
