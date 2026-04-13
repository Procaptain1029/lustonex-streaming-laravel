

@php
    $searchId = $searchId ?? uniqid('search_');
@endphp

<div class="sh-search-wrapper" data-search-id="{{ $searchId }}">
    
    <div class="sh-search-bar">
        <div class="sh-search-input-group">
            <i class="fas fa-search sh-search-icon-gold"></i>
            <input type="text" 
                   id="sh-search-input-{{ $searchId }}" 
                   class="sh-search-input-field" 
                   placeholder="{{ __('components.search_models.placeholder') }}"
                   autocomplete="off">
            
            <div class="sh-search-actions">
                <button type="button" class="sh-search-btn-clear" id="sh-search-clear-{{ $searchId }}" aria-label="{{ __('components.search_models.clear_title') }}">
                    <i class="fas fa-times-circle"></i>
                </button>
                <div class="sh-search-divider"></div>
                <button type="button" class="sh-search-btn-filters" id="sh-search-filters-toggle-{{ $searchId }}" aria-label="{{ __('components.search_models.filters_title') }}">
                    <span class="sh-search-filters-inner">
                        <i class="fas fa-sliders-h sh-search-filters-icon" aria-hidden="true"></i>
                        <span class="sh-search-filters-label">{{ __('components.search_models.filters_text') }}</span>
                    </span>
                </button>
            </div>
        </div>
    </div>

    
    {{-- Portal to body via JS on load: header .header-center uses transform, which breaks position:fixed for descendants --}}
    <div class="sh-search-overlay" id="sh-search-filters-panel-{{ $searchId }}" hidden aria-hidden="true">
        <div class="sh-search-window">
            <div class="sh-search-window-header">
                <div class="sh-search-window-title">
                    <i class="fas fa-sliders-h gold-text"></i>
                    <h3>{{ __('components.search_models.advanced_filters') }}</h3>
                </div>
                <button class="sh-search-window-close" id="sh-search-filters-close-{{ $searchId }}">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="sh-search-window-content sh-search-scrollbar">
                
                <div class="filter-section">
                    <h4 class="sh-search-section-label">{{ __('components.search_models.category') }}</h4>
                    <div class="sh-search-category-pills">
                        <button class="sh-search-pill active">{{ __('components.search_models.all') }}</button>
                        <button class="sh-search-pill">{{ __('components.search_models.girls') }}</button>
                        <button class="sh-search-pill">{{ __('components.search_models.guys') }}</button>
                        <button class="sh-search-pill">{{ __('components.search_models.couples') }}</button>
                        <button class="sh-search-pill">{{ __('components.search_models.trans') }}</button>
                    </div>
                </div>

                <div class="sh-search-grid">
                    <!-- Columna 1: Edad y País -->
                    <div class="sh-search-column">
                        <h4 class="sh-search-section-label">{{ __('components.search_models.age') }}</h4>
                        <div class="sh-search-checkbox-list">
                            <label class="sh-search-custom-cb">
                                <input type="checkbox" name="age[]" value="18-25">
                                <span class="sh-search-checkmark"></span>
                                <span class="sh-search-label-text">18 - 25</span>
                            </label>
                            <label class="sh-search-custom-cb">
                                <input type="checkbox" name="age[]" value="26-35">
                                <span class="sh-search-checkmark"></span>
                                <span class="sh-search-label-text">26 - 35</span>
                            </label>
                            <label class="sh-search-custom-cb">
                                <input type="checkbox" name="age[]" value="36+">
                                <span class="sh-search-checkmark"></span>
                                <span class="sh-search-label-text">36+</span>
                            </label>
                        </div>

                        <h4 class="sh-search-section-label" style="margin-top: 1.5rem;">{{ __('components.search_models.country') }}</h4>
                        <div class="sh-search-checkbox-list">
                            <label class="sh-search-custom-cb">
                                <input type="checkbox" name="country[]" value="Colombia">
                                <span class="sh-search-checkmark"></span>
                                <span class="sh-search-label-text">🇨🇴 Colombia</span>
                            </label>
                            <label class="sh-search-custom-cb">
                                <input type="checkbox" name="country[]" value="Argentina">
                                <span class="sh-search-checkmark"></span>
                                <span class="sh-search-label-text">🇦🇷 Argentina</span>
                            </label>
                        </div>
                    </div>

                    <!-- Columna 2: Etnia y Disponibilidad -->
                    <div class="sh-search-column">
                        <h4 class="sh-search-section-label">{{ __('components.search_models.ethnicity') }}</h4>
                        <div class="sh-search-checkbox-list">
                            <label class="sh-search-custom-cb">
                                <input type="checkbox" name="ethnicity[]" value="Latina">
                                <span class="sh-search-checkmark"></span>
                                <span class="sh-search-label-text">Latina</span>
                            </label>
                            <label class="sh-search-custom-cb">
                                <input type="checkbox" name="ethnicity[]" value="Blanca">
                                <span class="sh-search-checkmark"></span>
                                <span class="sh-search-label-text">Blanca</span>
                            </label>
                        </div>

                        <h4 class="sh-search-section-label" style="margin-top: 1.5rem;">{{ __('components.search_models.availability') }}</h4>
                        <div class="sh-search-checkbox-list">
                            <label class="sh-search-custom-cb">
                                <input type="checkbox" name="availability[]" value="live">
                                <span class="sh-search-checkmark"></span>
                                <span class="sh-search-label-text">{{ __('components.search_models.live') }}</span>
                            </label>
                            <label class="sh-search-custom-cb">
                                <input type="checkbox" name="availability[]" value="online">
                                <span class="sh-search-checkmark"></span>
                                <span class="sh-search-label-text">{{ __('components.search_models.online') }}</span>
                            </label>
                        </div>
                    </div>

                    <!-- Columna 3: Apariencia e Idiomas -->
                    <div class="sh-search-column">
                        <h4 class="sh-search-section-label">{{ __('components.search_models.appearance') }}</h4>
                        <div class="sh-search-checkbox-list">
                            <label class="sh-search-custom-cb">
                                <input type="checkbox" name="appearance[]" value="delgada">
                                <span class="sh-search-checkmark"></span>
                                <span class="sh-search-label-text">{{ __('components.search_models.slim') }}</span>
                            </label>
                            <label class="sh-search-custom-cb">
                                <input type="checkbox" name="appearance[]" value="curvas">
                                <span class="sh-search-checkmark"></span>
                                <span class="sh-search-label-text">{{ __('components.search_models.curves') }}</span>
                            </label>
                        </div>

                        <h4 class="sh-search-section-label" style="margin-top: 1.5rem;">{{ __('components.search_models.languages') }}</h4>
                        <div class="sh-search-checkbox-list">
                            <label class="sh-search-custom-cb">
                                <input type="checkbox" name="languages[]" value="Español">
                                <span class="sh-search-checkmark"></span>
                                <span class="sh-search-label-text">Español</span>
                            </label>
                            <label class="sh-search-custom-cb">
                                <input type="checkbox" name="languages[]" value="Inglés">
                                <span class="sh-search-checkmark"></span>
                                <span class="sh-search-label-text">Inglés</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sh-search-window-footer">
                <button class="sh-search-btn-reset" id="sh-search-reset-{{ $searchId }}">{{ __('components.search_models.clear_all') }}</button>
                <button class="sh-search-btn-apply" id="sh-search-apply-filters-{{ $searchId }}">
                    {{ __('components.search_models.apply') }}
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchId = "{{ $searchId }}";
    const toggleBtn = document.getElementById(`sh-search-filters-toggle-${searchId}`);
    const panel = document.getElementById(`sh-search-filters-panel-${searchId}`);
    const closeBtn = document.getElementById(`sh-search-filters-close-${searchId}`);
    const clearBtn = document.getElementById(`sh-search-clear-${searchId}`);
    const resetBtn = document.getElementById(`sh-search-reset-${searchId}`);
    const applyBtn = document.getElementById(`sh-search-apply-filters-${searchId}`);
    const input = document.getElementById(`sh-search-input-${searchId}`);

    if (!panel) return;

    // Keep overlay under document.body from first paint so position:fixed is viewport-relative
    // (.header-center uses transform, which creates a fixed-position containing block)
    if (panel.parentElement !== document.body) {
        document.body.appendChild(panel);
    }
    panel.removeAttribute('hidden');
    panel.style.display = 'none';
    panel.setAttribute('aria-hidden', 'true');

    // Toggle logic
    const openPanel = (e) => {
        if(e) e.preventDefault();
        if (panel.parentElement !== document.body) {
            document.body.appendChild(panel);
        }
        panel.style.display = 'flex';
        panel.setAttribute('aria-hidden', 'false');
        setTimeout(() => panel.classList.add('active'), 10);
        document.body.style.overflow = 'hidden';
    };

    if (toggleBtn) {
        toggleBtn.addEventListener('click', openPanel);
    }

    const closePanel = (e) => {
        if(e) e.preventDefault();
        panel.classList.remove('active');
        setTimeout(() => {
            panel.style.display = 'none';
            panel.setAttribute('aria-hidden', 'true');
        }, 300);
        document.body.style.overflow = '';
    };

    if (closeBtn) closeBtn.addEventListener('click', closePanel);
    
    panel.addEventListener('click', (e) => {
        if (e.target === panel) closePanel();
    });

    // Handle mobile trigger from outside (header)
    window.openSearchFilters = openPanel;

    // Clear and input logic
    if (input && clearBtn) {
        input.addEventListener('input', () => {
            clearBtn.style.display = input.value ? 'inline-flex' : 'none';
        });

        clearBtn.addEventListener('click', () => {
            input.value = '';
            clearBtn.style.display = 'none';
            input.focus();
        });

        // Search on Enter
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
    }

    // Reset filters
    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            panel.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
            panel.querySelectorAll('.sh-search-pill').forEach(btn => btn.classList.remove('active'));
            panel.querySelector('.sh-search-pill:first-child').classList.add('active');
        });
    }

    // Apply filters
    if (applyBtn) {
        applyBtn.addEventListener('click', () => {
            performSearch();
            closePanel();
        });
    }

    // Category pills selection
    panel.querySelectorAll('.sh-search-pill').forEach(pill => {
        pill.addEventListener('click', () => {
            panel.querySelectorAll('.sh-search-pill').forEach(p => p.classList.remove('active'));
            pill.classList.add('active');
        });
    });

    function performSearch() {
        const searchTerm = input.value;
        const filters = {
            search: searchTerm,
            age: [],
            ethnicity: [],
            appearance: [],
            country: [],
            availability: [],
            languages: []
        };

        // Collect checkboxes
        panel.querySelectorAll('input[type="checkbox"]:checked').forEach(cb => {
            const name = cb.name.replace('[]', '');
            if (filters[name]) {
                filters[name].push(cb.value);
            }
        });

        // Collect category pill (if not "Todos")
        const activePill = panel.querySelector('.sh-search-pill.active');
        if (activePill && activePill.textContent !== 'Todos') {
            filters.category = activePill.textContent.toLowerCase();
        }

        const params = new URLSearchParams();
        Object.keys(filters).forEach(key => {
            if (Array.isArray(filters[key])) {
                filters[key].forEach(val => params.append(key + '[]', val));
            } else if (filters[key]) {
                params.append(key, filters[key]);
            }
        });

        window.location.href = '/search/models?' + params.toString();
    }
});
</script>
@endpush
