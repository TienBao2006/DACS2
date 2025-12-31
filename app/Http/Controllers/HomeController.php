<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy tin nổi bật (tối đa 3 tin)
        $featuredNews = News::published()
            ->featured()
            ->latest()
            ->limit(3)
            ->get();
        
        // Lấy tin tức mới nhất (không bao gồm tin nổi bật)
        $latestNews = News::published()
            ->where('is_featured', false)
            ->latest()
            ->limit(6)
            ->get();
        
        // Lấy tất cả tin tức cho slider/carousel
        $allNews = News::published()
            ->latest()
            ->limit(10)
            ->get();
        
        // Thống kê
        $stats = [
            'total_news' => News::published()->count(),
            'featured_news' => News::published()->featured()->count(),
            'recent_news' => News::published()->where('created_at', '>=', now()->subDays(7))->count(),
        ];
        
        return view('home.index', compact('featuredNews', 'latestNews', 'allNews', 'stats'));
    }

    public function show($id)
    {
        $news = News::published()->findOrFail($id);
        
        // Tăng lượt xem
        $news->incrementViews();
        
        // Lấy tin liên quan (cùng thời gian hoặc ngẫu nhiên)
        $relatedNews = News::published()
            ->where('id', '!=', $news->id)
            ->latest()
            ->limit(4)
            ->get();
        
        return view('home.news-detail', compact('news', 'relatedNews'));
    }

    public function news(Request $request)
    {
        $query = News::published();
        
        // Tìm kiếm
        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
        }
        
        // Lọc tin nổi bật
        if ($request->has('featured') && $request->featured) {
            $query->featured();
        }
        
        $news = $query->latest()->paginate(9);
        $featuredNews = News::published()->featured()->latest()->limit(3)->get();
        
        return view('home.news', compact('news', 'featuredNews'));
    }
}