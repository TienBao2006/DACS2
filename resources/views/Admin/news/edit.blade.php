@extends('Admin.pageAdmin')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-news.css') }}">
@endpush

<div class="news-management">
    <div class="page-header">
        <h2><i class="fas fa-edit"></i> Chỉnh sửa tin tức</h2>
        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="news-form-container">
        <form method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data" class="news-form">
            @csrf
            @method('PUT')
            
            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="title">Tiêu đề <span class="required">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                           id="title" name="title" value="{{ old('title', $news->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="author">Tác giả</label>
                    <input type="text" class="form-control @error('author') is-invalid @enderror" 
                           id="author" name="author" value="{{ old('author', $news->author) }}">
                    @error('author')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="summary">Tóm tắt</label>
                <textarea class="form-control @error('summary') is-invalid @enderror" 
                          id="summary" name="summary" rows="3" 
                          placeholder="Tóm tắt ngắn gọn về nội dung tin tức...">{{ old('summary', $news->summary) }}</textarea>
                @error('summary')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="content">Nội dung <span class="required">*</span></label>
                <textarea class="form-control @error('content') is-invalid @enderror" 
                          id="content" name="content" rows="15" required>{{ old('content', $news->content) }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="image">Hình ảnh</label>
                    @if($news->image)
                        <div class="current-image">
                            <img src="{{ $news->image_url }}" alt="Current image" class="img-thumbnail" style="max-width: 200px;">
                            <p class="text-muted">Hình ảnh hiện tại</p>
                        </div>
                    @endif
                    <input type="file" class="form-control-file @error('image') is-invalid @enderror" 
                           id="image" name="image" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Chấp nhận: JPG, PNG, GIF. Tối đa 2MB. Để trống nếu không muốn thay đổi.</small>
                </div>
                <div class="form-group col-md-6">
                    <label for="published_at">Ngày xuất bản</label>
                    <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" 
                           id="published_at" name="published_at" 
                           value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}">
                    @error('published_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_published" name="is_published" 
                               {{ old('is_published', $news->is_published) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_published">
                            Xuất bản
                        </label>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" 
                               {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">
                            Tin nổi bật
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Cập nhật tin tức
                </button>
                <a href="{{ route('admin.news.show', $news) }}" class="btn btn-info">
                    <i class="fas fa-eye"></i> Xem tin tức
                </a>
                <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Hủy bỏ
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/4.25.1/standard/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize CKEditor for content
    CKEDITOR.replace('content', {
        height: 400,
        toolbar: [
            { name: 'document', items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates'] },
            { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },
            { name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'] },
            '/',
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'] },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'] },
            { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
            { name: 'insert', items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe'] },
            '/',
            { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
            { name: 'colors', items: ['TextColor', 'BGColor'] },
            { name: 'tools', items: ['Maximize', 'ShowBlocks'] }
        ]
    });

    // Image preview
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                let preview = document.getElementById('image-preview');
                if (!preview) {
                    preview = document.createElement('img');
                    preview.id = 'image-preview';
                    preview.style.maxWidth = '200px';
                    preview.style.marginTop = '10px';
                    preview.className = 'img-thumbnail';
                    document.querySelector('.current-image').appendChild(preview);
                }
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush

@endsection