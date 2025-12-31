@extends('Admin.pageAdmin')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-news.css') }}">
@endpush

<div class="news-management">
    <div class="page-header">
        <h2><i class="fas fa-eye"></i> Chi tiết tin tức</h2>
        <div class="header-actions">
            <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Chỉnh sửa
            </a>
            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="news-detail">
        <div class="news-meta">
            <div class="meta-row">
                <div class="meta-item">
                    <strong>Trạng thái:</strong>
                    @if($news->is_published)
                        <span class="badge badge-success">Đã xuất bản</span>
                    @else
                        <span class="badge badge-secondary">Bản nháp</span>
                    @endif
                    @if($news->is_featured)
                        <span class="badge badge-warning">Nổi bật</span>
                    @endif
                </div>
                <div class="meta-item">
                    <strong>Lượt xem:</strong> {{ number_format($news->views) }}
                </div>
            </div>
            <div class="meta-row">
                <div class="meta-item">
                    <strong>Tác giả:</strong> {{ $news->author ?? 'Không rõ' }}
                </div>
                <div class="meta-item">
                    <strong>Ngày xuất bản:</strong> {{ $news->formatted_date }}
                </div>
            </div>
            <div class="meta-row">
                <div class="meta-item">
                    <strong>Ngày tạo:</strong> {{ $news->created_at->format('d/m/Y H:i') }}
                </div>
                <div class="meta-item">
                    <strong>Cập nhật lần cuối:</strong> {{ $news->updated_at->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>

        <div class="news-content-preview">
            <h1 class="news-title">{{ $news->title }}</h1>
            
            @if($news->image)
                <div class="news-image">
                    <img src="{{ $news->image_url }}" alt="{{ $news->title }}" class="img-fluid">
                </div>
            @endif

            @if($news->summary)
                <div class="news-summary">
                    <h4>Tóm tắt:</h4>
                    <p>{{ $news->summary }}</p>
                </div>
            @endif

            <div class="news-content">
                <h4>Nội dung:</h4>
                <div class="content-body">
                    {!! $news->content !!}
                </div>
            </div>
        </div>

        <div class="news-actions">
            <div class="action-group">
                <h5>Thao tác nhanh:</h5>
                <button type="button" class="btn btn-info toggle-featured" data-id="{{ $news->id }}">
                    <i class="fas fa-star"></i> 
                    {{ $news->is_featured ? 'Bỏ nổi bật' : 'Đặt nổi bật' }}
                </button>
                <button type="button" class="btn btn-primary toggle-published" data-id="{{ $news->id }}">
                    <i class="fas fa-toggle-on"></i> 
                    {{ $news->is_published ? 'Chuyển thành nháp' : 'Xuất bản' }}
                </button>
                <form method="POST" action="{{ route('admin.news.destroy', $news) }}" 
                      style="display: inline;" onsubmit="return confirm('Bạn có chắc muốn xóa tin tức này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Xóa tin tức
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle featured status
    document.querySelector('.toggle-featured').addEventListener('click', function() {
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

    // Toggle published status
    document.querySelector('.toggle-published').addEventListener('click', function() {
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
</script>
@endpush

@endsection