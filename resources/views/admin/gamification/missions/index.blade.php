@extends('layouts.admin')

@section('title', __('admin.gamification.missions.index.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.gamification-2.missions.index.title') }}</span>
@endsection

@section('styles')
<style>
    /* ----- Missions List Professional Styling ----- */
    .sh-stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .sh-stat-mini-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .sh-stat-mini-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .sh-management-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 30px;
        gap: 20px;
        flex-wrap: wrap;
    }

    .sh-search-box {
        flex: 1;
        min-width: 300px;
        position: relative;
    }

    .sh-search-input {
        width: 100%;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 14px;
        padding: 12px 20px 12px 45px;
        color: #fff;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .sh-search-input:focus {
        outline: none;
        border-color: var(--admin-gold);
        box-shadow: 0 0 20px rgba(212, 175, 55, 0.1);
    }

    .sh-search-box i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.3);
    }

    .sh-admin-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 24px;
        padding: 0;
        overflow: hidden;
    }

    .sh-modern-table {
        width: 100%;
        border-collapse: collapse;
    }

    .sh-modern-table th {
        padding: 18px 25px;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.3);
        letter-spacing: 1.5px;
        background: rgba(255, 255, 255, 0.01);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .sh-modern-table td {
        padding: 20px 25px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        vertical-align: middle;
    }

    .sh-modern-table tr:hover td {
        background: rgba(255, 255, 255, 0.02);
    }

    /* Mission Info */
    .sh-mission-info {
        display: flex;
        flex-direction: column;
    }

    .sh-mission-name {
        font-weight: 700;
        color: #fff;
        font-size: 0.95rem;
    }

    .sh-mission-desc {
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.4);
        max-width: 300px;
    }

    /* Badge Styles */
    .sh-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .sh-badge-weekly { background: rgba(59, 130, 246, 0.15); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.2); }
    .sh-badge-level { background: rgba(168, 85, 247, 0.15); color: #a855f7; border: 1px solid rgba(168, 85, 247, 0.2); }
    .sh-badge-parallel { background: rgba(251, 191, 36, 0.15); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.2); }
    .sh-badge-active { background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); }
    .sh-badge-inactive { background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); }

    /* Action Buttons */
    .sh-action-group {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
    }

    .sh-btn-action {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.6) !important;
        transition: all 0.3s ease;
    }

    .sh-btn-action:hover {
        background: rgba(212, 175, 55, 0.1);
        border-color: var(--admin-gold);
        color: var(--admin-gold) !important;
        transform: translateY(-2px);
    }

    .sh-btn-delete:hover {
        background: rgba(239, 68, 68, 0.1);
        border-color: #ef4444;
        color: #ef4444 !important;
    }

    .sh-btn-create {
        padding: 12px 28px;
        border-radius: 12px;
        background: var(--gradient-gold);
        color: #000 !important;
        font-weight: 800;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 10px;
        border: none;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.2);
        text-decoration: none;
    }

    .sh-btn-create:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 25px rgba(212, 175, 55, 0.3);
        color: #000 !important;
    }

    /* Reward Items */
    .sh-reward-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        color: #fff;
        margin-bottom: 4px;
    }

    .sh-reward-icon {
        width: 20px;
        text-align: center;
        color: var(--admin-gold);
    }

    @media (max-width: 992px) {
        .sh-modern-table th:nth-child(3),
        .sh-modern-table td:nth-child(3) {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .sh-stats-row {

            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }

        .sh-stat-mini-card {
            padding: 14px;
            gap: 10px;
            border-radius: 12px;
        }

        .sh-stat-mini-icon {
            width: 36px;
            height: 36px;
            font-size: 1rem;
            border-radius: 8px;
        }

        .sh-stat-mini-card div[style*="font-size: 1.2rem"] {
            font-size: 1rem !important;
        }

        .sh-stat-mini-card div[style*="font-size: 0.7rem"] {
            font-size: 0.6rem !important;
        }

        .sh-management-header {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
            margin-bottom: 24px;
        }

        .sh-search-box {
            min-width: 100%;
        }

        .sh-search-input {
            width: 100%;
            padding: 10px 16px 10px 40px;
            font-size: 0.85rem;
        }

        .sh-btn-create {
            width: 100%;
            justify-content: center;
            padding: 10px 16px;
            font-size: 0.85rem;
        }

        .sh-admin-card {
            border-radius: 16px;
        }

        .sh-modern-table th,
        .sh-modern-table td {
            padding: 12px 14px;
        }

        .sh-modern-table th {
            font-size: 0.65rem;
            letter-spacing: 1px;
        }

        /* Hide Type and Status columns on tablet */
        .sh-modern-table th:nth-child(2),
        .sh-modern-table td:nth-child(2),
        .sh-modern-table th:nth-child(5),
        .sh-modern-table td:nth-child(5) {
            display: none;
        }

        .sh-mission-name {
            font-size: 0.85rem;
        }

        .sh-mission-desc {
            font-size: 0.75rem;
            max-width: 200px;
        }

        .sh-badge {
            font-size: 0.6rem;
            padding: 3px 8px;
        }

        .sh-reward-item {
            font-size: 0.8rem;
        }

        .sh-btn-action {
            width: 32px;
            height: 32px;
            border-radius: 8px;
        }
    }

    @media (max-width: 480px) {
        .sh-stats-row {

            gap: 10px;
            margin-bottom: 20px;
        }

        .sh-stat-mini-card {
            padding: 12px;
            gap: 8px;
        }

        .sh-stat-mini-icon {
            width: 32px;
            height: 32px;
            font-size: 0.9rem;
        }

        .sh-admin-card {
            border-radius: 12px;
        }

        .sh-modern-table th,
        .sh-modern-table td {
            padding: 10px 12px;
        }

        /* Also hide Rewards on very small screens */
        .sh-modern-table th:nth-child(4),
        .sh-modern-table td:nth-child(4) {
            display: none;
        }

        .sh-action-group {
            flex-direction: column;
            gap: 6px;
        }

        .sh-btn-action {
            width: 28px;
            height: 28px;
        }

        /* Empty state */
        div[style*="padding: 100px"] {
            padding: 60px 20px !important;
        }
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ __('admin.gamification-2.missions.index.title') }}</h1>
    <p class="page-subtitle">{{ __('admin.gamification-2.missions.index.subtitle') }}</p>
