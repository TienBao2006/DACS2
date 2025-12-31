<!DOCTYPE html>
<html class="light" lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $news->title }} - Trường THPT Chuyên</title>
    <meta name="description" content="{{ Str::limit($news->summary ?? $news->content, 160) }}">
    
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
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-10 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Article Content -->
                <article class="lg:col-span-2 bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <!-- Article Header -->
                    <header class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex flex-wrap gap-2 mb-4">
                            @if($news->is_featured)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    <span class="material-symbols-outlined text-sm mr-1">star</span>
                                    Nổi bật
                                </span>
                            @endif
                            @if($news->is_new)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    <span class="material-symbols-outlined text-sm mr-1">new_releases</span>
                                    Mới
                                </span>
                            @endif
                        </div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-text-main dark:text-white mb-4 leading-tight">{{ $news->title }}</h1>
                        <div class="flex flex-wrap items-center gap-4 text-sm text-text-muted dark:text-gray-400">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-lg">person</span>
                                <span>{{ $news->author }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-lg">calendar_today</span>
                                <span>{{ $news->formatted_date }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-lg">visibility</span>
                                <span>{{ $news->views }} lượt xem</span>
                            </div>
                        </div>
                    </header>

                    <!-- Article Image -->
                    @if($news->image)
                    <div class="relative">
                        <img src="{{ $news->image_url }}" alt="{{ $news->title }}" class="w-full h-64 lg:h-80 object-cover">
                    </div>
                    @endif

                    <!-- Article Content -->
                    <div class="p-6">
                        <!-- Article Summary -->
                        @if($news->summary)
                        <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-primary p-4 mb-6 rounded-r-lg">
                            <p class="text-text-main dark:text-gray-200 font-medium italic">{{ $news->summary }}</p>
                        </div>
                        @endif

                        <!-- Article Body -->
                        <div class="prose prose-lg max-w-none dark:prose-invert">
                            <div class="text-text-main dark:text-gray-200 leading-relaxed whitespace-pre-line">
                                {!! nl2br(e($news->content)) !!}
                            </div>
                        </div>
                    </div>

                    <!-- Article Footer -->
                    <footer class="p-6 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div class="flex flex-wrap gap-3">
                                <button onclick="shareArticle()" class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary-dark text-white rounded-lg transition-colors text-sm font-medium">
                                    <span class="material-symbols-outlined text-lg">share</span>
                                    Chia sẻ
                                </button>
                                <button onclick="printArticle()" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors text-sm font-medium">
                                    <span class="material-symbols-outlined text-lg">print</span>
                                    In bài viết
                                </button>
                            </div>
                            <a href="{{ route('homepage.news') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 dark:border-gray-600 text-text-main dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors text-sm font-medium">
                                <span class="material-symbols-outlined text-lg">arrow_back</span>
                                Quay lại tin tức
                            </a>
                        </div>
                    </footer>
                </article>

                <!-- Sidebar -->
                <aside class="space-y-6">
                    <!-- Related News -->
                    @if($relatedNews->count() > 0)
                    <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="flex items-center gap-2 text-lg font-bold text-text-main dark:text-white mb-4">
                            <span class="material-symbols-outlined text-primary">newspaper</span>
                            Tin liên quan
                        </h3>
                        <div class="space-y-4">
                            @foreach($relatedNews as $related)
                            <div class="flex gap-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                <div class="flex-shrink-0">
                                    <img src="{{ $related->image_url }}" alt="{{ $related->title }}" class="w-16 h-16 object-cover rounded-lg">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-medium text-text-main dark:text-white mb-1 line-clamp-2">
                                        <a href="{{ route('homepage.news.detail', $related->id) }}" class="hover:text-primary transition-colors">
                                            {{ Str::limit($related->title, 60) }}
                                        </a>
                                    </h4>
                                    <span class="text-xs text-text-muted dark:text-gray-400">{{ $related->short_date }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Quick Links -->
                    <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="flex items-center gap-2 text-lg font-bold text-text-main dark:text-white mb-4">
                            <span class="material-symbols-outlined text-primary">link</span>
                            Liên kết nhanh
                        </h3>
                        <div class="space-y-2">
                            <a href="{{ route('homepage.teachers') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 text-text-main dark:text-gray-200 hover:text-primary transition-colors">
                                <span class="material-symbols-outlined text-lg">school</span>
                                Đội ngũ giáo viên
                            </a>
                            <a href="{{ route('homepage.documents') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 text-text-main dark:text-gray-200 hover:text-primary transition-colors">
                                <span class="material-symbols-outlined text-lg">description</span>
                                Tài liệu học tập
                            </a>
                            <a href="{{ route('login.form') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 text-text-main dark:text-gray-200 hover:text-primary transition-colors">
                                <span class="material-symbols-outlined text-lg">login</span>
                                Đăng nhập hệ thống
                            </a>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="flex items-center gap-2 text-lg font-bold text-text-main dark:text-white mb-4">
                            <span class="material-symbols-outlined text-primary">contact_phone</span>
                            Liên hệ
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-start gap-3 text-sm">
                                <span class="material-symbols-outlined text-lg text-primary mt-0.5">location_on</span>
                                <span class="text-text-main dark:text-gray-200">123 Đường ABC, Quận XYZ, TP.HCM</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm">
                                <span class="material-symbols-outlined text-lg text-primary">phone</span>
                                <span class="text-text-main dark:text-gray-200">(028) 1234 5678</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm">
                                <span class="material-symbols-outlined text-lg text-primary">email</span>
                                <span class="text-text-main dark:text-gray-200">info@thptabc.edu.vn</span>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-surface-light dark:bg-surface-dark border-t border-gray-200 dark:border-gray-700 mt-auto">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-10 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-4">Trường THPT Chuyên</h3>
                    <div class="space-y-2 text-sm text-text-muted dark:text-gray-400">
                        <p>Địa chỉ: 123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh</p>
                        <p>Điện thoại: (028) 1234 5678</p>
                        <p>Email: info@thptabc.edu.vn</p>
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
                <p class="text-sm text-text-muted dark:text-gray-400">&copy; 2024 Trường THPT Chuyên. Tất cả quyền được bảo lưu.</p>
            </div>
        </div>
    </footer>

    <script>
        function shareArticle() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $news->title }}',
                    text: '{{ $news->summary ?? Str::limit($news->content, 100) }}',
                    url: window.location.href
                });
            } else {
                // Fallback - copy to clipboard
                navigator.clipboard.writeText(window.location.href).then(() => {
                    // Show toast notification
                    const toast = document.createElement('div');
                    toast.className = 'fixed bottom-4 right-4 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                    toast.textContent = 'Đã sao chép liên kết vào clipboard!';
                    document.body.appendChild(toast);
                    setTimeout(() => {
                        document.body.removeChild(toast);
                    }, 3000);
                });
            }
        }

        function printArticle() {
            window.print();
        }

        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('button[class*="lg:hidden"]');
            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', function() {
                    // Add mobile menu functionality if needed
                    console.log('Mobile menu clicked');
                });
            }
        });
    </script>
</body>
</html>