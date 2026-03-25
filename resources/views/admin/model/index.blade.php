@extends('layouts.admin')

@section('title', __('admin.models.index.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.models-2.index.breadcrumb') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Models List Professional Styling ----- */

        /* 1. Hero / Title */
        .page-header {
            margin-bottom: 32px;
        }


        /* 2. Management Header & Filters */
        .sh-management-header {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 32px;
            flex-wrap: wrap;
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
            border: 2px solid var(--admin-gold);
            font-weight: 600;
            color: #fff;
            background: rgba(212, 175, 55, 0.05);
        }

        .sh-search-row {
            display: flex;
            align-items: center;
        }

        .sh-search-box {
            width: 280px;
            position: relative;
            flex-shrink: 0;
        }

        .sh-search-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 12px 20px 12px 45px;
            color: #fff;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .sh-search-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--admin-gold);
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.1);
        }

        .sh-search-box i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.4);
        }

        /* 3. Admin Card (Main Container) */
        .sh-admin-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            padding: 24px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            /* Consistent depth */
        }

        /* 4. Tables */
        .sh-modern-table {
            width: 100%;
            border-collapse: collapse;
            /* Collapse for border-bottom style */
        }

        .sh-modern-table th {
            padding: 12px 16px;
            text-align: left;
            font-size: 14px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.8);
            background: rgba(255, 255, 255, 0.03);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sh-modern-table td {
            padding: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            vertical-align: middle;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.9);
        }

        .sh-modern-table tr {
            transition: all 0.2s ease;
        }

        .sh-modern-table tr:hover td {
            background: rgba(255, 255, 255, 0.03);
        }

        .sh-modern-table tr:last-child td {
            border-bottom: none;
        }

        /* Model Profile Info */
        .sh-model-profile {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .sh-model-avatar-wrapper {
            position: relative;
            flex-shrink: 0;
        }

        .sh-model-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(212, 175, 55, 0.2);
        }

        .sh-status-indicator {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid #0B0B0D;
        }

        .sh-status-online {
            background: #10b981;
        }

        .sh-status-offline {
            background: #6b7280;
        }

        .sh-model-details {
            display: flex;
            flex-direction: column;
        }

        .sh-model-name {
            font-weight: 600;
            color: #fff;
            font-size: 16px;
        }

        .sh-model-email {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.75);
        }

        /* Status Badges */
        .sh-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .sh-badge-admin {
            background: rgba(212, 175, 55, 0.1);
            color: var(--admin-gold);
            border: 1px solid rgba(212, 175, 55, 0.2);
        }

        .sh-badge-model {
            background: rgba(168, 85, 247, 0.1);
            color: #a855f7;
            border: 1px solid rgba(168, 85, 247, 0.2);
        }

        .sh-badge-verified {
            background: rgba(0, 150, 255, 0.15);
            color: #0096ff;
            border: 1px solid rgba(0, 150, 255, 0.2);
        }

        .sh-badge-fan {
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.6);
        }

        .sh-status-pill {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .sh-status-pill-streaming {
            background: rgba(239, 68, 68, 0.15);
            color: #ff4b4b;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .sh-status-pill-offline {
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.4);
        }

        /* Action Buttons */
        .sh-action-group {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }

        .sh-btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.85);
            /* Increased opacity */
            font-size: 0.9rem;
            transition: all 0.2s ease;
            text-decoration: none;
            cursor: pointer;
        }

        .sh-btn-action:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            transform: scale(1.05);
        }

        /* Pagination */
        .sh-pagination-container {
            padding: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            display: flex;
            justify-content: center;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .sh-admin-card {
            animation: fadeIn 0.3s ease-out;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sh-management-header {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }

            /* Filters scroll horizontally without wrapping */
            .sh-filter-container {
                flex-wrap: nowrap;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                gap: 8px;
                padding-bottom: 4px;
            }

            .sh-filter-container::-webkit-scrollbar { display: none; }

            .sh-filter-chip {
                white-space: nowrap;
                flex-shrink: 0;
                font-size: 13px;
                padding: 7px 14px;
            }

            .sh-search-row { width: 100%; }
            .sh-search-box { width: 100%; }

            .sh-search-input {
                padding: 11px 16px 11px 42px;
                font-size: 0.9rem;
            }

            /* Table: allow horizontal scroll so nothing clips */
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                width: 100%;
            }

            /* Hide Estado/Verificación and Registro columns */
            .sh-modern-table th:nth-child(2),
            .sh-modern-table td:nth-child(2),
            .sh-modern-table th:nth-child(3),
            .sh-modern-table td:nth-child(3) {
                display: none;
            }

            /* Fix Actions column so it doesn't push layout */
            .sh-modern-table th:last-child,
            .sh-modern-table td:last-child {
                width: 80px;
                min-width: 80px;
            }

            .sh-modern-table th,
            .sh-modern-table td {
                padding: 12px 10px;
                font-size: 0.85rem;
            }

            .sh-model-profile {
                max-width: 200px;
            }

            .sh-model-name {
                font-size: 14px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 140px;
            }

            .sh-model-email {
                font-size: 11px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 140px;
            }

            .sh-model-avatar {
                width: 36px;
                height: 36px;
            }


            .sh-admin-card {
                padding: 0;
                overflow: hidden;
            }

            .sh-pagination-container { padding: 16px; }

            .sh-pagination-container { padding: 16px; }

        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title">{{ __('admin.models-2.index.title') }}</h1>
        <p class="page-subtitle">{{ __('admin.models-2.index.subtitle') }}</p>
    </div>


    <div class="sh-management-header">
        <div class="sh-filter-container">
            <a href="{{ route('admin.models.index') }}"
                class="sh-filter-chip {{ !request('status') ? 'active' : '' }}">{{ __('admin.models-2.index.filters.all') }}</a>
            <a href="{{ route('admin.models.index', ['status' => 'pending']) }}"
                class="sh-filter-chip {{ request('status') == 'pending' ? 'active' : '' }}">{{ __('admin.models-2.index.filters.pending') }}</a>
            <a href="{{ route('admin.models.index', ['status' => 'approved']) }}"
                class="sh-filter-chip {{ request('status') == 'approved' ? 'active' : '' }}">{{ __('admin.models-2.index.filters.verified') }}</a>
        </div>

        <div class="sh-search-row">
            <form action="{{ route('admin.models.index') }}" method="GET" class="sh-search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="sh-search-input" placeholder="{{ __('admin.models-2.index.filters.search') }}"
                    value="{{ request('search') }}">
            </form>
        </div>
    </div>


    <div class="sh-admin-card">
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="sh-modern-table">
                    <thead>
                        <tr>
                            <th>{{ __('admin.models-2.index.table.model') }}</th>
                            <th>{{ __('admin.models-2.index.table.status_verification') }}</th>
                            <th>{{ __('admin.models-2.index.table.registration') }}</th>
                            <th style="text-align: right;">{{ __('admin.models-2.index.table.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            @php
                                $profile = $user->profile;
                            @endphp
                            <tr>
                                <td>
                                    <div class="sh-model-profile">
                                        <div class="sh-model-avatar-wrapper">
                                            <img src="{{ $profile->avatar_url ?? asset('images/default-avatar.png') }}"
                                                class="sh-model-avatar" alt="{{ $user->name }}"
                                                onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                                            <span
                                                class="sh-status-indicator {{ $profile?->is_online ? 'sh-status-online' : 'sh-status-offline' }}"></span>
                                        </div>
                                        <div class="sh-model-details">
                                            <span class="sh-model-name">{{ $user->name }}</span>
                                            <span class="sh-model-email">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; flex-direction: column; gap: 8px; align-items: flex-start;">
                                        @if($profile?->is_streaming)
                                            <span class="sh-status-pill sh-status-pill-streaming">{{ __('admin.models-2.index.table.live') }}</span>
                                        @endif

                                        @php
                                            $status = $profile->verification_status ?? 'pending';
                                            $statusLabel = [
                                                'pending' => __('admin.models-2.index.table.status.pending'),
                                                'under_review' => __('admin.models-2.index.table.status.under_review'),
                                                'approved' => __('admin.models-2.index.table.status.approved'),
                                                'rejected' => __('admin.models-2.index.table.status.rejected')
                                            ][$status] ?? __('admin.models-2.index.table.status.default');

                                            $badgeClass = match ($status) {
                                                'approved' => 'sh-badge-verified',
                                                'pending' => 'sh-badge-fan',
                                                default => 'sh-badge-admin'
                                            };
                                        @endphp
                                        <span class="sh-badge {{ $badgeClass }}">
                                            <i class="fas {{ $status === 'approved' ? 'fa-check-circle' : 'fa-clock' }}"></i>
                                            {{ $statusLabel }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; flex-direction: column;">
                                        <span
                                            style="font-size: 14px; font-weight: 600; color: #fff;">{{ $user->created_at->format('d/m/Y') }}</span>
                                        <span
                                            style="font-size: 12px; color: rgba(255,255,255,0.4);">{{ $user->created_at->diffForHumans() }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="sh-action-group">
                                        <a href="{{ route('profiles.show', $user) }}" target="_blank" class="sh-btn-action"
                                            title="{{ __('admin.models-2.index.table.view_profile') }}">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        <a href="{{ route('admin.models.show', $user) }}" class="sh-btn-action"
                                            title="{{ __('admin.models-2.index.table.view_details') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="sh-pagination-container">
                {{ $users->links('custom.pagination') }}
            </div>

        @else
            <div style="padding: 80px 24px; text-align: center; color: rgba(255,255,255,0.2);">
                <i class="fas fa-user-slash" style="font-size: 4rem; margin-bottom: 24px; opacity: 0.5;"></i>
                <h3 style="color: #fff; font-weight: 800; margin-bottom: 8px;">{{ __('admin.models-2.index.empty.title') }}</h3>
                <p style="font-size: 15px; max-width: 400px; margin: 0 auto;">{{ __('admin.models-2.index.empty.subtitle') }}</p>
                <a href="{{ route('admin.models.index') }}"
                    style="margin-top: 24px; display: inline-block; color: var(--admin-gold); font-weight: 600; text-decoration: none;">{{ __('admin.models-2.index.empty.clear_filters') }}</a>
            </div>
        @endif
    </div>
@endsection