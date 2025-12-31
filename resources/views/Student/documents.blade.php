@extends('Student.PageStudent')

@section('title', 'Tài liệu')

@section('content')
<div class="documents-container">
    <div class="page-header">
        <h1><i class="fas fa-folder-open"></i> Tài liệu học tập</h1>
        <div class="document-actions">
            <select class="form-select" id="categoryFilter">
                <option value="">Tất cả danh mục</option>
                <option value="Giáo trình">Giáo trình</option>
                <option value="Đề thi">Đề thi</option>
                <option value="Bài tập">Bài tập</option>
                <option value="Tham khảo">Tham khảo</option>
            </select>
            <select class="form-select" id="subjectFilter">
                <option value="">Tất cả môn học</option>
                <option value="Toán">Toán</option>
                <option value="Văn">Văn</option>
                <option value="Anh">Tiếng Anh</option>
                <option value="Lý">Vật Lý</option>
                <option value="Hóa">Hóa Học</option>
            </select>
        </div>
    </div>

    <!-- Document Stats -->
    <div class="document-stats">
        <div class="stat-card total">
            <div class="stat-icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-content">
                <h3>{{ count($documents) }}</h3>
                <p>Tổng tài liệu</p>
            </div>
        </div>
        <div class="stat-card downloaded">
            <div class="stat-icon">
                <i class="fas fa-download"></i>
            </div>
            <div class="stat-content">
                <h3>{{ collect($documents)->sum('downloads') }}</h3>
                <p>Lượt tải</p>
            </div>
        </div>
        <div class="stat-card recent">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3>{{ collect($documents)->where('uploaded_date', '>=', date('Y-m-d', strtotime('-7 days')))->count() }}</h3>
                <p>Mới tuần này</p>
            </div>
        </div>
    </div>

    <!-- Documents Grid -->
    <div class="documents-grid">
        @foreach($documents as $document)
        <div class="document-card" data-category="{{ $document['category'] }}" data-subject="{{ $document['subject'] }}">
            <div class="document-header">
                <div class="document-type">
                    @if($document['type'] === 'PDF')
                        <i class="fas fa-file-pdf text-danger"></i>
                    @elseif($document['type'] === 'DOC')
                        <i class="fas fa-file-word text-primary"></i>
                    @elseif($document['type'] === 'PPT')
                        <i class="fas fa-file-powerpoint text-warning"></i>
                    @else
                        <i class="fas fa-file text-secondary"></i>
                    @endif
                    <span>{{ $document['type'] }}</span>
                </div>
                <div class="document-category">{{ $document['category'] }}</div>
            </div>

            <div class="document-content">
                <h3>{{ $document['title'] }}</h3>
                <div class="document-meta">
                    <div class="meta-item">
                        <i class="fas fa-book"></i>
                        <span>{{ $document['subject'] }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-hdd"></i>
                        <span>{{ $document['size'] }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-calendar"></i>
                        <span>{{ date('d/m/Y', strtotime($document['uploaded_date'])) }}</span>
                    </div>
                </div>
            </div>

            <div class="document-footer">
                <div class="document-stats">
                    <span class="download-count">
                        <i class="fas fa-download"></i> {{ $document['downloads'] }} lượt tải
                    </span>
                </div>
                
                <div class="document-actions">
                    <button class="btn btn-primary btn-sm" onclick="downloadDocument('{{ $document['title'] }}')">
                        <i class="fas fa-download"></i> Tải xuống
                    </button>
                    <button class="btn btn-secondary btn-sm" onclick="previewDocument('{{ $document['title'] }}')">
                        <i class="fas fa-eye"></i> Xem trước
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if(count($documents) === 0)
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-folder-open"></i>
        </div>
        <h3>Chưa có tài liệu nào</h3>
        <p>Tài liệu học tập sẽ được cập nhật thường xuyên</p>
    </div>
    @endif
</div>

@push('styles')
<style>
.documents-container {
    padding: 20px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.document-actions {
    display: flex;
    gap: 15px;
}

.form-select {
    padding: 8px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    background: white;
}

.document-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 15px;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
}

.stat-card.total .stat-icon { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.stat-card.downloaded .stat-icon { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
.stat-card.recent .stat-icon { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }

.documents-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 20px;
}

.document-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.document-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.document-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.document-type {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
}

.document-category {
    background: #667eea;
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.document-content h3 {
    margin-bottom: 15px;
    color: #2d3748;
    font-size: 16px;
    line-height: 1.4;
}

.document-meta {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 15px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #718096;
    font-size: 14px;
}

.meta-item i {
    width: 16px;
    color: #a0aec0;
}

.document-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 15px;
    border-top: 1px solid #e2e8f0;
}

.download-count {
    color: #718096;
    font-size: 12px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.document-actions {
    display: flex;
    gap: 8px;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.empty-icon {
    font-size: 64px;
    color: #cbd5e0;
    margin-bottom: 20px;
}

.empty-state h3 {
    color: #2d3748;
    margin-bottom: 10px;
}

.empty-state p {
    color: #718096;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        gap: 15px;
        align-items: stretch;
    }
    
    .document-actions {
        justify-content: stretch;
    }
    
    .documents-grid {
        grid-template-columns: 1fr;
    }
    
    .document-footer {
        flex-direction: column;
        gap: 15px;
        align-items: stretch;
    }
    
    .document-actions {
        justify-content: center;
    }
}
</style>
@endpush

@push('scripts')
<script>
function downloadDocument(title) {
    alert('Đang tải xuống: ' + title);
    // Simulate download
    console.log('Downloading:', title);
}

function previewDocument(title) {
    alert('Xem trước: ' + title);
    // Simulate preview
    console.log('Previewing:', title);
}

// Filter functionality
document.getElementById('categoryFilter').addEventListener('change', function() {
    filterDocuments();
});

document.getElementById('subjectFilter').addEventListener('change', function() {
    filterDocuments();
});

function filterDocuments() {
    const categoryFilter = document.getElementById('categoryFilter').value;
    const subjectFilter = document.getElementById('subjectFilter').value;
    const cards = document.querySelectorAll('.document-card');
    
    cards.forEach(card => {
        const category = card.dataset.category;
        const subject = card.dataset.subject;
        
        const categoryMatch = categoryFilter === '' || category === categoryFilter;
        const subjectMatch = subjectFilter === '' || subject === subjectFilter;
        
        if (categoryMatch && subjectMatch) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>
@endpush
@endsection