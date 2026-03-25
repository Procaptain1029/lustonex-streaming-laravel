@php
    $isFan = auth()->check() && auth()->user()->isFan();
    $canChat = $isFan; // Only fans can chat publicly
    $streamIsLive = isset($activeStream) && $activeStream; // Check if stream var is present and truthy
    
    // Default to private if no stream is live
    $defaultTab = $streamIsLive ? 'public' : 'private';
@endphp
<div class="chat-section">
    <div class="chat-widget">
        <div class="chat-header">
            <div class="chat-tabs">
                @if($streamIsLive)
                <button class="chat-tab {{ $defaultTab === 'public' ? 'active' : '' }}" id="tab-public" onclick="switchChatTab('public')">
                    <i class="fas fa-comments"></i> {{ __('profiles.chat.public') }}
                </button>
                @endif
                <button class="chat-tab {{ $defaultTab === 'private' ? 'active' : '' }}" id="tab-private" onclick="switchChatTab('private')" style="position:relative;">
                    <i class="fas fa-lock"></i> {{ __('profiles.chat.private') }}
                  
                </button>
            </div>
            <div class="chat-header-actions">
                @if($streamIsLive)
                <span class="chat-count" id="chatMessageCount">{{ $activeStream->chatMessages()->count() }}</span>
                @auth
                    <button id="btnToggleTip" class="btn-chat-tip" onclick="toggleTipView()" title="{{ __('profiles.chat.toggle_tip') }}">
                        <i class="fas fa-gift"></i>
                    </button>
                @endauth
                @endif
            </div>
        </div>

        
        <div id="chat-pane-public" class="chat-pane {{ $defaultTab === 'public' ? 'active' : '' }}" style="{{ $defaultTab === 'public' ? '' : 'display: none;' }}">
            <div id="pinnedMessageContainerPublic" style="display: none; padding: 0.5rem 0.75rem; background: linear-gradient(90deg, rgba(212, 175, 55, 0.15), rgba(0,0,0,0)); border-bottom: 1px solid rgba(212,175,55,0.2); font-size: 0.8rem; position: relative; z-index: 10; backdrop-filter: blur(4px);">
                <div style="color: var(--accent-gold); font-weight: 700; font-size: 0.7rem; text-transform: uppercase; margin-bottom: 2px;"><i class="fas fa-thumbtack"></i> {{ __('profiles.chat.pinned_message') }}</div>
                <div id="pinnedMessageTextPublic" style="color: #e2e8f0; word-break: break-word; font-weight: 600;"></div>
            </div>
            <div class="chat-messages" id="chatMessages">
                
            </div>
            
            <div class="chat-input-container">
                @if(auth()->check())
                    @if($isFan || auth()->user()->isAdmin())
                        @if($isFan)
                            <div class="quick-tips-row">
                                <button class="quick-tip-btn" onclick="quickTip(10)"><i class="fas fa-coins"></i> 10</button>
                                <button class="quick-tip-btn" onclick="quickTip(25)"><i class="fas fa-coins"></i> 25</button>
                                <button class="quick-tip-btn" onclick="quickTip(50)"><i class="fas fa-coins"></i> 50</button>
                                <button class="quick-tip-btn" onclick="quickTip(100)"><i class="fas fa-coins"></i> 100</button>
                            </div>
                        @endif
                        <div class="chat-input-row">
                            <input type="text" id="publicChatInput" class="chat-input" placeholder="{{ __('profiles.chat.placeholder') }}" onkeypress="handleEnter(event)">
                            <button class="chat-send" onclick="sendPublicMessage()"><i class="fas fa-paper-plane"></i></button>
                        </div>
                    @else
                        <div class="chat-login-prompt">
                            <i class="fas fa-user-plus"></i>
                            <span style="font-size: 0.9rem; margin-bottom: 0.5rem; display: block;">{{ __('profiles.chat.only_fans_can_chat') }}</span>
                            <a href="{{ route('register') }}?role=fan" class="btn-register-fan">{{ __('profiles.chat.register_as_fan') }}</a>
                        </div>
                    @endif
                @else
                    <div class="chat-login-prompt">
                        <i class="fas fa-lock"></i>
                        <a href="{{ route('login') }}">{{ __('profiles.chat.login_to_chat') }}</a>
                    </div>
                @endif
            </div>
        </div>

        
        <div id="chat-pane-private" class="chat-pane {{ $defaultTab === 'private' ? 'active' : '' }}" style="{{ $defaultTab === 'private' ? '' : 'display: none;' }}">
            @auth
                {{-- Private Chat - Unlocked --}}
                <div id="private-unlocked" style="display: {{ isset($isPrivateChatUnlocked) && $isPrivateChatUnlocked ? 'flex' : 'none' }}; height: 100%; flex-direction: column;">
                    <div class="chat-messages" id="privateChatMessages" style="flex: 1;">
                        {{-- Messages will be loaded here via JS --}}
                    </div>
                    
                    <div class="chat-input-container">
                        <div class="chat-input-row">
                            <input type="text" id="privateChatInput" class="chat-input" placeholder="{{ __('profiles.chat.private_placeholder') }}" onkeypress="handlePrivateEnter(event)">
                            <button class="chat-send" onclick="sendPrivateMessage()"><i class="fas fa-paper-plane"></i></button>
                        </div>
                        <a href="{{ isset($privateConversationId) ? route('fan.chat.show', $privateConversationId) : '#' }}" class="view-all-link" style="text-align: center; color: var(--accent-gold); font-size: 0.75rem; text-decoration: none; margin-top: 5px; display: block; font-weight: 700;">
                            <i class="fas fa-external-link-alt"></i> {{ __('profiles.chat.view_all_messages') }}
                        </a>
                    </div>
                </div>

                {{-- Private Chat - Locked --}}
                <div id="private-locked" class="private-locked-state" style="display: {{ isset($isPrivateChatUnlocked) && $isPrivateChatUnlocked ? 'none' : 'flex' }};">
                    <div class="lock-icon"><i class="fas fa-lock"></i></div>
                    <p>{{ __('profiles.chat.locked') }}</p>
                    <p style="font-size: 0.9rem; opacity: 0.7; margin-bottom: 1.5rem;">
                        {{ __('profiles.chat.locked_desc', ['name' => $model->name]) }}
                    </p>
                    <button onclick="unlockPrivateChat()" class="btn-unlock-chat">
                        <span class="unlock-text">{{ __('profiles.chat.unlock_access', ['duration' => $model->profile->chat_unlock_duration ?? 24]) }}</span><br>
                        <span class="unlock-price"><i class="fas fa-coins"></i> {{ __('profiles.chat.unlock_price', ['price' => $model->profile->chat_unlock_price ?? 500]) }}</span>
                    </button>
                </div>
            @else
                <div class="chat-login-prompt" style="height: 100%; display: flex; flex-direction: column; justify-content: center;">
                    <i class="fas fa-lock" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                    <p>{{ __('profiles.chat.must_login_private') }}</p>
                    <a href="{{ route('login') }}" class="btn-login-action">{{ __('profiles.chat.login_button') }}</a>
                </div>
            @endauth
        </div>

        @auth
        {{-- Sidebar Tip View (Hidden by default) --}}
        <div id="sidebarTipView" class="sidebar-tip-view">
            <div class="user-tip-balance">
                <i class="fas fa-coins"></i> {{ __('profiles.tips.your_balance', ['amount' => number_format(auth()->user()->tokens, 0)]) }}
            </div>

            {{-- Tip Tabs --}}
            <div class="tip-sub-tabs">
                <button class="tip-sub-tab active" id="tab-btn-propinas" onclick="switchTipSubTab('propinas')">{{ __('profiles.tips.tabs.tips') }}</button>
                <button class="tip-sub-tab" id="tab-btn-menu" onclick="switchTipSubTab('menu')">{{ __('profiles.tips.tabs.menu') }}</button>
                <button class="tip-sub-tab" id="tab-btn-roulette" onclick="switchTipSubTab('roulette')">{{ __('profiles.tips.tabs.roulette') }}</button>
            </div>

            {{-- Propinas Pane --}}
            <div id="pane-propinas" class="tip-pane active">
                <div class="tip-presets">
                    <button class="tip-preset-btn" onclick="selectTip(10, this, false, '{{ __('profiles.tips.presets.detail') }}')">
                        <span class="preset-amount">10</span>
                        <span class="preset-label">{{ __('profiles.tips.presets.detail') }}</span>
                    </button>
                    <button class="tip-preset-btn" onclick="selectTip(50, this, false, '{{ __('profiles.tips.presets.cool') }}')">
                        <span class="preset-amount">50</span>
                        <span class="preset-label">{{ __('profiles.tips.presets.cool') }}</span>
                    </button>
                    <button class="tip-preset-btn" onclick="selectTip(100, this, false, '{{ __('profiles.tips.presets.generous') }}')">
                        <span class="preset-amount">100</span>
                        <span class="preset-label">{{ __('profiles.tips.presets.generous') }}</span>
                    </button>
                    <button class="tip-preset-btn" onclick="selectTip(500, this, false, '{{ __('profiles.tips.presets.super_fan') }}')">
                        <span class="preset-amount">500</span>
                        <span class="preset-label">{{ __('profiles.tips.presets.super_fan') }}</span>
                    </button>
                </div>
            </div>

            {{-- Menú Pane --}}
            <div id="pane-menu" class="tip-pane">
                <div class="tip-presets">
                    <button class="tip-preset-btn" onclick="selectTip(25, this, true, '{{ __('profiles.tips.menu.kiss') }}')">
                        <span class="preset-amount">25</span>
                        <span class="preset-label">{{ __('profiles.tips.menu.kiss') }}</span>
                    </button>
                    <button class="tip-preset-btn" onclick="selectTip(50, this, true, '{{ __('profiles.tips.menu.greeting') }}')">
                        <span class="preset-amount">50</span>
                        <span class="preset-label">{{ __('profiles.tips.menu.greeting') }}</span>
                    </button>
                    <button class="tip-preset-btn" onclick="selectTip(100, this, true, '{{ __('profiles.tips.menu.dance') }}')">
                        <span class="preset-amount">100</span>
                        <span class="preset-label">{{ __('profiles.tips.menu.dance') }}</span>
                    </button>
                    <button class="tip-preset-btn" onclick="selectTip(150, this, true, '{{ __('profiles.tips.menu.outfit') }}')">
                        <span class="preset-amount">150</span>
                        <span class="preset-label">{{ __('profiles.tips.menu.outfit') }}</span>
                    </button>
                </div>
            </div>

            {{-- Ruleta Pane --}}
            <div id="pane-roulette" class="tip-pane">
                <div class="roulette-setup" style="text-align: center; padding: 1rem;">
                    <div class="roulette-icon" style="font-size: 3rem; color: var(--accent-gold); margin-bottom: 1rem;">
                        <i class="fas fa-dharmachakra fa-spin-slow"></i>
                    </div>
                    <h4 style="color: #fff; margin-bottom: 0.5rem;">{{ __('profiles.tips.roulette.title') }}</h4>
                    <p style="font-size: 0.8rem; color: rgba(255,255,255,0.6); margin-bottom: 1.5rem;">
                        {{ __('profiles.tips.roulette.desc') }}
                    </p>
                    <div class="roulette-price" style="background: rgba(212, 175, 55, 0.1); padding: 0.5rem 1rem; border-radius: 8px; border: 1px dashed var(--accent-gold); display: inline-block; margin-bottom: 1.5rem;">
                        <span style="font-weight: 700; color: var(--accent-gold);"><i class="fas fa-coins"></i> {{ __('profiles.tips.roulette.price', ['price' => 33]) }}</span>
                    </div>
                    
                    <button onclick="spinRoulette()" class="btn-spin-roulette" id="btnSpinRoulette" style="width: 100%; padding: 1rem; background: var(--accent-gold); color: #000; border: none; border-radius: 12px; font-weight: 800; text-transform: uppercase;">
                        <i class="fas fa-sync-alt"></i> {{ __('profiles.tips.roulette.spin') }}
                    </button>
                </div>
            </div>

            <div id="selectedActionDisplay" style="text-align: center; margin: 1rem 0; font-size: 0.85rem; color: var(--accent-gold); font-weight: 700; min-height: 1.2rem;"></div>

            <button onclick="sendTip()" class="btn-send-tip" id="btnSendTip" disabled>
                <i class="fas fa-paper-plane"></i> {{ __('profiles.tips.send_tip') }}
            </button>
        </div>
        @endauth
    </div>
