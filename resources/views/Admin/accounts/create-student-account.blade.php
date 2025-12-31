@extends('admin.pageAdmin')

@section('content')
<style>
.form-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.page-header {
    text-align: center;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 2px solid #e2e8f0;
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    color: #2d3748;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.form-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.form-section {
    padding: 25px;
    border-bottom: 1px solid #e2e8f0;
}

.form-section:last-child {
    border-bottom: none;
}

.section-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}

.required {
    color: #ef4444;
}

.form-control {
    width: 100%;
    padding: 12px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.form-control:focus {
    outline: none;
    border-color: #4facfe;
    box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1);
}

.form-control:invalid {
    border-color: #ef4444;
}

.form-text {
    font-size: 0.875rem;
    color: #6b7280;
    margin-top: 5px;
}

.preview-card {
    background: #e8f5e8;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 15px;
    border: 2px solid #4ade80;
}

.preview-title {
    font-weight: 600;
    color: #166534;
    margin-bottom: 10px;
}

.preview-code {
    font-size: 1.2rem;
    font-weight: 700;
    color: #4facfe;
    background: white;
    padding: 8px 12px;
    border-radius: 6px;
    display: inline-block;
}

.checkbox-group {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 15px;
    background: #f0f9ff;
    border-radius: 8px;
    border: 2px solid #0ea5e9;
}

.checkbox-group input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: #4facfe;
}

.btn {
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.btn-primary {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(79, 172, 254, 0.3);
}

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
}

.form-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    padding-top: 20px;
}

.alert {
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 20px;
    border: none;
}

.alert-danger {
    background: linear-gradient(135deg, rgba(255, 154, 158, 0.1) 0%, rgba(254, 207, 239, 0.1) 100%);
    border-left: 4px solid #ff9a9e;
    color: #7f1d1d;
}

.error-list {
    margin: 0;
    padding-left: 20px;
}

