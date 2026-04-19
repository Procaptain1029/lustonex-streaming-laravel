<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Public RTMP ingest URL (OBS "Server")
    |--------------------------------------------------------------------------
    |
    | Used in API responses and OBS credentials in the dashboard. Must be a
    | hostname or IP reachable from encoders on the internet (never 127.0.0.1
    | in production). Example: rtmp://rtmp.example.com:1935/live (no stream key).
    | On Render Web Services, port 1935 is often not public; use WebRTC or a
    | dedicated ingest host that exposes TCP 1935.
    |
    */

    'rtmp_public_url_base' => rtrim(env('RTMP_PUBLIC_URL', 'rtmp://127.0.0.1:1935/live'), '/'),

];
