@extends('layouts.admin')

@section('title', __('admin.reports.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.reports.breadcrumb') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Reports Professional Styling ----- */

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

        .sh-stat-value.gold {
            color: var(--admin-gold);
        }

        .sh-stat-value.green {
            color: #10b981;
        }

        .sh-stat-value.gray {
            color: #9ca3af;
        }

        /* 3. Filter Chips */
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

        /* 4. Table */
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
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sh-user-name {
            font-size: 16px;
            font-weight: 600;
            color: #fff;
        }

        /* Type Tag */
        .sh-type-tag {
            font-size: 12px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            text-transform: capitalize;
        }

        /* Status Badges */
        .sh-badge {
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background: rgba(251, 191, 36, 0.15);
            color: #fbbf24;
            border: 1px solid rgba(251, 191, 36, 0.2);
        }

        .status-resolved {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .status-dismissed {
            background: rgba(156, 163, 175, 0.15);
            color: #9ca3af;
            border: 1px solid rgba(156, 163, 175, 0.2);
        }

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

        .sh-btn-action:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .sh-btn-action.resolve:hover {
            background: rgba(16, 185, 129, 0.2);
            border-color: #10b981;
            color: #10b981;
        }

        .sh-btn-action.dismiss:hover {
            background: rgba(239, 68, 68, 0.2);
            border-color: #ef4444;
            color: #ef4444;
        }

        /* Modal */
        .sh-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
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
            max-width: 700px;
            padding: 32px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        .sh-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding-bottom: 16px;
        }

        .sh-modal-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 30px;
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

            /* Hide Type, Reason, Date columns */
            .sh-modern-table th:nth-child(3),
            .sh-modern-table td:nth-child(3),
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

            .sh-btn-action {
                width: 28px;
                height: 28px;
                border-radius: 6px;
            }

            .sh-modal-content {
                padding: 24px;
                border-radius: 14px;
            }

            .sh-modal-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .sh-modal-grid img {
                width: 48px !important;
                height: 48px !important;
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

            /* Also hide Status column on very small screens */
            .sh-modern-table th:nth-child(5),
            .sh-modern-table td:nth-child(5) {
                display: none;
            }

            .sh-avatar {
                width: 28px;
                height: 28px;
            }

            .sh-user-name {
                font-size: 12px;
            }

            .sh-btn-action {
                width: 26px;
                height: 26px;
            }

            .sh-modal-content {
                padding: 20px;
            }

            .sh-modal-grid img {
                width: 40px !important;
                height: 40px !important;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Hero -->
    <div class="page-header">
        <h1 class="page-title">{{ __('admin.reports.title') }}</h1>
        <p class="page-subtitle">{{ __('admin.reports.subtitle') }}</p>
    </div>

    <!-- Stats -->
    <div class="sh-stats-grid">
        <div class="sh-stat-card">
            <div class="sh-stat-label">{{ __('admin.reports.stats.total') }}</div>
            <div class="sh-stat-value">{{ number_format($stats['total']) }}</div>
            <i class="fas fa-flag sh-stat-icon"></i>
        </div>
        <div class="sh-stat-card">
            <div class="sh-stat-label">{{ __('admin.reports.stats.pending') }}</div>
            <div class="sh-stat-value gold">{{ number_format($stats['pending']) }}</div>
            <i class="fas fa-exclamation-circle sh-stat-icon" style="color: var(--admin-gold);"></i>
        </div>
        <div class="sh-stat-card">
            <div class="sh-stat-label">{{ __('admin.reports.stats.resolved') }}</div>
            <div class="sh-stat-value green">{{ number_format($stats['resolved']) }}</div>
            <i class="fas fa-check-double sh-stat-icon" style="color: #10b981;"></i>
        </div>
        <div class="sh-stat-card">
            <div class="sh-stat-label">{{ __('admin.reports.stats.dismissed') }}</div>
            <div class="sh-stat-value gray">{{ number_format($stats['dismissed']) }}</div>
            <i class="fas fa-trash-alt sh-stat-icon" style="color: #9ca3af;"></i>
        </div>
    </div>

    <!-- Filters -->
    <div class="sh-filters-bar">
        <a href="{{ route('admin.reports.index') }}"
            class="sh-filter-chip {{ !request('status') ? 'active' : '' }}">{{ __('admin.reports.filters.all') }}</a>
        <a href="?status=pending" class="sh-filter-chip {{ request('status') == 'pending' ? 'active' : '' }}">{{ __('admin.reports.filters.pending') }}</a>
        <a href="?status=resolved"
            class="sh-filter-chip {{ request('status') == 'resolved' ? 'active' : '' }}">{{ __('admin.reports.filters.resolved') }}</a>
        <a href="?status=dismissed"
            class="sh-filter-chip {{ request('status') == 'dismissed' ? 'active' : '' }}">{{ __('admin.reports.filters.dismissed') }}</a>

        <form class="sh-search-container" method="GET">
            <i class="fas fa-search sh-search-icon"></i>
            <input type="text" name="search" class="sh-search-input" placeholder="{{ __('admin.reports.filters.search') }}"
                value="{{ request('search') }}">
        </form>
    </div>

    <!-- Table -->
    <div class="sh-table-container">
        <div class="table-responsive">
            <table class="sh-modern-table">
                <thead>
                    <tr>
                        <th>{{ __('admin.reports.table.reported_by') }}</th>
                        <th>{{ __('admin.reports.table.reported_item') }}</th>
                        <th>{{ __('admin.reports.table.type') }}</th>
                        <th>{{ __('admin.reports.table.reason') }}</th>
                        <th>{{ __('admin.reports.table.status') }}</th>
                        <th>{{ __('admin.reports.table.date') }}</th>
                        <th style="text-align: right;">{{ __('admin.reports.table.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <!-- Reporter -->
                            <td>
                                <div class="sh-user-profile">
                                    <img src="{{ $report->reporter?->profile?->avatar_url ?? asset('images/default-avatar.png') }}"
                                        class="sh-avatar" alt="Reporter">
                                    <span class="sh-user-name">{{ $report->reporter->name ?? 'N/A' }}</span>
                                </div>
                            </td>

                            <!-- Reported Entity -->
                            <td>
                                <div class="sh-user-profile">
                                    <img src="{{ $report->reported?->profile?->avatar_url ?? asset('images/default-avatar.png') }}"
                                        class="sh-avatar" style="border-color: var(--admin-gold);" alt="Reported">
                                    <span class="sh-user-name">{{ $report->reported->name ?? __('admin.reports.table.deleted_content') }}</span>
                                </div>
                            </td>

                            <!-- Type -->
                            <td>
                                <span class="sh-type-tag">{{ class_basename($report->reportable_type ?? 'Unknown') }}</span>
                            </td>

                            <!-- Reason -->
                            <td>
                                <span style="opacity: 0.7; font-size: 13px;"
                                    title="{{ $report->reason }}">{{ Str::limit($report->reason, 30) }}</span>
                            </td>

                            <!-- Status -->
                            <td>
                                <span class="sh-badge status-{{ $report->status }}">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </td>

                            <!-- Date -->
                            <td>
                                <div style="font-size: 13px; opacity: 0.7;">{{ $report->created_at->format('d M') }}</div>
                            </td>

                            <!-- Actions -->
                            <td>
                                <div class="sh-actions">
                                    <button type="button" class="sh-btn-action"
                                        onclick="openReportDetails({{ json_encode($report) }})" title="{{ __('admin.reports.table.view_details') }}">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    @if($report->status === 'pending')
                                        <form action="{{ route('admin.reports.resolve', $report) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="sh-btn-action resolve" title="{{ __('admin.reports.table.resolve') }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.reports.dismiss', $report) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="sh-btn-action dismiss" title="{{ __('admin.reports.table.dismiss') }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 80px; color: rgba(255,255,255,0.3);">
                                <i class="fas fa-shield-alt" style="font-size: 4rem; opacity: 0.1; margin-bottom: 20px;"></i>
                                <br>{{ __('admin.reports.table.empty') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reports->hasPages())
            <div style="padding: 20px; border-top: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: center;">
                {{ $reports->links('custom.pagination') }}
            </div>
        @endif
    </div>

    <!-- Detail Modal -->
    <div id="reportModal" class="sh-modal-overlay">
        <div class="sh-modal-content">
            <div class="sh-modal-header">
                <h2 style="font-size: 20px; font-weight: 700; color: #fff; margin: 0;">{{ __('admin.reports.modal.title') }}</h2>
                <button onclick="closeReportModal()"
                    style="background: none; border: none; color: #fff; font-size: 20px; cursor: pointer;">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="sh-modal-grid">
                <!-- Reporter Side -->
                <div>
                    <div
                        style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,0.4); margin-bottom: 12px;">
                        {{ __('admin.reports.modal.reported_by') }}</div>
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <img id="modalReporterAvatar" src=""
                            style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 1px solid rgba(255,255,255,0.1);">
                        <div>
                            <div id="modalReporterName" style="font-size: 18px; font-weight: 700; color: #fff;">-</div>
                            <div style="font-size: 13px; opacity: 0.6;">{{ __('admin.reports.modal.reporter_user') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Reported Side -->
                <div>
                    <div
                        style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,0.4); margin-bottom: 12px;">
                        {{ __('admin.reports.modal.reported_content_user') }}</div>
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <img id="modalReportedAvatar" src=""
                            style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid var(--admin-gold);">
                        <div>
                            <div id="modalReportedName" style="font-size: 18px; font-weight: 700; color: #fff;">-</div>
                            <div id="modalType" style="font-size: 13px; color: var(--admin-gold); font-weight: 600;">-</div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="background: rgba(255,255,255,0.03); border-radius: 12px; padding: 20px; margin-bottom: 24px;">
                <div style="font-size: 12px; font-weight: 700; color: rgba(255,255,255,0.5); margin-bottom: 8px;">{{ __('admin.reports.modal.reason_title') }}</div>
                <p id="modalReason" style="font-size: 16px; color: #fff; line-height: 1.5; margin: 0;">-</p>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <button onclick="closeReportModal()"
                    style="padding: 12px 24px; background: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; cursor: pointer;">{{ __('admin.reports.modal.close') }}</button>
                <!-- Actions could be mirrored here if dynamic forms are handled via JS, but for now we keep it simple since index has buttons -->
            </div>
        </div>
    </div>

    <script>
        function openReportDetails(report) {
            // Set Reporter
            document.getElementById('modalReporterName').innerText = report.reporter ? report.reporter.name : 'N/A';
            document.getElementById('modalReporterAvatar').src = report.reporter?.profile?.avatar_url || '/images/default-avatar.png';

            // Set Reported
            document.getElementById('modalReportedName').innerText = report.reported ? report.reported.name : '{{ __('admin.reports.modal.deleted') }}';
            document.getElementById('modalReportedAvatar').src = report.reported?.profile?.avatar_url || '/images/default-avatar.png';

            // Set Details
            let type = report.reportable_type ? report.reportable_type.split('\\').pop() : '{{ __('admin.reports.modal.unknown') }}';
            document.getElementById('modalType').innerText = type;
            document.getElementById('modalReason').innerText = report.reason || '{{ __('admin.reports.modal.no_reason') }}';

            document.getElementById('reportModal').classList.add('open');
        }

        function closeReportModal() {
            document.getElementById('reportModal').classList.remove('open');
        }
    </script>
@endsection