</div>


<div class="sh-stats-row">
    <div class="sh-stat-mini-card">
        <div class="sh-stat-mini-icon" style="background: rgba(212, 175, 55, 0.1); color: var(--admin-gold);">
            <i class="fas fa-tasks"></i>
        </div>
        <div>
            <div style="font-size: 0.7rem; color: rgba(255,255,255,0.4); text-transform: uppercase;">{{ __('admin.gamification-2.missions.index.stats.total') }}</div>
            <div style="font-size: 1.2rem; font-weight: 800;">{{ $missions->count() }}</div>
        </div>
    </div>
    <div class="sh-stat-mini-card">
        <div class="sh-stat-mini-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
            <i class="fas fa-check-circle"></i>
        </div>
        <div>
            <div style="font-size: 0.7rem; color: rgba(255,255,255,0.4); text-transform: uppercase;">{{ __('admin.gamification-2.missions.index.stats.active') }}</div>
            <div style="font-size: 1.2rem; font-weight: 800;">{{ $missions->where('is_active', true)->count() }}</div>
        </div>
    </div>
    <div class="sh-stat-mini-card">
        <div class="sh-stat-mini-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
            <i class="fas fa-calendar-week"></i>
        </div>
        <div>
            <div style="font-size: 0.7rem; color: rgba(255,255,255,0.4); text-transform: uppercase;">{{ __('admin.gamification-2.missions.index.stats.weekly') }}</div>
            <div style="font-size: 1.2rem; font-weight: 800;">{{ $missions->where('type', 'WEEKLY')->count() }}</div>
        </div>
    </div>
</div>


<div class="sh-management-header">
    <form method="GET" class="sh-search-box">
        <i class="fas fa-search"></i>
        <input type="text" name="search" class="sh-search-input" placeholder="{{ __('admin.gamification-2.missions.index.search_placeholder') }}" value="{{ request('search') }}">
    </form>
    
    <a href="{{ route('admin.gamification.missions.create') }}" class="sh-btn-create">
        <i class="fas fa-plus"></i> {{ __('admin.gamification-2.missions.index.create_button') }}
    </a>
