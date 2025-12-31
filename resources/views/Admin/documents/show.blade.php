@extends('Admin.pageAdmin')

@section('content')
<div class="document-show">
    <div class="page-header">
        <h1><i class="fas fa-eye"></i> Chi tiết tài liệu</h1>
        <div class="header-actions">
            <a href="{{ route('admin.documents.edit', $document) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Chỉnh sửa
            </a>
            <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="document-details">
        <!-- Document Info Card -->
        <div class="info-card">
            <div class="card-header">
                <h3><i class="fas fa-info-circle"></i> Thông tin tài liệu</h3>
                <div class="status-badges">
                    @if($document->is_public)
                        <span class="status-badge public">
                            <i class="fas fa-globe"></i> Công khai
                        </span>
                    @else
                        <span class="status-badge private">
                            <i class="fas fa-lock"></i> Riêng tư
                        </span>
                    @endif
                    <span class="category-badge category-{{ $document->category }}">
                        {{ $categories[$document->category] ?? $document->category }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <label>Tiêu đề:</label>
                        <span>{{ $document->title }}</span>
                    </div>
                    
                    @if($document->description)
                    <div class="info-item full-width">
                        <label>Mô tả:</label>
                        <span>{{ $document->description }}</span>
                    </div>
                    @endif

                    <div class="info-item">
                        <label>Danh mục:</label>
                        <span>{{ $categories[$document->category] ?? $document->category }}</span>
                    </div>

                    <div class="info-item">
                        <label>Ngày tải lên:</label>
                        <span>{{ $document->created_at->format('d/m/Y H:i') }}</span>
                    </div>

                    <div class="info-item">
                        <label>Cập nhật lần cuối:</label>
                        <span>{{ $document->updated_at->format('d/m/Y H:i') }}</span>
                    </div>

                    <div class="info-item">
                        <label>Người tải lên:</label>
                        <span>{{ $document->uploader->name ?? 'Không xác định' }}</span>
                    </div>

                    @if($document->tags && count($document->tags) > 0)
                    <div class="info-item full-width">
                        <label>Từ khóa:</label>
                        <div class="tags">
                            @foreach($document->tags as $tag)
                                <span class="tag">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- File Info Card -->
        <div class="info-card">
            <div class="card-header">
                <h3><i class="fas fa-file"></i> Thông tin file</h3>
            </div>
            <div class="card-body">
                <div class="file-preview">
                    <div class="file-icon-large">
                        <i class="{{ $document->file_icon }}"></i>
                    </div>
                    <div class="file-details">
                        <h4>{{ $document->file_name }}</h4>
                        <div class="file-meta">
                            <span class="file-size">
                                <i class="fas fa-hdd"></i> {{ $document->file_size_human }}
                            </span>
                            <span class="file-type">
                                <i class="fas fa-tag"></i> {{ strtoupper(pathinfo($document->file_name, PATHINFO_EXTENSION)) }}
                            </span>
                            <span class="file-downloads">
                                <i class="fas fa-download"></i> {{ $document->downloads }} lượt tải
                            </span>
                        </div>
                        <div class="file-actions">
                            <a href="{{ route('admin.documents.download', $document) }}" class="btn btn-success">
                                <i class="fas fa-download"></i> Tải xuống
                            </a>
                            @if($document->is_public)
                                <a href="{{ route('homepage.documents.download', $document) }}" class="btn btn-info" target="_blank">
                                    <i class="fas fa-external-link-alt"></i> Xem công khai
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="info-card">
            <div class="card-header">
                <h3><i class="fas fa-chart-bar"></i> Thống kê</h3>
            </div>
            <div class="card-body">
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-download"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $document->downloads }}</div>
                            <div class="stat-label">Lượt tải xuống</div>
                        </div>
                    </div>
                    
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $document->created_at->diffInDays(now()) }}</div>
                            <div class="stat-label">Ngày đã tải lên</div>
                        </div>
                    </div>
                    
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $document->is_public ? 'Có' : 'Không' }}</div>
                            <div class="stat-label">Hiển thị công khai</div>
                        </div>
                    </div>
                    
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-hdd"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $document->file_size_human }}</div>
                            <div class="stat-label">Kích thước file</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Card -->
        <div class="info-card">
            <div class="card-header">
                <h3><i class="fas fa-cogs"></i> Thao tác</h3>
            </div>
            <div class="card-body">
                <div class="action-buttons">
                    <a href="{{ route('admin.documents.edit', $document) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Chỉnh sửa tài liệu
                    </a>
                    
                    <a href="{{ route('admin.documents.download', $document) }}" class="btn btn-success">
                        <i class="fas fa-download"></i> Tải xuống file
                    </a>
                    
                    @if($document->is_public)
                        <a href="{{ route('homepage.documents.download', $document) }}" class="btn btn-info" target="_blank">
                            <i class="fas fa-external-link-alt"></i> Xem trên trang chủ
                        </a>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.documents.destroy', $document) }}" 
                          style="display: inline;" 
                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài liệu này? Hành động này không thể hoàn tác!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Xóa tài liệu
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.document-show {
    padding: 20px;
    max-width: 1000px;
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

.header-actions {
    display: flex;
    gap: 10px;
}

.document-details {
    display: grid;
    gap: 25px;
}

.info-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}

.card-header {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 20px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header h3 {
    margin: 0;
    font-size: 1.3rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.status-badges {
    display: flex;
    gap: 10px;
}

.status-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.status-badge.public {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.status-badge.private {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.category-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    color: white;
    background: rgba(255, 255, 255, 0.2);
}

.card-body {
    padding: 25px;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.info-item.full-width {
    grid-column: 1 / -1;
}

.info-item label {
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.9rem;
}

.info-item span {
    color: #495057;
    font-size: 1rem;
    line-height: 1.5;
}

.tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.tag {
    background: #e9ecef;
    color: #495057;
    padding: 4px 12px;
    border-radius: 15px;
    font-size: 0.85rem;
    font-weight: 500;
}

.file-preview {
    display: flex;
    align-items: center;
    gap: 25px;
}

.file-icon-large {
    font-size: 4rem;
    color: #667eea;
    flex-shrink: 0;
}

.file-details {
    flex: 1;
}

.file-details h4 {
    color: #2c3e50;
    margin: 0 0 15px 0;
    font-size: 1.3rem;
}

.file-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 20px;
}

.file-meta span {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #6c757d;
    font-size: 0.95rem;
}

.file-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 10px;
    border-left: 4px solid #667eea;
}

.stat-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.3rem;
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2c3e50;
    line-height: 1;
}

.stat-label {
    color: #6c757d;
    font-size: 0.9rem;
    margin-top: 5px;
}

.action-buttons {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.btn {
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.95rem;
}

.btn-primary { background: #667eea; color: white; }
.btn-secondary { background: #6c757d; color: white; }
.btn-success { background: #28a745; color: white; }
.btn-warning { background: #ffc107; color: #212529; }
.btn-info { background: #17a2b8; color: white; }
.btn-danger { background: #dc3545; color: white; }

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Responsive */
@media (max-width: 768px) {
    .document-show {
        padding: 15px;
    }

    .page-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }

    .page-header h1 {
        font-size: 1.5rem;
    }

    .header-actions {
        justify-content: center;
    }

    .file-preview {
        flex-direction: column;
        text-align: center;
    }

    .file-icon-large {
        font-size: 3rem;
    }

    .file-meta {
        justify-content: center;
    }

    .action-buttons {
        justify-content: center;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .info-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection