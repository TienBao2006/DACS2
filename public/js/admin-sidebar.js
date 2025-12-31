// Admin Sidebar JavaScript
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleBtn');
    const content = document.querySelector('.content');
    const menuItems = document.querySelectorAll('.sidebar a');

    // Initialize sidebar
    initSidebar();

    // Toggle sidebar
    if (toggleBtn) {
        toggleBtn.addEventListener('click', toggleSidebar);
    }

    // Set active menu item
    setActiveMenuItem();

    // Create scroll to top button
    createScrollToTopButton();

    // Handle window resize
    window.addEventListener('resize', handleResize);

    // Add tooltips for collapsed state
    addTooltips();

    // Smooth scrolling for sidebar
    addSmoothScrolling();
});

function initSidebar() {
    const sidebar = document.getElementById('sidebar');
    if (!sidebar) return;

    // Check if sidebar should be collapsed on mobile
    if (window.innerWidth <= 768) {
        sidebar.classList.add('collapsed');
    }

    // Load saved state
    const savedState = localStorage.getItem('adminSidebarCollapsed');
    if (savedState === 'true') {
        sidebar.classList.add('collapsed');
    }

    // Add menu container for scrolling
    const ul = sidebar.querySelector('ul');
    if (ul && !ul.parentElement.classList.contains('sidebar-menu')) {
        const menuContainer = document.createElement('div');
        menuContainer.className = 'sidebar-menu';
        ul.parentNode.insertBefore(menuContainer, ul);
        menuContainer.appendChild(ul);
    }
}

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    if (!sidebar) return;

    sidebar.classList.toggle('collapsed');

    // Save state
    const isCollapsed = sidebar.classList.contains('collapsed');
    localStorage.setItem('adminSidebarCollapsed', isCollapsed);

    // Trigger custom event
    const event = new CustomEvent('sidebarToggle', {
        detail: { collapsed: isCollapsed }
    });
    document.dispatchEvent(event);
}

function setActiveMenuItem() {
    const currentPath = window.location.pathname;
    const menuItems = document.querySelectorAll('.sidebar a');

    menuItems.forEach(item => {
        item.classList.remove('active');

        const href = item.getAttribute('href');
        if (href && (currentPath === href || currentPath.startsWith(href + '/'))) {
            item.classList.add('active');
        }
    });
}

function addTooltips() {
    const menuItems = document.querySelectorAll('.sidebar a');

    menuItems.forEach(item => {
        const span = item.querySelector('span');
        if (span) {
            item.setAttribute('data-tooltip', span.textContent.trim());
        }
    });
}

function createScrollToTopButton() {
    const scrollBtn = document.createElement('button');
    scrollBtn.className = 'scroll-to-top';
    scrollBtn.innerHTML = '<i class="fas fa-chevron-up"></i>';
    scrollBtn.title = 'Cuộn lên đầu trang';

    document.body.appendChild(scrollBtn);

    // Show/hide button based on scroll position
    const sidebarMenu = document.querySelector('.sidebar-menu');
    if (sidebarMenu) {
        sidebarMenu.addEventListener('scroll', function () {
            if (this.scrollTop > 200) {
                scrollBtn.classList.add('show');
            } else {
                scrollBtn.classList.remove('show');
            }
        });
    }

    // Scroll to top when clicked
    scrollBtn.addEventListener('click', function () {
        if (sidebarMenu) {
            sidebarMenu.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    });
}

function addSmoothScrolling() {
    const sidebarMenu = document.querySelector('.sidebar-menu');
    if (!sidebarMenu) return;

    let isScrolling = false;

    sidebarMenu.addEventListener('wheel', function (e) {
        if (isScrolling) return;

        isScrolling = true;

        // Smooth scroll
        const delta = e.deltaY;
        const scrollTop = this.scrollTop;
        const targetScroll = scrollTop + delta;

        this.scrollTo({
            top: targetScroll,
            behavior: 'smooth'
        });

        setTimeout(() => {
            isScrolling = false;
        }, 100);
    }, { passive: true });
}

function handleResize() {
    const sidebar = document.getElementById('sidebar');
    if (!sidebar) return;

    if (window.innerWidth <= 768) {
        // Mobile view
        sidebar.classList.add('mobile');
        createMobileToggle();
    } else {
        // Desktop view
        sidebar.classList.remove('mobile');
        removeMobileToggle();
    }
}

function createMobileToggle() {
    if (document.querySelector('.mobile-menu-toggle')) return;

    const mobileToggle = document.createElement('button');
    mobileToggle.className = 'mobile-menu-toggle';
    mobileToggle.innerHTML = '<i class="fas fa-bars"></i>';
    mobileToggle.title = 'Mở menu';

    document.body.appendChild(mobileToggle);

    mobileToggle.addEventListener('click', function () {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('active');

        // Update icon
        const icon = this.querySelector('i');
        if (sidebar.classList.contains('active')) {
            icon.className = 'fas fa-times';
            this.title = 'Đóng menu';
        } else {
            icon.className = 'fas fa-bars';
            this.title = 'Mở menu';
        }
    });

    // Close sidebar when clicking outside
    document.addEventListener('click', function (e) {
        const sidebar = document.getElementById('sidebar');
        const mobileToggle = document.querySelector('.mobile-menu-toggle');

        if (sidebar.classList.contains('active') &&
            !sidebar.contains(e.target) &&
            !mobileToggle.contains(e.target)) {
            sidebar.classList.remove('active');
            mobileToggle.querySelector('i').className = 'fas fa-bars';
            mobileToggle.title = 'Mở menu';
        }
    });
}

function removeMobileToggle() {
    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    if (mobileToggle) {
        mobileToggle.remove();
    }
}

// Utility functions
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;

    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#007bff'};
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        z-index: 10000;
        display: flex;
        align-items: center;
        gap: 10px;
        animation: slideInRight 0.3s ease;
        max-width: 400px;
    `;

    document.body.appendChild(notification);

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }
    }, 5000);
}

// Keyboard shortcuts
document.addEventListener('keydown', function (e) {
    // Ctrl + B to toggle sidebar
    if (e.ctrlKey && e.key === 'b') {
        e.preventDefault();
        toggleSidebar();
    }

    // Escape to close mobile menu
    if (e.key === 'Escape') {
        const sidebar = document.getElementById('sidebar');
        if (sidebar && sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
            const mobileToggle = document.querySelector('.mobile-menu-toggle');
            if (mobileToggle) {
                mobileToggle.querySelector('i').className = 'fas fa-bars';
                mobileToggle.title = 'Mở menu';
            }
        }
    }
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .notification {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .notification button {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        padding: 5px;
        border-radius: 3px;
        margin-left: auto;
    }
    
    .notification button:hover {
        background: rgba(255,255,255,0.2);
    }
`;
document.head.appendChild(style);

// Export functions for external use
window.AdminSidebar = {
    toggle: toggleSidebar,
    setActive: setActiveMenuItem,
    showNotification: showNotification
};