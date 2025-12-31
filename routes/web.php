<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Img\ImageController;
use App\Http\Controllers\PageLogin\LoginController;
use App\Http\Controllers\Teacher\PageTeacher;

// Trang chủ 
Route::get('/', [App\Http\Controllers\HomePageController::class, 'index'])->name('homepage');
Route::get('/news', [App\Http\Controllers\HomePageController::class, 'news'])->name('homepage.news');
Route::get('/news/{id}', [App\Http\Controllers\HomePageController::class, 'newsDetail'])->name('homepage.news.detail');
Route::get('/teachers', [App\Http\Controllers\HomePageController::class, 'teachers'])->name('homepage.teachers');
Route::get('/documents', [App\Http\Controllers\HomePageController::class, 'documents'])->name('homepage.documents');
Route::get('/documents/{document}/download', [App\Http\Controllers\Admin\DocumentController::class, 'download'])->name('homepage.documents.download');
Route::get('/about', [App\Http\Controllers\HomePageController::class, 'about'])->name('homepage.about');
Route::get('/notifications', [App\Http\Controllers\HomePageController::class, 'notifications'])->name('homepage.notifications');
Route::get('/admissions', [App\Http\Controllers\HomePageController::class, 'admissions'])->name('homepage.admissions');

// Authentication routes
Route::get('/Login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/Login', [LoginController::class, 'login'])->name('login.submit');
Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('login.form');
})->name('admin.logout');

// Search routes
Route::get('/search', [App\Http\Controllers\HomePageController::class, 'search'])->name('homepage.search');
Route::get('/api/search', [App\Http\Controllers\HomePageController::class, 'apiSearch'])->name('api.search');

// Admin routes
Route::get('/admin', [App\Http\Controllers\Admin\PageAdminController::class, 'showAdminPage'])->name('admin.page');
Route::get('/admin/user', [App\Http\Controllers\Admin\PageAdminController::class, 'dashboard'])->name('admin.user');

// Account management routes (General)
Route::get('/admin/account', [App\Http\Controllers\Admin\AccountController::class, 'index'])->name('admin.account.index');
Route::post('/admin/account', [App\Http\Controllers\Admin\AccountController::class, 'storeAccount'])->name('admin.account.store');
Route::get('/admin/account/edit/{id}', [App\Http\Controllers\Admin\AccountController::class, 'editAccount'])->name('admin.account.edit');
Route::post('/admin/account/update/{id}', [App\Http\Controllers\Admin\AccountController::class, 'updateAccount'])->name('admin.account.update');
Route::get('/admin/account/delete/{id}', [App\Http\Controllers\Admin\AccountController::class, 'deleteAccount'])->name('admin.account.delete');
Route::post('/admin/account/toggle-status/{id}', [App\Http\Controllers\Admin\AccountController::class, 'toggleStatus'])->name('admin.account.toggle-status');

// Teacher Account Management
Route::prefix('admin/teacher-accounts')->name('admin.teacher-accounts.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\TeacherAccountController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\Admin\TeacherAccountController::class, 'create'])->name('create');
    Route::post('/', [App\Http\Controllers\Admin\TeacherAccountController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [App\Http\Controllers\Admin\TeacherAccountController::class, 'edit'])->name('edit');
    Route::put('/{id}', [App\Http\Controllers\Admin\TeacherAccountController::class, 'update'])->name('update');
    Route::delete('/{id}', [App\Http\Controllers\Admin\TeacherAccountController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/toggle-status', [App\Http\Controllers\Admin\TeacherAccountController::class, 'toggleStatus'])->name('toggle-status');
});

// Student Account Management
Route::prefix('admin/student-accounts')->name('admin.student-accounts.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\StudentAccountController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\Admin\StudentAccountController::class, 'create'])->name('create');
    Route::post('/', [App\Http\Controllers\Admin\StudentAccountController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [App\Http\Controllers\Admin\StudentAccountController::class, 'edit'])->name('edit');
    Route::put('/{id}', [App\Http\Controllers\Admin\StudentAccountController::class, 'update'])->name('update');
    Route::delete('/{id}', [App\Http\Controllers\Admin\StudentAccountController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/toggle-status', [App\Http\Controllers\Admin\StudentAccountController::class, 'toggleStatus'])->name('toggle-status');
    Route::get('/preview-code/{khoi}/{lop}', [App\Http\Controllers\Admin\StudentAccountController::class, 'previewStudentCode'])->name('preview-code');
    Route::get('/create-for-student/{studentId}', [App\Http\Controllers\Admin\StudentAccountController::class, 'createForStudent'])->name('create-for-student');
    Route::post('/store-for-student/{studentId}', [App\Http\Controllers\Admin\StudentAccountController::class, 'storeForStudent'])->name('store-for-student');
    Route::post('/create-login/{studentId}', [App\Http\Controllers\Admin\StudentAccountController::class, 'createLoginAccount'])->name('create-login');
    
    // Quản lý điểm số
    Route::get('/scores', [App\Http\Controllers\Admin\StudentAccountController::class, 'scoresIndex'])->name('scores.index');
    Route::post('/scores/create-sample', [App\Http\Controllers\Admin\StudentAccountController::class, 'createSampleScores'])->name('scores.create-sample');
    Route::get('/scores/{student}', [App\Http\Controllers\Admin\StudentAccountController::class, 'viewScores'])->name('scores.view');
    Route::get('/scores/test-create', [App\Http\Controllers\Admin\StudentAccountController::class, 'testCreateScores'])->name('scores.test-create');
    
    // Scores management
    Route::get('/scores/test-create', [App\Http\Controllers\Admin\StudentAccountController::class, 'testCreateScores'])->name('scores.test-create');
});


// Student management routes
Route::get('/admin/students', [App\Http\Controllers\Admin\ManageStudent::class, 'index'])->name('admin.students');
Route::post('/admin/students', [App\Http\Controllers\Admin\ManageStudent::class, 'store'])->name('admin.students.store');
Route::get('/admin/students/edit/{id}', [App\Http\Controllers\Admin\ManageStudent::class, 'edit'])->name('admin.students.edit');
Route::put('/admin/students/{id}', [App\Http\Controllers\Admin\ManageStudent::class, 'update'])->name('admin.students.update');
Route::delete('/admin/students/{id}', [App\Http\Controllers\Admin\ManageStudent::class, 'destroy'])->name('admin.students.destroy');
Route::get('/admin/students/preview-code/{khoi}/{lop}', [App\Http\Controllers\Admin\ManageStudent::class, 'previewStudentCode'])->name('admin.students.preview-code');

// Timetable management routes
Route::get('/admin/timetable', [App\Http\Controllers\Admin\TimeTableController::class, 'index'])->name('admin.timetable.index');
Route::get('/admin/timetable/create-weekly', [App\Http\Controllers\Admin\TimeTableController::class, 'createWeekly'])->name('admin.timetable.create-weekly');
Route::post('/admin/timetable/save-weekly', [App\Http\Controllers\Admin\TimeTableController::class, 'saveWeekly'])->name('admin.timetable.save-weekly');
Route::get('/admin/timetable/{id}/edit', [App\Http\Controllers\Admin\TimeTableController::class, 'edit'])->name('admin.timetable.edit');
Route::put('/admin/timetable/{id}', [App\Http\Controllers\Admin\TimeTableController::class, 'update'])->name('admin.timetable.update');
Route::delete('/admin/timetable/{id}', [App\Http\Controllers\Admin\TimeTableController::class, 'destroy'])->name('admin.timetable.destroy');

// API routes for timetable
Route::get('/api/teachers/by-subject/{subject}', [App\Http\Controllers\Admin\TimeTableController::class, 'getTeachersBySubject'])->name('api.teachers.by-subject');
Route::get('/api/timetable/get-weekly', [App\Http\Controllers\Admin\TimeTableController::class, 'getWeeklySchedules'])->name('api.timetable.get-weekly');

// Debug routes (remove in production)
Route::get('/admin/timetable/test-teacher-data', [App\Http\Controllers\Admin\TimeTableController::class, 'testTeacherData'])->name('admin.timetable.test-teacher-data');
Route::post('/admin/timetable/fix-teacher-names', [App\Http\Controllers\Admin\TimeTableController::class, 'fixMissingTeacherNames'])->name('admin.timetable.fix-teacher-names');
Route::get('/admin/timetable/debug-mapping', [App\Http\Controllers\Admin\TimeTableController::class, 'debugMapping'])->name('admin.timetable.debug-mapping');
Route::post('/admin/timetable/clear-all-data', [App\Http\Controllers\Admin\TimeTableController::class, 'clearAllData'])->name('admin.timetable.clear-all-data');



// Class Assignment routes
Route::get('/admin/class-assignment', [App\Http\Controllers\Admin\ClassAssignmentController::class, 'index'])->name('admin.class.assignment');
Route::post('/admin/class-assignment', [App\Http\Controllers\Admin\ClassAssignmentController::class, 'store'])->name('admin.class.assignment.store');
Route::put('/admin/class-assignment/{id}', [App\Http\Controllers\Admin\ClassAssignmentController::class, 'update'])->name('admin.class.assignment.update');
Route::delete('/admin/class-assignment/{id}', [App\Http\Controllers\Admin\ClassAssignmentController::class, 'destroy'])->name('admin.class.assignment.destroy');
Route::get('/admin/class-assignment/teachers/{subject}', [App\Http\Controllers\Admin\ClassAssignmentController::class, 'getTeachersBySubject'])->name('admin.class.assignment.teachers');
Route::post('/admin/class-assignment/bulk', [App\Http\Controllers\Admin\ClassAssignmentController::class, 'bulkAssign'])->name('admin.class.assignment.bulk');
Route::get('/admin/class-assignment/export', [App\Http\Controllers\Admin\ClassAssignmentController::class, 'exportTemplate'])->name('admin.class.assignment.export');
Route::get('/admin/class-assignment/statistics/{year}', [App\Http\Controllers\Admin\ClassAssignmentController::class, 'getClassStatistics'])->name('admin.class.assignment.statistics');
Route::get('/admin/integration-guide', [App\Http\Controllers\Admin\ClassAssignmentController::class, 'integrationGuide'])->name('admin.integration.guide');

// News management routes
Route::get('/admin/news', [App\Http\Controllers\Admin\NewsController::class, 'index'])->name('admin.news.index');
Route::get('/admin/news/create', [App\Http\Controllers\Admin\NewsController::class, 'create'])->name('admin.news.create');
Route::post('/admin/news', [App\Http\Controllers\Admin\NewsController::class, 'store'])->name('admin.news.store');
Route::get('/admin/news/{news}', [App\Http\Controllers\Admin\NewsController::class, 'show'])->name('admin.news.show');
Route::get('/admin/news/{news}/edit', [App\Http\Controllers\Admin\NewsController::class, 'edit'])->name('admin.news.edit');
Route::put('/admin/news/{news}', [App\Http\Controllers\Admin\NewsController::class, 'update'])->name('admin.news.update');
Route::delete('/admin/news/{news}', [App\Http\Controllers\Admin\NewsController::class, 'destroy'])->name('admin.news.destroy');
Route::post('/admin/news/{news}/toggle-featured', [App\Http\Controllers\Admin\NewsController::class, 'toggleFeatured'])->name('admin.news.toggle-featured');
Route::post('/admin/news/{news}/toggle-published', [App\Http\Controllers\Admin\NewsController::class, 'togglePublished'])->name('admin.news.toggle-published');

// Document management routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('documents', App\Http\Controllers\Admin\DocumentController::class);
    Route::get('documents/{document}/download', [App\Http\Controllers\Admin\DocumentController::class, 'download'])->name('documents.download');
});

// Banner management routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('banners', App\Http\Controllers\Admin\BannerController::class);
    Route::patch('banners/{banner}/toggle', [App\Http\Controllers\Admin\BannerController::class, 'toggleStatus'])->name('banners.toggle');
});

// Notification management routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('notifications', App\Http\Controllers\Admin\NotificationController::class);
    Route::post('notifications/{notification}/toggle-status', [App\Http\Controllers\Admin\NotificationController::class, 'toggleStatus'])->name('notifications.toggle-status');
    Route::post('notifications/bulk-action', [App\Http\Controllers\Admin\NotificationController::class, 'bulkAction'])->name('notifications.bulk-action');
});

// Payment management routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('payments', [App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/create', [App\Http\Controllers\Admin\PaymentController::class, 'create'])->name('payments.create');
    Route::post('payments', [App\Http\Controllers\Admin\PaymentController::class, 'store'])->name('payments.store');
    Route::get('payments/{payment}', [App\Http\Controllers\Admin\PaymentController::class, 'show'])->name('payments.show');
    Route::put('payments/{payment}/status', [App\Http\Controllers\Admin\PaymentController::class, 'updateStatus'])->name('payments.update-status');
    Route::delete('payments/{payment}', [App\Http\Controllers\Admin\PaymentController::class, 'destroy'])->name('payments.destroy');
});

// API routes for notifications
Route::get('/api/notifications/active', [App\Http\Controllers\Admin\NotificationController::class, 'getActiveNotifications'])->name('api.notifications.active');
Route::get('/api/notifications/popup', [App\Http\Controllers\Admin\NotificationController::class, 'getPopupNotifications'])->name('api.notifications.popup');

