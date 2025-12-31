@extends('Admin.pageAdmin')

@section('title', 'Quản lý Banner')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-images"></i> Quản lý Banner
                    </h3>
                    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm Banner
                    </a>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="80">ID</th>
                                    <th width="120">Hình ảnh</th>
                                    <th>Tiêu đề</th>
                                    <th>Mô tả</th>
                                    <th width="100">Thứ tự</th>
                                    <th width="100">Trạng thái</th>
                                    <th width="150">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($banners as $banner)
                                <tr>
                                    <td>{{ $banner->id }}</td>
                                    <td>
                                        <img src="{{ $banner->image_url }}" 
                                             alt="{{ $banner->title }}" 
                                             class="img-thumbnail" 
                                             style="width: 100px; height: 60px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <strong>{{ $banner->title }}</strong>
                                        @if($banner->link_url)
                                            <br><small class="text-muted">
                                                <i class="fas fa-link"></i> 
                                                <a href="{{ $banner->link_url }}" target="_blank">{{ Str::limit($banner->link_url, 30) }}</a>
                                            </small>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($banner->description, 50) }}</td>
                                    <td>
                                        <span class="badge badge-secondary">{{ $banner->sort_order }}</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.banners.toggle', $banner) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $banner->is_active ? 'btn-success' : 'btn-secondary' }}">
                                                <i class="fas {{ $banner->is_active ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                                                {{ $banner->is_active ? 'Hiện' : 'Ẩn' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.banners.show', $banner) }}" 
                                               class="btn btn-sm btn-info" title="Xem">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.banners.edit', $banner) }}" 
                                               class="btn btn-sm btn-warning" title="Sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.banners.destroy', $banner) }}" 
                                                  method="POST" style="display: inline;"
                                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa banner này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <div class="py-4">
                                            <i class="fas fa-images fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Chưa có banner nào được tạo</p>
                                            <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Tạo Banner đầu tiên
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($banners->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $banners->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    border: none;
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.table th {
    background-color: #343a40;
    color: white;
    border-color: #454d55;
}

.btn-group .btn {
    margin-right: 2px;
}

.img-thumbnail {
    border: 2px solid #dee2e6;
}

.alert {
    border-radius: 10px;
}
</style>
@endpush