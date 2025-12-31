@extends('Admin.pageAdmin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-timetable-new.css') }}">
@endpush

@section('content')
<div class="timetable-container">
    <!-- Header -->
    <div class="page-header">
        <h1><i class="fas fa-calendar-alt"></i> Quản lý Thời khóa biểu</h1>
        <p>Xem và quản lý lịch học của các lớp trong trường</p>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <!-- Stats Section -->
    @if($selectedClass)
        <div class="stats-section">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">{{ $scheduleCount }}</div>
                    <div class="stat-label">Tiết học</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $classes->count() }}</div>
                    <div class="stat-label">Tổng lớp</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $selectedClass }}</div>
                    <div class="stat-label">Lớp hiện tại</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $selectedYear }}</div>
                    <div class="stat-label">Năm học</div>
                </div>
            </div>
        </div>
    @endif

    <!-- Filter Section -->
    <div class="filter-section">
        <form method="GET" action="{{ route('admin.timetable.index') }}">
            <div class="filter-row">
                <div class="filter-group">
                    <label><i class="fas fa-school"></i> Lớp học</label>
                    <select name="lop" class="form-select" onchange="this.form.submit()">
                        <option value="">Chọn lớp học...</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->lop }}" {{ $selectedClass == $class->lop ? 'selected' : '' }}>
                                Lớp {{ $class->lop }} (Khối {{ $class->khoi }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label><i class="fas fa-calendar-alt"></i> Năm học</label>
                    <select name="nam_hoc" class="form-select" onchange="this.form.submit()">
                        <option value="2024-2025" {{ $selectedYear == '2024-2025' ? 'selected' : '' }}>2024-2025</option>
                        <option value="2025-2026" {{ $selectedYear == '2025-2026' ? 'selected' : '' }}>2025-2026</option>
                        <option value="2023-2024" {{ $selectedYear == '2023-2024' ? 'selected' : '' }}>2023-2024</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label><i class="fas fa-book-open"></i> Học kỳ</label>
                    <select name="hoc_ky" class="form-select" onchange="this.form.submit()">
                        <option value="1" {{ $selectedSemester == '1' ? 'selected' : '' }}>Học kỳ I</option>
                        <option value="2" {{ $selectedSemester == '2' ? 'selected' : '' }}>Học kỳ II</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label style="opacity: 0;">Actions</label>
                    <div>
                        <a href="{{ route('admin.timetable.create-weekly') }}" class="btn btn-success">
                            <i class="fas fa-plus-circle"></i> Tạo thời khóa biểu
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @if($selectedClass)
        <!-- Timetable Grid -->
        <div class="timetable-grid">
            <table class="timetable-table">
                <thead>
                    <tr>
                        <th class="time-header">Tiết / Thứ</th>
                        <th class="day-header">Thứ Hai</th>
                        <th class="day-header">Thứ Ba</th>
                        <th class="day-header">Thứ Tư</th>
                        <th class="day-header">Thứ Năm</th>
                        <th class="day-header">Thứ Sáu</th>
                        <th class="day-header">Thứ Bảy</th>
                    </tr>
                </thead>
                <tbody>
                    @for($tiet = 1; $tiet <= 10; $tiet++)
                        <tr>
                            <td class="time-header">
                                <strong>Tiết {{ $tiet }}</strong><br>
                                <small>
                                    @php
                                        $times = [
                                            1 => '7:00-7:45', 2 => '7:45-8:30', 3 => '8:30-9:15',
                                            4 => '9:30-10:15', 5 => '10:15-11:00', 6 => '13:00-13:45',
                                            7 => '13:45-14:30', 8 => '14:30-15:15', 9 => '15:30-16:15', 10 => '16:15-17:00'
                                        ];
                                        echo $times[$tiet] ?? '';
                                    @endphp
                                </small>
                            </td>
                            @for($thu = '2'; $thu <= '7'; $thu++)
                                <td class="schedule-cell">
                                    @if(isset($timetable[$thu][$tiet]))
                                        @php $schedule = $timetable[$thu][$tiet]; @endphp
                                        <div class="schedule-item" onclick="editSchedule({{ $schedule->id }})">
                                            <div class="subject-name">{{ $schedule->mon_hoc }}</div>
                                            @if($schedule->ten_giao_vien)
                                                <div class="teacher-name">{{ $schedule->ten_giao_vien }}</div>
                                            @endif
                                            @if($schedule->phong_hoc)
                                                <div class="room-name">P.{{ $schedule->phong_hoc }}</div>
                                            @endif
                                            <div class="actions">
                                                <button class="btn-edit" onclick="event.stopPropagation(); editSchedule({{ $schedule->id }})" title="Sửa">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn-delete" onclick="event.stopPropagation(); deleteSchedule({{ $schedule->id }})" title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        <div class="empty-cell" onclick="addSchedule('{{ $selectedClass }}', '{{ $thu }}', {{ $tiet }})">
                                            <i class="fas fa-plus"></i> Thêm môn
                                        </div>
                                    @endif
                                </td>
                            @endfor
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    @else
        <!-- No Class Selected -->
        <div class="no-class-selected">
            <i class="fas fa-calendar-times"></i>
            <h3>Chọn lớp để xem thời khóa biểu</h3>
            <p>Vui lòng chọn lớp học từ bộ lọc ở trên để hiển thị thời khóa biểu chi tiết của lớp đó</p>
            <div>
                <a href="{{ route('admin.timetable.create-weekly') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i> Tạo thời khóa biểu mới
                </a>
                <a href="{{ route('admin.class.assignment') }}" class="btn btn-primary">
                    <i class="fas fa-chalkboard-teacher"></i> Quản lý phân công
                </a>
            </div>
        </div>
    @endif
</div>

<script>
function editSchedule(id) {
    window.location.href = `/admin/timetable/${id}/edit`;
}

function deleteSchedule(id) {
    if (confirm('Bạn có chắc chắn muốn xóa tiết học này?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/timetable/${id}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}

function addSchedule(lop, thu, tiet) {
    window.location.href = '{{ route("admin.timetable.create-weekly") }}';
}
</script>
@endsection