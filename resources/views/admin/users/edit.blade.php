@extends('layouts.admin')

@section('title', __('admin.users.edit.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('admin.users.index') }}" class="breadcrumb-item">{{ __('admin.users.breadcrumb') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('admin.users.show', $user) }}" class="breadcrumb-item">{{ $user->name }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.users.edit.breadcrumb') }}</span>
@endsection

@section('styles')
<style>
    .sh-edit-card {
        background: rgba(30, 30, 35, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 24px;
        padding: 40px;
        max-width: 800px;
        margin: 0 auto;
    }

    .sh-form-group {
        margin-bottom: 25px;
    }

    .sh-label {
        display: block;
        font-size: 0.9rem;
        color: rgba(255,255,255,0.7);
        margin-bottom: 8px;
        font-weight: 500;
    }

    .sh-input {
        width: 100%;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 12px 15px;
        color: #fff;
        font-size: 1rem;
        transition: all 0.3s;
    }

    .sh-input:focus {
        border-color: var(--admin-gold);
        box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.2);
        outline: none;
        background: rgba(255, 255, 255, 0.05);
    }
    
    .sh-select {
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='rgba(255,255,255,0.5)'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 16px;
    }

    .sh-checkbox-group {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 15px;
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 12px;
    }

    .sh-checkbox {
        width: 20px;
        height: 20px;
        accent-color: var(--admin-gold);
        cursor: pointer;
    }

    .sh-form-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 40px;
        padding-top: 25px;
        border-top: 1px solid rgba(255,255,255,0.05);
    }

    .btn-submit {
        background: linear-gradient(135deg, var(--admin-gold) 0%, #b8860b 100%);
        color: #000;
        font-weight: 700;
        padding: 12px 30px;
        border-radius: 50px;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
    }

    .btn-cancel {
        color: rgba(255,255,255,0.6);
        text-decoration: none;
        font-size: 0.95rem;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-cancel:hover {
        color: #fff;
    }

    .sh-error {
        color: #ef4444;
        font-size: 0.8rem;
        margin-top: 5px;
        display: block;
    }
    
    .sh-section-title {
        color: #fff;
        font-size: 1.5rem;
        margin-bottom: 30px;
        font-weight: 700;
        text-align: center;
    }
</style>
@endsection

@section('content')
<div class="sh-edit-card">
    <h2 class="sh-section-title"><i class="fas fa-user-edit" style="color: var(--admin-gold); margin-right: 10px;"></i> {{ __('admin.users.edit.header') }}</h2>
    
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')

        
        <div class="sh-form-group">
            <label for="name" class="sh-label">{{ __('admin.users.edit.form.name') }}</label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="{{ old('name', $user->name) }}"
                   class="sh-input"
                   placeholder="{{ __('admin.users.edit.form.name_placeholder') }}"
                   required>
            @error('name')
                <span class="sh-error">{{ $message }}</span>
            @enderror
        </div>

        
        <div class="sh-form-group">
            <label for="email" class="sh-label">{{ __('admin.users.edit.form.email') }}</label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   value="{{ old('email', $user->email) }}"
                   class="sh-input"
                   placeholder="{{ __('admin.users.edit.form.email_placeholder') }}"
                   required>
            @error('email')
                <span class="sh-error">{{ $message }}</span>
            @enderror
        </div>

        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            
            <div class="sh-form-group">
                <label for="role" class="sh-label">{{ __('admin.users.edit.form.role') }}</label>
                <select id="role" name="role" class="sh-input sh-select" required>
                    <option value="fan" {{ old('role', $user->role) === 'fan' ? 'selected' : '' }}>{{ __('admin.users.edit.form.role_fan') }}</option>
                    <option value="model" {{ old('role', $user->role) === 'model' ? 'selected' : '' }}>{{ __('admin.users.edit.form.role_model') }}</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>{{ __('admin.users.edit.form.role_admin') }}</option>
                </select>
                @error('role')
                    <span class="sh-error">{{ $message }}</span>
                @enderror
            </div>

            
            <div class="sh-form-group">
                <label class="sh-label">{{ __('admin.users.edit.form.status') }}</label>
                <div class="sh-checkbox-group">
                    <input id="is_active" 
                           name="is_active" 
                           type="checkbox" 
                           value="1"
                           {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                           class="sh-checkbox">
                    <label for="is_active" style="color: #fff; font-size: 0.95rem; cursor: pointer;">
                        {{ __('admin.users.edit.form.user_active') }}
                    </label>
                </div>
            </div>
        </div>

        <div style="margin: 30px 0; border-top: 1px dashed rgba(255,255,255,0.1);"></div>

        
        <div class="sh-form-group">
            <label for="password" class="sh-label">{{ __('admin.users.edit.form.password_new') }}</label>
            <input type="password" 
                   id="password" 
                   name="password" 
                   class="sh-input"
                   placeholder="{{ __('admin.users.edit.form.password_new_placeholder') }}">
            <p style="font-size: 0.75rem; color: rgba(255,255,255,0.3); margin-top: 5px;">
                {{ __('admin.users.edit.form.password_new_help') }}
            </p>
            @error('password')
                <span class="sh-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="sh-form-group">
            <label for="password_confirmation" class="sh-label">{{ __('admin.users.edit.form.password_confirm') }}</label>
            <input type="password" 
                   id="password_confirmation" 
                   name="password_confirmation" 
                   class="sh-input"
                   placeholder="{{ __('admin.users.edit.form.password_confirm_placeholder') }}">
        </div>

        
        <div class="sh-form-footer">
            <a href="{{ route('admin.users.index') }}" class="btn-cancel">
                <i class="fas fa-times"></i> {{ __('admin.users.edit.form.cancel') }}
            </a>
            
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> {{ __('admin.users.edit.form.submit') }}
            </button>
        </div>
    </form>
</div>
@endsection
