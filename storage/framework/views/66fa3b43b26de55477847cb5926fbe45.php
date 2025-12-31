<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $__env->yieldContent('title', 'Admin Panel'); ?> - Hệ thống Quản lý Trường học</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('css/admin.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/admin-sidebar.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/account.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/student.css')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>
    <div class="sidebar" id="sidebar">
        <h2><i class="fas fa-graduation-cap"></i> Admin Panel</h2>
        <button id="toggleBtn" class="toggle-btn"><i class="fas fa-bars"></i></button>
        
        <div class="sidebar-menu">
            <ul>
                <li><a href="<?php echo e(route('admin.user')); ?>"><i class="fas fa-home"></i> <span>Trang chủ</span></a></li>
                
                <!-- Quản lý tài khoản -->
                <li class="menu-section">
                    <span class="section-title"><i class="fas fa-users-cog"></i> Quản lý tài khoản</span>
                </li>
                <li><a href="<?php echo e(route('admin.teacher-accounts.index')); ?>"><i class="fas fa-chalkboard-teacher"></i> <span>Tài khoản giáo viên</span></a></li>
                <li><a href="<?php echo e(route('admin.student-accounts.index')); ?>"><i class="fas fa-user-graduate"></i> <span>Tài khoản học sinh</span></a></li>
                <li><a href="<?php echo e(route('admin.account.index')); ?>"><i class="fas fa-users"></i> <span>Tất cả tài khoản</span></a></li>
                
                <!-- Quản lý dữ liệu -->
                <li class="menu-section">
                    <span class="section-title"><i class="fas fa-database"></i> Quản lý dữ liệu</span>
                </li>
                <li><a href="<?php echo e(route('admin.students')); ?>"><i class="fas fa-user-graduate"></i> <span>Hồ sơ học sinh</span></a></li>
                <li><a href="<?php echo e(route('admin.timetable.index')); ?>"><i class="fas fa-calendar-alt"></i> <span>Thời khóa biểu</span></a></li>
                <li><a href="<?php echo e(route('admin.class.assignment')); ?>"><i class="fas fa-chalkboard-teacher"></i> <span>Phân công giảng dạy</span></a></li>
                
                <!-- Quản lý nội dung -->
                <li class="menu-section">
                    <span class="section-title"><i class="fas fa-edit"></i> Quản lý nội dung</span>
                </li>
                <li><a href="<?php echo e(route('admin.news.index')); ?>"><i class="fas fa-newspaper"></i> <span>Tin tức</span></a></li>
                <li><a href="<?php echo e(route('admin.documents.index')); ?>"><i class="fas fa-file-alt"></i> <span>Tài liệu</span></a></li>
                <li><a href="<?php echo e(route('admin.banners.index')); ?>"><i class="fas fa-images"></i> <span>Banner</span></a></li>
                <li><a href="<?php echo e(route('admin.notifications.index')); ?>"><i class="fas fa-bell"></i> <span>Thông báo</span></a></li>
                <li><a href="<?php echo e(route('admin.payments.index')); ?>"><i class="fas fa-credit-card"></i> <span>Thanh toán</span></a></li>
                <li class="menu-section">
                    <span class="section-title"><i class="fas fa-edit"></i> Quản lý nội dung</span>
                </li>
                <li><a href="<?php echo e(route('admin.payments.index')); ?>"><i class="fas fa-money-bill-wave"></i> <span>Quản lý học phí</span></a></li>
                <li class="menu-divider"></li>
                <li><a href="<?php echo e(route('admin.logout')); ?>"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></a></li>
            </ul>
        </div>
    </div>

    <div class="content">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if(session('warning')): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> <?php echo e(session('warning')); ?>

                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if(session('info')): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle"></i> <?php echo e(session('info')); ?>

                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo e(asset('js/admin-sidebar.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>

    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

        // Initialize tooltips
        $(function () {
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
<?php /**PATH F:\Xampp\htdocs\laravel\Myto\resources\views/Admin/pageAdmin.blade.php ENDPATH**/ ?>