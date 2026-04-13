import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/model-stream-admin-echo.js',
                'resources/js/stream-viewer.js',
                'resources/css/premium-design.css',
                'resources/css/icons.css',
                'resources/css/sh-search-premium.css',
            ],
            refresh: true,
        }),
    ],
    // Windows often blocks [::1]:5173 (ERR_NETWORK_ACCESS_DENIED). Force IPv4 for dev + HMR.
    server: {
        host: '127.0.0.1',
        port: 5173,
        strictPort: true,
        // Laravel writes compiled Blade to storage/framework/views on every request.
        // Without this, Vite sees those files change and full-reloads forever (tab never finishes loading).
        watch: {
            ignored: [
                '**/storage/**',
                '**/bootstrap/cache/**',
            ],
        },
        hmr: {
            host: '127.0.0.1',
            protocol: 'ws',
        },
    },
});
