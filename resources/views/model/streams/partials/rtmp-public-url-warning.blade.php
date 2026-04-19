@php
    $rtmpBase = (string) config('streaming.rtmp_public_url_base');
    $looksLocal = str_contains($rtmpBase, '127.0.0.1') || str_contains($rtmpBase, 'localhost');
@endphp
@if ($looksLocal && ! app()->environment(['local', 'testing']))
    <div role="alert"
        style="margin-bottom:1rem;padding:0.85rem 1rem;border-radius:10px;border:1px solid rgba(220,53,69,0.45);background:rgba(220,53,69,0.12);color:#f8d7da;font-size:0.85rem;line-height:1.45;">
        <strong style="color:#ff6b6b;">RTMP URL misconfigured for this environment.</strong>
        <code style="color:#fff;background:rgba(0,0,0,0.35);padding:2px 6px;border-radius:4px;">RTMP_PUBLIC_URL</code>
        still points to localhost (<code style="color:#ffc107;">{{ $rtmpBase }}</code>). OBS on your PC must publish to your
        <strong>public ingest host</strong> (e.g. <code style="color:#ffc107;">rtmp://rtmp.yourdomain.com:1935/live</code>), and TCP
        <strong>1935</strong> must be open on that server. Set <code>RTMP_PUBLIC_URL</code> in production <code>.env</code>, then run
        <code style="color:#ffc107;">php artisan config:clear</code>. The in-browser preview reads HLS from this app only after the server receives RTMP.
    </div>
@endif
