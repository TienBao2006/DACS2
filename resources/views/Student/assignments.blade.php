@extends('Student.PageStudent')

@section('title', 'Bài tập & Kiểm tra')

@section('content')
<div class="assignments-container">
    <div class="page-header">
        <h1><i class="fas fa-tasks"></i> Bài tập & Kiểm tra</h1>
        <div class="filter-actions">
            <select class="form-select" id="subjectFilter">
                <option value="">Tất cả môn học</option>
                <option value="math">Toán</option>
                <option value="literature">Văn</option>
                <option value="english">Tiếng Anh</option>
                <option value="physics">Vật Lý</option>
                <option value="chemistry">Hóa Học</option>
            </select>
            <select class="form-select" id="statusFilter">
                <option value="">Tất cả trạng thái</option>
                <option value="pending">Chưa nộp</option>
                <option value="completed">Đã hoàn thành</option>
                <option value="overdue">Quá hạn</option>
            </select>
        </div>
    </div>

    <!-- Assignment Stats -->
    <div class="assignment-stats">
        <div class="stat-card pending">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3>3</h3>
                <p>Chưa hoàn thành</p>
            </div>
        </div>
        <div class="stat-card completed">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3>15</h3>
                <p>Đã hoàn thành</p>
            </div>
        </div>
        <div class="stat-card overdue">
            <div class="stat-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-content">
                <h3>1</h3>
                <p>Quá hạn</p>
            </div>
        </div>
    </div>

    <!-- Assignments List -->
    <div class="assignments-list">
        @foreach($assignments as $assignment)
        <div class="assignment-card {{ $assignment['status'] }}">
            <div class="assignment-header">
                <div class="assignment-type">
                    @if($assignment['type'] === 'homework')
                        <i class="fas fa-book"></i>
                        <span>Bài tập</span>
                    @elseif($assignment['type'] === 'test')
                        <i class="fas fa-clipboard-check"></i>
                        <span>Kiểm tra</span>
                    @elseif($assignment['type'] === 'essay')
                        <i class="fas fa-pen-fancy"></i>
                        <span>Tiểu luận</span>
                    @else
                        <i class="fas fa-flask"></i>
                        <span>Thí nghiệm</span>
                    @endif
                </div>
                <div class="assignment-subject">{{ $assignment['subject'] }}</div>
            </div>

            <div class="assignment-content">
                <h3>{{ $assignment['title'] }}</h3>
                <p>{{ $assignment['description'] }}</p>
                
                <div class="assignment-dates">
                    <div class="date-item">
                        <i class="fas fa-calendar-plus"></i>
                        <span>Giao: {{ date('d/m/Y', strtotime($assignment['assigned_date'])) }}</span>
                    </div>
                    <div class="date-item">
                        <i class="fas fa-calendar-times"></i>
                        <span>Hạn: {{ date('d/m/Y', strtotime($assignment['due_date'])) }}</span>
                    </div>
                </div>
            </div>

            <div class="assignment-footer">
                <div class="assignment-status">
                    @if($assignment['status'] === 'completed')
                        <span class="status-badge completed">
                            <i class="fas fa-check"></i> Đã hoàn thành
                        </span>
                    @elseif($assignment['status'] === 'pending')
                        <span class="status-badge pending">
                            <i class="fas fa-clock"></i> Chưa nộp
                        </span>
                    @elseif($assignment['status'] === 'upcoming')
                        <span class="status-badge upcoming">
                            <i class="fas fa-calendar-alt"></i> Sắp tới
                        </span>
                    @else
                        <span class="status-badge overdue">
                            <i class="fas fa-exclamation-triangle"></i> Quá hạn
                        </span>
                    @endif
                </div>
                
                <div class="assignment-actions">
                    @if($assignment['status'] === 'pending' || $assignment['status'] === 'upcoming')
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-upload"></i> Nộp bài
                        </button>
                    @endif
                    <button class="btn btn-secondary btn-sm">
                        <i class="fas fa-eye"></i> Chi tiết
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.filter-actions {
    display: flex;
    gap: 15px;
}

.form-select {
    padding: 8px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    background: white;
}

.assignment-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 15px;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
}

.stat-card.pending .stat-icon { background: linear-gradient(135deg, #ffeaa7 0%, #fab1a0 100%); }
.stat-card.completed .stat-icon { background: linear-gradient(135deg, #00b894 0%, #00cec9 100%); }
.stat-card.overdue .stat-icon { background: linear-gradient(135deg, #e17055 0%, #d63031 100%); }

.assignments-list {
    display: grid;
    gap: 20px;
}

.assignment-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border-left: 4px solid #e2e8f0;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.assignment-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.assignment-card.pending { border-left-color: #ffeaa7; }
.assignment-card.completed { border-left-color: #00b894; }
.assignment-card.upcoming { border-left-color: #74b9ff; }
.assignment-card.overdue { border-left-color: #e17055; }

.assignment-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.assignment-type {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #667eea;
    font-weight: 500;
}

.assignment-subject {
    background: #667eea;
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.assignment-content h3 {
    margin-bottom: 10px;
    color: #2d3748;
    font-size: 18px;
}

.assignment-content p {
    color: #718096;
    margin-bottom: 15px;
    line-height: 1.5;
}

.assignment-dates {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
}

.date-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #718096;
    font-size: 14px;
}

.assignment-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 15px;
    border-top: 1px solid #e2e8f0;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 5px;
}

.status-badge.completed { background: #c6f6d5; color: #276749; }
.status-badge.pending { background: #fef5e7; color: #c05621; }
.status-badge.upcoming { background: #bee3f8; color: #2c5282; }
.status-badge.overdue { background: #fed7d7; color: #c53030; }

.assignment-actions {
    display: flex;
    gap: 10px;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        gap: 15px;
        align-items: stretch;
    }
    
    .filter-actions {
        justify-content: stretch;
    }
    
    .assignment-footer {
        flex-direction: column;
        gap: 15px;
        align-items: stretch;
    }
    
    .assignment-actions {
        justify-content: center;
    }
}
</style>
@endpush
@endsection