<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::query();
        
        // Tìm kiếm
        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
        }
        
        // Lọc theo trạng thái
        if ($request->has('status') && $request->status !== '') {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            } elseif ($request->status === 'featured') {
                $query->where('is_featured', true);
            }
        }
        
        $news = $query->latest('created_at')->paginate(10);
        
        return view('Admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('Admin.news.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'summary' => 'nullable|string|max:500',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'author' => 'nullable|string|max:255',
                'published_at' => 'nullable|date'
            ]);

            $data = [
                'title' => $request->title,
                'summary' => $request->summary,
                'content' => $request->content,
                'author' => $request->author ?? 'Admin',
                'is_featured' => $request->has('is_featured'),
                'is_published' => $request->has('is_published'),
                'views' => 0,
                'published_at' => $request->published_at ? $request->published_at : now()
            ];
            
            // Xử lý upload ảnh
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . \Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
                
                // Tạo thư mục nếu chưa có
                if (!file_exists(public_path('uploads/news'))) {
                    mkdir(public_path('uploads/news'), 0755, true);
                }
                
                $image->move(public_path('uploads/news'), $imageName);
                $data['image'] = $imageName;
            }
            
            $news = News::create($data);
            
            return redirect()->route('admin.news.index')->with('success', 'Tin tức đã được tạo thành công!');
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Lỗi khi tạo tin tức: ' . $e->getMessage()]);
        }
    }

    public function show(News $news)
    {
        return view('Admin.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        return view('Admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'summary' => 'nullable|string|max:500',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'author' => 'nullable|string|max:255',
                'published_at' => 'nullable|date'
            ]);

            $data = [
                'title' => $request->title,
                'summary' => $request->summary,
                'content' => $request->content,
                'author' => $request->author,
                'is_featured' => $request->has('is_featured'),
                'is_published' => $request->has('is_published'),
                'published_at' => $request->published_at
            ];
            
            // Xử lý upload ảnh mới
            if ($request->hasFile('image')) {
                // Xóa ảnh cũ
                if ($news->image && file_exists(public_path('uploads/news/' . $news->image))) {
                    unlink(public_path('uploads/news/' . $news->image));
                }
                
                $image = $request->file('image');
                $imageName = time() . '_' . \Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
                
                if (!file_exists(public_path('uploads/news'))) {
                    mkdir(public_path('uploads/news'), 0755, true);
                }
                
                $image->move(public_path('uploads/news'), $imageName);
                $data['image'] = $imageName;
            }
            
            $news->update($data);
            
            return redirect()->route('admin.news.index')->with('success', 'Tin tức đã được cập nhật thành công!');
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Lỗi khi cập nhật tin tức: ' . $e->getMessage()]);
        }
    }

    public function destroy(News $news)
    {
        // Xóa ảnh
        if ($news->image && file_exists(public_path('uploads/news/' . $news->image))) {
            unlink(public_path('uploads/news/' . $news->image));
        }
        
        $news->delete();
        
        return redirect()->route('admin.news.index')->with('success', 'Tin tức đã được xóa thành công!');
    }

    public function toggleFeatured(News $news)
    {
        $news->update(['is_featured' => !$news->is_featured]);
        
        $status = $news->is_featured ? 'nổi bật' : 'bình thường';
        return response()->json([
            'success' => true,
            'message' => "Tin tức đã được chuyển thành {$status}",
            'is_featured' => $news->is_featured
        ]);
    }

    public function togglePublished(News $news)
    {
        $news->update(['is_published' => !$news->is_published]);
        
        $status = $news->is_published ? 'xuất bản' : 'nháp';
        return response()->json([
            'success' => true,
            'message' => "Tin tức đã được chuyển thành {$status}",
            'is_published' => $news->is_published
        ]);
    }
}