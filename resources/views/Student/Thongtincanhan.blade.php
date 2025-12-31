@extends('Student.PageStudent')

@section('title', 'Thông tin cá nhân')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/student-profile.css') }}">
@endpush

@section('content')
<div class="student-profile-container">
    <div class="profile-header">
        <div class="profile-title">
            <i class="fas fa-user-circle"></i>
            <h1>Thông tin cá nhân</h1>
        </div>
        <p class="profile-subtitle">Cập nhật thông tin cá nhân của bạn</p>
    </div>

    @if(isset($student) && $student)
    <div class="profile-form-container">
        <form action="{{ route('student.profile.update', $student->id) }}" method="POST" enctype="multipart/form-data" class="profile-form">
            @csrf
            @method('PUT')
            
            <div class="form-grid">
                <!-- Thông tin cơ bản -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-info-circle"></i>
                        Thông tin cơ bản
                    </h3>
                    
                    <div class="form-group">
                        <label for="ma_hoc_sinh">Mã học sinh</label>
                        <input type="text" id="ma_hoc_sinh" name="ma_hoc_sinh" 
                               value="{{ old('ma_hoc_sinh', $student->ma_hoc_sinh) }}" 
                               class="form-control" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="ho_va_ten">Họ và tên <span class="required">*</span></label>
                        <input type="text" id="ho_va_ten" name="ho_va_ten" 
                               value="{{ old('ho_va_ten', $student->ho_va_ten) }}" 
                               class="form-control" required>
                        @error('ho_va_ten')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ngay_sinh">Ngày sinh <span class="required">*</span></label>
                            <input type="date" id="ngay_sinh" name="ngay_sinh" 
                                   value="{{ old('ngay_sinh', $student->ngay_sinh) }}" 
                                   class="form-control" required>
                            @error('ngay_sinh')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="gioi_tinh">Giới tính <span class="required">*</span></label>
                            <select id="gioi_tinh" name="gioi_tinh" class="form-control" required>
                                <option value="">Chọn giới tính</option>
                                <option value="Nam" {{ old('gioi_tinh', $student->gioi_tinh) == 'Nam' ? 'selected' : '' }}>Nam</option>
                                <option value="Nữ" {{ old('gioi_tinh', $student->gioi_tinh) == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                            </select>
                            @error('gioi_tinh')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Thông tin liên hệ -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-address-book"></i>
                        Thông tin liên hệ
                    </h3>
                    
                    <div class="form-group">
                        <label for="dia_chi">Địa chỉ</label>
                        <textarea id="dia_chi" name="dia_chi" class="form-control" rows="3">{{ old('dia_chi', $student->dia_chi) }}</textarea>
                        @error('dia_chi')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="so_dien_thoai">Số điện thoại</label>
                            <input type="tel" id="so_dien_thoai" name="so_dien_thoai" 
                                   value="{{ old('so_dien_thoai', $student->so_dien_thoai) }}" 
                                   class="form-control" placeholder="0987654321">
                            @error('so_dien_thoai')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" 
                                   value="{{ old('email', $student->email) }}" 
                                   class="form-control" placeholder="student@example.com">
                            @error('email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
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
                            <label for="khoi">Khối <span class="required">*</span></label>
                            <select id="khoi" name="khoi" class="form-control" required>
                                <option value="">Chọn khối</option>
                                <option value="10" {{ old('khoi', $student->khoi) == '10' ? 'selected' : '' }}>Khối 10</option>
                                <option value="11" {{ old('khoi', $student->khoi) == '11' ? 'selected' : '' }}>Khối 11</option>
                                <option value="12" {{ old('khoi', $student->khoi) == '12' ? 'selected' : '' }}>Khối 12</option>
                            </select>
                            @error('khoi')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="lop">Lớp <span class="required">*</span></label>
                            <input type="text" id="lop" name="lop" 
                                   value="{{ old('lop', $student->lop) }}" 
                                   class="form-control" placeholder="A1, A2, ..." required>
                            @error('lop')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="nam_hoc">Năm học</label>
                        <input type="text" id="nam_hoc" name="nam_hoc" 
                               value="{{ old('nam_hoc', $student->nam_hoc ?? '2024-2025') }}" 
                               class="form-control" placeholder="2024-2025">
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
                            <input type="text" id="ten_cha" name="ten_cha" 
                                   value="{{ old('ten_cha', $student->ten_cha) }}" 
                                   class="form-control">
                            @error('ten_cha')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="ten_me">Tên mẹ</label>
                            <input type="text" id="ten_me" name="ten_me" 
                                   value="{{ old('ten_me', $student->ten_me) }}" 
                                   class="form-control">
                            @error('ten_me')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="sdt_phu_huynh">Số điện thoại phụ huynh</label>
                        <input type="tel" id="sdt_phu_huynh" name="sdt_phu_huynh" 
                               value="{{ old('sdt_phu_huynh', $student->sdt_phu_huynh) }}" 
                               class="form-control" placeholder="0987654321">
                        @error('sdt_phu_huynh')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Ảnh đại diện -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-camera"></i>
                        Ảnh đại diện
                    </h3>
                    
                    <div class="avatar-upload">
                        @if(isset($student->anh_dai_dien) && $student->anh_dai_dien)
                            <div class="current-avatar">
                                <img src="{{ asset('uploads/student/' . $student->anh_dai_dien) }}" 
                                     alt="Ảnh đại diện hiện tại" class="avatar-preview">
                                <p class="avatar-label">Ảnh hiện tại</p>
                            </div>
                        @endif
                        
                        <div class="form-group">
                            <label for="anh_dai_dien">Chọn ảnh mới</label>
                            <input type="file" id="anh_dai_dien" name="anh_dai_dien" 
                                   class="form-control" accept="image/*">
                            <small class="form-text">Chấp nhận: JPG, PNG, GIF. Tối đa 2MB</small>
                            @error('anh_dai_dien')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Cập nhật thông tin
                </button>
                <a href="{{ route('student.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Quay lại
                </a>
            </div>
        </form>
    </div>
    @else
    <div class="no-data-message">
        <div class="no-data-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h3>Không tìm thấy thông tin học sinh</h3>
        <p>Vui lòng liên hệ với giáo viên hoặc ban quản trị để được hỗ trợ.</p>
        <a href="{{ route('student.dashboard') }}" class="btn btn-primary">
            <i class="fas fa-home"></i>
            Về trang chủ
        </a>
    </div>
    @endif
</div>

@endsection
