@extends('Admin.pageAdmin')

@section('content')
<style>
.form-container {
    max-width: 600px;
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

.student-info-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 30px;
    text-align: center;
}

.student-name {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.student-details {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    margin-top: 15px;
}

.student-detail {
    background: rgba(255, 255, 255, 0.1);
    padding: 10px;
    border-radius: 8px;
}

.form-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.form-section {
    padding: 25px;
}

.form-group {
    margin-bottom: 20px;
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

.form-text {
    font-size: 0.875rem;
    color: #6b7280;
    margin-top: 5px;
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
    
    .student-details {
        grid-template-columns: 1fr;
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
            Tạo tài khoản đăng nhập
        </h1>
    </div>

    <!-- Thông tin học sinh -->
    <div class="student-info-card">
        <div class="student-name">{{ $student->ho_va_ten }}</div>
        <div class="student-code">Mã học sinh: {{ $student->ma_hoc_sinh }}</div>
        
        <div class="student-details">
            <div class="student-detail">
                <strong>Lớp:</strong> {{ $student->khoi }}{{ $student->lop }}
            </div>
            <div class="student-detail">
                <strong>Giới tính:</strong> {{ $student->gioi_tinh }}
            </div>
            <div class="student-detail">
                <strong>Ngày sinh:</strong> {{ date('d/m/Y', strtotime($student->ngay_sinh)) }}
            </div>
            <div class="student-detail">
                <strong>Năm học:</strong> {{ $student->nam_hoc }}
            </div>
        </div>
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

    <form action="{{ route('admin.student-accounts.store-for-student', $student->id) }}" method="POST" class="form-card">
        @csrf
        
        <div class="form-section">
            <div class="form-group">
                <label class="form-label">Username <span class="required">*</span></label>
                <input type="text" name="username" class="form-control" 
                       value="{{ old('username', $student->ma_hoc_sinh) }}" required>
                <div class="form-text">Tên đăng nhập duy nhất cho học sinh (mặc định là mã học sinh)</div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Mật khẩu <span class="required">*</span></label>
                <input type="password" name="password" class="form-control" required>
                <div class="form-text">Tối thiểu 6 ký tự</div>
            </div>

            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" name="is_active" id="is_active" value="1" checked>
                    <label for="is_active" class="form-label" style="margin: 0;">
                        <strong>🟢 Kích hoạt tài khoản ngay</strong>
                    </label>
                </div>
                <div class="form-text">Tài khoản sẽ có thể đăng nhập ngay sau khi tạo</div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Tạo tài khoản đăng nhập
                </button>
                <a href="{{ route('admin.student-accounts.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Quay lại
                </a>
            </div>
        </div>
    </form>
</div>
@endsection