@extends('layouts.public')

@section('title', __('profile.title') . ' - Lustonex')


@section('content')
<style>
/* Container */
.profile-page {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0.5rem 2rem 3rem;
}

/* Identity Card */
.identity-card {
    background: rgba(25, 25, 30, 0.8);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: 24px;
    overflow: hidden;
    margin-bottom: 2rem;
    box-shadow: 0 15px 40px rgba(0,0,0,0.4);
}

.identity-cover {
    height: 110px;
    background: linear-gradient(135deg, rgba(212, 175, 55, 0.15), rgba(11, 11, 13, 0.8));
}

.identity-body {
    display: flex;
    padding: 0 2rem 2rem;
    margin-top: -55px;
    gap: 2rem;
    align-items: flex-end;
}

.identity-avatar-wrap {
    position: relative;
    flex-shrink: 0;
}

.identity-avatar, .identity-initials {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 4px solid #19191e;
    box-shadow: 0 8px 25px rgba(0,0,0,0.5);
    object-fit: cover;
}

.identity-initials {
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--gradient-gold);
    color: #000;
    font-size: 2.5rem;
    font-weight: 800;
}

.identity-liga {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 40px;
    height: 40px;
    background: #19191e;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 4px;
    border: 2px solid var(--color-oro-sensual);
}

.identity-liga img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.identity-info {
    flex: 1;
    padding-bottom: 0.25rem;
    min-width: 0;
}

.identity-top-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 4px;
}

.identity-name {
    font-family: var(--font-titles);
    font-size: 1.8rem;
    font-weight: 700;
    color: #fff;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.identity-role-tag {
    font-size: 0.65rem;
    text-transform: uppercase;
    background: rgba(212, 175, 55, 0.1);
    color: var(--color-oro-sensual);
    padding: 3px 10px;
    border-radius: 20px;
    letter-spacing: 1px;
    font-weight: 700;
}

.btn-view-profile {
    padding: 6px 14px;
    font-size: 0.78rem;
    font-weight: 600;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 8px;
    color: #fff;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.3s ease;
}

.btn-view-profile:hover {
    background: rgba(212, 175, 55, 0.1);
    border-color: rgba(212, 175, 55, 0.3);
    color: var(--color-oro-sensual);
}

.identity-email {
    color: rgba(255,255,255,0.5);
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.identity-stats-row {
    display: flex;
    gap: 2.5rem;
    margin-bottom: 1rem;
}

.id-stat {
    display: flex;
    flex-direction: column;
}

.id-stat-label {
    font-size: 0.65rem;
    text-transform: uppercase;
    color: rgba(255,255,255,0.35);
    letter-spacing: 1px;
}

.id-stat-value {
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--color-oro-sensual);
}

.id-xp-bar-wrap {
    max-width: 350px;
}

.id-xp-labels {
    display: flex;
    justify-content: space-between;
    font-size: 0.75rem;
    margin-bottom: 5px;
    color: rgba(255,255,255,0.55);
}

.id-xp-track {
    height: 8px;
    background: rgba(255,255,255,0.05);
    border-radius: 8px;
    overflow: hidden;
}

.id-xp-fill {
    height: 100%;
    background: var(--gradient-gold);
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(212, 175, 55, 0.4);
    transition: width 1s ease;
}

/* Forms Grid */
.forms-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.form-card {
    background: rgba(25, 25, 30, 0.7);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: 20px;
    padding: 1.75rem;
    transition: all 0.3s ease;
}

.form-card:hover {
    border-color: rgba(212, 175, 55, 0.2);
}

.form-card.danger {
    grid-column: 1 / -1;
    border-color: rgba(239, 68, 68, 0.15);
}

.form-card.danger:hover {
    border-color: rgba(239, 68, 68, 0.3);
}

.card-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 1.5rem;
}

.card-header-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}

