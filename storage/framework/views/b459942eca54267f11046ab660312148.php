

<?php $__env->startSection('content'); ?>
<style>
.account-overview {
    padding: 20px;
}

.page-header {
    text-align: center;
    margin-bottom: 40px;
    padding-bottom: 20px;
    border-bottom: 2px solid #e2e8f0;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2d3748;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
}

.management-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.management-card {
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
}

.management-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.card-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
}

.card-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.student-icon {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.teacher-icon {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.card-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2d3748;
    margin: 0;
}

.card-description {
    color: #718096;
    margin-bottom: 25px;
    line-height: 1.6;
}

.stats-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 1.8rem;
    font-weight: 700;
    color: #4a5568;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 0.9rem;
    color: #718096;
}

.card-actions {
    display: flex;
    gap: 10px;
}

.btn {
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    font-size: 0.9rem;
    flex: 1;
    justify-content: center;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.btn-secondary {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(240, 147, 251, 0.3);
}

.quick-stats {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    border-radius: 15px;
    margin-bottom: 30px;
}

.quick-stats h3 {
    margin: 0 0 20px 0;
    font-size: 1.5rem;
    text-align: center;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 20px;
}

.quick-stat-item {
    text-align: center;
    background: rgba(255, 255, 255, 0.1);
    padding: 20px;
    border-radius: 10px;
}

.quick-stat-number {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 5px;
}

.quick-stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
}

@media (max-width: 768px) {
    .management-grid {
        grid-template-columns: 1fr;
    }
    
    .card-actions {
        flex-direction: column;
    }
    
    .stats-row {
        flex-direction: column;
        gap: 15px;
    }
}
</style>

<div class="account-overview">
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-users-cog"></i>
            Quản lý tài khoản
        </h1>
    </div>

    <!-- Quick Stats -->
    <div class="quick-stats">
        <h3><i class="fas fa-chart-bar"></i> Thống kê tổng quan</h3>
        <div class="stats-grid">
            <div class="quick-stat-item">
                <div class="quick-stat-number"><?php echo e(App\Models\Student::count()); ?></div>
                <div class="quick-stat-label">Tổng học sinh</div>
            </div>
            <div class="quick-stat-item">
                <div class="quick-stat-number"><?php echo e(App\Models\Teacher::count()); ?></div>
                <div class="quick-stat-label">Tổng giáo viên</div>
            </div>
            <div class="quick-stat-item">
                <div class="quick-stat-number"><?php echo e(App\Models\Login::count()); ?></div>
                <div class="quick-stat-label">Tổng tài khoản</div>
            </div>
            <div class="quick-stat-item">
                <div class="quick-stat-number"><?php echo e(App\Models\Login::where('is_active', true)->count()); ?></div>
                <div class="quick-stat-label">Đang hoạt động</div>
            </div>
        </div>
    </div>

    <!-- Management Cards -->
    <div class="management-grid">
        <!-- Student Management -->
        <div class="management-card">
            <div class="card-header">
                <div class="card-icon student-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h2 class="card-title">Quản lý học sinh</h2>
            </div>
            
            <p class="card-description">
                Quản lý tài khoản và thông tin của tất cả học sinh trong trường. 
                Tạo tài khoản mới, chỉnh sửa thông tin và quản lý trạng thái hoạt động.
            </p>
            
            <div class="stats-row">
                <div class="stat-item">
                    <div class="stat-number"><?php echo e(App\Models\Student::count()); ?></div>
                    <div class="stat-label">Tổng học sinh</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?php echo e(App\Models\Student::whereNotNull('login_id')->count()); ?></div>
                    <div class="stat-label">Có tài khoản</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?php echo e(App\Models\Student::whereNull('login_id')->count()); ?></div>
                    <div class="stat-label">Chưa có TK</div>
                </div>
            </div>
            
            <div class="card-actions">
                <a href="<?php echo e(route('admin.student-accounts.index')); ?>" class="btn btn-primary">
                    <i class="fas fa-list"></i>
                    Danh sách
                </a>
                <a href="<?php echo e(route('admin.student-accounts.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Thêm mới
                </a>
            </div>
        </div>

        <!-- Teacher Management -->
        <div class="management-card">
            <div class="card-header">
                <div class="card-icon teacher-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <h2 class="card-title">Quản lý giáo viên</h2>
            </div>
            
            <p class="card-description">
                Quản lý tài khoản và thông tin của tất cả giáo viên trong trường. 
                Tạo tài khoản mới, phân quyền và quản lý thông tin cá nhân.
            </p>
            
            <div class="stats-row">
                <div class="stat-item">
                    <div class="stat-number"><?php echo e(App\Models\Teacher::count()); ?></div>
                    <div class="stat-label">Tổng giáo viên</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?php echo e(App\Models\Teacher::whereNotNull('login_id')->count()); ?></div>
                    <div class="stat-label">Có tài khoản</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?php echo e(App\Models\Teacher::whereNull('login_id')->count()); ?></div>
                    <div class="stat-label">Chưa có TK</div>
                </div>
            </div>
            
            <div class="card-actions">
                <a href="<?php echo e(route('admin.teacher-accounts.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-list"></i>
                    Danh sách
                </a>
                <a href="<?php echo e(route('admin.teacher-accounts.create')); ?>" class="btn btn-secondary">
                    <i class="fas fa-plus"></i>
                    Thêm mới
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Admin.pageAdmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Xampp\htdocs\laravel\Myto\resources\views/admin/accountManagement.blade.php ENDPATH**/ ?>