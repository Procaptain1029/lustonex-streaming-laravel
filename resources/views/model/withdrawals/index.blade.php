@extends('layouts.model')

@section('title', __('model.withdrawals.index.title'))

@section('breadcrumb')
    <a href="{{ route('model.dashboard') }}" class="breadcrumb-item">Dashboard</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('model.withdrawals.index.breadcrumb') }}</span>
@endsection



@section('content')
<style>
    /* --- STABILITY & CONTAINER CONTROL --- */
    #withdrawals-view.withdrawals-container,
    #withdrawals-view * {
        box-sizing: border-box !important;
        max-width: 100% !important;
    }

    #withdrawals-view.withdrawals-container {
        width: 100% !important;
        padding: 1.5rem 1rem;
        margin: 0 auto;
        overflow-x: hidden !important;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        color: #fff;
    }

    /* --- PAGE HEADER --- */
    #withdrawals-view .page-header {
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    /* Estilos de encabezado heredados del layout model */

    #withdrawals-view .header-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* --- BUTTONS --- */
    #withdrawals-view .sh-btn {
        padding: 12px 20px;
        font-size: 0.95rem;
        font-weight: 700;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        justify-content: center;
    }

    #withdrawals-view .sh-btn-primary {
        background: #d4af37;
        color: #000;
    }

    #withdrawals-view .sh-btn-secondary {
        background: rgba(255,255,255,0.08);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.1);
    }

    #withdrawals-view .sh-btn:hover {
        transform: translateY(-2px);
        filter: brightness(1.1);
    }

    /* --- INFO BANNER --- */
    #withdrawals-view .sh-info-banner {
        background: rgba(212, 175, 55, 0.08);
        border: 1px solid rgba(212, 175, 55, 0.25);
        border-radius: 16px;
        padding: 1.25rem;
        margin-bottom: 2.5rem;
        display: flex;
        gap: 1rem;
        align-items: flex-start;
        width: 100% !important;
    }

    #withdrawals-view .sh-info-icon {
        font-size: 1.5rem;
        color: #d4af37;
        padding-top: 2px;
    }

    #withdrawals-view .sh-info-content {
        font-size: 0.95rem;
        line-height: 1.6;
        color: rgba(255,255,255,0.9);
        word-break: break-word;
    }

    #withdrawals-view .sh-info-content strong {
        color: #d4af37;
    }

    /* --- STATS GRID --- */
    #withdrawals-view .sh-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    #withdrawals-view .sh-stat-card {
        background: #1a1a1a;
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 20px;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    #withdrawals-view .sh-stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    #withdrawals-view .sh-stat-label {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: rgba(255,255,255,0.5);
        font-weight: 700;
    }

    #withdrawals-view .sh-stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    #withdrawals-view .sh-stat-value {
        font-size: 2.5rem;
        font-weight: 900;
        line-height: 1;
        margin: 0;
    }

    #withdrawals-view .sh-stat-sub {
        font-size: 1rem;
        color: rgba(255,255,255,0.4);
        font-weight: 500;
    }

    /* --- TABLE CARD --- */
    #withdrawals-view .sh-table-card {
        background: #1a1a1a;
        border-radius: 20px;
        border: 1px solid rgba(255,255,255,0.05);
        overflow: hidden;
    }

    #withdrawals-view .sh-table-header {
        padding: 1.5rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    #withdrawals-view .sh-table-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    #withdrawals-view .sh-table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    #withdrawals-view .sh-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }

    #withdrawals-view .sh-table th,
    #withdrawals-view .sh-table td {
        padding: 1.25rem 1.5rem;
        text-align: left;
    }

    #withdrawals-view .sh-table th {
        font-size: 0.8rem;
        text-transform: uppercase;
        color: rgba(255,255,255,0.4);
        font-weight: 800;
        background: rgba(255,255,255,0.02);
    }

    #withdrawals-view .sh-status-badge {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
    }

    .status-pending { background: rgba(255, 193, 7, 0.1); color: #ffc107; border: 1px solid rgba(255, 193, 7, 0.2); }
    .status-completed { background: rgba(76, 209, 55, 0.1); color: #4cd137; border: 1px solid rgba(76, 209, 55, 0.2); }
    .status-rejected { background: rgba(232, 65, 24, 0.1); color: #e84118; border: 1px solid rgba(232, 65, 24, 0.2); }

    /* --- MOBILE OPTIMIZATIONS --- */
    @media (max-width: 768px) {
        #withdrawals-view.withdrawals-container {
            padding: 1rem 0.6rem !important;
        }

        #withdrawals-view .page-header {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 1rem !important;
            margin-bottom: 1.5rem !important;
        }

        /* Estilos responsivos de encabezado heredados */

        #withdrawals-view .header-actions {
            width: 100% !important;
            flex-direction: column !important;
            gap: 0.5rem !important;
        }

        #withdrawals-view .sh-btn {
            width: 100% !important;
            padding: 10px 15px !important;
        }

        #withdrawals-view .sh-info-banner {
            flex-direction: column !important;
            padding: 1rem !important;
            gap: 0.75rem !important;
            margin-bottom: 1.5rem !important;
        }

        #withdrawals-view .sh-info-icon {
            font-size: 1.25rem !important;
        }

        #withdrawals-view .sh-info-content {
            font-size: 0.85rem !important;
            line-height: 1.5 !important;
        }

        /* Compact stats grid */
        #withdrawals-view .sh-stats-grid {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 0.75rem !important;
            margin-bottom: 2rem !important;
        }

        #withdrawals-view .sh-stat-card {
            width: 100% !important;
            padding: 1rem !important;
            flex: none !important;
            min-width: 0 !important;
        }
        
        #withdrawals-view .sh-stat-card:last-child {
            grid-column: span 2;
        }

        #withdrawals-view .sh-stat-label {
            font-size: 0.65rem !important;
        }

        #withdrawals-view .sh-stat-icon {
            width: 32px !important;
            height: 32px !important;
            font-size: 0.9rem !important;
        }

        #withdrawals-view .sh-stat-value {
            font-size: 1.35rem !important;
        }

        #withdrawals-view .sh-stat-sub {
            font-size: 0.75rem !important;
        }

        /* Estilos responsivos heredados */

        /* Card Transform FOR REAL */
        #withdrawals-view .sh-table-responsive {
            background: transparent !important;
            overflow: hidden !important;
            width: 100% !important;
        }

        #withdrawals-view .sh-table, 
        #withdrawals-view .sh-table thead, 
        #withdrawals-view .sh-table tbody, 
        #withdrawals-view .sh-table tr, 
        #withdrawals-view .sh-table td {
            display: block !important;
            width: 100% !important;
            min-width: 0 !important; /* CRITICAL: removes the desktop 800px min-width */
            box-sizing: border-box !important;
        }

        #withdrawals-view .sh-table thead { display: none !important; }

        #withdrawals-view .sh-table tr {
            margin-bottom: 1rem !important;
            padding: 0.75rem !important;
            background: #1a1a1a !important;
            border-radius: 12px !important;
            border: 1px solid rgba(255,255,255,0.08) !important;
        }

        #withdrawals-view .sh-table td {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            padding: 0.5rem 0 !important;
            border-bottom: 1px solid rgba(255,255,255,0.03) !important;
            text-align: right !important;
        }

        #withdrawals-view .sh-table td::before {
            content: attr(data-label);
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.65rem;
            color: rgba(255,255,255,0.3);
            text-align: left;
            margin-right: 1rem;
        }

        #withdrawals-view .sh-table td:last-child { border: none !important; padding-bottom: 0 !important; }
        #withdrawals-view .sh-table td:first-child { padding-top: 0 !important; }
    }
