<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Teacher;
use App\Models\Document;
use App\Models\Banner;
use App\Models\Notification;

class HomePageController extends Controller
{
    public function index()
    {
        // Lấy banner đang hoạt động
        $banners = Banner::active()->ordered()->get();

        // Lấy thông báo hiển thị trên trang chủ
        try {
            $notifications = Notification::active()
                ->forHomepage()
                ->currentlyValid()
                ->byPriority()
                ->limit(5)
                ->get();
        } catch (\Exception $e) {
            // Nếu bảng notifications chưa tồn tại, tạo collection rỗng
            $notifications = collect();
        }

        // Lấy tin nổi bật (featured news)
        $featuredNews = News::where('is_featured', true)
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Lấy tin tức mới nhất
        $latestNews = News::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // Lấy danh sách giáo viên
        try {
            // Thử lấy giáo viên có ảnh đại diện trước
            $teachers = Teacher::whereNotNull('anh_dai_dien')
                ->where('anh_dai_dien', '!=', '')
                ->orderBy('ho_ten')
                ->limit(12)
                ->get();
            
            // Nếu không có giáo viên nào có ảnh, lấy tất cả giáo viên
            if ($teachers->count() == 0) {
                $teachers = Teacher::orderBy('ho_ten')->limit(12)->get();
            }
        } catch (\Exception $e) {
            // Nếu có lỗi với bảng teacher, tạo collection rỗng
            $teachers = collect([]);
        }

        // Lấy tài liệu công khai
        $documents = Document::where('is_public', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Thống kê
        $statistics = [
            'total_teachers' => Teacher::count(),
            'total_news' => News::where('is_published', true)->count(),
            'total_documents' => Document::where('is_public', true)->count(),
            'total_students' => \App\Models\Student::count(),
        ];

        return view('homepage.index', compact(
            'banners',
            'notifications',
            'featuredNews', 
            'latestNews', 
            'teachers', 
            'documents', 
            'statistics'
        ));
    }

    public function news()
    {
        $news = News::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('homepage.news', compact('news'));
    }

    public function newsDetail($id)
    {
        $news = News::where('is_published', true)->findOrFail($id);
        
        // Tăng lượt xem
        $news->increment('views');

        // Tin liên quan (lấy tin tức khác cùng tác giả hoặc tin nổi bật)
        $relatedNews = News::where('is_published', true)
            ->where('id', '!=', $id)
            ->where(function($query) use ($news) {
                $query->where('author', $news->author)
                      ->orWhere('is_featured', true);
            })
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        return view('homepage.news-detail', compact('news', 'relatedNews'));
    }

    public function teachers()
    {
        $teachers = Teacher::whereNotNull('anh_dai_dien')
            ->where('anh_dai_dien', '!=', '')
            ->orderBy('ho_ten')
            ->paginate(16);

        return view('homepage.teachers', compact('teachers'));
    }

    public function documents()
    {
        $documents = Document::where('is_public', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('homepage.documents', compact('documents'));
    }

    public function about()
    {
        // Thông tin về trường
        $statistics = [
            'total_teachers' => Teacher::count(),
            'total_news' => News::where('is_published', true)->count(),
            'total_documents' => Document::where('is_public', true)->count(),
            'total_students' => \App\Models\Student::count(),
            'establishment_year' => 2004,
            'total_classes' => 36,
        ];

        return view('homepage.about', compact('statistics'));
    }

    public function admissions()
    {
        // Thông tin tuyển sinh
        $latestNews = News::where('is_published', true)
            ->where('title', 'like', '%tuyển sinh%')
            ->orWhere('content', 'like', '%tuyển sinh%')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('homepage.admissions', compact('latestNews'));
    }

    public function notifications()
    {
        $notifications = Notification::active()
            ->forHomepage()
            ->currentlyValid()
            ->byPriority()
            ->paginate(15);

        return view('homepage.notifications', compact('notifications'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $results = [];
        
        if (strlen($query) >= 2) {
            // Tìm kiếm tin tức
            $news = News::where('is_published', true)
                ->where(function($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('content', 'like', "%{$query}%")
                      ->orWhere('summary', 'like', "%{$query}%");
                })
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            // Tìm kiếm thông báo
            $notifications = Notification::active()
                ->forHomepage()
                ->currentlyValid()
                ->where(function($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('content', 'like', "%{$query}%");
                })
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Tìm kiếm giáo viên
            $teachers = Teacher::where(function($q) use ($query) {
                    $q->where('ho_ten', 'like', "%{$query}%")
                      ->orWhere('mon_day', 'like', "%{$query}%")
                      ->orWhere('trinh_do_chuyen_mon', 'like', "%{$query}%")
                      ->orWhere('to_chuyen_mon', 'like', "%{$query}%")
                      ->orWhere('chuc_vu', 'like', "%{$query}%");
                })
                ->limit(5)
                ->get();

            // Tìm kiếm tài liệu
            $documents = Document::where('is_public', true)
                ->where(function($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%");
                })
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            $results = [
                'news' => $news,
                'notifications' => $notifications,
                'teachers' => $teachers,
                'documents' => $documents,
                'total' => $news->count() + $notifications->count() + $teachers->count() + $documents->count()
            ];
        }

        return view('homepage.search', compact('query', 'results'));
    }

    public function apiSearch(Request $request)
    {
        $query = $request->get('q', '');
        $results = [];
        
        if (strlen($query) >= 2) {
            // Tìm kiếm nhanh cho autocomplete
            $news = News::where('is_published', true)
                ->where('title', 'like', "%{$query}%")
                ->select('id', 'title', 'created_at')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
                ->map(function($item) {
                    return [
                        'type' => 'news',
                        'id' => $item->id,
                        'title' => $item->title,
                        'url' => route('homepage.news.detail', $item->id),
                        'date' => $item->created_at->format('d/m/Y')
                    ];
                });

            $notifications = Notification::active()
                ->forHomepage()
                ->currentlyValid()
                ->where('title', 'like', "%{$query}%")
                ->select('id', 'title', 'created_at')
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get()
                ->map(function($item) {
                    return [
                        'type' => 'notification',
                        'id' => $item->id,
                        'title' => $item->title,
                        'url' => '#',
                        'date' => $item->created_at->format('d/m/Y')
                    ];
                });

            $results = $news->concat($notifications)->take(8);
        }

        return response()->json($results);
    }
}