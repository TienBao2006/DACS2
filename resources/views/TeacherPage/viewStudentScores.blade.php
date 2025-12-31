@extends('TeacherPage.TeacherPage')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/teacher-view-scores.css') }}">
@endpush

@section('content')
<div class="main-content">
    <div class="header">
        <h1><i class="fas fa-user-graduate"></i> Chi Tiết Điểm Học Sinh</h1>
        <div class="breadcrumb">
            <span>Trang chủ</span> > <span>Danh sách điểm</span> > <span>Chi tiết</span>
        </div>
    </div>

    <div class="content-wrapper">
        <!-- Student Info Card -->
        <div class="student-info-card">
            <div class="student-header">
                <div class="student-avatar">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="student-details">
                    <h2>{{ $student->ho_va_ten }}</h2>
                    <div class="student-meta">
                        <span><i class="fas fa-id-card"></i> {{ $student->ma_hoc_sinh }}</span>
                        <span><i class="fas fa-graduation-cap"></i> Lớp {{ $student->lop }}</span>
                        <span><i class="fas fa-calendar"></i> {{ date('d/m/Y', strtotime($student->ngay_sinh)) }}</span>
                        <span><i class="fas fa-venus-mars"></i> {{ $student->gioi_tinh }}</span>
                    </div>
                </div>
                <div class="action-buttons">
                    <a href="{{ route('teacher.list.point') }}" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>

        <!-- Semester Selector -->
        <div class="semester-selector-card">
            <div class="selector-header">
                <h3><i class="fas fa-calendar-alt"></i> Chọn học kỳ</h3>
            </div>
            <div class="selector-content">
                <div class="semester-tabs">
                    <button class="tab-btn active" data-semester="HK1">Học kỳ 1</button>
                    <button class="tab-btn" data-semester="HK2">Học kỳ 2</button>
                    <button class="tab-btn" data-semester="HK3">Học kỳ 3</button>
                </div>
                <div class="year-selector">
                    <select id="academic_year">
                        <option value="2024-2025">Năm học 2024-2025</option>
                        <option value="2025-2026">Năm học 2025-2026</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Scores Detail -->
        <div class="scores-detail-container">
            <div class="scores-header">
                <h3><i class="fas fa-chart-line"></i> Bảng điểm chi tiết</h3>
                <div class="scores-actions">
                    <button class="btn btn-primary" onclick="printReport()">
                        <i class="fas fa-print"></i> In phiếu điểm
                    </button>
                </div>
            </div>

            <div class="subjects-grid">
                @foreach($subjects as $subjectName)
                    @php
                        $subjectScore = $studentScores[$subjectName] ?? null;
                    @endphp
                    <div class="subject-card">
                        <div class="subject-header">
                            <h4>{{ $subjectName }}</h4>
                            <div class="subject-average">
                                <span class="average-label">TB:</span>
                                <span class="average-score">
                                    {{ $subjectScore && $subjectScore->diem_tong_ket ? number_format($subjectScore->diem_tong_ket, 1) : '--' }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="scores-breakdown">
                            <div class="score-category">
                                <h5>Điểm 15 phút</h5>
                                <div class="scores-row">
                                    <div class="score-item">
                                        <span class="score-label">Lần 1:</span>
                                        <span class="score-value">
                                            {{ $subjectScore && $subjectScore->diem_15phut_1 ? number_format($subjectScore->diem_15phut_1, 1) : '--' }}
                                        </span>
                                    </div>
                                    <div class="score-item">
                                        <span class="score-label">Lần 2:</span>
                                        <span class="score-value">
                                            {{ $subjectScore && $subjectScore->diem_15phut_2 ? number_format($subjectScore->diem_15phut_2, 1) : '--' }}
                                        </span>
                                    </div>
                                    <div class="score-item">
                                        <span class="score-label">Lần 3:</span>
                                        <span class="score-value">
                                            {{ $subjectScore && $subjectScore->diem_15phut_3 ? number_format($subjectScore->diem_15phut_3, 1) : '--' }}
                                        </span>
                                    </div>
                                    <div class="score-item">
                                        <span class="score-label">Lần 4:</span>
                                        <span class="score-value">
                                            {{ $subjectScore && $subjectScore->diem_15phut_4 ? number_format($subjectScore->diem_15phut_4, 1) : '--' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="score-category">
                                <h5>Điểm miệng</h5>
                                <div class="scores-row">
                                    <div class="score-item">
                                        <span class="score-label">Lần 1:</span>
                                        <span class="score-value">
                                            {{ $subjectScore && $subjectScore->diem_mieng_1 ? number_format($subjectScore->diem_mieng_1, 1) : '--' }}
                                        </span>
                                    </div>
                                    <div class="score-item">
                                        <span class="score-label">Lần 2:</span>
                                        <span class="score-value">
                                            {{ $subjectScore && $subjectScore->diem_mieng_2 ? number_format($subjectScore->diem_mieng_2, 1) : '--' }}
                                        </span>
                                    </div>
                                    <div class="score-item">
                                        <span class="score-label">Lần 3:</span>
                                        <span class="score-value">
                                            {{ $subjectScore && $subjectScore->diem_mieng_3 ? number_format($subjectScore->diem_mieng_3, 1) : '--' }}
                                        </span>
                                    </div>
                                    <div class="score-item">
                                        <span class="score-label">Lần 4:</span>
                                        <span class="score-value">
                                            {{ $subjectScore && $subjectScore->diem_mieng_4 ? number_format($subjectScore->diem_mieng_4, 1) : '--' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="score-category">
                                <h5>Điểm kiểm tra</h5>
                                <div class="scores-row">
                                    <div class="score-item large">
                                        <span class="score-label">Giữa kỳ:</span>
                                        <span class="score-value">
                                            {{ $subjectScore && $subjectScore->diem_giua_ky ? number_format($subjectScore->diem_giua_ky, 1) : '--' }}
                                        </span>
                                    </div>
                                    <div class="score-item large">
                                        <span class="score-label">Cuối kỳ:</span>
                                        <span class="score-value">
                                            {{ $subjectScore && $subjectScore->diem_cuoi_ky ? number_format($subjectScore->diem_cuoi_ky, 1) : '--' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="score-category final">
                                <h5>Điểm tổng kết</h5>
                                <div class="final-score">
                                    <span class="final-value {{ $subjectScore && $subjectScore->diem_tong_ket >= 8 ? 'excellent' : ($subjectScore && $subjectScore->diem_tong_ket >= 6.5 ? 'good' : ($subjectScore && $subjectScore->diem_tong_ket >= 5 ? 'average' : 'poor')) }}">
                                        {{ $subjectScore && $subjectScore->diem_tong_ket ? number_format($subjectScore->diem_tong_ket, 1) : '--' }}
                                    </span>
                                </div>
                            </div>

                            @if($subjectScore && $subjectScore->ghi_chu)
                                <div class="score-notes">
                                    <h5>Ghi chú</h5>
                                    <p>{{ $subjectScore->ghi_chu }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Overall Summary -->
            <div class="overall-summary">
                <div class="summary-header">
                    <h3><i class="fas fa-trophy"></i> Tổng kết học kỳ {{ $semester }} - {{ $academicYear }}</h3>
                </div>
                <div class="summary-content">
                    <div class="summary-stats">
                        <div class="stat-item">
                            <span class="stat-label">Điểm trung bình chung:</span>
                            <span class="stat-value {{ $statistics['average_score'] >= 8 ? 'excellent' : ($statistics['average_score'] >= 6.5 ? 'good' : ($statistics['average_score'] >= 5 ? 'average' : 'poor')) }}">
                                {{ $statistics['average_score'] > 0 ? number_format($statistics['average_score'], 2) : '--' }}
                            </span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Xếp loại học lực:</span>
                            <span class="stat-value classification {{ strtolower($statistics['classification']) }}">
                                {{ $statistics['classification'] }}
                            </span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Xếp loại hạnh kiểm:</span>
                            <span class="stat-value conduct">Tốt</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Số môn đạt:</span>
                            <span class="stat-value">{{ $statistics['passed_subjects'] }}/{{ $statistics['subjects_with_scores'] }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Tổng số môn học:</span>
                            <span class="stat-value">{{ $statistics['total_subjects'] }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Số môn đã có điểm:</span>
                            <span class="stat-value">{{ $statistics['subjects_with_scores'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
// Tab switching functionality
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        // Remove active class from all tabs
        document.querySelectorAll('.tab-btn').forEach(tab => tab.classList.remove('active'));
        
        // Add active class to clicked tab
        this.classList.add('active');
        
        // Get semester value
        const semester = this.dataset.semester;
        
        // Load scores for selected semester
        loadScoresForSemester(semester);
    });
});

function loadScoresForSemester(semester) {
    // Implement AJAX call to load scores for specific semester
    console.log('Loading scores for semester:', semester);
    // This would typically make an AJAX request to get scores data
}

function printReport() {
    window.print();
}

// Academic year change handler
document.getElementById('academic_year').addEventListener('change', function() {
    const year = this.value;
    const activeSemester = document.querySelector('.tab-btn.active').dataset.semester;
    loadScoresForSemester(activeSemester);
});
</script>
@endsection