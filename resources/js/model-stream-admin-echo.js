import './bootstrap';

/**
 * Model stream admin: subscribe to the same private channel as fans for instant chat.
 * Requires BROADCAST_DRIVER=pusher (or compatible) and VITE_PUSHER_* in .env + npm run build/dev.
 */
function initModelStreamAdminEcho() {
    const el = document.getElementById('model-stream-broadcast-config');
    if (!el?.textContent || !window.Echo) {
        return;
    }

    let cfg;
    try {
        cfg = JSON.parse(el.textContent);
    } catch {
        return;
    }

    const streamId = cfg.streamId;
    if (!streamId) {
        return;
    }

    try {
        window.Echo.private(`stream.${streamId}`).listen('.chat.message', (payload) => {
            if (typeof window.modelStreamApplyBroadcastChat === 'function') {
                window.modelStreamApplyBroadcastChat(payload);
            }
        });
        window.__streamAdminEchoActive = true;
    } catch (e) {
        console.warn('[stream-admin] Echo subscribe failed, using polling only', e);
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initModelStreamAdminEcho);
} else {
    initModelStreamAdminEcho();
}
