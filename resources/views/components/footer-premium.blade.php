<footer class="footer-v2">
    <div class="footer-container">

        <div class="footer-brand-section">
            <div class="footer-logo">
                <i class="fas fa-gem gold-gradient-text"></i>
                <span class="logo-text">Lustonex</span>
            </div>
            <p class="brand-description">
                {{ __('components.footer.brand_description') }}
            </p>
            <div class="footer-social-discreet">
                <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" title="Telegram"><i class="fab fa-telegram"></i></a>
                <a href="#" title="Discord"><i class="fab fa-discord"></i></a>
            </div>
        </div>


        <div class="footer-links-grid">
            <div class="footer-column">
                <h4 class="column-title">{{ __('components.footer.explore') }}</h4>
                <ul class="footer-list">
                    <li><a href="{{ route('modelos.nuevas') }}"
                            class="{{ request()->routeIs('modelos.nuevas') ? 'highlight-link' : '' }}">{{ __('components.footer.new_models') }}</a></li>
                    <li><a href="{{ route('modelos.favoritas') }}"
                            class="{{ request()->routeIs('modelos.favoritas') ? 'highlight-link' : '' }}">{{ __('components.footer.favorites') }}</a>
                    </li>
                </ul>
            </div>

            <div class="footer-column">
                <h4 class="column-title">{{ __('components.footer.models_col') }}</h4>
                <ul class="footer-list">
                    <li><a href="{{ route('register.model') }}"
                            class="{{ request()->routeIs('register.model') ? 'highlight-link' : '' }}">{{ __('components.footer.join_as_model') }}</a></li>
                    <li><a href="{{ route('model.help') }}"
                            class="{{ request()->routeIs('model.help') ? 'highlight-link' : '' }}">{{ __('components.footer.help_center') }}</a>
                    </li>
                    <li><a href="{{ route('model.safety') }}"
                            class="{{ request()->routeIs('model.safety') ? 'highlight-link' : '' }}">{{ __('components.footer.safety') }}</a></li>
                    <li><a href="{{ route('model.academy') }}"
                            class="{{ request()->routeIs('model.academy') ? 'highlight-link' : '' }}">{{ __('components.footer.academy') }}</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4 class="column-title">{{ __('components.footer.legal') }}</h4>
                <ul class="footer-list">
                    <li><a href="{{ route('legal.terms') }}"
                            class="{{ request()->routeIs('legal.terms') ? 'highlight-link' : '' }}">{{ __('components.footer.terms_of_use') }}</a>
                    </li>
                    <li><a href="{{ route('legal.privacy') }}"
                            class="{{ request()->routeIs('legal.privacy') ? 'highlight-link' : '' }}">{{ __('components.footer.privacy') }}</a>
                    </li>
                    <li><a href="{{ route('legal.cookies') }}"
                            class="{{ request()->routeIs('legal.cookies') ? 'highlight-link' : '' }}">{{ __('components.footer.cookies') }}</a>
                    </li>
                    <li><a href="{{ route('legal.dmca') }}"
                            class="{{ request()->routeIs('legal.dmca') ? 'highlight-link' : '' }}">{{ __('components.footer.dmca') }}</a>
                    </li>
                    <li><a href="{{ route('legal.compliance') }}"
                            class="{{ request()->routeIs('legal.compliance') ? 'highlight-link' : '' }}">{{ __('components.footer.compliance') }}</a>
                    </li>
                </ul>
            </div>

            <div class="footer-column">
                <h4 class="column-title">{{ __('components.footer.annexes') }}</h4>
                <ul class="footer-list">
                    <li><a href="{{ route('legal.model-contract') }}"
                            class="{{ request()->routeIs('legal.model-contract') ? 'highlight-link' : '' }}">{{ __('components.footer.model_contract') }}</a>
                    </li>
                    <li><a href="{{ route('legal.studio-contract') }}"
                            class="{{ request()->routeIs('legal.studio-contract') ? 'highlight-link' : '' }}">{{ __('components.footer.studio_contract') }}</a>
                    </li>
                    <li><a href="{{ route('legal.affiliate-agreement') }}"
                            class="{{ request()->routeIs('legal.affiliate-agreement') ? 'highlight-link' : '' }}">{{ __('components.footer.affiliate_agreement') }}</a>
                    </li>
                    <li><a href="{{ route('legal.moderation-policy') }}"
                            class="{{ request()->routeIs('legal.moderation-policy') ? 'highlight-link' : '' }}">{{ __('components.footer.moderation_policy') }}</a>
                    </li>
                    <li><a href="{{ route('legal.protection-policy') }}"
                            class="{{ request()->routeIs('legal.protection-policy') ? 'highlight-link' : '' }}">{{ __('components.footer.protection_policy') }}</a>
                    </li>
                    <li><a href="{{ route('legal.model-release') }}"
                            class="{{ request()->routeIs('legal.model-release') ? 'highlight-link' : '' }}">{{ __('components.footer.model_release') }}</a>
                    </li>
                    <li><a href="{{ route('legal.tax-policy') }}"
                            class="{{ request()->routeIs('legal.tax-policy') ? 'highlight-link' : '' }}">{{ __('components.footer.tax_policy') }}</a>
                    </li>
                </ul>
            </div>

            <div class="footer-column">
                <h4 class="column-title">{{ __('components.footer.support') }}</h4>
                <ul class="footer-list">
                    <li><a href="{{ route('support.main') }}"
                            class="{{ request()->routeIs('support.main') ? 'highlight-link' : '' }}">{{ __('components.footer.support_247') }}</a>
                    </li>
                    <li><a href="{{ route('support.billing') }}"
                            class="{{ request()->routeIs('support.billing') ? 'highlight-link' : '' }}">{{ __('components.footer.billing') }}</a>
                    </li>
                    <li><a href="{{ route('support.faq') }}"
                            class="{{ request()->routeIs('support.faq') ? 'highlight-link' : '' }}">{{ __('components.footer.faq') }}</a></li>
                    <li><a href="{{ route('support.contact') }}"
                            class="{{ request()->routeIs('support.contact') ? 'highlight-link' : '' }}">{{ __('components.footer.contact') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>


    <div class="footer-bottom">
        <div class="bottom-container">
            <div class="compliance-badges">
                <span class="badge-18">{{ __('components.footer.adults_only') }}</span>
                <p class="compliance-text">
                    {{ __('components.footer.compliance_text') }}
                </p>
            </div>

            <div class="payment-trust">
                <div class="payment-icons">
                    <i class="fab fa-cc-visa" title="Visa"></i>
                    <i class="fab fa-cc-mastercard" title="Mastercard"></i>
                    <i class="fab fa-bitcoin" title="Crypto Accepted"></i>
                    <i class="fas fa-shield-alt" title="Secure Payment"></i>
                </div>
                <p class="copyright-text">
                    {{ __('components.footer.copyright', ['year' => date('Y')]) }}
                </p>
            </div>

            <!-- Mobile Only Language Selector -->
            <div class="footer-mobile-locale visible-mobile-only">
                <div class="user-menu-compact" id="footerLocaleDropdown">
                    <button class="footer-locale-btn" onclick="toggleFooterLocaleDropdown(event)">
                        @php $currentLocale = app()->getLocale(); @endphp
                        <div class="selected-locale">
                            @if($currentLocale == 'es')
                                <span class="fi fi-es"></span> <span>ES</span>
                            @elseif($currentLocale == 'en')
                                <span class="fi fi-us"></span> <span>EN</span>
                            @elseif($currentLocale == 'pt_BR')
                                <span class="fi fi-br"></span> <span>PT</span>
                            @endif
                        </div>
                        <i class="fas fa-chevron-up"></i>
                    </button>
                    
                    <div class="footer-locale-dropdown-menu" id="footerLocaleDropdownMenu">
                        <div class="dropdown-items">
                            <form method="POST" action="{{ route('locale.update') }}" id="footer-form-locale-es">
                                @csrf
                                <input type="hidden" name="locale" value="es">
                                <button type="button" onclick="document.getElementById('footer-form-locale-es').submit()" class="dropdown-item {{ $currentLocale == 'es' ? 'active' : '' }}">
                                    <span class="fi fi-es"></span> Español
                                </button>
                            </form>
                            <form method="POST" action="{{ route('locale.update') }}" id="footer-form-locale-en">
                                @csrf
                                <input type="hidden" name="locale" value="en">
                                <button type="button" onclick="document.getElementById('footer-form-locale-en').submit()" class="dropdown-item {{ $currentLocale == 'en' ? 'active' : '' }}">
                                    <span class="fi fi-us"></span> English
                                </button>
                            </form>
                            <form method="POST" action="{{ route('locale.update') }}" id="footer-form-locale-pt_BR">
                                @csrf
                                <input type="hidden" name="locale" value="pt_BR">
                                <button type="button" onclick="document.getElementById('footer-form-locale-pt_BR').submit()" class="dropdown-item {{ $currentLocale == 'pt_BR' ? 'active' : '' }}">
                                    <span class="fi fi-br"></span> Português
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer-v2 {
        background: #08080A;
        border-top: 1px solid rgba(212, 175, 55, 0.1);
        margin-top: 60px;
        font-family: 'Raleway', sans-serif;
        position: relative;
        z-index: 10;
        width: 100%;
        box-sizing: border-box; /* Previene overflow */
    }

    .footer-container {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px;
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 80px;
        box-sizing: border-box;
    }

    .footer-brand-section {
        max-width: 400px;
    }

    .footer-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
    }

    .footer-logo i {
        font-size: 24px;
    }

    .gold-gradient-text {
        background: var(--gradient-gold);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .logo-text {
        font-family: 'Poppins', sans-serif;
        font-size: 24px;
        font-weight: 700;
        color: #fff;
        letter-spacing: -0.5px;
    }

    .brand-description {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.6);
        line-height: 1.8;
        margin-bottom: 24px;
    }

    .footer-social-discreet {
        display: flex;
        gap: 20px;
    }

    .footer-social-discreet a {
        color: rgba(255, 255, 255, 0.4);
        font-size: 18px;
        transition: all 0.3s ease;
    }

    .footer-social-discreet a:hover {
        color: var(--color-oro-sensual);
        transform: translateY(-3px);
    }

    .footer-links-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
    }

    .column-title {
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: 600;
        color: #fff;
        margin-bottom: 24px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .footer-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-list li {
        margin-bottom: 12px;
    }

    .footer-list a {
        color: rgba(255, 255, 255, 0.5);
        text-decoration: none;
        font-size: 14px;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .footer-list a:hover {
        color: var(--color-oro-sensual);
        transform: translateX(5px);
    }

    .highlight-link {
        color: var(--color-oro-sensual) !important;
        font-weight: 600;
    }

    /* Bottom Bar */
    .footer-bottom {
        background: #040405;
        padding: 40px 0;
        border-top: 1px solid rgba(255, 255, 255, 0.03);
    }

    .bottom-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 40px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 60px;
    }

    .compliance-badges {
        max-width: 600px;
    }

    .badge-18 {
        display: inline-block;
        border: 1px solid #ff4b4b;
        color: #ff4b4b;
        padding: 4px 12px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 700;
        margin-bottom: 12px;
        letter-spacing: 1px;
    }

    .compliance-text {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.3);
        line-height: 1.6;
    }

    .payment-trust {
        text-align: right;
    }

    .payment-icons {
        display: flex;
        justify-content: flex-end;
        gap: 20px;
        margin-bottom: 16px;
        font-size: 24px;
        color: rgba(255, 255, 255, 0.2);
    }

    .copyright-text {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.3);
    }

    .visible-mobile-only {
        display: none !important;
    }

    .footer-mobile-locale {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    .footer-locale-btn {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 6px 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #fff;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .footer-locale-btn:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: var(--color-oro-sensual);
    }

    .selected-locale {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .footer-locale-btn i {
        font-size: 10px;
        opacity: 0.6;
        transition: transform 0.3s ease;
    }

    .user-menu-compact.active .footer-locale-btn i {
        transform: rotate(180deg);
    }

    .footer-locale-dropdown-menu {
        position: absolute;
        bottom: calc(100% + 10px);
        left: 50%;
        transform: translateX(-50%) translateY(10px);
        width: 160px;
        background: #1a1a1e;
        border: 1px solid rgba(212, 175, 55, 0.3);
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1000;
        padding: 6px;
    }

    .user-menu-compact.active .footer-locale-dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(0);
    }

    .footer-locale-dropdown-menu .dropdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.2s ease;
        text-align: left;
        width: 100%;
        background: transparent;
        border: none;
        cursor: pointer;
    }

    .footer-locale-dropdown-menu .dropdown-item:hover {
        background: rgba(212, 175, 55, 0.1);
        color: #fff;
    }

    .footer-locale-dropdown-menu .dropdown-item.active {
        color: var(--color-oro-sensual);
        background: rgba(212, 175, 55, 0.05);
    }

    /* Large Desktop – brand left, 5 link columns right */
    /* (default styles above already handle >1280px) */

    /* Medium-large screens: stack brand on top, keep 5 columns */
    @media (max-width: 1280px) {
        .footer-container {
            grid-template-columns: 1fr;
            gap: 40px;
            padding: 40px 40px;
        }

        .footer-brand-section {
            max-width: 100%;
            text-align: center;
        }

        .footer-logo {
            justify-content: center;
        }

        .footer-social-discreet {
            justify-content: center;
        }

        .footer-links-grid {
            grid-template-columns: repeat(5, 1fr);
            gap: 24px;
        }
    }

    /* Tablet: brand on top, 3-column link grid */
    @media (max-width: 900px) {
        .footer-container {
            padding: 40px 30px;
            gap: 36px;
        }

        .footer-links-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 30px 24px;
        }

        .bottom-container {
            flex-direction: column;
            align-items: center;
            gap: 30px;
            padding: 0 30px;
            text-align: center;
        }

        .compliance-badges,
        .payment-trust {
            max-width: 100%;
            width: 100%;
            text-align: center;
        }

        .payment-icons {
            justify-content: center;
        }
    }

    /* Small tablet / large phone: 2-column link grid */
    @media (max-width: 640px) {
        .footer-v2 {
            padding: 40px 0 0;
        }

        .footer-container {
            padding: 32px 20px;
            gap: 32px;
        }

        .footer-links-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 28px 20px;
        }

        .footer-column {
            text-align: center;
        }

        .column-title {
            margin-bottom: 16px;
            font-size: 13px;
        }

        .footer-list a {
            font-size: 13px;
        }

        .bottom-container {
            padding: 0 20px;
            gap: 24px;
        }

        .visible-mobile-only {
            display: flex !important;
            justify-content: center;
        }
    }

    /* Very small phone */
    @media (max-width: 400px) {
        .footer-container {
            padding: 24px 16px;
        }

        .footer-links-grid {
            grid-template-columns: 1fr;
            gap: 24px;
        }

        .bottom-container {
            padding: 0 16px;
        }

        .brand-description {
            font-size: 13px;
        }
    }
</style>

<script>
    function toggleFooterLocaleDropdown(event) {
        if (event) event.stopPropagation();
        const dropdown = document.getElementById('footerLocaleDropdown');
        dropdown.classList.toggle('active');

        if (dropdown.classList.contains('active')) {
            document.addEventListener('click', closeFooterLocaleDropdownOnOutsideClick);
        } else {
            document.removeEventListener('click', closeFooterLocaleDropdownOnOutsideClick);
        }
    }

    function closeFooterLocaleDropdownOnOutsideClick(event) {
        const dropdown = document.getElementById('footerLocaleDropdown');
        if (dropdown && !dropdown.contains(event.target)) {
            dropdown.classList.remove('active');
            document.removeEventListener('click', closeFooterLocaleDropdownOnOutsideClick);
        }
    }
</script>