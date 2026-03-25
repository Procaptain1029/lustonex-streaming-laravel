@extends('layouts.model')

@section('title', __('model.notifications.title'))

@section('styles')
<style>
    .notifications-container {
        max-width: 900px;
        margin: 0 auto;
        padding-bottom: 50px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        background: rgba(31, 31, 35, 0.6);
        backdrop-filter: blur(15px);
        padding: 1.5rem;
        border-radius: 20px;
        border: 1px solid rgba(212, 175, 55, 0.1);
    }

    /* Estilos de encabezado heredados del layout model */

    .btn-mark-all {
        background: rgba(212, 175, 55, 0.1);
        border: 1px solid rgba(212, 175, 55, 0.2);
        color: var(--color-oro-sensual, #D4AF37);
        padding: 8px 16px;
        border-radius: 12px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-mark-all:hover {
        background: var(--color-oro-sensual, #D4AF37);
        color: #0b0b0d;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
    }

    .stats-row {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        flex: 1;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        padding: 1rem;
        border-radius: 16px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(212, 175, 55, 0.2);
        transform: translateY(-3px);
    }

    .stat-value {
        font-size: 20px;
        font-weight: 800;
        color: #fff;
        display: block;
    }

    .stat-label {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.4);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .notifications-card {
        background: rgba(31, 31, 35, 0.6);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 24px;
        overflow: hidden;
    }

    .notifications-list {
        display: flex;
        flex-direction: column;
    }

    .notification-item {
        padding: 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
    }

    .notification-item:hover {
        background: rgba(255, 255, 255, 0.02);
    }

    .notification-item.unread {
        background: rgba(212, 175, 55, 0.03);
    }

    .notification-item.unread::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: var(--color-oro-sensual, #D4AF37);
        border-radius: 0 4px 4px 0;
    }

    .notification-item:last-child {
        border-bottom: none;
    }

    .notification-icon-wrapper {
        position: relative;
        flex-shrink: 0;
    }

    .notification-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        transition: all 0.3s ease;
    }

    .notification-icon.info { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
    .notification-icon.success { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .notification-icon.warning { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    .notification-icon.danger { background: rgba(239, 68, 68, 0.1); color: #ef4444; }

    .notification-content {
        flex: 1;
    }

    .notification-title {
        font-size: 16px;
        font-weight: 600;
        color: #fff;
        margin: 0 0 4px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .notification-time {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.3);
        font-weight: 400;
    }

    .notification-message {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.6);
        margin: 0;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .notification-actions {
        display: flex;
        gap: 10px;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .notification-item:hover .notification-actions {
        opacity: 1;
    }

    .btn-action-sm {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .btn-action-sm:hover {
        background: rgba(16, 185, 129, 0.2);
        color: #10b981;
        border-color: #10b981;
        transform: scale(1.1);
    }

    .pagination-wrapper {
        margin-top: 3rem;
        display: flex;
        justify-content: center;
    }

    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
    }

    .empty-icon {
        font-size: 64px;
        margin-bottom: 24px;
        background: var(--gradient-gold, linear-gradient(135deg, #D4AF37, #F4E37D));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: block;
        opacity: 0.5;
    }

    .empty-state h3 {
        font-size: 20px;
        color: #fff;
        margin-bottom: 12px;
    }

    .empty-state p {
        color: rgba(255, 255, 255, 0.4);
        max-width: 300px;
        margin: 0 auto;
    }

    @media (max-width: 768px) {
        .notifications-container {
            padding: 1rem;
        }

        .page-header {
            flex-direction: column;
            gap: 1.25rem;
            align-items: flex-start;
            padding: 1.25rem;
            border-radius: 16px;
        }
        
        .page-title {
            font-size: 28px;
            margin-bottom: 0;
        }

        .btn-mark-all {
            width: 100%;
            justify-content: center;
            padding: 10px 16px;
        }

        .stats-row {
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .stat-card {
            flex: 1 1 45%;
            padding: 1rem;
        }

        .notification-item {
            padding: 1rem;
            gap: 12px;
        }

        .notification-icon {
            width: 44px;
            height: 44px;
            font-size: 16px;
        }

        .notification-title {
            flex-direction: column;
            align-items: flex-start;
            gap: 2px;
        }

        .notification-actions {
            opacity: 1;
            align-self: flex-start;
        }
    }

    @media (max-width: 480px) {
        .notifications-container {
            padding: 0.85rem;
        }

        .page-header {
            padding: 1rem;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .page-title {
            font-size: 24px;
        }

        .stats-row {
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            flex: 1 1 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.85rem 1.25rem;
        }

        .stat-value {
            font-size: 1.1rem;
            order: 2;
        }

        .stat-label {
            order: 1;
        }

        .notification-item {
            padding: 0.85rem;
            gap: 10px;
        }

        .notification-icon {
            width: 38px;
            height: 38px;
            font-size: 14px;
            border-radius: 10px;
        }

        .notification-title {
            font-size: 0.95rem;
            gap: 4px;
        }

        .notification-message {
            font-size: 0.85rem;
            line-height: 1.4;
        }
        
        .btn-action-sm {
            width: 32px;
            height: 32px;
            font-size: 0.85rem;
        }
    }
</style>
@endsection

@section('content')
<div class="notifications-container">
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-bell"></i> {{ __('model.notifications.title_full') }}
        </h1>
        @if($stats['unread'] > 0)
        <button class="btn-mark-all" onclick="markAllAsRead()">
            <i class="fas fa-check-double"></i> {{ __('model.notifications.mark_all_read') }}
        </button>
        @endif
    </div>

    <div class="stats-row">
        <div class="stat-card">
            <span class="stat-value">{{ number_format($stats['total']) }}</span>
            <span class="stat-label">{{ __('model.notifications.stats.total') }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-value" style="color: var(--color-oro-sensual, #D4AF37);">{{ number_format($stats['unread']) }}</span>
            <span class="stat-label">{{ __('model.notifications.stats.unread') }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-value">{{ number_format($stats['today']) }}</span>
            <span class="stat-label">{{ __('model.notifications.stats.today') }}</span>
        </div>
    </div>

    <div class="notifications-card">
        <div class="notifications-list">
            @forelse($notifications as $notification)
            @php
                $data = $notification->data;
                $read = !is_null($notification->read_at);
                $colorClass = $data['color'] ?? 'info';
                $iconClass = $data['icon'] ?? 'fa-bell';
            @endphp
            <div class="notification-item {{ $read ? 'read' : 'unread' }}" data-id="{{ $notification->id }}">
                <div class="notification-icon-wrapper">
                    <div class="notification-icon {{ $colorClass }}">
                        <i class="fas {{ $iconClass }}"></i>
                    </div>
                </div>
                <div class="notification-content">
                    <div class="notification-title">
                        <span>{{ $data['title'] ?? __('model.notifications.default_title') }}</span>
                        <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="notification-message">{{ $data['message'] ?? '' }}</p>
                </div>
                <div class="notification-actions">
                    @if(!$read)
                    <button class="btn-action-sm" onclick="markAsRead('{{ $notification->id }}', event)" title="{{ __('model.notifications.mark_as_read') }}">
                        <i class="fas fa-check"></i>
                    </button>
                    @endif
                </div>
            </div>
            @empty
            <div class="empty-state">
                <span class="empty-icon">
                    <i class="fas fa-bell-slash"></i>
                </span>
                <h3>{{ __('model.notifications.empty.title') }}</h3>
                <p>{{ __('model.notifications.empty.subtitle') }}</p>
            </div>
            @endforelse
        </div>
    </div>

    @if($notifications->hasPages())
    <div class="pagination-wrapper">
        {{ $notifications->links('custom.pagination') }}
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
function markAsRead(id, event) {
    if (event) event.stopPropagation();
    
    fetch(`/model/notifications/${id}/read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const item = document.querySelector(`[data-id="${id}"]`);
            item.classList.remove('unread');
            item.classList.add('read');
            item.querySelector('.btn-action-sm')?.remove();
            
            // Opcional: actualizar contadores sin recargar
            location.reload(); 
        }
    })
    .catch(error => console.error('Error:', error));
}

function markAllAsRead() {
    Swal.fire({
        title: '{{ __('model.notifications.swal.mark_all.title') }}',
        text: "{{ __('model.notifications.swal.mark_all.text') }}",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#D4AF37',
        cancelButtonColor: 'rgba(255,255,255,0.1)',
        confirmButtonText: '{{ __('model.notifications.swal.mark_all.confirm') }}',
        cancelButtonText: '{{ __('model.notifications.swal.cancel') }}',
        background: '#1a1a1f',
        color: '#fff',
        customClass: {
            popup: 'premium-swal-popup',
            confirmButton: 'premium-swal-confirm'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/model/notifications/read-all', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: '{{ __('model.notifications.swal.done.title') }}',
                        text: '{{ __('model.notifications.swal.done.text') }}',
                        icon: 'success',
                        background: '#1a1a1f',
                        color: '#fff',
                        confirmButtonColor: '#D4AF37',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: '{{ __('model.notifications.swal.error.title') }}',
                    text: '{{ __('model.notifications.swal.error.text') }}',
                    icon: 'error',
                    background: '#1a1a1f',
                    color: '#fff',
                    confirmButtonColor: '#D4AF37'
                });
            });
        }
    });
}
</script>
@endsection
