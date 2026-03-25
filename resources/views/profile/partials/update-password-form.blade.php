<div class="space-y-6">
    <div class="form-group">
        <label class="form-label" for="current_password">
            <i class="fas fa-lock-open mr-2 text-xs"></i>{{ __('profile.security.current_password') }}
        </label>
        <input id="current_password" name="current_password" type="password" class="form-input" autocomplete="current-password">
        @error('current_password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="password">
            <i class="fas fa-lock mr-2 text-xs"></i>{{ __('profile.security.new_password') }}
        </label>
        <input id="password" name="password" type="password" class="form-input" autocomplete="new-password">
        @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="password_confirmation">
            <i class="fas fa-check-double mr-2 text-xs"></i>{{ __('profile.security.confirm_password') }}
        </label>
        <input id="password_confirmation" name="password_confirmation" type="password" class="form-input" autocomplete="new-password">
        @error('password_confirmation')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center gap-4">
        <button type="submit" class="btn-primary">
            <i class="fas fa-key mr-2"></i>{{ __('profile.security.update_password') }}
        </button>

        @if (session('status') === 'password-updated')
            <p class="text-green-500 text-sm">
                {{ __('profile.security.password_updated') }}
            </p>
        @endif
    </div>
</div>