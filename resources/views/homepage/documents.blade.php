<!DOCTYPE html>
<html class="light" lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kho Tài liệu & Học liệu - Trường THPT Chuyên</title>
    
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
            <!-- Page Header -->
            <div class="text-center mb-12">
                <h1 class="text-3xl lg:text-4xl font-bold text-text-main dark:text-white mb-4">Kho Tài liệu & Học liệu</h1>
                <p class="text-lg text-text-muted dark:text-gray-400 max-w-2xl mx-auto">
                    Tổng hợp các tài liệu học tập, đề thi, biểu mẫu và tài liệu hướng dẫn dành cho học sinh và giáo viên
                </p>
            </div>

            <!-- Filter Section -->
            <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
                <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                    <div class="flex flex-wrap gap-3">
                        <button class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium">Tất cả</button>
                        <button class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-text-main dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg text-sm font-medium transition-colors">Chương trình học</button>
                        <button class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-text-main dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg text-sm font-medium transition-colors">Đề thi</button>
                        <button class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-text-main dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg text-sm font-medium transition-colors">Biểu mẫu</button>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-text-muted dark:text-gray-400">Sắp xếp:</span>
                        <select class="px-3 py-2 bg-background-light dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-sm text-text-main dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option>Mới nhất</option>
                            <option>Cũ nhất</option>
                            <option>Tên A-Z</option>
                            <option>Lượt tải nhiều nhất</option>
                        </select>
                    </div>
                </div>
            </div>

            @if($documents->count() > 0)
                <!-- Documents Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                    @foreach($documents as $document)
                    <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow overflow-hidden">
                        <!-- Document Header -->
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary text-2xl">
                                        @php
                                            $extension = pathinfo($document->file_name ?? '', PATHINFO_EXTENSION);
                                            $icon = match(strtolower($extension)) {
                                                'pdf' => 'picture_as_pdf',
                                                'doc', 'docx' => 'description',
                                                'xls', 'xlsx' => 'table_chart',
                                                'ppt', 'pptx' => 'slideshow',
                                                'zip', 'rar' => 'folder_zip',
                                                'jpg', 'jpeg', 'png', 'gif' => 'image',
                                                default => 'insert_drive_file'
                                            };
                                            echo $icon;
                                        @endphp
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-semibold text-text-main dark:text-white mb-2 line-clamp-2">{{ $document->title }}</h3>
                                    @if($document->description)
                                        <p class="text-sm text-text-muted dark:text-gray-400 line-clamp-3">{{ Str::limit($document->description, 120) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Document Info -->
                        <div class="p-6">
                            <div class="flex flex-wrap gap-3 mb-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    @php
                                        $categories = [
                                            'general' => 'Tổng hợp',
                                            'curriculum' => 'Chương trình học',
                                            'exam' => 'Đề thi - Kiểm tra',
                                            'regulation' => 'Quy định - Thông tư',
                                            'form' => 'Biểu mẫu',
                                            'report' => 'Báo cáo',
                                            'other' => 'Khác'
                                        ];
                                    @endphp
                                    {{ $categories[$document->category ?? 'other'] ?? $document->category }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-4 text-sm text-text-muted dark:text-gray-400 mb-4">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-lg">storage</span>
                                    <span>{{ $document->file_size_human ?? '0 KB' }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-lg">download</span>
                                    <span>{{ $document->downloads ?? 0 }} lượt tải</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-lg">calendar_today</span>
                                    <span>{{ $document->created_at->format('d/m/Y') }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-lg">person</span>
                                    <span>{{ $document->author ?? 'Admin' }}</span>
                                </div>
                            </div>

                            @if(isset($document->tags) && is_array($document->tags) && count($document->tags) > 0)
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @foreach(array_slice($document->tags, 0, 3) as $tag)
                                        <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs rounded-md">{{ $tag }}</span>
                                    @endforeach
                                    @if(count($document->tags) > 3)
                                        <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs rounded-md">+{{ count($document->tags) - 3 }}</span>
                                    @endif
                                </div>
                            @endif

                            <!-- Actions -->
                            <div class="flex gap-3">
                                <a href="{{ route('homepage.documents.download', $document) }}" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary hover:bg-primary-dark text-white rounded-lg transition-colors text-sm font-medium">
                                    <span class="material-symbols-outlined text-lg">download</span>
                                    Tải xuống
                                </a>
                                <button class="px-3 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-text-main dark:text-gray-200 rounded-lg transition-colors" title="Thông tin file">
                                    <span class="material-symbols-outlined text-lg">info</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($documents->hasPages())
                    <div class="flex justify-center">
                        <div class="bg-surface-light dark:bg-surface-dark rounded-lg border border-gray-200 dark:border-gray-700 p-2">
                            {{ $documents->links() }}
                        </div>
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="material-symbols-outlined text-4xl text-gray-400">description</span>
                    </div>
                    <h3 class="text-xl font-semibold text-text-main dark:text-white mb-2">Chưa có tài liệu nào</h3>
                    <p class="text-text-muted dark:text-gray-400 mb-6">Các tài liệu học tập sẽ được cập nhật sớm</p>
                    <a href="{{ route('homepage') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary-dark text-white rounded-lg transition-colors font-medium">
                        <span class="material-symbols-outlined">home</span>
                        Về trang chủ
                    </a>
                </div>
            @endif
        </div>

        <!-- Categories Section -->
        @if($documents->count() > 0)
        <section class="bg-gray-50 dark:bg-gray-900 py-16">
            <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-10">
                <div class="text-center mb-12">
                    <h2 class="text-2xl lg:text-3xl font-bold text-text-main dark:text-white mb-4">Danh mục tài liệu</h2>
                    <p class="text-text-muted dark:text-gray-400">Khám phá các loại tài liệu theo danh mục</p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @php
                        $categoryStats = $documents->groupBy('category');
                        $categories = [
                            'general' => ['name' => 'Tổng hợp', 'icon' => 'folder', 'color' => 'blue'],
                            'curriculum' => ['name' => 'Chương trình học', 'icon' => 'school', 'color' => 'green'],
                            'exam' => ['name' => 'Đề thi - Kiểm tra', 'icon' => 'quiz', 'color' => 'red'],
                            'regulation' => ['name' => 'Quy định - Thông tư', 'icon' => 'gavel', 'color' => 'purple'],
                            'form' => ['name' => 'Biểu mẫu', 'icon' => 'description', 'color' => 'orange'],
                            'report' => ['name' => 'Báo cáo', 'icon' => 'bar_chart', 'color' => 'teal'],
                            'other' => ['name' => 'Khác', 'icon' => 'more_horiz', 'color' => 'gray']
                        ];
                    @endphp

                    @foreach($categories as $key => $category)
                        @php $count = $categoryStats->get($key, collect())->count(); @endphp
                        @if($count > 0)
                        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 bg-{{ $category['color'] }}-100 dark:bg-{{ $category['color'] }}-900/30 rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-{{ $category['color'] }}-600 dark:text-{{ $category['color'] }}-400 text-2xl">{{ $category['icon'] }}</span>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-text-main dark:text-white">{{ $category['name'] }}</h3>
                                    <span class="text-sm text-text-muted dark:text-gray-400">{{ $count }} tài liệu</span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-{{ $category['color'] }}-500 h-2 rounded-full" style="width: {{ min(100, ($count / $documents->total()) * 100) }}%"></div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
        @endif
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
        // Filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('button[class*="px-4 py-2"]');
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => {
                        btn.classList.remove('bg-primary', 'text-white');
                        btn.classList.add('bg-gray-100', 'dark:bg-gray-700', 'text-text-main', 'dark:text-gray-200');
                    });
                    
                    // Add active class to clicked button
                    this.classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-text-main', 'dark:text-gray-200');
                    this.classList.add('bg-primary', 'text-white');
                    
                    // Filter logic would go here
                    console.log('Filter clicked:', this.textContent);
                });
            });

            // Mobile menu toggle
            const mobileMenuButton = document.querySelector('button[class*="lg:hidden"]');
            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', function() {
                    console.log('Mobile menu clicked');
                });
            }

            // Search functionality
            const searchInput = document.querySelector('input[placeholder*="Tìm kiếm"]');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    // Search logic would go here
                    console.log('Search:', searchTerm);
                });
            }
        });
    </script>
</body>
</html>