.card-header-icon.gold { background: rgba(212, 175, 55, 0.1); color: var(--color-oro-sensual); }
.card-header-icon.blue { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
.card-header-icon.red { background: rgba(239, 68, 68, 0.1); color: #ef4444; }

.card-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #dfc04e;
    margin: 0;
}

/* Form Elements */
.form-group {
    margin-bottom: 1.25rem;
}

.form-label {
    display: block;
    color: rgba(255, 255, 255, 0.7);
    margin-bottom: 6px;
    font-weight: 500;
    font-size: 0.85rem;
}

.form-label i {
    color: var(--color-oro-sensual);
    margin-right: 6px;
    font-size: 0.75rem;
}

.form-input {
    width: 100%;
    padding: 0.7rem 1rem;
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 10px;
    color: white;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.form-input:focus {
    border-color: var(--color-oro-sensual);
    outline: none;
    box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
    background: rgba(255, 255, 255, 0.06);
}

.form-input::placeholder {
    color: rgba(255,255,255,0.25);
}

/* Buttons */
.btn-primary {
    background: var(--gradient-gold);
    color: #000;
    padding: 0.65rem 1.5rem;
    border: none;
    border-radius: 10px;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(212, 175, 55, 0.35);
}

.btn-secondary {
    background: rgba(255, 255, 255, 0.05);
    color: #fff;
    padding: 0.65rem 1.5rem;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-secondary:hover {
    background: rgba(255, 255, 255, 0.08);
}

.btn-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    padding: 0.65rem 1.5rem;
    border: none;
    border-radius: 10px;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(220, 38, 38, 0.35);
}

/* Danger Zone */
.danger-zone {
    border-left: 3px solid #ef4444;
    padding-left: 1.25rem;
    margin-top: 0.5rem;
}

.danger-zone h3 {
    color: #ef4444;
    margin-bottom: 0.5rem;
    font-size: 1rem;
    font-weight: 700;
}

.danger-zone > p {
    color: rgba(255,255,255,0.45);
    font-size: 0.85rem;
    margin-bottom: 1.25rem;
}

/* Utility */
.text-red-500 { color: #ef4444; }
.text-green-500 { color: #10b981; }
.text-sm { font-size: 0.85rem; }
.text-xs { font-size: 0.75rem; }
.mt-1 { margin-top: 0.25rem; }
.mt-2 { margin-top: 0.5rem; }
.mr-2 { margin-right: 0.5rem; }
.mr-3 { margin-right: 0.75rem; }
.mb-4 { margin-bottom: 1rem; }
.mb-6 { margin-bottom: 1.5rem; }
.text-amber-400 { color: var(--color-oro-sensual); }
.text-gray-300 { color: rgba(255,255,255,0.55); }
.text-gray-400 { color: rgba(255,255,255,0.45); }

.space-y-6 > * + * { margin-top: 1.25rem; }
.flex { display: flex; }
.items-center { align-items: center; }
.justify-between { justify-content: space-between; }
.justify-end { justify-content: flex-end; }
.gap-4 { gap: 1rem; }
.p-0 { padding: 0; }

/* Responsive */
@media (max-width: 768px) {
    .profile-page {
        padding: 0.25rem 0.75rem 2rem;
    }

    .identity-card {
        border-radius: 18px;
        margin-bottom: 1.25rem;
    }

    .identity-cover {
        height: 80px;
    }

    .identity-body {
        flex-direction: column;
        align-items: center;
        text-align: center;
        margin-top: -45px;
        padding: 0 1rem 1.5rem;
        gap: 0.75rem;
    }

    .identity-avatar, .identity-initials {
        width: 90px;
        height: 90px;
        border-width: 3px;
    }

    .identity-initials {
        font-size: 2rem;
    }

    .identity-liga {
        width: 32px;
        height: 32px;
    }

    .identity-top-row {
        justify-content: center;
    }

    .identity-name {
        font-size: 1.4rem;
        flex-wrap: wrap;
        justify-content: center;
        gap: 6px;
    }

    .btn-view-profile {
        font-size: 0.72rem;
    }

    .identity-email {
        margin-bottom: 0.75rem;
        font-size: 0.82rem;
    }

    .identity-stats-row {
        justify-content: center;
        gap: 1.5rem;
        margin-bottom: 0.75rem;
    }

    .id-stat-value {
        font-size: 1rem;
    }

    .id-xp-bar-wrap {
        margin: 0 auto;
        max-width: 250px;
        width: 100%;
    }

    .forms-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .form-card {
        padding: 1.25rem;
        border-radius: 16px;
    }

    .card-header {
        margin-bottom: 1rem;
    }

    .card-header-icon {
        width: 34px;
        height: 34px;
        font-size: 0.9rem;
        border-radius: 10px;
    }

    .card-title {
        font-size: 1rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-input {
        padding: 0.6rem 0.85rem;
        font-size: 0.9rem;
    }

    .btn-primary, .btn-secondary, .btn-danger {
        padding: 0.55rem 1.2rem;
        font-size: 0.82rem;
    }
}
</style>
<div class="profile-page">

    {{-- Identity Card --}}
    <div class="identity-card">
        <div class="identity-cover"></div>
        <div class="identity-body">
            <div class="identity-avatar-wrap">
                @if($user->profile && $user->profile->avatar)
                    <img src="{{ $user->profile->avatar_url }}" alt="{{ $user->name }}" class="identity-avatar">
                @else
                    <div class="identity-initials">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif
                <div class="identity-liga">
                    <img src="{{ $user->getLigaIcon() }}" alt="Liga" title="{{ __('profile.stats.league') }}">
                </div>
            </div>

            <div class="identity-info">
                <div class="identity-top-row">
                    <h2 class="identity-name">
                        {{ $user->name }}
                        <span class="identity-role-tag">
                            @if($user->isAdmin()) {{ __('profile.roles.admin') }}
                            @elseif($user->isModel()) {{ __('profile.roles.model') }}
                            @else {{ __('profile.roles.fan') }}
                            @endif
                        </span>
                    </h2>
                    @if($user->isModel())
                        <a href="{{ route('profiles.show', $user) }}" class="btn-view-profile">
                            <i class="fas fa-eye"></i> {{ __('profile.view_public_profile') }}
                        </a>
                    @endif
                </div>
                <p class="identity-email">{{ $user->email }}</p>

                <div class="identity-stats-row">
                    <div class="id-stat">
                        <span class="id-stat-label">{{ __('profile.stats.level') }}</span>
                        <span class="id-stat-value">{{ $user->progress->currentLevel->level_number ?? 0 }}</span>
                    </div>
                    <div class="id-stat">
                        <span class="id-stat-label">{{ __('profile.stats.league') }}</span>
                        <span class="id-stat-value">{{ $user->progress->currentLevel->name ?? __('profile.stats.novato') }}</span>
                    </div>
                    @if($user->isFan())
                    <div class="id-stat">
                        <span class="id-stat-label">{{ __('profile.stats.tokens') }}</span>
                        <span class="id-stat-value">{{ number_format($user->tokens) }}</span>
                    </div>
                    @endif
                </div>

                <div class="id-xp-bar-wrap">
                    @php
                        $nextLevel = \App\Models\Level::where('level_number', ($user->progress->currentLevel->level_number ?? 0) + 1)->first();
                        $currentXP = $user->progress->current_xp ?? 0;
                        $targetXP = $nextLevel->xp_required ?? $currentXP;
                    @endphp
                    <div class="id-xp-labels">
                        <span>XP: {{ number_format($currentXP) }} / {{ number_format($targetXP) }}</span>
                        <span>{{ round($user->getXPPercentage()) }}%</span>
                    </div>
                    <div class="id-xp-track">
                        <div class="id-xp-fill" style="width: {{ $user->getXPPercentage() }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Forms --}}
    <div class="forms-grid">
        {{-- Account Data --}}
        <div class="form-card">
            <div class="card-header">                
                <h2 class="card-title">{{ __('profile.sections.account_data') }}</h2>
            </div>
            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')
                @include('profile.partials.update-profile-information-form')
            </form>
        </div>

        {{-- Security --}}
        <div class="form-card">
            <div class="card-header">
                
                <h2 class="card-title">{{ __('profile.sections.security') }}</h2>
            </div>
            <form method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')
                @include('profile.partials.update-password-form')
            </form>
        </div>

        {{-- Danger Zone --}}
        <div class="form-card danger">
            <div class="card-header">
                
                <h2 class="card-title">{{ __('profile.sections.danger_zone') }}</h2>
</div>
            <div class="danger-zone">
                <h3>{{ __('profile.danger.delete_account') }}</h3>
                <p>{{ __('profile.danger.delete_warning') }}</p>
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    @include('profile.partials.delete-user-form')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection