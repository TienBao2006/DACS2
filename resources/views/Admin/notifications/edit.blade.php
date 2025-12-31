@extends('Admin.pageAdmin')

@section('title', 'Chỉnh sửa Thông báo')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-notifications.css') }}">
@endpush

@section('content')
<div class="notifications-container">
    <div class="page-header">
        <h1><i class="fas fa-edit"></i> Chỉnh sửa Thông báo</h1>
        <div class="header-actions">
            <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <h6><i class="fas fa-exclamation-triangle"></i> Có lỗi xảy ra:</h6>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <div class="notification-form-card">
        <form method="POST" action="{{ route('admin.notifications.update', $notification) }}">
            @csrf
            @method('PUT')
            
            <div class="form-section">
                <h3><i class="fas fa-info-circle"></i> Thông tin cơ bản</h3>
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="title">Tiêu đề thông báo <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title" class="form-control" 
                                   value="{{ old('title', $notification->title) }}" required maxlength="255"
                                   placeholder="Nhập tiêu đề thông báo...">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="type">Loại thông báo <span class="text-danger">*</span></label>
                            <select id="type" name="type" class="form-control" required>
                                <option value="">-- Chọn loại --</option>
                                <option value="info" {{ old('type', $notification->type) == 'info' ? 'selected' : '' }}>Thông tin</option>
                                <option value="success" {{ old('type', $notification->type) == 'success' ? 'selected' : '' }}>Thành công</option>
                                <option value="warning" {{ old('type', $notification->type) == 'warning' ? 'selected' : '' }}>Cảnh báo</option>
                                <option value="danger" {{ old('type', $notification->type) == 'danger' ? 'selected' : '' }}>Khẩn cấp</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="content">Nội dung thông báo <span class="text-danger">*</span></label>
                    <textarea id="content" name="content" class="form-control" rows="6" required
                              placeholder="Nhập nội dung chi tiết của thông báo...">{{ old('content', $notification->content) }}</textarea>
                </div>
            </div>

            <div class="form-section">
                <h3><i class="fas fa-cogs"></i> Cài đặt hiển thị</h3>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="priority">Mức độ ưu tiên <span class="text-danger">*</span></label>
                            <select id="priority" name="priority" class="form-control" required>
                                <option value="">-- Chọn mức độ --</option>
                                <option value="low" {{ old('priority', $notification->priority) == 'low' ? 'selected' : '' }}>Thấp</option>
                                <option value="medium" {{ old('priority', $notification->priority) == 'medium' ? 'selected' : '' }}>Trung bình</option>
                                <option value="high" {{ old('priority', $notification->priority) == 'high' ? 'selected' : '' }}>Cao</option>
                                <option value="urgent" {{ old('priority', $notification->priority) == 'urgent' ? 'selected' : '' }}>Khẩn cấp</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tùy chọn hiển thị</label>
                            <div class="checkbox-group">
                                <div class="form-check">
                                    <input type="checkbox" id="is_active" name="is_active" value="1" class="form-check-input" 
                                           {{ old('is_active', $notification->is_active) ? 'checked' : '' }}>
                                    <label for="is_active" class="form-check-label">Kích hoạt ngay</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="show_on_homepage" name="show_on_homepage" value="1" class="form-check-input"
                                           {{ old('show_on_homepage', $notification->show_on_homepage) ? 'checked' : '' }}>
                                    <label for="show_on_homepage" class="form-check-label">Hiển thị trên trang chủ</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="show_popup" name="show_popup" value="1" class="form-check-input"
                                           {{ old('show_popup', $notification->show_popup) ? 'checked' : '' }}>
                                    <label for="show_popup" class="form-check-label">Hiển thị popup</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3><i class="fas fa-calendar-alt"></i> Thời gian hiển thị</h3>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Ngày bắt đầu</label>
                            <input type="datetime-local" id="start_date" name="start_date" class="form-control"
                                   value="{{ old('start_date', $notification->start_date ? $notification->start_date->format('Y-m-d\TH:i') : '') }}">
                            <small class="form-text text-muted">Để trống nếu muốn hiển thị ngay lập tức</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date">Ngày kết thúc</label>
                            <input type="datetime-local" id="end_date" name="end_date" class="form-control"
                                   value="{{ old('end_date', $notification->end_date ? $notification->end_date->format('Y-m-d\TH:i') : '') }}">
                            <small class="form-text text-muted">Để trống nếu muốn hiển thị vô thời hạn</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Cập nhật thông báo
                </button>
                <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Hủy bỏ
                </a>
            </div>
        </form>
    </div>

    <!-- Preview Section -->
    <div class="notification-preview-card">
        <h3><i class="fas fa-eye"></i> Xem trước</h3>
        <div id="notificationPreview" class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <strong>{{ $notification->title }}</strong>
            <p>{{ $notification->content }}</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Live preview functionality
function updatePreview() {
    const title = document.getElementById('title').value || 'Tiêu đề thông báo sẽ hiển thị ở đây';
    const content = document.getElementById('content').value || 'Nội dung thông báo sẽ hiển thị ở đây...';
    const type = document.getElementById('type').value || 'info';
    
    const preview = document.getElementById('notificationPreview');
    
    // Update classes
    preview.className = `alert alert-${type}`;
    
    // Update icon
    const icons = {
        'info': 'fas fa-info-circle',
        'success': 'fas fa-check-circle',
        'warning': 'fas fa-exclamation-triangle',
        'danger': 'fas fa-exclamation-circle'
    };
    
    // Update content
    preview.innerHTML = `
        <i class="${icons[type]}"></i>
        <strong>${title}</strong>
        <p>${content.replace(/\n/g, '<br>')}</p>
    `;
}

// Add event listeners for live preview
document.getElementById('title').addEventListener('input', updatePreview);
document.getElementById('content').addEventListener('input', updatePreview);
document.getElementById('type').addEventListener('change', updatePreview);

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const content = document.getElementById('content').value.trim();
    const type = document.getElementById('type').value;
    const priority = document.getElementById('priority').value;
    
    if (!title || !content || !type || !priority) {
        e.preventDefault();
        alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
        return false;
    }
    
    // Validate date range
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    
    if (startDate && endDate && new Date(startDate) >= new Date(endDate)) {
        e.preventDefault();
        alert('Ngày kết thúc phải sau ngày bắt đầu!');
        return false;
    }
});

// Initialize preview
updatePreview();
</script>
@endpush