/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;

/**
 * Laravel Echo + Pusher (when VITE_PUSHER_APP_KEY is set).
 * Used by stream viewer chat and any page that imports this bootstrap.
 */
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

const pusherKey = import.meta.env.VITE_PUSHER_APP_KEY;

if (pusherKey) {
    const scheme = import.meta.env.VITE_PUSHER_SCHEME ?? 'https';
    const useTls = scheme === 'https';
    const customHost = import.meta.env.VITE_PUSHER_HOST;

    const echoConfig = {
        broadcaster: 'pusher',
        key: pusherKey,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER || 'mt1',
        forceTLS: useTls,
        encrypted: useTls,
        disableStats: true,
        enabledTransports: ['ws', 'wss'],
    };

    if (customHost) {
        echoConfig.wsHost = customHost;
        echoConfig.wsPort = Number(import.meta.env.VITE_PUSHER_PORT) || 80;
        echoConfig.wssPort = Number(import.meta.env.VITE_PUSHER_PORT) || 1935;
        echoConfig.forceTLS = useTls;
        echoConfig.encrypted = useTls;
    }

    window.Echo = new Echo(echoConfig);
} else {
    window.Echo = null;
}
