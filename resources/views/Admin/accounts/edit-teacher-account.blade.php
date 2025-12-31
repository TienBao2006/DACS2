@extends('Admin.pageAdmin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-edit-account.css') }}">
@endpush

@section('content')

<div class="edit-account-container">
    <div class="page-header">
        <h1><i class="fas fa-user-edit"></i> Chỉnh sửa tài khoản giáo viên</h1>
        <p>Cập nhật thông tin tài khoản và hồ sơ giáo viên</p>
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
        <form method="POST" action="{{ route('admin.teacher-accounts.update', $account->id) }}">
            @csrf
            @method('PUT')

            <!-- Thông tin mã giáo viên -->
            @if($teacher)
            <div class="student-code-display">
                <div class="code">{{ $teacher->ma_giao_vien }}</div>
                <div class="label">Mã giáo viên</div>
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

            @if($teacher)
            <!-- Thông tin cá nhân -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-user"></i>
                    Thông tin cá nhân
                </h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="ho_ten">Họ và tên *</label>
                        <input type="text" id="ho_ten" name="ho_ten" class="form-control" 
                               value="{{ old('ho_ten', $teacher->ho_ten) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="gioi_tinh">Giới tính *</label>
                        <select id="gioi_tinh" name="gioi_tinh" class="form-control" required>
                            <option value="">Chọn giới tính</option>
                            <option value="Nam" {{ old('gioi_tinh', $teacher->gioi_tinh) == 'Nam' ? 'selected' : '' }}>Nam</option>
                            <option value="Nữ" {{ old('gioi_tinh', $teacher->gioi_tinh) == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="ngay_sinh">Ngày sinh</label>
                        <input type="date" id="ngay_sinh" name="ngay_sinh" class="form-control" 
                               value="{{ old('ngay_sinh', $teacher->ngay_sinh) }}">
                    </div>
                </div>
            </div>

            <!-- Thông tin nghề nghiệp -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-chalkboard-teacher"></i>
                    Thông tin nghề nghiệp
                </h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="mon_day">Môn dạy</label>
                        <input type="text" id="mon_day" name="mon_day" class="form-control" 
                               value="{{ old('mon_day', $teacher->mon_day) }}" placeholder="VD: Toán, Văn, Anh...">
                    </div>
                    
                    <div class="form-group">
                        <label for="mon_kiem_nhiem">Môn kiêm nhiệm</label>
                        <input type="text" id="mon_kiem_nhiem" name="mon_kiem_nhiem" class="form-control" 
                               value="{{ old('mon_kiem_nhiem', $teacher->mon_kiem_nhiem) }}" placeholder="Môn dạy thêm...">
                    </div>
                    
                    <div class="form-group">
                        <label for="chuc_vu">Chức vụ</label>
                        <select id="chuc_vu" name="chuc_vu" class="form-control">
                            <option value="Giáo viên" {{ old('chuc_vu', $teacher->chuc_vu) == 'Giáo viên' ? 'selected' : '' }}>Giáo viên</option>
                            <option value="Tổ trưởng" {{ old('chuc_vu', $teacher->chuc_vu) == 'Tổ trưởng' ? 'selected' : '' }}>Tổ trưởng</option>
                            <option value="Phó tổ trưởng" {{ old('chuc_vu', $teacher->chuc_vu) == 'Phó tổ trưởng' ? 'selected' : '' }}>Phó tổ trưởng</option>
                            <option value="Giáo viên chủ nhiệm" {{ old('chuc_vu', $teacher->chuc_vu) == 'Giáo viên chủ nhiệm' ? 'selected' : '' }}>Giáo viên chủ nhiệm</option>
                            <option value="Phó hiệu trưởng" {{ old('chuc_vu', $teacher->chuc_vu) == 'Phó hiệu trưởng' ? 'selected' : '' }}>Phó hiệu trưởng</option>
                            <option value="Hiệu trưởng" {{ old('chuc_vu', $teacher->chuc_vu) == 'Hiệu trưởng' ? 'selected' : '' }}>Hiệu trưởng</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="to_chuyen_mon">Tổ chuyên môn</label>
                        <select id="to_chuyen_mon" name="to_chuyen_mon" class="form-control">
                            <option value="">Chọn tổ chuyên môn</option>
                            <option value="Toán - Tin" {{ old('to_chuyen_mon', $teacher->to_chuyen_mon) == 'Toán - Tin' ? 'selected' : '' }}>Toán - Tin</option>
                            <option value="Lý - Hóa" {{ old('to_chuyen_mon', $teacher->to_chuyen_mon) == 'Lý - Hóa' ? 'selected' : '' }}>Lý - Hóa</option>
                            <option value="Sinh - Địa" {{ old('to_chuyen_mon', $teacher->to_chuyen_mon) == 'Sinh - Địa' ? 'selected' : '' }}>Sinh - Địa</option>
                            <option value="Văn - Sử" {{ old('to_chuyen_mon', $teacher->to_chuyen_mon) == 'Văn - Sử' ? 'selected' : '' }}>Văn - Sử</option>
                            <option value="Ngoại ngữ" {{ old('to_chuyen_mon', $teacher->to_chuyen_mon) == 'Ngoại ngữ' ? 'selected' : '' }}>Ngoại ngữ</option>
                            <option value="Thể dục - GDQP" {{ old('to_chuyen_mon', $teacher->to_chuyen_mon) == 'Thể dục - GDQP' ? 'selected' : '' }}>Thể dục - GDQP</option>
                            <option value="Nghệ thuật" {{ old('to_chuyen_mon', $teacher->to_chuyen_mon) == 'Nghệ thuật' ? 'selected' : '' }}>Nghệ thuật</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="lop_chu_nhiem">Lớp chủ nhiệm</label>
                        <input type="text" id="lop_chu_nhiem" name="lop_chu_nhiem" class="form-control" 
                               value="{{ old('lop_chu_nhiem', $teacher->lop_chu_nhiem) }}" placeholder="VD: 10A1, 11B2...">
                    </div>
                    
                    <div class="form-group">
                        <label for="nam_cong_tac">Năm công tác</label>
                        <input type="number" id="nam_cong_tac" name="nam_cong_tac" class="form-control" 
                               value="{{ old('nam_cong_tac', $teacher->nam_cong_tac) }}" min="1990" max="{{ date('Y') }}" placeholder="VD: 2010">
                    </div>
                </div>
            </div>

            <!-- Trình độ học vấn -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-graduation-cap"></i>
                    Trình độ học vấn
                </h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="bang_cap">Bằng cấp</label>
                        <input type="text" id="bang_cap" name="bang_cap" class="form-control" 
                               value="{{ old('bang_cap', $teacher->bang_cap) }}" placeholder="VD: Cử nhân Toán học, Thạc sĩ Văn học...">
                    </div>
                    
                    <div class="form-group">
                        <label for="trinh_do_chuyen_mon">Trình độ chuyên môn</label>
                        <select id="trinh_do_chuyen_mon" name="trinh_do_chuyen_mon" class="form-control">
                            <option value="">Chọn trình độ</option>
                            <option value="Cử nhân" {{ old('trinh_do_chuyen_mon', $teacher->trinh_do_chuyen_mon) == 'Cử nhân' ? 'selected' : '' }}>Cử nhân</option>
                            <option value="Thạc sĩ" {{ old('trinh_do_chuyen_mon', $teacher->trinh_do_chuyen_mon) == 'Thạc sĩ' ? 'selected' : '' }}>Thạc sĩ</option>
                            <option value="Tiến sĩ" {{ old('trinh_do_chuyen_mon', $teacher->trinh_do_chuyen_mon) == 'Tiến sĩ' ? 'selected' : '' }}>Tiến sĩ</option>
                            <option value="Giáo sư" {{ old('trinh_do_chuyen_mon', $teacher->trinh_do_chuyen_mon) == 'Giáo sư' ? 'selected' : '' }}>Giáo sư</option>
                            <option value="Phó giáo sư" {{ old('trinh_do_chuyen_mon', $teacher->trinh_do_chuyen_mon) == 'Phó giáo sư' ? 'selected' : '' }}>Phó giáo sư</option>
                        </select>
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
                        <label for="so_dien_thoai">Số điện thoại</label>
                        <input type="tel" id="so_dien_thoai" name="so_dien_thoai" class="form-control" 
                               value="{{ old('so_dien_thoai', $teacher->so_dien_thoai) }}" placeholder="Nhập số điện thoại...">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" 
                               value="{{ old('email', $teacher->email) }}" placeholder="Nhập email...">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="dia_chi">Địa chỉ</label>
                        <input type="text" id="dia_chi" name="dia_chi" class="form-control" 
                               value="{{ old('dia_chi', $teacher->dia_chi) }}" placeholder="Nhập địa chỉ...">
                    </div>
                </div>
            </div>

            <!-- Mô tả thêm -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-info-circle"></i>
                    Thông tin bổ sung
                </h3>
                
                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="mo_ta">Mô tả</label>
                        <textarea id="mo_ta" name="mo_ta" class="form-control" rows="4" 
                                  placeholder="Thông tin bổ sung về giáo viên...">{{ old('mo_ta', $teacher->mo_ta) }}</textarea>
                    </div>
                </div>
            </div>
            @endif

            <!-- Nút hành động -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Cập nhật tài khoản
                </button>
                
                <a href="{{ route('admin.teacher-accounts.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
                
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                    <i class="fas fa-trash"></i> Xóa tài khoản
                </button>
            </div>
        </form>

        <!-- Form xóa ẩn -->
        <form id="deleteForm" method="POST" action="{{ route('admin.teacher-accounts.destroy', $account->id) }}" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>

<script>
function confirmDelete() {
    if (confirm('Bạn có chắc chắn muốn xóa tài khoản giáo viên này? Hành động này không thể hoàn tác!')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>

@endsection