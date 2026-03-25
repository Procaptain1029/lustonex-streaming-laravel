@extends('layouts.admin')

@section('title', 'Gestionar Propinas')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item">{{ __('admin.finance.balance.title') }}</span>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.finance.tips.title') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Tips Professional Styling ----- */

        /* 1. Hero */
        .page-header {
            margin-bottom: 32px;
        }


        /* Stats Grid */
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

        /* 2. Filter Chips */
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

        /* 3. Table */
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
            background: rgba(255, 255, 255, 0.03);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: rgba(255, 255, 255, 0.4);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sh-modern-table td {
            padding: 16px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            vertical-align: middle;
            color: #fff;
            font-size: 14px;
            transition: background 0.2s ease-out;
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

        .sh-user-role {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.5);
        }

        /* Amount */
        .sh-amount {
            font-size: 18px;
            font-weight: 700;
            color: var(--admin-gold);
            font-family: 'Space Grotesk', sans-serif;
            /* If used */
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

        .status-completed {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
        }

        .status-pending {
            background: rgba(251, 191, 36, 0.15);
            color: #fbbf24;
        }

        .status-failed {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
        }

        /* Actions */
        .sh-btn-icon {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            background: transparent;
            color: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            cursor: pointer;
            transition: all 0.2s;
            font-size: 12px;
        }

        .sh-btn-icon:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            transform: scale(1.05);
        }

        /* Pagination Override */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 0;
        }

        /* Modal Styling */
        .sh-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(8px);
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
            max-width: 600px;
            padding: 32px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            transform: translateY(20px);
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .sh-modal-overlay.open .sh-modal-content {
            transform: translateY(0);
        }

        .sh-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding-bottom: 16px;
        }

        .sh-detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
        }

        .sh-detail-label {
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            font-size: 11px;
            font-weight: 700;
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

            .sh-search-container {
                min-width: 100%;
                margin-left: 0;
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

            /* Hide Date and Status columns */
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

            .sh-user-role {
                font-size: 11px;
            }

            .sh-amount {
                font-size: 15px;
            }

            .sh-btn-icon {
                width: 26px;
                height: 26px;
            }

            .sh-modal-content {
                padding: 24px;
                border-radius: 14px;
            }

            .sh-modal-content div[style*="grid-template-columns: 1fr 1fr"] {
                grid-template-columns: 1fr !important;
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

            .sh-amount {
                font-size: 14px;
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
        <h1 class="page-title">{{ __('admin.finance.tips.title') }}</h1>
        <p class="page-subtitle">{{ __('admin.finance.tips.subtitle') }}</p>
    </div>

    <!-- Stats -->
    <div class="sh-stats-grid">
        <div class="sh-stat-card">
            <div class="sh-stat-label">{{ __('admin.finance.tips.stats.total_tokens') }}</div>
            <div class="sh-stat-value gold">{{ number_format($stats['total_tokens']) }}</div>
            <div style="font-size: 12px; opacity: 0.5;">{{ __('admin.finance.tips.stats.total_tokens_sub') }}</div>
            <i class="fas fa-coins sh-stat-icon"></i>
        </div>
        <div class="sh-stat-card">
            <div class="sh-stat-label">Promedio por Propina</div>
            <div class="sh-stat-value">{{ number_format($stats['average_tokens'] ?? 0) }}</div>
            <div style="font-size: 12px; opacity: 0.5;">Tokens promedio</div>
            <i class="fas fa-chart-line sh-stat-icon"></i>
        </div>
        <div class="sh-stat-card">
            <div class="sh-stat-label">{{ __('admin.finance.tips.stats.monthly_tokens') }}</div>
            <div class="sh-stat-value" style="color: #3b82f6;">{{ number_format($stats['monthly_tokens']) }}</div>
            <div style="font-size: 12px; opacity: 0.5;">{{ now()->format('F Y') }}</div>
            <i class="fas fa-calendar-alt sh-stat-icon"></i>
        </div>
        <div class="sh-stat-card">
            <div class="sh-stat-label">Completadas</div>
            <div class="sh-stat-value green">{{ $stats['completed'] }}</div>
            <i class="fas fa-check-circle sh-stat-icon"></i>
        </div>
        <div class="sh-stat-card">
            <div class="sh-stat-label">Pendientes</div>
            <div class="sh-stat-value" style="color: #fbbf24;">{{ $stats['pending'] }}</div>
            <i class="fas fa-hourglass-half sh-stat-icon"></i>
        </div>
    </div>

    <!-- Filters -->
    <div class="sh-filters-bar">
        <a href="{{ route('admin.finance.tips') }}"
            class="sh-filter-chip {{ !request('status') ? 'active' : '' }}">{{ __('admin.finance.tips.filters.all') }}</a>
        <a href="?status=completed"
            class="sh-filter-chip {{ request('status') == 'completed' ? 'active' : '' }}">{{ __('admin.finance.tips.filters.completed') }}</a>
        <a href="?status=pending" class="sh-filter-chip {{ request('status') == 'pending' ? 'active' : '' }}">{{ __('admin.finance.tips.filters.pending') }}</a>
        <a href="?status=failed" class="sh-filter-chip {{ request('status') == 'failed' ? 'active' : '' }}">{{ __('admin.finance.tips.filters.failed') }}</a>

        <form class="sh-search-container" method="GET">
            <i class="fas fa-search sh-search-icon"></i>
            <input type="text" name="search" class="sh-search-input" placeholder="{{ __('admin.finance.tips.filters.search') }}"
                value="{{ request('search') }}">
        </form>
    </div>

    <!-- Table -->
    <div class="sh-table-container">
        <div class="table-responsive">
            <table class="sh-modern-table">
                <thead>
                    <tr>
                        <th>{{ __('admin.finance.tips.table.sender') }}</th>
                        <th>{{ __('admin.finance.tips.table.receiver') }}</th>
                        <th>{{ __('admin.finance.tips.table.tokens') }}</th>
                        <th>{{ __('admin.finance.tips.table.status') }}</th>
                        <th>{{ __('admin.finance.tips.table.date') }}</th>
                        <th style="text-align: right;">{{ __('admin.finance.tips.table.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tips as $tip)
                        <tr>
                            <!-- Sender -->
                            <td>
                                <div class="sh-user-profile">
                                    <img src="{{ $tip->sender?->profile?->avatar_url ?? asset('images/default-avatar.png') }}"
                                        class="sh-avatar" alt="Sender">
                                    <div>
                                        <span class="sh-user-name">{{ $tip->sender->name ?? __('admin.finance.tips.table.deleted_user') }}</span>
                                        <span class="sh-user-role">{{ __('admin.finance.tips.table.fan_role') }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Receiver -->
                            <td>
                                <div class="sh-user-profile">
                                    <img src="{{ $tip->receiver?->profile?->avatar_url ?? asset('images/default-avatar.png') }}"
                                        class="sh-avatar" style="border-color: var(--admin-gold);" alt="Receiver">
                                    <div>
                                        <span class="sh-user-name">{{ $tip->receiver->name ?? __('admin.finance.tips.table.deleted_model') }}</span>
                                        <span class="sh-user-role" style="color: var(--admin-gold);">{{ __('admin.finance.tips.table.model_role') }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Tokens -->
                            <td>
                                <div class="sh-amount"><i class="fas fa-coins" style="font-size: 13px; margin-right: 4px;"></i>{{ number_format($tip->amount) }}</div>
                            </td>

                            <!-- Status -->
                            <td>
                                <span class="sh-badge status-{{ $tip->status }}">
                                    {{ ucfirst($tip->status) }}
                                </span>
                            </td>

                            <!-- Date -->
                            <td>
                                <div style="font-size: 14px; opacity: 0.75;">{{ $tip->created_at->format('d M, Y') }}</div>
                                <div style="font-size: 12px; opacity: 0.5;">{{ $tip->created_at->format('H:i') }}</div>
                            </td>

                            <!-- Actions -->
                            <td>
                                <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                    <button type="button" class="sh-btn-icon" onclick="openTipDetails({{ json_encode($tip) }})"
                                        title="Ver Detalles">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <!-- Placeholder Context Action -->
                                    @if($tip->status === 'completed')
                                        <!-- <button class="sh-btn-icon" title="Revertir" style="color: #ef4444; border-color: rgba(239,68,68,0.3);"><i class="fas fa-undo"></i></button> -->
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 80px; color: rgba(255,255,255,0.3);">
                                <i class="fas fa-hand-holding-usd"
                                    style="font-size: 4rem; opacity: 0.1; margin-bottom: 20px;"></i>
                                <br>{{ __('admin.finance.tips.table.no_tips') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tips->hasPages())
            <div style="padding: 20px; border-top: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: center;">
                {{ $tips->links('custom.pagination') }}
            </div>
        @endif
    </div>

    <!-- Details Modal -->
    <div id="tipModal" class="sh-modal-overlay">
        <div class="sh-modal-content">
            <div class="sh-modal-header">
                <h2 style="font-size: 20px; font-weight: 700; color: #fff; margin: 0;">Detalle de Transacción</h2>
                <button onclick="closeTipModal()"
                    style="background: none; border: none; color: #fff; font-size: 20px; cursor: pointer;">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div style="text-align: center; margin-bottom: 30px;">
                <div style="font-size: 12px; opacity: 0.5; text-transform: uppercase; margin-bottom: 5px;">Tokens Enviados</div>
                <div id="modalAmount" style="font-size: 32px; font-weight: 800; color: var(--admin-gold);">0</div>
                <div id="modalStatus"
                    style="display: inline-block; margin-top: 10px; padding: 4px 12px; border-radius: 20px; background: rgba(255,255,255,0.1); font-size: 12px; font-weight: 700;">
                    STATUS</div>
            </div>

            <div class="sh-detail-row">
                <span class="sh-detail-label">ID Transacción</span>
                <span id="modalId" style="font-family: monospace;">#</span>
            </div>
            <div class="sh-detail-row">
                <span class="sh-detail-label">Fecha</span>
                <span id="modalDate">-</span>
            </div>
            <div class="sh-detail-row">
                <span class="sh-detail-label">Mensaje Adjunto</span>
                <span id="modalMessage"
                    style="font-style: italic; opacity: 0.7; max-width: 200px; text-align: right;">-</span>
            </div>

            <div style="border-top: 1px solid rgba(255,255,255,0.1); margin: 20px 0; padding-top: 20px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <div class="sh-detail-label" style="margin-bottom: 8px;">De (Fan)</div>
                        <div id="modalSender" style="font-weight: 700;">-</div>
                    </div>
                    <div style="text-align: right;">
                        <div class="sh-detail-label" style="margin-bottom: 8px;">Para (Modelo)</div>
                        <div id="modalReceiver" style="font-weight: 700;">-</div>
                    </div>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; margin-top: 30px;">
                <button onclick="closeTipModal()"
                    style="padding: 10px 24px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 8px; cursor: pointer;">Cerrar</button>
            </div>
        </div>
    </div>

    <script>
        function openTipDetails(tip) {
            document.getElementById('modalAmount').innerText = Math.round(parseFloat(tip.amount)).toLocaleString() + ' tokens';
            document.getElementById('modalId').innerText = '#' + tip.id;
            document.getElementById('modalStatus').innerText = tip.status.toUpperCase();
            document.getElementById('modalDate').innerText = new Date(tip.created_at).toLocaleDateString();
            document.getElementById('modalMessage').innerText = tip.message || 'Sin mensaje';

            document.getElementById('modalSender').innerText = tip.sender ? tip.sender.name : 'Usuario Eliminado';
            document.getElementById('modalReceiver').innerText = tip.receiver ? tip.receiver.name : 'Modelo Eliminada';

            document.getElementById('tipModal').classList.add('open');
        }

        function closeTipModal() {
            document.getElementById('tipModal').classList.remove('open');
        }
    </script>
@endsection