// Homepage JavaScript
document.addEventListener('DOMContentLoaded', function () {
    // Smooth scrolling for anchor links
    const links = document.querySelectorAll('a[href^="#"]');
    links.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Navbar scroll effect
    const header = document.querySelector('.header');
    let lastScrollTop = 0;

    window.addEventListener('scroll', function () {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }

        // Hide/show header on scroll
        if (scrollTop > lastScrollTop && scrollTop > 200) {
            header.style.transform = 'translateY(-100%)';
        } else {
            header.style.transform = 'translateY(0)';
        }

        lastScrollTop = scrollTop;
    });

    // Animate statistics on scroll
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const statNumbers = entry.target.querySelectorAll('.stat-number');
                statNumbers.forEach(statNumber => {
                    animateNumber(statNumber);
                });
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const heroStats = document.querySelector('.hero-stats');
    if (heroStats) {
        observer.observe(heroStats);
    }

    // Animate cards on scroll
    const cardObserver = new IntersectionObserver(function (entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    // Observe all cards
    const cards = document.querySelectorAll('.news-card, .teacher-card, .document-card, .news-item');
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s ease';
        cardObserver.observe(card);
    });

    // Mobile menu toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const nav = document.querySelector('.nav');

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function () {
            nav.classList.toggle('active');
            this.classList.toggle('active');
        });
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', function (e) {
        if (nav && nav.classList.contains('active') &&
            !nav.contains(e.target) &&
            !mobileMenuBtn.contains(e.target)) {
            nav.classList.remove('active');
            mobileMenuBtn.classList.remove('active');
        }
    });

    // Image lazy loading
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver(function (entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });

    images.forEach(img => {
        imageObserver.observe(img);
    });

    // Search functionality (if search box exists)
    initializeSearch();
    initializeMobileSearch();

    // Back to top button
    createBackToTopButton();
});

// Animate numbers
function animateNumber(element) {
    const target = parseInt(element.textContent);
    const duration = 2000;
    const step = target / (duration / 16);
    let current = 0;

    const timer = setInterval(() => {
        current += step;
        if (current >= target) {
            current = target;
            clearInterval(timer);
        }
        element.textContent = Math.floor(current);
    }, 16);
}

// Search function
function performSearch(query) {
    if (query.length < 2) {
        hideSearchResults();
        return;
    }

    // Show loading
    showSearchLoading();

    // Make API request
    fetch(`/api/search?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(results => {
            displaySearchResults(results);
        })
        .catch(error => {
            console.error('Search error:', error);
            hideSearchResults();
        });
}

// Display search results
function displaySearchResults(results) {
    const resultsContainer = document.getElementById('searchResults');

    if (!results || results.length === 0) {
        hideSearchResults();
        return;
    }

    let html = '';

    results.forEach(result => {
        const icon = result.type === 'news' ? 'article' : 'notifications';
        const typeLabel = result.type === 'news' ? 'Tin tức' : 'Thông báo';

        html += `
            <div class="search-result-item p-3 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer border-b border-gray-100 dark:border-gray-600 last:border-b-0" onclick="window.location.href='${result.url}'">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-sm">${icon}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-medium text-text-main dark:text-white truncate">${result.title}</h4>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-xs text-primary font-medium">${typeLabel}</span>
                            <span class="text-xs text-text-muted dark:text-gray-400">${result.date}</span>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });

    // Add "View all results" link
    html += `
        <div class="p-3 border-t border-gray-100 dark:border-gray-600">
            <a href="/search?q=${encodeURIComponent(document.getElementById('searchInput').value)}" class="block text-center text-sm text-primary hover:text-primary-dark font-medium">
                Xem tất cả kết quả
            </a>
        </div>
    `;

    resultsContainer.innerHTML = html;
    resultsContainer.classList.remove('hidden');
}

// Show search loading
function showSearchLoading() {
    const resultsContainer = document.getElementById('searchResults');
    resultsContainer.innerHTML = `
        <div class="p-4 text-center">
            <div class="inline-flex items-center gap-2 text-text-muted dark:text-gray-400">
                <span class="material-symbols-outlined animate-spin">refresh</span>
                <span class="text-sm">Đang tìm kiếm...</span>
            </div>
        </div>
    `;
    resultsContainer.classList.remove('hidden');
}

// Hide search results
function hideSearchResults() {
    const resultsContainer = document.getElementById('searchResults');
    resultsContainer.classList.add('hidden');
}

