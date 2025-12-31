@extends('Admin.pageAdmin')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-news.css') }}">
@endpush

<div class="news-management">
    <div class="page-header">
        <h2><i class="fas fa-newspaper"></i> Quản lý tin tức</h2>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm tin tức mới
        </a>
    </div>

    <!-- Filters -->
    <div class="filters-section">
        <form method="GET" action="{{ route('admin.news.index') }}" class="filter-form">
            <div class="filter-group">
                <input type="text" name="search" placeholder="Tìm kiếm tin tức..." 
                       value="{{ request('search') }}" class="form-control">
            </div>
            <div class="filter-group">
                <select name="status" class="form-control">
                    <option value="">Tất cả trạng thái</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Đã xuất bản</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                    <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Nổi bật</option>
                </select>
            </div>
            <button type="submit" class="btn btn-secondary">
                <i class="fas fa-search"></i> Tìm kiếm
            </button>
            <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i> Xóa bộ lọc
            </a>
        </form>
    </div>

    <!-- Statistics -->
    <div class="stats-section">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-newspaper"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $news->total() }}</h3>
                <p>Tổng tin tức</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-eye"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $news->where('is_published', true)->count() }}</h3>
                <p>Đã xuất bản</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $news->where('is_featured', true)->count() }}</h3>
                <p>Tin nổi bật</p>
            </div>
        </div>
    </div>

    <!-- News List -->
    <div class="news-list">
        @if($news->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tiêu đề</th>
                            <th>Tác giả</th>
                            <th>Trạng thái</th>
                            <th>Lượt xem</th>
                            <th>Ngày xuất bản</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($news as $item)
                        <tr>
                            <td>
                                <div class="news-title">
                                    @if($item->image)
                                        <img src="{{ $item->image_url }}" alt="News image" class="news-thumb">
                                    @endif
                                    <div>
                                        <h5>{{ $item->title }}</h5>
                                        <p class="text-muted">{{ $item->short_summary }}</p>
                                        @if($item->is_featured)
                                            <span class="badge badge-warning">Nổi bật</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->author ?? 'Không rõ' }}</td>
                            <td>
                                @if($item->is_published)
                                    <span class="badge badge-success">Đã xuất bản</span>
                                @else
                                    <span class="badge badge-secondary">Bản nháp</span>
                                @endif
                            </td>
                            <td>
                                <i class="fas fa-eye"></i> {{ number_format($item->views) }}
                            </td>
                            <td>{{ $item->formatted_date }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.news.show', $item) }}" class="btn btn-sm btn-info" title="Xem">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-warning" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-secondary toggle-featured" 
                                            data-id="{{ $item->id }}" title="Chuyển nổi bật">
                                        <i class="fas fa-star"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary toggle-published" 
                                            data-id="{{ $item->id }}" title="Chuyển trạng thái">
                                        <i class="fas fa-toggle-on"></i>
                                    </button>
                                    <form method="POST" action="{{ route('admin.news.destroy', $item) }}" 
                                          style="display: inline;" onsubmit="return confirm('Bạn có chắc muốn xóa tin tức này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper">
                {{ $news->appends(request()->query())->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <h3>Chưa có tin tức nào</h3>
                <p>Hãy thêm tin tức đầu tiên cho website của bạn.</p>
                <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm tin tức mới
                </a>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle featured status
    document.querySelectorAll('.toggle-featured').forEach(button => {
        button.addEventListener('click', function() {
            const newsId = this.dataset.id;
            
            fetch(`/admin/news/${newsId}/toggle-featured`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        });
    });

    // Toggle published status
    document.querySelectorAll('.toggle-published').forEach(button => {
        button.addEventListener('click', function() {
            const newsId = this.dataset.id;
            
            fetch(`/admin/news/${newsId}/toggle-published`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        });
    });
});
</script>
@endpush

@endsection