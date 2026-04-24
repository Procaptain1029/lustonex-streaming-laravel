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

    /*
    |--------------------------------------------------------------------------
    | WebRTC ICE Servers (STUN + TURN)
    |--------------------------------------------------------------------------
    |
    | STUN servers help peers discover their public IP. TURN servers relay
    | media when direct P2P fails (symmetric NAT, corporate firewalls).
    | A TURN server is REQUIRED for production WebRTC to work reliably.
    |
    | Free TURN options: Metered.ca (free tier), Open Relay Project.
    | Self-hosted: coturn (https://github.com/coturn/coturn).
    |
    */

    'ice_servers' => array_filter([
        ['urls' => 'stun:stun.l.google.com:19302'],
        ['urls' => 'stun:stun1.l.google.com:19302'],
        env('TURN_SERVER_URL') ? [
            'urls'       => env('TURN_SERVER_URL'),
            'username'   => env('TURN_SERVER_USERNAME', ''),
            'credential' => env('TURN_SERVER_CREDENTIAL', ''),
        ] : null,
        env('TURN_SERVER_URL_2') ? [
            'urls'       => env('TURN_SERVER_URL_2'),
            'username'   => env('TURN_SERVER_USERNAME_2', ''),
            'credential' => env('TURN_SERVER_CREDENTIAL_2', ''),
        ] : null,
    ]),

    /*
    |--------------------------------------------------------------------------
    | WebRTC Signaling
    |--------------------------------------------------------------------------
    |
    | Max payload size (bytes) to send inline via Pusher. SDP offers/answers
    | under this threshold are sent directly in the event; larger ones use
    | a server-side cache relay. Pusher limit is ~10 KB.
    |
    */

    'webrtc_inline_max_bytes' => (int) env('WEBRTC_INLINE_MAX_BYTES', 16000),
    'webrtc_relay_ttl_seconds' => (int) env('WEBRTC_RELAY_TTL', 120),

];