// Initialize search functionality
function initializeSearch() {
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');

    if (!searchInput) return;

    let searchTimeout;

    // Handle input
    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimeout);
        const query = this.value.trim();

        if (query.length === 0) {
            hideSearchResults();
            return;
        }

        searchTimeout = setTimeout(() => {
            performSearch(query);
        }, 300);
    });

    // Handle form submission
    const searchForm = searchInput.closest('form');
    if (searchForm) {
        searchForm.addEventListener('submit', function (e) {
            const query = searchInput.value.trim();
            if (query.length < 2) {
                e.preventDefault();
                alert('Vui lòng nhập ít nhất 2 ký tự để tìm kiếm.');
                return false;
            }
        });
    }

    // Handle focus and blur
    searchInput.addEventListener('focus', function () {
        const query = this.value.trim();
        if (query.length >= 2) {
            performSearch(query);
        }
    });

    // Hide results when clicking outside
    document.addEventListener('click', function (e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            hideSearchResults();
        }
    });

    // Handle keyboard navigation
    searchInput.addEventListener('keydown', function (e) {
        const items = searchResults.querySelectorAll('.search-result-item');
        let currentIndex = -1;

        // Find currently selected item
        items.forEach((item, index) => {
            if (item.classList.contains('selected')) {
                currentIndex = index;
            }
        });

        switch (e.key) {
            case 'ArrowDown':
                e.preventDefault();
                currentIndex = Math.min(currentIndex + 1, items.length - 1);
                updateSelection(items, currentIndex);
                break;
            case 'ArrowUp':
                e.preventDefault();
                currentIndex = Math.max(currentIndex - 1, -1);
                updateSelection(items, currentIndex);
                break;
            case 'Enter':
                if (currentIndex >= 0 && items[currentIndex]) {
                    e.preventDefault();
                    items[currentIndex].click();
                }
                break;
            case 'Escape':
                hideSearchResults();
                searchInput.blur();
                break;
        }
    });
}

// Update selection for keyboard navigation
function updateSelection(items, selectedIndex) {
    items.forEach((item, index) => {
        if (index === selectedIndex) {
            item.classList.add('selected', 'bg-gray-100', 'dark:bg-gray-600');
        } else {
            item.classList.remove('selected', 'bg-gray-100', 'dark:bg-gray-600');
        }
    });
}

// Mobile search functionality
function initializeMobileSearch() {
    const mobileSearchBtn = document.getElementById('mobileSearchBtn');

    if (mobileSearchBtn) {
        mobileSearchBtn.addEventListener('click', function () {
            const query = prompt('Nhập từ khóa tìm kiếm:');
            if (query && query.trim().length >= 2) {
                window.location.href = `/search?q=${encodeURIComponent(query.trim())}`;
            } else if (query !== null) {
                alert('Vui lòng nhập ít nhất 2 ký tự để tìm kiếm.');
            }
        });
    }
}