@media (max-width: 768px) {
    .form-container {
        padding: 10px;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .form-section {
        padding: 20px;
    }
    
    .form-actions {
        flex-direction: column;
    }
}
</style>

<div class="form-container">
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-user-plus"></i>
            Tạo tài khoản học sinh
        </h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong><i class="fas fa-exclamation-triangle"></i> Có lỗi xảy ra:</strong>
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.student-accounts.store') }}" method="POST" class="form-card">
        @csrf
        
        <!-- Thông tin đăng nhập -->
        <div class="form-section">
            <h3 class="section-title">
                <i class="fas fa-key"></i>
                Thông tin đăng nhập
            </h3>
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Username <span class="required">*</span></label>
                    <input type="text" name="username" class="form-control" 
                           value="{{ old('username') }}" required>
                    <div class="form-text">Tên đăng nhập duy nhất cho học sinh</div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Mật khẩu <span class="required">*</span></label>
                    <input type="password" name="password" class="form-control" required>
                    <div class="form-text">Tối thiểu 6 ký tự</div>
                </div>
            </div>
        </div>

        <!-- Thông tin cá nhân -->
        <div class="form-section">
            <h3 class="section-title">
                <i class="fas fa-user"></i>
                Thông tin cá nhân
            </h3>
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Họ và tên <span class="required">*</span></label>
                    <input type="text" name="ho_va_ten" class="form-control" 
                           value="{{ old('ho_va_ten') }}" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Giới tính <span class="required">*</span></label>
                    <select name="gioi_tinh" class="form-control" required>
                        <option value="">Chọn giới tính</option>
                        <option value="Nam" {{ old('gioi_tinh') == 'Nam' ? 'selected' : '' }}>Nam</option>
                        <option value="Nữ" {{ old('gioi_tinh') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Ngày sinh <span class="required">*</span></label>
                    <input type="date" name="ngay_sinh" class="form-control" 
                           value="{{ old('ngay_sinh') }}" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Số điện thoại</label>
                    <input type="tel" name="so_dien_thoai" class="form-control" 
                           value="{{ old('so_dien_thoai') }}" placeholder="0987654321">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" 
                           value="{{ old('email') }}" placeholder="student@example.com">
                </div>
                
                <div class="form-group full-width">
                    <label class="form-label">Địa chỉ</label>
                    <textarea name="dia_chi" class="form-control" rows="3">{{ old('dia_chi') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Thông tin học tập -->
        <div class="form-section">
            <h3 class="section-title">
                <i class="fas fa-graduation-cap"></i>
                Thông tin học tập
            </h3>
            
            <div id="student-code-preview" style="display: none;">
                <div class="preview-card">
                    <div class="preview-title">Mã học sinh sẽ được tạo:</div>
                    <span class="preview-code" id="preview-code"></span>
                </div>
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Khối <span class="required">*</span></label>
                    <select name="khoi" id="khoi" class="form-control" required>
                        <option value="">Chọn khối</option>
                        <option value="10" {{ old('khoi') == '10' ? 'selected' : '' }}>Khối 10</option>
                        <option value="11" {{ old('khoi') == '11' ? 'selected' : '' }}>Khối 11</option>
                        <option value="12" {{ old('khoi') == '12' ? 'selected' : '' }}>Khối 12</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Lớp <span class="required">*</span></label>
                    <select name="lop" id="lop" class="form-control" required>
                        <option value="">Chọn lớp</option>
                    </select>
                </div>
                
                <div class="form-group full-width">
                    <label class="form-label">Năm học</label>
                    <input type="text" name="nam_hoc" class="form-control" 
                           value="{{ old('nam_hoc', date('Y') . '-' . (date('Y') + 1)) }}" 
                           placeholder="2024-2025">
                </div>
            </div>
        </div>

        <!-- Thông tin phụ huynh -->
        <div class="form-section">
            <h3 class="section-title">
                <i class="fas fa-users"></i>
                Thông tin phụ huynh
            </h3>
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Tên cha</label>
                    <input type="text" name="ten_cha" class="form-control" 
                           value="{{ old('ten_cha') }}">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Tên mẹ</label>
                    <input type="text" name="ten_me" class="form-control" 
                           value="{{ old('ten_me') }}">
                </div>
                
                <div class="form-group full-width">
                    <label class="form-label">Số điện thoại phụ huynh</label>
                    <input type="tel" name="sdt_phu_huynh" class="form-control" 
                           value="{{ old('sdt_phu_huynh') }}" placeholder="0987654321">
                </div>
            </div>
        </div>

        <!-- Cài đặt tài khoản -->
        <div class="form-section">
            <h3 class="section-title">
                <i class="fas fa-cog"></i>
                Cài đặt tài khoản
            </h3>
            
            <div class="checkbox-group">
                <input type="checkbox" name="is_active" id="is_active" value="1" checked>
                <label for="is_active" class="form-label" style="margin: 0;">
                    <strong>🟢 Kích hoạt tài khoản ngay</strong>
                </label>
            </div>
            <div class="form-text">Tài khoản sẽ có thể đăng nhập ngay sau khi tạo</div>
        </div>

        <div class="form-section">
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <span class="btn-text">
                        <i class="fas fa-save"></i>
                        Tạo tài khoản học sinh
                    </span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i>
                        Đang tạo tài khoản...
                    </span>
                </button>
                <a href="{{ route('admin.student-accounts.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Quay lại
                </a>
            </div>
        </div>
    </form>
</div>

<script>
// Danh sách lớp theo khối
const classes = {
    '10': ['A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8'],
    '11': ['A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8'],
    '12': ['A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8']
};

const khoiSelect = document.getElementById('khoi');
const lopSelect = document.getElementById('lop');

// Cập nhật danh sách lớp khi chọn khối
khoiSelect.addEventListener('change', function() {
    const selectedKhoi = this.value;
    lopSelect.innerHTML = '<option value="">Chọn lớp</option>';
    document.getElementById('student-code-preview').style.display = 'none';
    
    if (selectedKhoi && classes[selectedKhoi]) {
        classes[selectedKhoi].forEach(function(lop) {
            const option = document.createElement('option');
            option.value = lop;
            option.textContent = lop;
            lopSelect.appendChild(option);
        });
    }
});

// Preview mã học sinh khi chọn lớp
lopSelect.addEventListener('change', function() {
    const selectedKhoi = khoiSelect.value;
    const selectedLop = this.value;
    
    if (selectedKhoi && selectedLop) {
        fetch(`/admin/student-accounts/preview-code/${selectedKhoi}/${selectedLop}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('preview-code').textContent = data.ma_hoc_sinh;
                document.getElementById('student-code-preview').style.display = 'block';
            })
            .catch(error => {
                console.error('Error:', error);
            });
    } else {
        document.getElementById('student-code-preview').style.display = 'none';
    }
});

// Xử lý loading state khi submit form
document.querySelector('form').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoading = submitBtn.querySelector('.btn-loading');
    
    // Hiển thị loading state
    btnText.style.display = 'none';
    btnLoading.style.display = 'inline-flex';
    submitBtn.disabled = true;
    
    // Thêm overlay loading cho toàn bộ form
    const overlay = document.createElement('div');
    overlay.className = 'loading-overlay';
    overlay.innerHTML = `
        <div class="loading-content">
            <i class="fas fa-spinner fa-spin fa-2x"></i>
            <p>Đang tạo tài khoản học sinh...</p>
        </div>
    `;
    document.body.appendChild(overlay);
});
</script>

<style>
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.loading-content {
    background: white;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.loading-content i {
    color: #667eea;
    margin-bottom: 15px;
}

.loading-content p {
    margin: 0;
    font-weight: 600;
    color: #333;
}

.btn-loading {
    align-items: center;
    gap: 8px;
}

#submitBtn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}
</style>
@endsection