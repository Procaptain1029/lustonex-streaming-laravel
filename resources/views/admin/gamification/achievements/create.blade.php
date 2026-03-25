@extends('layouts.admin')

@section('title', __('admin.gamification.achievements.create.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('admin.gamification.achievements.index') }}" class="breadcrumb-item">{{ __('admin.gamification-2.achievements.index.title_header') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">Crear</span>
@endsection

@section('styles')
    <style>
        /* ----- Achievement Create/Edit Professional Styling ----- */
        .sh-page-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding-bottom: 80px;
        }

        .sh-form-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
        }

        .sh-section-title {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 24px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sh-form-group {
            margin-bottom: 24px;
        }

        .sh-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .sh-input,
        .sh-select,
        .sh-textarea {
            width: 100%;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 12px 16px;
            color: #fff;
            font-size: 16px;
            transition: all 0.2s ease;
        }

        .sh-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .sh-input:focus,
        .sh-select:focus,
        .sh-textarea:focus {
            outline: none;
            border-color: #fff;
            background: rgba(0, 0, 0, 0.4);
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.05);
        }

        /* Guide Sidebar */
        .sh-guide-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 16px;
            padding: 24px;
        }

        .sh-guide-title {
            font-size: 16px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sh-guide-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sh-guide-list li {
            margin-bottom: 12px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.5;
            display: flex;
            gap: 10px;
        }

        .sh-badge-pill {
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        /* Actions */
        .sh-form-actions {
            display: flex;
            gap: 16px;
            margin-top: 40px;
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
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

        @media(max-width: 900px) {
            .sh-page-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title">{{ __('admin.gamification-2.achievements.create.title') }}</h1>
        <p class="page-subtitle">{{ __('admin.gamification-2.achievements.create.subtitle') }}</p>
    </div>


    <div class="sh-page-grid">
        <!-- Form Column -->
        <div class="sh-form-column">
            <div class="sh-form-card">
                <form action="{{ route('admin.gamification.achievements.store') }}" method="POST">
                    @csrf

                    <div class="sh-section-title">
                        <i class="fas fa-info-circle"></i> {{ __('admin.gamification-2.achievements.form.basic_info') }}
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="sh-form-group">
                            <label class="sh-label">{{ __('admin.gamification-2.achievements.form.name') }}</label>
                            <input type="text" name="name" class="sh-input" placeholder="{{ __('admin.gamification-2.achievements.form.name_placeholder') }}"
                                value="{{ old('name') }}" required>
                        </div>
                        <div class="sh-form-group">
                            <label class="sh-label">{{ __('admin.gamification-2.achievements.form.slug') }}</label>
                            <input type="text" name="slug" class="sh-input" placeholder="{{ __('admin.gamification-2.achievements.form.slug_placeholder') }}"
                                value="{{ old('slug') }}" required>
                        </div>
                    </div>

                    <div class="sh-form-group">
                        <label class="sh-label">{{ __('admin.gamification-2.achievements.form.description') }}</label>
                        <textarea name="description" class="sh-textarea"
                            placeholder="{{ __('admin.gamification-2.achievements.form.description_placeholder') }}"
                            required>{{ old('description') }}</textarea>
                    </div>

                    <div class="sh-section-title" style="margin-top: 40px;">
                        <i class="fas fa-eye"></i> {{ __('admin.gamification-2.achievements.form.visualization') }}
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                        <div class="sh-form-group">
                            <label class="sh-label">{{ __('admin.gamification-2.achievements.form.icon') }}</label>
                            <input type="text" name="icon" class="sh-input" placeholder="{{ __('admin.gamification-2.achievements.form.icon_placeholder') }}"
                                value="{{ old('icon', 'fa-trophy') }}" required>
                        </div>
                        <div class="sh-form-group">
                            <label class="sh-label">{{ __('admin.gamification-2.achievements.form.rarity') }}</label>
                            <select name="rarity" class="sh-select" required>
                                <option value="common">{{ __('admin.gamification-2.achievements.form.rarities.common') }}</option>
                                <option value="rare">{{ __('admin.gamification-2.achievements.form.rarities.rare') }}</option>
                                <option value="epic">{{ __('admin.gamification-2.achievements.form.rarities.epic') }}</option>
                                <option value="legendary">{{ __('admin.gamification-2.achievements.form.rarities.legendary') }}</option>
                            </select>
                        </div>
                        <div class="sh-form-group">
                            <label class="sh-label">{{ __('admin.gamification-2.achievements.form.category') }}</label>
                            <select name="category" class="sh-select" required>
                                <option value="content">{{ __('admin.gamification-2.achievements.form.categories_list.content') }}</option>
                                <option value="earnings">{{ __('admin.gamification-2.achievements.form.categories_list.earnings') }}</option>
                                <option value="popularity">{{ __('admin.gamification-2.achievements.form.categories_list.popularity') }}</option>
                                <option value="special">{{ __('admin.gamification-2.achievements.form.categories_list.special') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="sh-section-title" style="margin-top: 40px;">
                        <i class="fas fa-gift"></i> {{ __('admin.gamification-2.achievements.form.rewards_rules') }}
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="sh-form-group">
                            <label class="sh-label">{{ __('admin.gamification-2.achievements.form.role_recipient') }}</label>
                            <select name="role" class="sh-select" required>
                                <option value="fan">{{ __('admin.gamification-2.achievements.form.roles.fan') }}</option>
                                <option value="model">{{ __('admin.gamification-2.achievements.form.roles.model') }}</option>
                                <option value="both">{{ __('admin.gamification-2.achievements.form.roles.both') }}</option>
                            </select>
                        </div>
                        <div class="sh-form-group">
                            <label class="sh-label">{{ __('admin.gamification-2.achievements.form.status') }}</label>
                            <select name="is_active" class="sh-select">
                                <option value="1">{{ __('admin.gamification-2.achievements.form.statuses.active') }}</option>
                                <option value="0">{{ __('admin.gamification-2.achievements.form.statuses.inactive') }}</option>
                            </select>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="sh-form-group">
                            <label class="sh-label">{{ __('admin.gamification-2.achievements.form.xp') }}</label>
                            <input type="number" name="xp_reward" class="sh-input" value="{{ old('xp_reward', 0) }}"
                                min="0">
                        </div>
                        <div class="sh-form-group">
                            <label class="sh-label">{{ __('admin.gamification-2.achievements.form.tickets') }}</label>
                            <input type="number" name="ticket_reward" class="sh-input" value="{{ old('ticket_reward', 0) }}"
                                min="0">
                        </div>
                    </div>

                    <div class="sh-form-actions">
                        <a href="{{ route('admin.gamification.achievements.index') }}" class="sh-btn-cancel">{{ __('admin.gamification-2.achievements.form.cancel') }}</a>
                        <button type="submit" class="sh-btn-save">{{ __('admin.gamification-2.achievements.form.submit_create') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Guide Column -->
        <div class="sh-guide-column">
            <div class="sh-guide-card">
                <h3 class="sh-guide-title"><i class="fas fa-book"></i> {{ __('admin.gamification-2.achievements.guide.title') }}</h3>

                <p style="color: rgba(255,255,255,0.5); font-size: 13px; margin-bottom: 20px;">{{ __('admin.gamification-2.achievements.guide.description') }}</p>

                <ul class="sh-guide-list">
                    <li>
                        <i class="fas fa-circle" style="color: #60a5fa; font-size: 8px; margin-top: 6px;"></i>
                        <div>
                            <strong>{{ __('admin.gamification-2.achievements.guide.category') }}</strong><br>{{ __('admin.gamification-2.achievements.guide.category_desc') }}
                        </div>
                    </li>
                    <li>
                        <i class="fas fa-circle" style="color: #c084fc; font-size: 8px; margin-top: 6px;"></i>
                        <div>
                            <strong>{{ __('admin.gamification-2.achievements.guide.rarity') }}</strong><br>{{ __('admin.gamification-2.achievements.guide.rarity_desc') }}
                        </div>
                    </li>
                    <li>
                        <i class="fas fa-circle" style="color: #facc15; font-size: 8px; margin-top: 6px;"></i>
                        <div>
                            <strong>{{ __('admin.gamification-2.achievements.guide.slug') }}</strong><br>{{ __('admin.gamification-2.achievements.guide.slug_desc') }}
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection