<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Student Portal') - Cổng thông tin Học sinh</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/student-portal.css') }}">
    @stack('styles')
</head>

<body>
    <!-- Top Navigation Bar -->
    <nav class="top-navbar">
        <div class="navbar-container">
            <div class="navbar-brand">
                <i class="fas fa-graduation-cap"></i>
                <span class="brand-text">Student Portal</span>
            </div>

            <div class="navbar-user">
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->name ?? 'Học sinh' }}</span>
                    <span class="user-role">Học sinh</span>
                </div>
                <div class="user-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <button class="mobile-menu-toggle" id="mobileMenuToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Sidebar Navigation -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="student-profile">
                <div class="profile-avatar">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="profile-info">
                    <h4>{{ Auth::user()->name ?? 'Học sinh' }}</h4>
                    <p>Lớp: <span class="class-name">10A1</span></p>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">
            <ul class="menu-list">
                <li class="menu-item">
                    <a href="{{ route('student.dashboard') }}" class="menu-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                        <div class="menu-icon">🏠</div>
                        <span class="menu-text">Trang chủ</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('student.profile') }}" class="menu-link {{ request()->routeIs('student.profile*') ? 'active' : '' }}">
                        <div class="menu-icon">👤</div>
                        <span class="menu-text">Thông tin cá nhân</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('student.schedule') }}" class="menu-link {{ request()->routeIs('student.schedule') ? 'active' : '' }}">
                        <div class="menu-icon">📅</div>
                        <span class="menu-text">Thời khóa biểu</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('student.grades') }}" class="menu-link {{ request()->routeIs('student.grades') ? 'active' : '' }}">
                        <div class="menu-icon">📝</div>
                        <span class="menu-text">Điểm số</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('student.payments') }}" class="menu-link {{ request()->routeIs('student.payments') ? 'active' : '' }}">
                        <div class="menu-icon">💳</div>
                        <span class="menu-text">Thanh toán</span>
                    </a>
                </li>

                <li class="menu-divider"></li>

                <li class="menu-item">
                    <a href="{{ route('admin.logout') }}" class="menu-link logout">
                        <div class="menu-icon">🚪</div>
                        <span class="menu-text">Đăng xuất</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="content">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle"></i> {{ session('info') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        @yield('content')

        @if (!View::hasSection('content'))
            <!-- Default Dashboard Content -->
            <div class="dashboard-container">
                <div class="dashboard-header">
                    <h1 class="dashboard-title">
                        <i class="fas fa-home"></i>
                        Trang chủ học sinh
                    </h1>
                    <p class="dashboard-subtitle">Chào mừng bạn đến với cổng thông tin học sinh</p>
                </div>

                <div class="dashboard-stats">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="stat-content">
                            <h3>8</h3>
                            <p>Môn học</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stat-content">
                            <h3>8.5</h3>
                            <p>Điểm trung bình</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <div class="stat-content">
                            <h3>3</h3>
                            <p>Bài tập chưa nộp</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-content">
                            <h3>95%</h3>
                            <p>Tỷ lệ tham gia</p>
                        </div>
                    </div>
                </div>

                <div class="dashboard-grid">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3><i class="fas fa-calendar-alt"></i> Lịch học hôm nay</h3>
                        </div>
                        <div class="card-content">
                            <div class="schedule-item">
                                <div class="schedule-time">07:00 - 07:45</div>
                                <div class="schedule-subject">Toán học</div>
                                <div class="schedule-room">Phòng 101</div>
                            </div>
                            <div class="schedule-item">
                                <div class="schedule-time">07:45 - 08:30</div>
                                <div class="schedule-subject">Văn học</div>
                                <div class="schedule-room">Phòng 102</div>
                            </div>
                            <div class="schedule-item">
                                <div class="schedule-time">08:45 - 09:30</div>
                                <div class="schedule-subject">Tiếng Anh</div>
                                <div class="schedule-room">Phòng 103</div>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3><i class="fas fa-bell"></i> Thông báo mới</h3>
                        </div>
                        <div class="card-content">
                            <div class="notification-item">
                                <div class="notification-icon">
                                    <i class="fas fa-exclamation-circle text-warning"></i>
                                </div>
                                <div class="notification-content">
                                    <h4>Kiểm tra giữa kỳ môn Toán</h4>
                                    <p>Ngày 20/12/2025 - Phòng 101</p>
                                    <span class="notification-time">2 giờ trước</span>
                                </div>
                            </div>

                            <div class="notification-item">
                                <div class="notification-icon">
                                    <i class="fas fa-info-circle text-info"></i>
                                </div>
                                <div class="notification-content">
                                    <h4>Nộp bài tập Văn học</h4>
                                    <p>Hạn cuối: 18/12/2025</p>
                                    <span class="notification-time">1 ngày trước</span>
                                </div>
                            </div>

                            <div class="notification-item">
                                <div class="notification-icon">
                                    <i class="fas fa-check-circle text-success"></i>
                                </div>
                                <div class="notification-content">
                                    <h4>Điểm kiểm tra Tiếng Anh đã có</h4>
                                    <p>Điểm: 9.0/10</p>
                                    <span class="notification-time">2 ngày trước</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3><i class="fas fa-chart-pie"></i> Tiến độ học tập</h3>
                        </div>
                        <div class="card-content">
                            <div class="progress-item">
                                <div class="progress-label">
                                    <span>Toán học</span>
                                    <span>85%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 85%"></div>
                                </div>
                            </div>

                            <div class="progress-item">
                                <div class="progress-label">
                                    <span>Văn học</span>
                                    <span>92%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 92%"></div>
                                </div>
                            </div>

                            <div class="progress-item">
                                <div class="progress-label">
                                    <span>Tiếng Anh</span>
                                    <span>78%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 78%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3><i class="fas fa-trophy"></i> Thành tích</h3>
                        </div>
                        <div class="card-content">
                            <div class="achievement-item">
                                <div class="achievement-icon">🏆</div>
                                <div class="achievement-content">
                                    <h4>Học sinh giỏi</h4>
                                    <p>Học kỳ I năm học 2024-2025</p>
                                </div>
                            </div>

                            <div class="achievement-item">
                                <div class="achievement-icon">⭐</div>
                                <div class="achievement-content">
                                    <h4>Điểm 10 môn Toán</h4>
                                    <p>Kiểm tra 15 phút</p>
                                </div>
                            </div>

                            <div class="achievement-item">
                                <div class="achievement-icon">📚</div>
                                <div class="achievement-content">
                                    <h4>Tham gia đầy đủ</h4>
                                    <p>100% buổi học tháng 12</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/student-portal.js') }}"></script>
    @stack('scripts')

    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

        // Initialize tooltips
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        // Confirm delete actions
        $(document).on('click', '[data-confirm]', function(e) {
            if (!confirm($(this).data('confirm'))) {
                e.preventDefault();
                return false;
            }
        });

        // Loading state for forms
        $('form').on('submit', function() {
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...').prop('disabled', true);

            // Re-enable after 10 seconds as fallback
            setTimeout(function() {
                submitBtn.html(originalText).prop('disabled', false);
            }, 10000);
        });
    </script>
</body>

</html>
