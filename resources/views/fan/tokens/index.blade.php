<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('fan.tokens.title') }}</title>

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Raleway:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    
    <link rel="stylesheet" href="{{ asset('css/premium-design.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sh-search-premium.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons/css/flag-icons.min.css">


    
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Raleway', sans-serif;
            background: var(--color-negro-azabache);
            color: var(--color-blanco-puro);
            overflow-x: hidden;
        }

        .main-content {
            margin-left: 280px;
            transition: all 0.3s ease;
            width: calc(100% - 280px);
            min-height: 100vh;
            position: relative;
            z-index: 10;
            padding-top: 85px;
        }

        .main-content.sidebar-hidden {
            margin-left: 0;
            width: 100%;
        }

        .tokens-container {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-family: 'Poppins', sans-serif;
            font-size: 28px !important;
            font-weight: 700;
            color: #d4af37;
            margin-bottom: 8px !important;
            line-height: 1.2;
            background: none;
            -webkit-text-fill-color: initial;
        }

        .page-subtitle {
            font-size: 16px !important;
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 24px !important;
            max-width: 620px;
            margin-left: 0;
            margin-right: 0;
        }

        .balance-section {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(32, 201, 151, 0.1));
            border: 1px solid rgba(40, 167, 69, 0.3);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .balance-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(40,167,69,0.1)"/></svg>') repeat;
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% {
                transform: translateY(0) translateX(0);
            }

            100% {
                transform: translateY(-100px) translateX(100px);
            }
        }

        .balance-content {
            position: relative;
            z-index: 10;
        }

        .balance-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #28a745, #20c997);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
            color: white;
            box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3);
        }

        .balance-amount {
            font-family: var(--font-titles);
            font-size: 3rem;
            font-weight: 700;
            color: #28a745;
            margin-bottom: 0.5rem;
        }

        .balance-label {
            font-size: 1.2rem;
            opacity: 0.8;
            margin-bottom: 1.5rem;
        }

        .balance-actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-recharge {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            font-family: var(--font-titles);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.1rem;
        }

        .btn-recharge:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(40, 167, 69, 0.4);
        }

        .btn-history {
            background: rgba(255, 255, 255, 0.1);
            color: var(--color-blanco-puro);
            padding: 1rem 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            font-family: var(--font-titles);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.1rem;
        }

        .btn-history:hover {
            background: rgba(212, 175, 55, 0.2);
            border-color: var(--color-oro-sensual);
            color: var(--color-oro-sensual);
            transform: translateY(-2px);
        }

        .quick-recharge {
            background: rgba(31, 31, 35, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .section-title {
            font-family: var(--font-titles);
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--color-oro-sensual);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quick-amounts {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .amount-btn {
            padding: 1rem;
            background: rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.3);
            border-radius: 12px;
            color: #28a745;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .amount-btn:hover {
            background: rgba(40, 167, 69, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.2);
        }

        .amount-btn.selected {
            background: #28a745;
            color: white;
            border-color: #28a745;
        }

        .amount-value {
            display: block;
            font-size: 1.2rem;
            margin-bottom: 0.25rem;
        }

        .amount-price {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .recent-transactions {
            background: rgba(31, 31, 35, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 16px;
            padding: 1.5rem;
        }

        .transaction-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .transaction-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .transaction-item:hover {
            background: rgba(212, 175, 55, 0.1);
        }

        .transaction-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .transaction-icon.recharge {
            background: linear-gradient(135deg, #007bff, #6610f2);
            color: white;
        }

        .transaction-icon.tip {
            background: linear-gradient(135deg, var(--color-rosa-vibrante), var(--color-rosa-oscuro));
            color: white;
        }

        .transaction-icon.refund {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            color: white;
        }

        .transaction-content {
            flex: 1;
        }

        .transaction-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .transaction-description {
            font-size: 0.85rem;
            opacity: 0.7;
        }

        .transaction-amount {
            font-weight: 600;
            white-space: nowrap;
        }

        .transaction-amount.positive {
            color: #28a745;
        }

        .transaction-amount.negative {
            color: var(--color-rosa-vibrante);
        }

        .transaction-time {
            font-size: 0.8rem;
            opacity: 0.6;
            white-space: nowrap;
            margin-left: 1rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            opacity: 0.7;
        }

        .empty-icon {
            font-size: 3rem;
            color: var(--color-oro-sensual);
            margin-bottom: 1rem;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-mini {
            background: rgba(31, 31, 35, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
        }

        .stat-mini-value {
            font-family: var(--font-titles);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-oro-sensual);
            margin-bottom: 0.25rem;
        }

        .stat-mini-label {
            font-size: 0.85rem;
            opacity: 0.8;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .main-content {
                margin-left: 0;
                width: 100%;
                padding-top: 90px;
            }

            .tokens-container {
                padding: 1rem;
            }

            .page-title {
                font-size: 20px !important;
            }

            .page-subtitle {
                font-size: 14px !important;
            }

            .balance-amount {
                font-size: 2.5rem;
            }

            .quick-amounts {
                grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            }

            .balance-actions {
                flex-direction: column;
                align-items: center;
            }

            .btn-recharge,
            .btn-history {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }
        }

        /* Estilos responsivos heredados */
    </style>
</head>

<body>
    @include('components.header-unified')

    @include('components.sidebar-premium')

    
    <div class="main-content" id="mainContent">
        <div class="tokens-container">
            
            <div class="page-header">
                <h1 class="page-title">
                    <i class="fas fa-coins"></i>
                    {{ __('fan.tokens.title') }}
                </h1>
                <p class="page-subtitle">
                    {{ __('fan.tokens.subtitle') }}
                </p>
            </div>

            
            <div class="balance-section">
                <div class="balance-content">
                    <div class="balance-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                    <div class="balance-amount">{{ $stats['balance'] ?? 0 }}</div>
                    <div class="balance-label">{{ __('fan.tokens.balance_label') }}</div>
                    <div class="balance-actions">
                        <a href="{{ route('fan.tokens.recharge') }}" class="btn-recharge">
                            <i class="fas fa-plus"></i>
                            {{ __('fan.tokens.btn_recharge') }}
                        </a>
                        <a href="{{ route('fan.tokens.history') }}" class="btn-history">
                            <i class="fas fa-history"></i>
                            {{ __('fan.tokens.btn_history') }}
                        </a>
                    </div>
                </div>
            </div>

            
            <div class="xp-earned-section"
                style="background: rgba(31, 31, 35, 0.95); border: 1px solid rgba(212, 175, 55, 0.2); border-radius: 16px; padding: 1.5rem; margin-bottom: 2rem;">
                <h3 class="section-title">
                    <i class="fas fa-chart-line"></i>
                    {{ __('fan.tokens.xp_title') }}
                </h3>
                <div class="xp-stats-grid"
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 1rem;">
                    <div class="xp-stat"
                        style="text-align: center; padding: 1rem; background: rgba(212, 175, 55, 0.1); border-radius: 12px;">
                        <span class="xp-stat-value"
                            style="display: block; font-size: 1.8rem; font-weight: 700; color: var(--color-oro-sensual); margin-bottom: 0.25rem;">{{ number_format($xpFromTokens) }}</span>
                        <span class="xp-stat-label" style="font-size: 0.9rem; opacity: 0.8;">{{ __('fan.tokens.xp_recharge') }}</span>
                    </div>
                    <div class="xp-stat"
                        style="text-align: center; padding: 1rem; background: rgba(212, 175, 55, 0.1); border-radius: 12px;">
                        <span class="xp-stat-value"
                            style="display: block; font-size: 1.8rem; font-weight: 700; color: var(--color-oro-sensual); margin-bottom: 0.25rem;">{{ number_format($xpFromTips) }}</span>
                        <span class="xp-stat-label" style="font-size: 0.9rem; opacity: 0.8;">{{ __('fan.tokens.xp_tips') }}</span>
                    </div>
                </div>
            </div>

            
            @if($cashbackPercentage > 0)
                <x-level-benefits-reminder :currentLevel="$currentLevel" :benefit="['required_level' => 6, 'description' => $cashbackPercentage . '% Cashback en todas las propinas']" type="success" />
            @elseif($nextLevelBenefit)
                <x-level-benefits-reminder :currentLevel="$currentLevel" :benefit="$nextLevelBenefit" type="warning" />
            @endif

            
            @if($tokenMissions->count() > 0)
                <div class="related-missions"
                    style="background: rgba(31, 31, 35, 0.95); border: 1px solid rgba(212, 175, 55, 0.2); border-radius: 16px; padding: 1.5rem; margin-bottom: 2rem;">
                    <h3 class="section-title">
                        <i class="fas fa-bullseye"></i>
                        {{ __('fan.tokens.missions_title') }}
                    </h3>
                    <div style="display: flex; flex-direction: column; gap: 0.75rem; margin-top: 1rem;">
                        @foreach($tokenMissions as $mission)
                            <x-mission-progress-mini :mission="$mission" />
                        @endforeach
                    </div>
                </div>
            @endif

            
            <div class="recent-transactions">
                <h2 class="section-title">
                    <i class="fas fa-clock"></i>
                    {{ __('fan.tokens.recent_transactions') }}
                </h2>

                <div class="transaction-list">
                    @forelse($transactions as $transaction)
                        <div class="transaction-item">
                            <div class="transaction-icon {{ $transaction->type }}">
                                @if($transaction->type === 'recharge')
                                    <i class="fas fa-plus"></i>
                                @elseif($transaction->type === 'tip')
                                    <i class="fas fa-heart"></i>
                                @elseif($transaction->type === 'refund')
                                    <i class="fas fa-undo"></i>
                                @endif
                            </div>
                            <div class="transaction-content">
                                <div class="transaction-title">
                                    @if($transaction->type === 'recharge')
                                        {{ __('fan.tokens.type_recharge') }}
                                    @elseif($transaction->type === 'tip')
                                        {{ __('fan.tokens.type_tip') }}
                                    @elseif($transaction->type === 'refund')
                                        {{ __('fan.tokens.type_refund') }}
                                    @endif
                                </div>
                                <div class="transaction-description">
                                    {{ $transaction->description }}
                                </div>
                            </div>
                            <div class="transaction-amount {{ $transaction->amount > 0 ? 'positive' : 'negative' }}">
                                {{ $transaction->amount > 0 ? '+' : '' }}{{ $transaction->amount }} {{ __('fan.tokens.token_unit') }}
                            </div>
                            <div class="transaction-time">
                                {{ $transaction->created_at ? $transaction->created_at->diffForHumans() : __('fan.tokens.date_not_available') }}
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-coins"></i>
                            </div>
                            <h3>{{ __('fan.tokens.empty_title') }}</h3>
                            <p>{{ __('fan.tokens.empty_subtitle') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    
    <script>
        // Header scroll effect
        window.addEventListener('scroll', function () {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Sidebar toggle
         else {
            sidebar.classList.toggle('open');
        }
        }

        // Close sidebar when clicking outside (mobile)
        document.addEventListener('click', function (event) {
            if (window.innerWidth <= 1024) {
                const sidebar = document.getElementById('sidebar');
                const target = event.target;

                if (!sidebar.contains(target) && !target.closest('[onclick="toggleSidebar()"]')) {
                    sidebar.classList.remove('open');
                }
            }
        });

        // Quick recharge functionality
        document.querySelectorAll('.amount-btn').forEach(button => {
            button.addEventListener('click', function () {
                const tokens = this.dataset.tokens;
                const price = this.dataset.price;

                // Remove selected class from all buttons
                document.querySelectorAll('.amount-btn').forEach(btn => {
                    btn.classList.remove('selected');
                });

                // Add selected class to clicked button
                this.classList.add('selected');

                // Update recharge button
                const rechargeBtn = document.getElementById('quickRechargeBtn');
                rechargeBtn.disabled = false;
                rechargeBtn.innerHTML = `<i class="fas fa-credit-card"></i> ${'{{ __('fan.tokens.buy_button_text', ['tokens' => ':tokens', 'price' => ':price']) }}'.replace(':tokens', tokens).replace(':price', price)}`;
                rechargeBtn.onclick = () => quickRecharge(tokens, price);
            });
        });

        function quickRecharge(tokens, price) {
            if (confirm('{{ __('fan.tokens.confirm_purchase') }}'.replace(':tokens', tokens).replace(':price', price))) {
                // Aquí iría la lógica de pago
                // Por ahora simulamos la compra
                fetch('{{ route("fan.tokens.quick-recharge") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        tokens: tokens,
                        price: price
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update balance
                            document.querySelector('.balance-amount').textContent = data.new_balance;

                            // Show success message
                            showNotification('{{ __('fan.tokens.recharge_success') }}', '{{ __('fan.tokens.recharge_success_msg') }}'.replace(':tokens', tokens), 'success');

                            // Reset selection
                            document.querySelectorAll('.amount-btn').forEach(btn => {
                                btn.classList.remove('selected');
                            });

                            const rechargeBtn = document.getElementById('quickRechargeBtn');
                            rechargeBtn.disabled = true;
                            rechargeBtn.innerHTML = '<i class="fas fa-credit-card"></i> {{ __('fan.tokens.select_amount') }}';

                            // Reload page after 2 seconds to show updated transactions
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        } else {
                            showNotification('Error', 'No se pudo procesar la recarga. Inténtalo de nuevo.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Error', 'Ocurrió un error inesperado. Inténtalo de nuevo.', 'error');
                    });
            }
        }

        function showNotification(title, message, type) {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? 'linear-gradient(135deg, #28a745, #20c997)' : 'linear-gradient(135deg, #dc3545, #c82333)'};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 12px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
                z-index: 10000;
                animation: slideInRight 0.5s ease;
                max-width: 350px;
            `;

            notification.innerHTML = `
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                    <strong>${title}</strong>
                </div>
                <div style="font-size: 0.9rem;">${message}</div>
            `;

            document.body.appendChild(notification);

            // Remove after 5 seconds
            setTimeout(() => {
                notification.style.animation = 'slideOutRight 0.5s ease';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 500);
            }, 5000);
        }

        // Add CSS for notifications
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateX(100%);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            
            @keyframes slideOutRight {
                from {
                    opacity: 1;
                    transform: translateX(0);
                }
                to {
                    opacity: 0;
                    transform: translateX(100%);
                }
            }
        `;
        document.head.appendChild(style);

        // Animate balance on load
        document.addEventListener('DOMContentLoaded', function () {
            const balanceElement = document.querySelector('.balance-amount');
            const finalValue = parseInt(balanceElement.textContent);
            let currentValue = 0;
            const increment = finalValue / 50;

            const timer = setInterval(() => {
                currentValue += increment;
                if (currentValue >= finalValue) {
                    balanceElement.textContent = finalValue;
                    clearInterval(timer);
                } else {
                    balanceElement.textContent = Math.floor(currentValue);
                }
            }, 30);
        });
    </script>

    
    @include('components.sidebar-header-scripts')
    @include('components.search-scripts')
</body>

</html>