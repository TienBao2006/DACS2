@extends('Student.PageStudent')

@section('title', 'Thông báo')

@section('content')
<div class="notifications-container">
    <div class="page-header">
        <h1><i class="fas fa-bell"></i> Thông báo</h1>
        <div class="notification-actions">
            <button class="btn btn-primary" onclick="markAllAsRead()">
                <i class="fas fa-check-double"></i> Đánh dấu đã đọc
            </button>
            <select class="form-select" id="typeFilter">
                <option value="">Tất cả loại</option>
                <option value="important">Quan trọng</option>
                <option value="urgent">Khẩn cấp</option>
                <option value="info">Thông tin</option>
            </select>
        </div>
    </div>

    <!-- Notification Stats -->
    <div class="notification-stats">
        <div class="stat-card unread">
            <div class="stat-icon">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-content">
                <h3>2</h3>
                <p>Chưa đọc</p>
            </div>
        </div>
        <div class="stat-card total">
            <div class="stat-icon">
                <i class="fas fa-bell"></i>
            </div>
            <div class="stat-content">
                <h3>{{ count($notifications) }}</h3>
                <p>Tổng thông báo</p>
            </div>
        </div>
        <div class="stat-card important">
            <div class="stat-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-content">
                <h3>1</h3>
                <p>Quan trọng</p>
            </div>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="notifications-list">
        @foreach($notifications as $notification)
        <div class="notification-card {{ $notification['type'] }} {{ $notification['read'] ? 'read' : 'unread' }}">
            <div class="notification-header">
                <div class="notification-type">
                    @if($notification['type'] === 'important')
                        <i class="fas fa-star text-warning"></i>
                        <span>Quan trọng</span>
                    @elseif($notification['type'] === 'urgent')
                        <i class="fas fa-exclamation-triangle text-danger"></i>
                        <span>Khẩn cấp</span>
                    @else
                        <i class="fas fa-info-circle text-info"></i>
                        <span>Thông tin</span>
                    @endif
                </div>
                <div class="notification-date">{{ $notification['date'] }}</div>
            </div>

            <div class="notification-content">
                <h3>{{ $notification['title'] }}</h3>
                <p>{{ $notification['content'] }}</p>
            </div>

            <div class="notification-footer">
                <div class="notification-status">
                    @if(!$notification['read'])
                        <span class="status-badge unread">
                            <i class="fas fa-circle"></i> Chưa đọc
                        </span>
                    @else
                        <span class="status-badge read">
                            <i class="fas fa-check"></i> Đã đọc
                        </span>
                    @endif
                </div>
                
                <div class="notification-actions">
                    @if(!$notification['read'])
                        <button class="btn btn-sm btn-primary" onclick="markAsRead({{ $loop->index }})">
                            <i class="fas fa-check"></i> Đánh dấu đã đọc
                        </button>
                    @endif
                    <button class="btn btn-sm btn-secondary" onclick="viewDetails({{ $loop->index }})">
                        <i class="fas fa-eye"></i> Chi tiết
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if(count($notifications) === 0)
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-bell-slash"></i>
        </div>
        <h3>Không có thông báo nào</h3>
        <p>Bạn sẽ nhận được thông báo mới từ nhà trường tại đây</p>
    </div>
    @endif
</div>

@push('styles')
<style>
.notifications-container {
    padding: 20px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.notification-actions {
    display: flex;
    gap: 15px;
    align-items: center;
}

.form-select {
    padding: 8px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    background: white;
}

.notification-stats {
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

.stat-card.unread .stat-icon { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.stat-card.total .stat-icon { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
.stat-card.important .stat-icon { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }

.notifications-list {
    display: grid;
    gap: 20px;
}

.notification-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border-left: 4px solid #e2e8f0;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.notification-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.notification-card.unread {
    border-left-color: #667eea;
    background: linear-gradient(135deg, #f8faff 0%, #ffffff 100%);
}

.notification-card.important { border-left-color: #fbbf24; }
.notification-card.urgent { border-left-color: #ef4444; }
.notification-card.info { border-left-color: #3b82f6; }

.notification-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.notification-type {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    color: #667eea;
}

.notification-date {
    color: #718096;
    font-size: 14px;
}

.notification-content h3 {
    margin-bottom: 10px;
    color: #2d3748;
    font-size: 18px;
}

.notification-content p {
    color: #718096;
    margin-bottom: 15px;
    line-height: 1.6;
}

.notification-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 15px;
    border-top: 1px solid #e2e8f0;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 5px;
}

.status-badge.unread { background: #dbeafe; color: #1e40af; }
.status-badge.read { background: #d1fae5; color: #065f46; }

.notification-actions {
    display: flex;
    gap: 10px;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.empty-icon {
    font-size: 64px;
    color: #cbd5e0;
    margin-bottom: 20px;
}

.empty-state h3 {
    color: #2d3748;
    margin-bottom: 10px;
}

.empty-state p {
    color: #718096;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        gap: 15px;
        align-items: stretch;
    }
    
    .notification-actions {
        justify-content: stretch;
    }
    
    .notification-footer {
        flex-direction: column;
        gap: 15px;
        align-items: stretch;
    }
    
    .notification-actions {
        justify-content: center;
    }
}
</style>
@endpush

@push('scripts')
<script>
function markAllAsRead() {
    // Simulate marking all as read
    document.querySelectorAll('.notification-card.unread').forEach(card => {
        card.classList.remove('unread');
        card.classList.add('read');
        
        const statusBadge = card.querySelector('.status-badge');
        statusBadge.className = 'status-badge read';
        statusBadge.innerHTML = '<i class="fas fa-check"></i> Đã đọc';
        
        const markButton = card.querySelector('.btn-primary');
        if (markButton) {
            markButton.remove();
        }
    });
    
    // Update stats
    document.querySelector('.stat-card.unread h3').textContent = '0';
    
    alert('Đã đánh dấu tất cả thông báo là đã đọc');
}

function markAsRead(index) {
    const cards = document.querySelectorAll('.notification-card');
    const card = cards[index];
    
    card.classList.remove('unread');
    card.classList.add('read');
    
    const statusBadge = card.querySelector('.status-badge');
    statusBadge.className = 'status-badge read';
    statusBadge.innerHTML = '<i class="fas fa-check"></i> Đã đọc';
    
    const markButton = card.querySelector('.btn-primary');
    if (markButton) {
        markButton.remove();
    }
    
    // Update unread count
    const unreadCount = document.querySelectorAll('.notification-card.unread').length;
    document.querySelector('.stat-card.unread h3').textContent = unreadCount;
}

function viewDetails(index) {
    alert('Chức năng xem chi tiết đang được phát triển');
}

// Filter functionality
document.getElementById('typeFilter').addEventListener('change', function() {
    const filterValue = this.value;
    const cards = document.querySelectorAll('.notification-card');
    
    cards.forEach(card => {
        if (filterValue === '' || card.classList.contains(filterValue)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});
</script>
@endpush
@endsection