@extends('layouts.public')

@section('title', 'Mis Reportes - Lustonex')

@section('title', __('reports.meta_title') . ' - Lustonex')

@section('content')
<style>
    .reports-container {
        padding: 40px 20px;
        max-width: 1000px;
        margin: 0 auto;
        min-height: calc(100vh - 200px);
    }

    .page-header {
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 800;
        background: var(--gradient-gold);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin: 0;
    }

    .report-card {
        background: rgba(20, 20, 25, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .report-card:hover {
        transform: translateY(-5px);
        border-color: rgba(212, 175, 55, 0.3);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
    }

    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .report-info {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .report-id {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.4);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .reported-user {
        font-size: 1.1rem;
        font-weight: 700;
        color: #fff;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-pending { background: rgba(255, 193, 7, 0.1); color: #ffc107; border: 1px solid rgba(255, 193, 7, 0.2); }
    .status-resolved { background: rgba(40, 167, 69, 0.1); color: #28a745; border: 1px solid rgba(40, 167, 69, 0.2); }
    .status-dismissed { background: rgba(220, 53, 69, 0.1); color: #dc3545; border: 1px solid rgba(220, 53, 69, 0.2); }

    .report-reason {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.95rem;
        line-height: 1.6;
        padding: 15px;
        background: rgba(0, 0, 0, 0.2);
        border-radius: 12px;
        margin-bottom: 15px;
    }

    .report-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.4);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: rgba(255, 255, 255, 0.02);
        border-radius: 30px;
        border: 2px dashed rgba(255, 255, 255, 0.05);
    }

    .empty-icon {
        font-size: 3rem;
        color: rgba(255, 255, 255, 0.1);
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .reports-container { padding: 20px; }
        .page-title { font-size: 1.5rem; }
        .report-header { flex-direction: column; gap: 10px; }
    }
</style>
<div class="reports-container">
    <div class="page-header">        
        <h1 class="page-title">{{ __('reports.title') }}</h1>
    </div>

    @forelse($reports as $report)
        <div class="report-card">
            <div class="report-header">
                <div class="report-info">
                    <span class="report-id">{{ __('reports.report_id', ['id' => str_pad($report->id, 5, '0', STR_PAD_LEFT)]) }}</span>
                    <span class="reported-user">{{ __('reports.reported_user', ['name' => $report->reported->name]) }}</span>
                </div>
                <span class="status-badge status-{{ $report->status }}">
                    @if($report->status === 'pending')
                        {{ __('reports.status.pending') }}
                    @elseif($report->status === 'resolved')
                        {{ __('reports.status.resolved') }}
                    @else
                        {{ __('reports.status.dismissed') }}
                    @endif
                </span>
            </div>

            <div class="report-reason">
                {{ $report->reason }}
            </div>

            <div class="report-footer">
                <span><i class="far fa-calendar-alt"></i> {{ __('reports.date') }}: {{ $report->created_at->format('d/m/Y H:i') }}</span>
                @if($report->resolved_at)
                    <span><i class="fas fa-check-circle"></i> {{ __('reports.processed_at', ['date' => $report->resolved_at->format('d/m/Y')]) }}</span>
                @endif
            </div>
        </div>
    @empty
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <h3 style="color: #dfc04e; margin-bottom: 10px;">{{ __('reports.empty_state.title') }}</h3>
            <p style="color: rgba(255, 255, 255, 0.4); max-width: 400px; margin: 0 auto;">
                {{ __('reports.empty_state.desc') }}
            </p>
        </div>
    @endforelse

    <div style="margin-top: 30px;">
        {{ $reports->links() }}
    </div>
</div>
@endsection
