@extends('layouts.admin')

@section('title', __('admin.logs.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.logs.breadcrumb') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Logs Professional Styling ----- */

        /* 1. Hero */
        .page-header {
            margin-bottom: 32px;
        }


        /* 2. Filter Chips */
        .sh-filters-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 32px;
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

        .sh-filter-chip.active i {
            color: #000;
        }

        /* Specific Filter Inputs embedded in bar if needed, or separate row. 
           For "Chips" requirement, we use links for quick filters. 
           We can keep the date/search inputs styled minimally next to them or below. */

        .sh-search-container {
            flex: 1;
            min-width: 200px;
            position: relative;
            margin-left: auto;
            /* Push to right */
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
            padding: 12px 24px;
            text-align: left;
            font-size: 12px;
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

        /* Severity Badges */
        .sh-severity-badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            display: inline-block;
            letter-spacing: 0.5px;
        }

        .severity-info {
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .severity-warning {
            background: rgba(251, 191, 36, 0.15);
            color: #fbbf24;
            border: 1px solid rgba(251, 191, 36, 0.2);
        }

        .severity-error {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .severity-critical {
            background: rgba(220, 38, 38, 0.25);
            color: #ef4444;
            border: 1px solid #ef4444;
            box-shadow: 0 0 5px rgba(239, 68, 68, 0.2);
        }

        /* Log Content */
        .sh-log-message {
            font-weight: 500;
            opacity: 0.9;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .sh-log-meta {
            font-size: 12px;
            opacity: 0.5;
            font-family: 'Space Mono', monospace;
        }

        /* User Cell */
        .sh-user-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sh-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sh-user-info {
            display: flex;
            flex-direction: column;
        }

        .sh-user-name {
            font-weight: 600;
            font-size: 13px;
        }

        .sh-user-role {
            font-size: 11px;
            opacity: 0.5;
        }

        /* Actions */
        .sh-btn-icon {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            background: transparent;
            color: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            cursor: pointer;
            transition: all 0.2s;
            font-size: 12px;
        }

        .sh-btn-icon:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        /* Modal / Details */
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
            max-width: 800px;
            padding: 32px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            transform: scale(0.95);
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .sh-modal-overlay.open .sh-modal-content {
            transform: scale(1);
        }

        .sh-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding-bottom: 16px;
        }

        .sh-payload-box {
            background: rgba(0, 0, 0, 0.3);
            padding: 16px;
            border-radius: 8px;
            font-family: 'Space Mono', monospace;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.8);
            overflow-x: auto;
            border: 1px solid rgba(255, 255, 255, 0.05);
            max-height: 400px;
            overflow-y: auto;
        }

        @media (max-width: 768px) {
            .page-header {
                margin-bottom: 20px;
            }


            .sh-filters-bar {
                gap: 8px;
                margin-bottom: 24px;
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

            /* Hide IP and Date columns */
            .sh-modern-table th:nth-child(4),
            .sh-modern-table td:nth-child(4),
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

            .sh-user-role {
                font-size: 10px;
            }

            .sh-log-message {
                font-size: 13px;
            }

            .sh-log-meta {
                font-size: 11px;
            }

            .sh-severity-badge {
                font-size: 10px;
                padding: 3px 6px;
            }

            .sh-btn-icon {
                width: 26px;
                height: 26px;
                font-size: 11px;
            }

            .sh-modal-content {
                padding: 24px;
                border-radius: 14px;
            }

            .sh-payload-box {
                font-size: 12px;
                padding: 14px;
                max-height: 300px;
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

            /* Also hide User column on very small screens */
            .sh-modern-table th:nth-child(3),
            .sh-modern-table td:nth-child(3) {
                display: none;
            }

            .sh-log-message {
                font-size: 12px;
            }

            .sh-log-meta {
                font-size: 10px;
            }

            .sh-modal-content {
                padding: 20px;
            }

            .sh-payload-box {
                font-size: 11px;
                padding: 12px;
                max-height: 250px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title">{{ __('admin.logs.title_header') }}</h1>
        <p class="page-subtitle">{{ __('admin.logs.subtitle') }}</p>
    </div>

    <!-- Filter Bar -->
    <div class="sh-filters-bar">
        <a href="{{ route('admin.logs.index') }}" class="sh-filter-chip {{ !request('level') ? 'active' : '' }}">{{ __('admin.logs.filters.all') }}</a>
        <a href="?level=error" class="sh-filter-chip {{ request('level') == 'error' ? 'active' : '' }}">
            <i class="fas fa-exclamation-circle" style="color: #ef4444;"></i> {{ __('admin.logs.filters.errors') }}
        </a>
        <a href="?level=warning" class="sh-filter-chip {{ request('level') == 'warning' ? 'active' : '' }}">
            <i class="fas fa-exclamation-triangle" style="color: #fbbf24;"></i> {{ __('admin.logs.filters.warnings') }}
        </a>
        <a href="?level=info" class="sh-filter-chip {{ request('level') == 'info' ? 'active' : '' }}">
            <i class="fas fa-info-circle" style="color: #60a5fa;"></i> {{ __('admin.logs.filters.info') }}
        </a>

        <form class="sh-search-container" method="GET">
            <i class="fas fa-search sh-search-icon"></i>
            <input type="text" name="search" class="sh-search-input" placeholder="{{ __('admin.logs.filters.search') }}"
                value="{{ request('search') }}">
        </form>
    </div>

    <!-- Logs Table -->
    <div class="sh-table-container">
        <div class="table-responsive">
            <table class="sh-modern-table">
                <thead>
                    <tr>
                        <th width="100">{{ __('admin.logs.table.severity') }}</th>
                        <th>{{ __('admin.logs.table.message_event') }}</th>
                        <th>{{ __('admin.logs.table.user') }}</th>
                        <th>{{ __('admin.logs.table.ip') }}</th>
                        <th>{{ __('admin.logs.table.date') }}</th>
                        <th style="text-align: right;">{{ __('admin.logs.table.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>
                                @php
                                    // Mapping severity to style
                                    $level = strtolower($log->level ?? 'info'); // Assuming 'level' field exists
                                    $sevClass = match (true) {
                                        str_contains($level, 'critical') => 'severity-critical',
                                        str_contains($level, 'error') => 'severity-error',
                                        str_contains($level, 'warning') => 'severity-warning',
                                        default => 'severity-info',
                                    };
                                @endphp
                                <span class="sh-severity-badge {{ $sevClass }}">
                                    {{ $log->level ?? 'INFO' }}
                                </span>
                            </td>
                            <td>
                                <div class="sh-log-message">{{ Str::limit($log->message ?? $log->description, 60) }}</div>
                                <div class="sh-log-meta">{{ $log->action ?? 'System Event' }} • ID: {{ $log->id }}</div>
                            </td>
                            <td>
                                <div class="sh-user-cell">
                                    <img src="{{ $log->user?->profile?->avatar_url ?? asset('images/default-avatar.png') }}"
                                        class="sh-avatar" alt="User">
                                    <div class="sh-user-info">
                                        <span class="sh-user-name">{{ $log->user->name ?? __('admin.logs.table.guest') }}</span>
                                        <span class="sh-user-role">#{{ $log->user_id ?? '0' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="font-family: monospace; opacity: 0.7;">{{ $log->ip_address ?? '127.0.0.1' }}</span>
                            </td>
                            <td>
                                <div style="font-size: 13px; font-weight: 600;">{{ $log->created_at->format('d M Y') }}</div>
                                <div style="font-size: 11px; opacity: 0.5;">{{ $log->created_at->format('H:i:s') }}</div>
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                    <button type="button" class="sh-btn-icon" onclick="openLogDetails({{ json_encode($log) }})"
                                        title="{{ __('admin.logs.table.view_payload') }}">
                                        <i class="fas fa-code"></i>
                                    </button>
                                    <!-- Copy ID Button -->
                                    <button type="button" class="sh-btn-icon"
                                        onclick="navigator.clipboard.writeText('{{ $log->id }}')" title="{{ __('admin.logs.table.copy_id') }}">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 60px; color: rgba(255,255,255,0.3);">
                                <i class="fas fa-shield-alt" style="font-size: 3rem; opacity: 0.2; margin-bottom: 20px;"></i>
                                <br>{{ __('admin.logs.table.empty') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div style="padding: 20px; border-top: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: center;">
                {{ $logs->links('custom.pagination') }}
            </div>
        @endif
    </div>

    <!-- Detail Modal -->
    <div id="logModal" class="sh-modal-overlay">
        <div class="sh-modal-content">
            <div class="sh-modal-header">
                <div>
                    <h2 style="font-size: 20px; font-weight: 700; color: #fff; margin-bottom: 5px;">{{ __('admin.logs.modal.title') }}</h2>
                    <div id="modalLogId" style="font-family: monospace; color: var(--admin-gold); opacity: 0.8;">ID: #</div>
                </div>
                <button onclick="closeLogModal()"
                    style="background: none; border: none; color: #fff; font-size: 20px; cursor: pointer;">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div style="margin-bottom: 20px;">
                <label
                    style="display: block; font-size: 12px; text-transform: uppercase; color: rgba(255,255,255,0.5); font-weight: 700; margin-bottom: 8px;">{{ __('admin.logs.modal.message') }}</label>
                <div id="modalMessage" style="font-size: 16px; color: #fff; margin-bottom: 20px;">-</div>

                <label
                    style="display: block; font-size: 12px; text-transform: uppercase; color: rgba(255,255,255,0.5); font-weight: 700; margin-bottom: 8px;">{{ __('admin.logs.modal.payload') }}</label>
                <pre id="modalPayload" class="sh-payload-box">{}</pre>
            </div>

            <div style="display: flex; justify-content: flex-end;">
                <button onclick="closeLogModal()"
                    style="padding: 10px 24px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 8px; cursor: pointer;">{{ __('admin.logs.modal.close') }}</button>
            </div>
        </div>
    </div>

    <script>
        function openLogDetails(log) {
            document.getElementById('modalLogId').textContent = 'ID: ' + log.id;
            document.getElementById('modalMessage').textContent = log.message || log.description;

            // Try to format properties/payload if exists
            let payload = log.properties || log.payload || {};
            try {
                if (typeof payload === 'string') payload = JSON.parse(payload);
            } catch (e) { }

            document.getElementById('modalPayload').textContent = JSON.stringify(payload, null, 2);

            document.getElementById('logModal').classList.add('open');
        }

        function closeLogModal() {
            document.getElementById('logModal').classList.remove('open');
        }
    </script>
@endsection