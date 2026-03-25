@extends('layouts.model')

@section('title', __('model.chat.index.title'))

@section('styles')
<style>
    :root {
        --chat-bg: #0a0a0c;
        --card-bg: rgba(18, 18, 22, 0.8);
        --accent-gold: #d4af37;
        --gradient-gold: linear-gradient(135deg, #d4af37 0%, #f9e29c 50%, #b8860b 100%);
    }

    body {
        background: #050505;
    }

    .chat-container {
        padding: 2rem 1rem;
        max-width: 900px;
        margin: 0 auto;
        min-height: 100vh;
        position: relative;
    }

    .ambient-glow {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            radial-gradient(circle at 5% 10%, rgba(212, 175, 55, 0.03) 0%, transparent 35%),
            radial-gradient(circle at 95% 90%, rgba(212, 175, 55, 0.03) 0%, transparent 35%);
        z-index: -1;
        pointer-events: none;
    }

    .premium-header {
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        background: rgba(20, 20, 24, 0.4);
        padding: 1.5rem;
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.03);
    }

    .page-title {
        font-family: 'Poppins', sans-serif;
        font-size: 40px;
        font-weight: 700;
        color: #d4af37;
        margin-bottom: 16px;
        line-height: 1.2;
    }

    .page-subtitle {
        font-size: 18px;
        color: #ffffff;
        max-width: 620px;
        margin-bottom: 32px;
    }

    /* Search & Filters */
    .chat-controls {
        display: flex;
        gap: 12px;
        margin-bottom: 1.5rem;
    }

    .search-box {
        flex: 1;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 10px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s;
    }

    .search-box:focus-within {
        background: rgba(255, 255, 255, 0.04);
        border-color: rgba(212, 175, 55, 0.2);
    }

    .search-box input {
        background: transparent;
        border: none;
        color: #fff;
        width: 100%;
        outline: none;
        font-size: 0.9rem;
    }

    /* Filter pill group */
    .filter-group {
        display: flex;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
    }

    .filter-btn {
        padding: 10px 20px;
        background: transparent;
        border: none;
        border-right: 1px solid rgba(255, 255, 255, 0.05);
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .filter-btn:last-child {
        border-right: none;
    }

    .filter-btn:hover, .filter-btn.active {
        background: rgba(212, 175, 55, 0.1);
        color: var(--accent-gold);
    }

    /* Conversation Cards */
    .conversations-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .conversation-card {
        display: flex;
        align-items: center;
        background: rgba(20, 20, 24, 0.6);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.04);
        border-radius: 18px;
        padding: 1rem 1.25rem;
        transition: all 0.3s ease;
        text-decoration: none;
        color: #fff;
        position: relative;
    }

    .conversation-card:hover {
        transform: translateX(5px);
        background: rgba(255, 255, 255, 0.02);
        border-color: rgba(212, 175, 55, 0.15);
    }

    .conversation-card.unread {
        border-left: 3px solid var(--accent-gold);
        background: rgba(212, 175, 55, 0.03);
    }

    .avatar-section {
        position: relative;
        margin-right: 1.25rem;
    }

    .avatar-frame {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        object-fit: cover;
        border: 1px solid rgba(255, 255, 255, 0.05);
        background: #111;
        transition: all 0.3s ease;
    }

    .conversation-card:hover .avatar-frame {
        border-color: var(--accent-gold);
        transform: scale(1.05);
    }

    .status-dot {
        position: absolute;
        bottom: -2px;
        right: -2px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: #10b981;
        border: 3px solid #0a0a0c;
    }

    .card-main {
        flex: 1;
        min-width: 0;
    }

    .model-name {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.05rem;
        margin-bottom: 2px;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .preview-text {
        color: rgba(255, 255, 255, 0.3);
        font-size: 0.9rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin: 0;
        max-width: 90%;
    }

    .conversation-card.unread .preview-text {
        color: rgba(255, 255, 255, 0.8);
        font-weight: 500;
    }

    .card-end {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 6px;
        margin-left: 1.5rem;
        flex-shrink: 0;
    }

    .time-badge {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.2);
        font-weight: 600;
        text-transform: uppercase;
    }

    .unread-bubble {
        background: var(--gradient-gold);
        color: #000;
        font-weight: 800;
        font-size: 0.7rem;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .expiration-tag {
        font-size: 0.6rem;
        color: var(--accent-gold);
        background: rgba(212, 175, 55, 0.1);
        padding: 1px 6px;
        border-radius: 4px;
        border: 1px solid rgba(212, 175, 55, 0.2);
        font-weight: 700;
        text-transform: uppercase;
    }

    .empty-container {
        text-align: center;
        padding: 5rem 2rem;
        background: rgba(255, 255, 255, 0.01);
        border-radius: 24px;
        border: 1px dashed rgba(255, 255, 255, 0.05);
    }

    @media (max-width: 768px) {
        .chat-container { 
            padding: 1rem; 
        }

        .premium-header { 
            flex-direction: column; 
            align-items: flex-start; 
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            border-radius: 18px;
            gap: 10px;
        }

        .page-title { 
            font-size: 28px;
            margin-bottom: 16px;
        }

        .page-subtitle {
            font-size: 16px;
            margin-bottom: 18px;
            color: #fff;
        }

        .chat-controls {
            flex-direction: column;
            gap: 10px;
        }

        .filter-btn {
            justify-content: center;
        }

        /* Group the filter buttons in a row on mobile */
        .chat-controls-filters {
            display: flex;
            gap: 10px;
            width: 100%;
        }

        .chat-controls-filters .filter-btn {
            flex: 1;
        }

        .conversation-card {
            padding: 1rem;
            border-radius: 16px;
        }

        .avatar-frame { 
            width: 48px; 
            height: 48px; 
            border-radius: 12px;
        }

        .avatar-section {
            margin-right: 1rem;
        }

        .model-name { 
            font-size: 1rem; 
        }
    }

    /* Small Mobile Responsive */
    @media (max-width: 480px) {
        .page-title { 
            font-size: 24px; 
        }

        .page-subtitle {
            font-size: 14px;
        }

        .premium-header {
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .chat-controls-filters {
            flex-direction: column;
        }

        .conversation-card {
            padding: 0.85rem;
            gap: 0;
        }

        .avatar-frame {
            width: 42px;
            height: 42px;
            border-radius: 10px;
        }

        .avatar-section {
            margin-right: 0.85rem;
        }

        .model-name {
            font-size: 0.95rem;
        }

        .preview-text {
            font-size: 0.85rem;
        }

        .card-end {
            margin-left: 0.75rem;
        }

        .time-badge {
            font-size: 0.65rem;
        }
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        margin-top: 2rem;
        padding: 0.85rem 2.5rem;
        background: var(--gradient-gold);
        color: #000;
        border-radius: 14px;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 10px 20px rgba(212, 175, 55, 0.2);
        font-size: 0.95rem;
    }

    .btn-action:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 15px 30px rgba(212, 175, 55, 0.4);
        filter: brightness(1.1);
    }
</style>
@endsection

@section('content')
<div class="ambient-glow"></div>

<div class="chat-container">
    <div class="premium-header">
        <div>
            <h1 class="page-title">{{ __('chat.index.title') }}</h1>
            <p class="page-subtitle">{{ __('chat.index.subtitle') }}</p>
        </div>
        <div class="header-actions">
        </div>
    </div>

    <div class="chat-controls">
        <div class="search-box">
            <i class="fas fa-search" style="opacity: 0.3;"></i>
            <input type="text" placeholder="{{ __('chat.index.search_placeholder') }}" id="chat-search">
        </div>
        <div class="filter-group">
            <button class="filter-btn active">
                <i class="fas fa-layer-group"></i> {{ __('chat.index.filters.all') }}
            </button>
            <button class="filter-btn">
                <i class="fas fa-envelope-open-text"></i> {{ __('chat.index.filters.unread') }}
            </button>
        </div>
    </div>

    @if($conversations->count() > 0)
        <div class="conversations-list">
            @foreach($conversations as $conv)
                @php
                    $otherUser = $conv['other_user'];
                    $isUnread = $conv['unread_count'] > 0;
                    // Supongamos que pasamos un flag de expiración o lo calculamos aquí
                    // Por simplicidad, usemos el objeto de conversación si está disponible
                @endphp
                <a href="{{ route('model.chat.show', $conv['id']) }}" class="conversation-card {{ $isUnread ? 'unread' : '' }}">
                    <div class="avatar-section">
                        @if($otherUser && $otherUser->profile && $otherUser->profile->avatar)
                            <img src="{{ $otherUser->profile->avatar_url }}" alt="{{ $otherUser->name }}" class="avatar-frame">
                        @else
                            <div class="avatar-frame" style="display: flex; align-items: center; justify-content: center; background: #1a1a1f;">
                                <i class="fas fa-user" style="opacity: 0.1; font-size: 2.5rem;"></i>
                            </div>
                        @endif
                        <div class="status-dot"></div>
                    </div>
                    
                    <div class="card-main">
                        <span class="model-name">
                            {{ $otherUser->name ?? __('chat.index.model_default') }}
                            @if($otherUser->isVIP())
                                <i class="fas fa-crown" style="color: var(--accent-gold); font-size: 0.85rem;" title="{{ __('chat.index.verified') }}"></i>
                            @endif
                        </span>
                        <p class="preview-text">
                            @if($conv['last_message'])
                                @if($conv['last_message']->user_id === auth()->id())
                                    <span style="color: var(--accent-gold); opacity: 0.9;">{{ __('chat.index.you') }}</span>
                                @endif
                                {{ $conv['last_message']->message }}
                            @else
                                <em style="opacity: 0.4;">{{ __('chat.index.empty_preview') }}</em>
                            @endif
                        </p>
                    </div>
 
                    <div class="card-end">
                        <span class="time-badge">{{ $conv['updated_at']->diffForHumans(['short' => true]) }}</span>
                        @if($isUnread)
                            <span class="unread-bubble">{{ $conv['unread_count'] }}</span>
                        @else
                             <i class="fas fa-chevron-right" style="color: rgba(255,255,255,0.05); font-size: 0.9rem;"></i>
                        @endif
                        
                        <div class="expiration-tag">
                            <i class="fas fa-unlock" style="font-size: 0.6rem;"></i> {{ __('chat.index.active_status') }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        @if($conversations->hasPages())
            <div class="pagination-wrapper" style="margin-top: 2rem; display: flex; justify-content: center;">
                {{ $conversations->links('custom.pagination') }}
            </div>
        @endif
    @else
        <div class="empty-container">
            <div style="margin-bottom: 2rem;">
                <i class="fas fa-comment-slash fa-5x" style="color: var(--accent-gold); opacity: 0.2;"></i>
            </div>
            <h3 style="color: #dfc04e; font-weight: 800; font-size: 1.8rem; margin-bottom: 1rem;">{{ __('chat.index.empty.title') }}</h3>
            <p style="color: rgba(255,255,255,0.4); max-width: 400px; margin: 0 auto;">{{ __('chat.index.empty.desc') }}</p>
            <a href="{{ route('search.models') }}" class="btn-action">
                <i class="fas fa-search" style="margin-right: 10px;"></i> {{ __('chat.index.empty.action') }}
            </a>
        </div>
    @endif
</div>

<script>
    // Búsqueda simple en el cliente
    document.getElementById('chat-search').addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase();
        document.querySelectorAll('.conversation-card').forEach(card => {
            const name = card.querySelector('.model-name').textContent.toLowerCase();
            card.style.display = name.includes(term) ? 'flex' : 'none';
        });
    });
</script>
@endsection
