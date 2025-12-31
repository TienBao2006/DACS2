@extends('Student.PageStudent')

@section('title', 'Thời khóa biểu')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/student-schedule.css') }}">
@endpush

@section('content')
<div class="schedule-container">
    <div class="page-header">
        <h1><i class="fas fa-calendar-alt"></i> Thời khóa biểu</h1>
        <div class="schedule-actions">
            <button class="btn btn-primary" onclick="printSchedule()">
                <i class="fas fa-print"></i> In lịch học
            </button>
            <button class="btn btn-secondary" onclick="exportSchedule()">
                <i class="fas fa-download"></i> Xuất PDF
            </button>
        </div>
    </div>

    @if(isset($dataSource) && $dataSource === 'fallback')
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            Đang hiển thị dữ liệu mẫu. Vui lòng liên hệ giáo viên để cập nhật thời khóa biểu chính thức.
        </div>
    @endif

    <!-- Week Navigation -->
    <div class="week-navigation">
        <button class="btn btn-outline-primary" onclick="previousWeek()">
            <i class="fas fa-chevron-left"></i> Tuần trước
        </button>
        <span class="current-week">
            Tuần {{ $currentWeek['week_number'] ?? date('W') }} 
            ({{ $currentWeek['start_date'] ?? date('d/m') }} - {{ $currentWeek['end_date'] ?? date('d/m/Y') }})
        </span>
        <button class="btn btn-outline-primary" onclick="nextWeek()">
            Tuần sau <i class="fas fa-chevron-right"></i>
        </button>
    </div>

    <!-- Schedule Table -->
    <div class="schedule-table-container">
        <table class="schedule-table">
            <thead>
                <tr>
                    <th class="time-column">Tiết</th>
                    <th>Thứ 2</th>
                    <th>Thứ 3</th>
                    <th>Thứ 4</th>
                    <th>Thứ 5</th>
                    <th>Thứ 6</th>
                    <th>Thứ 7</th>
                </tr>
            </thead>
            <tbody>
                @for($tiet = 1; $tiet <= 10; $tiet++)
                    @if($tiet == 4)
                        <!-- Break row after period 3 -->
                        <tr class="break-row">
                            <td class="time-slot break">
                                <div class="period">Giải lao</div>
                                <div class="time">09:25-09:40</div>
                            </td>
                            <td colspan="6" class="break-cell">
                                <i class="fas fa-coffee"></i> Giải lao 15 phút
                            </td>
                        </tr>
                    @elseif($tiet == 6)
                        <!-- Lunch break after period 5 -->
                        <tr class="break-row">
                            <td class="time-slot break">
                                <div class="period">Nghỉ trưa</div>
                                <div class="time">11:15-13:00</div>
                            </td>
                            <td colspan="6" class="break-cell">
                                <i class="fas fa-utensils"></i> Nghỉ trưa
                            </td>
                        </tr>
                    @endif
                    
                    <tr>
                        <td class="time-slot">
                            <div class="period">Tiết {{ $tiet }}</div>
                            <div class="time">
                                @php
                                    $times = [
                                        1 => '07:00-07:45', 2 => '07:50-08:35', 3 => '08:40-09:25',
                                        4 => '09:40-10:25', 5 => '10:30-11:15', 6 => '13:00-13:45',
                                        7 => '13:45-14:30', 8 => '14:30-15:15', 9 => '15:30-16:15', 10 => '16:15-17:00'
                                    ];
                                    echo $times[$tiet] ?? '';
                                @endphp
                            </div>
                        </td>
                        
                        @for($thu = 2; $thu <= 7; $thu++)
                            <td class="subject-cell-container">
                                @if(isset($schedule[$thu][$tiet]) && $schedule[$thu][$tiet])
                                    @php 
                                        $item = $schedule[$thu][$tiet];
                                        $subjectName = '';
                                        $cssClass = 'default';
                                        
                                        // Chuyển đổi mã môn học thành tên và class CSS
                                        $subjectNames = [
                                            'TOAN' => 'Toán', 'VAN' => 'Ngữ Văn', 'ANH' => 'Tiếng Anh',
                                            'LY' => 'Vật Lý', 'HOA' => 'Hóa Học', 'SINH' => 'Sinh Học',
                                            'SU' => 'Lịch Sử', 'DIA' => 'Địa Lý', 'GDCD' => 'GDCD', 'TD' => 'Thể Dục'
                                        ];
                                        
                                        $subjectClasses = [
                                            'TOAN' => 'math', 'VAN' => 'literature', 'ANH' => 'english',
                                            'LY' => 'physics', 'HOA' => 'chemistry', 'SINH' => 'biology',
                                            'SU' => 'history', 'DIA' => 'geography', 'GDCD' => 'civics', 'TD' => 'pe'
                                        ];
                                        
                                        $subjectName = $subjectNames[$item['mon_hoc']] ?? $item['mon_hoc'];
                                        $cssClass = $subjectClasses[$item['mon_hoc']] ?? 'default';
                                    @endphp
                                    
                                    <div class="subject-cell {{ $cssClass }}">
                                        <div class="subject-name">{{ $subjectName }}</div>
                                        <div class="teacher-name">{{ $item['ten_giao_vien'] }}</div>
                                        <div class="room-name">{{ $item['phong_hoc'] }}</div>
                                    </div>
                                @else
                                    <div class="empty-cell"></div>
                                @endif
                            </td>
                        @endfor
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>

    <!-- Schedule Summary -->
    <div class="schedule-summary">
        <div class="summary-card">
            <h3><i class="fas fa-chart-pie"></i> Thống kê môn học</h3>
            <div class="subject-stats">
                @if(isset($subjectStats) && count($subjectStats) > 0)
                    @foreach($subjectStats as $subjectName => $stats)
                        <div class="stat-item">
                            @php
                                $subjectClasses = [
                                    'TOAN' => 'math', 'VAN' => 'literature', 'ANH' => 'english',
                                    'LY' => 'physics', 'HOA' => 'chemistry', 'SINH' => 'biology',
                                    'SU' => 'history', 'DIA' => 'geography', 'GDCD' => 'civics', 'TD' => 'pe'
                                ];
                                $cssClass = $subjectClasses[$stats['code']] ?? 'default';
                            @endphp
                            <span class="subject-color {{ $cssClass }}"></span>
                            <span>{{ $subjectName }}: {{ $stats['count'] }} tiết</span>
                        </div>
                    @endforeach
                @else
                    <div class="no-data">
                        <i class="fas fa-calendar-times"></i>
                        <p>Chưa có thời khóa biểu</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function printSchedule() {
    window.print();
}

function exportSchedule() {
    alert('Chức năng xuất PDF đang được phát triển');
}

function previousWeek() {
    alert('Chức năng xem tuần trước đang được phát triển');
}

function nextWeek() {
    alert('Chức năng xem tuần sau đang được phát triển');
}
</script>
@endpush
@endsection