// API routes for payments
Route::post('/api/payments/qr', [App\Http\Controllers\PaymentController::class, 'createQR'])->name('api.payments.qr');
Route::get('/api/payments/list', [App\Http\Controllers\PaymentController::class, 'getPaymentsList'])->name('api.payments.list');
Route::get('/api/payments/{paymentId}/status', [App\Http\Controllers\PaymentController::class, 'checkStatus'])->name('api.payments.status');
Route::put('/api/payments/{paymentId}/status', [App\Http\Controllers\PaymentController::class, 'updateStatus'])->name('api.payments.update-status');
Route::get('/api/payments', [App\Http\Controllers\PaymentController::class, 'getPayments'])->name('api.payments.index');

// SePay API routes
Route::prefix('api/sepay')->name('api.sepay.')->group(function () {
    Route::post('/create-payment', [App\Http\Controllers\SepayController::class, 'createPayment'])->name('create-payment');
    Route::post('/check-status', [App\Http\Controllers\SepayController::class, 'checkPaymentStatus'])->name('check-status');
    Route::post('/webhook', [App\Http\Controllers\SepayController::class, 'webhook'])->name('webhook');
    Route::get('/transactions', [App\Http\Controllers\SepayController::class, 'getTransactions'])->name('transactions');
});

// Page Home (old route - redirect to new homepage)
Route::get('/home', function () {
    return redirect()->route('homepage');
});

// Page Teacher 
Route::middleware('auth')->prefix('teacher')->name('teacher.')->group(function () {

    // Trang chính của giáo viên
    Route::get('/dashboard', [PageTeacher::class, 'Page'])
        ->name('dashboard');

    // Trang hồ sơ giáo viên
    Route::get('/profile', [PageTeacher::class, 'profile'])
        ->name('profile');

    // Cập nhật thông tin giáo viên
    Route::post('/update/{ma_giao_vien}', [PageTeacher::class, 'update'])
        ->name('update');

    // Danh sách điểm
    Route::get('/list-point', [PageTeacher::class, 'listPoint'])
        ->name('list.point');

    // Xem chi tiết điểm học sinh
    Route::get('/view-student-scores/{student}', [PageTeacher::class, 'viewStudentScores'])
        ->name('view.student.scores');

    // Nhập điểm cho học sinh
    Route::get('/input-scores', [PageTeacher::class, 'showInputScoresForm'])
        ->name('input.scores');

    // Lưu điểm học sinh
    Route::post('/save-scores', [PageTeacher::class, 'saveScoresForm'])
        ->name('save.scores');

    // Thời khóa biểu giáo viên
    Route::get('/timetable', [PageTeacher::class, 'timetable'])
        ->name('timetable');
});

// Page Home (old route - redirect to new homepage)
Route::get('/home', function () {
    return redirect()->route('homepage');
});

// Student routes
Route::prefix('student')->name('student.')->group(function () {
    Route::get('/', [App\Http\Controllers\Student\PageStudent::class, 'index'])->name('dashboard');
    Route::get('/profile', [App\Http\Controllers\Student\PageStudent::class, 'profile'])->name('profile');
    Route::get('/profile/{id}', [App\Http\Controllers\Student\PageStudent::class, 'profileById'])->name('profile.show');
    Route::put('/profile/{id}', [App\Http\Controllers\Student\PageStudent::class, 'update'])->name('profile.update');
    Route::post('/profile/{id}', [App\Http\Controllers\Student\PageStudent::class, 'update'])->name('profile.update.post');
    Route::get('/grades', [App\Http\Controllers\Student\PageStudent::class, 'grades'])->name('grades');
    Route::get('/payments', [App\Http\Controllers\Student\PageStudent::class, 'payments'])->name('payments');
    Route::get('/schedule', [App\Http\Controllers\Student\PageStudent::class, 'schedule'])->name('schedule');
    Route::get('/assignments', [App\Http\Controllers\Student\PageStudent::class, 'assignments'])->name('assignments');
    Route::get('/subjects', [App\Http\Controllers\Student\PageStudent::class, 'subjects'])->name('subjects');
    Route::get('/documents', [App\Http\Controllers\Student\PageStudent::class, 'documents'])->name('documents');
    Route::get('/notifications', [App\Http\Controllers\Student\PageStudent::class, 'notifications'])->name('notifications');
    Route::get('/contact', [App\Http\Controllers\Student\PageStudent::class, 'contact'])->name('contact');
});
