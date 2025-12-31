@extends('Admin.pageAdmin')

@section('title', 'Chi tiết Thông báo')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-notifications.css') }}">
@endpush

@section('content')
<div class="notifications-container">
    <div class="page-header">
        <h1><i class="fas fa-eye"></i> Chi tiết Thông báo</h1>
        <div class="header-actions">
            <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
            <a href="{{ route('admin.notifications.edit', $notification) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Chỉnh sửa
            </a>
        </div>
    </div>

    <div class="notification-detail-card">
        <div class="notification-header">
            <div class="notification-title">
                <h2>{{ $notification->title }}</h2>
                <div class="notification-badges">
                    <span class="badge badge-{{ $notification->type }}">{{ ucfirst($notification->type) }}</span>
                    <span class="badge badge-{{ $notification->priority_badge }}">{{ ucfirst($notification->priority) }}</span>
                    @if($notification->is_active)
                        <span class="badge badge-success">Đang hoạt động</span>
                    @else
                        <span class="badge badge-secondary">Không hoạt động</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="notification-content">
            <div class="content-section">
                <h4><i class="fas fa-align-left"></i> Nội dung</h4>
                <div class="content-text">
                    {!! nl2br(e($notification->content)) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="info-section">
                        <h4><i class="fas fa-cogs"></i> Cài đặt hiển thị</h4>
                        <ul class="info-list">
                            <li>
                                <strong>Hiển thị trên trang chủ:</strong>
                                @if($notification->show_on_homepage)
                                    <span class="text-success"><i class="fas fa-check"></i> Có</span>
                                @else
                                    <span class="text-muted"><i class="fas fa-times"></i> Không</span>
                                @endif
                            </li>
                            <li>
                                <strong>Hiển thị popup:</strong>
                                @if($notification->show_popup)
                                    <span class="text-success"><i class="fas fa-check"></i> Có</span>
                                @else
                                    <span class="text-muted"><i class="fas fa-times"></i> Không</span>
                                @endif
                            </li>
                            <li>
                                <strong>Mức độ ưu tiên:</strong>
                                <span class="badge badge-{{ $notification->priority_badge }}">{{ ucfirst($notification->priority) }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-section">
                        <h4><i class="fas fa-calendar-alt"></i> Thời gian</h4>
                        <ul class="info-list">
                            <li>
                                <strong>Ngày tạo:</strong>
                                {{ $notification->created_at->format('d/m/Y H:i') }}
                            </li>
                            @if($notification->start_date)
                            <li>
                                <strong>Ngày bắt đầu:</strong>
                                {{ $notification->start_date->format('d/m/Y H:i') }}
                            </li>
                            @endif
                            @if($notification->end_date)
                            <li>
                                <strong>Ngày kết thúc:</strong>
                                {{ $notification->end_date->format('d/m/Y H:i') }}
                            </li>
                            @endif
                            <li>
                                <strong>Lượt xem:</strong>
                                {{ $notification->view_count ?? 0 }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            @if($notification->created_by)
            <div class="info-section">
                <h4><i class="fas fa-user"></i> Thông tin tác giả</h4>
                <p><strong>Tạo bởi:</strong> {{ $notification->created_by }}</p>
            </div>
            @endif
        </div>

        <div class="notification-actions">
            <form method="POST" action="{{ route('admin.notifications.toggle-status', $notification) }}" 
                  style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-{{ $notification->is_active ? 'warning' : 'success' }}">
                    <i class="fas fa-{{ $notification->is_active ? 'pause' : 'play' }}"></i>
                    {{ $notification->is_active ? 'Vô hiệu hóa' : 'Kích hoạt' }}
                </button>
            </form>
            
            <form method="POST" action="{{ route('admin.notifications.destroy', $notification) }}" 
                  style="display: inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa thông báo này?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Xóa
                </button>
            </form>
        </div>
    </div>

    <!-- Preview Section -->
    <div class="notification-preview-card">
        <h3><i class="fas fa-desktop"></i> Xem trước trên trang chủ</h3>
        <div class="alert alert-{{ $notification->type }}">
            <i class="{{ $notification->type_icon }}"></i>
            <strong>{{ $notification->title }}</strong>
            <p>{{ Str::limit($notification->content, 150) }}</p>
            <div class="notification-meta">
                <span class="badge badge-{{ $notification->priority_badge }}">
                    {{ ucfirst($notification->priority) }}
                </span>
                <span class="text-muted">
                    <i class="fas fa-clock"></i> {{ $notification->created_at->format('d/m/Y H:i') }}
                </span>
            </div>
        </div>
    </div>
</div>
@endsection