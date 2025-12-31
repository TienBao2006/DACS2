@extends('TeacherPage.TeacherPage')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/teacher-timetable.css') }}">
@endpush

<div class="timetable-container">
    <div class="page-header">
        <div class="header-content">
            <div class="header-left">
                <h1><i class="fas fa-calendar-alt"></i> Thời khóa biểu của tôi</h1>
                <p class="subtitle">Xem lịch giảng dạy và thông tin các tiết học</p>
            </div>
            <div class="header-right">
                <div class="academic-info">
                    <span class="academic-year">{{ $academicYear }}</span>
                    <span class="semester">{{ $semester }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $statistics['total_periods'] }}</div>
                <div class="stat-label">Tổng số tiết</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $statistics['subjects'] }}</div>
                <div class="stat-label">Môn học</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $statistics['classes'] }}</div>
                <div class="stat-label">Lớp học</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $statistics['days_teaching'] }}</div>
                <div class="stat-label">Ngày dạy/tuần</div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <form method="GET" action="{{ route('teacher.timetable') }}" class="filter-form">
            <div class="filter-group">
                <label for="nam_hoc">Năm học:</label>
                <select name="nam_hoc" id="nam_hoc" class="form-select">
                    <option value="2024-2025" {{ $academicYear == '2024-2025' ? 'selected' : '' }}>2024-2025</option>
                    <option value="2023-2024" {{ $academicYear == '2023-2024' ? 'selected' : '' }}>2023-2024</option>
                    <option value="2025-2026" {{ $academicYear == '2025-2026' ? 'selected' : '' }}>2025-2026</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="hoc_ky">Học kỳ:</label>
                <select name="hoc_ky" id="hoc_ky" class="form-select">
                    <option value="HK1" {{ $semester == 'HK1' ? 'selected' : '' }}>Học kỳ 1</option>
                    <option value="HK2" {{ $semester == 'HK2' ? 'selected' : '' }}>Học kỳ 2</option>
                </select>
            </div>
            
            <button type="submit" class="btn-filter">
                <i class="fas fa-search"></i> Lọc
            </button>
        </form>
    </div>



    <!-- Timetable Grid -->
    <div class="timetable-wrapper">
        @if($timetable->count() > 0)
            <div class="timetable-grid">
                <table class="timetable-table">
                    <thead>
                        <tr>
                            <th class="period-header">Tiết</th>
                            @foreach($days as $dayNum => $dayName)
                                <th class="day-header">{{ $dayName }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($periods as $period)
                            <tr>
                                <td class="period-cell">
                                    <div class="period-info">
                                        <span class="period-number">{{ $period }}</span>
                                        <span class="period-time">
                                            @php
                                                $times = [
                                                    1 => '7:00-7:45', 2 => '7:45-8:30', 3 => '8:30-9:15',
                                                    4 => '9:30-10:15', 5 => '10:15-11:00', 6 => '13:00-13:45',
                                                    7 => '13:45-14:30', 8 => '14:30-15:15', 9 => '15:30-16:15', 10 => '16:15-17:00'
                                                ];
                                            @endphp
                                            {{ $times[$period] ?? '' }}
                                        </span>
                                    </div>
                                </td>
                                @foreach($days as $dayNum => $dayName)
                                    <td class="schedule-cell">
                                        @if(isset($schedule[$dayNum][$period]) && $schedule[$dayNum][$period])
                                            @php $item = $schedule[$dayNum][$period]; @endphp
                                            <div class="class-item">
                                                <div class="subject-name">{{ $item->mon_hoc }}</div>
                                                <div class="class-info">
                                                    <span class="class-name">{{ $item->lop }}</span>
                                                    @if($item->phong_hoc)
                                                        <span class="room">{{ $item->phong_hoc }}</span>
                                                    @endif
                                                </div>
                                                @if($item->ghi_chu)
                                                    <div class="note">{{ $item->ghi_chu }}</div>
                                                @endif
                                            </div>
                                        @else
                                            <div class="empty-cell">
                                                <i class="fas fa-coffee text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-timetable">
                <div class="empty-icon">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <h3>Chưa có thời khóa biểu</h3>
                <p>Hiện tại chưa có lịch giảng dạy nào cho {{ $academicYear }} - {{ $semester }}</p>
                <div class="empty-actions">
                    <a href="{{ route('teacher.dashboard') }}" class="btn-primary">
                        <i class="fas fa-home"></i> Về trang chủ
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Subject Legend -->
    @if($timetable->count() > 0)
        <div class="legend-section">
            <h3><i class="fas fa-info-circle"></i> Danh sách môn học</h3>
            <div class="subject-list">
                @foreach($timetable->pluck('mon_hoc')->unique() as $subject)
                    <div class="subject-item">
                        <span class="subject-dot"></span>
                        <span class="subject-name">{{ $subject }}</span>
                        <span class="subject-count">
                            {{ $timetable->where('mon_hoc', $subject)->count() }} tiết/tuần
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when filters change
    const filterSelects = document.querySelectorAll('.filter-form select');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });

    // Add hover effects to schedule cells
    const scheduleCells = document.querySelectorAll('.schedule-cell');
    scheduleCells.forEach(cell => {
        cell.addEventListener('mouseenter', function() {
            const classItem = this.querySelector('.class-item');
            if (classItem) {
                classItem.style.transform = 'scale(1.05)';
                classItem.style.zIndex = '10';
            }
        });
        
        cell.addEventListener('mouseleave', function() {
            const classItem = this.querySelector('.class-item');
            if (classItem) {
                classItem.style.transform = 'scale(1)';
                classItem.style.zIndex = '1';
            }
        });
    });

    // Print functionality
    window.printTimetable = function() {
        window.print();
    };
});
</script>
@endpush
@endsection