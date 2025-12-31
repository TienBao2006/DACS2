@extends('Admin.pageAdmin')

@section('title', 'Quản lý Thông báo')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-notifications.css') }}">
@endpush

@section('content')
<div class="notifications-container">
    <div class="page-header">
        <h1><i class="fas fa-bell"></i> Quản lý Thông báo</h1>
        <div class="header-actions">
            <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tạo thông báo mới
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <!-- Bulk Actions -->
    <div class="bulk-actions-card">
        <form id="bulkActionForm" method="POST" action="{{ route('admin.notifications.bulk-action') }}">
            @csrf
            <div class="bulk-actions-header">
                <div class="select-all-container">
                    <input type="checkbox" id="selectAll" class="form-check-input">
                    <label for="selectAll" class="form-check-label">Chọn tất cả</label>
                </div>
                <div class="bulk-actions-buttons">
                    <select name="action" class="form-control" style="width: auto; display: inline-block;">
                        <option value="">-- Chọn thao tác --</option>
                        <option value="activate">Kích hoạt</option>
                        <option value="deactivate">Vô hiệu hóa</option>
                        <option value="delete">Xóa</option>
                    </select>
                    <button type="submit" class="btn btn-secondary" onclick="return confirmBulkAction()">
                        <i class="fas fa-cogs"></i> Thực hiện
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Notifications List -->
    <div class="notifications-list">
        @forelse($notifications as $notification)
            <div class="notification-card {{ $notification->priority_class }}">
                <div class="notification-header">
                    <div class="notification-select">
                        <input type="checkbox" name="notifications[]" value="{{ $notification->id }}" 
                               class="notification-checkbox form-check-input" form="bulkActionForm">
                    </div>
                    <div class="notification-info">
                        <h3 class="notification-title">
                            <i class="{{ $notification->type_icon }}"></i>
                            {{ $notification->title }}
                        </h3>
                        <div class="notification-meta">
                            <span class="badge {{ $notification->priority_badge }}">
                                {{ ucfirst($notification->priority) }}
                            </span>
                            <span class="badge badge-{{ $notification->type }}">
                                {{ ucfirst($notification->type) }}
                            </span>
                            @if($notification->is_active)
                                <span class="badge badge-success">Hoạt động</span>
                            @else
                                <span class="badge badge-secondary">Tạm dừng</span>
                            @endif
                            @if($notification->show_on_homepage)
                                <span class="badge badge-info">Trang chủ</span>
                            @endif
                            @if($notification->show_popup)
                                <span class="badge badge-warning">Popup</span>
                            @endif
                        </div>
                    </div>
                    <div class="notification-actions">
                        <a href="{{ route('admin.notifications.show', $notification) }}" 
                           class="btn btn-sm btn-info" title="Xem chi tiết">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.notifications.edit', $notification) }}" 
                           class="btn btn-sm btn-warning" title="Chỉnh sửa">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.notifications.toggle-status', $notification) }}" 
                              style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-{{ $notification->is_active ? 'secondary' : 'success' }}" 
                                    title="{{ $notification->is_active ? 'Tạm dừng' : 'Kích hoạt' }}">
                                <i class="fas fa-{{ $notification->is_active ? 'pause' : 'play' }}"></i>
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.notifications.destroy', $notification) }}" 
                              style="display: inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa thông báo này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="notification-content">
                    <p>{{ Str::limit($notification->content, 200) }}</p>
                </div>
                
                <div class="notification-footer">
                    <div class="notification-dates">
                        @if($notification->start_date)
                            <small><i class="fas fa-calendar-alt"></i> Bắt đầu: {{ $notification->start_date->format('d/m/Y H:i') }}</small>
                        @endif
                        @if($notification->end_date)
                            <small><i class="fas fa-calendar-times"></i> Kết thúc: {{ $notification->end_date->format('d/m/Y H:i') }}</small>
                        @endif
                    </div>
                    <div class="notification-stats">
                        <small><i class="fas fa-eye"></i> {{ $notification->view_count }} lượt xem</small>
                        <small><i class="fas fa-clock"></i> {{ $notification->created_at->format('d/m/Y H:i') }}</small>
                        @if($notification->created_by)
                            <small><i class="fas fa-user"></i> {{ $notification->created_by }}</small>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-bell-slash"></i>
                <h3>Chưa có thông báo nào</h3>
                <p>Tạo thông báo đầu tiên để hiển thị trên trang chủ</p>
                <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tạo thông báo mới
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($notifications->hasPages())
        <div class="pagination-container">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
// Select all functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.notification-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Update select all when individual checkboxes change
document.querySelectorAll('.notification-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const allCheckboxes = document.querySelectorAll('.notification-checkbox');
        const checkedCheckboxes = document.querySelectorAll('.notification-checkbox:checked');
        const selectAllCheckbox = document.getElementById('selectAll');
        
        if (checkedCheckboxes.length === 0) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = false;
        } else if (checkedCheckboxes.length === allCheckboxes.length) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = true;
        } else {
            selectAllCheckbox.indeterminate = true;
        }
    });
});

function confirmBulkAction() {
    const selectedCheckboxes = document.querySelectorAll('.notification-checkbox:checked');
    const action = document.querySelector('select[name="action"]').value;
    
    if (selectedCheckboxes.length === 0) {
        alert('Vui lòng chọn ít nhất một thông báo!');
        return false;
    }
    
    if (!action) {
        alert('Vui lòng chọn thao tác!');
        return false;
    }
    
    const actionText = {
        'activate': 'kích hoạt',
        'deactivate': 'vô hiệu hóa',
        'delete': 'xóa'
    };
    
    return confirm(`Bạn có chắc chắn muốn ${actionText[action]} ${selectedCheckboxes.length} thông báo đã chọn?`);
}

// Auto-hide alerts
setTimeout(function() {
    $('.alert').fadeOut('slow');
}, 5000);
</script>
@endpush