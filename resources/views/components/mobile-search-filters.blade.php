
<div class="mobile-search-filters" id="mobileSearchFilters">
    
    <div class="mobile-search-bar">
        <button class="search-toggle" onclick="toggleMobileSearch()">
            <i class="fa-solid fa-magnifying-glass"></i>
            <span>{{ __('components.mobile_search.search_placeholder') }}</span>
        </button>
        <button class="filter-toggle-btn" onclick="toggleMobileFilters()">
            <i class="fa-solid fa-sliders"></i>
        </button>
    </div>

    
    <div class="mobile-search-panel" id="mobileSearchPanel">
        <div class="search-panel-header">
            <input type="text" class="search-input" placeholder="{{ __('components.mobile_search.search_input_placeholder') }}"
                id="mobileSearchInput" autocomplete="off">
            <button class="search-close" onclick="toggleMobileSearch()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="search-panel-content">
            
            <div class="search-section">
                <h4 class="search-section-title">{{ __('components.mobile_search.recent_searches') }}</h4>
                <div class="recent-searches">
                    <a href="#" class="recent-search-item">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <span>colombia</span>
                    </a>
                    <a href="#" class="recent-search-item">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <span>argentina</span>
                    </a>
                </div>
            </div>

            
            <div class="search-section">
                <h4 class="search-section-title">{{ __('components.mobile_search.trending') }}</h4>
                <div class="trending-tags">
                    <a href="{{ route('filtros.edad', '18-25') }}" class="tag-item">
                        <i class="fa-solid fa-tag"></i>
                        <span>Adolescentes 18+</span>
                        <span class="tag-count">875</span>
                    </a>
                    <a href="#" class="tag-item">
                        <i class="fa-solid fa-tag"></i>
                        <span>Pechos grandes</span>
                        <span class="tag-count">2018</span>
                    </a>
                    <a href="#" class="tag-item">
                        <i class="fa-solid fa-tag"></i>
                        <span>MILF</span>
                        <span class="tag-count">869</span>
                    </a>
                    <a href="{{ route('filtros.etnia', 'asiatica') }}" class="tag-item">
                        <i class="fa-solid fa-tag"></i>
                        <span>Asiáticas</span>
                        <span class="tag-count">616</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    
    <div class="mobile-filters-panel" id="mobileFiltersPanel">
        <div class="filters-panel-header">
            <h3>{{ __('components.mobile_search.filters_title') }}</h3>
            <button class="filters-close" onclick="toggleMobileFilters()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="filters-panel-content">
            
            <div class="filter-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="{{ __('components.mobile_search.filter_search_placeholder') }}">
            </div>

            <!-- Categoría -->
            <div class="filter-category">
                <h4 class="filter-category-title">{{ __('components.mobile_search.category') }}</h4>
                <div class="mobile-category-pills">
                    <button class="mobile-pill active" data-category="todos">{{ __('components.mobile_search.all') }}</button>
                    <button class="mobile-pill" data-category="chicas">{{ __('components.mobile_search.girls') }}</button>
                    <button class="mobile-pill" data-category="chicos">{{ __('components.mobile_search.guys') }}</button>
                    <button class="mobile-pill" data-category="parejas">{{ __('components.mobile_search.couples') }}</button>
                    <button class="mobile-pill" data-category="trans">{{ __('components.mobile_search.trans') }}</button>
                </div>
            </div>

            <!-- Edad -->
            <div class="filter-category">
                <h4 class="filter-category-title">{{ __('components.mobile_search.age') }}</h4>
                <div class="filter-options">
                    <label class="filter-checkbox">
                        <input type="checkbox" name="age[]" value="18-25">
                        <span class="checkbox-custom"></span>
                        <span class="filter-label">18 - 25</span>
                    </label>
                    <label class="filter-checkbox">
                        <input type="checkbox" name="age[]" value="26-35">
                        <span class="checkbox-custom"></span>
                        <span class="filter-label">26 - 35</span>
                    </label>
                    <label class="filter-checkbox">
                        <input type="checkbox" name="age[]" value="36+">
                        <span class="checkbox-custom"></span>
                        <span class="filter-label">36+</span>
                    </label>
                </div>
            </div>

            <!-- País -->
            <div class="filter-category">
                <h4 class="filter-category-title">{{ __('components.mobile_search.country') }}</h4>
                <div class="filter-options">
                    <label class="filter-checkbox">
                        <input type="checkbox" name="country[]" value="Colombia">
                        <span class="checkbox-custom"></span>
                        <span class="filter-label">🇨🇴 Colombia</span>
                    </label>
                    <label class="filter-checkbox">
                        <input type="checkbox" name="country[]" value="Argentina">
                        <span class="checkbox-custom"></span>
                        <span class="filter-label">🇦🇷 Argentina</span>
                    </label>
                </div>
            </div>

            <!-- Etnia -->
            <div class="filter-category">
                <h4 class="filter-category-title">{{ __('components.mobile_search.ethnicity') }}</h4>
                <div class="filter-options">
                    <label class="filter-checkbox">
                        <input type="checkbox" name="ethnicity[]" value="Latina">
                        <span class="checkbox-custom"></span>
                        <span class="filter-label">Latina</span>
                    </label>
                    <label class="filter-checkbox">
                        <input type="checkbox" name="ethnicity[]" value="Blanca">
                        <span class="checkbox-custom"></span>
                        <span class="filter-label">Blanca</span>
                    </label>
                </div>
            </div>

            <!-- Disponibilidad -->
            <div class="filter-category">
                <h4 class="filter-category-title">{{ __('components.mobile_search.availability') }}</h4>
                <div class="filter-options">
                    <label class="filter-checkbox">
                        <input type="checkbox" name="availability[]" value="live">
                        <span class="checkbox-custom"></span>
                        <span class="filter-label">{{ __('components.mobile_search.live') }}</span>
                    </label>
                    <label class="filter-checkbox">
                        <input type="checkbox" name="availability[]" value="online">
                        <span class="checkbox-custom"></span>
                        <span class="filter-label">{{ __('components.mobile_search.online') }}</span>
                    </label>
                </div>
            </div>

            <!-- Apariencia -->
            <div class="filter-category">
                <h4 class="filter-category-title">{{ __('components.mobile_search.appearance') }}</h4>
                <div class="filter-options">
                    <label class="filter-checkbox">
                        <input type="checkbox" name="appearance[]" value="delgada">
                        <span class="checkbox-custom"></span>
                        <span class="filter-label">{{ __('components.mobile_search.slim') }}</span>
                    </label>
                    <label class="filter-checkbox">
                        <input type="checkbox" name="appearance[]" value="curvas">
                        <span class="checkbox-custom"></span>
                        <span class="filter-label">{{ __('components.mobile_search.curves') }}</span>
                    </label>
                </div>
            </div>

            <!-- Idiomas -->
            <div class="filter-category">
                <h4 class="filter-category-title">{{ __('components.mobile_search.languages') }}</h4>
                <div class="filter-options">
                    <label class="filter-checkbox">
                        <input type="checkbox" name="languages[]" value="Español">
                        <span class="checkbox-custom"></span>
                        <span class="filter-label">Español</span>
                    </label>
                    <label class="filter-checkbox">
                        <input type="checkbox" name="languages[]" value="Inglés">
                        <span class="checkbox-custom"></span>
                        <span class="filter-label">Inglés</span>
                    </label>
                </div>
            </div>

            <div class="filters-panel-footer">
                <button class="btn-apply-filters" onclick="applyMobileFilters()">
                    <i class="fa-solid fa-check"></i>
                    {{ __('components.mobile_search.apply_filters') }}
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Mobile Search & Filters - Only visible on mobile */
    .mobile-search-filters {
        display: none;
        position: sticky;
        top: 60px;
        z-index: 999;
        background: #0b0b0d;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    @media (max-width: 1024px) {
        .mobile-search-filters {
            display: block;
        }
    }

    /* Search Bar */
    .mobile-search-bar {
        display: flex;
        gap: 0.5rem;
        padding: 0.25rem 1.25rem;
        background: #0b0b0d;
        align-items: center;
        justify-content: center;
    }

    .search-toggle {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem 1rem;
        height: 40px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .search-toggle:active {
        background: rgba(255, 255, 255, 0.08);
    }

    .search-toggle i {
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.95rem;
    }

    .search-toggle span {
        flex: 1;
        text-align: left;
    }

    .filter-toggle-btn {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #D4AF37, #FFD700);
        border: none;
        border-radius: 8px;
        color: #0a0a0a;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(212, 175, 55, 0.3);
    }

    .filter-toggle-btn:active {
        transform: scale(0.95);
    }

    /* Search Panel */
    .mobile-search-panel {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #1a1a1e;
        z-index: 1100;
        transform: translateY(-100%);
        transition: transform 0.3s ease;
        overflow-y: auto;
    }

    .mobile-search-panel.active {
        transform: translateY(0);
    }

    .search-panel-header {
        position: sticky;
        top: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        background: #1a1a1e;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        z-index: 10;
    }

    .search-input {
        flex: 1;
        padding: 0.875rem 1rem;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        color: #fff;
        font-size: 0.9rem;
    }

    .search-input::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }

    .search-close {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        color: rgba(255, 255, 255, 0.7);
        font-size: 1.2rem;
        cursor: pointer;
    }

    .search-panel-content {
        padding: 1rem;
    }

    .search-section {
        margin-bottom: 2rem;
    }

    .search-section-title {
        font-size: 0.75rem;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.4);
        letter-spacing: 1px;
        margin-bottom: 1rem;
    }

    .recent-searches {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .recent-search-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 8px;
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .recent-search-item:active {
        background: rgba(255, 255, 255, 0.08);
    }

    .recent-search-item i {
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.9rem;
    }

    .trending-tags {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .tag-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 8px;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .tag-item:active {
        background: rgba(212, 175, 55, 0.1);
    }

    .tag-item i {
        color: #D4AF37;
        font-size: 0.85rem;
    }

    .tag-item span:first-of-type {
        flex: 1;
    }

    .tag-count {
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.4);
        font-weight: 600;
    }

    /* Filters Panel */
    .mobile-filters-panel {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #1a1a1e;
        z-index: 1100;
        transform: translateX(100%);
        transition: transform 0.3s ease;
        display: flex;
        flex-direction: column;
        padding-top: 60px;
        /* Espacio para el header principal */
    }

    .mobile-filters-panel.active {
        transform: translateX(0);
    }

    .filters-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        background: #1a1a1e;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .filters-panel-header h3 {
        font-size: 1rem;
        font-weight: 600;
        color: #fff;
        margin: 0;
    }

    .filters-panel-header .highlight {
        color: #D4AF37;
    }

    .filters-close {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        color: rgba(255, 255, 255, 0.7);
        font-size: 1.2rem;
        cursor: pointer;
    }

    .filters-panel-content {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
        padding-bottom: 80px;
    }

    .filter-search {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem 1rem;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }

    .filter-search i {
        color: rgba(255, 255, 255, 0.4);
    }

    .filter-search input {
        flex: 1;
        background: transparent;
        border: none;
        color: #fff;
        font-size: 0.9rem;
    }

    .filter-search input::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }

    .filter-category {
        margin-bottom: 2rem;
    }

    /* Category Pills */
    .mobile-category-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .mobile-pill {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.7);
        padding: 0.6rem 1.25rem;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .mobile-pill.active {
        background: linear-gradient(135deg, #D4AF37, #FFD700);
        color: #000;
        border-color: transparent;
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.2);
    }

    .filter-category-title {
        font-size: 0.75rem;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.4);
        letter-spacing: 1px;
        margin-bottom: 1rem;
    }

    .filter-options {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .filter-checkbox {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-checkbox:active {
        background: rgba(255, 255, 255, 0.08);
    }

    .filter-checkbox input[type="checkbox"] {
        display: none;
    }

    .checkbox-custom {
        width: 20px;
        height: 20px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 4px;
        position: relative;
        transition: all 0.3s ease;
    }

    .filter-checkbox input[type="checkbox"]:checked+.checkbox-custom {
        background: linear-gradient(135deg, #D4AF37, #FFD700);
        border-color: #D4AF37;
    }

    .filter-checkbox input[type="checkbox"]:checked+.checkbox-custom::after {
        content: '\f00c';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #0a0a0a;
        font-size: 0.7rem;
    }

    .filter-label {
        flex: 1;
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.9rem;
    }

    .filter-count {
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.4);
        font-weight: 600;
    }

    .filters-panel-footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1rem;
        background: #1a1a1e;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .btn-apply-filters {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, #D4AF37, #FFD700);
        border: none;
        border-radius: 8px;
        color: #0a0a0a;
        font-size: 1rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
    }

    .btn-apply-filters:active {
        transform: scale(0.98);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Manejo de pills de categoría en móvil
        const categoryPills = document.querySelectorAll('.mobile-pill');
        categoryPills.forEach(pill => {
            pill.addEventListener('click', function() {
                categoryPills.forEach(p => p.classList.remove('active'));
                this.classList.add('active');
            });
        });
    });

    function toggleMobileSearch() {
        const panel = document.getElementById('mobileSearchPanel');
        panel.classList.toggle('active');

        if (panel.classList.contains('active')) {
            document.getElementById('mobileSearchInput').focus();
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    }

    function toggleMobileFilters() {
        const panel = document.getElementById('mobileFiltersPanel');
        panel.classList.toggle('active');

        if (panel.classList.contains('active')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    }

    function applyMobileFilters() {
        console.log('Aplicando filtros móviles...');
        
        // Obtener término de búsqueda
        const searchInput = document.getElementById('mobileSearchInput');
        const searchTerm = searchInput ? searchInput.value : '';
        
        const filters = {
            search: searchTerm,
            category: 'todos',
            age: [],
            ethnicity: [],
            appearance: [],
            country: [],
            availability: [],
            languages: []
        };

        // Recopilar categoría activa (usando selector más específico)
        const activePill = document.querySelector('#mobileFiltersPanel .mobile-pill.active');
        if (activePill) {
            filters.category = activePill.getAttribute('data-category') || 'todos';
        }

        // Recopilar todos los checkboxes marcados dentro del panel de filtros
        const checkboxes = document.querySelectorAll('#mobileFiltersPanel input[type="checkbox"]:checked');
        checkboxes.forEach(checkbox => {
            // El name suele ser algo como "age[]"
            const name = checkbox.getAttribute('name').replace('[]', '');
            if (filters[name]) {
                filters[name].push(checkbox.value);
            }
        });

        // Construir URL con parámetros de forma robusta
        const params = new URLSearchParams();
        
        if (filters.search) params.set('search', filters.search);
        if (filters.category && filters.category !== 'todos') {
            params.set('category', filters.category);
        }
        
        const arrayParams = ['age', 'ethnicity', 'appearance', 'country', 'availability', 'languages'];
        arrayParams.forEach(key => {
            if (filters[key] && filters[key].length > 0) {
                filters[key].forEach(value => {
                    params.append(key + '[]', value);
                });
            }
        });

        const queryString = params.toString();
        const finalUrl = '/search/models' + (queryString ? '?' + queryString : '');
        
        console.log('Redirigiendo a:', finalUrl);

        // Ocultar panel móvil
        if (typeof toggleMobileFilters === 'function') {
            toggleMobileFilters();
        }

        // Redirigir
        window.location.href = finalUrl;
    }
</script>