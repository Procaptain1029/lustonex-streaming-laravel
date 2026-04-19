@extends('layouts.model')

@section('title', __('model.streams.go_live.title'))

@section('breadcrumb')
    <a href="{{ route('model.dashboard') }}" class="breadcrumb-item">{{ __('model.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('model.streams.index') }}" class="breadcrumb-item">{{ __('model.streams.index.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('model.streams.go_live.breadcrumb') }}</span>
@endsection

@section('styles')
    <style>
        .go-live-wrap { max-width: 920px; margin: 0 auto; padding: 1.5rem; }
        .go-live-head { margin-bottom: 2rem; }
        .go-live-head h1 { font-family: 'Poppins', sans-serif; color: #d4af37; font-size: 1.75rem; margin-bottom: 0.5rem; }
        .go-live-head p { color: rgba(255,255,255,0.75); font-size: 1rem; line-height: 1.5; }
        .mode-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
        @media (max-width: 720px) { .mode-grid { grid-template-columns: 1fr; } }
        .mode-card {
            display: flex; flex-direction: column; align-items: flex-start; text-align: left;
            padding: 1.75rem; border-radius: 20px; text-decoration: none; color: #fff;
            border: 1px solid rgba(255,255,255,0.12); background: rgba(31,31,35,0.55);
            backdrop-filter: blur(12px); transition: transform 0.2s, border-color 0.2s, box-shadow 0.2s;
        }
        .mode-card:hover { transform: translateY(-3px); border-color: rgba(212,175,55,0.45); box-shadow: 0 12px 40px rgba(0,0,0,0.35); color: #fff; }
        .mode-card.primary { border-color: rgba(212,175,55,0.55); background: linear-gradient(145deg, rgba(212,175,55,0.12), rgba(31,31,35,0.7)); }
        .mode-card.secondary { opacity: 0.95; }
        .mode-badge { font-size: 0.7rem; font-weight: 800; letter-spacing: 0.06em; text-transform: uppercase; padding: 0.35rem 0.65rem; border-radius: 999px; margin-bottom: 1rem; }
        .mode-card.primary .mode-badge { background: #d4af37; color: #000; }
        .mode-card.secondary .mode-badge { background: rgba(255,255,255,0.12); color: rgba(255,255,255,0.85); }
        .mode-card h2 { font-size: 1.2rem; font-weight: 800; margin: 0 0 0.5rem 0; font-family: 'Poppins', sans-serif; }
        .mode-card p { font-size: 0.88rem; color: rgba(255,255,255,0.6); margin: 0 0 1rem 0; line-height: 1.45; flex: 1; }
        .mode-card .cta { font-weight: 700; font-size: 0.95rem; color: #d4af37; display: inline-flex; align-items: center; gap: 0.5rem; }
        .warn-banner {
            margin-bottom: 1.5rem; padding: 1rem 1.25rem; border-radius: 14px;
            background: rgba(255, 193, 7, 0.1); border: 1px solid rgba(255, 193, 7, 0.35); color: #ffe08a; font-size: 0.9rem;
        }
    </style>
@endsection

@section('content')
    <div class="go-live-wrap">
        <div class="go-live-head">
            <h1>{{ __('model.streams.go_live.title') }}</h1>
            <p>{{ __('model.streams.go_live.subtitle') }}</p>
        </div>

        @if(!empty($warningMessage))
            <div class="warn-banner"><i class="fas fa-exclamation-triangle"></i> {{ $warningMessage }}</div>
        @endif

        <div class="mode-grid">
            <a href="{{ route('model.streams.create', ['mode' => 'browser']) }}" class="mode-card primary">
                <span class="mode-badge">{{ __('model.streams.go_live.badge_recommended') }}</span>
                <h2>{{ __('model.streams.go_live.card_browser_title') }}</h2>
                <p>{{ __('model.streams.go_live.card_browser_desc') }}</p>
                <span class="cta">{{ __('model.streams.go_live.card_browser_cta') }} <i class="fas fa-arrow-right"></i></span>
            </a>

            <a href="{{ route('model.streams.create', ['mode' => 'obs']) }}" class="mode-card secondary">
                <span class="mode-badge">{{ __('model.streams.go_live.badge_optional') }}</span>
                <h2>{{ __('model.streams.go_live.card_obs_title') }}</h2>
                <p>{{ __('model.streams.go_live.card_obs_desc') }}</p>
                <span class="cta">{{ __('model.streams.go_live.card_obs_cta') }} <i class="fas fa-arrow-right"></i></span>
            </a>
        </div>
    </div>
@endsection
