<!DOCTYPE html>
<html class="light" lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Trang chủ - Trường THPT Bách Khoa Lịch Sử</title>
    
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
                    <form action="{{ route('homepage.search') }}" method="GET" class="hidden md:flex flex-col min-w-40 h-10 w-64 relative group">
                        <div class="flex w-full h-full items-center rounded-lg bg-background-light dark:bg-gray-800 border border-transparent focus-within:border-primary focus-within:ring-1 focus-within:ring-primary transition-all">
                            <div class="pl-3 flex items-center justify-center text-text-muted">
                                <span class="material-symbols-outlined text-[20px]">search</span>
                            </div>
                            <input name="q" id="searchInput" class="w-full bg-transparent border-none text-sm text-text-main dark:text-white placeholder:text-text-muted focus:ring-0 px-3 h-full" placeholder="Tìm kiếm..." autocomplete="off"/>
                        </div>
                        <!-- Search Results Dropdown -->
                        <div id="searchResults" class="absolute top-full left-0 right-0 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg shadow-lg mt-1 hidden z-50 max-h-80 overflow-y-auto">
                            <!-- Results will be populated here -->
                        </div>
                    </form>
                    <!-- Mobile Search Button -->
                    <button id="mobileSearchBtn" class="md:hidden p-2 text-text-main dark:text-white">
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

    <!-- Hero Section -->
    @if($banners->count() > 0)
        @foreach($banners->take(1) as $banner)
        <section class="relative w-full bg-surface-light dark:bg-surface-dark">
            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-10 py-5 lg:py-8">
                <div class="relative w-full rounded-2xl overflow-hidden min-h-[480px] flex flex-col items-center justify-center p-8 text-center bg-cover bg-center shadow-md group" 
                     style="background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.6)), url('{{ $banner->image_url }}');">
                    <div class="flex flex-col gap-4 max-w-3xl z-10 animate-fade-in-up">
                        <h1 class="text-white text-4xl md:text-5xl lg:text-6xl font-black leading-tight tracking-tight drop-shadow-sm">
                            {{ $banner->title ?? 'Chào mừng đến với Trường THPT Bách Khoa Lịch Sử' }}
                        </h1>
                        <h2 class="text-gray-100 text-base md:text-lg font-medium leading-relaxed max-w-2xl mx-auto drop-shadow-sm">
                            {{ $banner->description ?? 'Nơi ươm mầm tài năng, rèn luyện nhân cách và kiến tạo tương lai vững chắc cho thế hệ trẻ.' }}
                        </h2>
                    </div>
                    <div class="flex flex-wrap gap-4 mt-8 z-10 justify-center">
                        @if($banner->button_text && $banner->button_url)
                        <a href="{{ route('homepage.news') }}" class="flex items-center justify-center h-12 px-8 rounded-lg bg-primary hover:bg-primary-dark text-white text-base font-bold shadow-lg transition-transform hover:-translate-y-0.5">
                            <span>Tìm hiểu thêm</span>
                        </a>
                        @else
                        <a href="{{ route('homepage.news') }}" class="flex items-center justify-center h-12 px-8 rounded-lg bg-primary hover:bg-primary-dark text-white text-base font-bold shadow-lg transition-transform hover:-translate-y-0.5">
                            <span>Tìm hiểu thêm</span>
                        </a>
                        @endif
                        <a href="{{ route('login.form') }}" class="flex items-center justify-center h-12 px-8 rounded-lg bg-white/90 hover:bg-white text-text-main text-base font-bold backdrop-blur-sm transition-colors">
                            <span>Đăng nhập hệ thống</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        @endforeach
    @else
    <section class="relative w-full bg-surface-light dark:bg-surface-dark">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-10 py-5 lg:py-8">
            <div class="relative w-full rounded-2xl overflow-hidden min-h-[480px] flex flex-col items-center justify-center p-8 text-center bg-cover bg-center shadow-md group" 
                 style="background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.6)), url('https://lh3.googleusercontent.com/aida-public/AB6AXuDz4fXOcOX6On0Vz9FgSw4a341gC5WNJuy_TgHINkuC9wRZN_UNSwYW-Ajzbr8GOeYVo7Ph8P8rkDx4uIR_0vLwObFdQKZnWQGJ-fkfYtlwm-3NURYeW8QVcxZLakY_gTCZoaIVuUDgjgvj47gZ4k_lnU-Kug1OubrfbhNvSH-kvaCXSyaUHI-jBOfODq2vgo69oCmd6Wss0UApXLnAAVijevoAwHeg8k1ea5JzSbc_QL8LKELMbXzm4lGY_WGGTAZdCA1L69voVUO_');">
                <div class="flex flex-col gap-4 max-w-3xl z-10 animate-fade-in-up">
                    <h1 class="text-white text-4xl md:text-5xl lg:text-6xl font-black leading-tight tracking-tight drop-shadow-sm">
                        Chào mừng đến với Trường THPT Chuyên
                    </h1>
                    <h2 class="text-gray-100 text-base md:text-lg font-medium leading-relaxed max-w-2xl mx-auto drop-shadow-sm">
                        Nơi ươm mầm tài năng, rèn luyện nhân cách và kiến tạo tương lai vững chắc cho thế hệ trẻ.
                    </h2>
                </div>
                <div class="flex flex-wrap gap-4 mt-8 z-10 justify-center">
                    <a href="{{ route('homepage.news') }}" class="flex items-center justify-center h-12 px-8 rounded-lg bg-primary hover:bg-primary-dark text-white text-base font-bold shadow-lg transition-transform hover:-translate-y-0.5">
                        <span>Tìm hiểu thêm</span>
                    </a>
                    <a href="{{ route('login.form') }}" class="flex items-center justify-center h-12 px-8 rounded-lg bg-white/90 hover:bg-white text-text-main text-base font-bold backdrop-blur-sm transition-colors">
                        <span>Đăng nhập hệ thống</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- Quick Links (Feature Section) -->
    <section class="py-8 bg-surface-light dark:bg-surface-dark border-b border-gray-100 dark:border-gray-800">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-10">
            <div class="flex flex-col md:flex-row gap-8 items-start md:items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-text-main dark:text-white mb-2">Lối tắt</h2>
                    <p class="text-text-muted dark:text-gray-400">Truy cập nhanh các dịch vụ số của nhà trường.</p>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Card 1: Cổng thông tin -->
                <a class="flex flex-col p-5 rounded-xl border border-[#dce0e5] dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-primary hover:shadow-md transition-all group" href="{{ route('login.form') }}">
                    <div class="mb-4 text-primary group-hover:scale-110 transition-transform origin-left">
                        <span class="material-symbols-outlined text-4xl">public</span>
                    </div>
                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-1">Cổng thông tin</h3>
                    <p class="text-sm text-text-muted dark:text-gray-400">Tra cứu điểm số</p>
                </a>
                <!-- Card 2: Thời khóa biểu -->
                <a class="flex flex-col p-5 rounded-xl border border-[#dce0e5] dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-primary hover:shadow-md transition-all group" href="{{ route('login.form') }}">
                    <div class="mb-4 text-primary group-hover:scale-110 transition-transform origin-left">
                        <span class="material-symbols-outlined text-4xl">calendar_month</span>
                    </div>
                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-1">Thời khóa biểu</h3>
                    <p class="text-sm text-text-muted dark:text-gray-400">Lịch học chi tiết</p>
                </a>
                <!-- Card 3: Thư viện số -->
                <a class="flex flex-col p-5 rounded-xl border border-[#dce0e5] dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-primary hover:shadow-md transition-all group" href="{{ route('homepage.documents') }}">
                    <div class="mb-4 text-primary group-hover:scale-110 transition-transform origin-left">
                        <span class="material-symbols-outlined text-4xl">local_library</span>
                    </div>
                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-1">Thư viện số</h3>
                    <p class="text-sm text-text-muted dark:text-gray-400">Tài liệu học tập</p>
                </a>
                <!-- Card 4: Liên hệ GVCN -->
                <a class="flex flex-col p-5 rounded-xl border border-[#dce0e5] dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-primary hover:shadow-md transition-all group" href="{{ route('homepage.teachers') }}">
                    <div class="mb-4 text-primary group-hover:scale-110 transition-transform origin-left">
                        <span class="material-symbols-outlined text-4xl">person_pin</span>
                    </div>
                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-1">Liên hệ GVCN</h3>
                    <p class="text-sm text-text-muted dark:text-gray-400">Kết nối giáo viên</p>
                </a>
            </div>
        </div>
    </section>
    <!-- Main Content: News & Announcements -->
    <section class="flex-grow py-10 bg-background-light dark:bg-background-dark">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Left Column: Latest News (Chiếm 8 phần) -->
                <div class="lg:col-span-8 flex flex-col gap-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-text-main dark:text-white">Tin tức mới nhất</h2>
                        <a class="text-primary hover:text-primary-dark font-medium text-sm flex items-center gap-1" href="{{ route('homepage.news') }}">
                            Xem tất cả <span class="material-symbols-outlined text-base">arrow_forward</span>
                        </a>
                    </div>
                    
                    @if($featuredNews->count() > 0)
                    <!-- Featured News Item (Large) -->
                    @php $firstNews = $featuredNews->first(); @endphp
                    <div class="group relative flex flex-col md:flex-row gap-0 md:gap-6 bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all">
                        <div class="w-full md:w-2/5 h-48 md:h-auto overflow-hidden">
                            <div class="w-full h-full bg-cover bg-center transition-transform duration-500 group-hover:scale-105" 
                                 style="background-image: url('{{ $firstNews->image_url }}');"></div>
                        </div>
                        <div class="flex flex-col justify-center p-6 flex-1">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="bg-primary/10 text-primary text-xs font-bold px-2 py-1 rounded">{{ $firstNews->category ?? 'Hoạt động' }}</span>
                                <span class="text-text-muted dark:text-gray-400 text-xs flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">schedule</span> {{ $firstNews->created_at->format('d/m/Y') }}
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-text-main dark:text-white mb-2 group-hover:text-primary transition-colors">
                                <a href="{{ route('homepage.news.detail', $firstNews->id) }}">{{ $firstNews->title }}</a>
                            </h3>
                            <p class="text-text-muted dark:text-gray-400 text-sm line-clamp-2 mb-4">
                                {{ Str::limit($firstNews->summary ?? $firstNews->content, 150) }}
                            </p>
                        </div>
                    </div>
                    @else
                    <!-- Default Featured News -->
                    <div class="group relative flex flex-col md:flex-row gap-0 md:gap-6 bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all">
                        <div class="w-full md:w-2/5 h-48 md:h-auto overflow-hidden">
                            <div class="w-full h-full bg-cover bg-center transition-transform duration-500 group-hover:scale-105" 
                                 style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBb9UjdxfM8byN_p6-nsX-9RBPQJeTR9t2P8uB0oSlwAgKscxn3UeIuYKwfizPFQmca9AkttLZp9SYMXViWzmTNw0XRatUvL11sHUUFXm1iIuMGVJjahrJ4ilMnTHTopLSvTzP6DH9D_Nyo0bbZaqpKlolY6oTd9K1za50-y_ZtEwrOsgJvX0NqqgJwbSiQ_XTL3Z4-Ptqk3uPSkwT6U8A4_BeGb3B4bl1lfOMGeyTsoPbI6103nTuddV3fMdVt2m8CekdO8fkrLbwG');"></div>
                        </div>
                        <div class="flex flex-col justify-center p-6 flex-1">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="bg-primary/10 text-primary text-xs font-bold px-2 py-1 rounded">Hoạt động</span>
                                <span class="text-text-muted dark:text-gray-400 text-xs flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">schedule</span> 16/05/2024
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-text-main dark:text-white mb-2 group-hover:text-primary transition-colors">
                                <a href="#">Học sinh trường THPT Chuyên đạt giải Nhất cuộc thi KHKT Quốc gia</a>
                            </h3>
                            <p class="text-text-muted dark:text-gray-400 text-sm line-clamp-2 mb-4">
                                Đội tuyển Robotics của trường đã xuất sắc vượt qua hàng trăm đội thi để giành huy chương vàng với dự án cánh tay robot hỗ trợ người khuyết tật.
                            </p>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Secondary News Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($latestNews->count() >= 2)
                            @foreach($latestNews->skip(1)->take(2) as $news)
                            <article class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all group h-full flex flex-col">
                                <div class="h-48 overflow-hidden relative">
                                    <div class="w-full h-full bg-cover bg-center transition-transform duration-500 group-hover:scale-105" 
                                         style="background-image: url('{{ $news->image_url }}');"></div>
                                </div>
                                <div class="p-5 flex flex-col flex-1">
                                    <div class="text-xs text-text-muted dark:text-gray-400 mb-2">{{ $news->created_at->format('d/m/Y') }}</div>
                                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-2 line-clamp-2 group-hover:text-primary transition-colors">
                                        <a href="{{ route('homepage.news.detail', $news->id) }}">{{ $news->title }}</a>
                                    </h3>
                                    <p class="text-sm text-text-muted dark:text-gray-400 line-clamp-3 mb-4 flex-1">
                                        {{ Str::limit($news->summary ?? $news->content, 120) }}
                                    </p>
                                </div>
                            </article>
                            @endforeach
                        @else
                        <!-- Default News Cards -->
                        <article class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all group h-full flex flex-col">
                            <div class="h-48 overflow-hidden relative">
                                <div class="w-full h-full bg-cover bg-center transition-transform duration-500 group-hover:scale-105" 
                                     style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAlXWIOS9JxXCHDBxlo1bq0gmxZzCGv5wtvUBZIWjYAdrjhQiuJmRt-RkfQGMetS4LkT14Rj-ZjEe94-jH_MtapUv8bDw_1cyZUY_DYNDSEV0jiCDFnOnx5za7KnUwmUpPSUZap9fjU4F4XykaxH899Lh1E_ZYYaVD4bVXktqV965Ghi4BZHbag99nEj6IufLx60gFHMVS6NZdffvHEkWpCcAkPyYc6YbPPqsmp467urIa094LY00h1B5LLnDft4BEu2Q47X0jr9UG4');"></div>
                            </div>
                            <div class="p-5 flex flex-col flex-1">
                                <div class="text-xs text-text-muted dark:text-gray-400 mb-2">14/05/2024</div>
                                <h3 class="text-lg font-bold text-text-main dark:text-white mb-2 line-clamp-2 group-hover:text-primary transition-colors">
                                    <a href="#">Hội thảo hướng nghiệp: "Định vị bản thân - Kiến tạo tương lai"</a>
                                </h3>
                                <p class="text-sm text-text-muted dark:text-gray-400 line-clamp-3 mb-4 flex-1">
                                    Chương trình thu hút sự tham gia của hơn 500 học sinh khối 12 cùng các diễn giả nổi tiếng đến từ các trường đại học hàng đầu.
                                </p>
                            </div>
                        </article>
                        <article class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all group h-full flex flex-col">
                            <div class="h-48 overflow-hidden relative">
                                <div class="w-full h-full bg-cover bg-center transition-transform duration-500 group-hover:scale-105" 
                                     style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAeCttrgCMONysYBrnY-jurx0XN1b7sTxfNRCqw5syMzREwZh_JlFTR0K3RmkGqqZfJmxy0Ep4s6p-1QB9E0aK8WvJGUu4rZv-Z6QZhiXVACzc8IeP0EbHX1eZQ8I2URUAAvPdzjuDbpaw59yGIIvWeDLOErwlRjYogeqx5Fbtc2oDQkb2TrNU-Kjjdd1nmYqVe2Lqwtv6A2bxXLsU5tBeSr6vrpEdgSuU8ssWADJ5hXsT8VTKUVHUzgqbxN52iASq4hWbr2jdjPEry');"></div>
                            </div>
                            <div class="p-5 flex flex-col flex-1">
                                <div class="text-xs text-text-muted dark:text-gray-400 mb-2">12/05/2024</div>
                                <h3 class="text-lg font-bold text-text-main dark:text-white mb-2 line-clamp-2 group-hover:text-primary transition-colors">
                                    <a href="#">Khai mạc giải bóng đá nam học sinh chào mừng ngày thành lập Đoàn</a>
                                </h3>
                                <p class="text-sm text-text-muted dark:text-gray-400 line-clamp-3 mb-4 flex-1">
                                    Không khí sôi động tại sân vận động trường với những trận cầu kịch tính ngay từ vòng bảng.
                                </p>
                            </div>
                        </article>
                        @endif
                    </div>
                </div>
                
                <!-- Right Column: Announcements (Chiếm 4 phần) -->
                <div class="lg:col-span-4 flex flex-col gap-6">
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden h-full">
                        <!-- Header -->
                        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 flex items-center justify-between">
                            <h2 class="text-lg font-bold text-text-main dark:text-white flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">notifications_active</span>
                                Thông báo
                            </h2>
                            <a class="text-xs font-semibold text-primary hover:underline" href="{{ route('homepage.notifications') }}">Xem tất cả</a>
                        </div>
                        <!-- List Items -->
                        <div class="divide-y divide-gray-100 dark:divide-gray-700">
                            @if($notifications->count() > 0)
                                @foreach($notifications->take(5) as $index => $notification)
                                <div class="p-5 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group cursor-pointer">
                                    <div class="flex items-start gap-3">
                                        @if($index === 0 && $notification->priority === 'urgent')
                                        <div class="flex flex-col items-center min-w-[50px] bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg p-1.5 border border-red-200 dark:border-red-800">
                                            <span class="text-xs font-bold uppercase">{{ $notification->created_at->format('M') }}</span>
                                            <span class="text-lg font-bold leading-none">{{ $notification->created_at->format('d') }}</span>
                                        </div>
                                        @elseif($index === 0)
                                        <div class="flex flex-col items-center min-w-[50px] bg-primary/10 text-primary rounded-lg p-1.5 border border-primary/20">
                                            <span class="text-xs font-bold uppercase">{{ $notification->created_at->format('M') }}</span>
                                            <span class="text-lg font-bold leading-none">{{ $notification->created_at->format('d') }}</span>
                                        </div>
                                        @else
                                        <div class="flex flex-col items-center min-w-[50px] bg-gray-100 dark:bg-gray-700 text-text-muted rounded-lg p-1.5 border border-gray-200 dark:border-gray-600">
                                            <span class="text-xs font-bold uppercase">{{ $notification->created_at->format('M') }}</span>
                                            <span class="text-lg font-bold leading-none">{{ $notification->created_at->format('d') }}</span>
                                        </div>
                                        @endif
                                        <div class="flex flex-col gap-1 flex-1">
                                            <div class="flex items-start justify-between gap-2">
                                                <h3 class="text-sm font-semibold text-text-main dark:text-white group-hover:text-primary transition-colors leading-snug flex-1">
                                                    {{ Str::limit($notification->title, 80) }}
                                                </h3>
                                                @if($notification->priority === 'urgent')
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 flex-shrink-0">
                                                    Khẩn
                                                </span>
                                                @elseif($notification->priority === 'high')
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200 flex-shrink-0">
                                                    Quan trọng
                                                </span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-text-muted dark:text-gray-400">
                                                @php
                                                    // Xác định phòng ban dựa trên nội dung thông báo
                                                    $department = 'Ban Giám hiệu';
                                                    if (str_contains(strtolower($notification->title), 'thi') || str_contains(strtolower($notification->content), 'đào tạo')) {
                                                        $department = 'Phòng Đào tạo';
                                                    } elseif (str_contains(strtolower($notification->title), 'đoàn') || str_contains(strtolower($notification->content), 'đoàn')) {
                                                        $department = 'Đoàn Thanh niên';
                                                    } elseif (str_contains(strtolower($notification->title), 'học phí') || str_contains(strtolower($notification->content), 'tài chính')) {
                                                        $department = 'Phòng Tài chính';
                                                    } elseif (str_contains(strtolower($notification->title), 'tuyển sinh')) {
                                                        $department = 'Phòng Tuyển sinh';
                                                    }
                                                @endphp
                                                {{ $department }} • {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                            @if($notification->content && strlen($notification->content) > 0)
                                            <p class="text-xs text-text-muted dark:text-gray-500 mt-1 line-clamp-2">
                                                {{ Str::limit($notification->content, 100) }}
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                            <!-- Default Notifications -->
                            <div class="p-5 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group cursor-pointer">
                                <div class="flex items-start gap-3">
                                    <div class="flex flex-col items-center min-w-[50px] bg-primary/10 text-primary rounded-lg p-1.5 border border-primary/20">
                                        <span class="text-xs font-bold uppercase">Th.12</span>
                                        <span class="text-lg font-bold leading-none">24</span>
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <h3 class="text-sm font-semibold text-text-main dark:text-white group-hover:text-primary transition-colors leading-snug">
                                            Chưa có thông báo mới
                                        </h3>
                                        <p class="text-xs text-text-muted dark:text-gray-400">Hệ thống</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <!-- Footer Action -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('homepage.notifications') }}" class="w-full flex items-center justify-center gap-2 text-sm font-medium text-text-muted hover:text-primary transition-colors py-2">
                                <span class="material-symbols-outlined text-lg">history</span>
                                Xem thông báo cũ hơn
                            </a>
                        </div>
                    </div>
                    
                    <!-- Small Banner / Ad Space -->
                    <div class="rounded-xl overflow-hidden relative min-h-[160px] flex items-center p-6 bg-gradient-to-r from-primary to-blue-500 shadow-md">
                        <div class="relative z-10 flex flex-col gap-3">
                            <h3 class="text-white font-bold text-xl">Tuyển sinh 2024</h3>
                            <p class="text-white/90 text-sm max-w-[200px]">Đăng ký trực tuyến hồ sơ xét tuyển vào lớp 10 năm học 2024-2025.</p>
                            <button class="bg-white text-primary text-xs font-bold py-2 px-4 rounded-lg w-fit hover:bg-gray-50 transition-colors">Đăng ký ngay</button>
                        </div>
                        <div class="absolute right-0 bottom-0 opacity-20 text-white transform translate-x-4 translate-y-4">
                            <span class="material-symbols-outlined text-[150px]">edit_document</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-16 bg-gradient-to-r from-primary to-primary-dark">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-10">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">Trường THPT Bách Khoa Lịch Sử</h2>
                <p class="text-blue-100 text-lg max-w-2xl mx-auto">Những con số ấn tượng về cộng đồng giáo dục của chúng tôi</p>
            </div>
            
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Học sinh -->
                <div class="text-center">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all">
                        <div class="text-white mb-4">
                            <span class="material-symbols-outlined text-5xl">school</span>
                        </div>
                        <div class="text-4xl font-bold text-white mb-2">{{ number_format($statistics['total_students']) }}</div>
                        <div class="text-blue-100 font-medium">Học sinh</div>
                    </div>
                </div>
                
                <!-- Giáo viên -->
                <div class="text-center">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all">
                        <div class="text-white mb-4">
                            <span class="material-symbols-outlined text-5xl">person</span>
                        </div>
                        <div class="text-4xl font-bold text-white mb-2">{{ number_format($statistics['total_teachers']) }}</div>
                        <div class="text-blue-100 font-medium">Giáo viên</div>
                    </div>
                </div>
                
                <!-- Tin tức -->
                <div class="text-center">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all">
                        <div class="text-white mb-4">
                            <span class="material-symbols-outlined text-5xl">newspaper</span>
                        </div>
                        <div class="text-4xl font-bold text-white mb-2">{{ number_format($statistics['total_news']) }}</div>
                        <div class="text-blue-100 font-medium">Tin tức</div>
                    </div>
                </div>
                
                <!-- Tài liệu -->
                <div class="text-center">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all">
                        <div class="text-white mb-4">
                            <span class="material-symbols-outlined text-5xl">folder</span>
                        </div>
                        <div class="text-4xl font-bold text-white mb-2">{{ number_format($statistics['total_documents']) }}</div>
                        <div class="text-blue-100 font-medium">Tài liệu</div>
                    </div>
                </div>
            </div>
            
            <!-- Additional Info -->
            <div class="mt-12 text-center">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 max-w-4xl mx-auto">
                    <h3 class="text-2xl font-bold text-white mb-4">Thành tích nổi bật</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                        <div>
                            <div class="text-3xl font-bold text-white mb-2">95%</div>
                            <div class="text-blue-100">Tỷ lệ đỗ đại học</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-white mb-2">50+</div>
                            <div class="text-blue-100">Giải thưởng học sinh giỏi</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-white mb-2">20+</div>
                            <div class="text-blue-100">Năm kinh nghiệm</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-background-dark text-white pt-12 pb-8 border-t border-gray-800">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-10">
                <!-- Brand Info -->
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-3">
                        <div class="size-8 text-primary">
                            <svg fill="currentColor" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                <path clip-rule="evenodd" d="M12.0799 24L4 19.2479L9.95537 8.75216L18.04 13.4961L18.0446 4H29.9554L29.96 13.4961L38.0446 8.75216L44 19.2479L35.92 24L44 28.7521L38.0446 39.2479L29.96 34.5039L29.9554 44H18.0446L18.04 34.5039L9.95537 39.2479L4 28.7521L12.0799 24Z" fill="currentColor" fill-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="font-bold text-lg">THPT Bách Khoa Lịch Sử</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Môi trường giáo dục tiên tiến, hiện đại, nơi nuôi dưỡng những tài năng tương lai của đất nước.
                    </p>
                    <div class="flex gap-4 mt-2">
                        <a class="text-gray-400 hover:text-white transition-colors" href="#"><span class="material-symbols-outlined">public</span></a>
                        <a class="text-gray-400 hover:text-white transition-colors" href="#"><span class="material-symbols-outlined">group</span></a>
                        <a class="text-gray-400 hover:text-white transition-colors" href="#"><span class="material-symbols-outlined">mail</span></a>
                    </div>
                </div>
                <!-- Contact -->
                <div>
                    <h3 class="font-bold text-white mb-4">Liên hệ</h3>
                    <ul class="flex flex-col gap-3 text-sm text-gray-400">
                        <li class="flex items-start gap-2">
                            <span class="material-symbols-outlined text-base mt-0.5">location_on</span>
                            <span>Số 01 Đại lộ Thăng Long, Hà Nội</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-base">call</span>
                            <span>(024) 3789 1234</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-base">email</span>
                            <span>contact@thptchuyen.edu.vn</span>
                        </li>
                    </ul>
                </div>
                <!-- Links -->
                <div>
                    <h3 class="font-bold text-white mb-4">Liên kết nhanh</h3>
                    <ul class="flex flex-col gap-2 text-sm text-gray-400">
                        <li><a class="hover:text-primary transition-colors" href="#">Giới thiệu chung</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Đội ngũ giáo viên</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Cơ sở vật chất</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Thành tích học sinh</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Thư viện ảnh</a></li>
                    </ul>
                </div>
                <!-- Newsletter -->
                <div>
                    <h3 class="font-bold text-white mb-4">Đăng ký nhận tin</h3>
                    <p class="text-xs text-gray-400 mb-3">Nhận các thông báo mới nhất về tuyển sinh và hoạt động trường.</p>
                    <div class="flex gap-2">
                        <input class="bg-gray-800 border border-gray-700 text-sm text-white rounded px-3 py-2 w-full focus:ring-1 focus:ring-primary focus:border-primary" placeholder="Email của bạn" type="email"/>
                        <button class="bg-primary hover:bg-primary-dark text-white p-2 rounded flex items-center justify-center">
                            <span class="material-symbols-outlined text-lg">send</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs text-gray-500">© {{ date('Y') }} Trường THPT Chuyên. All rights reserved.</p>
                <div class="flex gap-6 text-xs text-gray-500">
                    <a class="hover:text-gray-300" href="#">Chính sách bảo mật</a>
                    <a class="hover:text-gray-300" href="#">Điều khoản sử dụng</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="{{ asset('js/homepage.js') }}"></script>
</body>
</html>