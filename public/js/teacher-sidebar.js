/**
 * Teacher Sidebar Enhanced Functionality
 */

class TeacherSidebar {
    constructor() {
        this.sidebar = document.getElementById('sidebar');
        this.toggleBtn = document.getElementById('toggleBtn');
        this.overlay = document.getElementById('sidebarOverlay');
        this.content = document.querySelector('.content');

        this.init();
    }

    init() {
        this.bindEvents();
        this.loadSavedState();
        this.setActiveMenuItem();
        this.initTooltips();
        this.initMobileDetection();
        this.initScrollFeatures();
    }

    bindEvents() {
        // Toggle button click
        this.toggleBtn?.addEventListener('click', () => this.toggle());

        // Overlay click (mobile)
        this.overlay?.addEventListener('click', () => this.closeMobile());

        // Window resize
        window.addEventListener('resize', () => this.handleResize());

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => this.handleKeyboard(e));

        // Menu item clicks
        this.bindMenuClicks();
    }

    toggle() {
        const isCollapsed = this.sidebar.classList.contains('collapsed');

        if (isCollapsed) {
            this.expand();
        } else {
            this.collapse();
        }

        this.saveState();
    }

    collapse() {
        this.sidebar.classList.add('collapsed');
        this.updateToggleIcon('fas fa-chevron-right');
        this.hideTooltips();

        // Animate menu items
        this.animateMenuItems('collapse');
    }

    expand() {
        this.sidebar.classList.remove('collapsed');
        this.updateToggleIcon('fas fa-chevron-left');
        this.showTooltips();

        // Animate menu items
        this.animateMenuItems('expand');
    }

    updateToggleIcon(iconClass) {
        const icon = this.toggleBtn?.querySelector('i');
        if (icon) {
            icon.className = iconClass;
        }
    }

    // Mobile functionality
    openMobile() {
        if (this.isMobile()) {
            this.sidebar.classList.add('mobile-open');
            this.overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    closeMobile() {
        this.sidebar.classList.remove('mobile-open');
        this.overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    // State management
    saveState() {
        const isCollapsed = this.sidebar.classList.contains('collapsed');
        localStorage.setItem('teacherSidebarCollapsed', isCollapsed);
    }

    loadSavedState() {
        const isCollapsed = localStorage.getItem('teacherSidebarCollapsed') === 'true';
        if (isCollapsed && !this.isMobile()) {
            this.collapse();
        }
    }

    // Active menu item
    setActiveMenuItem() {
        const currentPath = window.location.pathname;
        const menuLinks = this.sidebar.querySelectorAll('ul li a');

        menuLinks.forEach(link => {
            link.classList.remove('active');

            const href = link.getAttribute('href');
            if (href && (href === currentPath || currentPath.startsWith(href + '/'))) {
                link.classList.add('active');
            }
        });
    }

    // Tooltips for collapsed state
    initTooltips() {
        const menuItems = this.sidebar.querySelectorAll('ul li a');

        menuItems.forEach(item => {
            const tooltip = item.getAttribute('data-tooltip');
            if (tooltip) {
                item.setAttribute('title', tooltip);
            }
        });
    }

    hideTooltips() {
        const menuItems = this.sidebar.querySelectorAll('ul li a');
        menuItems.forEach(item => {
            item.removeAttribute('title');
        });
    }

    showTooltips() {
        const menuItems = this.sidebar.querySelectorAll('ul li a');
        menuItems.forEach(item => {
            const tooltip = item.getAttribute('data-tooltip');
            if (tooltip) {
                item.setAttribute('title', tooltip);
            }
        });
    }

    // Animations
    animateMenuItems(direction) {
        const menuItems = this.sidebar.querySelectorAll('ul li');

        menuItems.forEach((item, index) => {
            setTimeout(() => {
                if (direction === 'collapse') {
                    item.style.transform = 'translateX(-10px)';
                    item.style.opacity = '0.7';
                } else {
                    item.style.transform = 'translateX(0)';
                    item.style.opacity = '1';
                }

                setTimeout(() => {
                    item.style.transform = '';
                    item.style.opacity = '';
                }, 200);
            }, index * 50);
        });
    }

    // Menu interactions
    bindMenuClicks() {
        const menuItems = this.sidebar.querySelectorAll('ul li a');

        menuItems.forEach(item => {
            item.addEventListener('click', (e) => {
                // Close mobile sidebar when clicking menu item
                if (this.isMobile()) {
                    this.closeMobile();
                }

                // Add ripple effect
                this.addRippleEffect(e.currentTarget, e);
            });
        });
    }

    // Ripple effect
    addRippleEffect(element, event) {
        const ripple = document.createElement('span');
        const rect = element.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;

        ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s ease-out;
            pointer-events: none;
        `;

        element.style.position = 'relative';
        element.style.overflow = 'hidden';
        element.appendChild(ripple);

        setTimeout(() => {
            ripple.remove();
        }, 600);
    }

    // Responsive handling
    handleResize() {
        if (window.innerWidth > 768) {
            this.closeMobile();
        }
    }

    isMobile() {
        return window.innerWidth <= 768;
    }

    initMobileDetection() {
        if (this.isMobile()) {
            this.sidebar.classList.remove('collapsed');
        }
    }

    // Keyboard shortcuts
    handleKeyboard(e) {
        // Ctrl + B to toggle sidebar
        if (e.ctrlKey && e.key === 'b') {
            e.preventDefault();
            this.toggle();
        }

        // Escape to close mobile sidebar
        if (e.key === 'Escape' && this.isMobile()) {
            this.closeMobile();
        }
    }

    // Public methods for external use
    isCollapsed() {
        return this.sidebar.classList.contains('collapsed');
    }

    setActiveByPath(path) {
        const menuLinks = this.sidebar.querySelectorAll('ul li a');
        menuLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === path) {
                link.classList.add('active');
            }
        });
    }
}

// CSS for ripple animation
const rippleCSS = `
@keyframes ripple {
    to {
        transform: scale(2);
        opacity: 0;
    }
}
`;

// Add CSS to document
const style = document.createElement('style');
style.textContent = rippleCSS;
document.head.appendChild(style);

// Initialize sidebar when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.teacherSidebar = new TeacherSidebar();
});

// Scroll features
initScrollFeatures() {
    const sidebarNav = this.sidebar.querySelector('.sidebar-nav');
    if (!sidebarNav) return;

    // Create scroll to top button
    this.createScrollToTopButton();

    // Handle scroll events
    sidebarNav.addEventListener('scroll', () => this.handleScroll());

    // Initial scroll state check
    this.updateScrollIndicators();

    // Smooth scrolling for menu items
    this.initSmoothScrolling();
}

createScrollToTopButton() {
    const scrollBtn = document.createElement('button');
    scrollBtn.className = 'scroll-to-top';
    scrollBtn.innerHTML = '<i class="fas fa-chevron-up"></i>';
    scrollBtn.title = 'Cuộn lên đầu';

    scrollBtn.addEventListener('click', () => {
        const sidebarNav = this.sidebar.querySelector('.sidebar-nav');
        sidebarNav.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    this.sidebar.appendChild(scrollBtn);
    this.scrollToTopBtn = scrollBtn;
}

handleScroll() {
    const sidebarNav = this.sidebar.querySelector('.sidebar-nav');
    const scrollTop = sidebarNav.scrollTop;

    // Update scroll indicators
    this.updateScrollIndicators();

    // Show/hide scroll to top button
    if (this.scrollToTopBtn) {
        if (scrollTop > 100) {
            this.scrollToTopBtn.classList.add('visible');
        } else {
            this.scrollToTopBtn.classList.remove('visible');
        }
    }

    // Add scrolling class for fade effect
    sidebarNav.classList.add('scrolling');
    clearTimeout(this.scrollTimeout);
    this.scrollTimeout = setTimeout(() => {
        sidebarNav.classList.remove('scrolling');
    }, 150);
}

updateScrollIndicators() {
    const sidebarNav = this.sidebar.querySelector('.sidebar-nav');
    const scrollTop = sidebarNav.scrollTop;
    const scrollHeight = sidebarNav.scrollHeight;
    const clientHeight = sidebarNav.clientHeight;

    // Can scroll up?
    if (scrollTop > 10) {
        sidebarNav.classList.add('can-scroll-up');
    } else {
        sidebarNav.classList.remove('can-scroll-up');
    }

    // Can scroll down?
    if (scrollTop < scrollHeight - clientHeight - 10) {
        sidebarNav.classList.add('can-scroll-down');
    } else {
        sidebarNav.classList.remove('can-scroll-down');
    }
}

initSmoothScrolling() {
    const sidebarNav = this.sidebar.querySelector('.sidebar-nav');

    // Mouse wheel smooth scrolling
    sidebarNav.addEventListener('wheel', (e) => {
        e.preventDefault();

        const delta = e.deltaY;
        const scrollTop = sidebarNav.scrollTop;
        const targetScroll = scrollTop + delta;

        sidebarNav.scrollTo({
            top: targetScroll,
            behavior: 'smooth'
        });
    });
}

// Scroll to active menu item
scrollToActiveItem() {
    const activeItem = this.sidebar.querySelector('ul li a.active');
    if (activeItem) {
        activeItem.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    }
}
}

// Export for module use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = TeacherSidebar;
}