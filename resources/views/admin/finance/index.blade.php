@extends('layouts.admin')

@section('title', __('admin.finance.balance.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.finance.balance.title') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Finance Balance Dashboard ----- */

        .page-header {
            margin-bottom: 32px;
        }


        .sh-token-rate {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            background: rgba(212, 175, 55, 0.1);
            border: 1px solid rgba(212, 175, 55, 0.2);
            color: var(--admin-gold);
            font-size: 12px;
            font-weight: 700;
            margin-top: 12px;
        }

        /* Hero Balance Cards */
        .sh-hero-balance {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 24px;
        }

        .sh-balance-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 28px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .sh-balance-card:hover {
            background: rgba(255, 255, 255, 0.04);
            transform: translateY(-4px);
        }

        .sh-balance-card.income {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.06), rgba(0, 0, 0, 0.2));
            border-color: rgba(212, 175, 55, 0.2);
        }

        .sh-balance-card.expense {
            border-color: rgba(239, 68, 68, 0.15);
        }

        .sh-balance-card.profit {
            border-color: rgba(16, 185, 129, 0.15);
        }

        .sh-balance-label {
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255, 255, 255, 0.4);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sh-balance-label i {
            font-size: 14px;
        }

        .sh-balance-value {
            font-size: 32px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 8px;
        }

        .sh-balance-value.gold { color: var(--admin-gold); }
        .sh-balance-value.red { color: #ef4444; }
        .sh-balance-value.green { color: #10b981; }

        .sh-balance-detail {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.5);
        }

        .sh-balance-icon {
            position: absolute;
            right: -10px;
            bottom: -10px;
            font-size: 4rem;
            opacity: 0.04;
            transform: rotate(-15deg);
            pointer-events: none;
        }

        /* Stats Grid */
        .sh-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .sh-stat-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 20px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .sh-stat-card:hover {
            background: rgba(255, 255, 255, 0.04);
            transform: translateY(-3px);
        }

        .sh-stat-label {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.4);
            margin-bottom: 8px;
        }

        .sh-stat-value {
            font-size: 22px;
            font-weight: 800;
            color: #fff;
        }

        .sh-stat-sub {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.4);
            margin-top: 4px;
        }

        .sh-stat-icon {
            position: absolute;
            right: -8px;
            bottom: -8px;
            font-size: 3rem;
            opacity: 0.04;
            transform: rotate(-15deg);
            color: var(--admin-gold);
            pointer-events: none;
        }

        /* Monthly comparison */
        .sh-monthly-row {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 16px;
            margin-bottom: 32px;
        }

        .sh-monthly-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .sh-monthly-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .sh-monthly-icon.income { background: rgba(212, 175, 55, 0.1); color: var(--admin-gold); }
        .sh-monthly-icon.expense { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
        .sh-monthly-icon.profit { background: rgba(16, 185, 129, 0.1); color: #10b981; }

        .sh-monthly-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.4);
            margin-bottom: 4px;
        }

        .sh-monthly-value {
            font-size: 20px;
            font-weight: 800;
            color: #fff;
        }

        /* Activity Tables */
        .sh-audit-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .sh-admin-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            overflow: hidden;
        }

        .sh-card-header {
            padding: 18px 22px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sh-card-title {
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--admin-gold);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sh-btn-view-all {
            font-size: 11px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.4);
            text-decoration: none;
            transition: color 0.2s;
        }

        .sh-btn-view-all:hover {
            color: var(--admin-gold);
        }

        .sh-modern-table {
            width: 100%;
            border-collapse: collapse;
        }

        .sh-modern-table th {
            padding: 12px 22px;
            text-align: left;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.25);
            letter-spacing: 0.5px;
            background: rgba(255, 255, 255, 0.01);
        }

        .sh-modern-table td {
            padding: 14px 22px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            vertical-align: middle;
            font-size: 14px;
            color: #fff;
        }

        .sh-modern-table tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }

        .sh-user-link {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .sh-avatar {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sh-user-name {
            font-weight: 700;
            color: #fff;
            font-size: 13px;
        }

        .sh-amount {
            font-weight: 800;
            color: var(--admin-gold);
            font-size: 14px;
        }

        .sh-badge {
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .sh-badge-completed, .sh-badge-active {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .sh-badge-pending {
            background: rgba(251, 191, 36, 0.1);
            color: #fbbf24;
        }

        .sh-timestamp {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.3);
        }

        /* ── Responsive ── */
        @media (max-width: 1200px) {
            .sh-audit-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .page-header {
                margin-bottom: 20px;
            }

            .sh-hero-balance {

                grid-template-columns: 1fr;
                gap: 12px;
                margin-bottom: 20px;
            }

            .sh-balance-card {
                padding: 20px;
                border-radius: 16px;
            }

            .sh-balance-value {
                font-size: 26px;
            }

            .sh-stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
                margin-bottom: 20px;
            }

            .sh-stat-card {
                padding: 16px;
                border-radius: 14px;
            }

            .sh-stat-value {
                font-size: 18px;
            }

            .sh-stat-label {
                font-size: 10px;
            }

            .sh-monthly-row {
                grid-template-columns: 1fr;
                gap: 12px;
                margin-bottom: 24px;
            }

            .sh-monthly-card {
                padding: 16px;
                border-radius: 14px;
            }

            .sh-monthly-value {
                font-size: 18px;
            }

            .sh-monthly-icon {
                width: 38px;
                height: 38px;
                font-size: 16px;
                border-radius: 10px;
            }

            .sh-admin-card {
                border-radius: 12px;
            }

            .sh-card-header {
                padding: 14px 18px;
            }

            .sh-card-title {
                font-size: 12px;
            }

            .sh-modern-table th,
            .sh-modern-table td {
                padding: 10px 16px;
            }

            /* Hide Status and Date in tables */
            .sh-modern-table th:nth-child(3),
            .sh-modern-table td:nth-child(3),
            .sh-modern-table th:nth-child(4),
            .sh-modern-table td:nth-child(4) {
                display: none;
            }

            .sh-avatar {
                width: 26px;
                height: 26px;
                border-radius: 6px;
            }

            .sh-user-name {
                font-size: 12px;
            }
        }

        @media (max-width: 480px) {
            .sh-balance-card {

                padding: 18px;
                border-radius: 14px;
            }

            .sh-balance-value {
                font-size: 22px;
            }

            .sh-balance-label {
                font-size: 11px;
            }

            .sh-stats-grid {
                gap: 10px;
            }

            .sh-stat-card {
                padding: 14px;
                border-radius: 12px;
            }

            .sh-stat-value {
                font-size: 16px;
            }

            .sh-modern-table th,
            .sh-modern-table td {
                padding: 8px 12px;
            }

            .sh-amount {
                font-size: 12px;
            }

            .sh-token-rate {
                font-size: 11px;
                padding: 5px 12px;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Hero -->
    <div class="page-header">
        <h1 class="page-title">{{ __('admin.finance.balance.title') }}</h1>
        <p class="page-subtitle">{{ __('admin.finance.balance.subtitle') }}</p>
        <div class="sh-token-rate">
            <i class="fas fa-coins"></i> {{ __('admin.finance.balance.token_rate', ['value' => number_format($stats['token_value'], 2)]) }}
        </div>
    </div>

    <!-- Hero Balance Cards -->
    <div class="sh-hero-balance">
        <div class="sh-balance-card income">
            <div class="sh-balance-label"><i class="fas fa-arrow-down" style="color: var(--admin-gold);"></i> {{ __('admin.finance.balance.total_income') }}</div>
            <div class="sh-balance-value gold">${{ number_format($stats['total_income_usd'], 2) }}</div>
            <div class="sh-balance-detail"><i class="fas fa-coins" style="font-size: 11px;"></i> {{ number_format($stats['tokens_sold']) }} {{ __('admin.finance.balance.tokens_sold') }}</div>
            <i class="fas fa-dollar-sign sh-balance-icon" style="color: var(--admin-gold);"></i>
        </div>

        <div class="sh-balance-card expense">
            <div class="sh-balance-label"><i class="fas fa-arrow-up" style="color: #ef4444;"></i> {{ __('admin.finance.balance.model_payouts') }}</div>
            <div class="sh-balance-value red">${{ number_format($stats['total_payouts_usd'], 2) }}</div>
            <div class="sh-balance-detail">{{ __('admin.finance.balance.payouts_desc') }}</div>
            <i class="fas fa-money-bill-wave sh-balance-icon" style="color: #ef4444;"></i>
        </div>

        <div class="sh-balance-card profit">
            <div class="sh-balance-label"><i class="fas fa-chart-line" style="color: #10b981;"></i> {{ __('admin.finance.balance.net_profit') }}</div>
            <div class="sh-balance-value green">${{ number_format($stats['net_profit_usd'], 2) }}</div>
            <div class="sh-balance-detail">{{ __('admin.finance.balance.profit_desc') }}</div>
            <i class="fas fa-trophy sh-balance-icon" style="color: #10b981;"></i>
        </div>
    </div>

    <!-- Operational Stats -->
    <div class="sh-stats-grid">
        <div class="sh-stat-card">
            <div class="sh-stat-label">{{ __('admin.finance.balance.stats.tokens_sold_title') }}</div>
            <div class="sh-stat-value" style="color: var(--admin-gold);">{{ number_format($stats['tokens_sold']) }}</div>
            <div class="sh-stat-sub">{{ __('admin.finance.balance.stats.tokens_sold_sub') }}</div>
            <i class="fas fa-coins sh-stat-icon"></i>
        </div>
        <div class="sh-stat-card">
            <div class="sh-stat-label">{{ __('admin.finance.balance.stats.in_circulation') }}</div>
            <div class="sh-stat-value" style="color: #3b82f6;">{{ number_format($stats['tokens_in_circulation']) }}</div>
            <div class="sh-stat-sub">${{ number_format($stats['circulation_value_usd'], 2) }} USD</div>
            <i class="fas fa-sync-alt sh-stat-icon"></i>
        </div>
        <div class="sh-stat-card">
            <div class="sh-stat-label">{{ __('admin.finance.balance.stats.pending_withdrawals') }}</div>
            <div class="sh-stat-value" style="color: #fbbf24;">{{ $stats['pending_withdrawals'] }}</div>
            <div class="sh-stat-sub"><i class="fas fa-coins" style="font-size: 10px;"></i> {{ number_format($stats['pending_withdrawals_amount']) }} {{ __('admin.finance.balance.stats.pending_withdrawals_sub') }}</div>
            <i class="fas fa-clock sh-stat-icon"></i>
        </div>
        <div class="sh-stat-card">
            <div class="sh-stat-label">{{ __('admin.finance.balance.stats.active_subscriptions') }}</div>
            <div class="sh-stat-value" style="color: #10b981;">{{ $stats['active_subscriptions'] }}</div>
            <i class="fas fa-user-check sh-stat-icon"></i>
        </div>
        <div class="sh-stat-card">
            <div class="sh-stat-label">{{ __('admin.finance.balance.stats.completed_tips') }}</div>
            <div class="sh-stat-value">{{ number_format($stats['total_tips']) }}</div>
            <i class="fas fa-gift sh-stat-icon"></i>
        </div>
    </div>

    <!-- Monthly Comparison -->
    <div class="sh-monthly-row">
        <div class="sh-monthly-card">
            <div class="sh-monthly-icon income"><i class="fas fa-arrow-down"></i></div>
            <div>
                <div class="sh-monthly-label">{{ __('admin.finance.balance.monthly.income') }}</div>
                <div class="sh-monthly-value" style="color: var(--admin-gold);">${{ number_format($stats['this_month_income_usd'], 2) }}</div>
            </div>
        </div>
        <div class="sh-monthly-card">
            <div class="sh-monthly-icon expense"><i class="fas fa-arrow-up"></i></div>
            <div>
                <div class="sh-monthly-label">{{ __('admin.finance.balance.monthly.payouts') }}</div>
                <div class="sh-monthly-value" style="color: #ef4444;">${{ number_format($stats['this_month_payouts_usd'], 2) }}</div>
            </div>
        </div>
        <div class="sh-monthly-card">
            <div class="sh-monthly-icon profit"><i class="fas fa-equals"></i></div>
            <div>
                <div class="sh-monthly-label">{{ __('admin.finance.balance.monthly.profit') }}</div>
                <div class="sh-monthly-value" style="color: #10b981;">${{ number_format($stats['this_month_net_usd'], 2) }}</div>
            </div>
        </div>
    </div>

    <!-- Activity Tables -->
    <div class="sh-audit-grid">
        <!-- Recent Tips -->
        <div class="sh-admin-card">
            <div class="sh-card-header">
                <h3 class="sh-card-title"><i class="fas fa-coins"></i> {{ __('admin.finance.balance.tables.recent_tips') }}</h3>
                <a href="{{ route('admin.finance.tips') }}" class="sh-btn-view-all">{{ __('admin.finance.balance.tables.view_all') }} <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="table-responsive">
                <table class="sh-modern-table">
                    <thead>
                        <tr>
                            <th>{{ __('admin.finance.balance.tables.sender') }}</th>
                            <th>{{ __('admin.finance.balance.tables.tokens') }}</th>
                            <th>{{ __('admin.finance.balance.tables.status') }}</th>
                            <th>{{ __('admin.finance.balance.tables.date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTips as $tip)
                            <tr>
                                <td>
                                    <div class="sh-user-link">
                                        <img src="{{ $tip->sender?->profile?->avatar_url ?? asset('images/default-avatar.png') }}" class="sh-avatar" alt="Avatar">
                                        <span class="sh-user-name">{{ $tip->sender->name ?? 'User' }}</span>
                                    </div>
                                </td>
                                <td><span class="sh-amount"><i class="fas fa-coins" style="font-size: 11px; margin-right: 3px;"></i>{{ number_format($tip->amount) }}</span></td>
                                <td><span class="sh-badge sh-badge-{{ $tip->status }}">{{ ucfirst($tip->status) }}</span></td>
                                <td><span class="sh-timestamp">{{ $tip->created_at->diffForHumans() }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 40px; color: rgba(255,255,255,0.2);">{{ __('admin.finance.balance.tables.no_activity') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Subscriptions -->
        <div class="sh-admin-card">
            <div class="sh-card-header">
                <h3 class="sh-card-title"><i class="fas fa-receipt"></i> {{ __('admin.finance.balance.tables.recent_subs') }}</h3>
                <a href="{{ route('admin.finance.subscriptions') }}" class="sh-btn-view-all">{{ __('admin.finance.balance.tables.view_all') }} <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="table-responsive">
                <table class="sh-modern-table">
                    <thead>
                        <tr>
                            <th>{{ __('admin.finance.balance.tables.subscriber') }}</th>
                            <th>{{ __('admin.finance.balance.tables.tokens') }}</th>
                            <th>{{ __('admin.finance.balance.tables.status') }}</th>
                            <th>{{ __('admin.finance.balance.tables.date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentSubscriptions as $sub)
                            <tr>
                                <td>
                                    <div class="sh-user-link">
                                        <img src="{{ $sub->fan?->profile?->avatar_url ?? asset('images/default-avatar.png') }}" class="sh-avatar" alt="Avatar">
                                        <span class="sh-user-name">{{ $sub->fan->name ?? 'Fan' }}</span>
                                    </div>
                                </td>
                                <td><span class="sh-amount"><i class="fas fa-coins" style="font-size: 11px; margin-right: 3px;"></i>{{ number_format($sub->amount) }}</span></td>
                                <td><span class="sh-badge sh-badge-{{ $sub->status }}">{{ ucfirst($sub->status) }}</span></td>
                                <td><span class="sh-timestamp">{{ $sub->created_at->diffForHumans() }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 40px; color: rgba(255,255,255,0.2);">{{ __('admin.finance.balance.tables.no_activity') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection