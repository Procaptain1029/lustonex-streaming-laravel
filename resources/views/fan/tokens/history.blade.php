<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('fan.tokens.history_title') }}</title>

    
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
        }

        .main-content.sidebar-hidden {
            margin-left: 0;
            width: 100%;
        }

        .history-container {
            padding: 2rem;
            max-width: 1200px;
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

        .filters-section {
            background: rgba(31, 31, 35, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .filter-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--color-oro-sensual);
        }

        .filter-select,
        .filter-input {
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 8px;
            color: white;
            font-size: 0.9rem;
        }

        .filter-select option {
            background-color: #1f1f23;
            color: white;
        }

        .filter-select:focus,
        .filter-input:focus {
            outline: none;
            border-color: var(--color-oro-sensual);
            box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.2);
        }

        .btn-filter {
            background: linear-gradient(135deg, var(--color-oro-sensual), #f4e37d);
            color: var(--color-negro-azabache);
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-filter:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.4);
        }

        .transactions-section {
            background: rgba(31, 31, 35, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 16px;
            padding: 1.5rem;
        }

        /* Transactions Section */
        .transactions-section {
            background: rgba(31, 31, 35, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(212, 175, 55, 0.1);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .section-title {
            font-family: var(--font-titles);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-oro-sensual);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .transactions-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .transactions-table th {
            color: rgba(255,255,255,0.5);
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: none;
        }

        .transactions-table tbody tr {
            background: rgba(255, 255, 255, 0.03);
            transition: all 0.3s ease;
        }

        .transactions-table tbody tr:hover {
            background: rgba(212, 175, 55, 0.08);
            transform: scale(1.005);
        }

        .transactions-table td {
            padding: 1.25rem 1rem;
            border-top: 1px solid rgba(255,255,255,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .transactions-table td:first-child {
            border-left: 1px solid rgba(255,255,255,0.05);
            border-radius: 12px 0 0 12px;
        }

        .transactions-table td:last-child {
            border-right: 1px solid rgba(255,255,255,0.05);
            border-radius: 0 12px 12px 0;
        }

        .transaction-type {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .type-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .type-icon.recharge {
            background: rgba(37, 99, 235, 0.15);
            color: #3b82f6;
            border: 1px solid rgba(37, 99, 235, 0.2);
        }

        .type-icon.tip {
            background: rgba(236, 72, 153, 0.15);
            color: #ec4899;
            border: 1px solid rgba(236, 72, 153, 0.2);
        }

        .type-icon.refund {
            background: rgba(245, 158, 11, 0.15);
            color: #f59e0b;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .amount-positive {
            color: #10b981;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .amount-negative {
            color: #ef4444;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-completed {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .status-pending {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .status-failed {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-icon {
            font-size: 4rem;
            background: linear-gradient(135deg, var(--color-oro-sensual), #f4e37d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1.5rem;
        }

        /* Mobile specific card styles */
        .mobile-label {
            display: none;
            font-size: 0.75rem;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            margin-bottom: 0.25rem;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .main-content {
                margin-left: 0;
                width: 100%;
                padding-top: 20px;
            }

            .history-container {
                padding: 1.25rem;
            }

            .page-title {
                font-size: 2.2rem;
            }

            .filters-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 20px !important;
            }

            .page-subtitle {
                font-size: 14px !important;
            }

            .filters-grid {
                grid-template-columns: 1fr;
            }

            .transactions-section {
                padding: 1.25rem;
            }

            .transactions-table, .transactions-table thead, .transactions-table tbody, .transactions-table th, .transactions-table td, .transactions-table tr {
                display: block;
            }

            .transactions-table thead {
                display: none;
            }

            .transactions-table tbody tr {
                margin-bottom: 1.5rem;
                padding: 1.25rem;
                border: 1px solid rgba(255,255,255,0.05);
                border-radius: 16px;
                background: rgba(255,255,255,0.02);
            }

            .transactions-table td {
                padding: 0.75rem 0;
                border: none !important;
                display: flex;
                flex-direction: column;
            }

            .transactions-table td:first-child {
                border-radius: 0;
            }

            .mobile-label {
                display: block;
            }

            .transaction-type {
                justify-content: flex-start;
            }

            .status-badge {
                display: inline-block;
                width: fit-content;
            }
        }

        /* Estilos responsivos heredados */
    </style>
</head>

<body>
    @include('components.header-unified')

    @include('components.sidebar-premium')

    
    <div class="main-content" id="mainContent">
        <div class="history-container">
            
            <div class="page-header">
                <h1 class="page-title">
                    <i class="fas fa-history"></i>
                    {{ __('fan.tokens.history_header') }}
                </h1>
                <p class="page-subtitle">
                    {{ __('fan.tokens.history_subtitle') }}
                </p>
            </div>

            
            <div class="filters-section">
                <div class="filters-grid">
                    <div class="filter-group">
                        <label class="filter-label">{{ __('fan.tokens.filter_type') }}</label>
                        <select class="filter-select" id="typeFilter">
                            <option value="">{{ __('fan.tokens.filter_all') }}</option>
                            <option value="recharge">{{ __('fan.tokens.filter_recharges') }}</option>
                            <option value="tip">{{ __('fan.tokens.filter_tips') }}</option>
                            <option value="refund">{{ __('fan.tokens.filter_refunds') }}</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">{{ __('fan.tokens.filter_date_from') }}</label>
                        <input type="date" class="filter-input" id="dateFrom">
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">{{ __('fan.tokens.filter_date_to') }}</label>
                        <input type="date" class="filter-input" id="dateTo">
                    </div>

                    <div class="filter-group">
                        <button class="btn-filter" onclick="applyFilters()">
                            <i class="fas fa-filter"></i>
                            {{ __('fan.tokens.btn_filter') }}
                        </button>
                    </div>
                </div>
            </div>



            
            <div class="transactions-section">
                <h2 class="section-title">
                    <i class="fas fa-list"></i>
                    {{ __('fan.tokens.history_header') }}
                </h2>

                <div style="overflow-x: auto;">
                    <table class="transactions-table">
                        <thead>
                            <tr>
                                <th>{{ __('fan.tokens.table.type') }}</th>
                                <th>{{ __('fan.tokens.table.description') }}</th>
                                <th>{{ __('fan.tokens.table.amount') }}</th>
                                <th>{{ __('fan.tokens.table.status') }}</th>
                                <th>{{ __('fan.tokens.table.date') }}</th>
                            </tr>
                        </thead>
                        <tbody id="transactionsBody">
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td>
                                        <span class="mobile-label">{{ __('fan.tokens.table.type') }}</span>
                                        <div class="transaction-type">
                                            <div class="type-icon {{ $transaction->type }}">
                                                @if($transaction->type === 'tip')
                                                    <i class="fas fa-heart"></i>
                                                @elseif($transaction->type === 'recharge' || $transaction->type === 'purchase')
                                                    <i class="fas fa-plus"></i>
                                                @else
                                                    <i class="fas fa-exchange-alt"></i>
                                                @endif
                                            </div>
                                            <span style="font-weight: 600;">{{ $transaction->type === 'tip' ? __('fan.tokens.type.tip') : ($transaction->type === 'recharge' || $transaction->type === 'purchase' ? __('fan.tokens.type.recharge') : ucfirst($transaction->type)) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="mobile-label">{{ __('fan.tokens.table.description') }}</span>
                                        <div style="font-size: 0.95rem;">
                                            {{ $transaction->description }}
                                            @if($transaction->message)
                                                <div style="opacity: 0.5; font-size: 0.85rem; margin-top: 4px;">
                                                    <i class="fas fa-quote-left" style="font-size: 10px; margin-right: 5px;"></i>
                                                    {{ $transaction->message }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="mobile-label">{{ __('fan.tokens.table.amount') }}</span>
                                        <div class="{{ $transaction->amount > 0 ? 'amount-positive' : 'amount-negative' }}">
                                            {{ $transaction->amount > 0 ? '+' : '' }}{{ number_format($transaction->amount) }} {{ __('fan.tokens.token_unit') }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="mobile-label">{{ __('fan.tokens.table.status') }}</span>
                                        <span class="status-badge status-{{ $transaction->status }}">
                                            @if($transaction->status === 'completed')
                                                {{ __('fan.tokens.status.completed') }}
                                            @elseif($transaction->status === 'pending')
                                                {{ __('fan.tokens.status.pending') }}
                                            @else
                                                {{ __('fan.tokens.status.failed') }}
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span class="mobile-label">{{ __('fan.tokens.table.date') }}</span>
                                        <div style="font-size: 0.9rem; opacity: 0.8;">
                                            <i class="far fa-calendar-alt" style="margin-right: 5px; opacity: 0.5;"></i>
                                            {{ $transaction->created_at ? $transaction->created_at->format('d/m/Y') : __('fan.tokens.date_not_available') }}
                                            <div style="font-size: 0.8rem; opacity: 0.5; margin-top: 2px;">
                                                <i class="far fa-clock" style="margin-right: 5px;"></i>
                                                {{ $transaction->created_at ? $transaction->created_at->format('H:i') : '' }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 2rem; opacity: 0.7;">
                                        <i class="fas fa-inbox"
                                            style="font-size: 2rem; margin-bottom: 1rem; display: block;"></i>
                                        {{ __('fan.tokens.empty_history') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-wrapper" style="margin-top: 2rem; display: flex; justify-content: center;">
                    {{ $transactions->links('custom.pagination') }}
                </div>

                
                <div class="empty-state" id="emptyState" style="display: none;">
                    <div class="empty-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <h3>{{ __('fan.tokens.empty_title') }}</h3>
                    <p>{{ __('fan.tokens.empty_subtitle') }}</p>
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

        // Apply filters
        function applyFilters() {
            const typeFilter = document.getElementById('typeFilter').value;
            const dateFrom = document.getElementById('dateFrom').value;
            const dateTo = document.getElementById('dateTo').value;

            // Aquí iría la lógica para filtrar las transacciones
            // Por ahora solo mostramos un mensaje
            console.log('Aplicando filtros:', { typeFilter, dateFrom, dateTo });

            // Simular filtrado
            const rows = document.querySelectorAll('#transactionsBody tr');
            let visibleRows = 0;

            rows.forEach(row => {
                let shouldShow = true;

                if (typeFilter) {
                    const typeText = row.querySelector('.transaction-type span').textContent.toLowerCase();
                    const filterMap = {
                        'recharge': 'recarga',
                        'tip': 'propina',
                        'refund': 'reembolso'
                    };

                    if (!typeText.includes(filterMap[typeFilter] || typeFilter)) {
                        shouldShow = false;
                    }
                }

                if (shouldShow) {
                    row.style.display = '';
                    visibleRows++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Mostrar estado vacío si no hay resultados
            const emptyState = document.getElementById('emptyState');
            const table = document.querySelector('.transactions-table');

            if (visibleRows === 0) {
                table.style.display = 'none';
                emptyState.style.display = 'block';
            } else {
                table.style.display = 'table';
                emptyState.style.display = 'none';
            }

            showNotification('{{ __('fan.tokens.filters_applied') }}', '{{ __('fan.tokens.transactions_found', ['count' => ':count']) }}'.replace(':count', visibleRows), 'success');
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

            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.animation = 'slideOutRight 0.5s ease';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 500);
            }, 3000);
        }

        // Add CSS for notifications
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from { opacity: 0; transform: translateX(100%); }
                to { opacity: 1; transform: translateX(0); }
            }
            @keyframes slideOutRight {
                from { opacity: 1; transform: translateX(0); }
                to { opacity: 0; transform: translateX(100%); }
            }
        `;
        document.head.appendChild(style);

        // Set default date range (last 30 days)
        document.addEventListener('DOMContentLoaded', function () {
            const today = new Date();
            const thirtyDaysAgo = new Date(today.getTime() - (30 * 24 * 60 * 60 * 1000));

            document.getElementById('dateTo').value = today.toISOString().split('T')[0];
            document.getElementById('dateFrom').value = thirtyDaysAgo.toISOString().split('T')[0];
        });
    </script>

    
    @include('components.sidebar-header-scripts')
    @include('components.search-scripts')
</body>

</html>