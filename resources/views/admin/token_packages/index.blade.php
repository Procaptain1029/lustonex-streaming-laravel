@extends('layouts.admin')

@section('title', __('admin.token_packages.title'))

@section('breadcrumb')
    <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.dashboard.title') }}</a></span>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-item active">{{ __('admin.token_packages.breadcrumb') }}</span>
@endsection

@section('styles')
    <style>
        .page-header {
            margin-bottom: 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        
        .page-title i {
            color: var(--admin-gold);
        }

        .sh-admin-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 32px;
            animation: fadeIn 0.3s ease-out;
        }

        .sh-modern-table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .sh-modern-table th {
            font-size: 14px;
            font-weight: 700;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.03);
            text-align: left;
            color: rgba(255, 255, 255, 0.8);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .sh-modern-table tbody tr {
            transition: background 0.2s ease-out;
        }

        .sh-modern-table tbody tr:hover td {
            background: rgba(255, 255, 255, 0.03);
        }

        .sh-modern-table td {
            padding: 16px;
            font-size: 14px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            color: rgba(255, 255, 255, 0.9);
            vertical-align: middle;
        }

        .sh-btn-create {
            background: linear-gradient(135deg, var(--admin-gold), #f4e37d);
            color: #000;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .sh-btn-create:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4);
            color: #000;
        }

        .sh-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .sh-status-active {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .sh-status-inactive {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }
        
        .sh-badge-time {
            background: rgba(139, 92, 246, 0.15);
            color: #8b5cf6;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 600;
            border: 1px solid rgba(139, 92, 246, 0.2);
        }

        .sh-action-buttons {
            display: flex;
            gap: 8px;
        }

        .sh-btn-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .sh-btn-icon.edit:hover {
            background: rgba(59, 130, 246, 0.15);
            color: #3b82f6;
            border-color: rgba(59, 130, 246, 0.3);
        }

        .sh-btn-icon.delete:hover {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
            border-color: rgba(239, 68, 68, 0.3);
        }

        .token-amount {
            color: var(--admin-gold);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 1.1rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .mobile-view {
            display: none;
        }
        
        /* Mobile Card Styling */
        .sh-mobile-cards {
            display: flex;
            flex-direction: column;
            gap: 16px;
            padding: 16px;
        }

        .sh-mobile-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .sh-mobile-card-header {
            padding: 16px;
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sh-mobile-card-title {
            font-weight: 700;
            font-size: 1rem;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sh-mobile-card-id {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.4);
            font-weight: 500;
        }

        .sh-mobile-card-price {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--admin-gold);
        }

        .sh-mobile-card-body {
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .sh-mobile-stat {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
        }

        .sh-mobile-stat-label {
            color: rgba(255, 255, 255, 0.5);
            font-weight: 600;
        }

        .sh-mobile-card-actions {
            padding: 12px 16px;
            display: flex;
            gap: 10px;
            background: rgba(0, 0, 0, 0.1);
            border-top: 1px solid rgba(255, 255, 255, 0.02);
        }

        /* Responsive Improvements */
        @media (max-width: 768px) {
            .desktop-view {
                display: none !important;
            }
            .mobile-view {
                display: block;
            }
            .page-header {
                flex-direction: column;
                align-items: stretch;
                gap: 16px;
                margin-bottom: 24px;
            }
            .page-title {
                word-wrap: break-word;
            }

            .sh-btn-create {
                width: 100%;
                justify-content: center;
                text-align: center;
                box-sizing: border-box;
            }
            /* Override background for cards view */
            .sh-admin-card {
                padding: 0;
                background: transparent;
                border: none;
            }
        }
        
        @media (max-width: 480px) {
            .sh-action-buttons {
                flex-direction: row;
                gap: 8px;
            }
            .sh-btn-create {
                padding: 14px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title"> {{ __('admin.token_packages.title') }}</h1>
        <a href="{{ route('admin.token-packages.create') }}" class="sh-btn-create">
            <i class="fas fa-plus"></i> {{ __('admin.token_packages.add_button') }}
        </a>
    </div>

        <div class="table-responsive desktop-view">
            <table class="sh-modern-table">
                <thead>
                    <tr>
                        <th>{{ __('admin.token_packages.table.id') }}</th>
                        <th>{{ __('admin.token_packages.table.name_tokens') }}</th>
                        <th>{{ __('admin.token_packages.table.price') }}</th>
                        <th>{{ __('admin.token_packages.table.bonus') }}</th>
                        <th>{{ __('admin.token_packages.table.features') }}</th>
                        <th>{{ __('admin.token_packages.table.status') }}</th>
                        <th>{{ __('admin.token_packages.table.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($packages as $package)
                        <tr>
                            <td style="color: rgba(255,255,255,0.5);">#{{ $package->id }}</td>
                            <td>
                                <div style="font-weight: 600; margin-bottom: 4px;">{{ $package->name }}</div>
                                <div class="token-amount">
                                    <i class="fas fa-coins"></i> {{ number_format($package->tokens) }}
                                </div>
                            </td>
                            <td>
                                <span style="font-size: 1.1rem; font-weight: 600;">${{ number_format($package->price, 2) }}</span>
                            </td>
                            <td>
                                @if($package->bonus > 0)
                                    <span style="color: #10b981; font-weight: 600;">+{{ number_format($package->bonus) }}</span>
                                @else
                                    <span style="color: rgba(255,255,255,0.3);">-</span>
                                @endif
                            </td>
                            <td>
                                @if($package->is_limited_time)
                                    <div class="sh-badge-time mb-1">
                                        <i class="fas fa-clock"></i> {{ __('admin.token_packages.features.limited_time') }}
                                    </div>
                                    <div style="font-size: 0.75rem; color: rgba(255,255,255,0.5);">
                                        {{ __('admin.token_packages.features.expires') }} <span class="local-date" data-utc="{{ $package->expires_at ? $package->expires_at->format('Y-m-d\TH:i:s\Z') : '' }}">
                                            {{ $package->expires_at ? $package->expires_at->format('d/m/Y H:i') : 'N/A' }}
                                        </span>
                                    </div>
                                @else
                                    <span style="color: rgba(255,255,255,0.3); font-size: 0.85rem;">{{ __('admin.token_packages.features.permanent') }}</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $isExpired = $package->is_limited_time && $package->expires_at && $package->expires_at->isPast();
                                @endphp
                                
                                @if($isExpired)
                                    <span class="sh-status-pill sh-status-inactive" style="background: rgba(139, 92, 246, 0.15); color: #8b5cf6; border-color: rgba(139, 92, 246, 0.2);"><i class="fas fa-clock"></i> {{ __('admin.token_packages.status.expired') }}</span>
                                @elseif($package->is_active)
                                    <span class="sh-status-pill sh-status-active"><i class="fas fa-check-circle"></i> {{ __('admin.token_packages.status.active') }}</span>
                                @else
                                    <span class="sh-status-pill sh-status-inactive"><i class="fas fa-times-circle"></i> {{ __('admin.token_packages.status.inactive') }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="sh-action-buttons">
                                    <a href="{{ route('admin.token-packages.edit', $package) }}" class="sh-btn-icon edit" title="{{ __('admin.token_packages.actions.edit') }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.token-packages.destroy', $package) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('admin.token_packages.actions.delete_confirm') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="sh-btn-icon delete" title="{{ __('admin.token_packages.actions.delete') }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center" style="padding: 40px;">
                                <div style="color: rgba(255,255,255,0.5); display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                    <i class="fas fa-box-open" style="font-size: 32px; color: rgba(255,255,255,0.2);"></i>
                                    <p style="margin: 0; font-size: 16px;">{{ __('admin.token_packages.empty') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mobile-view">
            <div class="sh-mobile-cards">
                @forelse($packages as $package)
                    <div class="sh-mobile-card">
                        <div class="sh-mobile-card-header">
                            <div>
                                <div class="sh-mobile-card-title">{{ $package->name }} <span class="sh-mobile-card-id">#{{ $package->id }}</span></div>
                                <div class="token-amount mt-1">
                                    <i class="fas fa-coins"></i> {{ number_format($package->tokens) }}
                                </div>
                            </div>
                            <div class="sh-mobile-card-price">
                                ${{ number_format($package->price, 2) }}
                            </div>
                        </div>

                        <div class="sh-mobile-card-body">
                            <div class="sh-mobile-stat">
                                <span class="sh-mobile-stat-label">{{ __('admin.token_packages.table.bonus') }}</span>
                                @if($package->bonus > 0)
                                    <span style="color: #10b981; font-weight: 700;">+{{ number_format($package->bonus) }}</span>
                                @else
                                    <span style="color: rgba(255,255,255,0.3);">-</span>
                                @endif
                            </div>
                            
                            <div class="sh-mobile-stat">
                                <span class="sh-mobile-stat-label">{{ __('admin.token_packages.table.features') }}</span>
                                @if($package->is_limited_time)
                                    <div style="text-align: right;">
                                        <div class="sh-badge-time mb-1" style="display: inline-block;">
                                            <i class="fas fa-clock"></i> {{ __('admin.token_packages.features.limited_time') }}
                                        </div>
                                        <div style="font-size: 0.75rem; color: rgba(255,255,255,0.5);">
                                            <span class="local-date" data-utc="{{ $package->expires_at ? $package->expires_at->format('Y-m-d\TH:i:s\Z') : '' }}">
                                                {{ $package->expires_at ? $package->expires_at->format('d/m/Y H:i') : 'N/A' }}
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <span style="color: rgba(255,255,255,0.4); font-size: 0.85rem;">{{ __('admin.token_packages.features.permanent') }}</span>
                                @endif
                            </div>

                            <div class="sh-mobile-stat">
                                <span class="sh-mobile-stat-label">{{ __('admin.token_packages.table.status') }}</span>
                                @php
                                    $isExpired = $package->is_limited_time && $package->expires_at && $package->expires_at->isPast();
                                @endphp
                                
                                @if($isExpired)
                                    <span class="sh-status-pill sh-status-inactive" style="background: rgba(139, 92, 246, 0.15); color: #8b5cf6; border-color: rgba(139, 92, 246, 0.2); padding: 4px 8px;"><i class="fas fa-clock"></i> {{ __('admin.token_packages.status.expired') }}</span>
                                @elseif($package->is_active)
                                    <span class="sh-status-pill sh-status-active" style="padding: 4px 8px;"><i class="fas fa-check-circle"></i> {{ __('admin.token_packages.status.active') }}</span>
                                @else
                                    <span class="sh-status-pill sh-status-inactive" style="padding: 4px 8px;"><i class="fas fa-times-circle"></i> {{ __('admin.token_packages.status.inactive') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="sh-mobile-card-actions">
                            <a href="{{ route('admin.token-packages.edit', $package) }}" class="sh-btn-icon edit" style="flex: 1; justify-content: center; border-radius: 8px;">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('admin.token-packages.destroy', $package) }}" method="POST" class="d-inline" style="flex: 1;" onsubmit="return confirm('{{ __('admin.token_packages.actions.delete_confirm') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="sh-btn-icon delete" style="width: 100%; justify-content: center; border-radius: 8px;">
                                    <i class="fas fa-trash"></i> Borrar
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center" style="padding: 40px;">
                        <div style="color: rgba(255,255,255,0.5); display: flex; flex-direction: column; align-items: center; gap: 10px;">
                            <i class="fas fa-box-open" style="font-size: 32px; color: rgba(255,255,255,0.2);"></i>
                            <p style="margin: 0; font-size: 16px;">{{ __('admin.token_packages.empty') }}</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.local-date').forEach(el => {
            const utcStr = el.getAttribute('data-utc');
            if (utcStr) {
                const date = new Date(utcStr);
                if (!isNaN(date)) {
                    // Format as DD/MM/YYYY HH:mm
                    const day = String(date.getDate()).padStart(2, '0');
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const year = date.getFullYear();
                    const hours = String(date.getHours()).padStart(2, '0');
                    const minutes = String(date.getMinutes()).padStart(2, '0');
                    el.innerText = `${day}/${month}/${year} ${hours}:${minutes}`;
                }
            }
        });
    });
</script>
@endsection
