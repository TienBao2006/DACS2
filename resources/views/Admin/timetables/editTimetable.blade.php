@extends('Admin.pageAdmin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-edit-timetable.css') }}">
@endpush

@section('content')
<div class="edit-container">
    <div class="edit-card">
        <div class="card-header">
            <h2><i class="fas fa-edit"></i> Chỉnh sửa tiết học</h2>
            <p>Cập nhật thông tin tiết học trong thời khóa biểu</p>
        </div>
        
        <div class="card-body">
            <!-- Schedule Info -->
            <div class="schedule-info">
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Lớp học</div>
                        <div class="info-value">{{ $schedule->lop }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Thứ</div>
                        <div class="info-value">
                            @php
                                $dayNames = [
                                    '2' => 'Thứ Hai',
                                    '3' => 'Thứ Ba',
                                    '4' => 'Thứ Tư',
                                    '5' => 'Thứ Năm',
                                    '6' => 'Thứ Sáu',
                                    '7' => 'Thứ Bảy'
                                ];
                                echo $dayNames[$schedule->thu] ?? 'N/A';
                            @endphp
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Tiết</div>
                        <div class="info-value">Tiết {{ $schedule->tiet }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Năm học</div>
                        <div class="info-value">{{ $schedule->nam_hoc }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Học kỳ</div>
                        <div class="info-value">Học kỳ {{ $schedule->hoc_ky }}</div>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <form method="POST" action="{{ route('admin.timetable.update', $schedule->id) }}">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label class="form-label" for="mon_hoc">
                        <i class="fas fa-book"></i> Môn học *
                    </label>
                    <select name="mon_hoc" id="mon_hoc" class="form-control" required>
                        <option value="">Chọn môn học</option>
                        @php
                            $subjects = [
                                'Toán', 'Ngữ văn', 'Tiếng Anh', 'Vật lý', 'Hóa học', 'Sinh học',
                                'Lịch sử', 'Địa lý', 'GDCD', 'Tin học', 'Thể dục',
                                'Công nghệ', 'Âm nhạc', 'Mỹ thuật', 'Hoạt động trải nghiệm',
                                'Giáo dục quốc phòng', 'Giáo dục kinh tế và pháp luật'
                            ];
                        @endphp
                        @foreach($subjects as $subject)
                            <option value="{{ $subject }}" {{ $schedule->mon_hoc == $subject ? 'selected' : '' }}>
                                {{ $subject }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="ma_giao_vien">
                        <i class="fas fa-chalkboard-teacher"></i> Giáo viên
                    </label>
                    <select name="ma_giao_vien" id="ma_giao_vien" class="form-control">
                        <option value="">Chọn giáo viên</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->ma_giao_vien }}" 
                                    data-name="{{ $teacher->ho_ten }}"
                                    {{ $schedule->ma_giao_vien == $teacher->ma_giao_vien ? 'selected' : '' }}>
                                {{ $teacher->ho_ten }} - {{ $teacher->mon_day }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="ten_giao_vien" id="ten_giao_vien" value="{{ $schedule->ten_giao_vien }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="phong_hoc">
                        <i class="fas fa-door-open"></i> Phòng học
                    </label>
                    <input type="text" name="phong_hoc" id="phong_hoc" class="form-control" 
                           value="{{ $schedule->phong_hoc }}" placeholder="Ví dụ: A101, B205...">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Lưu thay đổi
                    </button>
                    <a href="{{ route('admin.timetable.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('ma_giao_vien').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const teacherName = selectedOption.getAttribute('data-name') || '';
    document.getElementById('ten_giao_vien').value = teacherName;
});
</script>
@endsection