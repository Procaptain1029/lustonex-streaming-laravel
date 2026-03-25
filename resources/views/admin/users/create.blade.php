@extends('layouts.admin')

@section('title', __('admin.users.create.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('admin.users.index') }}" class="breadcrumb-item">{{ __('admin.users.breadcrumb') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.users.create.breadcrumb') }}</span>
@endsection

@section('styles')
<style>
    /* ----- Create User Professional Styling ----- */

    .sh-page-layout {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 24px;
        align-items: start;
    }

    .sh-admin-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 20px;
        padding: 36px;
        position: relative;
        overflow: hidden;
    }

    .sh-admin-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle at top right, rgba(212, 175, 55, 0.08), transparent 70%);
        pointer-events: none;
    }

    /* Form Groups */
    .sh-form-group {
        margin-bottom: 22px;
    }

    .sh-form-label {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 0.75rem;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.45);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 9px;
    }

    .sh-form-label i {
        color: var(--admin-gold);
        font-size: 0.65rem;
    }

    .sh-form-input {
        width: 100%;
        background: rgba(255, 255, 255, 0.03) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 12px;
        padding: 13px 18px;
        color: #fff !important;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    select.sh-form-input {
        background-color: #151517 !important;
        cursor: pointer;
    }

    select.sh-form-input option {
        background-color: #151517;
        color: #fff;
    }

    .sh-form-input:focus {
        outline: none;
        border-color: var(--admin-gold) !important;
        background: rgba(255, 255, 255, 0.05) !important;
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1) !important;
    }

    .sh-form-input::placeholder {
        color: rgba(255, 255, 255, 0.18);
    }

    /* Password row */
    .sh-form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    /* Role Info Panel */
    .sh-role-info {
        margin-top: 12px;
        padding: 13px 16px;
        background: rgba(212, 175, 55, 0.05);
        border-left: 3px solid var(--admin-gold);
        border-radius: 0 10px 10px 0;
        font-size: 0.82rem;
        color: rgba(255, 255, 255, 0.65);
        display: none;
        line-height: 1.5;
    }

    /* Custom Checkbox */
    .sh-checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 14px;
        cursor: pointer;
        padding: 14px 16px;
        background: rgba(255, 255, 255, 0.02);
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.06);
        transition: all 0.3s ease;
    }

    .sh-checkbox-wrapper:hover {
        background: rgba(255, 255, 255, 0.04);
        border-color: rgba(212, 175, 55, 0.2);
    }

    .sh-custom-checkbox {
        width: 20px;
        height: 20px;
        border-radius: 6px;
        border: 2px solid rgba(212, 175, 55, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    input[type="checkbox"]:checked + .sh-custom-checkbox {
        background: var(--admin-gold);
        border-color: var(--admin-gold);
    }

    input[type="checkbox"]:checked + .sh-custom-checkbox i {
        display: block;
    }

    .sh-custom-checkbox i {
        display: none;
        color: #000;
        font-size: 0.65rem;
    }

    /* Info notice */
    .sh-notice {
        margin-top: 24px;
        padding: 16px 18px;
        background: rgba(16, 185, 129, 0.05);
        border: 1px solid rgba(16, 185, 129, 0.12);
        border-radius: 12px;
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .sh-notice i {
        color: #10b981;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .sh-notice p {
        font-size: 0.82rem;
        color: rgba(255, 255, 255, 0.55);
        line-height: 1.6;
        margin: 0;
    }

    /* Form Actions */
    .sh-form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
    }

    .sh-btn-cancel {
        padding: 11px 22px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.45);
        transition: all 0.3s ease;
        text-decoration: none;
        border: 1px solid rgba(255, 255, 255, 0.06);
    }

    .sh-btn-cancel:hover {
        color: #fff;
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.12);
    }

    .sh-btn-submit {
        background: linear-gradient(135deg, #D4AF37, #FFD700);
        color: #000;
        padding: 12px 28px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 0.9rem;
        border: none;
        cursor: pointer;
        box-shadow: 0 6px 18px rgba(212, 175, 55, 0.25);
        display: flex;
        align-items: center;
        gap: 9px;
        transition: all 0.3s ease;
    }

    .sh-btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(212, 175, 55, 0.35);
    }

    /* Error States */
    .sh-error-text {
        color: #ef4444;
        font-size: 0.75rem;
        margin-top: 7px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .sh-input-error {
        border-color: rgba(239, 68, 68, 0.4) !important;
    }

    /* Sidebar Tips Column */
    .sh-sidebar-col {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .sh-tip-card {
        padding: 20px;
        background: rgba(255, 255, 255, 0.01);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 16px;
    }

    .sh-tip-title {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--admin-gold);
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .sh-tip-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .sh-tip-item {
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.4);
        display: flex;
        align-items: flex-start;
        gap: 9px;
        line-height: 1.45;
    }

    .sh-tip-item i {
        font-size: 0.4rem;
        margin-top: 5px;
        flex-shrink: 0;
        color: var(--admin-gold);
        opacity: 0.6;
    }

    /* Role Badge Previews */
    .sh-role-preview {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .sh-role-preview-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.04);
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.6);
    }

    .sh-role-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    /* Responsive */
    @media (max-width: 1100px) {
        .sh-page-layout {
            grid-template-columns: 1fr 280px;
        }
    }

    @media (max-width: 900px) {
        .sh-page-layout {
            grid-template-columns: 1fr;
        }

        .sh-sidebar-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 600px) {
        .sh-admin-card {
            padding: 22px 18px;
            border-radius: 16px;
        }

        .sh-form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .sh-form-actions {
            flex-direction: column;
            gap: 10px;
            margin-top: 24px;
        }

        .sh-btn-submit,
        .sh-btn-cancel {
            width: 100%;
            justify-content: center;
            text-align: center;
        }

        .sh-btn-cancel {
            order: 2;
        }

        .sh-sidebar-col {
            grid-template-columns: 1fr;
        }

        .sh-sidebar-col {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="page-header" style="margin-bottom: 28px;">
    <h1 class="page-title">{{ __('admin.users.create.header') }}</h1>
    <p class="page-subtitle">{{ __('admin.users.create.subtitle') }}</p>
</div>

<div class="sh-page-layout">

    {{-- FORM COLUMN --}}
    <div class="sh-admin-card">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            {{-- Name --}}
            <div class="sh-form-group">
                <label for="name" class="sh-form-label">
                    <i class="fas fa-user"></i> {{ __('admin.users.create.form.name') }}
                </label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       class="sh-form-input @error('name') sh-input-error @enderror"
                       placeholder="{{ __('admin.users.create.form.name_placeholder') }}"
                       required>
                @error('name')
                    <p class="sh-error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="sh-form-group">
                <label for="email" class="sh-form-label">
                    <i class="fas fa-envelope"></i> {{ __('admin.users.create.form.email') }}
                </label>
                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       class="sh-form-input @error('email') sh-input-error @enderror"
                       placeholder="{{ __('admin.users.create.form.email_placeholder') }}"
                       required>
                @error('email')
                    <p class="sh-error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            {{-- Password row --}}
            <div class="sh-form-row">
                <div class="sh-form-group">
                    <label for="password" class="sh-form-label">
                        <i class="fas fa-lock"></i> {{ __('admin.users.create.form.password') }}
                    </label>
                    <input type="password"
                           id="password"
                           name="password"
                           class="sh-form-input @error('password') sh-input-error @enderror"
                           placeholder="{{ __('admin.users.create.form.password_placeholder') }}"
                           required>
                    @error('password')
                        <p class="sh-error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="sh-form-group">
                    <label for="password_confirmation" class="sh-form-label">
                        <i class="fas fa-lock"></i> {{ __('admin.users.create.form.password_confirm') }}
                    </label>
                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           class="sh-form-input"
                           placeholder="{{ __('admin.users.create.form.password_confirm_placeholder') }}"
                           required>
                </div>
            </div>

            {{-- Role --}}
            <div class="sh-form-group">
                <label for="role" class="sh-form-label">
                    <i class="fas fa-id-badge"></i> {{ __('admin.users.create.form.role') }}
                </label>
                <select id="role"
                        name="role"
                        class="sh-form-input @error('role') sh-input-error @enderror"
                        required>
                    <option value="">{{ __('admin.users.create.form.role_select') }}</option>
                    <option value="fan"   {{ old('role') === 'fan'   ? 'selected' : '' }}>{{ __('admin.users.create.form.role_fan') }}</option>
                    <option value="model" {{ old('role') === 'model' ? 'selected' : '' }}>{{ __('admin.users.create.form.role_model') }}</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>{{ __('admin.users.create.form.role_admin') }}</option>
                </select>
                @error('role')
                    <p class="sh-error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror

                <div id="fan-desc"   class="sh-role-info">{!! __('admin.users.create.form.role_fan_desc') !!}</div>
                <div id="model-desc" class="sh-role-info">{!! __('admin.users.create.form.role_model_desc') !!}</div>
                <div id="admin-desc" class="sh-role-info">{!! __('admin.users.create.form.role_admin_desc') !!}</div>
            </div>

            {{-- Active toggle --}}
            <div class="sh-form-group">
                <label class="sh-form-label"><i class="fas fa-toggle-on"></i> {{ __('admin.users.create.form.initial_config') }}</label>
                <label class="sh-checkbox-wrapper">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="display: none;">
                    <div class="sh-custom-checkbox"><i class="fas fa-check"></i></div>
                    <div>
                        <span style="font-weight: 700; font-size: 0.88rem; display: block; color: #fff;">{{ __('admin.users.create.form.activate_now') }}</span>
                        <span style="font-size: 0.78rem; color: rgba(255,255,255,0.3);">{{ __('admin.users.create.form.activate_now_desc') }}</span>
                    </div>
                </label>
            </div>

            {{-- Notice --}}
            <div class="sh-notice">
                <i class="fas fa-info-circle"></i>
                <p>{{ __('admin.users.create.form.notice') }}</p>
            </div>

            {{-- Actions --}}
            <div class="sh-form-actions">
                <a href="{{ route('admin.users.index') }}" class="sh-btn-cancel">{{ __('admin.users.create.form.cancel') }}</a>
                <button type="submit" class="sh-btn-submit">
                    <i class="fas fa-user-plus"></i> {{ __('admin.users.create.form.submit') }}
                </button>
            </div>
        </form>
    </div>

    {{-- SIDEBAR TIPS COLUMN --}}
    <div class="sh-sidebar-col">

        {{-- Security Tips --}}
        <div class="sh-tip-card">
            <h4 class="sh-tip-title"><i class="fas fa-shield-alt"></i> {{ __('admin.users.create.tips.security_title') }}</h4>
            <ul class="sh-tip-list">
                <li class="sh-tip-item"><i class="fas fa-circle"></i> {{ __('admin.users.create.tips.sec_1') }}</li>
                <li class="sh-tip-item"><i class="fas fa-circle"></i> {{ __('admin.users.create.tips.sec_2') }}</li>
                <li class="sh-tip-item"><i class="fas fa-circle"></i> {{ __('admin.users.create.tips.sec_3') }}</li>
            </ul>
        </div>

        {{-- Role Descriptions --}}
        <div class="sh-tip-card">
            <h4 class="sh-tip-title"><i class="fas fa-users-cog"></i> {{ __('admin.users.create.tips.roles_title') }}</h4>
            <div class="sh-role-preview">
                <div class="sh-role-preview-item">
                    <div class="sh-role-dot" style="background: rgba(255,255,255,0.4);"></div>
                    <span>{!! __('admin.users.create.tips.role_fan') !!}</span>
                </div>
                <div class="sh-role-preview-item">
                    <div class="sh-role-dot" style="background: #a855f7;"></div>
                    <span>{!! __('admin.users.create.tips.role_model') !!}</span>
                </div>
                <div class="sh-role-preview-item">
                    <div class="sh-role-dot" style="background: var(--admin-gold);"></div>
                    <span>{!! __('admin.users.create.tips.role_admin') !!}</span>
                </div>
            </div>
            <p style="font-size: 0.78rem; color: rgba(255,255,255,0.3); margin-top: 14px; margin-bottom: 0;">{{ __('admin.users.create.tips.role_notice') }}</p>
        </div>

        {{-- Quick links --}}
        <div class="sh-tip-card" style="background: rgba(212,175,55,0.04); border-color: rgba(212,175,55,0.1);">
            <h4 class="sh-tip-title"><i class="fas fa-bolt"></i> {{ __('admin.users.create.tips.shortcuts_title') }}</h4>
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <a href="{{ route('admin.users.index') }}" style="font-size: 0.82rem; color: rgba(255,255,255,0.5); display: flex; align-items: center; gap: 8px; padding: 8px 10px; border-radius: 8px; transition: all 0.2s; text-decoration: none;">
                    <i class="fas fa-list" style="color: var(--admin-gold); width: 14px;"></i> {{ __('admin.users.create.tips.link_users') }}
                </a>
                <a href="{{ route('admin.models.index') }}" style="font-size: 0.82rem; color: rgba(255,255,255,0.5); display: flex; align-items: center; gap: 8px; padding: 8px 10px; border-radius: 8px; transition: all 0.2s; text-decoration: none;">
                    <i class="fas fa-user-tie" style="color: var(--admin-gold); width: 14px;"></i> {{ __('admin.users.create.tips.link_models') }}
                </a>
                <a href="{{ route('admin.verification.index') }}" style="font-size: 0.82rem; color: rgba(255,255,255,0.5); display: flex; align-items: center; gap: 8px; padding: 8px 10px; border-radius: 8px; transition: all 0.2s; text-decoration: none;">
                    <i class="fas fa-check-circle" style="color: var(--admin-gold); width: 14px;"></i> {{ __('admin.users.create.tips.link_verification') }}
                </a>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        const roleInfos = {
            'fan':   document.getElementById('fan-desc'),
            'model': document.getElementById('model-desc'),
            'admin': document.getElementById('admin-desc')
        };

        const updateRoleInfo = () => {
            const role = roleSelect.value;
            Object.values(roleInfos).forEach(el => el.style.display = 'none');
            if (role && roleInfos[role]) roleInfos[role].style.display = 'block';
        };

        roleSelect.addEventListener('change', updateRoleInfo);
        if (roleSelect.value) updateRoleInfo();

        // Custom Checkbox
        const checkboxWrapper = document.querySelector('.sh-checkbox-wrapper');
        const checkboxInput = checkboxWrapper.querySelector('input[type="checkbox"]');
        checkboxWrapper.addEventListener('click', (e) => {
            if (e.target !== checkboxInput) checkboxInput.checked = !checkboxInput.checked;
        });
    });
</script>
@endsection
