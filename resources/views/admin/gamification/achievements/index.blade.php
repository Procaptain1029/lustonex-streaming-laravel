@extends('layouts.admin')

@section('title', __('admin.gamification.achievements.index.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.gamification-2.achievements.index.title_header') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Achievements Index Professional Styling ----- */

        /* 1. Hero */
        .page-header {
            margin-bottom: 32px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
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

        /* 2. Filter Chips */
        .sh-filters-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 32px;
        }

        .sh-filter-chip {
            padding: 8px 20px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 14px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.6);
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            background: rgba(255, 255, 255, 0.02);
        }

        .sh-filter-chip:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        .sh-filter-chip.active {
            background: #fff;
            color: #000;
            border-color: #fff;
            font-weight: 700;
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
            padding: 16px 24px;
            text-align: left;
            font-size: 12px;
            font-weight: 800;
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
            transition: background 0.2s ease-out;
        }

        .sh-modern-table tr:hover td {
            background: rgba(255, 255, 255, 0.03);
        }

        /* Table Elements */
        .sh-achievement-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            background: rgba(255, 255, 255, 0.05);
            color: var(--admin-gold);
            opacity: 0.9;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sh-achievement-info {
            display: flex;
            flex-direction: column;
        }

        .sh-achievement-name {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 4px;
            color: #fff;
        }

        .sh-achievement-desc {
            font-size: 14px;
            opacity: 0.75;
            max-width: 350px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: rgba(255, 255, 255, 0.7);
        }

        .sh-achievement-rarity {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            opacity: 0.6;
            margin-top: 4px;
            letter-spacing: 0.5px;
        }

        .sh-pill {
            font-size: 12px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-block;
        }

        /* Type / Role Colors */
        .pill-role-fan {
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
        }

        .pill-role-model {
            background: rgba(236, 72, 153, 0.15);
            color: #f472b6;
        }

        .pill-role-both {
            background: rgba(168, 85, 247, 0.15);
            color: #c084fc;
        }

        /* Status Colors */
        .status-active {
            color: #10b981;
            font-weight: 600;
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 6px;
            background: rgba(16, 185, 129, 0.15);
        }

        .status-inactive {
            color: rgba(255, 255, 255, 0.4);
            font-weight: 600;
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.1);
        }

        /* Rewards */
        .sh-reward-text {
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 6px;
            color: #fff;
        }

        .sh-reward-icon {
            color: var(--admin-gold);
            font-size: 12px;
        }

        /* Actions */
        .sh-actions {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }

        .sh-btn-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: transparent;
            color: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.2s;
            cursor: pointer;
            text-decoration: none;
            font-size: 13px;
        }

        .sh-btn-icon:hover {
            background: #fff;
            color: #000;
            transform: scale(1.05);
            opacity: 1;
        }

        .sh-btn-icon.delete:hover {
            background: #ef4444;
            color: #fff;
            border-color: #ef4444;
        }

        /* Pagination Styling Override */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 6px;
            margin-top: 20px;
        }

        /* Mobile */
        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
                margin-bottom: 20px;
            }


            .sh-btn-create {
                width: 100%;
                justify-content: center;
                padding: 10px 20px;
                font-size: 13px;
            }

            .sh-filters-bar {
                gap: 8px;
                margin-bottom: 24px;
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

            /* Hide Description, Type/Rol, and Status columns */
            .sh-modern-table th:nth-child(3),
            .sh-modern-table td:nth-child(3),
            .sh-modern-table th:nth-child(4),
            .sh-modern-table td:nth-child(4),
            .sh-modern-table th:nth-child(6),
            .sh-modern-table td:nth-child(6) {
                display: none;
            }

            .sh-achievement-icon {
                width: 34px;
                height: 34px;
                font-size: 15px;
                border-radius: 8px;
            }

            .sh-achievement-name {
                font-size: 14px;
            }

            .sh-achievement-rarity {
                font-size: 9px;
            }

            .sh-reward-text {
                font-size: 12px;
            }

            .sh-btn-icon {
                width: 28px;
                height: 28px;
                border-radius: 6px;
                font-size: 11px;
            }
        }

        @media (max-width: 480px) {
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

            /* Also hide Reward column on very small screens */
            .sh-modern-table th:nth-child(5),
            .sh-modern-table td:nth-child(5) {
                display: none;
            }

            .sh-achievement-icon {
                width: 30px;
                height: 30px;
                font-size: 13px;
            }

            .sh-achievement-name {
                font-size: 13px;
            }

            .sh-actions {
                gap: 6px;
            }

            .sh-btn-icon {
                width: 26px;
                height: 26px;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Hero -->
    <div class="page-header">
        <div>
            <h1 class="page-title">{{ __('admin.gamification-2.achievements.index.title_header') }}</h1>
            <p class="page-subtitle">{{ __('admin.gamification-2.achievements.index.subtitle') }}</p>
        </div>
        <a href="{{ route('admin.gamification.achievements.create') }}" class="sh-btn-create">
            <i class="fas fa-plus"></i> {{ __('admin.gamification-2.achievements.index.create_btn') }}
        </a>
    </div>

    <!-- Filters -->
    <div class="sh-filters-bar">
        <a href="{{ route('admin.gamification.achievements.index') }}"
            class="sh-filter-chip {{ !request('role') && !request('is_active') ? 'active' : '' }}">{{ __('admin.gamification-2.achievements.index.filters.all') }}</a>
        <a href="?is_active=1" class="sh-filter-chip {{ request('is_active') == '1' ? 'active' : '' }}">{{ __('admin.gamification-2.achievements.index.filters.active') }}</a>
        <a href="?is_active=0" class="sh-filter-chip {{ request('is_active') === '0' ? 'active' : '' }}">{{ __('admin.gamification-2.achievements.index.filters.inactive') }}</a>
        <a href="?role=model" class="sh-filter-chip {{ request('role') == 'model' ? 'active' : '' }}">{{ __('admin.gamification-2.achievements.index.filters.for_models') }}</a>
        <a href="?role=fan" class="sh-filter-chip {{ request('role') == 'fan' ? 'active' : '' }}">{{ __('admin.gamification-2.achievements.index.filters.for_fans') }}</a>
    </div>

    <!-- Table -->
    <div class="sh-table-container">
        <div class="table-responsive">
            <table class="sh-modern-table">
                <thead>
                    <tr>
                        <th width="70">{{ __('admin.gamification-2.achievements.index.table.icon') }}</th>
                        <th>{{ __('admin.gamification-2.achievements.index.table.achievement') }}</th>
                        <th>{{ __('admin.gamification-2.achievements.index.table.description') }}</th>
                        <th>{{ __('admin.gamification-2.achievements.index.table.type_role') }}</th>
                        <th>{{ __('admin.gamification-2.achievements.index.table.reward') }}</th>
                        <th>{{ __('admin.gamification-2.achievements.index.table.status') }}</th>
                        <th style="text-align: right;">{{ __('admin.gamification-2.achievements.index.table.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($achievements as $achievement)
                        <tr>
                            <td>
                                <div class="sh-achievement-icon">
                                    <i class="fas {{ $achievement->icon }}"></i>
                                </div>
                            </td>
                            <td>
                                <div class="sh-achievement-info">
                                    <span class="sh-achievement-name">{{ $achievement->name }}</span>
                                    <span class="sh-achievement-rarity">{{ ucfirst($achievement->rarity) }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="sh-achievement-desc" title="{{ $achievement->description }}">
                                    {{Str::limit($achievement->description, 60)}}</div>
                            </td>
                            <td>
                                <span class="sh-pill pill-role-{{ $achievement->role }}">
                                    {{ ucfirst($achievement->role) }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; flex-direction: column; gap: 4px;">
                                    @if($achievement->xp_reward > 0)
                                        <div class="sh-reward-text"><i class="fas fa-bolt sh-reward-icon"></i>
                                            {{ $achievement->xp_reward }} XP</div>
                                    @endif
                                    @if($achievement->ticket_reward > 0)
                                        <div class="sh-reward-text"><i class="fas fa-ticket-alt sh-reward-icon"></i>
                                            {{ $achievement->ticket_reward }} Tickets</div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($achievement->is_active)
                                    <span class="status-active">{{ __('admin.gamification-2.achievements.index.table.active') }}</span>
                                @else
                                    <span class="status-inactive">{{ __('admin.gamification-2.achievements.index.table.inactive') }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="sh-actions">
                                    <a href="{{ route('admin.gamification.achievements.edit', $achievement) }}"
                                        class="sh-btn-icon" title="{{ __('admin.gamification-2.achievements.index.table.edit') }}">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <!-- Duplicate placeholder -->
                                    <!-- <a href="#" class="sh-btn-icon" title="Duplicar"><i class="fas fa-copy"></i></a> -->

                                    <form action="{{ route('admin.gamification.achievements.destroy', $achievement) }}"
                                        method="POST" class="swal-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="sh-btn-icon delete" title="{{ __('admin.gamification-2.achievements.index.table.delete') }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 60px; color: rgba(255,255,255,0.3);">
                                <i class="fas fa-trophy" style="font-size: 3rem; opacity: 0.2; margin-bottom: 20px;"></i>
                                <br>{{ __('admin.gamification-2.achievements.index.table.no_achievements') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($achievements->hasPages())
            <div
                style="padding: 20px; border-top: 1px solid rgba(255, 255, 255, 0.05); display: flex; justify-content: center;">
                {{ $achievements->links('custom.pagination') }}
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
                        title: '{{ __('admin.gamification-2.achievements.index.delete_alert.title') }}',
                        text: '{{ __('admin.gamification-2.achievements.index.delete_alert.text') }}',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#333',
                        confirmButtonText: '{{ __('admin.gamification-2.achievements.index.delete_alert.confirm') }}',
                        cancelButtonText: '{{ __('admin.gamification-2.achievements.index.delete_alert.cancel') }}',
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