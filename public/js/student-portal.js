// Student Portal JavaScript - Modern Interactions

document.addEventListener('DOMContentLoaded', function () {
    // Initialize all components
    initMobileMenu();
    initMenuInteractions();
    initAlerts();
    initLoadingStates();
    initTooltips();
    initScrollEffects();

    console.log('Student Portal initialized successfully');
});

// Mobile Menu Toggle
function initMobileMenu() {
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const sidebar = document.getElementById('sidebar');
    const content = document.querySelector('.content');

    if (mobileMenuToggle && sidebar) {
        mobileMenuToggle.addEventListener('click', function () {
            sidebar.classList.toggle('active');

            // Add overlay for mobile
            if (sidebar.classList.contains('active')) {
                createOverlay();
            } else {
                removeOverlay();
            }
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function (e) {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                    sidebar.classList.remove('active');
                    removeOverlay();
                }
            }
        });

        // Handle window resize
        window.addEventListener('resize', function () {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('active');
                removeOverlay();
            }
        });
    }
}

// Create overlay for mobile menu
function createOverlay() {
    if (!document.querySelector('.sidebar-overlay')) {
        const overlay = document.createElement('div');
        overlay.className = 'sidebar-overlay';
        overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 998;
            backdrop-filter: blur(4px);
            animation: fadeIn 0.3s ease-out;
        `;

        overlay.addEventListener('click', function () {
            document.getElementById('sidebar').classList.remove('active');
            removeOverlay();
        });

        document.body.appendChild(overlay);
    }
}

// Remove overlay
function removeOverlay() {
    const overlay = document.querySelector('.sidebar-overlay');
    if (overlay) {
        overlay.style.animation = 'fadeOut 0.3s ease-out';
        setTimeout(() => {
            overlay.remove();
        }, 300);
    }
}

// Menu Interactions
function initMenuInteractions() {
    const menuLinks = document.querySelectorAll('.menu-link');

    menuLinks.forEach(link => {
        // Add ripple effect on click
        link.addEventListener('click', function (e) {
            if (!this.classList.contains('logout')) {
                // Remove active class from all links
                menuLinks.forEach(l => l.classList.remove('active'));
                // Add active class to clicked link
                this.classList.add('active');

                // Create ripple effect
                createRipple(e, this);
            }
        });

        // Add hover sound effect (optional)
        link.addEventListener('mouseenter', function () {
            this.style.transform = 'translateX(5px)';
        });

        link.addEventListener('mouseleave', function () {
            if (!this.classList.contains('active')) {
                this.style.transform = 'translateX(0)';
            }
        });
    });
}

// Create ripple effect
function createRipple(event, element) {
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
        z-index: 1;
    `;

    element.style.position = 'relative';
    element.style.overflow = 'hidden';
    element.appendChild(ripple);

    setTimeout(() => {
        ripple.remove();
    }, 600);
}

// Alert Management
function initAlerts() {
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            hideAlert(alert);
        }, 5000);

        // Close button functionality
        const closeBtn = alert.querySelector('.close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                hideAlert(alert);
            });
        }
    });
}

// Hide alert with animation
function hideAlert(alert) {
    alert.style.animation = 'slideOutUp 0.5s ease-in';
    setTimeout(() => {
        alert.remove();
    }, 500);
}

// Loading States
function initLoadingStates() {
    // Form submission loading
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function () {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
                submitBtn.disabled = true;

                // Re-enable after 10 seconds as fallback
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 10000);
            }
        });
    });

    // Link loading states
    const loadingLinks = document.querySelectorAll('[data-loading]');
    loadingLinks.forEach(link => {
        link.addEventListener('click', function () {
            this.classList.add('loading');
            const icon = this.querySelector('i');
            if (icon) {
                icon.className = 'fas fa-spinner fa-spin';
            }
        });
    });
}

// Initialize tooltips
function initTooltips() {
    // Simple tooltip implementation
    const tooltipElements = document.querySelectorAll('[data-tooltip]');

    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function () {
            showTooltip(this, this.getAttribute('data-tooltip'));
        });

        element.addEventListener('mouseleave', function () {
            hideTooltip();
        });
    });
}

// Show tooltip
function showTooltip(element, text) {
    const tooltip = document.createElement('div');
    tooltip.className = 'custom-tooltip';
    tooltip.textContent = text;
    tooltip.style.cssText = `
        position: absolute;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
        font-size: 0.8rem;
        z-index: 9999;
        pointer-events: none;
        animation: fadeIn 0.2s ease-out;
        backdrop-filter: blur(10px);
    `;

    document.body.appendChild(tooltip);

    const rect = element.getBoundingClientRect();
    tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
    tooltip.style.top = rect.top - tooltip.offsetHeight - 8 + 'px';
}

// Hide tooltip
function hideTooltip() {
    const tooltip = document.querySelector('.custom-tooltip');
    if (tooltip) {
        tooltip.remove();
    }
}

// Scroll Effects
function initScrollEffects() {
    let ticking = false;

    function updateScrollEffects() {
        const scrollTop = window.pageYOffset;
        const navbar = document.querySelector('.top-navbar');

        // Add shadow to navbar on scroll
        if (navbar) {
            if (scrollTop > 10) {
                navbar.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.1)';
            } else {
                navbar.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)';
            }
        }

        ticking = false;
    }

    window.addEventListener('scroll', function () {
        if (!ticking) {
            requestAnimationFrame(updateScrollEffects);
            ticking = true;
        }
    });
}

// Utility Functions
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type}`;
    notification.innerHTML = `
        <i class="fas fa-${getIconForType(type)}"></i>
        ${message}
        <button type="button" class="close">
            <span>&times;</span>
        </button>
    `;

    const content = document.querySelector('.content');
    if (content) {
        content.insertBefore(notification, content.firstChild);

        // Auto-hide after 5 seconds
        setTimeout(() => {
            hideAlert(notification);
        }, 5000);

        // Close button
        notification.querySelector('.close').addEventListener('click', () => {
            hideAlert(notification);
        });
    }
}

function getIconForType(type) {
    const icons = {
        'success': 'check-circle',
        'danger': 'exclamation-circle',
        'warning': 'exclamation-triangle',
        'info': 'info-circle'
    };
    return icons[type] || 'info-circle';
}

// Confirm dialogs
function confirmAction(message, callback) {
    if (confirm(message)) {
        callback();
    }
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    @keyframes slideOutUp {
        from {
            transform: translateY(0);
            opacity: 1;
        }
        to {
            transform: translateY(-20px);
            opacity: 0;
        }
    }
    
    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Export functions for global use
window.StudentPortal = {
    showNotification,
    confirmAction,
    hideAlert
};