@extends('layouts.app')

@section('title', __('notifications.title'))

@section('content')
<div class="container-fluid px-4 py-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">{{ __('notifications.title') }}</h1>
        <div>
            @if($unreadCount > 0)
            <form action="{{ route('fan.notifications.read-all') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-check-double"></i> {{ __('notifications.read_all') }}
                </button>
            </form>
            @endif
            <form action="{{ route('fan.notifications.destroy-all') }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('{{ __('notifications.confirm_destroy_all') }}')">
                    <i class="fas fa-trash"></i> {{ __('notifications.destroy_all') }}
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($notifications->count() > 0)
    <div class="list-group">
        @foreach($notifications as $notification)
        <div class="list-group-item {{ $notification->read_at ? '' : 'list-group-item-primary' }}" 
             id="notification-{{ $notification->id }}">
            <div class="d-flex w-100 justify-content-between align-items-start">
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center mb-2">
                        @if(isset($notification->data['image']) && $notification->data['image'])
                        <img src="{{ $notification->data['image'] }}" 
                             class="rounded-circle me-2" 
                             width="40" 
                             height="40"
                             alt="Avatar">
                        @endif
                        <div>
                            <i class="fas fa-{{ $notification->data['icon'] ?? 'bell' }} text-{{ $notification->data['icon_color'] ?? 'primary' }} me-2"></i>
                            <strong>{{ $notification->data['title'] ?? __('notifications.default_notification') }}</strong>
                        </div>
                    </div>
                    <p class="mb-2">{{ $notification->data['message'] ?? '' }}</p>
                    <small class="text-muted">
                        <i class="fas fa-clock"></i> {{ $notification->created_at->diffForHumans() }}
                    </small>
                </div>
                <div class="ms-3 text-end">
                    @if(isset($notification->data['action_url']))
                    <a href="{{ $notification->data['action_url'] }}" class="btn btn-sm btn-primary mb-2">
                        {{ $notification->data['action_text'] ?? __('notifications.view') }}
                    </a>
                    @endif
                    <div class="btn-group-vertical btn-group-sm">
                        @if(!$notification->read_at)
                        <button type="button" 
                                class="btn btn-outline-secondary mark-as-read" 
                                data-id="{{ $notification->id }}"
                                title="{{ __('notifications.mark_as_read') }}">
                            <i class="fas fa-check"></i>
                        </button>
                        @endif
                        <button type="button" 
                                class="btn btn-outline-danger delete-notification" 
                                data-id="{{ $notification->id }}"
                                title="{{ __('notifications.delete') }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>
    @else
    <div class="text-center py-5">
        <i class="fas fa-bell-slash fa-4x text-muted mb-3"></i>
        <h5 class="text-muted">{{ __('notifications.empty') }}</h5>
        <p class="text-muted">{{ __('notifications.empty_desc') }}</p>
    </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mark as read
    document.querySelectorAll('.mark-as-read').forEach(button => {
        button.addEventListener('click', function() {
            const notificationId = this.dataset.id;
            
            fetch(`/fan/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const notification = document.getElementById(`notification-${notificationId}`);
                    notification.classList.remove('list-group-item-primary');
                    this.remove();
                }
            });
        });
    });

    // Delete notification
    document.querySelectorAll('.delete-notification').forEach(button => {
        button.addEventListener('click', function() {
            if (!confirm('{{ __('notifications.confirm_delete') }}')) return;
            
            const notificationId = this.dataset.id;
            
            fetch(`/fan/notifications/${notificationId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const notification = document.getElementById(`notification-${notificationId}`);
                    notification.style.transition = 'opacity 0.3s';
                    notification.style.opacity = '0';
                    setTimeout(() => notification.remove(), 300);
                }
            });
        });
    });
});
</script>
@endpush
@endsection
