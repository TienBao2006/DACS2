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
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-control:invalid {
    border-color: #ef4444;
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
    background: #f8fafc;
    border-radius: 8px;
    border: 2px solid #e5e7eb;
}

.checkbox-group input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: #667eea;
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
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
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
            Tạo tài khoản giáo viên
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

    <form action="{{ route('admin.teacher-accounts.store') }}" method="POST" class="form-card">
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
                    <div class="form-text">Tên đăng nhập duy nhất cho giáo viên</div>
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
                    <input type="text" name="ho_ten" class="form-control" 
                           value="{{ old('ho_ten') }}" required>
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
                    <label class="form-label">Ngày sinh</label>
                    <input type="date" name="ngay_sinh" class="form-control" 
                           value="{{ old('ngay_sinh') }}">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Số điện thoại</label>
                    <input type="tel" name="so_dien_thoai" class="form-control" 
                           value="{{ old('so_dien_thoai') }}" placeholder="0987654321">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" 
                           value="{{ old('email') }}" placeholder="teacher@school.edu.vn">
                </div>
                
                <div class="form-group full-width">
                    <label class="form-label">Địa chỉ</label>
                    <textarea name="dia_chi" class="form-control" rows="3">{{ old('dia_chi') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Thông tin nghề nghiệp -->
        <div class="form-section">
            <h3 class="section-title">
                <i class="fas fa-briefcase"></i>
                Thông tin nghề nghiệp
            </h3>
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Bằng cấp</label>
                    <input type="text" name="bang_cap" class="form-control" 
                           value="{{ old('bang_cap') }}" placeholder="Cử nhân, Thạc sĩ, Tiến sĩ...">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Trình độ chuyên môn</label>
                    <input type="text" name="trinh_do_chuyen_mon" class="form-control" 
                           value="{{ old('trinh_do_chuyen_mon') }}">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Tổ chuyên môn</label>
                    <select name="to_chuyen_mon" class="form-control">
                        <option value="">Chọn tổ chuyên môn</option>
                        <option value="Tổ Toán" {{ old('to_chuyen_mon') == 'Tổ Toán' ? 'selected' : '' }}>Tổ Toán</option>
                        <option value="Tổ Văn" {{ old('to_chuyen_mon') == 'Tổ Văn' ? 'selected' : '' }}>Tổ Văn</option>
                        <option value="Tổ Ngoại ngữ" {{ old('to_chuyen_mon') == 'Tổ Ngoại ngữ' ? 'selected' : '' }}>Tổ Ngoại ngữ</option>
                        <option value="Tổ Khoa học tự nhiên" {{ old('to_chuyen_mon') == 'Tổ Khoa học tự nhiên' ? 'selected' : '' }}>Tổ Khoa học tự nhiên</option>
                        <option value="Tổ Khoa học xã hội" {{ old('to_chuyen_mon') == 'Tổ Khoa học xã hội' ? 'selected' : '' }}>Tổ Khoa học xã hội</option>
                        <option value="Tổ Thể chất" {{ old('to_chuyen_mon') == 'Tổ Thể chất' ? 'selected' : '' }}>Tổ Thể chất</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Môn dạy chính</label>
                    <input type="text" name="mon_day" class="form-control" 
                           value="{{ old('mon_day') }}" placeholder="Toán, Văn, Anh...">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Môn kiêm nhiệm</label>
                    <input type="text" name="mon_kiem_nhiem" class="form-control" 
                           value="{{ old('mon_kiem_nhiem') }}">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Năm công tác</label>
                    <input type="number" name="nam_cong_tac" class="form-control" 
                           value="{{ old('nam_cong_tac') }}" min="1990" max="{{ date('Y') }}">
                    <div class="form-text">Năm bắt đầu làm việc</div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Chức vụ</label>
                    <select name="chuc_vu" class="form-control">
                        <option value="Giáo viên" {{ old('chuc_vu') == 'Giáo viên' ? 'selected' : '' }}>Giáo viên</option>
                        <option value="Tổ trưởng" {{ old('chuc_vu') == 'Tổ trưởng' ? 'selected' : '' }}>Tổ trưởng</option>
                        <option value="Phó tổ trưởng" {{ old('chuc_vu') == 'Phó tổ trưởng' ? 'selected' : '' }}>Phó tổ trưởng</option>
                        <option value="Giáo viên chủ nhiệm" {{ old('chuc_vu') == 'Giáo viên chủ nhiệm' ? 'selected' : '' }}>Giáo viên chủ nhiệm</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Lớp chủ nhiệm</label>
                    <input type="text" name="lop_chu_nhiem" class="form-control" 
                           value="{{ old('lop_chu_nhiem') }}" placeholder="10A1, 11B2...">
                </div>
                
                <div class="form-group full-width">
                    <label class="form-label">Mô tả thêm</label>
                    <textarea name="mo_ta" class="form-control" rows="3" 
                              placeholder="Thông tin bổ sung về giáo viên...">{{ old('mo_ta') }}</textarea>
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
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Tạo tài khoản giáo viên
                </button>
                <a href="{{ route('admin.teacher-accounts.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Quay lại
                </a>
            </div>
        </div>
    </form>
</div>
@endsection