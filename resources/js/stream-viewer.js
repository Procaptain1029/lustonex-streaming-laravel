import './bootstrap';

function parseBroadcastConfig() {
    const el = document.getElementById('stream-broadcast-config');
    if (!el?.textContent) {
        return null;
    }
    try {
        return JSON.parse(el.textContent);
    } catch {
        return null;
    }
}

function initStreamViewerChat() {
    const config = parseBroadcastConfig();
    if (!config?.streamId) {
        return;
    }

    let lastMessageId = Number(config.lastMessageId) || 0;

    const applyPollMessages = (messages) => {
        if (!Array.isArray(messages) || typeof window.appendStreamChatFromBroadcast !== 'function') {
            return;
        }
        for (const row of messages) {
            window.appendStreamChatFromBroadcast(row);
            if (row?.id != null && row.id > lastMessageId) {
                lastMessageId = row.id;
            }
        }
    };

    if (window.Echo) {
        window.Echo.private(`stream.${config.streamId}`).listen('.chat.message', (payload) => {
            if (!payload?.id || typeof window.appendStreamChatFromBroadcast !== 'function') {
                return;
            }
            if (payload.id > lastMessageId) {
                lastMessageId = payload.id;
            }
            window.appendStreamChatFromBroadcast(payload);
        });
    }

    if (config.pollUrl) {
        const poll = () => {
            const url = new URL(config.pollUrl, window.location.origin);
            url.searchParams.set('after', String(lastMessageId));
            fetch(url.toString(), {
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin',
            })
                .then((r) => (r.ok ? r.json() : Promise.reject()))
                .then((data) => {
                    if (data?.success && Array.isArray(data.messages)) {
                        applyPollMessages(data.messages);
                    }
                })
                .catch(() => {});
        };

        if (!window.Echo) {
            poll();
        }
        setInterval(poll, window.Echo ? 12000 : 4000);
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initStreamViewerChat);
} else {
    initStreamViewerChat();
}
