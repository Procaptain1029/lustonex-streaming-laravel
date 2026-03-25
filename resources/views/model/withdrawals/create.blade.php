@extends('layouts.model')

@section('title', __('model.withdrawals.create.title'))

@section('breadcrumb')
    <a href="{{ route('model.dashboard') }}" class="breadcrumb-item">Dashboard</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('model.withdrawals.index') }}" class="breadcrumb-item">{{ __('model.withdrawals.index.breadcrumb') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('model.withdrawals.create.breadcrumb_request') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Model Withdrawal Create Styling ----- */
        .sh-split-layout,
        .sh-form-card,
        .sh-balance-card,
        .sh-input,
        .sh-select,
        .sh-btn-submit,
        .sh-receipt {
            box-sizing: border-box;
            max-width: 100%;
        }

        .page-header {
            padding-top: 64px;
            margin-bottom: 40px;
        }

        /* Estilos de encabezado heredados del layout model */

        .sh-btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 24px;
            transition: color 0.2s;
        }

        .sh-btn-back:hover {
            color: #fff;
        }

        .sh-split-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 32px;
        }

        .sh-form-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 32px;
            margin-bottom: 32px;
        }

        .sh-section-title {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Form Inputs */
        .sh-form-group {
            margin-bottom: 24px;
        }

        .sh-label {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 8px;
            display: block;
        }

        .sh-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .sh-input-icon {
            position: absolute;
            left: 16px;
            color: var(--model-gold);
            font-size: 18px;
            pointer-events: none;
        }

        .sh-input {
            width: 100%;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 14px 16px 14px 48px;
            color: #fff;
            font-size: 16px;
            transition: all 0.2s;
        }

        .sh-input:focus {
            outline: none;
            border-color: var(--model-gold);
            background: rgba(0, 0, 0, 0.5);
            box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.1);
        }

        .sh-select {
            width: 100%;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 14px 16px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        .sh-select option {
            background-color: #1a1a1a;
            color: #fff;
        }

        .sh-quick-btns {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }

        .sh-quick-btn {
            padding: 6px 12px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.8);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .sh-quick-btn:hover {
            background: rgba(212, 175, 55, 0.1);
            color: var(--model-gold);
            border-color: var(--model-gold);
        }

        /* Receipt Widget */
        .sh-receipt {
            background: linear-gradient(135deg, rgba(30, 30, 35, 0.9), rgba(15, 15, 20, 0.95));
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 16px;
            padding: 24px;
            position: relative;
            overflow: hidden;
        }

        .sh-receipt::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(212, 175, 55, 0.1) 10px, rgba(212, 175, 55, 0.1) 20px);
        }

        .sh-receipt-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
        }

        .sh-receipt-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 16px 0;
            border-bottom: 1px dashed rgba(255, 255, 255, 0.1);
        }

        .sh-receipt-total {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .sh-total-label {
            font-size: 14px;
            font-weight: 700;
            color: #fff;
        }

        .sh-total-val {
            font-size: 24px;
            font-weight: 800;
            color: var(--model-gold);
            line-height: 1;
        }

        /* Submit Button */
        .sh-btn-submit {
            width: 100%;
            padding: 16px;
            background: var(--model-gold);
            color: #000;
            font-weight: 800;
            font-size: 18px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 20px rgba(212, 175, 55, 0.2);
        }

        .sh-btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(212, 175, 55, 0.3);
        }

        /* Side Info */
        .sh-balance-card {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(0, 0, 0, 0));
            border: 1px solid rgba(40, 167, 69, 0.3);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            text-align: center;
        }

        .sh-balance-main {
            font-size: 32px;
            font-weight: 800;
            color: #28a745;
            margin-bottom: 8px;
        }

        .sh-balance-sub {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
        }

        .sh-info-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .sh-info-list li {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 12px;
            padding-left: 20px;
            position: relative;
        }

        .sh-info-list li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--model-gold);
            font-weight: bold;
        }

        @media (max-width: 900px) {
            .page-header {
                padding-top: 24px;
                margin-bottom: 20px;
            }

            /* Estilos responsivos de encabezado heredados */

            .sh-btn-back {
                margin-bottom: 16px;
                font-size: 13px;
            }

            .sh-split-layout {
                display: flex;
                flex-direction: column-reverse;
                gap: 20px;
            }

            .sh-form-card, .sh-balance-card {
                padding: 16px;
                margin-bottom: 20px;
            }

            .sh-section-title {
                font-size: 18px;
                margin-bottom: 16px;
                word-wrap: break-word;
            }

            .sh-balance-main {
                font-size: 26px;
            }

            .sh-quick-btns {
                gap: 6px;
            }

            .sh-quick-btn {
                flex: 1;
                padding: 10px 4px;
                font-size: 12px;
                text-align: center;
                min-width: 0; /* Prevents overflow due to small screens */
            }

            .sh-receipt {
                padding: 16px;
            }

            .sh-total-val {
                font-size: 20px;
            }

            .sh-btn-submit {
                font-size: 16px;
                padding: 14px;
                margin-bottom: 10px;
            }
        }
    </style>
