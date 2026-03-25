
<script>
    function initializeSearch() {
        // Verificar si ya está inicializado
        if (window.searchListenersAdded) {
            console.log('Search listeners already added');
            return;
        }
        
        console.log('Initializing search...');
        
        // Buscar todas las instancias de search containers
        const searchContainers = document.querySelectorAll('.search-models-container');
        console.log('Found search containers:', searchContainers.length);
        
        searchContainers.forEach((container, index) => {
            const searchId = container.getAttribute('data-search-id');
            console.log(`Initializing search container ${index + 1} with ID: ${searchId}`);
            
            const searchInput = document.getElementById(`search-input-${searchId}`);
            const filtersToggle = document.getElementById(`filters-toggle-${searchId}`);
            const filtersPanel = document.getElementById(`filters-panel-${searchId}`);
            const filtersOverlay = document.getElementById(`filters-overlay-${searchId}`);
            const filtersClose = document.getElementById(`filters-close-${searchId}`);
            const applyFilters = document.getElementById(`apply-filters-${searchId}`);
            const searchClear = document.getElementById(`search-clear-${searchId}`);
            const filtersSearchInput = container.querySelector('.filters-search-input');
            
            console.log(`Elements found for ${searchId}:`, {
                searchInput: !!searchInput,
                filtersToggle: !!filtersToggle,
                filtersPanel: !!filtersPanel,
                filtersOverlay: !!filtersOverlay,
                filtersClose: !!filtersClose,
                applyFilters: !!applyFilters,
                searchClear: !!searchClear,
                filtersSearchInput: !!filtersSearchInput
            });
            
            initializeSearchInstance(searchInput, filtersToggle, filtersPanel, filtersOverlay, filtersClose, applyFilters, searchClear, filtersSearchInput, searchId);
        });
        
        // Marcar que los listeners fueron agregados
        window.searchListenersAdded = true;
        console.log('Search initialization completed');
    }

    function initializeSearchInstance(searchInput, filtersToggle, filtersPanel, filtersOverlay, filtersClose, applyFilters, searchClear, filtersSearchInput, searchId) {
        // Toggle filtros
        if (filtersToggle && filtersPanel && filtersOverlay) {
            filtersToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Filters toggle clicked'); // Debug
                
                // En móvil/tablet, mover el panel al body para evitar restricciones del header
                if (window.innerWidth <= 768) {
                    if (!filtersPanel.classList.contains('active')) {
                        // Mover al body cuando se abre
                        document.body.appendChild(filtersPanel);
                        document.body.appendChild(filtersOverlay);
                    }
                }
                
                filtersPanel.classList.toggle('active');
                filtersOverlay.classList.toggle('active');
            });
            
            // También agregar event listener para touch
            filtersToggle.addEventListener('touchend', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Filters toggle touched'); // Debug
                
                // En móvil/tablet, mover el panel al body para evitar restricciones del header
                if (window.innerWidth <= 768) {
                    if (!filtersPanel.classList.contains('active')) {
                        // Mover al body cuando se abre
                        document.body.appendChild(filtersPanel);
                        document.body.appendChild(filtersOverlay);
                    }
                }
                
                filtersPanel.classList.toggle('active');
                filtersOverlay.classList.toggle('active');
            });
        } else {
            console.log(`Missing elements for ${searchId}:`, {
                filtersToggle: !!filtersToggle,
                filtersPanel: !!filtersPanel,
                filtersOverlay: !!filtersOverlay
            });
        }

        // Función para cerrar filtros de esta instancia
        function closeFilters() {
            console.log(`Closing filters for ${searchId}`);
            if (filtersPanel) filtersPanel.classList.remove('active');
            if (filtersOverlay) filtersOverlay.classList.remove('active');
        }

        // Cerrar filtros
        if (filtersClose) {
            filtersClose.addEventListener('click', closeFilters);
        }
        
        if (filtersOverlay) {
            filtersOverlay.addEventListener('click', closeFilters);
        }

        // Mostrar/ocultar botón limpiar
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                if (this.value.length > 0) {
                    searchClear.style.display = 'flex';
                } else {
                    searchClear.style.display = 'none';
                }
            });
        }

        // Limpiar búsqueda
        if (searchClear) {
            searchClear.addEventListener('click', function() {
                searchInput.value = '';
                this.style.display = 'none';
            });
        }

        // Aplicar filtros
        if (applyFilters) {
            applyFilters.addEventListener('click', function() {
                performSearch();
                closeFilters();
            });
        }

        // Búsqueda al presionar Enter
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    performSearch();
                }
            });
        }

        // Funcionalidad del input de búsqueda de filtros
        if (filtersSearchInput) {
            filtersSearchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const filterGroups = document.querySelectorAll('.filter-group');
                
                filterGroups.forEach(group => {
                    const title = group.querySelector('.filter-group-title').textContent.toLowerCase();
                    const options = group.querySelectorAll('.filter-option');
                    let hasVisibleOptions = false;
                    
                    // Mostrar/ocultar grupo si coincide con el título
                    const titleMatches = title.includes(searchTerm);
                    
                    options.forEach(option => {
                        const label = option.querySelector('.filter-label').textContent.toLowerCase();
                        const matches = label.includes(searchTerm) || titleMatches;
                        
                        if (matches) {
                            option.style.display = 'flex';
                            hasVisibleOptions = true;
                        } else {
                            option.style.display = 'none';
                        }
                    });
                    
                    // Mostrar/ocultar todo el grupo
                    if (hasVisibleOptions || titleMatches) {
                        group.style.display = 'block';
                    } else {
                        group.style.display = 'none';
                    }
                });
            });
        }
    }

    function performSearch() {
        // Buscar el input activo (el que tiene foco o valor)
        const searchInputs = document.querySelectorAll('.search-input');
        let activeInput = null;
        let searchTerm = '';
        
        searchInputs.forEach(input => {
            if (input.value || input === document.activeElement) {
                activeInput = input;
                searchTerm = input.value;
            }
        });
        
        if (!activeInput && searchInputs.length > 0) {
            activeInput = searchInputs[0];
            searchTerm = activeInput.value;
        }
        
        // Recopilar filtros seleccionados
        const filters = {
            search: searchTerm,
            age: [],
            ethnicity: [],
            body_type: [],
            hair_color: [],
            country: []
        };

        // Recopilar checkboxes seleccionados
        document.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
            const name = checkbox.name.replace('[]', '');
            if (filters[name]) {
                filters[name].push(checkbox.value);
            }
        });

        // Construir URL con parámetros
        const params = new URLSearchParams();
        Object.keys(filters).forEach(key => {
            if (Array.isArray(filters[key])) {
                filters[key].forEach(value => {
                    params.append(key + '[]', value);
                });
            } else if (filters[key]) {
                params.append(key, filters[key]);
            }
        });

        // Redirigir a la página de resultados
        window.location.href = '/search/models?' + params.toString();
    }

    // Inicializar solo una vez
    if (!window.searchInitialized) {
        window.searchInitialized = true;
        
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(initializeSearch, 100);
            });
        } else {
            setTimeout(initializeSearch, 100);
        }
    }
</script>