</style>
<div id="withdrawals-view" class="withdrawals-container">
    <div class="page-header">
        <div>
            <h1 class="page-title">{{ __('model.withdrawals.index.title') }}</h1>
            <p class="page-subtitle">{{ __('model.withdrawals.index.subtitle') }}</p>
        </div>
        <div class="header-actions">
            {{-- <a href="{{ route('model.withdrawals.export') }}" class="sh-btn sh-btn-secondary">
                <i class="fas fa-file-csv"></i> {{ __('model.earnings.filters.export_csv') }}
            </a> --}}
            <a href="{{ route('model.withdrawals.create') }}" class="sh-btn sh-btn-primary">
                <i class="fas fa-plus"></i> {{ __('model.withdrawals.index.btn_request') }}
            </a>
        </div>
    </div>

    <div class="sh-info-banner">
        <div class="sh-info-icon"><i class="fas fa-info-circle"></i></div>
        <div class="sh-info-content">
            <strong>{{ __('model.withdrawals.index.info_title') }}</strong><br>
            {{ __('model.withdrawals.index.info_commission') }}: <strong>{{ $stats['commission_rate'] }}%</strong> • {{ __('model.withdrawals.index.info_minimum') }}: <strong>${{ number_format($stats['minimum_withdrawal'], 2) }}</strong> • {{ __('model.withdrawals.index.info_rate') }}: <strong>1 Token = ${{ number_format($stats['token_usd_rate'], 2) }} USD</strong>
        </div>
    </div>

    <div class="sh-stats-grid">
        <!-- Saldo Disponible -->
        <div class="sh-stat-card">
            <div class="sh-stat-header">
                <div class="sh-stat-label">{{ __('model.withdrawals.index.stats.available') }}</div>
                <div class="sh-stat-icon" style="background: rgba(76, 209, 55, 0.15); color: #4cd137;">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
            <div>
                <h2 class="sh-stat-value" style="color: #4cd137;">{{ number_format($stats['available_balance']) }} <span style="font-size: 1rem; opacity: 0.6;">Tk</span></h2>
                <div class="sh-stat-sub">≈ ${{ number_format($stats['available_balance'] * $stats['token_usd_rate'], 2) }} USD</div>
            </div>
        </div>

        <!-- En Proceso -->
        <div class="sh-stat-card">
            <div class="sh-stat-header">
                <div class="sh-stat-label">{{ __('model.withdrawals.index.stats.pending') }}</div>
                <div class="sh-stat-icon" style="background: rgba(255, 193, 7, 0.15); color: #ffc107;">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <div>
                <h2 class="sh-stat-value" style="color: #ffc107;">{{ number_format($stats['pending_balance']) }} <span style="font-size: 1rem; opacity: 0.6;">Tk</span></h2>
                <div class="sh-stat-sub">≈ ${{ number_format($stats['pending_balance'] * $stats['token_usd_rate'], 2) }} USD</div>
            </div>
        </div>

        <!-- Total Retirado -->
        <div class="sh-stat-card">
            <div class="sh-stat-header">
                <div class="sh-stat-label">{{ __('model.withdrawals.index.stats.total') }}</div>
                <div class="sh-stat-icon" style="background: rgba(13, 202, 240, 0.15); color: #0dcaf0;">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div>
                <h2 class="sh-stat-value" style="color: #0dcaf0;">{{ number_format($stats['total_withdrawn']) }} <span style="font-size: 1rem; opacity: 0.6;">Tk</span></h2>
                <div class="sh-stat-sub">≈ ${{ number_format($stats['total_withdrawn'] * $stats['token_usd_rate'], 2) }} USD</div>
            </div>
        </div>
    </div>

    <div class="sh-table-card">
        <div class="sh-table-header">
            <h3 class="sh-table-title" style="color: #dfc04e;"> {{ __('model.withdrawals.index.table.title') }}</h3>
        </div>
        <div class="sh-table-responsive">
            <table class="sh-table">
                <thead>
                    <tr>
                        <th>{{ __('model.withdrawals.index.table.date') }}</th>
                        <th>{{ __('model.withdrawals.index.table.amount') }}</th>
                        <th>{{ __('model.withdrawals.index.table.commission') }}</th>
                        <th>{{ __('model.withdrawals.index.table.net') }}</th>
                        <th>{{ __('model.withdrawals.index.table.method') }}</th>
                        <th>{{ __('model.withdrawals.index.table.status') }}</th>
                        <th>{{ __('model.withdrawals.index.table.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($withdrawals as $withdrawal)
                    <tr>
                        <td data-label="{{ __('model.withdrawals.index.table.date') }}">{{ $withdrawal->created_at->format('d M, Y - H:i') }}</td>
                        <td data-label="{{ __('model.withdrawals.index.table.amount') }}" style="font-weight: 700;">{{ number_format($withdrawal->amount) }} Tk</td>
                        <td data-label="{{ __('model.withdrawals.index.table.commission') }}" style="color: #e84118;">-{{ number_format($withdrawal->fee) }} Tk</td>
                        <td data-label="{{ __('model.withdrawals.index.table.net') }}" style="color: #4cd137; font-weight: 700;">${{ number_format(($withdrawal->net_amount * $stats['token_usd_rate']), 2) }}</td>
                        <td data-label="{{ __('model.withdrawals.index.table.method') }}">
                            @switch($withdrawal->payment_method)
                                @case('bank_transfer') <i class="fas fa-university"></i> {{ __('model.withdrawals.index.table.method_bank') }} @break
                                @case('paypal') <i class="fab fa-paypal"></i> {{ __('model.withdrawals.index.table.method_paypal') }} @break
                                @case('stripe') <i class="fab fa-stripe"></i> {{ __('model.withdrawals.index.table.method_stripe') }} @break
                                @case('crypto') <i class="fab fa-bitcoin"></i> {{ __('model.withdrawals.index.table.method_crypto') }} @break
                                @default {{ $withdrawal->payment_method }}
                            @endswitch
                        </td>
                        <td data-label="{{ __('model.withdrawals.index.table.status') }}">
                            <span class="sh-status-badge status-{{ $withdrawal->status }}">
                                {{ __('auth.status.' . $withdrawal->status) }}
                            </span>
                        </td>
                        <td data-label="{{ __('model.withdrawals.index.table.actions') }}">
                            @if($withdrawal->status === 'pending')
                                <form action="{{ route('model.withdrawals.cancel', $withdrawal) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="background: none; border: none; color: #ffc107; cursor: pointer; font-size: 0.85rem; padding: 0;">
                                        <i class="fas fa-times"></i> {{ __('model.withdrawals.index.table.cancel') }}
                                    </button>
                                </form>
                            @elseif($withdrawal->status === 'rejected')
                                <button type="button" style="background: none; border: none; color: #0dcaf0; cursor: pointer; font-size: 0.85rem; padding: 0;" onclick="alert('{{ __('model.withdrawals.index.table.info') }}: {{ addslashes($withdrawal->rejection_reason) }}')">
                                    <i class="fas fa-info-circle"></i> {{ __('model.withdrawals.index.table.info') }}
                                </button>
                            @else
                                <span style="opacity: 0.3;">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 3rem; color: rgba(255,255,255,0.2);">
                            <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                            {{ __('model.withdrawals.index.table.empty') }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($withdrawals->hasPages())
            <div style="padding: 1.5rem; border-top: 1px solid rgba(255,255,255,0.05); text-align: center;">
                {{ $withdrawals->links('custom.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection
