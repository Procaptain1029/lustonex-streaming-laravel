@extends('layouts.admin')

@section('title', __('admin.gamification.levels.index.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item">{{ __('admin.gamification-2.title') }}</span>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.gamification-2.levels.index.title_header') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Levels List Professional Styling ----- */

        /* 1. Hero / Title */
        .page-header {
            margin-bottom: 32px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 20px;
        }


        /* 2. Management Header & Filters */
        .sh-management-header {
            display: flex;
            flex-direction: column;
            gap: 24px;
            margin-bottom: 32px;
        }

        .sh-filter-container {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .sh-filter-chip {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 14px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.2s ease;
            background: transparent;
        }

        .sh-filter-chip:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        .sh-filter-chip.active {
            border: 2px solid #111;
            border-color: var(--admin-gold);
            font-weight: 600;
            color: #fff;
            background: rgba(212, 175, 55, 0.05);
        }

        .sh-header-actions {
            margin-left: auto;
        }

        .sh-btn-create {
            padding: 12px 28px;
            border-radius: 12px;
            background: var(--gradient-gold);
            color: #000 !important;
            font-weight: 800;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.2);
            border: none;
        }

        .sh-btn-create:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.3);
            color: #000 !important;
        }

        /* 3. Modern Table */
        .sh-admin-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
            padding: 0;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .sh-modern-table {
            width: 100%;
            border-collapse: collapse;
        }

        .sh-modern-table th {
            padding: 18px 25px;
            text-align: left;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.4);
            letter-spacing: 0.5px;
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sh-modern-table td {
            padding: 20px 25px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            vertical-align: middle;
            font-size: 14px;
        }

        .sh-modern-table tr {
            transition: background 0.2s ease-out;
        }

        .sh-modern-table tr:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .sh-modern-table tr:last-child td {
            border-bottom: none;
        }

        /* Level Info */
        .sh-level-number-badge {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 800;
            color: #fff;
        }

        .sh-level-name {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
        }

        .sh-xp-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 8px;
            background: rgba(212, 175, 55, 0.1);
            border: 1px solid rgba(212, 175, 55, 0.2);
            color: var(--admin-gold);
            font-weight: 700;
            font-size: 13px;
        }

        /* League Styles */
        .sh-league-pill {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 4px;
        }

        .league-gris {
            background: rgba(148, 163, 184, 0.1);
            color: #94a3b8;
        }

        .league-verde {
            background: rgba(16, 185, 129, 0.1);
            color: #34d399;
        }

        .league-bronce {
            background: rgba(251, 191, 36, 0.1);
            color: #fbbf24;
        }

        .league-oro {
            background: rgba(212, 175, 55, 0.1);
            color: #facc15;
        }

        .league-diamante {
            background: rgba(96, 165, 250, 0.1);
            color: #60a5fa;
        }

        .league-elite {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Action Buttons */
        .sh-action-group {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 8px;
        }

        .sh-btn-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1px solid transparent;
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.6);
            transition: all 0.2s;
            cursor: pointer;
            text-decoration: none;
        }

        .sh-btn-icon:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            transform: scale(1.1);
        }

        .sh-btn-delete {
            color: #f87171;
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.2);
        }

        .sh-btn-delete:hover {
            background: #ef4444;
            color: #fff;
        }

        .sh-btn-edit {
            color: #60a5fa;
            background: rgba(59, 130, 246, 0.1);
            border-color: rgba(59, 130, 246, 0.2);
        }

        .sh-btn-edit:hover {
            background: #3b82f6;
            color: #fff;
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 20px;
                gap: 12px;
            }

            .sh-btn-create {
                width: 100%;
                justify-content: center;
                padding: 10px 16px;
            }


            .sh-management-header {
                gap: 16px;
                margin-bottom: 24px;
            }

            .sh-filter-container {
                gap: 8px;
                flex-wrap: wrap;
            }

            .sh-filter-chip {
                padding: 6px 14px;
                font-size: 13px;
                white-space: nowrap;
            }

            .sh-header-actions {
                margin-left: 0;
            }

            .sh-admin-card {
                border-radius: 16px;
            }

            .sh-modern-table th,
            .sh-modern-table td {
                padding: 12px 14px;
                font-size: 13px;
            }

            .sh-modern-table th {
                font-size: 11px;
            }

            /* Hide XP and Rewards columns on mobile */
            .sh-modern-table th:nth-child(3),
            .sh-modern-table td:nth-child(3),
            .sh-modern-table th:nth-child(4),
            .sh-modern-table td:nth-child(4) {
                display: none;
            }

            .sh-level-number-badge {
                width: 34px;
                height: 34px;
                font-size: 15px;
                border-radius: 8px;
            }

            .sh-level-name {
                font-size: 14px;
            }

            .sh-league-pill {
                font-size: 10px;
                padding: 3px 8px;
            }

            .sh-action-group {
                gap: 6px;
            }

            .sh-btn-icon {
                width: 28px;
                height: 28px;
                border-radius: 6px;
            }

            /* Empty state */
            div[style*="padding: 80px"] {
                padding: 50px 20px !important;
            }
        }

        @media (max-width: 480px) {
            .sh-filter-chip {

                padding: 5px 12px;
                font-size: 12px;
                border-radius: 16px;
            }

            .sh-admin-card {
                border-radius: 12px;
            }

            .sh-modern-table th,
            .sh-modern-table td {
                padding: 10px 12px;
            }

            .sh-level-number-badge {
                width: 30px;
                height: 30px;
                font-size: 13px;
            }

            .sh-level-name {
                font-size: 13px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">
               
                {{ __('admin.gamification-2.levels.index.title_header') }}
            </h1>
            <p class="page-subtitle">{{ __('admin.gamification-2.levels.index.subtitle') }}</p>
        </div>
        <a href="{{ route('admin.gamification.levels.create') }}" class="sh-btn-create">
            <i class="fas fa-plus"></i> {{ __('admin.gamification-2.levels.index.create_button') }}
        </a>
    </div>

  
    
    <div class="sh-admin-card">
        @if($levels->count() > 0)
            <div class="table-responsive">
                <table class="sh-modern-table">
                    <thead>
                        <tr>
                            <th style="width: 80px; text-align: center;">{{ __('admin.gamification-2.levels.index.table.level') }}</th>
                            <th>{{ __('admin.gamification-2.levels.index.table.name_league') }}</th>
                            <th>{{ __('admin.gamification-2.levels.index.table.xp_required') }}</th>
                            <th>{{ __('admin.gamification-2.levels.index.table.rewards') }}</th>
                            <th style="text-align: right;">{{ __('admin.gamification-2.levels.index.table.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($levels as $level)
                            @php
                                $leagueClass = 'league-gris';
                                if (str_contains(strtolower($level->name), 'verde'))
                                    $leagueClass = 'league-verde';
                                elseif (str_contains(strtolower($level->name), 'bronce'))
                                    $leagueClass = 'league-bronce';
                                elseif (str_contains(strtolower($level->name), 'oro'))
                                    $leagueClass = 'league-oro';
                                elseif (str_contains(strtolower($level->name), 'diamante'))
                                    $leagueClass = 'league-diamante';
                                elseif (str_contains(strtolower($level->name), 'elite'))
                                    $leagueClass = 'league-elite';
                            @endphp
                            <tr>
                                <td style="text-align: center;">
                                    <div class="sh-level-number-badge">{{ $level->level_number }}</div>
                                </td>
                                <td>
                                    <div style="display: flex; flex-direction: column;">
                                        <span class="sh-level-name">{{ $level->name }}</span>
                                        <span class="sh-league-pill {{ $leagueClass }}">
                                            {{ explode(' - ', $level->name)[1] ?? __('admin.gamification-2.levels.index.table.standard') }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <span class="sh-xp-badge">
                                        <i class="fas fa-star" style="font-size: 10px;"></i>
                                        {{ number_format($level->xp_required) }} XP
                                    </span>
                                </td>
                                <td>
                                    @php $rewards = $level->rewards_json ?? []; @endphp
                                    <div style="font-size: 13px; color: rgba(255,255,255,0.7);">
                                        @if(isset($rewards['tokens']) && $rewards['tokens'] > 0)
                                            <span><i class="fas fa-coins" style="color: #fbbf24; margin-right: 4px;"></i>
                                                {{ $rewards['tokens'] }} {{ __('admin.gamification-2.levels.index.table.tokens') }}</span>
                                        @else
                                            <span style="opacity: 0.5;">{{ __('admin.gamification-2.levels.index.table.no_tokens') }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="sh-action-group">
                                        <a href="{{ route('admin.gamification.levels.edit', $level->id) }}"
                                            class="sh-btn-icon sh-btn-edit" title="{{ __('admin.gamification-2.levels.index.table.edit') }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('admin.gamification.levels.destroy', $level->id) }}" method="POST"
                                            style="margin: 0;" class="swal-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="sh-btn-icon sh-btn-delete" title="{{ __('admin.gamification-2.levels.index.table.delete') }}">
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
            <!-- Pagination if available -->
            @if(method_exists($levels, 'links'))
                <div class="sh-pagination-container"
                    style="padding: 24px; display: flex; justify-content: center; border-top: 1px solid rgba(255,255,255,0.05);">
                    {{ $levels->links('custom.pagination') }}
                </div>
            @endif
        @else
            <div style="padding: 80px; text-align: center; color: rgba(255,255,255,0.3);">
                <i class="fas fa-layer-group" style="font-size: 4rem; opacity: 0.2; margin-bottom: 24px;"></i>
                <h3 style="color: #fff; font-weight: 800; font-size: 24px; margin-bottom: 12px;">{{ __('admin.gamification-2.levels.index.empty.title') }}
                </h3>
                <p style="font-size: 16px; margin: 0 auto; max-width: 400px;">{{ __('admin.gamification-2.levels.index.empty.subtitle') }}</p>
                <a href="{{ route('admin.gamification.levels.create') }}"
                    style="margin-top: 24px; display: inline-block; color: var(--admin-gold); font-weight: 600;">{{ __('admin.gamification-2.levels.index.empty.action') }}</a>
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
                        title: '{{ __('admin.gamification-2.levels.index.delete_alert.title') }}',
                        text: '{{ __('admin.gamification-2.levels.index.delete_alert.text') }}',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#333',
                        confirmButtonText: '{{ __('admin.gamification-2.levels.index.delete_alert.confirm') }}',
                        cancelButtonText: '{{ __('admin.gamification-2.levels.index.delete_alert.cancel') }}',
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