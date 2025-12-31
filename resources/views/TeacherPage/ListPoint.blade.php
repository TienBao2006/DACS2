@extends('TeacherPage.TeacherPage')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/teacher-list-points.css') }}">
@endpush

@section('content')
<div class="main-content">
    <div class="header">
        <h1><i class="fas fa-list-alt"></i> Danh Sách Điểm</h1>
        <div class="breadcrumb">
            <span>Trang chủ</span> > <span>Danh sách điểm</span>
        </div>
    </div>

    <div class="content-wrapper">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        @if(empty($classesBySubject))
            <div class="no-class-message">
                <i class="fas fa-info-circle"></i>
                <h3>Chưa có phân công giảng dạy</h3>
                <p>Bạn chưa được phân công dạy lớp nào. Vui lòng liên hệ với ban giám hiệu để được phân công.</p>
            </div>
        @else
            <!-- Teacher Assignment Info -->
            <div class="assignment-info-card">
                <div class="assignment-header">
                    <div class="assignment-title">
                        <h2><i class="fas fa-chalkboard-teacher"></i> Phân công giảng dạy</h2>
                        <p>Giáo viên: <strong>{{ $teacher->ho_ten }}</strong> - Năm học: <strong>{{ $academicYear }}</strong></p>
                    </div>
                    <div class="assignment-stats">
                        <div class="stat-item">
                            <i class="fas fa-school"></i>
                            <span>{{ count($classesBySubject) }} lớp</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-book"></i>
                            <span>{{ $assignments->count() }} phân công</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-card">
                    <h3><i class="fas fa-filter"></i> Bộ lọc</h3>
                    <form method="GET" action="{{ route('teacher.list.point') }}">
                        <div class="filter-row">
                            <div class="filter-group">
                                <label for="nam_hoc">Năm học:</label>
                                <select name="nam_hoc" id="nam_hoc">
                                    <option value="2024-2025" {{ $academicYear == '2024-2025' ? 'selected' : '' }}>2024-2025</option>
                                    <option value="2025-2026" {{ $academicYear == '2025-2026' ? 'selected' : '' }}>2025-2026</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Lọc
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Classes List -->
            @foreach($classesBySubject as $classKey => $classData)
                <div class="class-container">
                    <div class="class-header-section">
                        <h3><i class="fas fa-school"></i> Lớp {{ $classData['class_name'] }}</h3>
                        <div class="subjects-taught">
                            <span>Môn dạy: </span>
                            @foreach($classData['subjects'] as $subject)
                                <span class="subject-tag">{{ $subject }}</span>
                            @endforeach
                        </div>
                    </div>

                    @if($classData['students']->count() > 0)
                        <div class="table-responsive">
                            <table class="scores-table">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã HS</th>
                                        <th>Họ và tên</th>
                                        <th>Giới tính</th>
                                        <th>Ngày sinh</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($classData['students'] as $index => $student)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $student->ma_hoc_sinh }}</td>
                                            <td class="student-name">
                                                <strong>{{ $student->ho_va_ten }}</strong>
                                            </td>
                                            <td>
                                                <span class="gender-badge {{ $student->gioi_tinh == 'Nam' ? 'male' : 'female' }}">
                                                    {{ $student->gioi_tinh }}
                                                </span>
                                            </td>
                                            <td>{{ date('d/m/Y', strtotime($student->ngay_sinh)) }}</td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="{{ route('teacher.view.student.scores', $student->id) }}?nam_hoc={{ $academicYear }}" 
                                                       class="btn btn-sm btn-info" 
                                                       title="Xem chi tiết điểm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('teacher.input.scores', $student->id) }}?nam_hoc={{ $academicYear }}" 
                                                       class="btn btn-sm btn-primary" 
                                                       title="Nhập điểm">
                                                        <i class="fas fa-edit"></i> Nhập điểm
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Class Statistics -->
                        <div class="class-stats-summary">
                            <div class="stat-item">
                                <span class="stat-label">Tổng số học sinh:</span>
                                <span class="stat-value">{{ $classData['students']->count() }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Môn dạy:</span>
                                <span class="stat-value">{{ count($classData['subjects']) }}</span>
                            </div>
                        </div>
                    @else
                        <div class="no-students">
                            <i class="fas fa-user-slash"></i>
                            <p>Lớp {{ $classData['class_name'] }} chưa có học sinh nào.</p>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</div>



<script>
function applyFilter() {
    const semester = document.getElementById('semester').value;
    const academicYear = document.getElementById('academic_year').value;
    const subject = document.getElementById('subject_filter').value;
    
    // Implement filter logic here
    console.log('Filter applied:', { semester, academicYear, subject });
    alert('Chức năng lọc đang được phát triển');
}

function exportExcel() {
    alert('Chức năng xuất Excel đang được phát triển');
}

function printScores() {
    window.print();
}

function inputScores(studentId) {
    // Redirect to input scores page
    window.location.href = `/teacher/input-scores/${studentId}`;
}
</script>
@endsection