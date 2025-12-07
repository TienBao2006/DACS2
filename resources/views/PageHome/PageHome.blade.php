<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trường Học ABC - Nơi Ươm Mầm Tương Lai</title>
    <!-- Tải Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Tải Font Inter cho giao diện hiện đại -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <!-- Cấu hình Tailwind cho màu sắc và font chữ -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#1e40af', // Màu xanh dương đậm (cho brand)
                        'secondary': '#38bdf8', // Màu xanh nhạt hơn
                        'accent': '#fbbf24', // Màu vàng nổi bật (cho nút Tuyển Sinh)
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        /* CSS tùy chỉnh cho hiệu ứng hover và menu */
        .nav-link:hover {
            color: #fbbf24; /* Màu vàng khi hover */
        }
        .dropdown-menu {
            display: none;
            z-index: 10;
        }
        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <!-- HEADER & NAVIGATION -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- 1. LOGO & TÊN TRƯỜNG (Trang Chủ) -->
                <a href="#" class="flex items-center space-x-2">
                    <img src="https://placehold.co/40x40/1e40af/ffffff?text=TH" alt="Logo Trường Học" class="rounded-full">
                    <span class="text-2xl font-bold text-primary">Trường Học ABC</span>
                </a>

                <!-- MENU CHÍNH (Desktop) -->
                <nav class="hidden lg:flex space-x-6 items-center text-sm font-medium">
                    
                    <!-- 2. GIỚI THIỆU (Dropdown) -->
                    <div class="relative dropdown group">
                        <button class="nav-link text-gray-700 p-2 rounded-lg transition duration-150 ease-in-out flex items-center">
                            📝 Giới Thiệu
                            <svg class="ml-1 w-4 h-4 transform group-hover:rotate-180 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="dropdown-menu absolute left-0 mt-3 w-60 bg-white rounded-lg shadow-xl py-2">
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Tổng quan</a>
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Tầm nhìn & Sứ mệnh</a>
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Cơ cấu tổ chức</a>
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Đội ngũ giáo viên</a>
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Cơ sở vật chất</a>
                        </div>
                    </div>

                    <!-- 3. TUYỂN SINH (Nổi bật) -->
                    <div class="relative dropdown group">
                        <button class="bg-accent text-primary p-2 rounded-lg font-bold hover:bg-yellow-400 transition duration-150 ease-in-out flex items-center">
                            🎓 Tuyển Sinh
                            <svg class="ml-1 w-4 h-4 transform group-hover:rotate-180 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="dropdown-menu absolute mt-3 w-64 bg-white rounded-lg shadow-xl py-2">
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Thông báo Tuyển sinh</a>
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Chương trình học các cấp</a>
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Quy trình/Thủ tục nhập học</a>
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Học phí & Chính sách</a>
                            <a href="#" class="block px-4 py-2 text-primary font-semibold hover:bg-gray-100">Đăng ký trực tuyến</a>
                        </div>
                    </div>

                    <!-- 4. ĐÀO TẠO (Dropdown) -->
                    <div class="relative dropdown group">
                        <button class="nav-link text-gray-700 p-2 rounded-lg transition duration-150 ease-in-out flex items-center">
                            📖 Đào Tạo
                            <svg class="ml-1 w-4 h-4 transform group-hover:rotate-180 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="dropdown-menu absolute left-0 mt-3 w-60 bg-white rounded-lg shadow-xl py-2">
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Chương trình chính khóa</a>
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Chương trình ngoại khóa</a>
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Phương pháp giảng dạy</a>
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Thành tích học tập</a>
                        </div>
                    </div>

                    <!-- 5. TIN TỨC & SỰ KIỆN -->
                    <a href="#" class="nav-link text-gray-700 p-2 rounded-lg hover:text-accent">
                        📰 Tin Tức & Sự Kiện
                    </a>
                    
                    <!-- 6. CỔNG THÔNG TIN -->
                    <a href="#" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-secondary transition duration-150 ease-in-out shadow-lg">
                        🌐 Cổng Thông Tin
                    </a>
                    
                    <!-- 7. LIÊN HỆ -->
                    <a href="#" class="nav-link text-gray-700 p-2 rounded-lg hover:text-accent flex items-center">
                        📞 Liên Hệ
                    </a>
                </nav>

                <!-- Nút Hamburger Menu (Mobile) -->
                <button id="mobile-menu-button" class="lg:hidden p-2 rounded-md text-gray-700 hover:text-primary hover:bg-gray-100 transition duration-150 ease-in-out">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>
        </div>

        <!-- MENU MOBILE (Hidden by default) -->
        <div id="mobile-menu" class="lg:hidden hidden bg-white border-t border-gray-100">
            <nav class="px-2 pt-2 pb-3 space-y-1">
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-primary">🏠 Trang Chủ</a>
                
                <!-- Mobile Giới Thiệu -->
                <button onclick="toggleMobileDropdown('gt')" class="w-full text-left flex justify-between items-center px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-primary">
                    📝 Giới Thiệu
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div id="gt-dropdown" class="ml-4 pl-4 border-l border-gray-200 hidden space-y-1">
                    <a href="#" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-50">Tổng quan</a>
                    <a href="#" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-50">Tầm nhìn & Sứ mệnh</a>
                    <!-- ... Các mục con khác ... -->
                </div>

                <!-- Mobile Tuyển Sinh -->
                <button onclick="toggleMobileDropdown('ts')" class="w-full text-left flex justify-between items-center px-3 py-2 rounded-md text-base font-medium bg-accent/20 text-primary hover:bg-accent/40">
                    🎓 Tuyển Sinh
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div id="ts-dropdown" class="ml-4 pl-4 border-l border-gray-200 hidden space-y-1">
                    <a href="#" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-50">Thông báo Tuyển sinh</a>
                    <a href="#" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-50">Đăng ký trực tuyến</a>
                    <!-- ... Các mục con khác ... -->
                </div>
                
                <!-- Mobile Đào Tạo -->
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-primary">📖 Đào Tạo</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-primary">📰 Tin Tức & Sự Kiện</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-primary hover:bg-secondary">🌐 Cổng Thông Tin</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-primary">📞 Liên Hệ</a>
            </nav>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main>
        
        <!-- Phần 1: HERO SECTION (Giới thiệu nổi bật) -->
        <section class="bg-primary/95 text-white py-20 md:py-32">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 leading-tight">
                    Nơi Ươm Mầm Trí Tuệ & Khơi Dậy Đam Mê
                </h1>
                <p class="text-xl md:text-2xl mb-8 opacity-90">
                    Trường Học ABC cam kết mang đến môi trường giáo dục toàn diện, chuẩn quốc tế.
                </p>
                <a href="#" class="bg-accent text-primary px-8 py-4 rounded-xl font-bold text-lg hover:bg-yellow-400 transition duration-300 transform hover:scale-105 shadow-xl">
                    ĐĂNG KÝ TUYỂN SINH NGAY
                </a>
            </div>
        </section>

        <!-- Phần 2: WHY CHOOSE US (Giới Thiệu - 3 Giá Trị Cốt Lõi) -->
        <section class="py-16 md:py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center text-primary mb-12">Tại Sao Chọn Trường Học ABC?</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    
                    <!-- Giá trị 1 -->
                    <div class="text-center p-6 bg-gray-100 rounded-xl shadow-lg hover:shadow-2xl transition duration-300">
                        <div class="text-4xl text-secondary mb-4">💡</div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-800">Chương Trình Đổi Mới</h3>
                        <p class="text-gray-600">Áp dụng các phương pháp giảng dạy tiên tiến, kích thích tư duy phản biện và sáng tạo.</p>
                    </div>

                    <!-- Giá trị 2 -->
                    <div class="text-center p-6 bg-gray-100 rounded-xl shadow-lg hover:shadow-2xl transition duration-300">
                        <div class="text-4xl text-secondary mb-4">🧑‍🏫</div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-800">Đội Ngũ Tận Tâm</h3>
                        <p class="text-gray-600">Giáo viên giàu kinh nghiệm, yêu nghề, luôn đồng hành và hỗ trợ từng học sinh.</p>
                    </div>

                    <!-- Giá trị 3 -->
                    <div class="text-center p-6 bg-gray-100 rounded-xl shadow-lg hover:shadow-2xl transition duration-300">
                        <div class="text-4xl text-secondary mb-4">🌎</div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-800">Môi Trường Toàn Diện</h3>
                        <p class="text-gray-600">Cơ sở vật chất hiện đại, đa dạng hoạt động ngoại khóa, phát triển cả thể chất và tinh thần.</p>
                    </div>

                </div>
            </div>
        </section>

        <!-- Phần 3: TIN TỨC MỚI NHẤT -->
        <section class="py-16 md:py-24 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center text-primary mb-12">Tin Tức & Hoạt Động Nổi Bật</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    
                    <!-- Bài viết 1 -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <img src="https://placehold.co/600x400/38bdf8/ffffff?text=Lễ+Khai+Giảng" alt="Hoạt động" class="w-full h-48 object-cover">
                        <div class="p-5">
                            <span class="text-xs font-semibold text-secondary uppercase">Sự Kiện</span>
                            <h3 class="text-lg font-bold text-gray-800 mt-1 mb-2">Lễ Khai Giảng Năm Học Mới Rực Rỡ</h3>
                            <p class="text-gray-600 text-sm">Nhà trường tổ chức thành công Lễ Khai Giảng, chào đón hơn 1000 học sinh...</p>
                            <a href="#" class="text-primary font-medium text-sm mt-3 inline-block hover:underline">Xem chi tiết &rarr;</a>
                        </div>
                    </div>
                    
                    <!-- Bài viết 2 -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <img src="https://placehold.co/600x400/1e40af/ffffff?text=Học+Sinh+Giỏi" alt="Thành tích" class="w-full h-48 object-cover">
                        <div class="p-5">
                            <span class="text-xs font-semibold text-secondary uppercase">Thành Tích</span>
                            <h3 class="text-lg font-bold text-gray-800 mt-1 mb-2">Học Sinh Khối 9 Đạt Giải Vàng Olympic Toán</h3>
                            <p class="text-gray-600 text-sm">Chúc mừng em Nguyễn Văn A đã mang vinh quang về cho nhà trường tại cuộc thi...</p>
                            <a href="#" class="text-primary font-medium text-sm mt-3 inline-block hover:underline">Xem chi tiết &rarr;</a>
                        </div>
                    </div>
                    
                    <!-- Bài viết 3 -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <img src="https://placehold.co/600x400/fbbf24/1e40af?text=Ngoại+Khóa" alt="Ngoại khóa" class="w-full h-48 object-cover">
                        <div class="p-5">
                            <span class="text-xs font-semibold text-secondary uppercase">Ngoại Khóa</span>
                            <h3 class="text-lg font-bold text-gray-800 mt-1 mb-2">Trải Nghiệm Cắm Trại Rèn Luyện Kỹ Năng Sống</h3>
                            <p class="text-gray-600 text-sm">Chuyến đi ngoại khóa 3 ngày 2 đêm đầy thú vị của các em học sinh khối THCS...</p>
                            <a href="#" class="text-primary font-medium text-sm mt-3 inline-block hover:underline">Xem chi tiết &rarr;</a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Phần 4: CALL TO ACTION - Đăng ký Liên Hệ -->
        <section class="bg-secondary/10 py-16 md:py-20">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold text-primary mb-4">Bạn Có Câu Hỏi?</h2>
                <p class="text-gray-600 mb-8 text-lg">
                    Hãy liên hệ với chúng tôi ngay hôm nay để được tư vấn chi tiết về chương trình học và các chính sách tuyển sinh.
                </p>
                <a href="#" class="bg-primary text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-primary/90 transition duration-300 transform hover:scale-105 shadow-xl">
                    GỬI YÊU CẦU TƯ VẤN 📞
                </a>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer class="bg-gray-800 text-gray-300 pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 border-b border-gray-700 pb-8 mb-8">
                
                <!-- Cột 1: Thông tin liên hệ -->
                <div>
                    <h4 class="text-white text-lg font-semibold mb-4">Trường Học ABC</h4>
                    <p class="text-sm mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Tầng 1, Tòa nhà Giáo dục, TP. HCM
                    </p>
                    <p class="text-sm mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        info@truonghocabc.edu.vn
                    </p>
                    <p class="text-sm flex items-center">
                        <svg class="w-5 h-5 mr-2 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-12a4 4 0 01-4-4v-12z"></path></svg>
                        028.123.4567
                    </p>
                </div>

                <!-- Cột 2: Liên kết nhanh -->
                <div>
                    <h4 class="text-white text-lg font-semibold mb-4">Liên Kết</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-accent transition duration-150">Học phí & Chính sách</a></li>
                        <li><a href="#" class="hover:text-accent transition duration-150">Tuyển dụng Giáo viên</a></li>
                        <li><a href="#" class="hover:text-accent transition duration-150">Chính sách Bảo mật</a></li>
                        <li><a href="#" class="hover:text-accent transition duration-150">Sơ đồ Website</a></li>
                    </ul>
                </div>

                <!-- Cột 3: Cổng thông tin -->
                <div>
                    <h4 class="text-white text-lg font-semibold mb-4">Cổng Thông Tin</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-accent transition duration-150">Dành cho Phụ huynh</a></li>
                        <li><a href="#" class="hover:text-accent transition duration-150">Dành cho Học sinh</a></li>
                        <li><a href="#" class="hover:text-accent transition duration-150">Dành cho Giáo viên</a></li>
                        <li><a href="#" class="hover:text-accent transition duration-150">Thư viện Ảnh</a></li>
                    </ul>
                </div>

                <!-- Cột 4: Kết nối xã hội -->
                <div>
                    <h4 class="text-white text-lg font-semibold mb-4">Theo Dõi Chúng Tôi</h4>
                    <div class="flex space-x-4 text-2xl">
                        <!-- Facebook -->
                        <a href="#" class="hover:text-accent transition duration-150"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.588-1.333h2.412v-3.996h-3.235c-3.51 0-4.765 1.708-4.765 4.686v2.314z"/></svg></a>
                        <!-- YouTube -->
                        <a href="#" class="hover:text-accent transition duration-150"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.228 0-3.897.266-4.356 2.62-4.385 8.814 0 6.195.464 8.549 4.385 8.816 3.6.245 11.626.246 15.228 0 3.897-.266 4.356-2.62 4.385-8.816 0-6.194-.464-8.548-4.385-8.814zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg></a>
                        <!-- Zalo (Dùng Icon placeholder vì không có sẵn trong thư viện phổ biến) -->
                        <a href="#" class="hover:text-accent transition duration-150"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm1 16h-2v-2h2v2zm0-4h-2V7h2v7z"/></svg></a>
                    </div>
                </div>

            </div>

            <!-- Bản quyền -->
            <div class="text-center text-sm text-gray-500 pt-4">
                &copy; 2024 Trường Học ABC. Bảo lưu mọi quyền. Thiết kế bởi Gemini AI.
            </div>
        </div>
    </footer>

    <!-- JAVASCRIPT cho Menu Di động và Dropdown -->
    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        function toggleMobileDropdown(id) {
            const dropdown = document.getElementById(id + '-dropdown');
            dropdown.classList.toggle('hidden');
        }
    </script>
</body>
</html>