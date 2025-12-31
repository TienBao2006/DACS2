<!DOCTYPE html>
<html class="light" lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tin tức - Trường THPT Chuyên</title>
    
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

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-primary to-primary-dark text-white py-16">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-10">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    <span class="material-symbols-outlined text-5xl md:text-6xl mr-4 align-middle">newspaper</span>
                    Tin tức
                </h1>
                <p class="text-xl text-white/90 mb-6">Cập nhật những thông tin mới nhất từ nhà trường</p>
                <nav class="flex items-center justify-center gap-2 text-white/80">
                    <a href="{{ route('homepage') }}" class="hover:text-white transition-colors">Trang chủ</a>
                    <span class="material-symbols-outlined text-sm">chevron_right</span>
                    <span class="text-white">Tin tức</span>
                </nav>
            </div>
        </div>
    </section>

    <!-- News Content -->
    <section class="flex-grow py-10 bg-background-light dark:bg-background-dark">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-8">
                    @if ($news->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            @foreach ($news as $article)
                                <article class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all group">
                                    @if($article->image_url)
                                    <div class="h-48 overflow-hidden relative">
                                        <img src="{{ asset('storage/' . $article->image_url) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                        @if ($article->is_featured)
                                            <span class="absolute top-3 left-3 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded">Nổi bật</span>
                                        @endif
                                        @if ($article->created_at->diffInDays() < 3)
                                            <span class="absolute top-3 right-3 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">Mới</span>
                                        @endif
                                    </div>
                                    @endif
                                    <div class="p-6">
                                        <h3 class="text-lg font-bold text-text-main dark:text-white mb-3 line-clamp-2 group-hover:text-primary transition-colors">
                                            <a href="{{ route('homepage.news.detail', $article->id) }}">{{ $article->title }}</a>
                                        </h3>
                                        <p class="text-text-muted dark:text-gray-400 text-sm line-clamp-3 mb-4">
                                            {{ Str::limit($article->summary ?? $article->content, 120) }}
                                        </p>
                                        <div class="flex items-center justify-between text-xs text-text-muted dark:text-gray-400 mb-4">
                                            <span class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-sm">person</span>
                                                {{ $article->author ?? 'Admin' }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-sm">schedule</span>
                                                {{ $article->created_at->format('d/m/Y') }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-sm">visibility</span>
                                                {{ $article->views ?? 0 }}
                                            </span>
                                        </div>
                                        <a href="{{ route('homepage.news.detail', $article->id) }}" class="inline-flex items-center gap-2 text-primary hover:text-primary-dark font-medium text-sm transition-colors">
                                            Đọc tiếp
                                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if ($news->hasPages())
                            <div class="flex justify-center">
                                <div class="flex items-center gap-2">
                                    {{ $news->links('pagination::tailwind') }}
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-16">
                            <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                                <span class="material-symbols-outlined text-4xl text-gray-400">newspaper</span>
                            </div>
                            <h3 class="text-xl font-bold text-text-main dark:text-white mb-2">Chưa có tin tức nào</h3>
                            <p class="text-text-muted dark:text-gray-400">Hiện tại chưa có tin tức nào được đăng tải</p>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-4">
                    <div class="space-y-6">
                        <!-- Latest News Widget -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                                <h3 class="text-lg font-bold text-text-main dark:text-white flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary">schedule</span>
                                    Tin mới nhất
                                </h3>
                            </div>
                            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach ($news->take(5) as $latest)
                                <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <div class="flex gap-3">
                                        @if($latest->image_url)
                                        <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0">
                                            <img src="{{ asset('storage/' . $latest->image_url) }}" alt="{{ $latest->title }}" class="w-full h-full object-cover">
                                        </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-semibold text-text-main dark:text-white line-clamp-2 mb-1">
                                                <a href="{{ route('homepage.news.detail', $latest->id) }}" class="hover:text-primary transition-colors">
                                                    {{ $latest->title }}
                                                </a>
                                            </h4>
                                            <span class="text-xs text-text-muted dark:text-gray-400">{{ $latest->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Quick Links Widget -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                                <h3 class="text-lg font-bold text-text-main dark:text-white flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary">link</span>
                                    Liên kết nhanh
                                </h3>
                            </div>
                            <div class="p-4 space-y-2">
                                <a href="{{ route('homepage.teachers') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                                    <span class="material-symbols-outlined text-primary group-hover:scale-110 transition-transform">school</span>
                                    <span class="text-sm font-medium text-text-main dark:text-white">Đội ngũ giáo viên</span>
                                </a>
                                <a href="{{ route('homepage.documents') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                                    <span class="material-symbols-outlined text-primary group-hover:scale-110 transition-transform">description</span>
                                    <span class="text-sm font-medium text-text-main dark:text-white">Tài liệu học tập</span>
                                </a>
                                <a href="{{ route('login.form') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                                    <span class="material-symbols-outlined text-primary group-hover:scale-110 transition-transform">login</span>
                                    <span class="text-sm font-medium text-text-main dark:text-white">Đăng nhập hệ thống</span>
                                </a>
                            </div>
                        </div>

                        <!-- Banner -->
                        <div class="rounded-xl overflow-hidden relative min-h-[200px] flex items-center p-6 bg-gradient-to-r from-primary to-blue-500 shadow-md">
                            <div class="relative z-10 flex flex-col gap-3">
                                <h3 class="text-white font-bold text-xl">Tuyển sinh 2024</h3>
                                <p class="text-white/90 text-sm">Đăng ký trực tuyến hồ sơ xét tuyển vào lớp 10 năm học 2024-2025.</p>
                                <button class="bg-white text-primary text-sm font-bold py-2 px-4 rounded-lg w-fit hover:bg-gray-50 transition-colors">Đăng ký ngay</button>
                            </div>
                            <div class="absolute right-0 bottom-0 opacity-20 text-white transform translate-x-4 translate-y-4">
                                <span class="material-symbols-outlined text-[120px]">edit_document</span>
                            </div>
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
                        <span class="font-bold text-lg">THPT Chuyên</span>
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
                        <li><a class="hover:text-primary transition-colors" href="{{ route('homepage') }}">Trang chủ</a></li>
                        <li><a class="hover:text-primary transition-colors" href="{{ route('homepage.news') }}">Tin tức</a></li>
                        <li><a class="hover:text-primary transition-colors" href="{{ route('homepage.teachers') }}">Giáo viên</a></li>
                        <li><a class="hover:text-primary transition-colors" href="{{ route('homepage.documents') }}">Tài liệu</a></li>
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

    <script src="{{ asset('js/homepage.js') }}"></script>
</body>
</html>
