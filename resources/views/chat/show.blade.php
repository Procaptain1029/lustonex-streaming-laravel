@extends('layouts.public')

@section('title', __('chat.show.title', ['name' => $otherUser->name]))



@section('content')
<style>
    :root {
        --chat-bg: #0a0a0c;
        --card-bg: rgba(18, 18, 22, 0.85);
        --accent-gold: #d4af37;
        --gradient-gold: linear-gradient(135deg, #d4af37 0%, #f9e29c 50%, #b8860b 100%);
        --gradient-dark: linear-gradient(135deg, #1a1a1e 0%, #0a0a0c 100%);
    }

    body {
        background: #050505;
        overflow: hidden;
    }

    /* Hide global footer on this page */
    footer.footer-premium {
        display: none !important;
    }

    /* Full height layout with blur background */
    /* Flexible layout for desktop */
    .chat-layout {
        height: calc(100vh - 40px); /* Adjust based on dashboard header */
        display: flex;
        flex-direction: column;
        width: 100%;
        max-width: 100%;
        margin: 0;
        padding: 1rem;
        position: relative;
    }

    /* Ambient Background Glow */
    .ambient-glow {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            radial-gradient(circle at 10% 20%, rgba(212, 175, 55, 0.05) 0%, transparent 40%),
            radial-gradient(circle at 90% 80%, rgba(212, 175, 55, 0.05) 0%, transparent 40%);
        z-index: -1;
        pointer-events: none;
    }

    .chat-card {
        flex: 1;
        background: var(--card-bg);
        backdrop-filter: blur(40px);
        -webkit-backdrop-filter: blur(40px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 30px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        box-shadow: 0 40px 80px rgba(0, 0, 0, 0.6);
        position: relative;
        width: 100%;
    }

    /* Timer / Expiration Banner */
    .expiration-banner {
        background: rgba(212, 175, 55, 0.1);
        border-bottom: 1px solid rgba(212, 175, 55, 0.2);
        padding: 8px 20px;
        text-align: center;
        font-size: 0.8rem;
        color: var(--accent-gold);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        z-index: 10;
    }

    .expiration-banner .clock-icon {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.2); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
    }

    /* Header */
    .chat-header {
        position: relative;
        z-index: 1;
        padding: 1rem 1.5rem;
        background: rgba(255, 255, 255, 0.02);
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .user-info {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        gap: 1rem;
        text-decoration: none;
        color: #fff;
    }

    .header-avatar-container {
        position: relative;
        flex-shrink: 0;
    }

    .header-avatar {
        width: 50px;
        height: 50px;
        border-radius: 16px;
        object-fit: cover;
        border: 2px solid rgba(212, 175, 55, 0.4);
        box-shadow: 0 0 15px rgba(212, 175, 55, 0.2);
        transition: transform 0.3s;
    }

    .user-info:hover .header-avatar {
        transform: scale(1.05);
    }

    .online-indicator {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 16px;
        height: 16px;
        background: #10b981;
        border: 3px solid #121216;
        border-radius: 50%;
        box-shadow: 0 0 10px #10b981;
    }

    .header-details h2 {
        font-size: 1.15rem;
        font-weight: 850;
        margin: 0;
        line-height: 1.2;
        letter-spacing: -0.5px;
        background: linear-gradient(to right, #fff, rgba(255,255,255,0.7));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--accent-gold);
        background: rgba(212, 175, 55, 0.08);
        padding: 3px 8px;
        border-radius: 8px;
        margin-top: 3px;
    }

    .header-actions {
        display: flex;
        gap: 15px;
    }

    .action-btn {
        width: 48px;
        height: 48px;
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
        text-decoration: none;
        font-size: 1.1rem;
    }

    .action-btn:hover {
        background: rgba(212, 175, 55, 0.15);
        color: var(--accent-gold);
        border-color: rgba(212, 175, 55, 0.3);
        transform: translateY(-4px) scale(1.1);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    /* Messages Area */
    .messages-area {
        position: relative;
        z-index: 1;
        flex: 1;
        padding: 2.5rem;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
        scrollbar-width: thin;
        scrollbar-color: rgba(212, 175, 55, 0.2) transparent;
    }

    .messages-area::-webkit-scrollbar { width: 5px; }
    .messages-area::-webkit-scrollbar-thumb { background: rgba(212, 175, 55, 0.2); border-radius: 10px; }

    /* Date Separator */
    .date-separator {
        text-align: center;
        margin: 1rem 0;
        position: relative;
    }
    .date-separator::before {
        content: '';
        position: absolute;
        left: 0; top: 50%; width: 100%; height: 1px;
        background: linear-gradient(to right, transparent, rgba(255,255,255,0.05), transparent);
    }
    .date-separator span {
        position: relative;
        background: #121216;
        padding: 4px 15px;
        border-radius: 12px;
        font-size: 0.7rem;
        color: rgba(255,255,255,0.3);
        font-weight: 700;
        text-transform: uppercase;
    }

    /* Message Bubbles */
    .message-wrapper {
        display: flex;
        flex-direction: column;
        max-width: 80%;
        animation: messageFadeIn 0.5s cubic-bezier(0.23, 1, 0.32, 1);
    }

    @keyframes messageFadeIn {
        from { opacity: 0; transform: translateY(20px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .message-wrapper.sent { align-self: flex-end; align-items: flex-end; }
    .message-wrapper.received { align-self: flex-start; align-items: flex-start; }

    .bubble-container {
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .message-bubble {
        padding: 14px 24px;
        border-radius: 28px;
        font-size: 1.05rem;
        line-height: 1.5;
        position: relative;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }

    .message-wrapper.sent .message-bubble {
        background: var(--gradient-gold);
        color: #000;
        border-bottom-right-radius: 6px;
        font-weight: 600;
    }

    .message-wrapper.received .message-bubble {
        background: rgba(255, 255, 255, 0.06);
        color: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-bottom-left-radius: 6px;
    }

    .message-image {
        max-width: 300px;
        max-height: 300px;
        border-radius: 15px;
        margin-top: 5px;
        display: block;
        cursor: pointer;
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        object-fit: cover;
    }

    .message-image:hover {
        transform: scale(1.02);
    }

    .message-meta {
        font-size: 0.7rem;
        margin-top: 8px;
        color: rgba(255, 255, 255, 0.3);
        display: flex;
        align-items: center;
        gap: 5px;
        font-weight: 600;
    }

    /* Input Area */
    .chat-input-area {
        position: relative;
        z-index: 1;
        padding: 2rem 2.5rem;
        background: rgba(255, 255, 255, 0.02);
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    .input-box {
        display: flex;
        align-items: center;
        gap: 15px;
        background: rgba(0, 0, 0, 0.4);
        padding: 10px 15px;
        border-radius: 30px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.4s ease;
    }

    .input-box:focus-within {
        border-color: rgba(212, 175, 55, 0.5);
        background: rgba(0, 0, 0, 0.6);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4), 0 0 20px rgba(212, 175, 55, 0.1);
        transform: translateY(-2px);
    }

    .attach-btn {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 1rem;
    }

    .attach-btn:hover {
        background: rgba(212, 175, 55, 0.1);
        color: var(--accent-gold);
        border-color: rgba(212, 175, 55, 0.3);
        transform: translateY(-2px);
    }

    .control-btn {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.05);
        color: rgba(255, 255, 255, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
        font-size: 1.1rem;
    }

    .control-btn:hover {
        background: rgba(255, 255, 255, 0.1);
        color: var(--accent-gold);
        transform: scale(1.1) rotate(5deg);
    }

    .control-btn.tip-btn {
        background: rgba(212, 175, 55, 0.1);
        color: var(--accent-gold);
    }

    .chat-input {
        flex: 1;
        background: transparent;
        border: none;
        color: #fff;
        padding: 12px 10px;
        font-size: 1.05rem;
        outline: none;
        font-weight: 500;
    }

    .chat-input::placeholder { color: rgba(255,255,255,0.25); }

    .send-button {
        background: var(--gradient-gold);
        border: none;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        color: #000;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        font-size: 1.2rem;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
    }

    .send-button:hover {
        transform: scale(1.15) rotate(-10deg);
        box-shadow: 0 8px 25px rgba(212, 175, 55, 0.5);
    }

    @media (max-width: 768px) {
        /* Hide layout elements */
        header.header-stripchat, 
        .mobile-search-filters, 
        aside#sidebar, 
        footer.footer-premium {
            display: none !important;
        }

        .page-container {
            min-height: 100vh;
            background: #000;
        }

        .main-content {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            height: 100dvh !important;
            display: flex;
            flex-direction: column;
        }

        .chat-layout { 
            padding: 0; 
            height: 100dvh; 
            width: 100vw;
            margin: 0;
        }

        .chat-card { 
            border-radius: 0; 
            border: none;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .chat-header { 
            padding: 12px 15px;
            background: rgba(15, 15, 18, 0.98);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
            flex-shrink: 0;
        }

        .messages-area { 
            padding: 1.25rem 1rem;
            background: #050505;
            flex: 1;
            overscroll-behavior-y: contain;
            -webkit-overflow-scrolling: touch;
        }

        .chat-input-area { 
            padding: 10px 12px;
            background: rgba(15, 15, 18, 0.98);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255,255,255,0.05);
            padding-bottom: calc(env(safe-area-inset-bottom, 10px) + 5px);
            flex-shrink: 0;
        }

        .header-avatar { width: 38px; height: 38px; border-radius: 12px; }
        .header-details h2 { font-size: 0.95rem; font-weight: 700; }
        .status-badge { padding: 2px 6px; font-size: 0.6rem; }
        
        .message-wrapper { max-width: 88%; gap: 1.25rem; }
        .message-bubble { padding: 10px 16px; font-size: 0.95rem; line-height: 1.4; }
        
        .action-btn { width: 36px; height: 36px; border-radius: 10px; font-size: 1rem; }
        .input-box { gap: 8px; padding: 4px 10px; border-radius: 24px; }
        .chat-input { padding: 8px 5px; font-size: 0.95rem; }
        .send-button { width: 40px; height: 40px; font-size: 1rem; }
    }
</style>
<div class="ambient-glow"></div>

<div class="chat-layout">
    <div class="chat-card">
        
        <!-- Timer Banner for Fans -->
        @if(auth()->user()->isFan() && $conversation->unlocked_until)
            <div class="expiration-banner">
                <i class="fas fa-clock clock-icon"></i>
                <span>{{ __('chat.show.expiration_label') }} <strong>{{ $conversation->unlocked_until->diffForHumans(['parts' => 2, 'short' => true]) }}</strong></span>
                <a href="javascript:void(0)" onclick="extendChat()" style="color: #fff; text-decoration: underline; margin-left: 10px; font-weight: 700;">{{ __('chat.show.extend') }}</a>
            </div>
        @endif

        <div class="chat-header">
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <a href="{{ route('fan.chat.index') }}" class="action-btn" title="{{ __('chat.show.back') }}">
                    <i class="fas fa-chevron-left"></i>
                </a>
                
                <a href="{{ route('profiles.show', $otherUser->id) }}" class="user-info">
                    <div class="header-avatar-container">
                        @if($otherUser->profile && $otherUser->profile->avatar)
                            <img src="{{ $otherUser->profile->avatar_url }}" alt="{{ $otherUser->name }}" class="header-avatar">
                        @else
                            <div class="header-avatar" style="background: #222; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user" style="opacity: 0.2;"></i>
                            </div>
                        @endif
                        <div class="online-indicator"></div>
                    </div>
                    <div class="header-details">
                        <h2>{{ $otherUser->name }}</h2>
                        <div class="status-badge">
                            @if($otherUser->isVIP())
                                <i class="fas fa-crown"></i> {{ __('chat.show.vip_model') }}
                            @else
                                <span class="pulse-dot" style="width: 6px; height: 6px; background: #10b981; border-radius: 50%; display: inline-block;"></span>
                                {{ __('chat.show.online') }}
                            @endif
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="header-actions">
               
                <button title="{{ __('chat.show.report_security') }}" class="action-btn report" onclick="reportUser()">
                    <i class="fas fa-shield-alt"></i>
                </button>
            </div>
        </div>

        <!-- Messages Area -->
        <div class="messages-area" id="messages-container">
            @php $lastDate = null; @endphp
            @forelse($messages as $message)
                @php $msgDate = $message->created_at->format('Y-m-d'); @endphp
                @if($lastDate !== $msgDate)
                    <div class="date-separator">
                        <span>{{ $message->created_at->isToday() ? __('chat.show.dates.today') : ($message->created_at->isYesterday() ? __('chat.show.dates.yesterday') : $message->created_at->format('d M, Y')) }}</span>
                    </div>
                    @php $lastDate = $msgDate; @endphp
                @endif

                <div class="message-wrapper {{ $message->user_id === auth()->id() ? 'sent' : 'received' }}" data-id="{{ $message->id }}">
                    <div class="bubble-container">
                        <div class="message-bubble">
                            @if($message->type === 'image' && isset($message->metadata['url']))
                                <img src="{{ $message->metadata['url'] }}" class="message-image" onclick="window.open(this.src, '_blank')">
                            @endif
                            
                            @if($message->message !== '[Imagen]')
                                {{ $message->message }}
                            @endif
                        </div>
                        <div class="message-meta">
                            {{ $message->created_at->format('H:i') }}
                            @if($message->user_id === auth()->id())
                                <i class="fas {{ $message->read_at ? 'fa-check-double' : 'fa-check' }}" style="color: {{ $message->read_at ? 'var(--accent-gold)' : 'inherit' }}"></i>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5" style="margin: auto;">
                    <div style="width: 100px; height: 100px; background: rgba(212, 175, 55, 0.05); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem;">
                        <i class="fas fa-comment-medical fa-3x" style="color: var(--accent-gold); opacity: 0.5;"></i>
                    </div>
                    <h3 style="color: #fff; font-weight: 800; font-size: 1.8rem; margin-bottom: 0.5rem;">{{ __('chat.show.empty.title') }}</h3>
                    <p style="color: rgba(255,255,255,0.4); max-width: 300px; margin: 0 auto;">{{ __('chat.show.empty.desc', ['name' => $otherUser->name]) }}</p>
                </div>
            @endforelse
        </div>

        <!-- Input Area -->
        <div class="chat-input-area">
            <form id="message-form" class="input-box">
                @csrf
                @if(auth()->user()->isModel())
                    <div style="display: flex; gap: 8px;">
                        <button type="button" class="attach-btn" title="{{ __('chat.show.input.attach') }}" onclick="multimediaAction('file')">
                            <i class="fas fa-paperclip"></i>
                        </button>
                        <button type="button" class="attach-btn" title="{{ __('chat.show.input.camera') }}" onclick="multimediaAction('camera')">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>
                @endif
                
                <input type="text" id="message-input" class="chat-input" placeholder="{{ __('chat.show.input.placeholder') }}" autocomplete="off">
                
                <div style="display: flex; gap: 10px; align-items: center;">
                   
                    <button type="submit" id="send-button" class="send-button">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Core Variables
    const form = document.getElementById('message-form');
    const input = document.getElementById('message-input');
    const messagesContainer = document.getElementById('messages-container');
    const conversationId = {{ $conversation->id }};
    const sendButton = document.getElementById('send-button');

    // Multimedia Placeholders
    window.multimediaAction = function(type) {
        Swal.fire({
            title: type === 'camera' ? '{{ __('chat.show.swal.camera_title') }}' : '{{ __('chat.show.swal.attach_title') }}',
            text: '{{ __('chat.show.swal.multimedia_soon') }}',
            icon: 'info',
            background: '#1a1a1e',
            color: '#fff',
            confirmButtonColor: '#D4AF37'
        });
    }

    // Extend Chat Functionality
    window.extendChat = function() {
        const price = {{ $otherUser->profile->chat_unlock_price ?? 0 }};
        
        Swal.fire({
            title: '{{ __('chat.show.swal.extend_title') }}',
            text: `{{ __('chat.show.swal.extend_desc', ['price' => ':price']) }}`.replace(':price', price),
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#d4af37',
            cancelButtonColor: 'rgba(255,255,255,0.1)',
            confirmButtonText: '{{ __('chat.show.swal.extend_confirm') }}',
            cancelButtonText: '{{ __('chat.show.swal.cancel') }}',
            background: '#1a1a1e',
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                Swal.fire({
                    title: '{{ __('chat.show.swal.processing') }}',
                    didOpen: () => { Swal.showLoading(); },
                    background: '#1a1a1e',
                    color: '#fff',
                    allowOutsideClick: false,
                    showConfirmButton: false
                });

                fetch('{{ route('fan.chat.extend', $conversation->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __('chat.show.swal.extended_title') }}',
                            text: data.message,
                            background: '#1a1a1e',
                            color: '#fff',
                            timer: 3000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload(); // Reload to update timer
                        });
                    } else {
                        throw new Error(data.message || 'Error al extender el chat');
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __('chat.show.swal.error_title') }}',
                        text: error.message,
                        background: '#1a1a1e',
                        color: '#fff'
                    });
                });
            }
        });
    }

    // Report Functionality
    window.reportUser = function() {
        Swal.fire({
            title: '{{ __('chat.show.swal.report_title') }}',
            text: '{{ __('chat.show.swal.report_desc') }}',
            icon: 'warning',
            input: 'textarea',
            inputPlaceholder: '{{ __('chat.show.swal.report_placeholder') }}',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: 'rgba(255,255,255,0.1)',
            confirmButtonText: '{{ __('chat.show.swal.report_confirm') }}',
            cancelButtonText: '{{ __('chat.show.swal.cancel') }}',
            background: '#1a1a1e',
            color: '#fff',
            preConfirm: (reason) => {
                if (!reason) {
                    Swal.showValidationMessage('{{ __('chat.show.swal.report_reason_required') }}');
                }
                return reason;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('{{ route('reports.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        reported_id: {{ $otherUser->id }},
                        reportable_id: {{ $conversation->id }},
                        reportable_type: 'App\\Models\\Conversation',
                        reason: result.value
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __('chat.show.swal.report_success_title') }}',
                            text: data.message,
                            background: '#1a1a1e',
                            color: '#fff',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    } else {
                        throw new Error(data.message || 'Error al enviar el reporte');
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message,
                        background: '#1a1a1e',
                        color: '#fff'
                    });
                });
            }
        });
    }

    // Scroll to bottom
    const scrollToBottom = () => {
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    };
    
    scrollToBottom();
    
    // Send message
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const message = input.value.trim();
        if (!message) return;
        
        // Disable UI
        input.disabled = true;
        sendButton.disabled = true;
        
        fetch(`/fan/chat/${conversationId}/message`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ message: message }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                appendMessage(data.message, true, true);
                input.value = '';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: '{{ __('chat.show.swal.error_title') }}',
                text: '{{ __('chat.show.swal.send_error') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        })
        .finally(() => {
            input.disabled = false;
            sendButton.disabled = false;
            input.focus();
        });
    });
    
    function appendMessage(message, isSent, forceScroll = false) {
        if (document.querySelector(`.message-wrapper[data-id="${message.id}"]`)) return;

        const wrapper = document.createElement('div');
        wrapper.className = `message-wrapper ${isSent ? 'sent' : 'received'}`;
        wrapper.dataset.id = message.id;
        
        const time = new Date(message.created_at).toLocaleTimeString('es-ES', { 
            hour: '2-digit', 
            minute: '2-digit' 
        });
        
        let content = '';
        if (message.type === 'image' && message.metadata && message.metadata.url) {
            content += `<img src="${message.metadata.url}" class="message-image" onclick="window.open(this.src, '_blank')">`;
        }
        
        if (message.message !== '[Imagen]') {
            content += `<div>${escapeHtml(message.message)}</div>`;
        }

        wrapper.innerHTML = `
            <div class="message-bubble">
                ${content}
            </div>
            <div class="message-meta">
                ${time}
            </div>
        `;
        
        const emptyState = messagesContainer.querySelector('.text-center');
        if(emptyState) emptyState.remove();

        messagesContainer.appendChild(wrapper);
        if (forceScroll) scrollToBottom();
    }
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    function fetchMessages() {
        if (document.hidden) return;

        fetch(`/fan/chat/${conversationId}/messages`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderMessages(data.messages);
            }
        })
        .catch(error => console.error('Error fetching messages:', error));
    }

    function renderMessages(messages) {
        const isAtBottom = messagesContainer.scrollHeight - messagesContainer.scrollTop <= messagesContainer.clientHeight + 100;
        let hasNew = false;

        messages.forEach(msg => {
            if (!document.querySelector(`.message-wrapper[data-id="${msg.id}"]`)) {
                appendMessage(msg, msg.user_id === {{ auth()->id() }}, false);
                hasNew = true;
            }
        });
        
        if (hasNew && isAtBottom) {
            scrollToBottom();
        }
    }

    setInterval(fetchMessages, 3000); 
});
</script>
@endsection
