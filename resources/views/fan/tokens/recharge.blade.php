@extends('layouts.public')

@section('title', __('fan.tokens.recharge.title') . ' - Lustonex')



@section('content')
<style>
        :root {
            --glass-bg: rgba(20, 20, 25, 0.7);
            --glass-border: rgba(255, 255, 255, 0.08);
            --accent-gold: #D4AF37;
            --accent-green: #2ecc71;
            --text-muted: rgba(255, 255, 255, 0.6);
        }

        .recharge-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 64px 24px 64px 24px;
            /* Ajuste padding superior */
        }

        /* 1. Hero / Título */
        .page-header {
            text-align: center;
            margin-bottom: 48px;
        }

        /* Estilos de encabezado heredados del layout public */

        /* Steps Indicator */
        .checkout-steps {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 48px;
            position: relative;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Line through steps */
        .checkout-steps::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 50px;
            right: 50px;
            height: 2px;
            background: rgba(255, 255, 255, 0.1);
            z-index: 0;
        }

        .step-item {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            opacity: 0.5;
            transition: all 0.3s ease;
            flex: 1;
            min-width: 0;
        }

        .step-item.active {
            opacity: 1;
        }

        .step-item.completed {
            opacity: 0.8;
        }

        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #1a1a1f;
            border: 2px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #fff;
            transition: all 0.3s ease;
            font-size: 16px;
        }

        .step-item.active .step-number {
            border-color: var(--accent-gold);
            background: var(--accent-gold);
            color: #000;
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.3);
        }

        .step-item.completed .step-number {
            border-color: var(--accent-green);
            background: var(--accent-green);
            color: #fff;
        }

        .step-label {
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* 3. Grid Layout */
        .packages-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            /* Ajuste a 280-300 para mejor respiro */
            gap: 24px;
            /* Ajuste solicitado */
            margin-bottom: 32px;
        }

        /* 2. Package Cards */
        .package-card {
            background: rgba(30, 30, 35, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            /* Ajuste solicitado */
            border-radius: 12px;
            /* Ajuste solicitado */
            padding: 24px;
            /* Ajuste solicitado */
            cursor: pointer;
            transition: all 0.2s ease-out;
            /* Ajuste solicitado */
            position: relative;
            overflow: hidden;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            /* Ajuste solicitado */
        }

        .package-card:hover {
            transform: translateY(-4px);
            /* Ajuste solicitado */
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
            /* Ajuste solicitado */
            border-color: rgba(212, 175, 55, 0.3);
            background: rgba(40, 40, 45, 0.8);
        }

        .package-card.selected {
            background: rgba(212, 175, 55, 0.1);
            border-color: var(--accent-gold);
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.15);
        }

        .package-card.limited-time {
            border-color: rgba(239, 68, 68, 0.4);
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.15);
            background: rgba(50, 20, 20, 0.4);
            animation: pulseGlow 2s infinite alternate;
        }

        .package-card.limited-time.selected {
            background: rgba(239, 68, 68, 0.2);
            border: 2px solid #ef4444;
            box-shadow: inset 0 0 20px rgba(239, 68, 68, 0.2), 0 0 30px rgba(239, 68, 68, 0.4);
            animation: none; /* Stop pulsing when selected to make selection obvious */
        }
        
        @keyframes pulseGlow {
            0% { box-shadow: 0 0 10px rgba(239, 68, 68, 0.2); border-color: rgba(239, 68, 68, 0.3); }
            100% { box-shadow: 0 0 25px rgba(239, 68, 68, 0.5); border-color: rgba(239, 68, 68, 0.7); }
        }

        .package-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: var(--accent-gold);
            color: #000;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .package-badge.badge-urgent {
            background: #ef4444;
            color: #fff;
            animation: pulseText 1.5s infinite alternate;
        }
        
        @keyframes pulseText {
            0% { opacity: 0.8; }
            100% { opacity: 1; text-shadow: 0 0 8px rgba(255,255,255,0.5); }
        }
        
        .timer-badge {
            font-size: 12px;
            color: #ef4444;
            font-weight: 700;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .package-name {
            font-size: 20px;
            /* Ajuste solicitado */
            font-weight: 700;
            margin-bottom: 8px;
            color: #fff;
        }

        .package-tk {
            font-size: 32px;
            /* Ajuste solicitado */
            font-weight: 700;
            color: var(--accent-gold);
            line-height: 1;
            margin-bottom: 8px;
        }

        .package-tk span {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.6);
        }

        .package-price {
            font-size: 18px;
            /* Ajuste solicitado */
            font-weight: 600;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 16px;
        }

        /* 5. Payment Methods & Security */
        .methods-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .payment-method-card {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 24px;
            /* Ajuste solicitado */
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            /* Ajuste solicitado */
            cursor: pointer;
            transition: all 0.2s ease;
            margin-bottom: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            /* Ajuste solicitado */
        }

        .payment-method-card:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .payment-method-card.selected {
            background: rgba(212, 175, 55, 0.05);
            border-color: var(--accent-gold);
        }

        .method-icon {
            font-size: 24px;
            color: #fff;
            width: 40px;
            text-align: center;
        }

        .security-badge {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 24px;
            /* Ajuste solicitado */
            background: rgba(255, 255, 255, 0.03);
            /* Ajuste solicitado */
            border-radius: 12px;
            /* Ajuste solicitado */
            margin-top: 48px;
            gap: 32px;
            flex-wrap: wrap;
        }

        .security-item {
            display: flex;
            align-items: center;
            gap: 12px;
            opacity: 0.7;
        }

        .security-item i {
            font-size: 20px;
        }

        .security-item span {
            font-size: 14px;
            font-weight: 600;
        }

        /* Checkbox Styling */
        .recharge-checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-top: 24px;
            padding: 16px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            cursor: pointer;
        }

        .recharge-checkbox-input {
            appearance: none;
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.05);
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .recharge-checkbox-input:checked {
            background: var(--accent-gold);
            border-color: var(--accent-gold);
        }

        .recharge-checkbox-input:checked::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: #000;
            font-size: 12px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .recharge-checkbox-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            line-height: 1.4;
            user-select: none;
            cursor: pointer;
        }

        .recharge-checkbox-label a {
            color: var(--accent-gold);
            text-decoration: none;
            font-weight: 600;
        }

        .recharge-checkbox-label a:hover {
            color: #fff;
            text-decoration: underline;
        }

        /* Review & Pay */
        .checkout-footer {
            margin-top: 32px;
            padding-top: 32px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total-display {
            display: flex;
            flex-direction: column;
        }

        .total-label {
            font-size: 14px;
            color: var(--text-muted);
        }

        .total-amount {
            font-size: 32px;
            font-weight: 700;
            color: #fff;
        }

        .btn-action {
            background: var(--gradient-gold);
            color: #000;
            padding: 12px 32px;
            /* Ajuste solicitado */
            border-radius: 8px;
            /* Ajuste solicitado */
            font-weight: 700;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-action:hover:not(:disabled) {
            transform: scale(1.02);
            /* Ajuste solicitado */
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
        }

        .btn-action:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background: #444;
            color: #888;
        }

        .simulation-input {
            width: 100%;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 12px 16px;
            border-radius: 8px;
            color: #fff;
            margin-bottom: 16px;
        }

        .simulation-input:focus {
            outline: none;
            border-color: var(--accent-gold);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .recharge-wrapper {
                padding: 40px 16px;
            }

            .page-title {
                font-size: 28px;
                margin-bottom: 16px;
            }

            .page-subtitle {
                font-size: 16px;
                margin-bottom: 18px;
            }

            .checkout-steps {
                max-width: 320px;
            }

            .checkout-steps::before {
                width: 160px;
            }
            .step-number {
                width: 32px;
                height: 32px;
                font-size: 14px;
            }
            .step-item {
                width: 80px;
            }

            .step-label {
                font-size: 12px;
            }

            .packages-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .package-card {
                padding: 20px;
            }

            .package-tk {
                font-size: 28px;
            }

            .btn-action {
                width: 100%;
                justify-content: center;
            }

            .checkout-footer {
                flex-direction: column;
                gap: 20px;
                align-items: stretch;
                text-align: center;
            }

            .total-display {
                align-items: center;
            }
        }

        @media (max-width: 480px) {
            .page-title {
                font-size: 24px;
            }

            .page-subtitle {
                font-size: 14px;
            }
        }

        .step-content {
            display: none;
            animation: fadeIn 0.4s ease-out;
        }

        .step-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <div class="recharge-wrapper">

        <div class="page-header">
            <h1 class="page-title">{{ __('fan.tokens.recharge.title') }}</h1>
            <p class="page-subtitle">{{ __('fan.tokens.recharge.subtitle') }}</p>
        </div>

        <!-- Steps -->
        <div class="checkout-steps">
            <div class="step-item active" id="step-marker-1">
                <div class="step-number">1</div>
                <span class="step-label">{{ __('fan.tokens.recharge.steps.packages') }}</span>
            </div>
            <div class="step-item" id="step-marker-2">
                <div class="step-number">2</div>
                <span class="step-label">{{ __('fan.tokens.recharge.steps.method') }}</span>
            </div>
            <div class="step-item" id="step-marker-3">
                <div class="step-number">3</div>
                <span class="step-label">{{ __('fan.tokens.recharge.steps.payment') }}</span>
            </div>
        </div>

        <form id="purchase-form">
            @csrf

            <!-- Step 1: Packages -->
            <div class="step-content active" id="step-1">
                <div class="packages-grid">
                    @foreach($packages as $pkg)
                        <div class="package-card {{ $pkg['is_limited_time'] ? 'limited-time' : '' }}" 
                             data-id="{{ $pkg['id'] }}" 
                             onclick="selectPackage(this, {{ json_encode($pkg) }})">

                            @if($pkg['is_limited_time'])
                                <div class="package-badge badge-urgent"><i class="fas fa-fire"></i> {{ __('fan.tokens.recharge.flash_offer') }}</div>
                            @elseif($pkg['best_value'])
                                <div class="package-badge">{{ __('fan.tokens.recharge.best_value') }}</div>
                            @elseif($pkg['popular'])
                                <div class="package-badge" style="background: var(--accent-green);">{{ __('fan.tokens.recharge.popular') }}</div>
                            @endif

                            @if($pkg['is_limited_time'] && $pkg['expires_at'])
                                <div class="timer-badge" data-expires="{{ $pkg['expires_at'] }}">
                                    <i class="fas fa-clock"></i> <span class="countdown-text">{{ __('fan.tokens.recharge.calculating') }}</span>
                                </div>
                            @endif

                            <div class="package-name">{{ $pkg['name'] ?? __('fan.tokens.recharge.standard_package') }}</div>
                            <div class="package-tk">{{ number_format($pkg['tokens']) }} <span>{{ ucfirst(__('fan.tokens.token_unit')) }}</span></div>
                            <div class="package-price">${{ number_format($pkg['price'], 2) }} USD</div>

                            <div style="font-size: 13px; font-weight: 700; background: rgba(0,0,0,0.2); border-radius: 8px; padding: 6px; margin-top: 10px;">
                                @if($pkg['bonus'] > 0)
                                    <span style="color: var(--accent-green);"><i class="fas fa-gift"></i> {{ __('fan.tokens.recharge.bonus', ['amount' => number_format($pkg['bonus'])]) }}</span>
                                @else
                                    <span style="opacity: 0.3;">{{ __('fan.tokens.recharge.no_bonus') }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div style="text-align: center; margin-top: 32px;">
                    <button type="button" class="btn-action" id="btn-to-method" disabled
                        style="margin: 0 auto; min-width: 200px;">
                        {{ __('fan.tokens.recharge.continue') }}
                    </button>
                </div>
            </div>

            <!-- Step 2: Payment Methods -->
            <div class="step-content" id="step-2">
                <div class="methods-container">
                    <h3 style="font-size: 24px; font-weight: 700; margin-bottom: 24px; text-align: center;">{{ __('fan.tokens.recharge.choose_method') }}</h3>

                    <div class="payment-method-card" onclick="selectMethod('card', this)">
                        <div class="method-icon"><i class="fas fa-credit-card"></i></div>
                        <div>
                            <div style="font-weight: 700; margin-bottom: 4px;">{{ __('fan.tokens.recharge.credit_card') }}</div>
                            <div style="font-size: 14px; opacity: 0.6;">{{ __('fan.tokens.recharge.secure_processing') }}</div>
                        </div>
                    </div>

                    <div class="payment-method-card" onclick="selectMethod('paypal', this)">
                        <div class="method-icon"><i class="fab fa-paypal"></i></div>
                        <div>
                            <div style="font-weight: 700; margin-bottom: 4px;">PayPal</div>
                            <div style="font-size: 14px; opacity: 0.6;">{{ __('fan.tokens.recharge.paypal_hint') }}</div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 16px; justify-content: center; margin-top: 32px;">
                        <button type="button" class="btn-action" onclick="goToStep(1)"
                            style="background: transparent; border: 1px solid rgba(255,255,255,0.2); color: #fff;">
                            {{ __('fan.tokens.recharge.back') }}
                        </button>
                        <button type="button" class="btn-action" id="btn-to-payment" disabled>
                            {{ __('fan.tokens.recharge.continue_to_payment') }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Step 3: Checkout -->
            <div class="step-content" id="step-3">
                <div class="methods-container"
                    style="background: rgba(255,255,255,0.02); padding: 32px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.05);">
                    <h3 style="font-size: 24px; font-weight: 700; margin-bottom: 24px;">{{ __('fan.tokens.recharge.confirm_purchase_header') }}</h3>

                    <!-- Card Inputs (Simulation/Real) -->
                    <div id="card-fields" style="display:none;">
                        @if(config('payment.simulation_mode'))
                            <div
                                style="padding: 12px; background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.3); border-radius: 8px; font-size: 14px; margin-bottom: 24px; color: #93c5fd;">
                                <i class="fas fa-info-circle"></i> {{ __('fan.tokens.recharge.simulation_mode') }}
                            </div>
                        @endif

                        <div style="margin-bottom: 16px;">
                            <label
                                style="display: block; font-size: 12px; font-weight: 700; text-transform: uppercase; margin-bottom: 8px; opacity: 0.7;">{{ __('fan.tokens.recharge.holder') }}</label>
                            <input type="text" class="simulation-input" name="card_name"
                                placeholder="{{ __('fan.tokens.recharge.holder_placeholder') }}">
                        </div>
                        <div style="margin-bottom: 16px;">
                            <label
                                style="display: block; font-size: 12px; font-weight: 700; text-transform: uppercase; margin-bottom: 8px; opacity: 0.7;">{{ __('fan.tokens.recharge.number') }}</label>
                            <input type="text" class="simulation-input" name="card_number"
                                placeholder="0000 0000 0000 0000">
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div>
                                <label
                                    style="display: block; font-size: 12px; font-weight: 700; text-transform: uppercase; margin-bottom: 8px; opacity: 0.7;">{{ __('fan.tokens.recharge.expires') }}</label>
                                <div style="display: flex; gap: 8px;">
                                    <input type="text" class="simulation-input" name="exp_month" placeholder="MM"
                                        style="margin:0;">
                                    <input type="text" class="simulation-input" name="exp_year" placeholder="YY"
                                        style="margin:0;">
                                </div>
                            </div>
                            <div>
                                <label
                                    style="display: block; font-size: 12px; font-weight: 700; text-transform: uppercase; margin-bottom: 8px; opacity: 0.7;">{{ __('fan.tokens.recharge.cvc') }}</label>
                                <input type="text" class="simulation-input" name="cvc" placeholder="123">
                            </div>
                        </div>
                    </div>

                        <div id="paypal-info" style="display:none; text-align: center; padding: 24px;">
                            <i class="fab fa-paypal" style="font-size: 48px; color: #fff; margin-bottom: 16px;"></i>
                            <p>{{ __('fan.tokens.recharge.paypal_redirect') }}</p>
                        </div>

                        <div class="recharge-checkbox-group">
                            <input type="checkbox" name="terms_accepted" id="terms_accepted" class="recharge-checkbox-input">
                            <label for="terms_accepted" class="recharge-checkbox-label">
                                {!! __('legal.clickwrap_acceptance') !!}
                            </label>
                        </div>

                    <div class="checkout-footer">
                        <div class="total-display">
                            <span class="total-label">{{ __('fan.tokens.recharge.total_to_pay') }}</span>
                            <span class="total-amount" id="final-price">$0.00</span>
                        </div>
                        <div style="display: flex; gap: 16px;">
                            <button type="button" class="btn-action" onclick="goToStep(2)"
                                style="background: transparent; border: 1px solid rgba(255,255,255,0.2); color: #fff;">
                                {{ __('fan.tokens.recharge.back') }}
                            </button>
                            <button type="button" id="btn-confirm-pay" class="btn-action">
                                {{ __('fan.tokens.recharge.confirm_pay') }} <i class="fas fa-lock"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </form>

        <!-- Trust Badges -->
        <div class="security-badge">
            <div class="security-item">
                <i class="fas fa-shield-alt"></i>
                <span>{{ __('fan.tokens.recharge.secure_payment') }}</span>
            </div>
            <div class="security-item">
                <i class="fas fa-lock"></i>
                <span>{{ __('fan.tokens.recharge.ssl_encryption') }}</span>
            </div>
            <div class="security-item">
                <i class="fas fa-headset"></i>
                <span>{{ __('fan.tokens.recharge.support_247') }}</span>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let currentData = {
            package: null,
            method: null
        };

        function selectPackage(el, pkg) {
            document.querySelectorAll('.package-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            currentData.package = pkg;
            document.getElementById('btn-to-method').disabled = false;
            document.getElementById('final-price').innerText = '$' + parseFloat(pkg.price).toFixed(2);
        }

        function selectMethod(method, el) {
            document.querySelectorAll('.payment-method-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            currentData.method = method;
            document.getElementById('btn-to-payment').disabled = false;

            // Toggle view based on method
            document.getElementById('card-fields').style.display = method === 'card' ? 'block' : 'none';
            document.getElementById('paypal-info').style.display = method === 'paypal' ? 'block' : 'none';
        }

        document.getElementById('btn-to-method').addEventListener('click', () => goToStep(2));
        document.getElementById('btn-to-payment').addEventListener('click', () => goToStep(3));

        function goToStep(step) {
            // Hide all
            document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.step-item').forEach(el => {
                el.classList.remove('active');
                el.classList.remove('completed');
            });

            // Show target
            document.getElementById('step-' + step).classList.add('active');

            // Update markers
            for (let i = 1; i < step; i++) {
                document.getElementById('step-marker-' + i).classList.add('completed');
            }
            document.getElementById('step-marker-' + step).classList.add('active');
        }

        // Countdown Timers
        function updateTimers() {
            document.querySelectorAll('.timer-badge').forEach(badge => {
                const expiresStr = badge.getAttribute('data-expires');
                if (!expiresStr) return;
                
                // Parse ISO date string
                const expiresAt = new Date(expiresStr).getTime();
                const now = new Date().getTime();
                const distance = expiresAt - now;

                if (distance < 0) {
                    const card = badge.closest('.package-card');
                    if (card) {
                        card.style.display = 'none';
                    }
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                let timeStr = '';
                if (days > 0) timeStr += days + 'd ';
                timeStr += hours.toString().padStart(2, '0') + ':';
                timeStr += minutes.toString().padStart(2, '0') + ':';
                timeStr += seconds.toString().padStart(2, '0');

                badge.querySelector('.countdown-text').innerText = timeStr;
            });
        }

        setInterval(updateTimers, 1000);
        updateTimers();

        // Auto-select package from URL
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const packageId = urlParams.get('package_id');
            if (packageId) {
                const card = document.querySelector(`.package-card[data-id="${packageId}"]`);
                if (card) {
                    card.click();
                    // Optional: Scroll to payment methods or just show selection
                    setTimeout(() => {
                        document.getElementById('btn-to-method').scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 500);
                }
            }
        });

        // Purchase Logic
        document.getElementById('btn-confirm-pay').addEventListener('click', function () {
            if (!currentData.package) return;

            const termsCheckbox = document.getElementById('terms_accepted');
            if (!termsCheckbox.checked) {
                Swal.fire({
                    icon: 'warning',
                    title: '{{ __("auth.attention") }}',
                    text: '{{ __("legal.must_accept_terms") }}',
                    background: '#1a1a1f',
                    color: '#fff',
                    confirmButtonColor: '#D4AF37'
                });
                return;
            }

            const btn = this;
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __('fan.tokens.recharge.processing') }}';

            // Prepare Payload
            const payload = {
                tokens: currentData.package.tokens,
                total_tokens: currentData.package.total, // Added total_tokens
                price: currentData.package.price,
                payment_method: currentData.method,
                _token: '{{ csrf_token() }}'
            };

            if (currentData.method === 'card') {
                const form = document.getElementById('purchase-form');
                const data = new FormData(form);

                payload.card_data = {
                    number: data.get('card_number'), // Mapped to 'number'
                    exp_month: data.get('exp_month'),
                    exp_year: data.get('exp_year'),
                    cvv: data.get('cvc') // Mapped to 'cvv'
                };
            } else {
                // For PayPal/Skrill, backend expects email
                payload.email = '{{ Auth::user()->email }}';
            }

            // Simulate API Call
            fetch('{{ route("fan.tokens.purchase") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Tokens Recargados!',
                            text: 'Disfruta de tu contenido.',
                            background: '#1a1a1f',
                            color: '#fff',
                            confirmButtonColor: '#D4AF37'
                        }).then(() => {
                            window.location.href = '{{ route("fan.dashboard") }}';
                        });
                    } else {
                        throw new Error(data.message || 'Error desconocido');
                    }
                })
                .catch(err => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: err.message,
                        background: '#1a1a1f',
                        color: '#fff'
                    });
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                });
        });
    </script>
@endsection