</div>


<div class="sh-admin-card">
    @if($missions->count() > 0)
    <div class="table-responsive">
        <table class="sh-modern-table">
            <thead>
                <tr>
                    <th>{{ __('admin.gamification-2.missions.index.table.mission') }}</th>
                    <th>{{ __('admin.gamification-2.missions.index.table.type') }}</th>
                    <th>{{ __('admin.gamification-2.missions.index.table.goal') }}</th>
                    <th>{{ __('admin.gamification-2.missions.index.table.rewards') }}</th>
                    <th>{{ __('admin.gamification-2.missions.index.table.status') }}</th>
                    <th style="text-align: right;">{{ __('admin.gamification-2.missions.index.table.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($missions as $mission)
                <tr>
                    <td>
                        <div class="sh-mission-info">
                            <span class="sh-mission-name">{{ $mission->name }}</span>
                            <span class="sh-mission-desc">{{ Str::limit($mission->description, 60) }}</span>
                        </div>
                    </td>
                    <td>
                        @php $typeClass = ['WEEKLY' => 'sh-badge-weekly', 'LEVEL_UP' => 'sh-badge-level', 'PARALLEL' => 'sh-badge-parallel'][$mission->type] ?? ''; @endphp
                        <span class="sh-badge {{ $typeClass }}">{{ $mission->type }}</span>
                    </td>
                    <td>
                        <div style="display: flex; flex-direction: column;">
                            <span style="font-size: 0.95rem; font-weight: 700; color: #fff;">{{ $mission->goal_amount }}</span>
                            <span style="font-size: 0.75rem; color: rgba(255,255,255,0.4);">{{ $mission->target_action }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="sh-reward-item">
                            <i class="fas fa-bolt sh-reward-icon"></i>
                            <span>{{ $mission->reward_xp }} XP</span>
                        </div>
                        <div class="sh-reward-item">
                            <i class="fas fa-ticket-alt sh-reward-icon"></i>
                            <span>{{ $mission->reward_tickets }} Tickets</span>
                        </div>
                    </td>
                    <td>
                        @if($mission->is_active)
                            <span class="sh-badge sh-badge-active">{{ __('admin.gamification-2.missions.index.table.active') }}</span>
                        @else
                            <span class="sh-badge sh-badge-inactive">{{ __('admin.gamification-2.missions.index.table.inactive') }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="sh-action-group">
                            <a href="{{ route('admin.gamification.missions.edit', $mission) }}" class="sh-btn-action" title="{{ __('admin.gamification-2.missions.index.table.edit') }}">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.gamification.missions.destroy', $mission) }}" method="POST" class="swal-delete">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="sh-btn-action sh-btn-delete" title="{{ __('admin.gamification-2.missions.index.table.delete') }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="padding: 20px; display: flex; justify-content: center; border-top: 1px solid rgba(255,255,255,0.05);">
        {{ $missions->links('custom.pagination') }}
    </div>
    @else
    <div style="padding: 100px; text-align: center; color: rgba(255,255,255,0.2);">
        <i class="fas fa-clipboard-list" style="font-size: 4rem; opacity: 0.1; margin-bottom: 20px;"></i>
        <h3 style="color: #fff; font-weight: 800;">{{ __('admin.gamification-2.missions.index.empty.title') }}</h3>
        <p>{{ __('admin.gamification-2.missions.index.empty.subtitle') }}</p>
    </div>
    @endif
</div>

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.swal-delete').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: '{{ __('admin.gamification-2.missions.index.delete_alert.title') }}',
                        text: '{{ __('admin.gamification-2.missions.index.delete_alert.text') }}',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#333',
                        confirmButtonText: '{{ __('admin.gamification-2.missions.index.delete_alert.confirm') }}',
                        cancelButtonText: '{{ __('admin.gamification-2.missions.index.delete_alert.cancel') }}',
                        background: '#111',
                        color: '#fff'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
@endsection
