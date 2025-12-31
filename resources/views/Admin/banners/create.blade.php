@extends('Admin.pageAdmin')

@section('title', 'Thêm Banner')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus"></i> Thêm Banner Mới
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
                
                <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="title">Tiêu đề <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title') }}" 
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Mô tả</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="link_url">Liên kết (URL)</label>
                                    <input type="url" 
                                           class="form-control @error('link_url') is-invalid @enderror" 
                                           id="link_url" 
                                           name="link_url" 
                                           value="{{ old('link_url') }}"
                                           placeholder="https://example.com">
                                    @error('link_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sort_order">Thứ tự hiển thị</label>
                                            <input type="number" 
                                                   class="form-control @error('sort_order') is-invalid @enderror" 
                                                   id="sort_order" 
                                                   name="sort_order" 
                                                   value="{{ old('sort_order', 0) }}" 
                                                   min="0">
                                            @error('sort_order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-check mt-4">
                                                <input type="checkbox" 
                                                       class="form-check-input" 
                                                       id="is_active" 
                                                       name="is_active" 
                                                       value="1" 
                                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    Kích hoạt banner
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="image">Hình ảnh <span class="text-danger">*</span></label>
                                    <div class="custom-file">
                                        <input type="file" 
                                               class="custom-file-input @error('image') is-invalid @enderror" 
                                               id="image" 
                                               name="image" 
                                               accept="image/*" 
                                               required>
                                        <label class="custom-file-label" for="image">Chọn hình ảnh...</label>
                                    </div>
                                    @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Định dạng: JPG, PNG, GIF. Kích thước tối đa: 2MB
                                    </small>
                                </div>

                                <div class="form-group">
                                    <div id="image-preview" class="text-center" style="display: none;">
                                        <img id="preview-img" src="" alt="Preview" class="img-thumbnail" style="max-width: 100%; max-height: 200px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Lưu Banner
                        </button>
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Hủy
                        </a>
                    </div>
                </form>
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

.form-group label {
    font-weight: 600;
    color: #495057;
}

.custom-file-label::after {
    content: "Chọn";
}

#image-preview {
    margin-top: 10px;
    padding: 10px;
    border: 2px dashed #dee2e6;
    border-radius: 5px;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Preview image
    $('#image').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#preview-img').attr('src', e.target.result);
                $('#image-preview').show();
            }
            reader.readAsDataURL(file);
            
            // Update label
            $(this).next('.custom-file-label').text(file.name);
        } else {
            $('#image-preview').hide();
            $(this).next('.custom-file-label').text('Chọn hình ảnh...');
        }
    });
});
</script>
@endpush