<!DOCTYPE html>
<html class="light" lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Giới thiệu - Trường THPT Bách Khoa Lịch Sử</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&amp;family=Noto+Sans:wght@300..800&amp;display=swap" rel="stylesheet"/>
    
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- Tailwind Config -->
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#197fe6",
                        "primary-dark": "#156cbd",
                        "background-light": "#f6f7f8",
                        "background-dark": "#111921",
                        "surface-light": "#ffffff",
                        "surface-dark": "#1e2936",
                        "text-main": "#111418",
                        "text-muted": "#637588",
                    },
                    fontFamily: {
                        "display": ["Lexend", "sans-serif"],
                        "body": ["Noto Sans", "sans-serif"],
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
    
    <style type="text/tailwindcss">
        @layer utilities {
            .material-symbols-outlined {
                font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            }
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-text-main dark:text-gray-100 flex flex-col min-h-screen overflow-x-hidden">
    <!-- Top Navigation Bar -->
     <header class="sticky top-0 z-50 w-full bg-surface-light dark:bg-surface-dark border-b border-[#f0f2f4] dark:border-gray-700 shadow-sm">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-10">
            <div class="flex items-center justify-between h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center gap-4 lg:gap-8">
                    <a class="flex items-center gap-3 text-text-main dark:text-white hover:opacity-90 transition-opacity" href="#">
                        <div class="size-8 text-primary">
                            <span class="material-symbols-outlined text-3xl">school</span>
                        </div>
                        <h2 class="text-lg font-bold leading-tight tracking-tight hidden sm:block">Trường THPT </h2>
                    </a>
                    <!-- Desktop Menu -->
                    <nav class="hidden lg:flex items-center gap-6 xl:gap-9">
                        <a class="text-sm font-medium text-primary" href="{{ route('homepage') }}">Trang chủ</a>
                                        <a class="text-sm font-medium text-primary" href="{{ route('homepage.news') }}">Tin tức</a>
                        <a class="text-sm font-medium hover:text-primary transition-colors" href="{{ route('homepage.teachers') }}">Giáo viên</a>
                        <a class="text-sm font-medium hover:text-primary transition-colors" href="{{ route('homepage.documents') }}">Tài liệu</a>
                        <a class="text-sm font-medium hover:text-primary transition-colors" href="#">Liên hệ</a>
                    </nav>
                </div>
                <!-- Right Actions -->
                <div class="flex items-center gap-4">
                    <!-- Search Bar (Desktop) -->
                    <label class="hidden md:flex flex-col min-w-40 h-10 w-64 relative group">
                        <div class="flex w-full h-full items-center rounded-lg bg-background-light dark:bg-gray-800 border border-transparent focus-within:border-primary focus-within:ring-1 focus-within:ring-primary transition-all">
                            <div class="pl-3 flex items-center justify-center text-text-muted">
                                <span class="material-symbols-outlined text-[20px]">search</span>
                            </div>
                            <input class="w-full bg-transparent border-none text-sm text-text-main dark:text-white placeholder:text-text-muted focus:ring-0 px-3 h-full" placeholder="Tìm kiếm..."/>
                        </div>
                    </label>
                    <!-- Mobile Search Button -->
                    <button class="md:hidden p-2 text-text-main dark:text-white">
                        <span class="material-symbols-outlined">search</span>
                    </button>
                    <!-- Login Button -->
                    <a href="{{ route('login.form') }}" class="flex items-center justify-center h-10 px-5 rounded-lg bg-primary hover:bg-primary-dark text-white text-sm font-bold transition-colors shadow-sm">
                        <span>Đăng nhập</span>
                    </a>
                    <!-- Mobile Menu Button -->
                    <button class="lg:hidden p-2 text-text-main dark:text-white">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 bg-background-light dark:bg-background-dark">
        <!-- Hero Section -->
        <section class="py-16 bg-gradient-to-r from-primary to-primary-dark text-white">
            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-10 text-center">
                <h1 class="text-4xl lg:text-5xl font-bold mb-6">Giới thiệu về trường</h1>
                <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                    Trường THPT - Nơi ươm mầm tài năng, rèn luyện nhân cách và kiến tạo tương lai vững chắc cho thế hệ trẻ
                </p>
            </div>
        </section>

        <!-- About Content -->
        <section class="py-16">
            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16">
                    <div>
                        <h2 class="text-3xl font-bold text-text-main dark:text-white mb-6">Lịch sử hình thành</h2>
                        <div class="space-y-4 text-text-muted dark:text-gray-300">
                            <p>
                                Trường THPT Bách Khoa Lịch Sử được thành lập vào năm {{ $statistics['establishment_year'] }}, 
                                với sứ mệnh đào tạo thế hệ trẻ có kiến thức vững chắc, kỹ năng toàn diện và phẩm chất đạo đức cao.
                            </p>
                            <p>
                                Qua {{ date('Y') - $statistics['establishment_year'] }} năm xây dựng và phát triển, 
                                nhà trường đã không ngừng nâng cao chất lượng giáo dục, đổi mới phương pháp giảng dạy 
                                và hiện đại hóa cơ sở vật chất.
                            </p>
                            <p>
                                Với đội ngũ {{ $statistics['total_teachers'] }} giáo viên giàu kinh nghiệm và tâm huyết, 
                                trường đã đào tạo hàng nghìn học sinh xuất sắc, nhiều em đạt thành tích cao trong các kỳ thi 
                                học sinh giỏi quốc gia và quốc tế.
                            </p>
                        </div>
                    </div>
                    <div class="bg-surface-light dark:bg-surface-dark rounded-2xl p-8 shadow-lg">
                        <h3 class="text-2xl font-bold text-text-main dark:text-white mb-6 text-center">Thống kê nổi bật</h3>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-primary mb-2">{{ number_format($statistics['total_students']) }}</div>
                                <div class="text-sm text-text-muted dark:text-gray-400">Học sinh</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-primary mb-2">{{ number_format($statistics['total_teachers']) }}</div>
                                <div class="text-sm text-text-muted dark:text-gray-400">Giáo viên</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-primary mb-2">{{ $statistics['total_classes'] }}</div>
                                <div class="text-sm text-text-muted dark:text-gray-400">Lớp học</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-primary mb-2">{{ date('Y') - $statistics['establishment_year'] }}</div>
                                <div class="text-sm text-text-muted dark:text-gray-400">Năm kinh nghiệm</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mission & Vision -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
                    <div class="bg-surface-light dark:bg-surface-dark rounded-2xl p-8 shadow-lg">
                        <div class="text-primary mb-4">
                            <span class="material-symbols-outlined text-5xl">visibility</span>
                        </div>
                        <h3 class="text-2xl font-bold text-text-main dark:text-white mb-4">Tầm nhìn</h3>
                        <p class="text-text-muted dark:text-gray-300">
                            Trở thành một trong những trường THPT hàng đầu khu vực, đào tạo học sinh có năng lực 
                            toàn diện, sẵn sàng hội nhập quốc tế và đóng góp tích cực cho sự phát triển của đất nước.
                        </p>
                    </div>
                    <div class="bg-surface-light dark:bg-surface-dark rounded-2xl p-8 shadow-lg">
                        <div class="text-primary mb-4">
                            <span class="material-symbols-outlined text-5xl">flag</span>
                        </div>
                        <h3 class="text-2xl font-bold text-text-main dark:text-white mb-4">Sứ mệnh</h3>
                        <p class="text-text-muted dark:text-gray-300">
                            Cung cấp nền giáo dục chất lượng cao, phát triển toàn diện nhân cách và năng lực của học sinh, 
                            tạo ra những công dân có trách nhiệm và đóng góp tích cực cho xã hội.
                        </p>
                    </div>
                </div>

                <!-- Core Values -->
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-text-main dark:text-white mb-8">Giá trị cốt lõi</h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="bg-surface-light dark:bg-surface-dark rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                            <div class="text-primary mb-4">
                                <span class="material-symbols-outlined text-4xl">school</span>
                            </div>
                            <h4 class="text-lg font-bold text-text-main dark:text-white mb-2">Chất lượng</h4>
                            <p class="text-sm text-text-muted dark:text-gray-400">Cam kết mang đến chất lượng giáo dục tốt nhất</p>
                        </div>
                        <div class="bg-surface-light dark:bg-surface-dark rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                            <div class="text-primary mb-4">
                                <span class="material-symbols-outlined text-4xl">favorite</span>
                            </div>
                            <h4 class="text-lg font-bold text-text-main dark:text-white mb-2">Tâm huyết</h4>
                            <p class="text-sm text-text-muted dark:text-gray-400">Đặt tình yêu thương học sinh lên hàng đầu</p>
                        </div>
                        <div class="bg-surface-light dark:bg-surface-dark rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                            <div class="text-primary mb-4">
                                <span class="material-symbols-outlined text-4xl">lightbulb</span>
                            </div>
                            <h4 class="text-lg font-bold text-text-main dark:text-white mb-2">Sáng tạo</h4>
                            <p class="text-sm text-text-muted dark:text-gray-400">Khuyến khích tư duy sáng tạo và đổi mới</p>
                        </div>
                        <div class="bg-surface-light dark:bg-surface-dark rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                            <div class="text-primary mb-4">
                                <span class="material-symbols-outlined text-4xl">handshake</span>
                            </div>
                            <h4 class="text-lg font-bold text-text-main dark:text-white mb-2">Hợp tác</h4>
                            <p class="text-sm text-text-muted dark:text-gray-400">Xây dựng tinh thần đoàn kết và hợp tác</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-surface-light dark:bg-surface-dark border-t border-gray-200 dark:border-gray-700 mt-auto">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-10 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-4">Trường THPT Bách Khoa Lịch Sử</h3>
                    <div class="space-y-2 text-sm text-text-muted dark:text-gray-400">
                        <p>Địa chỉ: 123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh</p>
                        <p>Điện thoại: (028) 1234 5678</p>
                        <p>Email: info@bachkhoalichsu.id.vn</p>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-4">Liên kết nhanh</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('homepage') }}" class="text-text-muted dark:text-gray-400 hover:text-primary transition-colors">Trang chủ</a></li>
                        <li><a href="{{ route('homepage.news') }}" class="text-text-muted dark:text-gray-400 hover:text-primary transition-colors">Tin tức</a></li>
                        <li><a href="{{ route('homepage.teachers') }}" class="text-text-muted dark:text-gray-400 hover:text-primary transition-colors">Giáo viên</a></li>
                        <li><a href="{{ route('homepage.documents') }}" class="text-text-muted dark:text-gray-400 hover:text-primary transition-colors">Tài liệu</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-4">Theo dõi chúng tôi</h3>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 bg-blue-600 hover:bg-blue-700 text-white rounded-lg flex items-center justify-center transition-colors">
                            <span class="material-symbols-outlined">facebook</span>
                        </a>
                        <a href="#" class="w-10 h-10 bg-red-600 hover:bg-red-700 text-white rounded-lg flex items-center justify-center transition-colors">
                            <span class="material-symbols-outlined">smart_display</span>
                        </a>
                        <a href="#" class="w-10 h-10 bg-blue-500 hover:bg-blue-600 text-white rounded-lg flex items-center justify-center transition-colors">
                            <span class="material-symbols-outlined">chat</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700 mt-8 pt-8 text-center">
                <p class="text-sm text-text-muted dark:text-gray-400">&copy; 2024 Trường THPT Bách Khoa Lịch Sử. Tất cả quyền được bảo lưu.</p>
            </div>
        </div>
    </footer>
</body>
</html>