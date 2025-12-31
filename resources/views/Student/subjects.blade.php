@extends('Student.PageStudent')

@section('title', 'Môn học')

@section('content')
<div class="subjects-container">
    <div class="page-header">
        <h1><i class="fas fa-book"></i> Môn học</h1>
        <p>Danh sách các môn học trong chương trình</p>
    </div>

    <div class="subjects-grid">
        @foreach($subjects as $subject)
        <div class="subject-card">
            <div class="subject-header">
                <div class="subject-icon">
                    @if($subject['name'] === 'Toán')
                        <i class="fas fa-calculator"></i>
                    @elseif($subject['name'] === 'Ngữ Văn')
                        <i class="fas fa-feather-alt"></i>
                    @elseif($subject['name'] === 'Tiếng Anh')
                        <i class="fas fa-globe"></i>
                    @elseif($subject['name'] === 'Vật Lý')
                        <i class="fas fa-atom"></i>
                    @elseif($subject['name'] === 'Hóa Học')
                        <i class="fas fa-flask"></i>
                    @elseif($subject['name'] === 'Sinh Học')
                        <i class="fas fa-dna"></i>
                    @elseif($subject['name'] === 'Lịch Sử')
                        <i class="fas fa-landmark"></i>
                    @elseif($subject['name'] === 'Địa Lý')
                        <i class="fas fa-map"></i>
                    @elseif($subject['name'] === 'Thể Dục')
                        <i class="fas fa-running"></i>
                    @else
                        <i class="fas fa-book"></i>
                    @endif
                </div>
                <h3>{{ $subject['name'] }}</h3>
            </div>

            <div class="subject-info">
                <div class="info-item">
                    <i class="fas fa-user-tie"></i>
                    <span>{{ $subject['teacher'] }}</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-door-open"></i>
                    <span>{{ $subject['room'] }}</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ $subject['schedule'] }}</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-star"></i>
                    <span>{{ $subject['credits'] }} tín chỉ</span>
                </div>
            </div>

            <div class="subject-actions">
                <button class="btn btn-primary btn-sm">
                    <i class="fas fa-chart-line"></i> Xem điểm
                </button>
                <button class="btn btn-secondary btn-sm">
                    <i class="fas fa-tasks"></i> Bài tập
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Subject Statistics -->
    <div class="subjects-stats">
        <div class="stats-card">
            <h3><i class="fas fa-chart-pie"></i> Thống kê môn học</h3>
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-number">{{ count($subjects) }}</span>
                    <span class="stat-label">Tổng môn học</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ array_sum(array_column($subjects, 'credits')) }}</span>
                    <span class="stat-label">Tổng tín chỉ</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">8.6</span>
                    <span class="stat-label">Điểm TB chung</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection