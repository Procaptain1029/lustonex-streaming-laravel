@extends('layouts.admin')

@section('title', __('admin.withdrawals.index.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.withdrawals.index.breadcrumb') }}</span>
@endsection

@section('styles')
<style>
    /* ----- Withdrawals Professional Styling ----- */
    
    /* 1. Hero */
    .page-header {
        margin-bottom: 32px;
    }


    /* 2. Stats Grid */
    .sh-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
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

    .sh-stat-value.gold { color: var(--admin-gold); }
    .sh-stat-value.green { color: #10b981; }
    .sh-stat-value.blue { color: #60a5fa; }

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
        border: 1px solid rgba(255,255,255,0.1);
        font-size: 14px;
        font-weight: 500;
        color: rgba(255,255,255,0.6);
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        background: rgba(255,255,255,0.02);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .sh-filter-chip:hover {
        background: rgba(255,255,255,0.05);
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
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
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
        color: rgba(255,255,255,0.4);
    }

    /* 4. Table */
    .sh-table-container {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
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
        border: 1px solid rgba(255,255,255,0.1);
    }

    .sh-user-name {
        font-size: 16px;
        font-weight: 600;
        color: #fff;
        display: block;
    }

    /* Amount */
    .sh-amount {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        font-family: 'Space Grotesk', sans-serif;
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

    .status-pending { background: rgba(251, 191, 36, 0.15); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.2); }
    .status-processing { background: rgba(96, 165, 250, 0.15); color: #60a5fa; border: 1px solid rgba(96, 165, 250, 0.2); }
    .status-completed { background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); }
    .status-rejected { background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); }

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
    
    .sh-btn-action:hover { background: rgba(255,255,255,0.1); }
    .sh-btn-action.approve:hover { background: rgba(16, 185, 129, 0.2); border-color: #10b981; color: #10b981; }
    .sh-btn-action.reject:hover { background: rgba(239, 68, 68, 0.2); border-color: #ef4444; color: #ef4444; }

    /* Modals */
    .sh-modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.8);
        backdrop-filter: blur(5px);
        z-index: 1000;
        display: none;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .sh-modal-overlay.open { display: flex; opacity: 1; }

    .sh-modal-content {
        background: #1a1a1f;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        width: 90%;
        max-width: 500px;
        padding: 32px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    }
    
    .sh-modal-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 24px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        padding-bottom: 16px;
    }
    
    .sh-modal-actions {
        display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;
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

        /* Hide Method, Date columns */
        .sh-modern-table th:nth-child(4),
        .sh-modern-table td:nth-child(4),
        .sh-modern-table th:nth-child(6),
        .sh-modern-table td:nth-child(6) {
            display: none;
        }

        .sh-avatar {
            width: 32px;
            height: 32px;
        }

        .sh-user-name {
            font-size: 13px;
        }

        .sh-amount {
            font-size: 15px;
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

        /* Also hide Net column on very small screens */
        .sh-modern-table th:nth-child(3),
        .sh-modern-table td:nth-child(3) {
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

        .sh-btn-action {
            width: 26px;
            height: 26px;
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
    <h1 class="page-title">{{ __('admin.withdrawals.index.title') }}</h1>
    <p class="page-subtitle">{{ __('admin.withdrawals.index.subtitle') }}</p>
</div>

<!-- Stats -->
<div class="sh-stats-grid">
    <div class="sh-stat-card">
        <div class="sh-stat-label">{{ __('admin.withdrawals.index.stats.pending') }}</div>
        <div class="sh-stat-value gold">{{ $stats['pending'] }}</div>
        <div style="font-size: 12px; opacity: 0.5;"><i class="fas fa-coins" style="font-size: 10px;"></i> {{ number_format($stats['pending_amount']) }} {{ __('admin.withdrawals.index.stats.pending_amount') }}</div>
        <i class="fas fa-clock sh-stat-icon"></i>
    </div>
    <div class="sh-stat-card">
        <div class="sh-stat-label">{{ __('admin.withdrawals.index.stats.processed_today') }}</div>
        <div class="sh-stat-value blue">{{ $stats['completed_today'] }}</div>
        <div style="font-size: 12px; opacity: 0.5;">{{ __('admin.withdrawals.index.stats.processed_today_desc') }}</div>
        <i class="fas fa-check-circle sh-stat-icon"></i>
    </div>
    <div class="sh-stat-card">
        <div class="sh-stat-label">{{ __('admin.withdrawals.index.stats.total_processed') }}</div>
        <div class="sh-stat-value green">{{ number_format($stats['total_processed']) }}</div>
        <div style="font-size: 12px; opacity: 0.5;">{{ __('admin.withdrawals.index.stats.total_processed_desc') }}</div>
        <i class="fas fa-coins sh-stat-icon"></i>
    </div>
</div>

<!-- Filters -->
<div class="sh-filters-bar">
    <a href="{{ route('admin.withdrawals.index') }}" class="sh-filter-chip {{ !request('status') ? 'active' : '' }}">{{ __('admin.withdrawals.index.filters.all') }}</a>
    <a href="?status=pending" class="sh-filter-chip {{ request('status') == 'pending' ? 'active' : '' }}">{{ __('admin.withdrawals.index.filters.pending') }}</a>
    <a href="?status=completed" class="sh-filter-chip {{ request('status') == 'completed' ? 'active' : '' }}">{{ __('admin.withdrawals.index.filters.completed') }}</a>
    <a href="?status=rejected" class="sh-filter-chip {{ request('status') == 'rejected' ? 'active' : '' }}">{{ __('admin.withdrawals.index.filters.rejected') }}</a>
    
    <div class="sh-search-container">
        <!-- Optional Search, sticking to minimal requirement -->
    </div>
</div>

<!-- Table -->
<div class="sh-table-container">
    <div class="table-responsive">
        <table class="sh-modern-table">
            <thead>
                <tr>
                    <th>{{ __('admin.withdrawals.index.table.model') }} </th>
                    <th>{{ __('admin.withdrawals.index.table.tokens') }} </th>
                    <th>{{ __('admin.withdrawals.index.table.net') }}</th>
                    <th>{{ __('admin.withdrawals.index.table.method') }}</th>
                    <th>{{ __('admin.withdrawals.index.table.status') }}</th>
                    <th>{{ __('admin.withdrawals.index.table.date') }}</th>
                    <th style="text-align: right;">{{ __('admin.withdrawals.index.table.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($withdrawals as $withdrawal)
                <tr>
                    <!-- Model -->
                    <td>
                        <div class="sh-user-profile">
                            <img src="{{ $withdrawal->user?->profile?->avatar_url ?? asset('images/default-avatar.png') }}" class="sh-avatar" alt="Model">
                            <span class="sh-user-name">{{ $withdrawal->user->name ?? __('admin.withdrawals.index.table.deleted_user') }}</span>
                        </div>
                    </td>
                    
                    <!-- Amount (Tokens) -->
                    <td>
                        <div class="sh-amount"><i class="fas fa-coins" style="font-size: 13px; margin-right: 4px; color: var(--admin-gold);"></i>{{ number_format($withdrawal->amount) }}</div>
                    </td>
                    
                    <!-- Net Amount (Tokens) -->
                    <td>
                        <div class="sh-amount" style="color: #10b981;"><i class="fas fa-coins" style="font-size: 13px; margin-right: 4px;"></i>{{ number_format($withdrawal->net_amount) }}</div>
                    </td>
                    
                    <!-- Method -->
                    <td>
                        <span style="opacity: 0.9; font-size: 14px;">
                            @if($withdrawal->payment_method == 'paypal') <i class="fab fa-paypal" style="color:#3b82f6"></i> PayPal
                            @elseif($withdrawal->payment_method == 'stripe') <i class="fab fa-stripe" style="color:#6366f1"></i> Stripe
                            @elseif($withdrawal->payment_method == 'crypto') <i class="fab fa-bitcoin" style="color:#f59e0b"></i> Crypto
                            @else <i class="fas fa-university" style="color:#9ca3af"></i> Banco @endif
                        </span>
                    </td>
                    
                    <!-- Status -->
                    <td>
                        <span class="sh-badge status-{{ $withdrawal->status }}">
                            {{ ucfirst($withdrawal->status) }}
                        </span>
                    </td>
                    
                    <!-- Date -->
                    <td>
                        <div style="font-size: 13px; opacity: 0.7;">{{ $withdrawal->created_at->format('d M, Y') }}</div>
                    </td>
                    
                    <!-- Actions -->
                    <td>
                        <div class="sh-actions">
                            <a href="{{ route('admin.withdrawals.show', $withdrawal) }}" class="sh-btn-action" title="{{ __('admin.withdrawals.index.table.action_view') }}">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            @if($withdrawal->status === 'pending')
                            <button type="button" class="sh-btn-action approve" onclick="openApproveModal({{ $withdrawal->id }}, '{{ $withdrawal->user->name ?? __('admin.withdrawals.index.table.deleted_user') }}', '{{ number_format($withdrawal->amount) }}', '{{ number_format($withdrawal->net_amount) }}')" title="{{ __('admin.withdrawals.index.table.action_approve') }}">
                                <i class="fas fa-check"></i>
                            </button>
                            <button type="button" class="sh-btn-action reject" onclick="openRejectModal({{ $withdrawal->id }})" title="{{ __('admin.withdrawals.index.table.action_reject') }}">
                                <i class="fas fa-times"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 80px; color: rgba(255,255,255,0.3);">
                        <i class="fas fa-receipt" style="font-size: 4rem; opacity: 0.1; margin-bottom: 20px;"></i>
                        <br>{{ __('admin.withdrawals.index.table.empty') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($withdrawals->hasPages())
    <div style="padding: 20px; border-top: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: center;">
        {{ $withdrawals->links('custom.pagination') }}
    </div>
    @endif
</div>

<!-- Approve Modal -->
<div id="approveModal" class="sh-modal-overlay">
    <div class="sh-modal-content">
        <form id="approveForm" action="" method="POST">
            @csrf
            <div class="sh-modal-header">
                <h2 style="font-size: 20px; font-weight: 700; color: #fff; margin: 0;">{{ __('admin.withdrawals.index.modal.approve_title') }}</h2>
                <button type="button" onclick="closeApproveModal()" style="background: none; border: none; color: #fff; font-size: 20px; cursor: pointer;"><i class="fas fa-times"></i></button>
            </div>
            
            <p>{{ __('admin.withdrawals.index.modal.approve_desc') }} <strong id="approveUser" style="color: #fff;">-</strong>.</p>
            <div style="background: rgba(16, 185, 129, 0.1); padding: 16px; border-radius: 8px; border: 1px solid rgba(16, 185, 129, 0.2); margin: 20px 0; text-align: center;">
                <span style="font-size: 12px; text-transform: uppercase;">{{ __('admin.withdrawals.index.modal.approve_requested') }}</span>
                <div id="approveTokens" style="font-size: 28px; font-weight: 800; color: var(--admin-gold);">0</div>
                <div style="margin-top: 8px; font-size: 12px; opacity: 0.5;">{{ __('admin.withdrawals.index.modal.approve_net') }}</div>
                <div id="approveNet" style="font-size: 22px; font-weight: 800; color: #10b981;">0</div>
            </div>
            
            <div class="sh-modal-actions">
                <button type="button" onclick="closeApproveModal()" style="padding: 10px 20px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); background: transparent; color: #fff; cursor: pointer;">{{ __('admin.withdrawals.index.modal.cancel') }}</button>
                <button type="submit" style="padding: 10px 20px; border-radius: 8px; border: none; background: #10b981; color: #fff; font-weight: 700; cursor: pointer;">{{ __('admin.withdrawals.index.modal.confirm_approve') }}</button>
            </div>
        </form>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="sh-modal-overlay">
    <div class="sh-modal-content">
        <form id="rejectForm" action="" method="POST">
            @csrf
            <div class="sh-modal-header">
                <h2 style="font-size: 20px; font-weight: 700; color: #fff; margin: 0;">{{ __('admin.withdrawals.index.modal.reject_title') }}</h2>
                <button type="button" onclick="closeRejectModal()" style="background: none; border: none; color: #fff; font-size: 20px; cursor: pointer;"><i class="fas fa-times"></i></button>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 12px; text-transform: uppercase; color: rgba(255,255,255,0.5); font-weight: 700; margin-bottom: 8px;">{{ __('admin.withdrawals.index.modal.reject_reason_label') }}</label>
                <textarea name="rejection_reason" rows="3" style="width: 100%; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 12px; border-radius: 8px;" placeholder="{{ __('admin.withdrawals.index.modal.reject_reason_placeholder') }}" required></textarea>
            </div>
            
            <div class="sh-modal-actions">
                <button type="button" onclick="closeRejectModal()" style="padding: 10px 20px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); background: transparent; color: #fff; cursor: pointer;">{{ __('admin.withdrawals.index.modal.cancel') }}</button>
                <button type="submit" style="padding: 10px 20px; border-radius: 8px; border: none; background: #ef4444; color: #fff; font-weight: 700; cursor: pointer;">{{ __('admin.withdrawals.index.modal.confirm_reject') }}</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openApproveModal(id, user, tokens, net) {
        let form = document.getElementById('approveForm');
        form.action = '/admin/withdrawals/' + id + '/approve';
        
        document.getElementById('approveUser').innerText = user;
        document.getElementById('approveTokens').innerText = tokens + ' tokens';
        document.getElementById('approveNet').innerText = net + ' tokens';
        document.getElementById('approveModal').classList.add('open');
    }

    function closeApproveModal() {
        document.getElementById('approveModal').classList.remove('open');
    }

    function openRejectModal(id) {
        let form = document.getElementById('rejectForm');
        form.action = '/admin/withdrawals/' + id + '/reject';
        
        document.getElementById('rejectModal').classList.add('open');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.remove('open');
    }
</script>
@endsection