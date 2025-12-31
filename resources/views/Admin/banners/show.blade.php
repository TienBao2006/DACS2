@extends('Admin.pageAdmin')

@section('title', 'Chi tiết Banner')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-eye"></i> Chi tiết Banner: {{ $banner->title }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="200">ID</th>
                                    <td>{{ $banner->id }}</td>
                                </tr>
                                <tr>
                                    <th>Tiêu đề</th>
                                    <td><strong>{{ $banner->title }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Mô tả</th>
                                    <td>{{ $banner->description ?: 'Không có mô tả' }}</td>
                                </tr>
                                <tr>
                                    <th>Liên kết</th>
                                    <td>
                                        @if($banner->link_url)
                                            <a href="{{ $banner->link_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-external-link-alt"></i> {{ $banner->link_url }}
                                            </a>
                                        @else
                                            <span class="text-muted">Không có liên kết</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Thứ tự hiển thị</th>
                                    <td>
                                        <span class="badge badge-secondary">{{ $banner->sort_order }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Trạng thái</th>
                                    <td>
                                        <span class="badge {{ $banner->is_active ? 'badge-success' : 'badge-secondary' }}">
                                            <i class="fas {{ $banner->is_active ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                                            {{ $banner->is_active ? 'Đang hiển thị' : 'Đã ẩn' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Ngày tạo</th>
                                    <td>{{ $banner->created_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Cập nhật lần cuối</th>
                                    <td>{{ $banner->updated_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-4">
                            <div class="text-center">
                                <h5>Hình ảnh Banner</h5>
                                <div class="banner-preview">
                                    <img src="{{ $banner->image_url }}" 
                                         alt="{{ $banner->title }}" 
                                         class="img-fluid rounded shadow">
                                </div>
                                
                                @if($banner->link_url)
                                    <div class="mt-3">
                                        <a href="{{ $banner->link_url }}" 
                                           target="_blank" 
                                           class="btn btn-primary">
                                            <i class="fas fa-external-link-alt"></i> Xem liên kết
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Sửa Banner
                            </a>
                            <form action="{{ route('admin.banners.toggle', $banner) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn {{ $banner->is_active ? 'btn-secondary' : 'btn-success' }}">
                                    <i class="fas {{ $banner->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                    {{ $banner->is_active ? 'Ẩn Banner' : 'Hiện Banner' }}
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6 text-right">
                            <form action="{{ route('admin.banners.destroy', $banner) }}" 
                                  method="POST" 
                                  style="display: inline;"
                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa banner này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Xóa Banner
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.table th {
    background-color: #f8f9fa;
    font-weight: 600;
    color: #495057;
}

.banner-preview {
    border: 3px solid #dee2e6;
    border-radius: 10px;
    padding: 10px;
    background-color: #f8f9fa;
}

.banner-preview img {
    max-width: 100%;
    height: auto;
}

.badge {
    font-size: 0.9em;
}
</style>
@endpush