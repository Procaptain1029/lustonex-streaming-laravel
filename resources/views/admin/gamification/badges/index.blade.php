@extends('layouts.admin')

@section('title', __('admin.gamification.badges.index.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item">Gamificación</span>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.gamification-2.badges.index.title_header') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Badges Index Professional Styling ----- */

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
            padding: 20px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            vertical-align: middle;
            color: #fff;
        }

        .sh-modern-table tr:hover td {
            background: rgba(255, 255, 255, 0.03);
        }

        /* Table Elements */
        .sh-badge-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            background: rgba(255, 255, 255, 0.05);
        }

        .sh-badge-info div {
            display: flex;
            flex-direction: column;
        }

        .sh-badge-name {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .sh-badge-desc {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.5);
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sh-pill {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 6px;
            border: 1px solid transparent;
        }

        /* Type Colors */
        .pill-hall_of_fame {
            background: rgba(251, 191, 36, 0.1);
            color: #fbbf24;
            border-color: rgba(251, 191, 36, 0.2);
        }

        .pill-event {
            background: rgba(59, 130, 246, 0.1);
            color: #60a5fa;
            border-color: rgba(59, 130, 246, 0.2);
        }

        .pill-milestone {
            background: rgba(16, 185, 129, 0.1);
            color: #34d399;
            border-color: rgba(16, 185, 129, 0.2);
        }

        .pill-special {
            background: rgba(139, 92, 246, 0.1);
            color: #a78bfa;
            border-color: rgba(139, 92, 246, 0.2);
        }

        /* Rarity Visualization (mockup based on requirements) */
        .sh-rarity-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }

        .status-active {
            color: #10b981;
            font-weight: 600;
            font-size: 13px;
        }

        .status-inactive {
            color: rgba(255, 255, 255, 0.3);
            font-weight: 600;
            font-size: 13px;
        }

        /* Actions */
        .sh-actions {
            display: flex;
            gap: 8px;
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .sh-modern-table tr:hover .sh-actions {
            opacity: 1;
        }

        .sh-btn-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: transparent;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.2s;
            cursor: pointer;
            text-decoration: none;
        }

        .sh-btn-icon:hover {
            background: #fff;
            color: #000;
            transform: scale(1.05);
        }

        .sh-btn-icon.delete:hover {
            background: #ef4444;
            color: #fff;
            border-color: #ef4444;
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

            /* Hide Description, Status, and Users columns */
            .sh-modern-table th:nth-child(3),
            .sh-modern-table td:nth-child(3),
            .sh-modern-table th:nth-child(5),
            .sh-modern-table td:nth-child(5),
            .sh-modern-table th:nth-child(6),
            .sh-modern-table td:nth-child(6) {
                display: none;
            }

            .sh-badge-icon {
                width: 38px;
                height: 38px;
                font-size: 16px;
                border-radius: 8px;
            }

            .sh-badge-name {
                font-size: 14px;
            }

            .sh-pill {
                font-size: 10px;
                padding: 3px 8px;
            }

            .sh-btn-icon {
                width: 28px;
                height: 28px;
                border-radius: 6px;
                font-size: 11px;
            }

            .sh-actions {
                gap: 6px;
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

            /* Also hide Category on very small screens */
            .sh-modern-table th:nth-child(4),
            .sh-modern-table td:nth-child(4) {
                display: none;
            }

            .sh-badge-icon {
                width: 32px;
                height: 32px;
                font-size: 14px;
            }

            .sh-badge-name {
                font-size: 13px;
            }

            .sh-btn-icon {
                width: 26px;
                height: 26px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">{{ __('admin.gamification-2.badges.index.title_header') }}</h1>
            <p class="page-subtitle">{{ __('admin.gamification-2.badges.index.subtitle') }}</p>
        </div>
        <a href="{{ route('admin.gamification.badges.create') }}" class="sh-btn-create">
            <i class="fas fa-plus"></i> {{ __('admin.gamification-2.badges.index.create_btn') }}
        </a>
    </div>

    <!-- Filters -->
    <div class="sh-filters-bar">
        <a href="{{ route('admin.gamification.badges.index') }}"
            class="sh-filter-chip {{ !request('type') ? 'active' : '' }}">{{ __('admin.gamification-2.badges.index.filters.all') }}</a>
        <a href="?type=hall_of_fame" class="sh-filter-chip {{ request('type') == 'hall_of_fame' ? 'active' : '' }}">{{ __('admin.gamification-2.badges.index.filters.hall_of_fame') }}</a>
        <a href="?type=event" class="sh-filter-chip {{ request('type') == 'event' ? 'active' : '' }}">{{ __('admin.gamification-2.badges.index.filters.event') }}</a>
        <a href="?type=milestone" class="sh-filter-chip {{ request('type') == 'milestone' ? 'active' : '' }}">{{ __('admin.gamification-2.badges.index.filters.milestone') }}</a>
        <a href="?type=special" class="sh-filter-chip {{ request('type') == 'special' ? 'active' : '' }}">{{ __('admin.gamification-2.badges.index.filters.special') }}</a>
    </div>

    <!-- Table -->
    <div class="sh-table-container">
        <div class="table-responsive">
            <table class="sh-modern-table">
                <thead>
                    <tr>
                        <th width="80">{{ __('admin.gamification-2.badges.index.table.icon') }}</th>
                        <th>{{ __('admin.gamification-2.badges.index.table.badge') }}</th>
                        <th>{{ __('admin.gamification-2.badges.index.table.description') }}</th>
                        <th>{{ __('admin.gamification-2.badges.index.table.category') }}</th>
                        <th>{{ __('admin.gamification-2.badges.index.table.status') }}</th>
                        <th>{{ __('admin.gamification-2.badges.index.table.users') }}</th>
                        <th width="120" style="text-align: right;">{{ __('admin.gamification-2.badges.index.table.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($badges as $badge)
                        <tr>
                            <td>
                                <div class="sh-badge-icon"
                                    style="color: {{ $badge->color }}; background: {{ $badge->color }}15; border: 1px solid {{ $badge->color }}30;">
                                    <i class="fas {{ $badge->icon }}"></i>
                                </div>
                            </td>
                            <td>
                                <div class="sh-badge-info">
                                    <div class="sh-badge-name">{{ $badge->name }}</div>
                                    <!-- Rarity Dot derived from color for visual flair -->
                                    <div style="font-size: 11px; font-weight: 600; color: rgba(255,255,255,0.4);">
                                        <span class="sh-rarity-dot"
                                            style="background: {{ $badge->color }}; box-shadow: 0 0 5px {{ $badge->color }};"></span>
                                        {{ __('admin.gamification-2.badges.index.table.high_rarity') }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="sh-badge-desc">{{ $badge->description }}</div>
                            </td>
                            <td>
                                <span class="sh-pill pill-{{ $badge->type }}">
                                    {{ str_replace('_', ' ', $badge->type) }}
                                </span>
                            </td>
                            <td>
                                @if($badge->is_active)
                                    <span class="status-active"><i class="fas fa-check-circle"></i> {{ __('admin.gamification-2.badges.index.table.active') }}</span>
                                @else
                                    <span class="status-inactive"><i class="fas fa-circle"></i> {{ __('admin.gamification-2.badges.index.table.inactive') }}</span>
                                @endif
                            </td>
                            <td style="font-weight: 700;">{{ $badge->users()->count() }}</td>
                            <td>
                                <div class="sh-actions" style="justify-content: flex-end;">
                                    <form action="{{ route('admin.gamification.badges.toggle-active', $badge->id) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="sh-btn-icon"
                                            title="{{ $badge->is_active ? __('admin.gamification.badges.index.table.deactivate') : __('admin.gamification.badges.index.table.activate') }}">
                                            <i class="fas {{ $badge->is_active ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.gamification.badges.edit', $badge->id) }}" class="sh-btn-icon"
                                        title="{{ __('admin.gamification-2.badges.index.table.edit') }}">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <!-- Duplicate (Mock link for now if route doesn't exist, leveraging create with query params if implemented, otherwise just visual) -->
                                    <!-- <a href="#" class="sh-btn-icon" title="Duplicar"><i class="fas fa-copy"></i></a> -->

                                    <!-- Delete -->
                                    <form action="{{ route('admin.gamification.badges.destroy', $badge->id) }}" method="POST"
                                        class="swal-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="sh-btn-icon delete" title="{{ __('admin.gamification-2.badges.index.table.delete') }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 60px; color: rgba(255,255,255,0.3);">
                                <i class="fas fa-award" style="font-size: 3rem; opacity: 0.2; margin-bottom: 20px;"></i>
                                <br>{{ __('admin.gamification-2.badges.index.table.no_badges') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.swal-delete').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: '{{ __('admin.gamification-2.badges.index.delete_alert.title') }}',
                        text: '{{ __('admin.gamification-2.badges.index.delete_alert.text') }}',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#333',
                        confirmButtonText: '{{ __('admin.gamification-2.badges.index.delete_alert.confirm') }}',
                        cancelButtonText: '{{ __('admin.gamification-2.badges.index.delete_alert.cancel') }}',
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