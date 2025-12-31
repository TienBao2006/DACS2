@extends('TeacherPage.TeacherPage')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/teacher-scores.css') }}">
@endpush

@section('content')
<div class="main-content">
    <div class="header">
        <h1><i class="fas fa-clipboard-check"></i> Nhập Điểm</h1>
        <div class="breadcrumb">
            <span>Trang chủ</span> > <span>Danh sách điểm</span> > <span>Nhập điểm</span>
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

        @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
                    </div>
                </div>
            </div>
        </div>

        <!-- Score Input Form -->
        <div class="score-input-container">
            <div class="form-header">
                <h3><i class="fas fa-edit"></i> Nhập điểm cho học sinh</h3>
                <div class="semester-selector">
                    <label for="semester">Học kỳ:</label>
                    <select id="semester" name="semester">
                        <option value="HK1">Học kỳ 1</option>
                        <option value="HK2">Học kỳ 2</option>
                        <option value="HK3">Học kỳ 3</option>
                    </select>
                    <label for="academic_year">Năm học:</label>
                    <select id="academic_year" name="academic_year">
                        <option value="2024-2025">2024-2025</option>
                        <option value="2025-2026">2025-2026</option>
                    </select>
                </div>
            </div>

            <form id="scoreForm" method="POST" action="{{ route('teacher.save.scores', $student->id) }}">
                @csrf
                <input type="hidden" name="semester" id="form_semester" value="HK1">
                <input type="hidden" name="academic_year" id="form_academic_year" value="{{ $academicYear }}">

                <!-- Subject Selection -->
                <div class="subject-section">
                    <label for="subject_name">Môn học bạn dạy:</label>
                    <select id="subject_name" name="subject_name" required>
                        <option value="">-- Chọn môn học --</option>
                        @foreach($teacherSubjects as $subject)
                            <option value="{{ $subject }}">{{ $subject }}</option>
                        @endforeach
                    </select>
                    <small class="help-text">Chỉ hiển thị các môn bạn được phân công dạy cho lớp {{ $student->lop }}</small>
                </div>

                <!-- Score Input Sections -->
                <div class="score-sections">
                    <!-- Điểm 15 phút -->
                    <div class="score-group">
                        <h4><i class="fas fa-clock"></i> Điểm 15 phút</h4>
                        <div class="score-row">
                            <div class="score-input">
                                <label>Lần 1:</label>
                                <input type="number" name="diem_15phut_1" min="0" max="10" step="0.1" placeholder="0.0">
                            </div>
                            <div class="score-input">
                                <label>Lần 2:</label>
                                <input type="number" name="diem_15phut_2" min="0" max="10" step="0.1" placeholder="0.0">
                            </div>
                            <div class="score-input">
                                <label>Lần 3:</label>
                                <input type="number" name="diem_15phut_3" min="0" max="10" step="0.1" placeholder="0.0">
                            </div>
                            <div class="score-input">
                                <label>Lần 4:</label>
                                <input type="number" name="diem_15phut_4" min="0" max="10" step="0.1" placeholder="0.0">
                            </div>
                        </div>
                    </div>

                    <!-- Điểm miệng -->
                    <div class="score-group">
                        <h4><i class="fas fa-microphone"></i> Điểm miệng</h4>
                        <div class="score-row">
                            <div class="score-input">
                                <label>Lần 1:</label>
                                <input type="number" name="diem_mieng_1" min="0" max="10" step="0.1" placeholder="0.0">
                            </div>
                            <div class="score-input">
                                <label>Lần 2:</label>
                                <input type="number" name="diem_mieng_2" min="0" max="10" step="0.1" placeholder="0.0">
                            </div>
                            <div class="score-input">
                                <label>Lần 3:</label>
                                <input type="number" name="diem_mieng_3" min="0" max="10" step="0.1" placeholder="0.0">
                            </div>
                            <div class="score-input">
                                <label>Lần 4:</label>
                                <input type="number" name="diem_mieng_4" min="0" max="10" step="0.1" placeholder="0.0">
                            </div>
                        </div>
                    </div>

                    <!-- Điểm giữa kỳ và cuối kỳ -->
                    <div class="score-group">
                        <h4><i class="fas fa-file-alt"></i> Điểm kiểm tra</h4>
                        <div class="score-row">
                            <div class="score-input large">
                                <label>Điểm giữa kỳ:</label>
                                <input type="number" name="diem_giua_ky" min="0" max="10" step="0.1" placeholder="0.0">
                            </div>
                            <div class="score-input large">
                                <label>Điểm cuối kỳ:</label>
                                <input type="number" name="diem_cuoi_ky" min="0" max="10" step="0.1" placeholder="0.0">
                            </div>
                        </div>
                    </div>

                    <!-- Điểm tổng kết -->
                    <div class="score-group">
                        <h4><i class="fas fa-calculator"></i> Điểm tổng kết</h4>
                        <div class="score-row">
                            <div class="score-input large">
                                <label>Điểm tổng kết:</label>
                                <input type="number" name="diem_tong_ket" min="0" max="10" step="0.1" placeholder="0.0" readonly>
                                <small>Điểm này sẽ được tính tự động</small>
                            </div>
                        </div>
                    </div>

                    <!-- Ghi chú -->
                    <div class="score-group">
                        <h4><i class="fas fa-sticky-note"></i> Ghi chú</h4>
                        <textarea name="ghi_chu" rows="3" placeholder="Nhập ghi chú (nếu có)..."></textarea>
                    </div>
                </div>

                <!-- Score Summary -->
                <div class="score-summary" id="scoreSummary" style="display: none;">
                    <h4><i class="fas fa-chart-line"></i> Tóm tắt điểm</h4>
                    <div class="summary-content">
                        <div class="summary-item">
                            <span>Điểm 15 phút trung bình:</span>
                            <span id="avg15phut">-</span>
                        </div>
                        <div class="summary-item">
                            <span>Điểm miệng trung bình:</span>
                            <span id="avgMieng">-</span>
                        </div>
                        <div class="summary-item">
                            <span>Điểm giữa kỳ:</span>
                            <span id="diemGiuaKy">-</span>
                        </div>
                        <div class="summary-item">
                            <span>Điểm cuối kỳ:</span>
                            <span id="diemCuoiKy">-</span>
                        </div>
                        <div class="summary-item total">
                            <span><strong>Điểm tổng kết:</strong></span>
                            <span id="diemTongKet"><strong>-</strong></span>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="calculateTotal()">
                        <i class="fas fa-calculator"></i> Tính điểm tổng kết
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu điểm
                    </button>
                    <a href="{{ route('teacher.list.point') }}" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
// Existing scores data
const existingScores = @json($existingScores ?? []);

// Load existing scores when subject is selected
document.getElementById('subject_name').addEventListener('change', function() {
    const selectedSubject = this.value;
    const semester = document.getElementById('semester').value;
    
    // Clear all inputs first
    clearAllInputs();
    
    if (selectedSubject && existingScores[selectedSubject]) {
        const scores = existingScores[selectedSubject];
        
        // Load existing scores
        if (scores.diem_15phut_1) document.querySelector('input[name="diem_15phut_1"]').value = scores.diem_15phut_1;
        if (scores.diem_15phut_2) document.querySelector('input[name="diem_15phut_2"]').value = scores.diem_15phut_2;
        if (scores.diem_15phut_3) document.querySelector('input[name="diem_15phut_3"]').value = scores.diem_15phut_3;
        if (scores.diem_15phut_4) document.querySelector('input[name="diem_15phut_4"]').value = scores.diem_15phut_4;
        
        if (scores.diem_mieng_1) document.querySelector('input[name="diem_mieng_1"]').value = scores.diem_mieng_1;
        if (scores.diem_mieng_2) document.querySelector('input[name="diem_mieng_2"]').value = scores.diem_mieng_2;
        if (scores.diem_mieng_3) document.querySelector('input[name="diem_mieng_3"]').value = scores.diem_mieng_3;
        if (scores.diem_mieng_4) document.querySelector('input[name="diem_mieng_4"]').value = scores.diem_mieng_4;
        
        if (scores.diem_giua_ky) document.querySelector('input[name="diem_giua_ky"]').value = scores.diem_giua_ky;
        if (scores.diem_cuoi_ky) document.querySelector('input[name="diem_cuoi_ky"]').value = scores.diem_cuoi_ky;
        if (scores.diem_tong_ket) document.querySelector('input[name="diem_tong_ket"]').value = scores.diem_tong_ket;
        if (scores.ghi_chu) document.querySelector('textarea[name="ghi_chu"]').value = scores.ghi_chu;
        
        // Recalculate total
        calculateTotal();
    }
    
    // Subject is already selected in the dropdown, no need for hidden field
});

function clearAllInputs() {
    const inputs = document.querySelectorAll('input[type="number"], textarea');
    inputs.forEach(input => {
        if (input.name !== 'diem_tong_ket') { // Don't clear calculated field
            input.value = '';
        }
    });
}

// Update hidden form fields when selectors change
document.getElementById('semester').addEventListener('change', function() {
    document.getElementById('form_semester').value = this.value;
});

document.getElementById('academic_year').addEventListener('change', function() {
    document.getElementById('form_academic_year').value = this.value;
});

// Calculate total score
function calculateTotal() {
    // Get all score inputs
    const diem15phut = [
        parseFloat(document.querySelector('input[name="diem_15phut_1"]').value) || 0,
        parseFloat(document.querySelector('input[name="diem_15phut_2"]').value) || 0,
        parseFloat(document.querySelector('input[name="diem_15phut_3"]').value) || 0,
        parseFloat(document.querySelector('input[name="diem_15phut_4"]').value) || 0
    ].filter(score => score > 0);

    const diemMieng = [
        parseFloat(document.querySelector('input[name="diem_mieng_1"]').value) || 0,
        parseFloat(document.querySelector('input[name="diem_mieng_2"]').value) || 0,
        parseFloat(document.querySelector('input[name="diem_mieng_3"]').value) || 0,
        parseFloat(document.querySelector('input[name="diem_mieng_4"]').value) || 0
    ].filter(score => score > 0);

    const diemGiuaKy = parseFloat(document.querySelector('input[name="diem_giua_ky"]').value) || 0;
    const diemCuoiKy = parseFloat(document.querySelector('input[name="diem_cuoi_ky"]').value) || 0;

    // Calculate averages
    const avg15phut = diem15phut.length > 0 ? diem15phut.reduce((a, b) => a + b, 0) / diem15phut.length : 0;
    const avgMieng = diemMieng.length > 0 ? diemMieng.reduce((a, b) => a + b, 0) / diemMieng.length : 0;

    // Calculate total score (Vietnamese grading system)
    // Formula: (Điểm 15p + Điểm miệng + Điểm giữa kỳ*2 + Điểm cuối kỳ*3) / 7
    let totalScore = 0;
    let weightSum = 0;

    if (avg15phut > 0) {
        totalScore += avg15phut * 1;
        weightSum += 1;
    }
    if (avgMieng > 0) {
        totalScore += avgMieng * 1;
        weightSum += 1;
    }
    if (diemGiuaKy > 0) {
        totalScore += diemGiuaKy * 2;
        weightSum += 2;
    }
    if (diemCuoiKy > 0) {
        totalScore += diemCuoiKy * 3;
        weightSum += 3;
    }

    const finalScore = weightSum > 0 ? (totalScore / weightSum).toFixed(1) : 0;
    document.querySelector('input[name="diem_tong_ket"]').value = finalScore;
    
    // Update summary
    document.getElementById('avg15phut').textContent = avg15phut > 0 ? avg15phut.toFixed(1) : '-';
    document.getElementById('avgMieng').textContent = avgMieng > 0 ? avgMieng.toFixed(1) : '-';
    document.getElementById('diemGiuaKy').textContent = diemGiuaKy > 0 ? diemGiuaKy.toFixed(1) : '-';
    document.getElementById('diemCuoiKy').textContent = diemCuoiKy > 0 ? diemCuoiKy.toFixed(1) : '-';
    document.getElementById('diemTongKet').textContent = finalScore > 0 ? finalScore : '-';
    
    // Show summary if there are scores
    const summaryDiv = document.getElementById('scoreSummary');
    if (weightSum > 0) {
        summaryDiv.style.display = 'block';
    } else {
        summaryDiv.style.display = 'none';
    }
}

// Auto-calculate when any score input changes
document.querySelectorAll('input[type="number"]').forEach(input => {
    input.addEventListener('input', calculateTotal);
});

// Form submission validation and loading
document.getElementById('scoreForm').addEventListener('submit', function(e) {
    const subjectName = document.getElementById('subject_name').value;
    if (!subjectName) {
        e.preventDefault();
        alert('Vui lòng chọn môn học trước khi lưu điểm!');
        return false;
    }
    
    // Get final score for confirmation
    const finalScore = document.querySelector('input[name="diem_tong_ket"]').value;
    const studentName = '{{ $student->ho_va_ten }}';
    
    // Show confirmation dialog
    const confirmMessage = `Bạn có chắc chắn muốn lưu điểm môn ${subjectName} cho học sinh ${studentName}?\n\nĐiểm tổng kết: ${finalScore || 'Chưa tính'}`;
    
    if (!confirm(confirmMessage)) {
        e.preventDefault();
        return false;
    }
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang lưu...';
    submitBtn.disabled = true;
    
    // Re-enable button after 10 seconds (in case of error)
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 10000);
    
    console.log('Form submitted with subject:', subjectName);
    console.log('Form action:', this.action);
});
</script>
@endsection