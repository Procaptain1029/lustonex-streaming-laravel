<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Public RTMP ingest URL (OBS "Server")
    |--------------------------------------------------------------------------
    |
    | Used in API responses and profile helpers. For Docker/VPS, set to
    | rtmp://YOUR_HOST:1935/live (no trailing stream key). On Render Web
    | Services, port 1935 is not reachable from the public internet; use
    | browser WebRTC or host RTMP on a provider that exposes TCP ingest.
    |
    */

    'rtmp_public_url_base' => rtrim(env('RTMP_PUBLIC_URL', 'rtmp://127.0.0.1:1935/live'), '/'),

];
