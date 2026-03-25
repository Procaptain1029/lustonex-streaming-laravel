
<script>
    // Sidebar toggle para desktop y mobile
    function toggleSidebar() {
        console.log('toggleSidebar called');
        const sidebar = document.getElementById('sidebar');
        const body = document.body;
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const isDesktop = window.innerWidth > 1024;
        
        console.log('isDesktop:', isDesktop, 'sidebar found:', !!sidebar, 'hamburgerBtn found:', !!hamburgerBtn);

        if (isDesktop) {
            // Desktop: toggle collapsed class
            sidebar.classList.toggle('collapsed');
            body.classList.toggle('sidebar-collapsed');
            
            // Guardar estado en localStorage
            if (sidebar.classList.contains('collapsed')) {
                localStorage.setItem('sidebarCollapsed', 'true');
                if (hamburgerBtn) hamburgerBtn.classList.remove('active');
            } else {
                localStorage.setItem('sidebarCollapsed', 'false');
                if (hamburgerBtn) hamburgerBtn.classList.add('active');
            }
        } else {
            // Mobile: toggle open class
            console.log('Mobile branch - toggling open class');
            sidebar.classList.toggle('open');
            
            // Botón hamburguesa: active cuando menú está ABIERTO
            if (hamburgerBtn) {
                if (sidebar.classList.contains('open')) {
                    hamburgerBtn.classList.add('active');
                } else {
                    hamburgerBtn.classList.remove('active');
                }
            }
        }
    }

    // Toggle filter groups
    function toggleFilter(filterId) {
        // Usamos el evento global si existe, o el target del evento actual
        const target = event ? event.target : null;
        if (target) {
            const filterGroup = target.closest('.filter-group');
            if (filterGroup) {
                filterGroup.classList.toggle('active');
            }
        }
    }

    // Close sidebar on mobile when a link or filter is clicked
    function handleSidebarLinkClick(event) {
        const isMobile = window.innerWidth <= 1024;
        if (!isMobile) return;

        const target = event.target.closest('.nav-item, .filter-item, .sidebar-footer-links a');
        if (target) {
            const sidebar = document.getElementById('sidebar');
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            if (sidebar && sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
                if (hamburgerBtn) hamburgerBtn.classList.remove('active');
            }
        }
    }

    // Close sidebar when clicking outside (solo en mobile)
    function handleOutsideClick(event) {
        const sidebar = document.getElementById('sidebar');
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        
        if (window.innerWidth <= 1024 && sidebar && hamburgerBtn) {
            const target = event.target;
            
            // Si el click no es en el sidebar ni en el botón hamburguesa
            if (!sidebar.contains(target) && 
                !hamburgerBtn.contains(target) &&
                sidebar.classList.contains('open')) {
                
                sidebar.classList.remove('open');
                hamburgerBtn.classList.remove('active');
            }
        }
    }

    // Handle window resize
    window.addEventListener('resize', function() {
        const sidebar = document.getElementById('sidebar');
        const body = document.body;
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        
        if (sidebar && hamburgerBtn) {
            if (window.innerWidth > 1024) {
                // Desktop: remover clases mobile
                sidebar.classList.remove('open');
                
                // Restaurar estado desde localStorage o default
                const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                if (isCollapsed) {
                    sidebar.classList.add('collapsed');
                    body.classList.add('sidebar-collapsed');
                    hamburgerBtn.classList.remove('active');
                } else {
                    sidebar.classList.remove('collapsed');
                    body.classList.remove('sidebar-collapsed');
                    hamburgerBtn.classList.add('active');
                }
            } else {
                // Mobile: remover clases desktop y cerrar sidebar
                sidebar.classList.remove('collapsed');
                body.classList.remove('sidebar-collapsed');
                sidebar.classList.remove('open');
                hamburgerBtn.classList.remove('active');
            }
        }
    });

    // Función para inicializar el estado
    function initializeSidebarState() {
        const sidebar = document.getElementById('sidebar');
        const body = document.body;
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        
        if (sidebar) {
            const isChatPage = window.location.pathname.includes('/fan/chat');

            if (window.innerWidth > 1024) {
                // Desktop: Por defecto abierto, pero permitimos override si NO es página de chat
                let isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                
                // Si es página de chat, FORZAMOS que no esté colapsado
                if (isChatPage) {
                    isCollapsed = false;
                }

                if (isCollapsed) {
                    sidebar.classList.add('collapsed');
                    body.classList.add('sidebar-collapsed');
                    if (hamburgerBtn) hamburgerBtn.classList.remove('active');
                } else {
                    sidebar.classList.remove('collapsed');
                    body.classList.remove('sidebar-collapsed');
                    if (hamburgerBtn) hamburgerBtn.classList.add('active');
                }
            } else {
                // Mobile: Por defecto cerrado (colapsado)
                sidebar.classList.remove('open');
                if (hamburgerBtn) hamburgerBtn.classList.remove('active');
            }
        }

        updateSidebarActiveStates();
    }

    // Function to update active states dynamically
    function updateSidebarActiveStates() {
        const currentUrl = window.location.href;
        const currentPath = window.location.pathname;

        // 1. Update Category Links (Main nav items)
        document.querySelectorAll('.nav-item').forEach(item => {
            const itemUrl = new URL(item.href);
            // Match exact path for categories
            if (itemUrl.pathname === currentPath && currentPath !== '/') {
                item.classList.add('active');
            } else if (currentPath === '/' && itemUrl.pathname === '/') {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });

        // 2. Update Filter Links
        let hasActiveFilter = false;
        document.querySelectorAll('.filter-item').forEach(item => {
            const itemUrl = new URL(item.href);
            let isActive = false;

            // Simple match for basic filters
            if (item.href === currentUrl) {
                isActive = true;
            } 
            // Query match for search-based filters
            else if (itemUrl.pathname === currentPath && itemUrl.search !== '') {
                const itemParams = new URLSearchParams(itemUrl.search);
                const currentParams = new URLSearchParams(window.location.search);
                
                // Check if all params in the link are present in the current URL
                let allMatch = true;
                for (let [key, value] of itemParams.entries()) {
                    if (currentParams.get(key) !== value && !currentParams.getAll(key).includes(value)) {
                        allMatch = false;
                        break;
                    }
                }
                if (allMatch) isActive = true;
            }

            if (isActive) {
                item.classList.add('active');
                hasActiveFilter = true;
                
                // Auto-open parent group
                const filterGroup = item.closest('.filter-group');
                if (filterGroup) {
                    filterGroup.classList.add('active');
                }
            } else {
                item.classList.remove('active');
            }
        });
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('click', handleOutsideClick);
        document.addEventListener('click', handleSidebarLinkClick);
        initializeSidebarState();
        
        // Inicializar búsqueda si existe
        if (typeof initializeSearch === 'function') {
            initializeSearch();
        }
    });
</script>