// Create back to top button
function createBackToTopButton() {
    const backToTop = document.createElement('button');
    backToTop.innerHTML = '<i class="fas fa-chevron-up"></i>';
    backToTop.className = 'back-to-top';
    backToTop.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        border-radius: 50%;
        font-size: 18px;
        cursor: pointer;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 1000;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    `;

    document.body.appendChild(backToTop);

    // Show/hide button based on scroll position
    window.addEventListener('scroll', function () {
        if (window.pageYOffset > 300) {
            backToTop.style.opacity = '1';
            backToTop.style.visibility = 'visible';
        } else {
            backToTop.style.opacity = '0';
            backToTop.style.visibility = 'hidden';
        }
    });

    // Scroll to top when clicked
    backToTop.addEventListener('click', function () {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Hover effect
    backToTop.addEventListener('mouseenter', function () {
        this.style.transform = 'translateY(-3px)';
        this.style.boxShadow = '0 6px 20px rgba(0,0,0,0.3)';
    });

    backToTop.addEventListener('mouseleave', function () {
        this.style.transform = 'translateY(0)';
        this.style.boxShadow = '0 4px 15px rgba(0,0,0,0.2)';
    });
}

// Utility functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Add loading states for dynamic content
function showLoading(element) {
    element.innerHTML = '<div class="loading-spinner"><i class="fas fa-spinner fa-spin"></i> Đang tải...</div>';
}

function hideLoading(element, content) {
    element.innerHTML = content;
}

// Toast notifications
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
    `;

    toast.style.cssText = `
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

    document.body.appendChild(toast);

    setTimeout(() => {
        if (toast.parentElement) {
            toast.remove();
        }
    }, 5000);
}

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
    
    .header.scrolled {
        background: rgba(102, 126, 234, 0.95);
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 20px rgba(0,0,0,0.1);
    }
    
    .loading-spinner {
        text-align: center;
        padding: 40px;
        color: #667eea;
        font-size: 1.1rem;
    }
    
    .toast button {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        padding: 5px;
        border-radius: 3px;
        margin-left: auto;
    }
    
    .toast button:hover {
        background: rgba(255,255,255,0.2);
    }
`;
document.head.appendChild(style);

// Banner Slider JavaScript
let currentSlideIndex = 0;
let slideInterval;

// Initialize slider
function initSlider() {
    const slides = document.querySelectorAll('.slide');
    if (slides.length <= 1) return;

    // Start auto-slide
    startAutoSlide();

    // Pause on hover
    const sliderContainer = document.querySelector('.slider-container');
    if (sliderContainer) {
        sliderContainer.addEventListener('mouseenter', stopAutoSlide);
        sliderContainer.addEventListener('mouseleave', startAutoSlide);
    }
}

// Change slide function
function changeSlide(direction) {
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');

    if (slides.length === 0) return;

    // Remove active class from current slide and dot
    slides[currentSlideIndex].classList.remove('active');
    if (dots[currentSlideIndex]) {
        dots[currentSlideIndex].classList.remove('active');
    }

    // Calculate new slide index
    currentSlideIndex += direction;

    if (currentSlideIndex >= slides.length) {
        currentSlideIndex = 0;
    } else if (currentSlideIndex < 0) {
        currentSlideIndex = slides.length - 1;
    }

    // Add active class to new slide and dot
    slides[currentSlideIndex].classList.add('active');
    if (dots[currentSlideIndex]) {
        dots[currentSlideIndex].classList.add('active');
    }
}

// Go to specific slide
function currentSlide(index) {
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');

    if (slides.length === 0 || index < 0 || index >= slides.length) return;

    // Remove active class from current slide and dot
    slides[currentSlideIndex].classList.remove('active');
    if (dots[currentSlideIndex]) {
        dots[currentSlideIndex].classList.remove('active');
    }

    // Set new slide index
    currentSlideIndex = index;

    // Add active class to new slide and dot
    slides[currentSlideIndex].classList.add('active');
    if (dots[currentSlideIndex]) {
        dots[currentSlideIndex].classList.add('active');
    }
}

// Auto slide functionality
function startAutoSlide() {
    const slides = document.querySelectorAll('.slide');
    if (slides.length <= 1) return;

    slideInterval = setInterval(() => {
        changeSlide(1);
    }, 5000); // Change slide every 5 seconds
}

function stopAutoSlide() {
    if (slideInterval) {
        clearInterval(slideInterval);
    }
}

// Initialize slider when DOM is loaded
document.addEventListener('DOMContentLoaded', function () {
    initSlider();
});

// Handle window resize
window.addEventListener('resize', function () {
    // Reinitialize slider if needed
    const slides = document.querySelectorAll('.slide');
    if (slides.length > 0) {
        // Ensure current slide is still active
        slides.forEach((slide, index) => {
            slide.classList.toggle('active', index === currentSlideIndex);
        });
    }
});

// Touch/swipe support for mobile
let touchStartX = 0;
let touchEndX = 0;

function handleTouchStart(e) {
    touchStartX = e.changedTouches[0].screenX;
}

function handleTouchEnd(e) {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
}

function handleSwipe() {
    const swipeThreshold = 50;
    const diff = touchStartX - touchEndX;

    if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
            // Swipe left - next slide
            changeSlide(1);
        } else {
            // Swipe right - previous slide
            changeSlide(-1);
        }
    }
}

// Add touch event listeners to slider
document.addEventListener('DOMContentLoaded', function () {
    const sliderContainer = document.querySelector('.slider-container');
    if (sliderContainer) {
        sliderContainer.addEventListener('touchstart', handleTouchStart, { passive: true });
        sliderContainer.addEventListener('touchend', handleTouchEnd, { passive: true });
    }
});

// Keyboard navigation
document.addEventListener('keydown', function (e) {
    const slides = document.querySelectorAll('.slide');
    if (slides.length <= 1) return;

    switch (e.key) {
        case 'ArrowLeft':
            changeSlide(-1);
            break;
        case 'ArrowRight':
            changeSlide(1);
            break;
        case ' ': // Spacebar
            e.preventDefault();
            changeSlide(1);
            break;
    }
});

// Preload images for better performance
function preloadSliderImages() {
    const slides = document.querySelectorAll('.slide img');
    slides.forEach(img => {
        const imageUrl = img.src;
        const preloadImg = new Image();
        preloadImg.src = imageUrl;
    });
}

// Initialize preloading
document.addEventListener('DOMContentLoaded', function () {
    preloadSliderImages();
});

// Notification Functions
function showNotificationDetail(notificationId) {
    // Fetch notification details via API
    fetch(`/api/notifications/${notificationId}`)
        .then(response => response.json())
        .then(notification => {
            showNotificationModal(notification);
        })
        .catch(error => {
            console.error('Error fetching notification:', error);
            alert('Không thể tải chi tiết thông báo. Vui lòng thử lại sau.');
        });
}

