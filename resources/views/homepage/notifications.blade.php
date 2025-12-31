<!DOCTYPE html>
<html class="light" lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Thông báo - Trường THPT Bách Khoa Lịch Sử</title>
    
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
                    <a class="flex items-center gap-3 text-text-main dark:text-white hover:opacity-90 transition-opacity" href="{{ route('homepage') }}">
                        <div class="size-8 text-primary">
                            <span class="material-symbols-outlined text-3xl">school</span>
                        </div>
                        <h2 class="text-lg font-bold leading-tight tracking-tight hidden sm:block">Trường THPT Bách Khoa Lịch Sử</h2>
                    </a>
                    <!-- Desktop Menu -->
                    <nav class="hidden lg:flex items-center gap-6 xl:gap-9">
                        <a class="text-sm font-medium hover:text-primary transition-colors" href="{{ route('homepage') }}">Trang chủ</a>
                        <a class="text-sm font-medium hover:text-primary transition-colors" href="{{ route('homepage.about') }}">Giới thiệu</a>
                        <a class="text-sm font-medium hover:text-primary transition-colors" href="{{ route('homepage.news') }}">Tin tức</a>
                        <a class="text-sm font-medium hover:text-primary transition-colors" href="{{ route('homepage.teachers') }}">Giáo viên</a>
                        <a class="text-sm font-medium hover:text-primary transition-colors" href="{{ route('homepage.documents') }}">Tài liệu</a>
                    </nav>
                </div>
                <!-- Right Actions -->
                <div class="flex items-center gap-4">
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
        <!-- Page Header -->
        <section class="py-12 bg-gradient-to-r from-primary to-primary-dark text-white">
            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-10">
                <div class="flex items-center gap-4 mb-4">
                    <span class="material-symbols-outlined text-4xl">notifications_active</span>
                    <h1 class="text-3xl lg:text-4xl font-bold">Thông báo</h1>
                </div>
                <p class="text-blue-100 text-lg">Các thông báo và thông tin quan trọng từ nhà trường</p>
            </div>
        </section>

        <!-- Notifications List -->
        <section class="py-12">
            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-10">
                @if($notifications->count() > 0)
                    <div class="space-y-6">
                        @foreach($notifications as $notification)
                        <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-start gap-4">
                                    <!-- Date Badge -->
                                    <div class="flex-shrink-0">
                                        @if($notification->priority === 'urgent')
                                        <div class="flex flex-col items-center min-w-[60px] bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg p-2 border border-red-200 dark:border-red-800">
                                            <span class="text-xs font-bold uppercase">{{ $notification->created_at->format('M') }}</span>
                                            <span class="text-xl font-bold leading-none">{{ $notification->created_at->format('d') }}</span>
                                            <span class="text-xs">{{ $notification->created_at->format('Y') }}</span>
                                        </div>
                                        @elseif($notification->priority === 'high')
                                        <div class="flex flex-col items-center min-w-[60px] bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 rounded-lg p-2 border border-orange-200 dark:border-orange-800">
                                            <span class="text-xs font-bold uppercase">{{ $notification->created_at->format('M') }}</span>
                                            <span class="text-xl font-bold leading-none">{{ $notification->created_at->format('d') }}</span>
                                            <span class="text-xs">{{ $notification->created_at->format('Y') }}</span>
                                        </div>
                                        @else
                                        <div class="flex flex-col items-center min-w-[60px] bg-primary/10 text-primary rounded-lg p-2 border border-primary/20">
                                            <span class="text-xs font-bold uppercase">{{ $notification->created_at->format('M') }}</span>
                                            <span class="text-xl font-bold leading-none">{{ $notification->created_at->format('d') }}</span>
                                            <span class="text-xs">{{ $notification->created_at->format('Y') }}</span>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between gap-4 mb-3">
                                            <h2 class="text-xl font-bold text-text-main dark:text-white leading-tight">
                                                {{ $notification->title }}
                                            </h2>
                                            <div class="flex gap-2 flex-shrink-0">
                                                @if($notification->priority === 'urgent')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                    <span class="material-symbols-outlined text-sm mr-1">priority_high</span>
                                                    Khẩn cấp
                                                </span>
                                                @elseif($notification->priority === 'high')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                                                    <span class="material-symbols-outlined text-sm mr-1">warning</span>
                                                    Quan trọng
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-4 text-sm text-text-muted dark:text-gray-400 mb-4">
                                            <div class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-lg">business</span>
                                                @php
                                                    // Xác định phòng ban dựa trên nội dung thông báo
                                                    $department = 'Ban Giám hiệu';
                                                    if (str_contains(strtolower($notification->title), 'thi') || str_contains(strtolower($notification->content), 'đào tạo')) {
                                                        $department = 'Phòng Đào tạo';
                                                    } elseif (str_contains(strtolower($notification->title), 'đoàn') || str_contains(strtolower($notification->content), 'đoàn')) {
                                                        $department = 'Đoàn Thanh niên';
                                                    } elseif (str_contains(strtolower($notification->title), 'học phí') || str_contains(strtolower($notification->content), 'tài chính')) {
                                                        $department = 'Phòng Tài chính - Kế toán';
                                                    } elseif (str_contains(strtolower($notification->title), 'tuyển sinh')) {
                                                        $department = 'Phòng Tuyển sinh';
                                                    }
                                                @endphp
                                                <span>{{ $department }}</span>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-lg">schedule</span>
                                                <span>{{ $notification->created_at->format('d/m/Y H:i') }}</span>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-lg">visibility</span>
                                                <span>{{ $notification->view_count ?? 0 }} lượt xem</span>
                                            </div>
                                        </div>

                                        @if($notification->content)
                                        <div class="prose prose-sm max-w-none dark:prose-invert">
                                            <p class="text-text-main dark:text-gray-200 leading-relaxed">
                                                {{ $notification->content }}
                                            </p>
                                        </div>
                                        @endif

                                        @if($notification->end_date)
                                        <div class="mt-4 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                            <div class="flex items-center gap-2 text-sm text-yellow-800 dark:text-yellow-200">
                                                <span class="material-symbols-outlined text-lg">event</span>
                                                <span>Có hiệu lực đến: {{ $notification->end_date->format('d/m/Y H:i') }}</span>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($notifications->hasPages())
                        <div class="mt-12 flex justify-center">
                            <div class="bg-surface-light dark:bg-surface-dark rounded-lg border border-gray-200 dark:border-gray-700 p-2">
                                {{ $notifications->links() }}
                            </div>
                        </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                            <span class="material-symbols-outlined text-4xl text-gray-400">notifications_off</span>
                        </div>
                        <h3 class="text-xl font-semibold text-text-main dark:text-white mb-2">Chưa có thông báo nào</h3>
                        <p class="text-text-muted dark:text-gray-400 mb-6">Các thông báo mới sẽ được hiển thị tại đây</p>
                        <a href="{{ route('homepage') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary-dark text-white rounded-lg transition-colors font-medium">
                            <span class="material-symbols-outlined">home</span>
                            Về trang chủ
                        </a>
                    </div>
                @endif
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