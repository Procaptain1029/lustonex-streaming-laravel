// Sidebar Premium JavaScript
// Funcionalidades del sidebar fijo y responsivo

// Sidebar toggle para desktop y mobile
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const toggleIcon = document.getElementById('toggleIcon');
    const toggleText = document.getElementById('toggleText');
    
    // En desktop (>1024px) oculta/muestra el sidebar
    if (window.innerWidth > 1024) {
        sidebar.classList.toggle('hidden');
        if (mainContent) {
            mainContent.classList.toggle('sidebar-hidden');
        }
        
        if (sidebar.classList.contains('hidden')) {
            if (toggleIcon) toggleIcon.className = 'fas fa-eye-slash';
            if (toggleText) toggleText.textContent = 'Mostrar Menú';
        } else {
            if (toggleIcon) toggleIcon.className = 'fas fa-eye';
            if (toggleText) toggleText.textContent = 'Ocultar Menú';
        }
    } else {
        // En mobile/tablet funciona como antes
        sidebar.classList.toggle('open');
    }
}

// Close sidebar when clicking outside (solo en mobile)
document.addEventListener('click', function(event) {
    if (window.innerWidth <= 1024) {
        const sidebar = document.getElementById('sidebar');
        const target = event.target;
        
        if (!sidebar.contains(target) && !target.closest('[onclick="toggleSidebar()"]')) {
            sidebar.classList.remove('open');
        }
    }
});

// Ajustar comportamiento en resize
window.addEventListener('resize', function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const toggleIcon = document.getElementById('toggleIcon');
    const toggleText = document.getElementById('toggleText');
    
    if (window.innerWidth > 1024) {
        // Desktop: remover clases de mobile
        sidebar.classList.remove('open');
        
        // Restaurar estado desktop si no está oculto
        if (!sidebar.classList.contains('hidden')) {
            if (mainContent) mainContent.classList.remove('sidebar-hidden');
            if (toggleIcon && toggleText) {
                toggleIcon.className = 'fas fa-eye';
                toggleText.textContent = 'Ocultar Menú';
            }
        }
    } else {
        // Mobile: limpiar clases desktop
        sidebar.classList.remove('hidden');
        if (mainContent) mainContent.classList.remove('sidebar-hidden');
        
        // Restaurar texto del botón
        if (toggleIcon && toggleText) {
            toggleIcon.className = 'fas fa-compass';
            toggleText.textContent = 'Explorar Ahora';
        }
    }
});

// Smooth scroll para enlaces internos del sidebar
document.querySelectorAll('.sidebar-item[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
            
            // Cerrar sidebar en mobile después del scroll
            if (window.innerWidth <= 1024) {
                document.getElementById('sidebar').classList.remove('open');
            }
        }
    });
});

// Highlight active sidebar item based on scroll position
function updateActiveSidebarItem() {
    const sections = document.querySelectorAll('section[id]');
    const sidebarItems = document.querySelectorAll('.sidebar-item[href^="#"]');
    
    let current = '';
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (window.scrollY >= (sectionTop - 200)) {
            current = section.getAttribute('id');
        }
    });
    
    sidebarItems.forEach(item => {
        item.classList.remove('active');
        if (item.getAttribute('href') === '#' + current) {
            item.classList.add('active');
        }
    });
}

// Update active item on scroll
window.addEventListener('scroll', updateActiveSidebarItem);

// Initialize sidebar functionality
function initSidebar() {
    updateActiveSidebarItem();
}

// Auto-initialize when DOM is ready
document.addEventListener('DOMContentLoaded', initSidebar);