function showNotificationModal(notification) {
    // Create modal HTML
    const modalHTML = `
        <div class="notification-modal-overlay" id="notificationModal">
            <div class="notification-modal">
                <div class="notification-modal-header">
                    <h3><i class="${notification.type_icon}"></i> ${notification.title}</h3>
                    <button class="notification-modal-close" onclick="closeNotificationModal()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="notification-modal-body">
                    <div class="notification-modal-meta">
                        <span class="badge ${notification.priority_badge}">${notification.priority}</span>
                        <span class="badge badge-${notification.type}">${notification.type}</span>
                        <span class="notification-modal-date">
                            <i class="fas fa-clock"></i> ${formatDate(notification.created_at)}
                        </span>
                    </div>
                    <div class="notification-modal-content">
                        ${notification.formatted_content}
                    </div>
                    ${notification.start_date || notification.end_date ? `
                        <div class="notification-modal-dates">
                            ${notification.start_date ? `<p><i class="fas fa-calendar-alt"></i> Bắt đầu: ${formatDate(notification.start_date)}</p>` : ''}
                            ${notification.end_date ? `<p><i class="fas fa-calendar-times"></i> Kết thúc: ${formatDate(notification.end_date)}</p>` : ''}
                        </div>
                    ` : ''}
                </div>
                <div class="notification-modal-footer">
                    <button class="btn btn-secondary" onclick="closeNotificationModal()">Đóng</button>
                </div>
            </div>
        </div>
    `;

    // Add modal to page
    document.body.insertAdjacentHTML('beforeend', modalHTML);

    // Show modal with animation
    setTimeout(() => {
        document.getElementById('notificationModal').classList.add('show');
    }, 10);

    // Increment view count
    incrementNotificationView(notification.id);
}

function closeNotificationModal() {
    const modal = document.getElementById('notificationModal');
    if (modal) {
        modal.classList.remove('show');
        setTimeout(() => {
            modal.remove();
        }, 300);
    }
}

function incrementNotificationView(notificationId) {
    fetch(`/api/notifications/${notificationId}/view`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        }
    }).catch(error => {
        console.error('Error incrementing view count:', error);
    });
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('vi-VN', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit'
    });
}

// Auto-refresh notifications every 5 minutes
function refreshNotifications() {
    fetch('/api/notifications/active')
        .then(response => response.json())
        .then(notifications => {
            updateNotificationsDisplay(notifications);
        })
        .catch(error => {
            console.error('Error refreshing notifications:', error);
        });
}

function updateNotificationsDisplay(notifications) {
    const container = document.querySelector('.notifications-container');
    if (!container || notifications.length === 0) return;

    // Clear existing notifications
    container.innerHTML = '';

    // Add new notifications
    notifications.forEach((notification, index) => {
        const notificationHTML = `
            <div class="notification-item ${notification.type_class} ${notification.priority_class}" 
                 data-notification-id="${notification.id}"
                 style="animation-delay: ${index * 0.1}s">
                <div class="notification-icon">
                    <i class="${notification.type_icon}"></i>
                </div>
                <div class="notification-content">
                    <h4 class="notification-title">${notification.title}</h4>
                    <p class="notification-text">${notification.content.substring(0, 150)}${notification.content.length > 150 ? '...' : ''}</p>
                    <div class="notification-meta">
                        <span class="notification-priority badge ${notification.priority_badge}">
                            ${notification.priority}
                        </span>
                        <span class="notification-date">
                            <i class="fas fa-clock"></i> ${formatDate(notification.created_at)}
                        </span>
                    </div>
                </div>
                ${notification.show_popup ? `
                    <div class="notification-actions">
                        <button class="btn-notification-detail" onclick="showNotificationDetail(${notification.id})">
                            <i class="fas fa-info-circle"></i> Chi tiết
                        </button>
                    </div>
                ` : ''}
            </div>
        `;
        container.insertAdjacentHTML('beforeend', notificationHTML);
    });
}

// Check for popup notifications on page load
function checkPopupNotifications() {
    fetch('/api/notifications/popup')
        .then(response => response.json())
        .then(notifications => {
            if (notifications.length > 0) {
                showPopupNotifications(notifications);
            }
        })
        .catch(error => {
            console.error('Error checking popup notifications:', error);
        });
}

function showPopupNotifications(notifications) {
    // Show the first urgent notification as popup
    const urgentNotification = notifications.find(n => n.priority === 'urgent') || notifications[0];

    setTimeout(() => {
        showNotificationModal(urgentNotification);
    }, 2000); // Show popup after 2 seconds
}

// Initialize notification system
document.addEventListener('DOMContentLoaded', function () {
    // Check for popup notifications
    checkPopupNotifications();

    // Set up auto-refresh (every 5 minutes)
    setInterval(refreshNotifications, 5 * 60 * 1000);

    // Close modal when clicking outside
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('notification-modal-overlay')) {
            closeNotificationModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeNotificationModal();
        }
    });
});