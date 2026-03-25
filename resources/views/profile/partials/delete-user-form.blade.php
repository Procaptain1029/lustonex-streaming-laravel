<div class="space-y-6">
    <div class="mb-4 text-sm text-gray-300">
        {{ __('profile.danger.delete_confirm_text') }}
    </div>

    <div class="form-group">
        <label for="password" class="form-label">{{ __('profile.security.current_password') }}</label>
        <input
            id="password"
            name="password"
            type="password"
            class="form-input"
            placeholder="{{ __('profile.danger.password_placeholder') }}"
            required
        />
        @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end gap-4">
        <button type="button" 
                class="btn-secondary" 
                onclick="this.closest('form').reset()">
            <i class="fas fa-times mr-2"></i>{{ __('profile.danger.cancel') }}
        </button>
        
        <button type="submit" class="btn-danger" onclick="return confirm('{{ __('profile.danger.confirm_js') }}')">
            <i class="fas fa-trash-alt mr-2"></i>{{ __('profile.danger.delete_button') }}
        </button>
    </div>
</div>