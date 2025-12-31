@extends('Student.PageStudent')

@section('title', 'Điểm số')

@section('content')
<div class="grades-container">
    <div class="page-header">
        <h1><i class="fas fa-chart-line"></i> Bảng điểm</h1>
        <div class="grade-summary">
            <div class="summary-item">
                <span class="summary-label">Điểm TB:</span>
                <span class="summary-value">{{ $overallAverage }}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Xếp hạng:</span>
                <span class="summary-value">{{ $ranking }}/{{ $totalStudents }}</span>
            </div>
            @if(isset($dataSource))
            <div class="summary-item data-source">
                <span class="summary-label">Nguồn:</span>
                <span class="summary-value {{ $dataSource === 'database' ? 'text-success' : 'text-warning' }}">
                    @if($dataSource === 'database')
                        <i class="fas fa-database"></i> Database
                    @else
                        <i class="fas fa-exclamation-triangle"></i> Dữ liệu mẫu
                    @endif
                </span>
            </div>
            @endif
        </div>
    </div>

    <!-- Grade Overview Cards -->
    @php
        $excellentCount = 0;
        $goodCount = 0;
        $averageCount = 0;
        $belowAverageCount = 0;
        
        foreach($grades as $subject => $gradeData) {
            $avg = $gradeData['trungbinh'];
            if ($avg >= 9.0) $excellentCount++;
            elseif ($avg >= 8.0) $goodCount++;
            elseif ($avg >= 6.5) $averageCount++;
            else $belowAverageCount++;
        }
    @endphp
    
    <div class="grade-overview">
        <div class="overview-card excellent">
            <div class="card-icon">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="card-content">
                <h3>Xuất sắc</h3>
                <p>{{ $excellentCount }} môn học</p>
            </div>
        </div>
        <div class="overview-card good">
            <div class="card-icon">
                <i class="fas fa-medal"></i>
            </div>
            <div class="card-content">
                <h3>Giỏi</h3>
                <p>{{ $goodCount }} môn học</p>
            </div>
        </div>
        <div class="overview-card average">
            <div class="card-icon">
                <i class="fas fa-thumbs-up"></i>
            </div>
            <div class="card-content">
                <h3>Khá</h3>
                <p>{{ $averageCount }} môn học</p>
            </div>
        </div>
        @if($belowAverageCount > 0)
        <div class="overview-card below-average">
            <div class="card-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="card-content">
                <h3>Cần cải thiện</h3>
                <p>{{ $belowAverageCount }} môn học</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Detailed Grades Table -->
    <div class="grades-table-container">
        <div class="table-header">
            <h3><i class="fas fa-table"></i> Bảng điểm chi tiết</h3>
            <div class="table-actions">
                <button class="btn btn-primary" onclick="exportGrades()">
                    <i class="fas fa-download"></i> Xuất Excel
                </button>
                <button class="btn btn-secondary" onclick="printGrades()">
                    <i class="fas fa-print"></i> In bảng điểm
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="grades-table">
                <thead>
                    <tr>
                        <th>Môn học</th>
                        <th>Điểm miệng</th>
                        <th>Điểm 15'</th>
                        <th>Điểm 1 tiết</th>
                        <th>Điểm học kỳ</th>
                        <th>Điểm TB</th>
                        <th>Xếp loại</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grades as $subject => $gradeData)
                    <tr>
                        <td class="subject-name">
                            <i class="subject-icon fas fa-book"></i>
                            {{ $subject }}
                        </td>
                        <td class="grade-cell">
                            @foreach($gradeData['mieng'] as $grade)
                                <span class="grade-badge">{{ $grade }}</span>
                            @endforeach
                        </td>
                        <td class="grade-cell">
                            @foreach($gradeData['15phut'] as $grade)
                                <span class="grade-badge">{{ $grade }}</span>
                            @endforeach
                        </td>
                        <td class="grade-cell">
                            @foreach($gradeData['1tiet'] as $grade)
                                <span class="grade-badge">{{ $grade }}</span>
                            @endforeach
                        </td>
                        <td class="grade-cell">
                            @foreach($gradeData['hocky'] as $grade)
                                <span class="grade-badge semester">{{ $grade }}</span>
                            @endforeach
                        </td>
                        <td class="average-cell">
                            <span class="average-grade {{ $gradeData['trungbinh'] >= 9 ? 'excellent' : ($gradeData['trungbinh'] >= 8 ? 'good' : 'average') }}">
                                {{ $gradeData['trungbinh'] }}
                            </span>
                        </td>
                        <td class="classification-cell">
                            @if($gradeData['trungbinh'] >= 9)
                                <span class="classification excellent">Xuất sắc</span>
                            @elseif($gradeData['trungbinh'] >= 8)
                                <span class="classification good">Giỏi</span>
                            @elseif($gradeData['trungbinh'] >= 6.5)
                                <span class="classification average">Khá</span>
                            @else
                                <span class="classification below-average">Trung bình</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="5"><strong>Điểm trung bình chung</strong></td>
                        <td class="average-cell">
                            <span class="average-grade excellent">{{ $overallAverage }}</span>
                        </td>
                        <td class="classification-cell">
                            <span class="classification excellent">Giỏi</span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Grade Chart -->
    <div class="grade-chart-container">
        <div class="chart-header">
            <h3><i class="fas fa-chart-bar"></i> Biểu đồ điểm số</h3>
        </div>
        <div class="chart-content">
            <canvas id="gradeChart" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- Grade Legend -->
    <div class="grade-legend">
        <h4>Thang điểm đánh giá:</h4>
        <div class="legend-items">
            <div class="legend-item">
                <span class="legend-color excellent"></span>
                <span>Xuất sắc (9.0 - 10.0)</span>
            </div>
            <div class="legend-item">
                <span class="legend-color good"></span>
                <span>Giỏi (8.0 - 8.9)</span>
            </div>
            <div class="legend-item">
                <span class="legend-color average"></span>
                <span>Khá (6.5 - 7.9)</span>
            </div>
            <div class="legend-item">
                <span class="legend-color below-average"></span>
                <span>Trung bình (5.0 - 6.4)</span>
            </div>
        </div>
    </div>
</div>

@endsection