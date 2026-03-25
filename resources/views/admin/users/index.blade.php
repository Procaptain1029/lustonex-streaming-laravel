@extends('layouts.admin')

@section('title', __('admin.users.title'))

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="breadcrumb-item">{{ __('admin.dashboard.title') }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.users.breadcrumb') }}</span>
@endsection

@section('styles')
    <style>
        /* ----- Fans List Professional Styling ----- */

        /* 1. Hero / Title */
        .page-header {
            margin-bottom: 32px;
        }


        /* 2. Management Header (Search & Actions) */
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
            border-radius: 12px;
            padding: 12px 20px 12px 45px;
            color: #fff;
            font-size: 0.95rem;
            /* slightly larger */
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
            text-transform: none;
            /* No uppercase */
            letter-spacing: normal;
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

        /* Remove last child border if desired, but consistent lines are okay */
        .sh-modern-table tr:last-child td {
            border-bottom: none;
        }

        /* User Profile Info */
        .sh-user-profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .sh-user-avatar-wrapper {
            position: relative;
            flex-shrink: 0;
        }

        .sh-user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid rgba(212, 175, 55, 0.2);
        }

        .sh-status-indicator {
            position: absolute;
            bottom: -2px;
            right: -2px;
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

        .sh-user-details {
            display: flex;
            flex-direction: column;
        }

        .sh-user-name {
            font-weight: 700;
            color: #fff;
            font-size: 0.95rem;
        }

        .sh-user-email {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.5);
            /* slightly lighter */
        }

        /* Role & Status Badges */
        .sh-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            /* Adjusted padding */
            border-radius: 20px;
            font-size: 0.75rem;
            /* Larger font */
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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

        .sh-badge-fan {
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sh-status-pill {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .sh-status-pill-active {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .sh-status-pill-inactive {
            background: rgba(107, 114, 128, 0.1);
            color: #9ca3af;
        }

        /* Action Buttons */
        .sh-action-group {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }

        .sh-btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.6);
            transition: all 0.2s ease;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .sh-btn-icon:hover {
            background: rgba(212, 175, 55, 0.1);
            border-color: var(--admin-gold);
            color: var(--admin-gold) !important;
            transform: translateY(-2px);
        }

        .sh-btn-delete:hover {
            background: rgba(239, 68, 68, 0.1);
            border-color: #ef4444;
            color: #ef4444;
        }

        .sh-btn-success:hover {
            background: rgba(16, 185, 129, 0.1);
            border-color: #10b981;
            color: #10b981;
        }

        .sh-pagination-container {
            padding: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            display: flex;
            justify-content: center;
        }

        /* Button Styles (General) */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid transparent;
            /* Ensure border box */
            cursor: pointer;
            transition: all 0.2s ease-out;
        }

        .btn-primary {
            background: linear-gradient(135deg, #D4AF37, #FFD700);
            color: #000;
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(212, 175, 55, 0.3);
            color: #000 !important;
        }

        /* Floating Action Button (FAB) para móvil */
        .btn-fab {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, #D4AF37, #FFD700);
            color: #000;
            display: none;
            /* Oculto por defecto */
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(212, 175, 55, 0.4);
            z-index: 1000;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            padding: 0;
            /* Reset padding for fab */
        }

        .btn-fab i {
            font-size: 1.3rem;
        }

        .btn-fab:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 32px rgba(212, 175, 55, 0.5);
        }

        .btn-fab span {
            display: none;
            /* Ocultar texto en FAB */
        }

        /* Modal Styles - Adapted to new theme */
        .sh-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .sh-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .sh-modal-container {
            background: #18181b;
            /* Darker bg */
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 32px;
            width: 90%;
            max-width: 420px;
            text-align: center;
            transform: scale(0.9);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        .sh-modal-overlay.active .sh-modal-container {
            transform: scale(1);
        }

        .sh-modal-icon-wrapper {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 28px;
        }

        .sh-modal-title {
            color: #fff;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .sh-modal-message {
            color: rgba(255, 255, 255, 0.7);
            font-size: 16px;
            margin-bottom: 32px;
            line-height: 1.6;
        }

        .sh-modal-actions {
            display: flex;
            gap: 16px;
        }

        .sh-modal-btn {
            flex: 1;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            font-size: 14px;
        }

        .sh-modal-cancel {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        .sh-modal-cancel:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .sh-modal-confirm {
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .sh-modal-confirm:hover {
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header {
                margin-bottom: 20px;
            }

            .sh-management-header {

                flex-direction: column;
                align-items: stretch;
                gap: 12px;
                margin-bottom: 20px;
            }

            .sh-search-box {
                min-width: 100%;
            }

            .sh-search-input {
                padding: 10px 16px 10px 40px;
                font-size: 14px;
                border-radius: 10px;
            }

            /* Show FAB on mobile, hide regular button */
            .btn-desktop-add {
                display: none !important;
            }

            .btn-fab {
                display: flex !important;
            }

            /* Hide Status and Date columns on mobile */
            .sh-modern-table th:nth-child(3),
            .sh-modern-table td:nth-child(3),
            .sh-modern-table th:nth-child(4),
            .sh-modern-table td:nth-child(4) {
                display: none;
            }

            .sh-modern-table th {
                font-size: 12px;
                padding: 10px 12px;
            }

            .sh-modern-table td {
                padding: 12px;
            }

            .sh-admin-card {
                padding: 0;
                border-radius: 10px;
            }

            .sh-user-avatar {
                width: 36px;
                height: 36px;
                border-radius: 10px;
            }

            .sh-user-profile {
                gap: 10px;
            }

            .sh-user-name {
                font-size: 13px;
            }

            .sh-user-email {
                font-size: 11px;
            }

            .sh-status-indicator {
                width: 10px;
                height: 10px;
            }

            .sh-badge {
                padding: 3px 8px;
                font-size: 10px;
            }

            .sh-btn-icon {
                width: 28px;
                height: 28px;
                border-radius: 6px;
                font-size: 12px;
            }

            .sh-action-group {
                gap: 6px;
            }

            .sh-pagination-container {
                padding: 16px;
                padding-bottom: 80px;
            }

            .sh-modal-container {
                padding: 24px;
            }

            .sh-modal-icon-wrapper {
                width: 52px;
                height: 52px;
                font-size: 24px;
            }

            .sh-modal-title {
                font-size: 18px;
            }

            .sh-modal-message {
                font-size: 14px;
                margin-bottom: 24px;
            }
        }

        @media (max-width: 480px) {
            /* Also hide Rol column */

            .sh-modern-table th:nth-child(2),
            .sh-modern-table td:nth-child(2) {
                display: none;
            }

            .sh-modern-table th {
                font-size: 11px;
                padding: 8px 10px;
            }

            .sh-modern-table td {
                padding: 10px;
            }

            .sh-user-avatar {
                width: 30px;
                height: 30px;
                border-radius: 8px;
            }

            .sh-user-name {
                font-size: 12px;
            }

            .sh-user-email {
                font-size: 10px;
            }

            .sh-btn-icon {
                width: 26px;
                height: 26px;
                font-size: 11px;
            }

            .btn-fab {
                width: 48px;
                height: 48px;
                bottom: 16px;
                right: 16px;
            }

            .btn-fab i {
                font-size: 1.1rem;
            }

            .sh-modal-container {
                padding: 20px;
            }

            .sh-modal-actions {
                gap: 10px;
            }

            .sh-modal-btn {
                font-size: 13px;
                padding: 10px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title">{{ __('admin.users.header') }}</h1>
        <p class="page-subtitle">{{ __('admin.users.subtitle') }}</p>
    </div>


    <div class="sh-management-header">
        <form action="{{ route('admin.users.index') }}" method="GET" class="sh-search-box">
            <i class="fas fa-search"></i>
            <input type="text" name="search" class="sh-search-input" placeholder="{{ __('admin.users.search_placeholder') }}"
                value="{{ request('search') }}">
        </form>

        <div style="display: flex; gap: 12px;">
            <!-- Desktop button -->
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-desktop-add"
                style="padding: 12px 20px; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-user-plus"></i> <span style="font-weight: 700;">{{ __('admin.users.add_button') }}</span>
            </a>
        </div>
    </div>
    <!-- Mobile FAB -->
    <a href="{{ route('admin.users.create') }}" class="btn-fab" title="{{ __('admin.users.add_button') }}">
        <i class="fas fa-user-plus"></i>
    </a>


    <div class="sh-admin-card">
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="sh-modern-table">
                    <thead>
                        <tr>
                            <th>{{ __('admin.users.table.user') }}</th>
                            <th>{{ __('admin.users.table.role_level') }}</th>
                            <th>{{ __('admin.users.table.status') }}</th>
                            <th>{{ __('admin.users.table.registered') }}</th>
                            <th style="text-align: right;">{{ __('admin.users.table.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="sh-user-profile">
                                        <div class="sh-user-avatar-wrapper">
                                            <img src="{{ $user->profile->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&color=fff' }}"
                                                class="sh-user-avatar" alt="{{ $user->name }}"
                                                onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&color=fff'">
                                            <span
                                                class="sh-status-indicator {{ $user->profile?->is_streaming ? 'sh-status-online' : 'sh-status-offline' }}"></span>
                                        </div>
                                        <div class="sh-user-details">
                                            <span class="sh-user-name">{{ $user->name }}</span>
                                            <span class="sh-user-email">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($user->isAdmin())
                                        <span class="sh-badge sh-badge-admin"><i class="fas fa-shield-alt"></i> {{ __('admin.users.roles.admin') }}</span>
                                    @elseif($user->isModel())
                                        <span class="sh-badge sh-badge-model"><i class="fas fa-star"></i> {{ __('admin.users.roles.model') }}</span>
                                    @else
                                        <span class="sh-badge sh-badge-fan"><i class="fas fa-user"></i> {{ __('admin.users.roles.fan') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->profile?->is_streaming)
                                        <span class="sh-status-pill sh-status-pill-active">{{ __('admin.users.status.online') }}</span>
                                    @else
                                        <span class="sh-status-pill sh-status-pill-inactive">{{ __('admin.users.status.offline') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; flex-direction: column;">
                                        <span
                                            style="font-size: 0.85rem; font-weight: 600;">{{ $user->created_at->format('d/m/Y') }}</span>
                                        <span
                                            style="font-size: 0.75rem; color: rgba(255,255,255,0.3);">{{ $user->created_at->diffForHumans() }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="sh-action-group">

                                        <a href="{{ route('admin.users.show', $user->id) }}" class="sh-btn-icon" title="{{ __('admin.users.actions.view') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="sh-btn-icon" title="{{ __('admin.users.actions.edit') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST"
                                            style="display:inline;"
                                            onsubmit="confirmToggle(event, this, '{{ $user->name }}', {{ $user->is_active }});">
                                            @csrf
                                            <button type="submit"
                                                class="sh-btn-icon {{ $user->is_active ? 'sh-btn-delete' : 'sh-btn-success' }}"
                                                title="{{ $user->is_active ? __('admin.users.actions.disable') : __('admin.users.actions.enable') }}">
                                                <i class="fas {{ $user->is_active ? 'fa-ban' : 'fa-check' }}"></i>
                                            </button>
                                        </form>
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
            <div style="padding: 100px; text-align: center; color: rgba(255,255,255,0.2);">
                <i class="fas fa-users-slash" style="font-size: 4rem; margin-bottom: 20px; opacity: 0.5;"></i>
                <h3 style="color: #fff; font-weight: 800;">{{ __('admin.users.empty.title') }}</h3>
                <p>{{ __('admin.users.empty.description') }}</p>
                <a href="{{ route('admin.users.index') }}"
                    style="margin-top: 15px; display: inline-block; color: var(--admin-gold); font-weight: 700;">{{ __('admin.users.empty.clear') }}</a>
            </div>
        @endif
    </div>


    <div id="confirmModal" class="sh-modal-overlay">
        <div class="sh-modal-container">
            <div class="sh-modal-icon-wrapper">
                <i id="modalIcon" class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 id="modalTitle" class="sh-modal-title">{{ __('admin.users.modal.title') }}</h3>
            <p id="modalMessage" class="sh-modal-message">{{ __('admin.users.modal.message') }}</p>

            <div class="sh-modal-actions">
                <button onclick="closeModal()" class="sh-modal-btn sh-modal-cancel">{{ __('admin.users.modal.cancel') }}</button>
                <button id="confirmBtn" onclick="executeAction()" class="sh-modal-btn sh-modal-confirm">{{ __('admin.users.modal.confirm') }}</button>
            </div>
        </div>
    </div>

    <script>
        let currentForm = null;

        function confirmToggle(event, form, userName, isActive) {
            event.preventDefault();
            currentForm = form;

            const modal = document.getElementById('confirmModal');
            const icon = document.getElementById('modalIcon');
            const title = document.getElementById('modalTitle');
            const message = document.getElementById('modalMessage');
            const confirmBtn = document.getElementById('confirmBtn');

            modal.classList.add('active');

            if (isActive) {
                // Desactivar
                icon.className = 'fas fa-user-slash';
                icon.style.color = '#ef4444'; // Red
                title.innerText = 'Desactivar Usuario';
                message.innerHTML = `¿Estás seguro de suspender a <strong style="color:#fff">${userName}</strong>?<br>No podrá acceder al sistema.`;
                confirmBtn.style.background = 'linear-gradient(135deg, #ef4444, #b91c1c)';
                confirmBtn.innerText = 'Sí, suspender';
            } else {
                // Activar
                icon.className = 'fas fa-user-check';
                icon.style.color = '#10b981'; // Green
                title.innerText = 'Activar Usuario';
                message.innerHTML = `¿Estás seguro de reactivar a <strong style="color:#fff">${userName}</strong>?`;
                confirmBtn.style.background = 'linear-gradient(135deg, #10b981, #059669)';
                confirmBtn.innerText = 'Sí, activar';
            }
        }

        function closeModal() {
            document.getElementById('confirmModal').classList.remove('active');
            currentForm = null;
        }

        function executeAction() {
            if (currentForm) {
                currentForm.submit();
            }
        }

        // Close on outside click
        document.getElementById('confirmModal').addEventListener('click', function (e) {
            if (e.target === this) closeModal();
        });
    </script>
@endsection