</div>

<style>
    .chat-tabs {
        display: flex;
        gap: 15px;
    }
    .chat-tab {
        background: transparent;
        border: none;
        color: rgba(255,255,255,0.5);
        font-weight: 700;
        cursor: pointer;
        padding-bottom: 5px;
        border-bottom: 2px solid transparent;
        transition: all 0.3s ease;
    }
    .chat-tab.active {
        color: #fff;
        border-color: var(--accent-gold);
    }
    .chat-tab:hover {
        color: rgba(255,255,255,0.8);
    }
    .chat-pane {
        flex: 1;
        min-height: 0; 
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .chat-pane.active {
        display: flex !important;
    }
    .btn-register-fan {
        display: inline-block;
        background: var(--accent-gold);
        color: #000;
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.85rem;
        margin-top: 5px;
        transition: transform 0.2s;
    }
    .btn-register-fan:hover {
        transform: scale(1.05);
    }

    /* Base Message Styles */
    .message-item {
        padding: 0.4rem 0.6rem;
        border-radius: 8px;
        word-wrap: break-word;
        margin-bottom: 0.4rem;
        position: relative;
        transition: background 0.2s;
        max-width: 100%;
    }

    /* Regular Fan Messages */
    .message-item.fan-msg {
        background: rgba(255, 255, 255, 0.03);
        border-left: 3px solid rgba(255, 255, 255, 0.1);
    }

    /* Model Messages */
    .message-item.model-msg {
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.05), rgba(0,0,0,0));
        border-left: 3px solid var(--accent-gold);
    }
    
    .message-item.model-reply {
        background: linear-gradient(135deg, rgba(147, 51, 234, 0.08), rgba(0,0,0,0));
        border-left: 3px solid var(--accent-purple);
    }
    
    .message-item:hover { background: rgba(255, 255, 255, 0.06); }

    /* Tip Messages - Enhanced Gold Style */
    .tip-msg {
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.15), rgba(255, 215, 0, 0.05));
        border-left: 3px solid var(--accent-gold);
        padding: 6px 10px;
        border-radius: 6px;
        animation: slideInRight 0.4s ease, pulseGold 2s ease-in-out;
        position: relative;
        overflow: hidden;
    }

    .tip-amount {
        color: var(--accent-gold);
        font-weight: 800;
        font-size: 0.85rem;
    }

    /* Roulette Messages - Special Purple/Pink Style */
    .roulette-msg {
        background: linear-gradient(135deg, rgba(236, 72, 153, 0.1), rgba(147, 51, 234, 0.1));
        border-left: 3px solid #ec4899;
        padding: 6px 10px;
        border-radius: 6px;
        animation: slideInRight 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .roulette-msg .tip-amount {
        color: #ec4899;
        font-size: 0.85rem;
        font-weight: 800;
    }

    .roulette-msg .msg-content {
        color: #fbbf24;
        font-size: 0.85rem;
    }

    /* Message Header */
    .msg-header {
        font-weight: 700;
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        gap: 4px;
        margin-bottom: 2px;
    }
    
    .msg-header.is-model { color: var(--accent-gold); }
    .msg-header.is-fan { color: #a0aec0; }
    
    .msg-user {
        /* No specific styles needed, inherits from msg-header */
    }

    .msg-badge {
        font-size: 0.6rem;
        padding: 1px 4px;
        border-radius: 4px;
        font-weight: bold;
    }
    
    .msg-badge.modelo {
        background: var(--accent-gold);
        color: #000;
        margin-left: 2px;
    }

    .msg-badge.vip {
        background: linear-gradient(135deg, #ffd700, #ffed4e);
        color: #000;
        margin-left: 2px;
    }

    /* Message Content */
    .msg-content {
        color: #e2e8f0;
        font-size: 0.85rem;
        line-height: 1.3;
        word-break: break-word;
        padding-left: 0;
    }

    /* Mention Highlighting */
    .mention {
        color: var(--accent-purple);
        font-weight: 800;
        background: rgba(147, 51, 234, 0.2);
        padding: 1px 5px;
        border-radius: 4px;
        margin-right: 2px;
        font-size: 0.8rem;
    }

    /* Animations */
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes pulseGold {
        0%, 100% {
            box-shadow: 0 2px 12px rgba(212, 175, 55, 0.4);
        }
        50% {
            box-shadow: 0 2px 20px rgba(212, 175, 55, 0.6);
        }
    }

    @keyframes spinWheel {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    /* Private Chat Styles */
    .private-locked-state {
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 2rem;
        color: #fff;
    }

    .lock-icon {
        font-size: 3rem;
        color: var(--accent-gold);
        margin-bottom: 1rem;
        opacity: 0.8;
    }

    .btn-unlock-chat {
        background: var(--accent-gold);
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        color: #000;
        cursor: pointer;
        margin-top: 1.5rem;
        transition: transform 0.2s;
    }

    .btn-unlock-chat:hover {
        transform: scale(1.05);
    }

    .unlock-price {
        font-weight: 800;
        font-size: 1.1rem;
    }

    .unlock-text {
        font-size: 0.8rem;
        text-transform: uppercase;
        font-weight: 700;
    }

    .btn-login-action {
        color: var(--accent-gold);
        text-decoration: underline;
        font-weight: 700;
        cursor: pointer;
    }

    .view-all-link:hover {
        filter: brightness(1.2);
    }
</style>

<script>
    let chatRefreshInterval = null;
    let privateChatBackgroundInterval = null;
    let privateUnreadLocalCount = 0;
    const currentUserId = {{ auth()->id() ?? 'null' }};
    const privateConversationId = {{ $privateConversationId ?? 'null' }};

    document.addEventListener('DOMContentLoaded', function() {
        startChatPolling();
    });

    function startChatPolling() {
        if (chatRefreshInterval) clearInterval(chatRefreshInterval);
        if (privateChatBackgroundInterval) clearInterval(privateChatBackgroundInterval);
        
        // Initial load
        refreshActiveChat();
        
        // Dynamic polling based on active tab
        chatRefreshInterval = setInterval(refreshActiveChat, 5000);

        // Private chat background polling
        if (privateConversationId) {
            privateChatBackgroundInterval = setInterval(checkPrivateChatBackground, 10000);
        }
    }

    function checkPrivateChatBackground() {
        const activeTab = document.querySelector('.chat-tab.active');
        if (activeTab && activeTab.id === 'tab-private') return; // Handled by refreshActiveChat
        loadPrivateChatHistory(true);
    }

    function refreshActiveChat() {
        const activeTab = document.querySelector('.chat-tab.active');
        if (!activeTab) return;

        if (activeTab.id === 'tab-public') {
            loadPublicChatHistory();
        } else if (activeTab.id === 'tab-private') {
            loadPrivateChatHistory();
        }
    }

    function switchChatTab(tab) {
        document.querySelectorAll('.chat-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.chat-pane').forEach(p => {
             p.style.display = 'none';
             p.classList.remove('active');
        });

        document.getElementById('tab-' + tab).classList.add('active');
        const pane = document.getElementById('chat-pane-' + tab);
        pane.style.display = 'flex';
        pane.classList.add('active');
        
        // Load history immediately on switch
        if (tab === 'public') {
            loadPublicChatHistory();
        } else if (tab === 'private') {
            privateUnreadLocalCount = 0;
            updatePrivateBadge();
            loadPrivateChatHistory();
        }
    }

    function updatePrivateBadge() {
        const badge = document.getElementById('privateUnreadCount');
        if (!badge) return;
        if (privateUnreadLocalCount > 0) {
            badge.innerText = privateUnreadLocalCount > 99 ? '99+' : privateUnreadLocalCount;
            badge.style.display = 'block';
        } else {
            badge.style.display = 'none';
        }
    }

    function handleEnter(e) {
        if (e.key === 'Enter') sendPublicMessage();
    }

    function handlePrivateEnter(e) {
        if (e.key === 'Enter') sendPrivateMessage();
    }

    function loadPublicChatHistory() {
        fetch('{{ route("profiles.chat.history", $model->id) }}')
             .then(response => response.json())
             .then(data => {
                 if (data.success) {
                     renderChat('chatMessages', data.history, {{ $model->id }});
                 }
             })
             .catch(error => console.error('Error loading public chat:', error));
    }

    function loadPrivateChatHistory(isBackground = false) {
        if (!privateConversationId) return;

        fetch(`/fan/chat/${privateConversationId}/messages`)
             .then(response => response.json())
             .then(data => {
                 if (data.success) {
                     const formattedHistory = data.messages.map(m => ({
                         id: m.id,
                         type: 'message',
                         user: m.user,
                         content: m.message,
                         created_at: m.created_at
                     }));
                     const newCount = renderChat('privateChatMessages', formattedHistory, {{ $model->id }});
                     if (isBackground && newCount > 0) {
                         privateUnreadLocalCount += newCount;
                         updatePrivateBadge();
                     }
                 }
             })
             .catch(error => console.error('Error loading private chat:', error));
    }

    function renderChat(containerId, history, modelId) {
        const container = document.getElementById(containerId);
        if (!container) return;

        const isAtBottom = container.scrollHeight - container.scrollTop <= container.clientHeight + 50;
        const existingIds = new Set();
        container.querySelectorAll('.message-item').forEach(el => {
             if (el.dataset.id) existingIds.add(el.dataset.id);
        });

        let hasNewMessages = false;
        let newMessagesCount = 0;
        let pinnedMessage = null;

        history.forEach(item => {
            if (item.is_pinned === true || item.is_pinned === 1) {
                pinnedMessage = item;
            }

            if (existingIds.has(String(item.id))) return;

            const div = document.createElement('div');
            div.className = 'message-item';
            div.dataset.id = item.id;
            
            const isModelMessage = item.user && item.user.id === modelId;
            
            if (item.type === 'message') {
                const isReply = isModelMessage && item.content.startsWith('@');
                div.classList.add(isModelMessage ? (isReply ? 'model-reply' : 'model-msg') : 'fan-msg');
                if (item.is_pinned) div.classList.add('is-pinned');
                
                const roleBadge = isModelMessage ? '<span class="msg-badge modelo" style="font-size: 0.6rem; padding: 1px 4px; border-radius: 4px; font-weight: bold; background: var(--accent-gold); color: #000;">MODELO</span>' : '';
                const iconHtml = isModelMessage ? '<i class="fas fa-crown"></i>' : '<i class="fas fa-user-circle"></i>';
                
                div.innerHTML = `
                    <div class="msg-header ${isModelMessage ? 'is-model' : 'is-fan'}">
                        ${iconHtml}
                        <span class="msg-user">${item.user ? item.user.name : 'Usuario'}</span>
                        ${roleBadge}
                        ${item.user && item.user.is_vip && !isModelMessage ? '<span class="msg-badge vip">VIP</span>' : ''}
                    </div>
                    <div class="msg-content">${parseMentions(item.content)}</div>
                `;
            } else if (item.type === 'tip' || item.type === 'roulette' || item.type === 'menu') {
                const isRoulette = item.type === 'roulette' || (item.content && item.content.includes('🎲'));
                const isMenu = item.type === 'menu';
                const msgClass = isRoulette ? 'roulette-msg' : 'tip-msg';
                const iconHtml = isRoulette ? '<span style="font-size:0.8rem;">🎰</span>' : (isMenu ? '<span style="font-size:0.8rem;">📜</span>' : '<span style="font-size:0.8rem;">💰</span>');
                
                div.innerHTML = `
                    <div class="${msgClass}">
                        <div class="msg-header is-fan">
                            ${iconHtml}
                            <span class="msg-user">${item.user ? item.user.name : 'Usuario'}</span>
                        </div>
                        <div class="msg-content">
                            <span class="tip-amount">${item.amount} Tk</span> <span style="font-size:0.8rem; color:var(--text-muted);">ha enviado -</span> ${item.content || 'Propina enviada'}
                        </div>
                    </div>
                `;
            }
            container.appendChild(div);
            hasNewMessages = true;
            newMessagesCount++;
        });

        if (hasNewMessages && isAtBottom) {
            container.scrollTop = container.scrollHeight;
        }

        // Update count only for public chat bubble in header if visible
        if (containerId === 'chatMessages') {
            const countEl = document.getElementById('chatMessageCount');
            if (countEl) countEl.innerText = container.querySelectorAll('.message-item').length;

            const pinnedContainer = document.getElementById('pinnedMessageContainerPublic');
            if (pinnedContainer) {
                if (pinnedMessage && pinnedMessage.content) {
                    document.getElementById('pinnedMessageTextPublic').innerText = pinnedMessage.content;
                    pinnedContainer.style.display = 'block';
                } else {
                    pinnedContainer.style.display = 'none';
                }
            }
        }
        
        return newMessagesCount;
    }

    function parseMentions(text) {
        if (!text) return '';
        if (text.startsWith('@')) {
            const match = text.match(/^@([^:]+):\s*(.*)/);
            if (match) {
                return `<span class="mention">@${match[1]}</span> ${match[2]}`;
            }
            const parts = text.split(' ');
            if (parts.length >= 2) {
                const mention = parts.shift();
                return `<span class="mention">${mention}</span> ` + parts.join(' ');
            }
        }
        return text.replace(/@(\w+)/g, '<span class="mention">@$1</span>');
    }

    function sendPublicMessage() {
        const input = document.getElementById('publicChatInput');
        const message = input.value.trim();
        if (!message) return;

        fetch('{{ route("profiles.chat.send", $model->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                input.value = '';
                loadPublicChatHistory();
            }
        })
        .catch(error => console.error('Error sending public message:', error));
    }

    function sendPrivateMessage() {
        if (!privateConversationId) return;

        const input = document.getElementById('privateChatInput');
        const message = input.value.trim();
        if (!message) return;

        const sendBtn = document.querySelector('#private-unlocked .chat-send');
        sendBtn.disabled = true;

        fetch(`/fan/chat/${privateConversationId}/message`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                input.value = '';
                loadPrivateChatHistory();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.error || 'No se pudo enviar el mensaje',
                    background: '#1a1a1e',
                    color: '#fff',
                    confirmButtonColor: '#d4af37'
                });
            }
        })
        .catch(error => console.error('Error sending private message:', error))
        .finally(() => {
            sendBtn.disabled = false;
        });
    }

    function unlockPrivateChat() {
        Swal.fire({
            title: '¿Desbloquear Chat?',
            text: '¿Estás seguro de pagar {{ $model->profile->chat_unlock_price ?? 500 }} tokens por {{ $model->profile->chat_unlock_duration ?? 24 }} horas de acceso al chat privado con {{ $model->name }}?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#D4AF37',
            cancelButtonColor: 'rgba(255,255,255,0.1)',
            confirmButtonText: 'Sí, confirmar',
            cancelButtonText: 'Cancelar',
            background: '#1a1a1e',
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: '{{ __('profiles.chat.processing') }}',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading(),
                    background: '#1a1a1e',
                    color: '#fff'
                });

                fetch('{{ route("profiles.chat.unlock", $model->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json().then(data => ({ status: response.status, data })))
                .then(({ status, data }) => {
                    if (data.success) {
                        location.reload(); // Reload to refresh all IDs and states
                    } else {
                        const isInsufficient = data.message && (data.message.includes('tokens') || data.message.includes('insuficientes'));

                        if (isInsufficient || status === 400) {
                            Swal.fire({
                                icon: 'warning',
                                title: '{{ __('profiles.chat.insufficient_tokens') }}',
                                text: data.message || '{{ __('profiles.chat.unlock_error') }}',
                                showCancelButton: true,
                                confirmButtonColor: '#D4AF37',
                                cancelButtonColor: 'rgba(255,255,255,0.1)',
                                confirmButtonText: '{{ __('profiles.chat.recharge_tokens') }}',
                                cancelButtonText: '{{ __('profiles.chat.cancel') }}',
                                background: '#1a1a1e',
                                color: '#fff'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '{{ route('fan.tokens.recharge') }}';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || '{{ __('profiles.chat.unlock_error') }}',
                                background: '#1a1a1e',
                                color: '#fff',
                                confirmButtonColor: '#d4af37'
                            });
                        }
                    }
                });
            }
        });
    }
</script>
