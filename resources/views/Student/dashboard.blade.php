@extends('Student.PageStudent')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-container">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="welcome-content">
            <h1>Chào mừng trở lại, {{ $student->ho_va_ten ?? 'Học sinh' }}! 👋</h1>
            <p>Lớp {{ $student->lop ?? '10A1' }} - Năm học {{ $student->nam_hoc ?? '2024-2025' }}</p>
        </div>
        <div class="welcome-stats">
            <div class="stat-item">
                <div class="stat-icon">📚</div>
                <div class="stat-info">
                    <span class="stat-number">{{ $stats['total_subjects'] }}</span>
                    <span class="stat-label">Môn học</span>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">⭐</div>
                <div class="stat-info">
                    <span class="stat-number">{{ $stats['average_grade'] }}</span>
                    <span class="stat-label">Điểm TB</span>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">✅</div>
                <div class="stat-info">
                    <span class="stat-number">{{ $stats['attendance_rate'] }}%</span>
                    <span class="stat-label">Chuyên cần</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Dashboard Grid -->
    <div class="dashboard-grid">
        <!-- Quick Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card completed">
                <div class="stat-card-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-card-content">
                    <h3>{{ $stats['completed_assignments'] }}</h3>
                    <p>Bài tập hoàn thành</p>
                </div>
            </div>

            <div class="stat-card pending">
                <div class="stat-card-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-card-content">
                    <h3>{{ $stats['pending_assignments'] }}</h3>
                    <p>Bài tập chưa nộp</p>
                </div>
            </div>

            <div class="stat-card notifications">
                <div class="stat-card-icon">
                    <i class="fas fa-bell"></i>
                </div>
                <div class="stat-card-content">
                    <h3>{{ $stats['notifications_count'] }}</h3>
                    <p>Thông báo mới</p>
                </div>
            </div>

            <div class="stat-card payment">
                <div class="stat-card-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="stat-card-content">
                    <h3>{{ $stats['pending_payments_count'] ?? 0 }}</h3>
                    <p>Khoản cần thanh toán</p>
                    <a href="{{ route('student.payments') }}" class="stat-card-link">Xem chi tiết</a>
                </div>
            </div>
        </div>

        <!-- Today's Schedule -->
        <div class="dashboard-card schedule-card">
            <div class="card-header">
                <h3><i class="fas fa-calendar-day"></i> Lịch học hôm nay</h3>
                <span class="date">{{ date('d/m/Y') }}</span>
            </div>
            <div class="card-content">
                @if(count($todaySchedule) > 0)
                    <div class="schedule-list">
                        @foreach($todaySchedule as $class)
                        <div class="schedule-item">
                            <div class="schedule-time">{{ $class['time'] }}</div>
                            <div class="schedule-info">
                                <h4>{{ $class['subject'] }}</h4>
                                <p>{{ $class['teacher'] }} - {{ $class['room'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-calendar-times"></i>
                        <p>Không có lịch học hôm nay</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Upcoming Assignments -->
        <div class="dashboard-card assignments-card">
            <div class="card-header">
                <h3><i class="fas fa-tasks"></i> Bài tập sắp hết hạn</h3>
                <a href="{{ route('student.assignments') }}" class="view-all">Xem tất cả</a>
            </div>
            <div class="card-content">
                @if(count($upcomingAssignments) > 0)
                    <div class="assignment-list">
                        @foreach($upcomingAssignments as $assignment)
                        <div class="assignment-item {{ $assignment['status'] }}">
                            <div class="assignment-info">
                                <h4>{{ $assignment['title'] }}</h4>
                                <p>{{ $assignment['subject'] }} - Hạn: {{ date('d/m/Y', strtotime($assignment['due_date'])) }}</p>
                            </div>
                            <div class="assignment-status">
                                @if($assignment['status'] === 'completed')
                                    <span class="status-badge completed">Hoàn thành</span>
                                @else
                                    <span class="status-badge pending">Chưa nộp</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-clipboard-check"></i>
                        <p>Không có bài tập nào sắp hết hạn</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Notifications -->
        <div class="dashboard-card notifications-card">
            <div class="card-header">
                <h3><i class="fas fa-bell"></i> Thông báo gần đây</h3>
                <a href="{{ route('student.notifications') }}" class="view-all">Xem tất cả</a>
            </div>
            <div class="card-content">
                @if(count($recentNotifications) > 0)
                    @foreach($recentNotifications as $notification)
                    <div class="notification-item">
                        <div class="notification-icon">
                            @if($notification['type'] === 'warning')
                                <i class="fas fa-exclamation-triangle text-warning"></i>
                            @elseif($notification['type'] === 'success')
                                <i class="fas fa-check-circle text-success"></i>
                            @else
                                <i class="fas fa-info-circle text-info"></i>
                            @endif
                        </div>
                        <div class="notification-content">
                            <h4>{{ $notification['title'] }}</h4>
                            <p>{{ $notification['content'] }}</p>
                            <span class="notification-time">{{ $notification['time'] }}</span>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="fas fa-bell-slash"></i>
                        <p>Không có thông báo mới</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="dashboard-card actions-card">
            <div class="card-header">
                <h3><i class="fas fa-bolt"></i> Thao tác nhanh</h3>
            </div>
            <div class="card-content">
                <div class="quick-actions">
                    <a href="{{ route('student.grades') }}" class="action-btn">
                        <i class="fas fa-chart-line"></i>
                        <span>Xem điểm</span>
                    </a>
                    <a href="{{ route('student.schedule') }}" class="action-btn">
                        <i class="fas fa-calendar"></i>
                        <span>Thời khóa biểu</span>
                    </a>
                    <a href="{{ route('student.documents') }}" class="action-btn">
                        <i class="fas fa-download"></i>
                        <span>Tài liệu</span>
                    </a>
                    <a href="{{ route('student.contact') }}" class="action-btn">
                        <i class="fas fa-envelope"></i>
                        <span>Liên hệ GV</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Academic Progress Chart -->
        <div class="dashboard-card progress-card">
            <div class="card-header">
                <h3><i class="fas fa-chart-area"></i> Tiến độ học tập</h3>
            </div>
            <div class="card-content">
                <div class="progress-chart">
                    <canvas id="academicChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Academic Progress Chart
const ctx = document.getElementById('academicChart').getContext('2d');
const academicChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
        datasets: [{
            label: 'Điểm trung bình',
            data: [8.2, 8.4, 8.5, 8.6],
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: false,
                min: 7,
                max: 10
            }
        }
    }
});
</script>
@endpush
@endsection