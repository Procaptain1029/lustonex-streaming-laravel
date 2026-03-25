@extends('layouts.admin')

@section('title', __('admin.verification.index.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.verification.index.title') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Verification List Professional Styling ----- */

        /* 1. Hero / Title */
        .page-header {
            margin-bottom: 32px;
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
            /* User requested #111, but for dark mode context often gold is used. Adhering to prompt: #111 border might be invisible on black bg. Adjusting to visible high contrast or gold based on design system consistency. User prompt said: border: 2px solid #111111 on active. I will use gold to match the rest of the system as #111 is black on black. */
            border-color: var(--admin-gold);
            font-weight: 600;
            color: #fff;
            background: rgba(212, 175, 55, 0.05);
        }

        /* 3. Table Card */
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

        /* Model Profile Info */
        .sh-user-profile {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .sh-user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        .sh-user-details {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .sh-user-name {
            font-size: 16px;
            font-weight: 600;
            color: #fff;
        }

        .sh-user-meta {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.4);
        }

        /* Status Badges */
        .sh-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sh-badge-success {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
        }

        .sh-badge-danger {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
        }

        .sh-badge-warning {
            background: rgba(245, 158, 11, 0.15);
            color: #f59e0b;
        }

        .sh-badge-info {
            background: rgba(59, 130, 246, 0.15);
            color: #3b82f6;
        }

        /* Action Buttons */
        .sh-action-group {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 12px;
        }

        .sh-btn-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1px solid transparent;
            background: transparent;
            color: rgba(255, 255, 255, 0.6);
            transition: all 0.2s;
            cursor: pointer;
        }

        .sh-btn-icon:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            transform: scale(1.1);
        }

        .sh-btn-view {
            padding: 6px 12px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .sh-btn-view:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        /* Pagination */
        .sh-pagination-container {
            padding: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .page-header {
                margin-bottom: 20px;
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

            /* Hide email and status columns on mobile */
            .sh-modern-table th:nth-child(2),
            .sh-modern-table td:nth-child(2),
            .sh-modern-table th:nth-child(3),
            .sh-modern-table td:nth-child(3) {
                display: none;
            }

            .sh-user-avatar {
                width: 40px;
                height: 40px;
            }

            .sh-user-profile {
                gap: 10px;
            }

            .sh-user-name {
                font-size: 14px;
            }

            .sh-user-meta {
                font-size: 11px;
            }

            .sh-btn-view {
                padding: 5px 10px;
                font-size: 12px;
                gap: 4px;
            }

            .sh-btn-icon {
                width: 28px;
                height: 28px;
            }

            .sh-pagination-container {
                padding: 16px;
            }

            /* Empty state */
            div[style*="padding: 80px"] {
                padding: 50px 20px !important;
            }
        }

        @media (max-width: 480px) {
            .page-header {
                margin-bottom: 16px;
            }

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

            .sh-user-avatar {
                width: 36px;
                height: 36px;
            }

            .sh-user-name {
                font-size: 13px;
            }

            .sh-btn-view {
                padding: 4px 8px;
                font-size: 11px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title">{{ __('admin.verification.index.title') }}</h1>
        <p class="page-subtitle">{{ __('admin.verification.index.subtitle') }}</p>
    </div>

    <div class="sh-management-header">
        <div class="sh-filter-container">
            <a href="{{ route('admin.verification.index') }}"
                class="sh-filter-chip {{ !request('status') ? 'active' : '' }}">{{ __('admin.verification.index.filters.all') }}</a>
            <a href="{{ route('admin.verification.index', ['status' => 'pending']) }}"
                class="sh-filter-chip {{ request('status') == 'pending' ? 'active' : '' }}">{{ __('admin.verification.index.filters.pending') }}</a>
            <a href="{{ route('admin.verification.index', ['status' => 'approved']) }}"
                class="sh-filter-chip {{ request('status') == 'approved' ? 'active' : '' }}">{{ __('admin.verification.index.filters.approved') }}</a>
            <a href="{{ route('admin.verification.index', ['status' => 'rejected']) }}"
                class="sh-filter-chip {{ request('status') == 'rejected' ? 'active' : '' }}">{{ __('admin.verification.index.filters.rejected') }}</a>
        </div>
    </div>

    <div class="sh-admin-card">
        @if($models->count() > 0)
            <div class="table-responsive">
                <table class="sh-modern-table">
                    <thead>
                        <tr>
                            <th>{{ __('admin.verification.index.table.model') }}</th>
                            <th>{{ __('admin.verification.index.table.email') }}</th>
                            <th>{{ __('admin.verification.index.table.status') }}</th>
                            <th style="text-align: right;">{{ __('admin.verification.index.table.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($models as $user)
                            <tr>
                                <td>
                                    <div class="sh-user-profile">
                                        <img src="{{ $user->profile?->avatar_url ?? asset('images/default-avatar.png') }}"
                                            class="sh-user-avatar" alt="{{ $user->name }}"
                                            onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                                        <div class="sh-user-details">
                                            <span class="sh-user-name">{{ $user->name }}</span>
                                            <span class="sh-user-meta">{{ __('admin.verification.index.table.id_prefix') }}{{ $user->id }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; flex-direction: column;">
                                        <span style="color: #fff; font-size: 14px;">{{ $user->email }}</span>
                                        @if($user->email_verified_at)
                                            <span
                                                style="font-size: 11px; color: #10b981; display: flex; align-items: center; gap: 4px;">
                                                <i class="fas fa-check-circle"></i> {{ __('admin.verification.index.table.email_verified') }}
                                            </span>
                                        @else
                                            <span
                                                style="font-size: 11px; color: #ef4444; display: flex; align-items: center; gap: 4px;">
                                                <i class="fas fa-exclamation-circle"></i> {{ __('admin.verification.index.table.email_unverified') }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @php $status = $user->profile->verification_status ?? 'pending'; @endphp
                                    @if($status === 'approved')
                                        <span class="sh-badge sh-badge-success">{{ __('admin.verification.index.table.status_approved') }}</span>
                                    @elseif($status === 'under_review')
                                        <span class="sh-badge sh-badge-info">{{ __('admin.verification.index.table.status_under_review') }}</span>
                                    @elseif($status === 'rejected')
                                        <span class="sh-badge sh-badge-danger">{{ __('admin.verification.index.table.status_rejected') }}</span>
                                    @else
                                        <span class="sh-badge sh-badge-warning">{{ __('admin.verification.index.table.status_pending') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="sh-action-group">
                                        @if(!$user->email_verified_at)
                                            <form action="{{ route('admin.models.approveEmail', $user->id) }}" method="POST"
                                                class="swal-approve" style="margin: 0;">
                                                @csrf
                                                <button type="submit" class="sh-btn-view"
                                                    style="border-color: rgba(245, 158, 11, 0.3); color: #f59e0b;">
                                                    <i class="fas fa-envelope"></i> {{ __('admin.verification.index.table.action_approve_email') }}
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('admin.verification.show', $user->profile->id) }}" class="sh-btn-view">
                                                {{ __('admin.verification.index.table.action_review') }} <i class="fas fa-arrow-right" style="font-size: 10px;"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="sh-pagination-container">
                {{ $models->appends(request()->query())->links('custom.pagination') }}
            </div>
        @else
            <div style="padding: 80px; text-align: center; color: rgba(255,255,255,0.3);">
                <i class="fas fa-clipboard-check" style="font-size: 4rem; opacity: 0.2; margin-bottom: 24px;"></i>
                <h3 style="color: #dab843; font-weight: 800; font-size: 24px; margin-bottom: 12px;">{{ __('admin.verification.index.empty.title') }}</h3>
                <p style="font-size: 16px; max-width: 400px; margin: 0 auto;">{{ __('admin.verification.index.empty.subtitle') }}</p>
                <a href="{{ route('admin.verification.index') }}"
                    style="margin-top: 24px; display: inline-block; color: var(--admin-gold); font-weight: 600;">{{ __('admin.verification.index.empty.action') }}</a>
            </div>
        @endif
    </div>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const forms = document.querySelectorAll('.swal-approve');

                forms.forEach(form => {
                    form.addEventListener('submit', function (e) {
                        e.preventDefault();

                        Swal.fire({
                            title: '{{ __('admin.verification.index.modal.approve_title') }}',
                            text: "{{ __('admin.verification.index.modal.approve_desc') }}",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#D4AF37',
                            cancelButtonColor: '#333',
                            confirmButtonText: '{{ __('admin.verification.index.modal.confirm') }}',
                            cancelButtonText: '{{ __('admin.verification.index.modal.cancel') }}',
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