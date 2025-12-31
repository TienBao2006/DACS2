<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Hệ thống Giáo viên' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/teacher-sidebar.css') }}">
    @stack('styles')
</head>

<body>
    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Sidebar Header -->
        <div class="sidebar-header">
            <div class="sidebar-brand">
                <i class="fas fa-graduation-cap"></i>
                <h3>Giáo Viên</h3>
            </div>

            <!-- Teacher Info -->
            <div class="teacher-info">
                @if (isset($teacher) && $teacher->anh_dai_dien)
                    <img src="{{ asset('uploads/teacher/' . $teacher->anh_dai_dien) }}" alt="Avatar"
                        class="teacher-avatar">
                @else
                    <div class="teacher-avatar"
                        style="background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user" style="font-size: 30px; color: rgba(255,255,255,0.8);"></i>
                    </div>
                @endif
                <div class="teacher-name">
                    <strong>{{ $teacher->ho_ten ?? 'Giáo viên' }}</strong>
                    <div class="teacher-role">Giáo viên</div>
                </div>
            </div>
        </div>

        <!-- Toggle Button -->
        <button id="toggleBtn" class="toggle-btn">
            <i class="fas fa-chevron-left"></i>
        </button>

        <!-- Navigation -->
        <nav class="sidebar-nav" id="sidebarNav">
            <ul>
                <li>
                    <a href="{{ route('teacher.dashboard') }}" data-tooltip="Trang chủ"
                        class="{{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        <span>Trang chủ</span>
                    </a>
                </li>

                <div class="menu-category">Thông tin cá nhân</div>

                <li>
                    <a href="{{ route('teacher.profile') }}" data-tooltip="Hồ sơ cá nhân"
                        class="{{ request()->routeIs('teacher.profile') ? 'active' : '' }}">
                        <i class="fas fa-user-circle"></i>
                        <span>Hồ sơ cá nhân</span>
                    </a>
                </li>

                <div class="menu-category">Quản lý lớp học</div>

                <li>
                    <a href="{{ route('teacher.timetable') }}" data-tooltip="Thời khóa biểu"
                        class="{{ request()->routeIs('teacher.timetable') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Thời khóa biểu</span>
                    </a>
                </li>

                <div class="menu-category">Quản lý điểm số</div>

                <li>
                    <a href="{{ route('teacher.list.point') }}" data-tooltip="Danh sách điểm"
                        class="{{ request()->routeIs('teacher.list.point') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Danh sách điểm</span>
                    </a>
                </li>

                <div class="menu-category">Hệ thống</div>

                <li>
                    <a href="{{ route('admin.logout') }}" data-tooltip="Đăng xuất"
                        onclick="return confirm('Bạn có chắc chắn muốn đăng xuất?')">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Đăng xuất</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="content">
        @yield('content')
    </div>

    <!-- JavaScript -->
    <script src="{{ asset('js/teacher-sidebar.js') }}"></script>

    <!-- Additional functionality -->
    <script>
        // Mobile menu button (if needed)
        function createMobileMenuButton() {
            if (window.innerWidth <= 768) {
                const mobileBtn = document.createElement('button');
                mobileBtn.innerHTML = '<i class="fas fa-bars"></i>';
                mobileBtn.className = 'mobile-menu-btn';
                mobileBtn.style.cssText = `
                    position: fixed;
                    top: 20px;
                    left: 20px;
                    z-index: 1001;
                    background: #667eea;
                    color: white;
                    border: none;
                    width: 50px;
                    height: 50px;
                    border-radius: 50%;
                    font-size: 18px;
                    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                    cursor: pointer;
                    transition: all 0.3s ease;
                `;

                mobileBtn.addEventListener('click', () => {
                    if (window.teacherSidebar) {
                        window.teacherSidebar.openMobile();
                    }
                });

                document.body.appendChild(mobileBtn);
            }
        }

        // Initialize mobile button on load and resize
        window.addEventListener('load', createMobileMenuButton);
        window.addEventListener('resize', () => {
            const existingBtn = document.querySelector('.mobile-menu-btn');
            if (existingBtn) {
                existingBtn.remove();
            }
            createMobileMenuButton();
        });

        // Page loading animation
        document.addEventListener('DOMContentLoaded', () => {
            const content = document.querySelector('.content');
            if (content) {
                content.style.opacity = '0';
                content.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    content.style.transition = 'all 0.5s ease';
                    content.style.opacity = '1';
                    content.style.transform = 'translateY(0)';
                }, 100);
            }
        });

        // Notification system (if needed)
        window.showNotification = function(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                <span>${message}</span>
                <button onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            `;

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
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 5000);
        };
    </script>

    @stack('scripts')
</body>

</html>
