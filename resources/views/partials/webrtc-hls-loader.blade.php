{{-- Load hls.js only when WebRTC fails or HLS-only path — avoids blocking parse/download before joinBroadcast(). --}}
<script>
(function () {
    window.__lustonexEnsureHls = function () {
        if (window.Hls) {
            return Promise.resolve();
        }
        if (window.__lustonexHlsP) {
            return window.__lustonexHlsP;
        }
        window.__lustonexHlsP = new Promise(function (resolve, reject) {
            var s = document.createElement('script');
            s.src = 'https://cdn.jsdelivr.net/npm/hls.js@1.5.7/dist/hls.min.js';
            s.async = true;
            s.onload = function () { resolve(); };
            s.onerror = reject;
            document.head.appendChild(s);
        });
        return window.__lustonexHlsP;
    };
})();
</script>
