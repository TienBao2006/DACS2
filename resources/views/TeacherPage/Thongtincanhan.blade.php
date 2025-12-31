@extends('TeacherPage.TeacherPage')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/teacher-profile.css') }}">
@endpush

@section('content')
    <div class="teacher-form-container">
        <h1>Thông tin cá nhân</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('teacher.update', $teacher->ma_giao_vien ?? '') }}" method="POST"
            enctype="multipart/form-data">
            @csrf

            <div class="teacher-grid">

                <!-- Mã giáo viên -->
                <div class="form-group mb-3">
                    <label for="ma_giao_vien"><i class="fas fa-id-badge"></i> Mã giáo viên</label>
                    <input type="text" id="ma_giao_vien" name="ma_giao_vien" class="form-control"
                        value="{{ $teacher->ma_giao_vien ?? '' }}" readonly style="background-color: #f0f0f0;">
                </div>

                <!-- Username -->
                <div class="form-group mb-3">
                    <label for="username"><i class="fas fa-user"></i> Tên đăng nhập</label>
                    <input type="text" id="username" name="username" class="form-control"
                        value="{{ $account->username ?? '' }}" required">
                </div>

                <!-- Họ tên -->
                <div class="form-group mb-3">
                    <label for="ho_ten"><i class="fas fa-signature"></i> Họ tên</label>
                    <input type="text" id="ho_ten" name="ho_ten" class="form-control"
                        value="{{ $teacher->ho_ten ?? '' }}" required>
                </div>

                <!-- Giới tính -->
                <div class="form-group mb-3">
                    <label for="gioi_tinh">Giới tính</label>
                    <select id="gioi_tinh" name="gioi_tinh" class="form-control" required>
                        <option value="">-- Chọn giới tính --</option>
                        <option value="Nam" {{ ($teacher->gioi_tinh ?? '') == 'Nam' ? 'selected' : '' }}>Nam</option>
                        <option value="Nu" {{ ($teacher->gioi_tinh ?? '') == 'Nu' ? 'selected' : '' }}>Nữ</option>
                    </select>
                </div>

                <!-- Ngày sinh -->
                <div class="form-group mb-3">
                    <label for="ngay_sinh">Ngày sinh</label>
                    <input type="date" id="ngay_sinh" name="ngay_sinh" class="form-control"
                        value="{{ $teacher->ngay_sinh ?? '' }}" required>
                </div>

                <!-- Ảnh đại diện -->
                <div class="form-group mb-3">
                    <label for="anh_dai_dien">Ảnh đại diện</label>
                    <input type="file" id="anh_dai_dien" name="anh_dai_dien" class="form-control">
                </div>

                <!-- CCCD -->
                <div class="form-group mb-3">
                    <label for="cccd">CCCD</label>
                    <input type="text" id="cccd" name="cccd" class="form-control"
                        value="{{ $teacher->cccd ?? '' }}">
                </div>

                <!-- Số điện thoại -->
                <div class="form-group mb-3">
                    <label for="so_dien_thoai">Số điện thoại</label>
                    <input type="text" id="so_dien_thoai" name="so_dien_thoai" class="form-control"
                        value="{{ $teacher->so_dien_thoai ?? '' }}" required>
                </div>

                <!-- Email -->
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control"
                        value="{{ $teacher->email ?? '' }}" required>
                </div>

                <!-- Địa chỉ -->
                <div class="form-group mb-3">
                    <label for="dia_chi">Địa chỉ</label>
                    <input type="text" id="dia_chi" name="dia_chi" class="form-control"
                        value="{{ $teacher->dia_chi ?? '' }}">
                </div>

                <!-- Bằng cấp -->
                <div class="form-group mb-3">
                    <label for="bang_cap">Bằng cấp</label>
                    <input type="text" id="bang_cap" name="bang_cap" class="form-control"
                        value="{{ $teacher->bang_cap ?? '' }}">
                </div>

                <!-- Trình độ chuyên môn -->
                <div class="form-group mb-3">
                    <label for="trinh_do_chuyen_mon">Trình độ chuyên môn</label>
                    <input type="text" id="trinh_do_chuyen_mon" name="trinh_do_chuyen_mon" class="form-control"
                        value="{{ $teacher->trinh_do_chuyen_mon ?? '' }}">
                </div>

                <!-- Tổ chuyên môn -->
                <div class="form-group mb-3">
                    <label for="to_chuyen_mon">Tổ chuyên môn</label>
                    <select id="to_chuyen_mon" name="to_chuyen_mon" class="form-control" required>
                        <option value="">-- Chọn tổ chuyên môn --</option>
                        <option value="Toan" {{ ($teacher->to_chuyen_mon ?? '') == 'Toan' ? 'selected' : '' }}>Tổ Toán
                        </option>
                        <option value="Van" {{ ($teacher->to_chuyen_mon ?? '') == 'Van' ? 'selected' : '' }}>Tổ Ngữ Văn
                        </option>
                        <option value="NgoaiNgu" {{ ($teacher->to_chuyen_mon ?? '') == 'NgoaiNgu' ? 'selected' : '' }}>Tổ
                            Ngoại Ngữ</option>
                        <option value="Ly" {{ ($teacher->to_chuyen_mon ?? '') == 'Ly' ? 'selected' : '' }}>Tổ Vật Lý
                        </option>
                        <option value="Hoa" {{ ($teacher->to_chuyen_mon ?? '') == 'Hoa' ? 'selected' : '' }}>Tổ Hóa Học
                        </option>
                        <option value="Sinh" {{ ($teacher->to_chuyen_mon ?? '') == 'Sinh' ? 'selected' : '' }}>Tổ Sinh
                            Học</option>
                        <option value="SuDiaGDCD" {{ ($teacher->to_chuyen_mon ?? '') == 'SuDiaGDCD' ? 'selected' : '' }}>
                            Tổ Sử - Địa - GDCD</option>
                        <option value="Tin" {{ ($teacher->to_chuyen_mon ?? '') == 'Tin' ? 'selected' : '' }}>Tổ Tin học
                        </option>
                        <option value="TheDuc" {{ ($teacher->to_chuyen_mon ?? '') == 'TheDuc' ? 'selected' : '' }}>Tổ Thể
                            dục</option>
                        <option value="QP" {{ ($teacher->to_chuyen_mon ?? '') == 'QP' ? 'selected' : '' }}>Tổ Quốc
                            phòng</option>
                    </select>

                </div>

                <!-- Môn dạy chính -->
                <div class="form-group mb-3">
                    <label for="mon_day"><i class="fas fa-book"></i> Môn dạy (chính)</label>
                    <select id="mon_day" name="mon_day" class="form-control" required>
                        <option value="">-- Chọn môn dạy --</option>
                        <option value="Toán" {{ ($teacher->mon_day ?? '') == 'Toán' ? 'selected' : '' }}>Toán</option>
                        <option value="Ngữ văn" {{ ($teacher->mon_day ?? '') == 'Ngữ văn' ? 'selected' : '' }}>Ngữ văn
                        </option>
                        <option value="Tiếng Anh" {{ ($teacher->mon_day ?? '') == 'Tiếng Anh' ? 'selected' : '' }}>Tiếng
                            Anh</option>
                        <option value="Vật lý" {{ ($teacher->mon_day ?? '') == 'Vật lý' ? 'selected' : '' }}>Vật lý
                        </option>
                        <option value="Hóa học" {{ ($teacher->mon_day ?? '') == 'Hóa học' ? 'selected' : '' }}>Hóa học
                        </option>
                        <option value="Sinh học" {{ ($teacher->mon_day ?? '') == 'Sinh học' ? 'selected' : '' }}>Sinh học
                        </option>
                        <option value="Lịch sử" {{ ($teacher->mon_day ?? '') == 'Lịch sử' ? 'selected' : '' }}>Lịch sử
                        </option>
                        <option value="Địa lý" {{ ($teacher->mon_day ?? '') == 'Địa lý' ? 'selected' : '' }}>Địa lý
                        </option>
                        <option value="GDCD" {{ ($teacher->mon_day ?? '') == 'GDCD' ? 'selected' : '' }}>GDCD</option>
                        <option value="Thể dục" {{ ($teacher->mon_day ?? '') == 'Thể dục' ? 'selected' : '' }}>Thể dục
                        </option>
                        <option value="Tin học" {{ ($teacher->mon_day ?? '') == 'Tin học' ? 'selected' : '' }}>Tin học
                        </option>
                        <option value="Công nghệ" {{ ($teacher->mon_day ?? '') == 'Công nghệ' ? 'selected' : '' }}>Công
                            nghệ</option>
                        <option value="Âm nhạc" {{ ($teacher->mon_day ?? '') == 'Âm nhạc' ? 'selected' : '' }}>Âm nhạc
                        </option>
                        <option value="Mỹ thuật" {{ ($teacher->mon_day ?? '') == 'Mỹ thuật' ? 'selected' : '' }}>Mỹ thuật
                        </option>
                        <option value="Hoạt động trải nghiệm"
                            {{ ($teacher->mon_day ?? '') == 'Hoạt động trải nghiệm' ? 'selected' : '' }}>Hoạt động trải
                            nghiệm</option>
                        <option value="Giáo dục quốc phòng"
                            {{ ($teacher->mon_day ?? '') == 'Giáo dục quốc phòng' ? 'selected' : '' }}>Giáo dục quốc phòng
                        </option>
                        <option value="Giáo dục kinh tế và pháp luật"
                            {{ ($teacher->mon_day ?? '') == 'Giáo dục kinh tế và pháp luật' ? 'selected' : '' }}>Giáo dục
                            kinh tế và pháp luật</option>

                        <!-- Backward compatibility - check old values without diacritics -->
                        <option value="Toán" {{ ($teacher->mon_day ?? '') == 'Toan' ? 'selected' : '' }}>Toán</option>
                        <option value="Ngữ văn" {{ ($teacher->mon_day ?? '') == 'Van' ? 'selected' : '' }}>Ngữ văn
                        </option>
                        <option value="Tiếng Anh" {{ ($teacher->mon_day ?? '') == 'TiengAnh' ? 'selected' : '' }}>Tiếng
                            Anh</option>
                        <option value="Vật lý" {{ ($teacher->mon_day ?? '') == 'Ly' ? 'selected' : '' }}>Vật lý</option>
                        <option value="Hóa học" {{ ($teacher->mon_day ?? '') == 'Hoa' ? 'selected' : '' }}>Hóa học
                        </option>
                        <option value="Sinh học" {{ ($teacher->mon_day ?? '') == 'Sinh' ? 'selected' : '' }}>Sinh học
                        </option>
                        <option value="Lịch sử" {{ ($teacher->mon_day ?? '') == 'Su' ? 'selected' : '' }}>Lịch sử</option>
                        <option value="Địa lý" {{ ($teacher->mon_day ?? '') == 'Dia' ? 'selected' : '' }}>Địa lý</option>
                        <option value="Thể dục" {{ ($teacher->mon_day ?? '') == 'TheDuc' ? 'selected' : '' }}>Thể dục
                        </option>
                        <option value="Tin học" {{ ($teacher->mon_day ?? '') == 'Tin' ? 'selected' : '' }}>Tin học
                        </option>
                        <option value="Công nghệ" {{ ($teacher->mon_day ?? '') == 'CongNghe' ? 'selected' : '' }}>Công
                            nghệ</option>
                        <option value="Âm nhạc" {{ ($teacher->mon_day ?? '') == 'AmNhac' ? 'selected' : '' }}>Âm nhạc
                        </option>
                        <option value="Mỹ thuật" {{ ($teacher->mon_day ?? '') == 'MyThuat' ? 'selected' : '' }}>Mỹ thuật
                        </option>
                        <option value="Hoạt động trải nghiệm" {{ ($teacher->mon_day ?? '') == 'HDTN' ? 'selected' : '' }}>
                            Hoạt động trải nghiệm</option>
                        <option value="Giáo dục quốc phòng" {{ ($teacher->mon_day ?? '') == 'GDQP' ? 'selected' : '' }}>
                            Giáo dục quốc phòng</option>
                        <option value="Giáo dục kinh tế và pháp luật"
                            {{ ($teacher->mon_day ?? '') == 'GDKTPL' ? 'selected' : '' }}>Giáo dục kinh tế và pháp luật
                        </option>
                    </select>
                </div>


                <!-- Môn kiêm nhiệm -->
                <div class="form-group mb-3">
                    <label for="mon_kiem_nhiem">Môn kiêm nhiệm</label>
                    <select id="mon_kiem_nhiem" name="mon_kiem_nhiem" class="form-control">
                        <option value="">-- Chọn môn kiêm nhiệm --</option>
                        <option value="Toán" {{ ($teacher->mon_kiem_nhiem ?? '') == 'Toán' ? 'selected' : '' }}>Toán
                        </option>
                        <option value="Ngữ văn" {{ ($teacher->mon_kiem_nhiem ?? '') == 'Ngữ văn' ? 'selected' : '' }}>Ngữ
                            văn</option>
                        <option value="Tiếng Anh" {{ ($teacher->mon_kiem_nhiem ?? '') == 'Tiếng Anh' ? 'selected' : '' }}>
                            Tiếng Anh</option>
                        <option value="Vật lý" {{ ($teacher->mon_kiem_nhiem ?? '') == 'Vật lý' ? 'selected' : '' }}>Vật lý
                        </option>
                        <option value="Hóa học" {{ ($teacher->mon_kiem_nhiem ?? '') == 'Hóa học' ? 'selected' : '' }}>Hóa
                            học</option>
                        <option value="Sinh học" {{ ($teacher->mon_kiem_nhiem ?? '') == 'Sinh học' ? 'selected' : '' }}>
                            Sinh học</option>
                        <option value="Lịch sử" {{ ($teacher->mon_kiem_nhiem ?? '') == 'Lịch sử' ? 'selected' : '' }}>Lịch
                            sử</option>
                        <option value="Địa lý" {{ ($teacher->mon_kiem_nhiem ?? '') == 'Địa lý' ? 'selected' : '' }}>Địa lý
                        </option>
                        <option value="GDCD" {{ ($teacher->mon_kiem_nhiem ?? '') == 'GDCD' ? 'selected' : '' }}>GDCD
                        </option>
                        <option value="Thể dục" {{ ($teacher->mon_kiem_nhiem ?? '') == 'Thể dục' ? 'selected' : '' }}>Thể
                            dục</option>
                        <option value="Tin học" {{ ($teacher->mon_kiem_nhiem ?? '') == 'Tin học' ? 'selected' : '' }}>Tin
                            học</option>
                        <option value="Công nghệ" {{ ($teacher->mon_kiem_nhiem ?? '') == 'Công nghệ' ? 'selected' : '' }}>
                            Công nghệ</option>
                        <option value="Âm nhạc" {{ ($teacher->mon_kiem_nhiem ?? '') == 'Âm nhạc' ? 'selected' : '' }}>Âm
                            nhạc</option>
                        <option value="Mỹ thuật" {{ ($teacher->mon_kiem_nhiem ?? '') == 'Mỹ thuật' ? 'selected' : '' }}>Mỹ
                            thuật</option>

                        <!-- Backward compatibility -->
                        <option value="Toán" {{ ($teacher->mon_kiem_nhiem ?? '') == 'Toan' ? 'selected' : '' }}>Toán
                        </option>
                        <option value="Ngữ văn" {{ ($teacher->mon_kiem_nhiem ?? '') == 'Van' ? 'selected' : '' }}>Ngữ văn
                        </option>
                        <option value="Tiếng Anh" {{ ($teacher->mon_kiem_nhiem ?? '') == 'TiengAnh' ? 'selected' : '' }}>
                            Tiếng Anh</option>
                        <option value="Vật lý" {{ ($teacher->mon_kiem_nhiem ?? '') == 'Ly' ? 'selected' : '' }}>Vật lý
                        </option>
                        <option value="Hóa học" {{ ($teacher->mon_kiem_nhiem ?? '') == 'Hoa' ? 'selected' : '' }}>Hóa học
                        </option>
                        <option value="Sinh học" {{ ($teacher->mon_kiem_nhiem ?? '') == 'Sinh' ? 'selected' : '' }}>Sinh
                            học</option>
                        <option value="Lịch sử" {{ ($teacher->mon_kiem_nhiem ?? '') == 'Su' ? 'selected' : '' }}>Lịch sử
                        </option>
                        <option value="Địa lý" {{ ($teacher->mon_kiem_nhiem ?? '') == 'Dia' ? 'selected' : '' }}>Địa lý
                        </option>
                        <option value="Thể dục" {{ ($teacher->mon_kiem_nhiem ?? '') == 'TheDuc' ? 'selected' : '' }}>Thể
                            dục</option>
                        <option value="Tin học" {{ ($teacher->mon_kiem_nhiem ?? '') == 'Tin' ? 'selected' : '' }}>Tin học
                        </option>
                        <option value="Công nghệ" {{ ($teacher->mon_kiem_nhiem ?? '') == 'CongNghe' ? 'selected' : '' }}>
                            Công nghệ</option>
                        <option value="Âm nhạc" {{ ($teacher->mon_kiem_nhiem ?? '') == 'AmNhac' ? 'selected' : '' }}>Âm
                            nhạc</option>
                        <option value="Mỹ thuật" {{ ($teacher->mon_kiem_nhiem ?? '') == 'MyThuat' ? 'selected' : '' }}>Mỹ
                            thuật</option>
                    </select>
                </div>


                <!-- Năm công tác -->
                <div class="form-group mb-3">
                    <label for="nam_cong_tac">Năm công tác</label>
                    <input type="number" id="nam_cong_tac" name="nam_cong_tac" class="form-control"
                        value="{{ $teacher->nam_cong_tac ?? '' }}">
                </div>

                <!-- Kinh nghiệm -->
                <div class="form-group mb-3">
                    <label for="kinh_nghiem">Số năm kinh nghiệm</label>
                    <input type="number" id="kinh_nghiem" name="kinh_nghiem" class="form-control"
                        value="{{ $teacher->kinh_nghiem ?? '' }}" placeholder="Để trống để tự động tính từ năm công tác">
                    <small class="form-text text-muted">
                        Nếu để trống, hệ thống sẽ tự động tính dựa trên năm công tác:
                        {{ date('Y') - ($teacher->nam_cong_tac ?? date('Y')) }} năm
                    </small>
                </div>

                <!-- Chức vụ -->
                <div class="form-group mb-3">
                    <label for="chuc_vu">Chức vụ</label>
                    <select id="chuc_vu" name="chuc_vu" class="form-control" required>
                        <option value="">-- Chọn chức vụ --</option>

                        <option value="GiaoVien" {{ ($teacher->chuc_vu ?? '') == 'GiaoVien' ? 'selected' : '' }}>Giáo viên
                        </option>
                        <option value="ChuNhiem" {{ ($teacher->chuc_vu ?? '') == 'ChuNhiem' ? 'selected' : '' }}>Giáo viên
                            chủ nhiệm</option>
                        <option value="ToTruong" {{ ($teacher->chuc_vu ?? '') == 'ToTruong' ? 'selected' : '' }}>Tổ trưởng
                            chuyên môn</option>
                        <option value="ToPho" {{ ($teacher->chuc_vu ?? '') == 'ToPho' ? 'selected' : '' }}>Tổ phó chuyên
                            môn</option>
                        <option value="PhoHieuTruong"
                            {{ ($teacher->chuc_vu ?? '') == 'PhoHieuTruong' ? 'selected' : '' }}>Phó Hiệu trưởng</option>
                        <option value="HieuTruong" {{ ($teacher->chuc_vu ?? '') == 'HieuTruong' ? 'selected' : '' }}>Hiệu
                            trưởng</option>
                        <option value="NhanVien" {{ ($teacher->chuc_vu ?? '') == 'NhanVien' ? 'selected' : '' }}>Nhân viên
                        </option>
                        <option value="VanThu" {{ ($teacher->chuc_vu ?? '') == 'VanThu' ? 'selected' : '' }}>Văn thư
                        </option>
                        <option value="ThuQuy" {{ ($teacher->chuc_vu ?? '') == 'ThuQuy' ? 'selected' : '' }}>Thủ quỹ
                        </option>
                        <option value="BaoVe" {{ ($teacher->chuc_vu ?? '') == 'BaoVe' ? 'selected' : '' }}>Bảo vệ
                        </option>
                    </select>
                </div>


                <!-- Lớp chủ nhiệm -->
                <div class="form-group mb-3">
                    <label for="lop_chu_nhiem">Lớp chủ nhiệm</label>
                    <select id="lop_chu_nhiem" name="lop_chu_nhiem" class="form-control">
                        <option value="">-- Chọn lớp chủ nhiệm --</option>

                        @php
                            $classes = ['10A', '11A', '12A'];
                            $sections = ['1', '2', '3', '4', '5', '6', '7', '8'];
                        @endphp

                        @foreach ($classes as $class)
                            @foreach ($sections as $sec)
                                <option value="{{ $class . $sec }}"
                                    {{ ($teacher->lop_chu_nhiem ?? '') == $class . $sec ? 'selected' : '' }}>
                                    {{ $class . $sec }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                </div>

                <!-- Mô tả -->
                <div class="form-group mb-3">
                    <label for="mo_ta">Mô tả</label>
                    <textarea id="mo_ta" name="mo_ta" class="form-control" rows="3">{{ $teacher->mo_ta ?? '' }}</textarea>
                </div>

            </div>

            <div class="button-container">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Cập nhật thông tin
                </button>
            </div>
        </form>
    </div>
@endsection
