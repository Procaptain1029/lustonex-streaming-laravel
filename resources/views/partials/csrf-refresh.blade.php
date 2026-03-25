<script>
    /**
     * Lustonex Premium - CSRF Auto-Refresh System
     * Keeps the session alive and prevents TokenMismatchException
     */
    function refreshCsrfToken() {
        fetch('{{ url("/refresh-csrf") }}')
            .then(response => response.json())
            .then(data => {
                // Update Meta Tag
                const meta = document.querySelector('meta[name="csrf-token"]');
                if (meta) {
                    meta.setAttribute('content', data.token);
                }
                
                // Update all hidden tokens in forms
                document.querySelectorAll('input[name="_token"]').forEach(input => {
                    input.value = data.token;
                });
                
                console.log('%c[CSRF]%c Token Refreshed Successfully', 'color: #D4AF37; font-weight: bold;', 'color: inherit;');
            })
            .catch(err => console.error('[CSRF] Auto-refresh failed:', err));
    }

    // Initialize auto-refresh every 10 minutes (600,000ms)
    setInterval(refreshCsrfToken, 600000);
</script>
