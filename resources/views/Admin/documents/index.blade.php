@extends('Admin.pageAdmin')

@section('content')
<div class="documents-management">
    <div class="page-header">
        <h1><i class="fas fa-file-alt"></i> Quản lý Tài liệu</h1>
        <a href="{{ route('admin.documents.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm tài liệu mới
        </a>
    </div>

    <!-- Filters -->
    <div class="filters-section">
        <form method="GET" action="{{ route('admin.documents.index') }}" class="filters-form">
            <div class="filter-group">
                <label for="category">Danh mục:</label>
                <select name="category" id="category" class="form-select">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $key => $value)
                        <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="is_public">Trạng thái:</label>
                <select name="is_public" id="is_public" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="1" {{ request('is_public') == '1' ? 'selected' : '' }}>Công khai</option>
                    <option value="0" {{ request('is_public') == '0' ? 'selected' : '' }}>Riêng tư</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="search">Tìm kiếm:</label>
                <input type="text" name="search" id="search" class="form-input" 
                       placeholder="Tìm theo tiêu đề..." value="{{ request('search') }}">
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-search"></i> Lọc
                </button>
                <a href="{{ route('admin.documents.index') }}" class="btn btn-outline">
                    <i class="fas fa-times"></i> Xóa bộ lọc
                </a>
            </div>
        </form>
    </div>

    <!-- Documents Table -->
    <div class="table-container">
        <table class="documents-table">
            <thead>
                <tr>
                    <th>Tài liệu</th>
                    <th>Danh mục</th>
                    <th>Kích thước</th>
                    <th>Lượt tải</th>
                    <th>Trạng thái</th>
                    <th>Ngày tải lên</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $document)
                <tr>
                    <td>
                        <div class="document-info">
                            <div class="document-icon">
                                <i class="{{ $document->file_icon }}"></i>
                            </div>
                            <div class="document-details">
                                <h4>{{ $document->title }}</h4>
                                <p class="file-name">{{ $document->file_name }}</p>
                                @if($document->description)
                                    <p class="description">{{ Str::limit($document->description, 100) }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="category-badge category-{{ $document->category }}">
                            {{ $categories[$document->category] ?? $document->category }}
                        </span>
                    </td>
                    <td>{{ $document->file_size_human }}</td>
                    <td>
                        <span class="downloads-count">
                            <i class="fas fa-download"></i> {{ $document->downloads }}
                        </span>
                    </td>
                    <td>
                        @if($document->is_public)
                            <span class="status-badge public">
                                <i class="fas fa-globe"></i> Công khai
                            </span>
                        @else
                            <span class="status-badge private">
                                <i class="fas fa-lock"></i> Riêng tư
                            </span>
                        @endif
                    </td>
                    <td>{{ $document->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.documents.show', $document) }}" 
                               class="btn btn-sm btn-info" title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.documents.edit', $document) }}" 
                               class="btn btn-sm btn-warning" title="Chỉnh sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('admin.documents.download', $document) }}" 
                               class="btn btn-sm btn-success" title="Tải xuống">
                                <i class="fas fa-download"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.documents.destroy', $document) }}" 
                                  style="display: inline;" 
                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài liệu này?')">
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
                    <td colspan="7" class="no-data">
                        <div class="empty-state">
                            <i class="fas fa-file-alt"></i>
                            <h3>Chưa có tài liệu nào</h3>
                            <p>Hãy thêm tài liệu đầu tiên của bạn</p>
                            <a href="{{ route('admin.documents.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Thêm tài liệu
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($documents->hasPages())
        <div class="pagination-wrapper">
            {{ $documents->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<style>
.documents-management {
    padding: 20px;
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
}

.filters-section {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.filters-form {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    align-items: end;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.filter-group label {
    font-weight: 600;
    color: #2c3e50;
}

.form-select,
.form-input {
    padding: 10px 15px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.form-select:focus,
.form-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.filter-actions {
    display: flex;
    gap: 10px;
}

.table-container {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.documents-table {
    width: 100%;
    border-collapse: collapse;
}

.documents-table th {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 15px;
    text-align: left;
    font-weight: 600;
}

.documents-table td {
    padding: 15px;
    border-bottom: 1px solid #e9ecef;
    vertical-align: top;
}

.document-info {
    display: flex;
    align-items: flex-start;
    gap: 15px;
}

.document-icon {
    font-size: 2rem;
    flex-shrink: 0;
}

.document-details h4 {
    margin: 0 0 5px 0;
    color: #2c3e50;
    font-size: 1.1rem;
}

.file-name {
    color: #7f8c8d;
    font-size: 0.9rem;
    margin: 0 0 5px 0;
}

.description {
    color: #95a5a6;
    font-size: 0.85rem;
    margin: 0;
    line-height: 1.4;
}

.category-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    color: white;
}

.category-general { background: #3498db; }
.category-curriculum { background: #2ecc71; }
.category-exam { background: #e74c3c; }
.category-regulation { background: #9b59b6; }
.category-form { background: #f39c12; }
.category-report { background: #1abc9c; }
.category-other { background: #95a5a6; }

.downloads-count {
    display: flex;
    align-items: center;
    gap: 5px;
    color: #27ae60;
    font-weight: 600;
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
    background: #d4edda;
    color: #155724;
}

.status-badge.private {
    background: #f8d7da;
    color: #721c24;
}

.action-buttons {
    display: flex;
    gap: 5px;
}

.btn {
    padding: 8px 16px;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-primary { background: #667eea; color: white; }
.btn-secondary { background: #6c757d; color: white; }
.btn-outline { background: transparent; color: #6c757d; border: 1px solid #6c757d; }
.btn-info { background: #17a2b8; color: white; }
.btn-warning { background: #ffc107; color: #212529; }
.btn-success { background: #28a745; color: white; }
.btn-danger { background: #dc3545; color: white; }

.btn-sm {
    padding: 6px 12px;
    font-size: 0.8rem;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #7f8c8d;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 20px;
    color: #bdc3c7;
}

.empty-state h3 {
    margin-bottom: 10px;
    color: #2c3e50;
}

.pagination-wrapper {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        gap: 20px;
        text-align: center;
    }

    .filters-form {
        grid-template-columns: 1fr;
    }

    .documents-table {
        font-size: 0.9rem;
    }

    .document-info {
        flex-direction: column;
        text-align: center;
    }

    .action-buttons {
        flex-wrap: wrap;
        justify-content: center;
    }
}
</style>
@endsection