@extends('Admin.pageAdmin')

@section('content')
<div class="document-edit">
    <div class="page-header">
        <h1><i class="fas fa-edit"></i> Chỉnh sửa tài liệu</h1>
        <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <h4><i class="fas fa-exclamation-triangle"></i> Có lỗi xảy ra:</h4>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-container">
        <form action="{{ route('admin.documents.update', $document) }}" method="POST" enctype="multipart/form-data" class="document-form">
            @csrf
            @method('PUT')
            
            <div class="form-section">
                <h3><i class="fas fa-info-circle"></i> Thông tin cơ bản</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="title" class="required">Tiêu đề tài liệu</label>
                        <input type="text" id="title" name="title" class="form-input" 
                               value="{{ old('title', $document->title) }}" required placeholder="Nhập tiêu đề tài liệu">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="description">Mô tả</label>
                        <textarea id="description" name="description" class="form-textarea" rows="4" 
                                  placeholder="Mô tả ngắn về tài liệu">{{ old('description', $document->description) }}</textarea>
                    </div>
                </div>

                <div class="form-row two-cols">
                    <div class="form-group">
                        <label for="category" class="required">Danh mục</label>
                        <select id="category" name="category" class="form-select" required>
                            <option value="">Chọn danh mục</option>
                            @foreach($categories as $key => $value)
                                <option value="{{ $key }}" {{ old('category', $document->category) == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tags">Từ khóa</label>
                        <input type="text" id="tags" name="tags" class="form-input" 
                               value="{{ old('tags', is_array($document->tags) ? implode(', ', $document->tags) : '') }}" 
                               placeholder="Nhập từ khóa, cách nhau bằng dấu phẩy">
                        <small class="form-help">Ví dụ: toán học, đề thi, lớp 10</small>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3><i class="fas fa-file"></i> File hiện tại</h3>
                
                <div class="current-file">
                    <div class="file-info">
                        <i class="{{ $document->file_icon }}"></i>
                        <div class="file-details">
                            <span class="file-name">{{ $document->file_name }}</span>
                            <span class="file-size">{{ $document->file_size_human }}</span>
                            <span class="file-downloads">{{ $document->downloads }} lượt tải</span>
                        </div>
                        <a href="{{ route('admin.documents.download', $document) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-download"></i> Tải xuống
                        </a>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3><i class="fas fa-upload"></i> Thay đổi file (tùy chọn)</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="file">Chọn file mới</label>
                        <div class="file-upload-area" id="fileUploadArea">
                            <input type="file" id="file" name="file" class="file-input" 
                                   accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip,.rar">
                            <div class="file-upload-content">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Kéo thả file vào đây hoặc <span class="file-browse">chọn file</span></p>
                                <small>Hỗ trợ: PDF, DOC, XLS, PPT, TXT, ZIP, RAR (Tối đa 10MB)</small>
                            </div>
                        </div>
                        <div class="file-preview" id="filePreview" style="display: none;">
                            <div class="file-info">
                                <i class="file-icon"></i>
                                <div class="file-details">
                                    <span class="file-name"></span>
                                    <span class="file-size"></span>
                                </div>
                                <button type="button" class="remove-file" onclick="removeFile()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <small class="form-help">Để trống nếu không muốn thay đổi file</small>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3><i class="fas fa-cog"></i> Cài đặt</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="is_public" value="1" {{ old('is_public', $document->is_public) ? 'checked' : '' }}>
                                <span class="checkbox-custom"></span>
                                <span class="checkbox-text">
                                    <strong>Công khai</strong>
                                    <small>Cho phép mọi người xem và tải xuống tài liệu này</small>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Cập nhật tài liệu
                </button>
                <a href="{{ route('admin.documents.index') }}" class="btn btn-outline">
                    <i class="fas fa-times"></i> Hủy bỏ
                </a>
            </div>
        </form>
    </div>
</div>

<style>
/* Reuse styles from create.blade.php */
.document-edit {
    padding: 20px;
    max-width: 800px;
    margin: 0 auto;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid #e9ecef;
}

.page-header h1 {
    color: #2c3e50;
    font-size: 2rem;
    display: flex;
    align-items: center;
    gap: 15px;
    margin: 0;
}

.current-file {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 20px;
}

.current-file .file-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.current-file .file-info i {
    font-size: 2.5rem;
}

.current-file .file-details {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.current-file .file-name {
    font-weight: 600;
    color: #2c3e50;
    font-size: 1.1rem;
}

.current-file .file-size,
.current-file .file-downloads {
    color: #6c757d;
    font-size: 0.9rem;
}

/* Include all other styles from create.blade.php */
.alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 25px;
}

.alert-danger {
    background: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.form-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}

.form-section {
    padding: 30px;
    border-bottom: 1px solid #e9ecef;
}

.form-section:last-child {
    border-bottom: none;
}

.form-section h3 {
    color: #2c3e50;
    margin: 0 0 25px 0;
    font-size: 1.3rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.form-row.two-cols {
    grid-template-columns: 1fr 1fr;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-input,
.form-select,
.form-textarea {
    padding: 12px 15px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-help {
    color: #6c757d;
    font-size: 0.85rem;
}

.btn {
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-primary { background: #667eea; color: white; }
.btn-secondary { background: #6c757d; color: white; }
.btn-success { background: #28a745; color: white; }
.btn-outline { background: transparent; color: #6c757d; border: 2px solid #6c757d; }
.btn-sm { padding: 8px 16px; font-size: 0.9rem; }

.form-actions {
    padding: 25px 30px;
    background: #f8f9fa;
    display: flex;
    gap: 15px;
    justify-content: flex-end;
}
</style>

<script>
// Reuse JavaScript from create.blade.php for file upload functionality
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('file');
    const fileUploadArea = document.getElementById('fileUploadArea');
    const filePreview = document.getElementById('filePreview');

    if (fileInput && fileUploadArea && filePreview) {
        fileInput.addEventListener('change', function(e) {
            handleFileSelect(e.target.files[0]);
        });

        fileUploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });

        fileUploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });

        fileUploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                handleFileSelect(files[0]);
            }
        });
    }

    function handleFileSelect(file) {
        if (!file) return;

        if (file.size > 10 * 1024 * 1024) {
            alert('File quá lớn! Vui lòng chọn file nhỏ hơn 10MB.');
            fileInput.value = '';
            return;
        }

        const fileName = file.name;
        const fileSize = formatFileSize(file.size);
        const fileIcon = getFileIcon(fileName);

        document.querySelector('#filePreview .file-icon').className = 'file-icon ' + fileIcon;
        document.querySelector('#filePreview .file-name').textContent = fileName;
        document.querySelector('#filePreview .file-size').textContent = fileSize;

        fileUploadArea.style.display = 'none';
        filePreview.style.display = 'block';
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function getFileIcon(fileName) {
        const extension = fileName.split('.').pop().toLowerCase();
        const icons = {
            'pdf': 'fas fa-file-pdf text-danger',
            'doc': 'fas fa-file-word text-primary',
            'docx': 'fas fa-file-word text-primary',
            'xls': 'fas fa-file-excel text-success',
            'xlsx': 'fas fa-file-excel text-success',
            'ppt': 'fas fa-file-powerpoint text-warning',
            'pptx': 'fas fa-file-powerpoint text-warning',
            'txt': 'fas fa-file-alt text-secondary',
            'zip': 'fas fa-file-archive text-info',
            'rar': 'fas fa-file-archive text-info',
        };
        return icons[extension] || 'fas fa-file text-muted';
    }
});

function removeFile() {
    document.getElementById('file').value = '';
    document.getElementById('fileUploadArea').style.display = 'block';
    document.getElementById('filePreview').style.display = 'none';
}
</script>
@endsection