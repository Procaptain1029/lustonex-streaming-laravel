<div class="space-y-6">
    <div class="form-group">
        <label class="form-label" for="name">
            <i class="fas fa-user mr-2 text-xs"></i>{{ __('profile.form.public_name') }}
        </label>
        <input id="name" name="name" type="text" class="form-input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
        @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="email">
            <i class="fas fa-envelope mr-2 text-xs"></i>{{ __('profile.form.email') }}
            <span style="font-size: 0.7rem; color: rgba(255,255,255,0.3); margin-left: 6px;"><i class="fas fa-lock" style="font-size: 0.6rem;"></i> {{ __('profile.form.not_editable') }}</span>
        </label>
        <input id="email" name="email" type="email" class="form-input" value="{{ $user->email }}" disabled readonly style="opacity: 0.5; cursor: not-allowed;">
    </div>

    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div style="background: rgba(212, 175, 55, 0.08); border: 1px solid rgba(212, 175, 55, 0.25); border-radius: 12px; padding: 0.85rem 1rem; margin-bottom: 1rem;">
            <p style="margin: 0; font-size: 0.85rem; color: var(--color-oro-sensual); display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                <i class="fas fa-exclamation-triangle" style="font-size: 0.9rem;"></i>
                {{ __('profile.form.email_unverified') }}

                <button form="send-verification" style="background: none; border: none; color: var(--color-oro-sensual); text-decoration: underline; cursor: pointer; font-weight: 600; font-size: 0.85rem; padding: 0;">
                    {{ __('profile.form.resend_verification') }}
                </button>
            </p>

            @if (session('status') === 'verification-link-sent')
                <p style="margin: 8px 0 0; font-size: 0.8rem; color: #10b981; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-check-circle"></i> {{ __('profile.form.verification_sent') }}
                </p>
            @endif
        </div>
    @endif

    <div class="flex items-center gap-4">
        <button type="submit" class="btn-primary">
            <i class="fas fa-save mr-2"></i>{{ __('profile.form.save_changes') }}
        </button>

        @if (session('status') === 'profile-updated')
            <p class="text-green-500 text-sm">
                {{ __('profile.form.saved') }}
            </p>
        @endif
    </div>
</div>