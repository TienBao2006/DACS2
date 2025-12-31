@extends('Admin.pageAdmin')

@section('title', 'Chi tiết điểm học sinh')

@section('content')
<div class="student-scores-detail">
    <div class="page-header">
        <div class="header-left">
            <h1><i class="fas fa-user-graduate"></i> Chi tiết điểm học sinh</h1>
            <div class="student-info">
                <span class="student-name">{{ $student->ho_va_ten }}</span>
                <span class="student-code">{{ $student->ma_hoc_sinh }}</span>
                <span class="student-class">Lớp {{ $student->lop }}</span>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.student-accounts.scores.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    @if($scores->count() > 0)
        <!-- Summary Cards -->
        <div class="summary-grid">
            <div class="summary-card">
                <div class="card-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="card-content">
                    <h3>{{ $student->calculateOverallAverage() }}</h3>
                    <p>Điểm trung bình chung</p>
                </div>
            </div>
            <div class="summary-card">
                <div class="card-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="card-content">
                    <h3>{{ $scores->count() }}</h3>
                    <p>Số môn học</p>
                </div>
            </div>
            <div class="summary-card">
                <div class="card-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="card-content">
                    <h3>{{ $scores->where('diem_tong_ket', '>=', 9)->count() }}</h3>
                    <p>Môn xuất sắc</p>
                </div>
            </div>
            <div class="summary-card">
                <div class="card-icon">
                    <i class="fas fa-medal"></i>
                </div>
                <div class="card-content">
                    <h3>{{ $scores->where('diem_tong_ket', '>=', 8)->where('diem_tong_ket', '<', 9)->count() }}</h3>
                    <p>Môn giỏi</p>
                </div>
            </div>
        </div>

        <!-- Detailed Scores Table -->
        <div class="scores-table-container">
            <div class="table-header">
                <h3><i class="fas fa-table"></i> Bảng điểm chi tiết</h3>
            </div>

            <div class="table-responsive">
                <table class="scores-table">
                    <thead>
                        <tr>
                            <th>Môn học</th>
                            <th>Điểm miệng</th>
                            <th>Điểm 15 phút</th>
                            <th>Điểm giữa kỳ</th>
                            <th>Điểm cuối kỳ</th>
                            <th>Điểm tổng kết</th>
                            <th>Xếp loại</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $subjectNames = [
                                'TOAN' => 'Toán', 'VAN' => 'Ngữ Văn', 'ANH' => 'Tiếng Anh',
                                'LY' => 'Vật Lý', 'HOA' => 'Hóa Học', 'SINH' => 'Sinh Học',
                                'SU' => 'Lịch Sử', 'DIA' => 'Địa Lý', 'GDCD' => 'GDCD', 'TD' => 'Thể Dục'
                            ];
                        @endphp
                        
                        @foreach($scores as $score)
                        <tr>
                            <td class="subject-name">
                                <i class="subject-icon fas fa-book"></i>
                                {{ $subjectNames[$score->mon_hoc] ?? $score->mon_hoc }}
                            </td>
                            <td class="grade-cell">
                                @foreach($score->diem_mieng as $grade)
                                    @if($grade)
                                        <span class="grade-badge">{{ $grade }}</span>
                                    @endif
                                @endforeach
                            </td>
                            <td class="grade-cell">
                                @foreach($score->diem_15p as $grade)
                                    @if($grade)
                                        <span class="grade-badge">{{ $grade }}</span>
                                    @endif
                                @endforeach
                            </td>
                            <td class="grade-cell">
                                @if($score->diem_giua_ky)
                                    <span class="grade-badge semester">{{ $score->diem_giua_ky }}</span>
                                @endif
                            </td>
                            <td class="grade-cell">
                                @if($score->diem_cuoi_ky)
                                    <span class="grade-badge semester">{{ $score->diem_cuoi_ky }}</span>
                                @endif
                            </td>
                            <td class="average-cell">
                                @if($score->diem_tong_ket)
                                    <span class="average-grade {{ $score->diem_tong_ket >= 9 ? 'excellent' : ($score->diem_tong_ket >= 8 ? 'good' : 'average') }}">
                                        {{ $score->diem_tong_ket }}
                                    </span>
                                @endif
                            </td>
                            <td class="classification-cell">
                                <span class="classification {{ strtolower($score->classification) }}">
                                    {{ $score->classification }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Grade Chart -->
        <div class="chart-container">
            <div class="chart-header">
                <h3><i class="fas fa-chart-bar"></i> Biểu đồ điểm số</h3>
            </div>
            <div class="chart-content">
                <canvas id="studentGradeChart" width="400" height="200"></canvas>
            </div>
        </div>
    @else
        <!-- No Scores State -->
        <div class="no-scores-state">
            <div class="no-scores-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <h3>Chưa có điểm</h3>
            <p>Học sinh này chưa có điểm số nào được ghi nhận.</p>
            <button class="btn btn-primary" onclick="createScoresForStudent({{ $student->id }})">
                <i class="fas fa-plus"></i> Tạo điểm mẫu
            </button>
        </div>
    @endif
</div>

@push('styles')
<style>
.student-scores-detail {
    padding: 20px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 30px;
}

.student-info {
    display: flex;
    gap: 15px;
    margin-top: 10px;
}

.student-name {
    font-size: 18px;
    font-weight: bold;
    color: #2d3748;
}

.student-code, .student-class {
    padding: 4px 12px;
    background: #e2e8f0;
    border-radius: 20px;
    font-size: 14px;
    color: #4a5568;
}

.summary-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.summary-card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 15px;
}

.card-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.card-content h3 {
    margin: 0;
    font-size: 24px;
    font-weight: bold;
    color: #2d3748;
}

.card-content p {
    margin: 0;
    color: #718096;
    font-size: 14px;
}

.scores-table-container {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.scores-table {
    width: 100%;
    border-collapse: collapse;
}

.scores-table th,
.scores-table td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #e2e8f0;
}

.scores-table th {
    background: #f7fafc;
    font-weight: 600;
    color: #2d3748;
}

.subject-name {
    text-align: left !important;
    font-weight: 500;
}

.subject-icon {
    margin-right: 8px;
    color: #667eea;
}

.grade-badge {
    display: inline-block;
    padding: 4px 8px;
    margin: 2px;
    background: #e2e8f0;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
}

.grade-badge.semester {
    background: #667eea;
    color: white;
}

.average-grade {
    font-weight: bold;
    font-size: 16px;
    padding: 6px 12px;
    border-radius: 6px;
}

.average-grade.excellent { background: #f093fb; color: white; }
.average-grade.good { background: #4facfe; color: white; }
.average-grade.average { background: #43e97b; color: white; }

.classification {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.classification.xuất.sắc { background: #fed7d7; color: #c53030; }
.classification.giỏi { background: #bee3f8; color: #2b6cb0; }
.classification.khá { background: #c6f6d5; color: #276749; }

.chart-container {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.no-scores-state {
    background: white;
    border-radius: 12px;
    padding: 60px 40px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.no-scores-icon {
    font-size: 64px;
    color: #cbd5e0;
    margin-bottom: 20px;
}

.no-scores-state h3 {
    color: #4a5568;
    margin-bottom: 10px;
}

.no-scores-state p {
    color: #718096;
    margin-bottom: 30px;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
@if($scores->count() > 0)
// Student Grade Chart
const ctx = document.getElementById('studentGradeChart').getContext('2d');

const subjects = @json($scores->pluck('mon_hoc')->map(function($code) {
    $names = [
        'TOAN' => 'Toán', 'VAN' => 'Ngữ Văn', 'ANH' => 'Tiếng Anh',
        'LY' => 'Vật Lý', 'HOA' => 'Hóa Học', 'SINH' => 'Sinh Học',
        'SU' => 'Lịch Sử', 'DIA' => 'Địa Lý', 'GDCD' => 'GDCD', 'TD' => 'Thể Dục'
    ];
    return $names[$code] ?? $code;
}));

const averages = @json($scores->pluck('diem_tong_ket'));

const studentGradeChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: subjects,
        datasets: [{
            label: 'Điểm tổng kết',
            data: averages,
            backgroundColor: 'rgba(102, 126, 234, 0.8)',
            borderColor: 'rgba(102, 126, 234, 1)',
            borderWidth: 2
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
                min: 0,
                max: 10
            }
        }
    }
});
@endif

function createScoresForStudent(studentId) {
    if (confirm('Bạn có chắc muốn tạo điểm mẫu cho học sinh này?')) {
        // Redirect to create sample scores with student ID
        window.location.href = '{{ route("admin.student-accounts.scores.create-sample") }}?student_id=' + studentId;
    }
}
</script>
@endpush
@endsection