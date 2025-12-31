<!DOCTYPE html>
<html class="light" lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kết quả tìm kiếm: {{ $query }} - Trường THPT Bách Khoa Lịch Sử</title>
    
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
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-text-main dark:text-gray-100">
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
                        <h2 class="text-lg font-bold leading-tight tracking-tight hidden sm:block">Trường THPT</h2>
                    </a>
                </div>
                <!-- Search Bar -->
                <div class="flex-1 max-w-2xl mx-8">
                    <form action="{{ route('homepage.search') }}" method="GET" class="relative">
                        <div class="flex w-full h-10 items-center rounded-lg bg-background-light dark:bg-gray-800 border border-gray-300 dark:border-gray-600 focus-within:border-primary focus-within:ring-1 focus-within:ring-primary transition-all">
                            <div class="pl-3 flex items-center justify-center text-text-muted">
                                <span class="material-symbols-outlined text-[20px]">search</span>
                            </div>
                            <input name="q" value="{{ $query }}" class="w-full bg-transparent border-none text-sm text-text-main dark:text-white placeholder:text-text-muted focus:ring-0 px-3 h-full" placeholder="Tìm kiếm tin tức, thông báo, giáo viên..."/>
                            <button type="submit" class="px-4 h-full bg-primary hover:bg-primary-dark text-white rounded-r-lg transition-colors">
                                Tìm
                            </button>
                        </div>
                    </form>
                </div>
                <!-- Login Button -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('login.form') }}" class="flex items-center justify-center h-10 px-5 rounded-lg bg-primary hover:bg-primary-dark text-white text-sm font-bold transition-colors shadow-sm">
                        <span>Đăng nhập</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="min-h-screen py-8 bg-background-light dark:bg-background-dark">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-10">
            <!-- Search Results Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-text-main dark:text-white mb-2">
                    Kết quả tìm kiếm
                </h1>
                @if($query)
                    <p class="text-text-muted dark:text-gray-400">
                        Tìm kiếm cho: <strong>"{{ $query }}"</strong>
                        @if(isset($results['total']) && $results['total'] > 0)
                            - Tìm thấy {{ $results['total'] }} kết quả
                        @endif
                    </p>
                @endif
            </div>

            @if($query && strlen($query) >= 2)
                @if(isset($results['total']) && $results['total'] > 0)
                    <!-- Search Results -->
                    <div class="space-y-8">
                        <!-- News Results -->
                        @if($results['news']->count() > 0)
                            <section>
                                <h2 class="text-xl font-bold text-text-main dark:text-white mb-4 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary">article</span>
                                    Tin tức ({{ $results['news']->count() }})
                                </h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach($results['news'] as $news)
                                        <article class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all group">
                                            <div class="p-6">
                                                <div class="text-xs text-text-muted dark:text-gray-400 mb-2">{{ $news->created_at->format('d/m/Y') }}</div>
                                                <h3 class="text-lg font-bold text-text-main dark:text-white mb-2 line-clamp-2 group-hover:text-primary transition-colors">
                                                    <a href="{{ route('homepage.news.detail', $news->id) }}">{{ $news->title }}</a>
                                                </h3>
                                                <p class="text-sm text-text-muted dark:text-gray-400 line-clamp-3">
                                                    {{ Str::limit($news->summary ?? $news->content, 150) }}
                                                </p>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            </section>
                        @endif

                        <!-- Notifications Results -->
                        @if($results['notifications']->count() > 0)
                            <section>
                                <h2 class="text-xl font-bold text-text-main dark:text-white mb-4 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary">notifications</span>
                                    Thông báo ({{ $results['notifications']->count() }})
                                </h2>
                                <div class="space-y-4">
                                    @foreach($results['notifications'] as $notification)
                                        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all">
                                            <div class="flex items-start gap-4">
                                                <div class="flex-shrink-0 w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-primary">notifications_active</span>
                                                </div>
                                                <div class="flex-1">
                                                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-2">{{ $notification->title }}</h3>
                                                    <p class="text-sm text-text-muted dark:text-gray-400 line-clamp-2 mb-2">
                                                        {{ Str::limit($notification->content, 200) }}
                                                    </p>
                                                    <div class="flex items-center gap-2 text-xs text-text-muted dark:text-gray-400">
                                                        <span class="bg-{{ $notification->priority === 'urgent' ? 'red' : ($notification->priority === 'high' ? 'orange' : 'blue') }}-100 text-{{ $notification->priority === 'urgent' ? 'red' : ($notification->priority === 'high' ? 'orange' : 'blue') }}-800 px-2 py-1 rounded">
                                                            {{ ucfirst($notification->priority) }}
                                                        </span>
                                                        <span>{{ $notification->created_at->format('d/m/Y') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                        @endif

                        <!-- Teachers Results -->
                        @if($results['teachers']->count() > 0)
                            <section>
                                <h2 class="text-xl font-bold text-text-main dark:text-white mb-4 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary">person</span>
                                    Giáo viên ({{ $results['teachers']->count() }})
                                </h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach($results['teachers'] as $teacher)
                                        <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all">
                                            <div class="p-6 text-center">
                                                <div class="w-16 h-16 mx-auto mb-4 bg-primary/10 rounded-full flex items-center justify-center">
                                                    @if($teacher->anh_dai_dien)
                                                        <img src="{{ asset('uploads/teacher/' . $teacher->anh_dai_dien) }}" alt="{{ $teacher->ho_ten }}" class="w-full h-full object-cover rounded-full">
                                                    @else
                                                        <span class="material-symbols-outlined text-primary text-2xl">person</span>
                                                    @endif
                                                </div>
                                                <h3 class="text-lg font-bold text-text-main dark:text-white mb-1">{{ $teacher->ho_ten }}</h3>
                                                <p class="text-sm text-text-muted dark:text-gray-400 mb-2">{{ $teacher->mon_day }}</p>
                                                <p class="text-xs text-text-muted dark:text-gray-400">{{ $teacher->trinh_do_chuyen_mon ?? $teacher->chuc_vu }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                        @endif

                        <!-- Documents Results -->
                        @if($results['documents']->count() > 0)
                            <section>
                                <h2 class="text-xl font-bold text-text-main dark:text-white mb-4 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary">description</span>
                                    Tài liệu ({{ $results['documents']->count() }})
                                </h2>
                                <div class="space-y-4">
                                    @foreach($results['documents'] as $document)
                                        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all">
                                            <div class="flex items-start gap-4">
                                                <div class="flex-shrink-0 w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-primary">description</span>
                                                </div>
                                                <div class="flex-1">
                                                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-2">{{ $document->title }}</h3>
                                                    @if($document->description)
                                                        <p class="text-sm text-text-muted dark:text-gray-400 line-clamp-2 mb-2">{{ $document->description }}</p>
                                                    @endif
                                                    <div class="flex items-center gap-4 text-xs text-text-muted dark:text-gray-400">
                                                        <span>{{ $document->created_at->format('d/m/Y') }}</span>
                                                        <a href="{{ route('homepage.documents.download', $document) }}" class="text-primary hover:text-primary-dark font-medium">
                                                            <span class="material-symbols-outlined text-sm">download</span> Tải xuống
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                        @endif
                    </div>
                @else
                    <!-- No Results -->
                    <div class="text-center py-16">
                        <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-4xl text-gray-400">search_off</span>
                        </div>
                        <h2 class="text-2xl font-bold text-text-main dark:text-white mb-2">Không tìm thấy kết quả</h2>
                        <p class="text-text-muted dark:text-gray-400 mb-6">
                            Không có kết quả nào cho từ khóa "<strong>{{ $query }}</strong>". Hãy thử với từ khóa khác.
                        </p>
                        <div class="space-y-2 text-sm text-text-muted dark:text-gray-400">
                            <p><strong>Gợi ý:</strong></p>
                            <ul class="space-y-1">
                                <li>• Kiểm tra chính tả từ khóa</li>
                                <li>• Sử dụng từ khóa ngắn gọn hơn</li>
                                <li>• Thử tìm kiếm với từ đồng nghĩa</li>
                            </ul>
                        </div>
                    </div>
                @endif
            @elseif($query && strlen($query) < 2)
                <!-- Query too short -->
                <div class="text-center py-16">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-4xl text-gray-400">search</span>
                    </div>
                    <h2 class="text-2xl font-bold text-text-main dark:text-white mb-2">Từ khóa quá ngắn</h2>
                    <p class="text-text-muted dark:text-gray-400">
                        Vui lòng nhập ít nhất 2 ký tự để tìm kiếm.
                    </p>
                </div>
            @else
                <!-- Empty search -->
                <div class="text-center py-16">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-4xl text-gray-400">search</span>
                    </div>
                    <h2 class="text-2xl font-bold text-text-main dark:text-white mb-2">Tìm kiếm thông tin</h2>
                    <p class="text-text-muted dark:text-gray-400 mb-6">
                        Nhập từ khóa để tìm kiếm tin tức, thông báo, giáo viên và tài liệu.
                    </p>
                    <div class="max-w-md mx-auto">
                        <form action="{{ route('homepage.search') }}" method="GET">
                            <div class="flex w-full h-12 items-center rounded-lg bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 focus-within:border-primary focus-within:ring-1 focus-within:ring-primary transition-all shadow-sm">
                                <div class="pl-4 flex items-center justify-center text-text-muted">
                                    <span class="material-symbols-outlined text-[20px]">search</span>
                                </div>
                                <input name="q" class="w-full bg-transparent border-none text-sm text-text-main dark:text-white placeholder:text-text-muted focus:ring-0 px-3 h-full" placeholder="Nhập từ khóa tìm kiếm..."/>
                                <button type="submit" class="px-6 h-full bg-primary hover:bg-primary-dark text-white rounded-r-lg transition-colors font-medium">
                                    Tìm kiếm
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-surface-light dark:bg-surface-dark border-t border-gray-200 dark:border-gray-700 py-8">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-10 text-center">
            <p class="text-text-muted dark:text-gray-400">
                © 2024 Trường THPT .
            </p>
        </div>
    </footer>
</body>
</html>