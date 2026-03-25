@extends('layouts.admin')

@section('title', __('admin.finance.subscriptions.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item">{{ __('admin.finance.balance.title') }}</span>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.finance.subscriptions.title') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Subscriptions Professional Styling ----- */

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

        .sh-stat-value.green {
            color: #10b981;
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

        .sh-plan-name {
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            display: block;
        }

        .sh-plan-price {
            font-size: 16px;
            font-weight: 700;
            color: var(--admin-gold);
        }

        /* Status Badges */
        .sh-badge {
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-active {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .status-cancelled {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .status-expired {
            background: rgba(245, 158, 11, 0.15);
            color: #f59e0b;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        /* Actions */
        .sh-actions {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }

        .sh-btn-action {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: transparent;
            color: #fff;
            cursor: pointer;
            transition: all 0.2s;
            padding: 0;
        }

        .sh-btn-action:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .sh-btn-action.cancel:hover {
            background: rgba(239, 68, 68, 0.2);
            border-color: #ef4444;
            color: #ef4444;
        }

        /* Modal */
        .sh-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .sh-modal-overlay.open {
            display: flex;
            opacity: 1;
        }

        .sh-modal-content {
            background: #1a1a1f;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            width: 90%;
            max-width: 800px;
            padding: 32px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        .sh-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding-bottom: 16px;
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

            .sh-modern-table th,
            .sh-modern-table td {
                padding: 12px 14px;
            }

            .sh-modern-table th {
                font-size: 11px;
            }

            /* Hide Dates and Status columns */
            .sh-modern-table th:nth-child(4),
            .sh-modern-table td:nth-child(4),
            .sh-modern-table th:nth-child(5),
            .sh-modern-table td:nth-child(5) {
                display: none;
            }

            .sh-avatar {
                width: 32px;
                height: 32px;
            }

            .sh-user-name {
                font-size: 13px;
            }

            .sh-plan-name {
                font-size: 12px;
            }

            .sh-plan-price {
                font-size: 14px;
            }

            .sh-btn-action {
                width: 28px;
                height: 28px;
                border-radius: 6px;
            }

            .sh-modal-content {
                padding: 24px;
                border-radius: 14px;
            }

            .sh-modal-content div[style*="grid-template-columns: 1fr 1fr"] {
                grid-template-columns: 1fr !important;
                gap: 20px !important;
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

            .sh-modern-table th,
            .sh-modern-table td {
                padding: 10px 12px;
            }

            /* Also hide Model column on very small screens */
            .sh-modern-table th:nth-child(2),
            .sh-modern-table td:nth-child(2) {
                display: none;
            }

            .sh-avatar {
                width: 28px;
                height: 28px;
            }

            .sh-user-name {
                font-size: 12px;
            }

            .sh-modal-content {
                padding: 20px;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Hero -->
    <div class="page-header">
        <h1 class="page-title">{{ __('admin.finance.subscriptions.title') }}</h1>
        <p class="page-subtitle">{{ __('admin.finance.subscriptions.subtitle') }}</p>
    </div>

    <!-- Stats -->
    <div class="sh-stats-grid">
        <div class="sh-stat-card">
            <div class="sh-stat-label">{{ __('admin.finance.subscriptions.stats.total_charged') }}</div>
            <div class="sh-stat-value gold">{{ number_format($stats['total_tokens']) }}</div>
            <div style="font-size: 12px; opacity: 0.5;">{{ __('admin.finance.subscriptions.stats.total_charged_sub') }}</div>
            <i class="fas fa-coins sh-stat-icon"></i>
        </div>
        <div class="sh-stat-card">
            <div class="sh-stat-label">{{ __('admin.finance.subscriptions.stats.active_tokens') }}</div>
            <div class="sh-stat-value green">{{ number_format($stats['active_tokens']) }}</div>
            <div style="font-size: 12px; opacity: 0.5;">{{ __('admin.finance.subscriptions.stats.active_tokens_sub') }}</div>
            <i class="fas fa-check-circle sh-stat-icon"></i>
        </div>
        <div class="sh-stat-card">
            <div class="sh-stat-label">{{ __('admin.finance.subscriptions.stats.monthly_tokens') }}</div>
            <div class="sh-stat-value" style="color: #3b82f6;">{{ number_format($stats['monthly_tokens']) }}</div>
            <div style="font-size: 12px; opacity: 0.5;">{{ now()->format('F Y') }}</div>
            <i class="fas fa-calendar-alt sh-stat-icon"></i>
        </div>
        <div class="sh-stat-card">
            <div class="sh-stat-label">{{ __('admin.finance.subscriptions.stats.cancelled') }}</div>
            <div class="sh-stat-value red">{{ $stats['cancelled'] }}</div>
            <div style="font-size: 12px; opacity: 0.5;">{{ __('admin.finance.subscriptions.stats.cancelled_sub') }}</div>
            <i class="fas fa-times-circle sh-stat-icon"></i>
        </div>
    </div>

    <!-- Filters -->
    <div class="sh-filters-bar">
        <a href="{{ route('admin.finance.subscriptions') }}"
            class="sh-filter-chip {{ !request('status') ? 'active' : '' }}">{{ __('admin.finance.subscriptions.filters.all') }}</a>
        <a href="?status=active" class="sh-filter-chip {{ request('status') == 'active' ? 'active' : '' }}">{{ __('admin.finance.subscriptions.filters.active') }}</a>
        <a href="?status=cancelled"
            class="sh-filter-chip {{ request('status') == 'cancelled' ? 'active' : '' }}">{{ __('admin.finance.subscriptions.filters.cancelled') }}</a>
        <a href="?status=expired" class="sh-filter-chip {{ request('status') == 'expired' ? 'active' : '' }}">{{ __('admin.finance.subscriptions.filters.expired') }}</a>

        <div class="sh-search-container">
            <!-- Search placeholder -->
        </div>
    </div>

    <!-- Table -->
    <div class="sh-table-container">
        <div class="table-responsive">
            <table class="sh-modern-table">
                <thead>
                    <tr>
                        <th>{{ __('admin.finance.subscriptions.table.subscriber') }}</th>
                        <th>{{ __('admin.finance.subscriptions.table.model') }}</th>
                        <th>{{ __('admin.finance.subscriptions.table.cost') }}</th>
                        <th>{{ __('admin.finance.subscriptions.table.status') }}</th>
                        <th>{{ __('admin.finance.subscriptions.table.dates') }}</th>
                        <th style="text-align: right;">{{ __('admin.finance.subscriptions.table.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscriptions as $sub)
                        <tr>
                            <!-- Subscriber -->
                            <td>
                                <div class="sh-user-profile">
                                    <img src="{{ $sub->fan?->profile?->avatar_url ?? asset('images/default-avatar.png') }}"
                                        class="sh-avatar" alt="Fan">
                                    <span class="sh-user-name">{{ $sub->fan->name ?? __('admin.finance.subscriptions.table.deleted_user') }}</span>
                                </div>
                            </td>

                            <!-- Model -->
                            <td>
                                <div class="sh-user-profile">
                                    <img src="{{ $sub->model?->profile?->avatar_url ?? asset('images/default-avatar.png') }}"
                                        class="sh-avatar" style="border-color: var(--admin-gold);" alt="Model">
                                    <span class="sh-user-name">{{ $sub->model->name ?? __('admin.finance.subscriptions.table.deleted_model') }}</span>
                                </div>
                            </td>

                            <!-- Cost in Tokens -->
                            <td>
                                <span class="sh-plan-name">{{ $sub->plan_name ?? 'Mensual Standard' }}</span>
                                <span class="sh-plan-price"><i class="fas fa-coins" style="font-size: 12px; margin-right: 4px;"></i>{{ number_format($sub->amount) }} tokens</span>
                            </td>

                            <!-- Status -->
                            <td>
                                <span class="sh-badge status-{{ $sub->status }}">
                                    {{ ucfirst($sub->status) }}
                                </span>
                            </td>

                            <!-- Dates -->
                            <td>
                                <div style="font-size: 13px; opacity: 0.9;">
                                    {{ $sub->start_date ? $sub->start_date->format('d M, Y') : '-' }}</div>
                                <div style="font-size: 11px; opacity: 0.5;">{{ __('admin.finance.subscriptions.table.renews') }}
                                    {{ $sub->end_date ? $sub->end_date->format('d M') : '-' }}</div>
                            </td>

                            <!-- Actions -->
                            <td>
                                <div class="sh-actions">
                                    <button type="button" class="sh-btn-action"
                                        onclick="openSubDetails({{ json_encode($sub) }})" title="{{ __('admin.finance.subscriptions.table.view_details') }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <!-- Placeholder for Cancel Action -->
                                    @if($sub->status === 'active')
                                        <!-- <button class="sh-btn-action cancel" title="Cancelar"><i class="fas fa-ban"></i></button> -->
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 80px; color: rgba(255,255,255,0.3);">
                                <i class="fas fa-users" style="font-size: 4rem; opacity: 0.1; margin-bottom: 20px;"></i>
                                <br>{{ __('admin.finance.subscriptions.table.no_subs') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($subscriptions->hasPages())
            <div style="padding: 20px; border-top: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: center;">
                {{ $subscriptions->links('custom.pagination') }}
            </div>
        @endif
    </div>

    <!-- Details Modal -->
    <div id="subModal" class="sh-modal-overlay">
        <div class="sh-modal-content">
            <div class="sh-modal-header">
                <h2 style="font-size: 20px; font-weight: 700; color: #fff; margin: 0;">{{ __('admin.finance.subscriptions.modal.title') }}</h2>
                <button onclick="closeSubModal()"
                    style="background: none; border: none; color: #fff; font-size: 20px; cursor: pointer;">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 30px;">
                <div>
                    <div
                        style="font-size: 11px; text-transform: uppercase; color: rgba(255,255,255,0.4); margin-bottom: 8px;">
                        {{ __('admin.finance.subscriptions.modal.fan') }}</div>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img id="modalFanAvatar" src="" style="width: 50px; height: 50px; border-radius: 50%;">
                        <div id="modalFanName" style="font-weight: 700;">-</div>
                    </div>
                </div>
                <div>
                    <div
                        style="font-size: 11px; text-transform: uppercase; color: rgba(255,255,255,0.4); margin-bottom: 8px;">
                        {{ __('admin.finance.subscriptions.modal.model') }}</div>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img id="modalModelAvatar" src=""
                            style="width: 50px; height: 50px; border-radius: 50%; border: 1px solid var(--admin-gold);">
                        <div id="modalModelName" style="font-weight: 700;">-</div>
                    </div>
                </div>
            </div>

            <div style="background: rgba(255,255,255,0.03); border-radius: 12px; padding: 20px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                    <span style="opacity: 0.6;">{{ __('admin.finance.subscriptions.modal.current_plan') }}</span>
                    <span id="modalPlan" style="font-weight: 700;">-</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                    <span style="opacity: 0.6;">{{ __('admin.finance.subscriptions.modal.cost') }}</span>
                    <span id="modalPrice" style="color: var(--admin-gold); font-weight: 700;">-</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="opacity: 0.6;">{{ __('admin.finance.subscriptions.modal.status') }}</span>
                    <span id="modalStatus" style="text-transform: uppercase; font-weight: 700;">-</span>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; margin-top: 30px;">
                <button onclick="closeSubModal()"
                    style="padding: 10px 24px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 8px; cursor: pointer;">{{ __('admin.finance.subscriptions.modal.close') }}</button>
            </div>
        </div>
    </div>

    <script>
        function openSubDetails(sub) {
            document.getElementById('modalFanName').innerText = sub.fan ? sub.fan.name : 'N/A';
            document.getElementById('modalFanAvatar').src = sub.fan?.profile?.avatar_url || '/images/default-avatar.png';

            document.getElementById('modalModelName').innerText = sub.model ? sub.model.name : 'N/A';
            document.getElementById('modalModelAvatar').src = sub.model?.profile?.avatar_url || '/images/default-avatar.png';

            document.getElementById('modalPlan').innerText = sub.plan_name || '{{ __('admin.finance.subscriptions.modal.monthly') }}';
            document.getElementById('modalPrice').innerText = Math.round(parseFloat(sub.amount)).toLocaleString() + ' tokens';
            document.getElementById('modalStatus').innerText = sub.status;

            document.getElementById('subModal').classList.add('open');
        }

        function closeSubModal() {
            document.getElementById('subModal').classList.remove('open');
        }
    </script>
@endsection