@extends('Admin.pageAdmin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-edit-account.css') }}">
@endpush

@section('content')

<div class="edit-account-container">
    <div class="page-header">
        <h1><i class="fas fa-user-edit"></i> Chỉnh sửa tài khoản học sinh</h1>
        <p>Cập nhật thông tin tài khoản và hồ sơ học sinh</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background: linear-gradient(135deg, #d4edda, #c3e6cb); color: #155724; padding: 20px; border-radius: 12px; margin-bottom: 25px; border-left: 5px solid #28a745; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);">
            <i class="fas fa-check-circle" style="margin-right: 10px;"></i>{{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger" style="background: linear-gradient(135deg, #f8d7da, #f5c6cb); color: #721c24; padding: 20px; border-radius: 12px; margin-bottom: 25px; border-left: 5px solid #dc3545; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2);">
            <i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>
            <strong>Có lỗi xảy ra:</strong>
            <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-container">
        <form method="POST" action="{{ route('admin.student-accounts.update', $account->id) }}">
            @csrf
            @method('PUT')

            <!-- Thông tin mã học sinh -->
            @if($student)
            <div class="student-code-display">
                <div class="code">{{ $student->ma_hoc_sinh }}</div>
                <div class="label">Mã học sinh</div>
            </div>
            @endif

            <!-- Thông tin tài khoản -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-user-lock"></i>
                    Thông tin tài khoản
                </h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="username">Tên đăng nhập *</label>
                        <input type="text" id="username" name="username" class="form-control" 
                               value="{{ old('username', $account->username) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Mật khẩu mới (để trống nếu không đổi)</label>
                        <input type="password" id="password" name="password" class="form-control" 
                               placeholder="Nhập mật khẩu mới...">
                    </div>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="is_active" name="is_active" value="1" 
                           {{ old('is_active', $account->is_active) ? 'checked' : '' }}>
                    <label for="is_active">Kích hoạt tài khoản</label>
                </div>
            </div>

            @if($student)
            <!-- Thông tin cá nhân -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-user"></i>
                    Thông tin cá nhân
                </h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="ho_va_ten">Họ và tên *</label>
                        <input type="text" id="ho_va_ten" name="ho_va_ten" class="form-control" 
                               value="{{ old('ho_va_ten', $student->ho_va_ten) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="gioi_tinh">Giới tính *</label>
                        <select id="gioi_tinh" name="gioi_tinh" class="form-control" required>
                            <option value="">Chọn giới tính</option>
                            <option value="Nam" {{ old('gioi_tinh', $student->gioi_tinh) == 'Nam' ? 'selected' : '' }}>Nam</option>
                            <option value="Nữ" {{ old('gioi_tinh', $student->gioi_tinh) == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="ngay_sinh">Ngày sinh *</label>
                        <input type="date" id="ngay_sinh" name="ngay_sinh" class="form-control" 
                               value="{{ old('ngay_sinh', $student->ngay_sinh) }}" required>
                    </div>
                </div>
            </div>

            <!-- Thông tin học tập -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-graduation-cap"></i>
                    Thông tin học tập
                </h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="khoi">Khối *</label>
                        <select id="khoi" name="khoi" class="form-control" required>
                            <option value="">Chọn khối</option>
                            <option value="10" {{ old('khoi', $student->khoi) == '10' ? 'selected' : '' }}>Khối 10</option>
                            <option value="11" {{ old('khoi', $student->khoi) == '11' ? 'selected' : '' }}>Khối 11</option>
                            <option value="12" {{ old('khoi', $student->khoi) == '12' ? 'selected' : '' }}>Khối 12</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="lop">Lớp *</label>
                        <input type="text" id="lop" name="lop" class="form-control" 
                               value="{{ old('lop', $student->lop) }}" placeholder="VD: 10A1, 11B2..." required>
                    </div>
                    
                    <div class="form-group">
                        <label for="nam_hoc">Năm học</label>
                        <input type="text" id="nam_hoc" name="nam_hoc" class="form-control" 
                               value="{{ old('nam_hoc', $student->nam_hoc) }}" placeholder="VD: 2024-2025">
                    </div>
                </div>
            </div>

            <!-- Thông tin liên hệ -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-address-book"></i>
                    Thông tin liên hệ
                </h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="dia_chi">Địa chỉ</label>
                        <input type="text" id="dia_chi" name="dia_chi" class="form-control" 
                               value="{{ old('dia_chi', $student->dia_chi) }}" placeholder="Nhập địa chỉ...">
                    </div>
                    
                    <div class="form-group">
                        <label for="so_dien_thoai">Số điện thoại</label>
                        <input type="tel" id="so_dien_thoai" name="so_dien_thoai" class="form-control" 
                               value="{{ old('so_dien_thoai', $student->so_dien_thoai) }}" placeholder="Nhập số điện thoại...">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" 
                               value="{{ old('email', $student->email) }}" placeholder="Nhập email...">
                    </div>
                </div>
            </div>

            <!-- Thông tin phụ huynh -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-users"></i>
                    Thông tin phụ huynh
                </h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="ten_cha">Tên cha</label>
                        <input type="text" id="ten_cha" name="ten_cha" class="form-control" 
                               value="{{ old('ten_cha', $student->ten_cha) }}" placeholder="Nhập tên cha...">
                    </div>
                    
                    <div class="form-group">
                        <label for="ten_me">Tên mẹ</label>
                        <input type="text" id="ten_me" name="ten_me" class="form-control" 
                               value="{{ old('ten_me', $student->ten_me) }}" placeholder="Nhập tên mẹ...">
                    </div>
                    
                    <div class="form-group">
                        <label for="sdt_phu_huynh">Số điện thoại phụ huynh</label>
                        <input type="tel" id="sdt_phu_huynh" name="sdt_phu_huynh" class="form-control" 
                               value="{{ old('sdt_phu_huynh', $student->sdt_phu_huynh) }}" placeholder="Nhập SĐT phụ huynh...">
                    </div>
                </div>
            </div>
            @endif

            <!-- Nút hành động -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Cập nhật tài khoản
                </button>
                
                <a href="{{ route('admin.student-accounts.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
                
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                    <i class="fas fa-trash"></i> Xóa tài khoản
                </button>
            </div>
        </form>

        <!-- Form xóa ẩn -->
        <form id="deleteForm" method="POST" action="{{ route('admin.student-accounts.destroy', $account->id) }}" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>

<script>
function confirmDelete() {
    if (confirm('Bạn có chắc chắn muốn xóa tài khoản này? Hành động này không thể hoàn tác!')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>

@endsection