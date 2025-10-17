/**
 * Navigation JavaScript functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    // Highlight current navigation item based on URL
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentPath || 
            (href !== '/' && currentPath.startsWith(href))) {
            link.classList.add('active');
            
            // If link is in dropdown, highlight parent dropdown
            const dropdownParent = link.closest('.dropdown');
            if (dropdownParent) {
                dropdownParent.querySelector('.nav-link').classList.add('active');
            }
        }
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(e) {
        const navbar = document.getElementById('mainNavbar');
        const navbarToggler = document.querySelector('.navbar-toggler');
        
        if (navbar.classList.contains('show') && 
            !navbar.contains(e.target) && 
            !navbarToggler.contains(e.target)) {
            navbar.classList.remove('show');
        }
    });

    // Add smooth transition for dropdown menus
    const dropdowns = document.querySelectorAll('.dropdown');
    dropdowns.forEach(dropdown => {
        const menu = dropdown.querySelector('.dropdown-menu');
        
        dropdown.addEventListener('show.bs.dropdown', function() {
            menu.style.transition = 'transform 0.2s ease-out';
            menu.style.transform = 'translateY(0)';
        });
        
        dropdown.addEventListener('hide.bs.dropdown', function() {
            menu.style.transition = 'transform 0.2s ease-in';
            menu.style.transform = 'translateY(-10px)';
        });
    });

    // Handle search form submission
    const searchForm = document.querySelector('form[action*="/search"]');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const searchInput = this.querySelector('input[name="q"]');
            if (!searchInput.value.trim()) {
                e.preventDefault();
                searchInput.focus();
            }
        });
    }
});