@endsection

@section('content')

    <div class="page-header">
        <a href="{{ route('model.withdrawals.index') }}" class="sh-btn-back">
            <i class="fas fa-arrow-left"></i> {{ __('model.withdrawals.create.back_history') }}
        </a>
        <h1 class="page-title">{{ __('model.withdrawals.create.title') }}</h1>
    </div>

    <div class="sh-split-layout">
        <!-- Form Side -->
        <div>
            <form action="{{ route('model.withdrawals.store') }}" method="POST" id="withdrawalForm">
                @csrf

                <div class="sh-form-card">
                    <h3 class="sh-section-title"><i class="fas fa-coins" style="color: var(--model-gold);"></i> {{ __('model.withdrawals.create.section_amount') }}</h3>

                    <div class="sh-form-group">
                        <label class="sh-label">{{ __('model.withdrawals.create.label_amount') }}</label>
                        <div class="sh-input-wrapper">
                            <i class="fas fa-gem sh-input-icon"></i>
                            <input type="number" name="amount" id="amount" class="sh-input"
                                placeholder="{{ __('model.withdrawals.create.placeholder_amount', ['min' => number_format($minWithdrawal)]) }}" min="{{ $minWithdrawal }}"
                                max="{{ $availableBalance }}" oninput="calculateReceipt()">
                        </div>
                        <div class="sh-quick-btns">
                            <button type="button" class="sh-quick-btn"
                                onclick="setAmount({{ $minWithdrawal }})">{{ __('model.withdrawals.create.btn_min') }}</button>
                            <button type="button" class="sh-quick-btn"
                                onclick="setAmount({{ floor($availableBalance * 0.5) }})">{{ __('model.withdrawals.create.btn_50') }}</button>
                            <button type="button" class="sh-quick-btn"
                                onclick="setAmount({{ $availableBalance }})">{{ __('model.withdrawals.create.btn_max') }}</button>
                        </div>
                    </div>

                    <div id="receipt" class="sh-receipt" style="display: none;">
                        <div class="sh-receipt-row">
                            <span>{{ __('model.withdrawals.create.receipt.gross') }}</span>
                            <span id="receiptGross">$0.00 USD</span>
                        </div>
                        <div class="sh-receipt-row">
                            <span>{{ __('model.withdrawals.create.receipt.fee') }}</span>
                            <span id="receiptFee" style="color: #dc3545;">-$0.00 USD</span>
                        </div>
                        <div class="sh-receipt-divider"></div>
                        <div class="sh-receipt-total">
                            <span class="sh-total-label">{{ __('model.withdrawals.create.receipt.net') }}</span>
                            <span class="sh-total-val" id="receiptNet">$0.00 USD</span>
                        </div>
                    </div>
                </div>

                <div class="sh-form-card">
                    <h3 class="sh-section-title"><i class="fas fa-university" style="color: #0d6efd;"></i> {{ __('model.withdrawals.create.section_method') }}</h3>

                    <div class="sh-form-group">
                        <label class="sh-label">{{ __('model.withdrawals.create.label_method') }}</label>
                        <select name="payment_method" id="payment_method" class="sh-select" onchange="toggleDetails()">
                            <option value="">{{ __('model.withdrawals.create.placeholder_method') }}</option>
                            <option value="bank_transfer">{{ __('model.withdrawals.create.methods.bank') }}</option>
                            <option value="paypal">{{ __('model.withdrawals.create.methods.paypal') }}</option>
                            <option value="crypto">{{ __('model.withdrawals.create.methods.crypto') }}</option>
                        </select>
                    </div>

                    <!-- Dynamic Details -->
                    <div id="details-bank" style="display:none;" class="sh-payment-details">
                        <div class="sh-form-group">
                            <label class="sh-label">{{ __('model.withdrawals.create.bank.name') }}</label>
                            <input type="text" name="payment_details[bank_name]" class="sh-input"
                                placeholder="{{ __('model.withdrawals.create.bank.placeholder_name') }}">
                        </div>
                        <div class="sh-form-group">
                            <label class="sh-label">{{ __('model.withdrawals.create.bank.account') }}</label>
                            <input type="text" name="payment_details[account_number]" class="sh-input">
                        </div>
                        <div class="sh-form-group">
                            <label class="sh-label">{{ __('model.withdrawals.create.bank.holder') }}</label>
                            <input type="text" name="payment_details[account_holder]" class="sh-input">
                        </div>
                    </div>

                    <div id="details-paypal" style="display:none;" class="sh-payment-details">
                        <div class="sh-form-group">
                            <label class="sh-label">{{ __('model.withdrawals.create.paypal.email') }}</label>
                            <input type="email" name="payment_details[paypal_email]" class="sh-input"
                                placeholder="{{ __('model.withdrawals.create.paypal.placeholder_email') }}">
                        </div>
                    </div>

                    <div id="details-crypto" style="display:none;" class="sh-payment-details">
                        <div class="sh-form-group">
                            <label class="sh-label">{{ __('model.withdrawals.create.crypto.network') }}</label>
                            <select name="payment_details[crypto_type]" class="sh-select">
                                <option value="USDT">USDT (TRC20)</option>
                                <option value="BTC">Bitcoin</option>
                            </select>
                        </div>
                        <div class="sh-form-group">
                            <label class="sh-label">{{ __('model.withdrawals.create.crypto.address') }}</label>
                            <input type="text" name="payment_details[wallet_address]" class="sh-input" placeholder="{{ __('model.withdrawals.create.crypto.placeholder_address') }}">
                        </div>
                    </div>
                </div>

                <button type="submit" class="sh-btn-submit" onclick="return confirm('{{ __('model.withdrawals.create.confirm_submit') }}')">
                    {{ __('model.withdrawals.create.btn_submit') }} <i class="fas fa-arrow-right"></i>
                </button>
            </form>
        </div>

        <!-- Info Side -->
        <div>
            <div class="sh-balance-card">
                <div class="sh-label" style="color: #28a745;">{{ __('model.withdrawals.create.available_title') }}</div>
                <div class="sh-balance-main">{{ number_format($availableBalance) }} <small>TK</small></div>
                <div class="sh-balance-sub">≈ ${{ number_format($availableBalance * $tokenUsdRate, 2) }} USD</div>
            </div>

            <div class="sh-form-card">
                <h4 style="color: #fff; margin-bottom: 16px;">{{ __('model.withdrawals.create.rules_title') }}</h4>
                <ul class="sh-info-list">
                    <li>{{ __('model.withdrawals.create.rule_min', ['min' => number_format($minWithdrawal)]) }}</li>
                    <li>{{ __('model.withdrawals.create.rule_process') }}</li>
                    <li>{{ __('model.withdrawals.create.rule_rate', ['rate' => $tokenUsdRate]) }}</li>
                    <li>{{ __('model.withdrawals.create.rule_verify') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        const USDRATE = {{ $tokenUsdRate }};
        const MIN = {{ $minWithdrawal }};
        const MAX = {{ $availableBalance }};

        function setAmount(val) {
            document.getElementById('amount').value = val;
            calculateReceipt();
        }

        function calculateReceipt() {
            const val = document.getElementById('amount').value;
            const receipt = document.getElementById('receipt');

            if (val >= MIN) {
                receipt.style.display = 'block';

                const gross = val * USDRATE;
                const fee = gross * 0.05; // 5% fee
                const net = gross - fee;

                document.getElementById('receiptGross').innerText = '$' + gross.toFixed(2) + ' USD';
                document.getElementById('receiptFee').innerText = '-$' + fee.toFixed(2) + ' USD';
                document.getElementById('receiptNet').innerText = '$' + net.toFixed(2) + ' USD';
            } else {
                receipt.style.display = 'none';
            }
        }

        function toggleDetails() {
            // Hide all
            document.getElementById('details-bank').style.display = 'none';
            document.getElementById('details-paypal').style.display = 'none';
            document.getElementById('details-crypto').style.display = 'none';

            const method = document.getElementById('payment_method').value;
            if (method === 'bank_transfer') document.getElementById('details-bank').style.display = 'block';
            if (method === 'paypal') document.getElementById('details-paypal').style.display = 'block';
            if (method === 'crypto') document.getElementById('details-crypto').style.display = 'block';
        }
    </script>

@endsection