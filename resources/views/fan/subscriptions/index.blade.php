@extends('layouts.public')

@section('title', __('fan.subscriptions.title') . ' - Lustonex')



@section('content')
  <style>
        .subscriptions-container {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Page Header */
        .page-header {
            margin-bottom: 2.5rem;
            position: relative;
        }

        /* Estilos de encabezado heredados del layout public */

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-card-premium {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 20px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .stat-card-premium:hover {
            transform: translateY(-5px);
            border-color: var(--color-oro-sensual);
            background: rgba(255, 255, 255, 0.05);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .stat-card-premium::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.1) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .stat-card-premium:hover::after {
            opacity: 1;
        }

        .stat-icon-box {
            width: 50px;
            height: 50px;
            background: rgba(212, 175, 55, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--color-oro-sensual);
            margin-bottom: 1rem;
        }

        .stat-info .value {
            font-family: var(--font-titles);
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--color-blanco-puro);
            line-height: 1;
            margin-bottom: 0.25rem;
            display: block;
        }

        .stat-info .label {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.6);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Subscription Grid */
        .subscriptions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .sub-card-premium {
            background: rgba(30, 30, 35, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
            overflow: hidden;
            transition: all 0.4s ease;
            position: relative;
        }

        .sub-card-premium:hover {
            transform: translateY(-8px);
            border-color: rgba(212, 175, 55, 0.4);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4);
        }

        .sub-banner {
            height: 160px;
            position: relative;
            background: var(--color-gris-carbon);
        }

        .sub-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.6;
            transition: transform 0.6s ease;
        }

        .sub-card-premium:hover .sub-cover {
            transform: scale(1.1);
        }

        .sub-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.4rem 1rem;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(212, 175, 55, 0.5);
            border-radius: 50px;
            color: var(--color-oro-sensual);
            font-size: 0.75rem;
            font-weight: 700;
            z-index: 5;
        }

        .sub-avatar-container {
            position: absolute;
            bottom: -40px;
            left: 24px;
            z-index: 10;
        }

        .sub-avatar {
            width: 80px;
            height: 80px;
            border-radius: 22px;
            border: 4px solid #1e1e23;
            object-fit: cover;
            background: #1e1e23;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .sub-body {
            padding: 50px 24px 24px;
        }

        .model-info-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .model-name-group {
            display: flex;
            flex-direction: column;
        }

        .model-name {
            font-family: var(--font-titles);
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--color-blanco-puro);
            margin: 0;
        }

        .model-tag {
            font-size: 0.85rem;
            color: var(--color-oro-sensual);
            opacity: 0.8;
        }

        .sub-meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .meta-item {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            padding: 0.75rem;
            display: flex;
            flex-direction: column;
        }

        .meta-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.4);
            margin-bottom: 0.25rem;
        }

        .meta-value {
            font-size: 1rem;
            font-weight: 600;
            color: var(--color-blanco-puro);
        }

        .sub-card-actions {
            display: flex;
            gap: 0.75rem;
        }

        .btn-premium-action {
            flex: 1;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-visit-model {
            background: linear-gradient(135deg, var(--color-oro-sensual), #f4e37d);
            color: var(--color-negro-azabache);
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
        }

        .btn-visit-model:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.5);
        }

        .btn-manage-sub {
            background: rgba(255, 255, 255, 0.05);
            color: var(--color-blanco-puro);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-manage-sub:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
        }

        /* Benefits & Missions integrated columns */
        .utility-layout {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 2rem;
        }

        .gamification-sidebar {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(212, 175, 55, 0.15);
            border-radius: 20px;
            padding: 1.5rem;
        }

        .panel-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .panel-header i {
            color: var(--color-oro-sensual);
            font-size: 1.2rem;
        }

        .panel-header h4 {
            margin: 0;
            font-family: var(--font-titles);
            font-size: 1.2rem;
            font-weight: 700;
            color: #dfc04e;
        }


        /* Empty State */
        .premium-empty {
            text-align: center;
            padding: 5rem 2rem;
            background: rgba(255, 255, 255, 0.02);
            border: 1px dashed rgba(212, 175, 55, 0.3);
            border-radius: 30px;
            margin: 2rem 0;
        }

        .empty-illustration {
            font-size: 4rem;
            color: var(--color-oro-sensual);
            margin-bottom: 2rem;
            opacity: 0.5;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        /* Recommended Section */
        .reco-title-box {
            margin-bottom: 2rem;
        }

        .reco-title-box h3 {
            font-family: var(--font-titles);
            font-size: 1.8rem;
            font-weight: 700;
            color: #dfc04e;
        }


        /* Recommendation Cards (Welcome Style) */
        .reco-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            width: 100%;
        }

        .reco-grid .sh-model-card {
            flex: 1 1 calc(16.666% - 17px);
            max-width: calc(16.666% - 17px);
            border-radius: 12px;
            overflow: hidden;
            background: rgba(31, 31, 35, 0.5);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.05);
            display: block;
            text-decoration: none;
        }

        .reco-grid .sh-model-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.2);
            border-color: rgba(212, 175, 55, 0.3);
            z-index: 2;
        }

        .sh-card-image-wrapper {
            aspect-ratio: 4/5;
            position: relative;
            background: #000;
            overflow: hidden;
        }

        .sh-card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .reco-grid .sh-model-card:hover .sh-card-image {
            transform: scale(1.05);
        }

        .sh-category-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(138, 43, 226, 0.9);
            backdrop-filter: blur(4px);
            color: #fff;
            font-size: 10px;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 4px;
            z-index: 5;
        }

        .sh-card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 40%;
            background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 14px;
        }

        .sh-model-name {
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            margin: 0 0 2px 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }

        .sh-model-meta {
            color: var(--color-oro-sensual);
            font-size: 12px;
            font-weight: 600;
        }

        @media (max-width: 1200px) {
            .utility-layout {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .subscriptions-container {
                padding: 1rem 0.75rem;
            }

            .page-header {
                margin-bottom: 1.5rem;
                text-align: center;
            }

            /* Estilos responsivos de encabezado heredados */

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.5rem;
                margin-bottom: 1.5rem;
            }

            .stat-card-premium {
                padding: 1rem 0.5rem;
                text-align: center;
            }

            .stat-icon-box {
                width: 36px;
                height: 36px;
                font-size: 1rem;
                margin: 0 auto 0.5rem;
            }

            .stat-info .value {
                font-size: 1.2rem;
            }

            .stat-info .label {
                font-size: 0.6rem;
                white-space: nowrap;
                letter-spacing: 0;
            }

            .subscriptions-grid {
                grid-template-columns: 1fr;
                gap: 1.25rem;
                margin-bottom: 2rem;
            }

            .sub-card-premium {
                border-radius: 16px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            }

            .sub-banner {
                height: 100px;
            }

            .sub-badge {
                font-size: 0.6rem;
                padding: 4px 8px;
                top: 0.5rem;
                right: 0.5rem;
            }

            .sub-avatar-container {
                bottom: -20px;
                left: 16px;
            }

            .sub-avatar {
                width: 56px;
                height: 56px;
                border-radius: 50%;
                border-width: 3px;
            }

            .sub-body {
                padding: 24px 16px 16px;
            }

            .model-name {
                font-size: 1rem;
            }

            .model-tag {
                font-size: 0.75rem;
            }

            .model-info-header {
                flex-direction: row;
                justify-content: space-between;
                align-items: flex-start;
                margin-bottom: 1rem;
            }

            .subscription-status {
                margin-top: 4px;
            }

            .sub-meta-grid {
                grid-template-columns: 1fr 1fr;
                gap: 0.5rem;
                margin-bottom: 1.2rem;
            }

            .meta-item {
                padding: 0.6rem;
                border-radius: 10px;
                background: rgba(255, 255, 255, 0.05);
            }

            .meta-label {
                font-size: 0.6rem;
            }

            .meta-value {
                font-size: 0.85rem;
            }

            .btn-premium-action {
                height: 42px;
                font-size: 0.85rem;
                border-radius: 12px;
            }

            .utility-layout {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .reco-title-box h3 {
                font-size: 1.4rem;
            }

            .reco-grid {
                gap: 12px;
            }

            .reco-grid .sh-model-card {
                flex: 1 1 calc(50% - 6px);
                max-width: calc(50% - 6px);
            }

            .sh-card-overlay {
                padding: 10px;
            }

            .sh-model-name {
                font-size: 13px;
            }

            .sh-model-meta {
                font-size: 10px;
            }

            .sh-category-badge {
                font-size: 8px;
                padding: 3px 6px;
                top: 6px;
                right: 6px;
            }

            .premium-empty {
                padding: 3rem 1rem;
            }
        }

        @media (max-width: 480px) {
            /* Estilos responsivos heredados */
        }
    </style>
    <div class="subscriptions-container">
        
        <div class="page-header">
            <h1 class="page-title">{{ __('fan.subscriptions.title') }}</h1>
            <p class="page-subtitle">{{ __('fan.subscriptions.subtitle') }}</p>
        </div>

        
        <div class="stats-grid">
            <div class="stat-card-premium">
                <div class="stat-icon-box">
                    <i class="fas fa-crown"></i>
                </div>
                <div class="stat-info">
                    <span class="value">{{ $stats['active_count'] }}</span>
                    <span class="label">{{ __('fan.subscriptions.active_count') }}</span>
                </div>
            </div>
           
            <div class="stat-card-premium">
                <div class="stat-icon-box" style="color: #ff4757; background: rgba(255, 71, 87, 0.1);">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="stat-info">
                    <span class="value">{{ number_format($stats['total_spent']) }}</span>
                    <span class="label">{{ __('fan.subscriptions.total_spent') }}</span>
                </div>
            </div>
        </div>

        <div class="utility-layout">
            
            <div class="feed-column">
                @if($activeSubscriptions->count() > 0)
                    <div class="subscriptions-grid">
                        @foreach($activeSubscriptions as $subscription)
                            <div class="sub-card-premium">
                                <div class="sub-banner">
                                    <span class="sub-badge">{{ __('fan.subscriptions.auto_renewal') }}</span>
                                    <img src="{{ $subscription->model->profile->cover_image_url }}"
                                        class="sub-cover" alt="Cover">
                                    <div class="sub-avatar-container">
                                        <img src="{{ $subscription->model->profile->avatar_url }}"
                                            class="sub-avatar" alt="Avatar"
                                            onerror="this.onerror=null;this.src='{{ asset('images/placeholder-avatar.svg') }}'">
                                    </div>
                                </div>
                                <div class="sub-body">
                                    <div class="model-info-header">
                                        <div class="model-name-group">
                                            <h3 class="model-name">
                                                {{ $subscription->model->profile->display_name ?? $subscription->model->name }}</h3>
                                            <span class="model-tag">@ {{ $subscription->model->name }}</span>
                                        </div>
                                        <div class="subscription-status">
                                            <span class="dot"
                                                style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #00ff88; margin-right: 5px;"></span>
                                            <span style="font-size: 0.8rem; font-weight: 600; color: #00ff88;">{{ __('fan.subscriptions.status_active') }}</span>
                                        </div>
                                    </div>

                                    <div class="sub-meta-grid">
                                        <div class="meta-item">
                                            <span class="meta-label">{{ __('fan.subscriptions.next_payment') }}</span>
                                            <span
                                                class="meta-value">{{ $subscription->expires_at ? $subscription->expires_at->format('d M, Y') : 'N/A' }}</span>
                                        </div>
                                        <div class="meta-item">
                                            <span class="meta-label">{{ __('fan.subscriptions.monthly_cost') }}</span>
                                            <span class="meta-value">{{ number_format($subscription->amount) }} TK</span>
                                        </div>
                                        <div class="meta-item">
                                            <span class="meta-label">{{ __('fan.subscriptions.subscribed_since') }}</span>
                                            <span
                                                class="meta-value">{{ $subscription->starts_at ? $subscription->starts_at->format('M Y') : 'N/A' }}</span>
                                        </div>
                                        <div class="meta-item">
                                            <span class="meta-label">{{ __('fan.subscriptions.payment_method') }}</span>
                                            <span class="meta-value">Tokens</span>
                                        </div>
                                    </div>

                                    <div class="sub-card-actions">
                                        <a href="{{ route('profiles.show', $subscription->model) }}"
                                            class="btn-premium-action btn-visit-model">
                                            <i class="fas fa-play"></i>
                                            {{ __('fan.subscriptions.go_to_wall') }}
                                        </a>
                                        <button onclick="cancelSubscription({{ $subscription->id }})"
                                            class="btn-premium-action btn-manage-sub">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="premium-empty">
                        <div class="empty-illustration">
                            <i class="fas fa-crown"></i>
                        </div>
                        <h2 class="font-titles" style="font-size: 2rem; margin-bottom: 1rem;">{{ __('fan.subscriptions.empty_title') }}</h2>
                        <p style="color: rgba(255,255,255,0.6); max-width: 400px; margin: 0 auto 2.5rem;">{{ __('fan.subscriptions.empty_subtitle') }}</p>
                        <a href="{{ url('/') }}" class="btn-premium-action btn-visit-model"
                            style="display: inline-flex; width: auto; padding: 0 2.5rem;">
                            {{ __('fan.subscriptions.discover_creators') }}
                        </a>
                    </div>
                @endif
            </div>

            
            <div class="gamification-sidebar">
                @if($subscriptionDiscount > 0)
                    <div class="glass-panel" style="background: linear-gradient(135deg, rgba(212, 175, 55, 0.1), transparent);">
                        <div class="panel-header">
                            <i class="fas fa-percentage"></i>
                            <h4>{{ __('fan.subscriptions.level_benefit') }}</h4>
                        </div>
                        <div class="benefit-box"
                            style="padding: 1rem; background: rgba(0,0,0,0.2); border-radius: 14px; border: 1px solid var(--color-oro-sensual);">
                            <p style="margin: 0; font-weight: 700; color: var(--color-oro-sensual); font-size: 1.2rem;">
                                {{ $subscriptionDiscount }}% {{ __('fan.subscriptions.discount') }}</p>
                            <p style="margin: 5px 0 0; font-size: 0.85rem; opacity: 0.7;">{{ __('fan.subscriptions.discount_hint') }}</p>
                        </div>
                    </div>
                @endif

                @if($subscriptionMissions->count() > 0)
                    <div class="glass-panel">
                        <div class="panel-header">
                           
                            <h4>{{ __('fan.subscriptions.active_missions') }}</h4>
                        </div>
                        <div class="missions-list" style="display: flex; flex-direction: column; gap: 1rem;">
                            @foreach($subscriptionMissions as $mission)
                                <x-mission-progress-mini :mission="$mission" />
                            @endforeach
                        </div>
                    </div>
                @endif

                
                <div class="glass-panel" style="border-style: dashed; opacity: 0.8;">
                    <div class="panel-header" style="margin-bottom: 0.75rem;">
                        <i class="fas fa-question-circle"></i>
                        <h4>{{ __('fan.subscriptions.how_it_works') }}</h4>
                    </div>
                    <p style="font-size: 0.85rem; line-height: 1.6; margin: 0;">{{ __('fan.subscriptions.how_it_works_text') }}</p>
                </div>
            </div>
        </div>

        @if($recommendedModels->count() > 0)
            <div class="reco-title-box" style="margin-top: 3rem;">
                <h3>{{ __('fan.subscriptions.you_might_like') }}</h3>
                <p style="color: rgba(255,255,255,0.5);">{{ __('fan.subscriptions.recommendations_subtitle') }}</p>
            </div>
            <div class="reco-grid">
                @foreach($recommendedModels->take(6) as $rModel)
                    <a href="{{ route('profiles.show', $rModel) }}" class="sh-model-card">
                        <div class="sh-card-image-wrapper">
                            @if($rModel->profile && $rModel->profile->avatar)
                                <img src="{{ $rModel->profile->avatar_url }}" alt="{{ $rModel->name }}" class="sh-card-image" loading="lazy">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #1a1a1a;">
                                    <i class="fas fa-user" style="font-size: 48px; color: rgba(255,255,255,0.1);"></i>
                                </div>
                            @endif

                            <div class="sh-category-badge">
                                <i class="fas fa-crown"></i> VIP
                            </div>

                            <div class="sh-card-overlay">
                                <h3 class="sh-model-name">
                                    {{ $rModel->profile->display_name ?? $rModel->name }}
                                </h3>
                                <span class="sh-model-meta">
                                    {{ number_format($rModel->profile->subscription_price ?? 19.99) }} TK / mes
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function cancelSubscription(subscriptionId) {
            Swal.fire({
                title: '¿Confirmas la cancelación?',
                text: "Perderás el acceso inmediato al contenido exclusivo de esta modelo.",
                icon: 'warning',
                showCancelButton: true,
                background: '#1a1a1e',
                color: '#ffffff',
                confirmButtonColor: '#d4af37',
                cancelButtonColor: '#303035',
                confirmButtonText: 'Sí, cancelar suscripción',
                cancelButtonText: 'Mantener VIP'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/fan/subscriptions/${subscriptionId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Cancelada',
                                    text: 'Tu suscripción ha sido dada de baja.',
                                    icon: 'success',
                                    background: '#1a1a1e',
                                    color: '#ffffff',
                                    confirmButtonColor: '#d4af37'
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire('Error', data.message || 'No se pudo procesar la cancelación', 'error');
                            }
                        });
                }
            });
        }

        // Animate stats values
        document.addEventListener('DOMContentLoaded', () => {
            const counters = document.querySelectorAll('.stat-info .value');
            counters.forEach(counter => {
                const target = +counter.innerText.replace(/,/g, '');
                const count = +counter.innerText;
                if (target === 0) return;

                const animate = () => {
                    const value = +counter.innerText.replace(/,/g, '');
                    const data = target;
                    const time = 400;
                    const step = data / time;
                    if (value < data) {
                        counter.innerText = Math.ceil(value + step).toLocaleString();
                        setTimeout(animate, 1);
                    } else {
                        counter.innerText = data.toLocaleString();
                    }
                }
                // animate(); // Uncomment if you want real dynamic count-up
            });
        });
    </script>
@endsection