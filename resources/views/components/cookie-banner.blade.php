<div id="cookie-banner" class="cookie-banner" style="display: none;">
    <div class="cookie-banner-container">
        <div class="cookie-banner-content">
            <h3><i class="fas fa-cookie-bite"></i> {{ __('legal.cookies_banner.title') }}</h3>
            <p>{{ __('legal.cookies_banner.description') }}</p>
        </div>
        <div class="cookie-banner-actions">
            <button type="button" class="cookie-btn cookie-btn-outline" onclick="toggleCookieSettings()">
                {{ __('legal.cookies_banner.configure') }}
            </button>
            <button type="button" class="cookie-btn cookie-btn-outline" onclick="setCookieConsent('rejected')">
                {{ __('legal.cookies_banner.reject') }}
            </button>
            <button type="button" class="cookie-btn cookie-btn-primary" onclick="setCookieConsent('accepted')">
                {{ __('legal.cookies_banner.accept') }}
            </button>
        </div>
    </div>

    <!-- Configuration Panel (Hidden by default) -->
    <div id="cookie-settings" class="cookie-settings" style="display: none;">
        <div class="cookie-settings-header">
            <h4>{{ __('legal.cookies_banner.configure') }}</h4>
            <button type="button" class="close-settings" onclick="toggleCookieSettings()">&times;</button>
        </div>
        <div class="cookie-settings-list">
            <div class="cookie-setting-item">
                <div class="setting-info">
                    <strong>{{ __('legal.cookies_banner.functional') }}</strong>
                    <span>{{ __('legal.cookies_banner.functional_desc') }}</span>
                </div>
                <div class="setting-toggle">
                    <input type="checkbox" checked disabled>
                    <span class="toggle-slider disabled"></span>
                </div>
            </div>
            <div class="cookie-setting-item">
                <div class="setting-info">
                    <strong>{{ __('legal.cookies_banner.analytics') }}</strong>
                    <span>{{ __('legal.cookies_banner.analytics_desc') }}</span>
                </div>
                <div class="setting-toggle">
                    <input type="checkbox" id="cookie-analytics" checked>
                    <label for="cookie-analytics" class="toggle-slider"></label>
                </div>
            </div>
            <div class="cookie-setting-item">
                <div class="setting-info">
                    <strong>{{ __('legal.cookies_banner.marketing') }}</strong>
                    <span>{{ __('legal.cookies_banner.marketing_desc') }}</span>
                </div>
                <div class="setting-toggle">
                    <input type="checkbox" id="cookie-marketing" checked>
                    <label for="cookie-marketing" class="toggle-slider"></label>
                </div>
            </div>
        </div>
        <div class="cookie-settings-footer">
            <button type="button" class="cookie-btn cookie-btn-primary" onclick="saveCookieSettings()">
                {{ __('legal.cookies_banner.save') }}
            </button>
        </div>
    </div>
</div>

<style>
    .cookie-banner {
        position: fixed;
        bottom: 24px;
        left: 50%;
        transform: translateX(-50%);
        width: 90%;
        max-width: 1000px;
        background: rgba(18, 18, 22, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        z-index: 9999;
        animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .cookie-banner-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 32px;
    }

    .cookie-banner-content {
        flex: 1;
    }

    .cookie-banner-content h3 {
        color: #D4AF37;
        font-size: 1.1rem;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .cookie-banner-content p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.9rem;
        line-height: 1.5;
        margin: 0;
    }

    .cookie-banner-actions {
        display: flex;
        gap: 12px;
    }

    .cookie-btn {
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .cookie-btn-primary {
        background: #D4AF37;
        color: #000;
        border: none;
    }

    .cookie-btn-primary:hover {
        background: #fff;
        transform: translateY(-2px);
    }

    .cookie-btn-outline {
        background: transparent;
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .cookie-btn-outline:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: #D4AF37;
    }

    /* Settings Panel */
    .cookie-settings {
        margin-top: 24px;
        padding-top: 24px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .cookie-settings-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .cookie-settings-header h4 {
        color: #fff;
        margin: 0;
    }

    .close-settings {
        background: none;
        border: none;
        color: #fff;
        font-size: 1.5rem;
        cursor: pointer;
        opacity: 0.5;
    }

    .close-settings:hover {
        opacity: 1;
    }

    .cookie-settings-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }

    .cookie-setting-item {
        background: rgba(255, 255, 255, 0.05);
        padding: 16px;
        border-radius: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .setting-info {
        display: flex;
        flex-direction: column;
    }

    .setting-info strong {
        color: #fff;
        font-size: 0.9rem;
        margin-bottom: 4px;
    }

    .setting-info span {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.8rem;
    }

    .toggle-slider {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 22px;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        cursor: pointer;
        transition: .4s;
    }

    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 3px;
        bottom: 3px;
        background-color: #fff;
        border-radius: 50%;
        transition: .4s;
    }

    input:checked + .toggle-slider {
        background-color: #D4AF37;
    }

    input:checked + .toggle-slider:before {
        transform: translateX(18px);
    }

    .cookie-setting-item input {
        display: none;
    }

    .toggle-slider.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background-color: #D4AF37;
    }

    .cookie-settings-footer {
        display: flex;
        justify-content: flex-end;
    }

    @keyframes slideUp {
        from {
            transform: translate(-50%, 100%);
            opacity: 0;
        }
        to {
            transform: translate(-50%, 0);
            opacity: 1;
        }
    }

    @media (max-width: 768px) {
        .cookie-banner-container {
            flex-direction: column;
            text-align: center;
            gap: 20px;
        }

        .cookie-banner-actions {
            width: 100%;
            flex-direction: column;
        }

        .cookie-btn {
            width: 100%;
        }

        .cookie-settings-list {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const consent = localStorage.getItem('cookie_consent');
        if (!consent) {
            document.getElementById('cookie-banner').style.display = 'block';
        }
    });

    function setCookieConsent(type) {
        localStorage.setItem('cookie_consent', type);
        localStorage.setItem('cookie_consent_date', new Date().toISOString());
        
        if (type === 'accepted') {
            localStorage.setItem('cookie_analytics', 'true');
            localStorage.setItem('cookie_marketing', 'true');
        } else if (type === 'rejected') {
            localStorage.setItem('cookie_analytics', 'false');
            localStorage.setItem('cookie_marketing', 'false');
        }
        
        hideCookieBanner();
    }

    function toggleCookieSettings() {
        const settings = document.getElementById('cookie-settings');
        settings.style.display = settings.style.display === 'none' ? 'block' : 'none';
        
        // Scroll to settings if on mobile
        if (window.innerWidth <= 768 && settings.style.display === 'block') {
            settings.scrollIntoView({ behavior: 'smooth' });
        }
    }

    function saveCookieSettings() {
        const analytics = document.getElementById('cookie-analytics').checked;
        const marketing = document.getElementById('cookie-marketing').checked;
        
        localStorage.setItem('cookie_consent', 'configured');
        localStorage.setItem('cookie_consent_date', new Date().toISOString());
        localStorage.setItem('cookie_analytics', analytics);
        localStorage.setItem('cookie_marketing', marketing);
        
        hideCookieBanner();
    }

    function hideCookieBanner() {
        const banner = document.getElementById('cookie-banner');
        banner.style.transition = 'all 0.5s ease';
        banner.style.transform = 'translate(-50%, 100%)';
        banner.style.opacity = '0';
        setTimeout(() => {
            banner.style.display = 'none';
        }, 500);
    }
</script>
