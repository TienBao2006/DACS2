@extends('Admin.pageAdmin')

@section('title', 'Trang chủ Admin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
@endpush

@section('content')
<div class="dashboard-container">
    <div class="dashboard-header">
        <h1><i class="fas fa-tachometer-alt"></i> Bảng điều khiển Admin</h1>
        <p class="text-muted">Tổng quan hệ thống quản lý trường học</p>
    </div>

    @if(isset($error))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> {{ $error }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card bg-primary">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['total_users'] ?? 0 }}</h3>
                    <p>Tài khoản</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card bg-success">
                <div class="stat-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['total_students'] ?? 0 }}</h3>
                    <p>Học sinh</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card bg-warning">
                <div class="stat-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['total_teachers'] ?? 0 }}</h3>
                    <p>Giáo viên</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card bg-info">
                <div class="stat-icon">
                    <i class="fas fa-school"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['total_classes'] ?? 0 }}</h3>
                    <p>Lớp học</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Statistics -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card bg-secondary">
                <div class="stat-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['total_assignments'] ?? 0 }}</h3>
                    <p>Phân công</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card bg-danger">
                <div class="stat-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['total_news'] ?? 0 }}</h3>
                    <p>Tin tức</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card bg-dark">
                <div class="stat-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['total_documents'] ?? 0 }}</h3>
                    <p>Tài liệu</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card bg-light">
                <div class="stat-icon">
                    <i class="fas fa-images"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['total_banners'] ?? 0 }}</h3>
                    <p>Banner</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Data -->
    <div class="row">
        <!-- Class Distribution Chart -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-chart-pie"></i> Phân bố học sinh theo khối</h5>
                </div>
                <div class="card-body">
                    <canvas id="classChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Subject Assignments Chart -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-chart-bar"></i> Phân công theo môn học</h5>
                </div>
                <div class="card-body">
                    <canvas id="subjectChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row">
        <!-- Recent News -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-newspaper"></i> Tin tức mới nhất</h5>
                    <a href="{{ route('admin.news.index') }}" class="btn btn-sm btn-primary">Xem tất cả</a>
                </div>
                <div class="card-body">
                    @if(isset($recent_news) && $recent_news->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recent_news as $news)
                            <div class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">{{ \Illuminate\Support\Str::limit($news->title ?? 'Không có tiêu đề', 50) }}</div>
                                    <small class="text-muted">{{ $news->created_at ? $news->created_at->format('d/m/Y H:i') : 'Không có ngày' }}</small>
                                </div>
                                @if($news->is_featured)
                                    <span class="badge bg-primary rounded-pill">Nổi bật</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Chưa có tin tức nào.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Documents -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-file-alt"></i> Tài liệu mới nhất</h5>
                    <a href="{{ route('admin.documents.index') }}" class="btn btn-sm btn-primary">Xem tất cả</a>
                </div>
                <div class="card-body">
                    @if(isset($recent_documents) && $recent_documents->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recent_documents as $document)
                            <div class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">{{ \Illuminate\Support\Str::limit($document->title ?? 'Không có tiêu đề', 50) }}</div>
                                    <small class="text-muted">{{ $document->created_at ? $document->created_at->format('d/m/Y H:i') : 'Không có ngày' }}</small>
                                </div>
                                <span class="badge bg-secondary rounded-pill">{{ strtoupper(pathinfo($document->file_path, PATHINFO_EXTENSION)) }}</span>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Chưa có tài liệu nào.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-bolt"></i> Thao tác nhanh</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                            <a href="{{ route('admin.account.index') }}" class="btn btn-outline-primary btn-block">
                                <i class="fas fa-user-plus"></i><br>
                                Thêm tài khoản
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                            <a href="{{ route('admin.students') }}" class="btn btn-outline-success btn-block">
                                <i class="fas fa-user-graduate"></i><br>
                                Quản lý học sinh
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                            <a href="{{ route('admin.timetable.create-weekly') }}" class="btn btn-outline-warning btn-block">
                                <i class="fas fa-calendar-plus"></i><br>
                                Tạo thời khóa biểu
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                            <a href="{{ route('admin.class.assignment') }}" class="btn btn-outline-info btn-block">
                                <i class="fas fa-chalkboard-teacher"></i><br>
                                Phân công lớp
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                            <a href="{{ route('admin.news.create') }}" class="btn btn-outline-danger btn-block">
                                <i class="fas fa-plus"></i><br>
                                Thêm tin tức
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                            <a href="{{ route('admin.banners.create') }}" class="btn btn-outline-dark btn-block">
                                <i class="fas fa-image"></i><br>
                                Thêm banner
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                            <a href="{{ route('admin.notifications.create') }}" class="btn btn-outline-info btn-block">
                                <i class="fas fa-bell"></i><br>
                                Tạo thông báo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Class Distribution Chart
const classCtx = document.getElementById('classChart').getContext('2d');
const classData = @json($class_distribution ?? []);
const classChart = new Chart(classCtx, {
    type: 'doughnut',
    data: {
        labels: classData.map(item => `Khối ${item.khoi}`),
        datasets: [{
            data: classData.map(item => item.total),
            backgroundColor: [
                '#FF6384',
                '#36A2EB',
                '#FFCE56',
                '#4BC0C0',
                '#9966FF',
                '#FF9F40'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Subject Assignments Chart
const subjectCtx = document.getElementById('subjectChart').getContext('2d');
const subjectData = @json($subject_assignments ?? []);
const subjectChart = new Chart(subjectCtx, {
    type: 'bar',
    data: {
        labels: subjectData.map(item => item.subject),
        datasets: [{
            label: 'Số phân công',
            data: subjectData.map(item => item.total),
            backgroundColor: '#36A2EB',
            borderColor: '#1E88E5',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>
@endpush
