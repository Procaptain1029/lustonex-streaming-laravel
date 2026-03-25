@extends('layouts.admin')

@section('title', __('admin.tokens.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.tokens.breadcrumb') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Tokens Professional Styling ----- */

        /* 1. Hero */
        .page-header {
            margin-bottom: 32px;
        }


        /* 2. Stats Grid */
        .sh-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .sh-stat-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 24px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .sh-stat-card:hover {
            background: rgba(255, 255, 255, 0.04);
            transform: translateY(-4px);
        }

        .sh-stat-icon {
            position: absolute;
            right: -10px;
            bottom: -10px;
            font-size: 3.5rem;
            opacity: 0.05;
            transform: rotate(-15deg);
            color: var(--admin-gold);
            pointer-events: none;
        }

        .sh-stat-label {
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.4);
            margin-bottom: 8px;
        }

        .sh-stat-value {
            font-size: 24px;
            font-weight: 800;
            color: #fff;
        }

        .sh-stat-value.gold {
            color: var(--admin-gold);
        }

        .sh-stat-value.blue {
            color: #3b82f6;
        }

        .sh-stat-value.red {
            color: #ef4444;
        }

        /* 3. Filters Bar */
        .sh-filters-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 24px;
            align-items: center;
        }

        .sh-filter-chip {
            padding: 8px 16px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 14px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.6);
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            background: rgba(255, 255, 255, 0.02);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .sh-filter-chip:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        .sh-filter-chip.active {
            background: #fff;
            color: #000;
            border-color: #fff;
            font-weight: 600;
        }

        .sh-search-container {
            flex: 1;
            min-width: 200px;
            position: relative;
            margin-left: auto;
        }

        .sh-search-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 8px 16px 8px 40px;
            color: #fff;
            font-size: 14px;
        }

        .sh-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.4);
        }

        /* 4. Table */
        .sh-table-container {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .sh-card-header {
            padding: 20px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sh-card-title {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sh-modern-table {
            width: 100%;
            border-collapse: collapse;
        }

        .sh-modern-table th {
            padding: 12px 24px;
            text-align: left;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 0.01);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sh-modern-table td {
            padding: 16px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            vertical-align: middle;
            color: #fff;
            font-size: 14px;
        }

        .sh-modern-table tr:hover td {
            background: rgba(255, 255, 255, 0.03);
        }

        /* User Columns */
        .sh-user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sh-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sh-user-name {
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            display: block;
        }

        .sh-transaction-desc {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.6);
        }

        /* Token Values */
        .sh-token-value {
            font-size: 18px;
            font-weight: 700;
            font-family: 'Space Grotesk', sans-serif;
        }

        .sh-token-plus {
            color: #10b981;
        }

        .sh-token-minus {
            color: #ef4444;
        }

        /* Type Badges */
        .sh-badge {
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .type-purchase {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .type-spent {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .type-earned {
            background: rgba(59, 130, 246, 0.15);
            color: #3b82f6;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .type-refund {
            background: rgba(251, 191, 36, 0.15);
            color: #fbbf24;
            border: 1px solid rgba(251, 191, 36, 0.2);
        }

        /* Layout */
        .sh-dashboard-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }

        /* Leaderboard */
        .sh-rank {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: 800;
            font-size: 12px;
            background: rgba(255, 255, 255, 0.1);
        }

        .sh-rank-1 {
            background: var(--admin-gold);
            color: #000;
            box-shadow: 0 0 10px rgba(212, 175, 55, 0.4);
        }

        .sh-rank-2 {
            background: #e2e8f0;
            color: #000;
        }

        .sh-rank-3 {
            background: #b45309;
            color: #fff;
        }

        @media (max-width: 1200px) {
            .sh-dashboard-layout {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .page-header {
                margin-bottom: 20px;
            }


            .sh-stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
                margin-bottom: 24px;
            }

            .sh-stat-card {
                padding: 16px;
                border-radius: 14px;
            }

            .sh-stat-value {
                font-size: 20px;
            }

            .sh-stat-label {
                font-size: 11px;
            }

            .sh-filters-bar {
                gap: 8px;
                margin-bottom: 20px;
            }

            .sh-filter-chip {
                padding: 6px 14px;
                font-size: 13px;
            }

            .sh-table-container {
                border-radius: 12px;
            }

            .sh-card-header {
                padding: 16px 18px;
            }

            .sh-card-title {
                font-size: 14px;
            }

            .sh-modern-table th,
            .sh-modern-table td {
                padding: 12px 14px;
            }

            .sh-modern-table th {
                font-size: 11px;
            }

            /* Hide Description column in transactions table */
            .sh-dashboard-layout > .sh-table-container:first-child .sh-modern-table th:nth-child(4),
            .sh-dashboard-layout > .sh-table-container:first-child .sh-modern-table td:nth-child(4) {
                display: none;
            }

            .sh-avatar {
                width: 32px;
                height: 32px;
            }

            .sh-user-name {
                font-size: 13px;
            }

            .sh-token-value {
                font-size: 15px;
            }

            .sh-rank {
                width: 24px;
                height: 24px;
                font-size: 11px;
            }
        }

        @media (max-width: 480px) {
            .sh-stats-grid {

                gap: 10px;
            }

            .sh-stat-card {
                padding: 14px;
                border-radius: 12px;
            }

            .sh-stat-value {
                font-size: 18px;
            }

            .sh-filter-chip {
                padding: 5px 12px;
                font-size: 12px;
                border-radius: 16px;
            }

            .sh-table-container {
                border-radius: 10px;
            }

            .sh-card-header {
                padding: 14px 16px;
            }

            .sh-card-title {
                font-size: 13px;
            }

            .sh-modern-table th,
            .sh-modern-table td {
                padding: 10px 12px;
            }

            /* Also hide Type column on very small screens */
            .sh-dashboard-layout > .sh-table-container:first-child .sh-modern-table th:nth-child(2),
            .sh-dashboard-layout > .sh-table-container:first-child .sh-modern-table td:nth-child(2) {
                display: none;
            }

            .sh-avatar {
                width: 28px;
                height: 28px;
            }

            .sh-user-name {
                font-size: 12px;
            }

            .sh-token-value {
                font-size: 14px;
            }

            .sh-transaction-desc {
                font-size: 12px;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Hero -->
    <div class="page-header">
        <h1 class="page-title">{{ __('admin.tokens.header') }}</h1>
        <p class="page-subtitle">{{ __('admin.tokens.subtitle') }}</p>
    </div>

    <!-- Stats -->
    <div class="sh-stats-grid">
        <div class="sh-stat-card">
            <div class="sh-stat-label">{{ __('admin.tokens.stats.total_sales') }}</div>
            <div class="sh-stat-value gold">{{ number_format($stats['total_purchased']) }}</div>
            <div style="font-size: 12px; opacity: 0.5;">{{ __('admin.tokens.stats.purchased_desc') }}</div>
            <i class="fas fa-coins sh-stat-icon"></i>
        </div>
        <div class="sh-stat-card">
            <div class="sh-stat-label">{{ __('admin.tokens.stats.in_circulation') }}</div>
            <div class="sh-stat-value blue">{{ number_format($stats['total_earned']) }}</div>
            <div style="font-size: 12px; opacity: 0.5;">{{ __('admin.tokens.stats.earned_desc') }}</div>
            <i class="fas fa-sync-alt sh-stat-icon"></i>
        </div>
        <div class="sh-stat-card">
            <div class="sh-stat-label">{{ __('admin.tokens.stats.total_spent') }}</div>
            <div class="sh-stat-value red">{{ number_format($stats['total_spent']) }}</div>
            <div style="font-size: 12px; opacity: 0.5;">{{ __('admin.tokens.stats.spent_desc') }}</div>
            <i class="fas fa-shopping-cart sh-stat-icon"></i>
        </div>
        <div class="sh-stat-card">
            <div class="sh-stat-label">{{ __('admin.tokens.stats.active_users') }}</div>
            <div class="sh-stat-value">{{ number_format($stats['active_users']) }}</div>
            <div style="font-size: 12px; opacity: 0.5;">{{ __('admin.tokens.stats.users_desc') }}</div>
            <i class="fas fa-users sh-stat-icon"></i>
        </div>
    </div>

    <!-- Filters -->
    <div class="sh-filters-bar">
        <a href="{{ route('admin.tokens.index') }}" class="sh-filter-chip {{ !request('type') ? 'active' : '' }}">{{ __('admin.tokens.filters.all') }}</a>
        <a href="?type=purchase" class="sh-filter-chip {{ request('type') == 'purchase' ? 'active' : '' }}">{{ __('admin.tokens.filters.purchases') }}</a>
        <a href="?type=spent" class="sh-filter-chip {{ request('type') == 'spent' ? 'active' : '' }}">{{ __('admin.tokens.filters.spent') }}</a>
        <a href="?type=earned" class="sh-filter-chip {{ request('type') == 'earned' ? 'active' : '' }}">{{ __('admin.tokens.filters.earned') }}</a>
        <a href="?type=refund" class="sh-filter-chip {{ request('type') == 'refund' ? 'active' : '' }}">{{ __('admin.tokens.filters.refund') }}</a>

        <div class="sh-search-container">
            <!-- Optional Search -->
        </div>
    </div>

    <div class="sh-dashboard-layout">
        <!-- Transactions Table -->
        <div class="sh-table-container">
            <div class="sh-card-header">
                <h3 class="sh-card-title"><i class="fas fa-list-alt"></i> {{ __('admin.tokens.table.title') }}</h3>
            </div>
            <div class="table-responsive">
                <table class="sh-modern-table">
                    <thead>
                        <tr>
                            <th>{{ __('admin.tokens.table.user') }}</th>
                            <th>{{ __('admin.tokens.table.type') }}</th>
                            <th>{{ __('admin.tokens.table.amount') }}</th>
                            <th>{{ __('admin.tokens.table.concept') }}</th>
                            <th style="text-align: right;">{{ __('admin.tokens.table.date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <!-- User -->
                                <td>
                                    <div class="sh-user-profile">
                                        <img src="{{ $transaction->user?->profile?->avatar_url ?? asset('images/default-avatar.png') }}"
                                            class="sh-avatar" alt="User">
                                        <span class="sh-user-name">{{ $transaction->user->name ?? __('admin.tokens.table.deleted_user') }}</span>
                                    </div>
                                </td>

                                <!-- Type -->
                                <td>
                                    <span class="sh-badge type-{{ $transaction->type }}">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                </td>

                                <!-- Amount -->
                                <td>
                                    @php $isPositive = in_array($transaction->type, ['purchase', 'earned', 'refund']); @endphp
                                    <span class="sh-token-value {{ $isPositive ? 'sh-token-plus' : 'sh-token-minus' }}">
                                        {{ $isPositive ? '+' : '-' }}{{ number_format($transaction->amount) }}
                                    </span>
                                </td>

                                <!-- Description -->
                                <td>
                                    <span class="sh-transaction-desc" title="{{ $transaction->description }}">
                                        {{ Str::limit($transaction->description ?? __('admin.tokens.table.internal_movement'), 35) }}
                                    </span>
                                </td>

                                <!-- Date -->
                                <td style="text-align: right;">
                                    <div style="font-size: 13px; opacity: 0.8;">{{ $transaction->created_at->format('d M') }}
                                    </div>
                                    <div style="font-size: 11px; opacity: 0.5;">{{ $transaction->created_at->format('H:i') }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 60px; color: rgba(255,255,255,0.3);">
                                    <i class="fas fa-exchange-alt"
                                        style="font-size: 3rem; opacity: 0.1; margin-bottom: 20px;"></i>
                                    <br>{{ __('admin.tokens.table.empty') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($transactions->hasPages())
                <div
                    style="padding: 20px; border-top: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: center;">
                    {{ $transactions->links('custom.pagination') }}
                </div>
            @endif
        </div>

        <!-- Leaderboard (Sidebar) -->
        <div class="sh-table-container" style="height: fit-content;">
            <div class="sh-card-header">
                <h3 class="sh-card-title"><i class="fas fa-crown"></i> {{ __('admin.tokens.leaderboard.title') }}</h3>
            </div>
            <div class="table-responsive">
                <table class="sh-modern-table">
                    <thead>
                        <tr>
                            <th style="width: 40px;">#</th>
                            <th>{{ __('admin.tokens.leaderboard.user') }}</th>
                            <th style="text-align: right;">{{ __('admin.tokens.leaderboard.tokens') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topUsers as $index => $user)
                            <tr>
                                <td>
                                    <div class="sh-rank sh-rank-{{ $index + 1 }}">{{ $index + 1 }}</div>
                                </td>
                                <td>
                                    <div class="sh-user-profile">
                                        <img src="{{ $user->profile?->avatar_url ?? asset('images/default-avatar.png') }}"
                                            class="sh-avatar" style="width: 30px; height: 30px;" alt="User">
                                        <span class="sh-user-name"
                                            style="font-size: 14px;">{{ Str::limit($user->name, 15) }}</span>
                                    </div>
                                </td>
                                <td style="text-align: right;">
                                    <span class="sh-token-value sh-token-plus"
                                        style="font-size: 14px;">{{ number_format($user->tokens) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align: center; padding: 20px;">{{ __('admin.tokens.leaderboard.empty') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection