@extends('TeacherPage.TeacherPage')

@section('title', 'Nhập điểm')

@section('content')
<div class="input-scores-container">
    <div class="page-header">
        <h1><i class="fas fa-edit"></i> Nhập điểm học sinh</h1>
    </div>

    <!-- Thông tin giáo viên -->
    <div class="teacher-info-card">
        <div class="info-item">
            <strong>Giáo viên:</strong> {{ $teacher->ho_ten }}
        </div>
        <div class="info-item">
            <strong>Mã GV:</strong> {{ $teacher->ma_giao_vien }}
        </div>
    </div>

    <!-- Chọn lớp và môn học -->
    <div class="selection-card">
        <form method="GET" action="{{ route('teacher.input-scores') }}">
            <div class="row">
                <div class="col-md-4">
                    <label for="lop" class="form-label">Chọn lớp</label>
                    <select name="lop" id="lop" class="form-select" required onchange="this.form.submit()">
                        <option value="">-- Chọn lớp --</option>
                        @foreach($assignedClasses as $class)
                            <option value="{{ $class->lop }}" {{ request('lop') == $class->lop ? 'selected' : '' }}>
                                {{ $class->lop }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="mon_hoc" class="form-label">Chọn môn học</label>
                    <select name="mon_hoc" id="mon_hoc" class="form-select" required onchange="this.form.submit()">
                        <option value="">-- Chọn môn học --</option>
                        @if(request('lop'))
                            @foreach($assignedSubjects as $subject)
                                <option value="{{ $subject }}" {{ request('mon_hoc') == $subject ? 'selected' : '' }}>
                                    {{ $subjectNames[$subject] ?? $subject }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="nam_hoc" class="form-label">Năm học</label>
                    <select name="nam_hoc" id="nam_hoc" class="form-select" onchange="this.form.submit()">
                        <option value="2024-2025" {{ request('nam_hoc', '2024-2025') == '2024-2025' ? 'selected' : '' }}>2024-2025</option>
                        <option value="2023-2024" {{ request('nam_hoc') == '2023-2024' ? 'selected' : '' }}>2023-2024</option>
                    </select>
                </div>
            </div>
        </form>
    </div>

    @if(request('lop') && request('mon_hoc'))
        <!-- Danh sách học sinh -->
        <div class="students-table-card">
            <div class="table-header">
                <h3>
                    <i class="fas fa-users"></i> 
                    Danh sách học sinh lớp {{ request('lop') }} - Môn {{ $subjectNames[request('mon_hoc')] ?? request('mon_hoc') }}
                </h3>
                <div class="header-actions">
                    <button class="btn btn-success" onclick="saveAllScores()">
                        <i class="fas fa-save"></i> Lưu tất cả
                    </button>
                </div>
            </div>

            <form id="scoresForm" method="POST" action="{{ route('teacher.save-scores') }}">
                @csrf
                <input type="hidden" name="lop" value="{{ request('lop') }}">
                <input type="hidden" name="mon_hoc" value="{{ request('mon_hoc') }}">
                <input type="hidden" name="nam_hoc" value="{{ request('nam_hoc', '2024-2025') }}">

                <div class="table-responsive">
                    <table class="scores-table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã HS</th>
                                <th>Họ và tên</th>
                                <th>Miệng 1</th>
                                <th>Miệng 2</th>
                                <th>Miệng 3</th>
                                <th>15 phút 1</th>
                                <th>15 phút 2</th>
                                <th>Giữa kỳ</th>
                                <th>Cuối kỳ</th>
                                <th>TB</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $index => $student)
                                @php
                                    $score = $student->scores()
                                        ->where('mon_hoc', request('mon_hoc'))
                                        ->where('nam_hoc', request('nam_hoc', '2024-2025'))
                                        ->first();
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $student->ma_hoc_sinh }}</td>
                                    <td class="student-name">{{ $student->ho_va_ten }}</td>
                                    <td>
                                        <input type="number" 
                                               name="scores[{{ $student->id }}][diem_mieng_1]" 
                                               class="form-control score-input"
                                               min="0" max="10" step="0.1"
                                               value="{{ $score->diem_mieng_1 ?? '' }}"
                                               onchange="calculateAverage({{ $student->id }})">
                                    </td>
                                    <td>
                                        <input type="number" 
                                               name="scores[{{ $student->id }}][diem_mieng_2]" 
                                               class="form-control score-input"
                                               min="0" max="10" step="0.1"
                                               value="{{ $score->diem_mieng_2 ?? '' }}"
                                               onchange="calculateAverage({{ $student->id }})">
                                    </td>
                                    <td>
                                        <input type="number" 
                                               name="scores[{{ $student->id }}][diem_mieng_3]" 
                                               class="form-control score-input"
                                               min="0" max="10" step="0.1"
                                               value="{{ $score->diem_mieng_3 ?? '' }}"
                                               onchange="calculateAverage({{ $student->id }})">
                                    </td>
                                    <td>
                                        <input type="number" 
                                               name="scores[{{ $student->id }}][diem_15phut_1]" 
                                               class="form-control score-input"
                                               min="0" max="10" step="0.1"
                                               value="{{ $score->diem_15phut_1 ?? '' }}"
                                               onchange="calculateAverage({{ $student->id }})">
                                    </td>
                                    <td>
                                        <input type="number" 
                                               name="scores[{{ $student->id }}][diem_15phut_2]" 
                                               class="form-control score-input"
                                               min="0" max="10" step="0.1"
                                               value="{{ $score->diem_15phut_2 ?? '' }}"
                                               onchange="calculateAverage({{ $student->id }})">
                                    </td>
                                    <td>
                                        <input type="number" 
                                               name="scores[{{ $student->id }}][diem_giua_ky]" 
                                               class="form-control score-input"
                                               min="0" max="10" step="0.1"
                                               value="{{ $score->diem_giua_ky ?? '' }}"
                                               onchange="calculateAverage({{ $student->id }})">
                                    </td>
                                    <td>
                                        <input type="number" 
                                               name="scores[{{ $student->id }}][diem_cuoi_ky]" 
                                               class="form-control score-input"
                                               min="0" max="10" step="0.1"
                                               value="{{ $score->diem_cuoi_ky ?? '' }}"
                                               onchange="calculateAverage({{ $student->id }})">
                                    </td>
                                    <td>
                                        <span id="avg_{{ $student->id }}" class="average-display">
                                            {{ $score->diem_tong_ket ?? '-' }}
                                        </span>
                                        <input type="hidden" 
                                               name="scores[{{ $student->id }}][diem_tong_ket]" 
                                               id="avg_input_{{ $student->id }}"
                                               value="{{ $score->diem_tong_ket ?? '' }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-clipboard-list"></i>
            <h3>Vui lòng chọn lớp và môn học</h3>
            <p>Chọn lớp và môn học để bắt đầu nhập điểm cho học sinh</p>
        </div>
    @endif
</div>

@endsection

.teacher-info-card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 20px;
    display: flex;
    gap: 30px;
}

.info-item {
    font-size: 16px;
}

.selection-card {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.students-table-card {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.scores-table {
    width: 100%;
    border-collapse: collapse;
}

.scores-table th,
.scores-table td {
    padding: 10px;
    text-align: center;
    border: 1px solid #e2e8f0;
}

.scores-table th {
    background: #f7fafc;
    font-weight: 600;
    color: #2d3748;
}

.student-name {
    text-align: left !important;
    font-weight: 500;
}

.score-input {
    width: 70px;
    text-align: center;
    padding: 5px;
}

.average-display {
    font-weight: bold;
    color: #667eea;
    font-size: 16px;
}

.empty-state {
    background: white;
    padding: 60px 40px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    text-align: center;
}

.empty-state i {
    font-size: 64px;
    color: #cbd5e0;
    margin-bottom: 20px;
}

.empty-state h3 {
    color: #4a5568;
    margin-bottom: 10px;
}

.empty-state p {
    color: #718096;
}
</style>
@endpush

@push('scripts')
<script>
function calculateAverage(studentId) {
    const mieng1 = parseFloat(document.querySelector(`input[name="scores[${studentId}][diem_mieng_1]"]`).value) || 0;
    const mieng2 = parseFloat(document.querySelector(`input[name="scores[${studentId}][diem_mieng_2]"]`).value) || 0;
    const mieng3 = parseFloat(document.querySelector(`input[name="scores[${studentId}][diem_mieng_3]"]`).value) || 0;
    const p15_1 = parseFloat(document.querySelector(`input[name="scores[${studentId}][diem_15phut_1]"]`).value) || 0;
    const p15_2 = parseFloat(document.querySelector(`input[name="scores[${studentId}][diem_15phut_2]"]`).value) || 0;
    const giuaKy = parseFloat(document.querySelector(`input[name="scores[${studentId}][diem_giua_ky]"]`).value) || 0;
    const cuoiKy = parseFloat(document.querySelector(`input[name="scores[${studentId}][diem_cuoi_ky]"]`).value) || 0;
    
    // Tính trung bình: (miệng*2 + 15p + GK*2 + CK*3) / 8
    const avgMieng = (mieng1 + mieng2 + mieng3) / 3;
    const avg15p = (p15_1 + p15_2) / 2;
    const average = (avgMieng * 2 + avg15p + giuaKy * 2 + cuoiKy * 3) / 8;
    
    const roundedAvg = Math.round(average * 10) / 10;
    
    document.getElementById(`avg_${studentId}`).textContent = roundedAvg || '-';
    document.getElementById(`avg_input_${studentId}`).value = roundedAvg || '';
}

function saveAllScores() {
    if (confirm('Bạn có chắc muốn lưu tất cả điểm đã nhập?')) {
        document.getElementById('scoresForm').submit();
    }
}
</script>
@endpush
@endsection