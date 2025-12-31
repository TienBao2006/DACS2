@extends('Admin.pageAdmin')

@section('title', 'Quản lý điểm số học sinh')

@section('content')
<div class="scores-management">
    <div class="page-header">
        <h1><i class="fas fa-chart-bar"></i> Quản lý điểm số học sinh</h1>
        <div class="header-actions">
            <button class="btn btn-info" onclick="createSampleTimetable()">
                <i class="fas fa-calendar-alt"></i> Tạo thời khóa biểu mẫu
            </button>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createSampleModal">
                <i class="fas fa-plus"></i> Tạo điểm mẫu
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $stats['total_students'] }}</h3>
                <p>Tổng học sinh</p>
            </div>
        </div>
        <div class="stat-card success">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $stats['students_with_scores'] }}</h3>
                <p>Có điểm</p>
            </div>
        </div>
        <div class="stat-card warning">
            <div class="stat-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $stats['students_without_scores'] }}</h3>
                <p>Chưa có điểm</p>
            </div>
        </div>
        <div class="stat-card info">
            <div class="stat-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $stats['total_scores'] }}</h3>
                <p>Tổng bản ghi điểm</p>
            </div>
        </div>
    </div>

    <!-- Students List -->
    <div class="students-table-container">
        <div class="table-header">
            <h3><i class="fas fa-table"></i> Danh sách học sinh</h3>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Mã HS</th>
                        <th>Họ và tên</th>
                        <th>Lớp</th>
                        <th>Số môn có điểm</th>
                        <th>Điểm TB</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr>
                        <td>{{ $student->ma_hoc_sinh }}</td>
                        <td>{{ $student->ho_va_ten }}</td>
                        <td>{{ $student->lop }}</td>
                        <td>
                            <span class="badge {{ $student->scores->count() > 0 ? 'badge-success' : 'badge-warning' }}">
                                {{ $student->scores->count() }} môn
                            </span>
                        </td>
                        <td>
                            @if($student->scores->count() > 0)
                                <span class="average-score">{{ $student->calculateOverallAverage() }}</span>
                            @else
                                <span class="text-muted">Chưa có</span>
                            @endif
                        </td>
                        <td>
                            @if($student->scores->count() > 0)
                                <span class="status-badge success">Có điểm</span>
                            @else
                                <span class="status-badge warning">Chưa có điểm</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                @if($student->scores->count() > 0)
                                    <a href="{{ route('admin.student-accounts.scores.view', $student) }}" 
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> Xem điểm
                                    </a>
                                @endif
                                <button class="btn btn-sm btn-success" 
                                        onclick="createScoresForStudent({{ $student->id }})">
                                    <i class="fas fa-plus"></i> Tạo điểm
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            {{ $students->links() }}
        </div>
    </div>
</div>

<!-- Create Sample Scores Modal -->
<div class="modal fade" id="createSampleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tạo điểm mẫu cho tất cả học sinh</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.student-accounts.scores.create-sample') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        Chức năng này sẽ tạo điểm mẫu ngẫu nhiên cho tất cả học sinh chưa có điểm.
                    </div>
                    
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Lưu ý:</strong> Hệ thống sẽ tự động lấy giáo viên từ thời khóa biểu đã được phân công. 
                        Nếu chưa có thời khóa biểu, vui lòng tạo thời khóa biểu mẫu trước.
                    </div>
                    
                    <div class="mb-3">
                        <label for="year" class="form-label">Năm học</label>
                        <select name="year" id="year" class="form-select">
                            <option value="2024-2025" selected>2024-2025</option>
                            <option value="2023-2024">2023-2024</option>
                            <option value="2025-2026">2025-2026</option>
                        </select>
                    </div>

                    <div class="stats-preview">
                        <p><strong>Sẽ tạo điểm cho:</strong> {{ $stats['students_without_scores'] }} học sinh</p>
                        <p><strong>Số môn học:</strong> 10 môn/học sinh</p>
                        <p><strong>Tổng bản ghi:</strong> {{ $stats['students_without_scores'] * 10 }} bản ghi</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus"></i> Tạo điểm mẫu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
.scores-management {
    padding: 20px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 15px;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: white;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stat-card.success .stat-icon {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.stat-card.warning .stat-icon {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.stat-card.info .stat-icon {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.stat-content h3 {
    margin: 0;
    font-size: 28px;
    font-weight: bold;
    color: #2d3748;
}

.stat-content p {
    margin: 0;
    color: #718096;
    font-size: 14px;
}

.students-table-container {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.table-header {
    margin-bottom: 20px;
}

.badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
}

.badge-success {
    background: #c6f6d5;
    color: #276749;
}

.badge-warning {
    background: #fed7d7;
    color: #c53030;
}

.average-score {
    font-weight: bold;
    color: #2d3748;
    padding: 4px 8px;
    background: #e2e8f0;
    border-radius: 4px;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.status-badge.success {
    background: #c6f6d5;
    color: #276749;
}

.status-badge.warning {
    background: #fed7d7;
    color: #c53030;
}

.action-buttons {
    display: flex;
    gap: 5px;
}

.stats-preview {
    background: #f7fafc;
    padding: 15px;
    border-radius: 8px;
    margin-top: 15px;
}

.stats-preview p {
    margin: 5px 0;
}
</style>
@endpush

@push('scripts')
<script>
function createScoresForStudent(studentId) {
    if (confirm('Bạn có chắc muốn tạo điểm mẫu cho học sinh này?')) {
        // Tạo form và submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.student-accounts.scores.create-sample") }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const studentIdInput = document.createElement('input');
        studentIdInput.type = 'hidden';
        studentIdInput.name = 'student_id';
        studentIdInput.value = studentId;
        
        form.appendChild(csrfToken);
        form.appendChild(studentIdInput);
        document.body.appendChild(form);
        form.submit();
    }
}

function createSampleTimetable() {
    if (confirm('Bạn có chắc muốn tạo thời khóa biểu mẫu? Điều này sẽ tạo phân công giảng dạy cho tất cả các lớp.')) {
        fetch('{{ route("admin.student-accounts.timetable.create-sample") }}')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Thành công: ' + data.message);
                    location.reload();
                } else {
                    alert('Lỗi: ' + (data.error || 'Có lỗi xảy ra'));
                }
            })
            .catch(error => {
                alert('Lỗi: ' + error.message);
            });
    }
}
</script>
@endpush
@endsection