<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::ordered()->paginate(10);
        return view('Admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('Admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link_url' => 'nullable|url',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $data = $request->only(['title', 'description', 'link_url', 'sort_order']);
        $data['is_active'] = $request->has('is_active');

        // Upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            
            // Tạo thư mục nếu chưa có
            $uploadPath = public_path('uploads/banners');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            $image->move($uploadPath, $imageName);
            $data['image_path'] = $imageName;
        }

        Banner::create($data);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner đã được tạo thành công!');
    }

    public function show(Banner $banner)
    {
        return view('Admin.banners.show', compact('banner'));
    }

    public function edit(Banner $banner)
    {
        return view('Admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link_url' => 'nullable|url',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $data = $request->only(['title', 'description', 'link_url', 'sort_order']);
        $data['is_active'] = $request->has('is_active');

        // Upload new image if provided
        if ($request->hasFile('image')) {
            // Delete old image
            if ($banner->image_path) {
                $oldImagePath = public_path('uploads/banners/' . $banner->image_path);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            
            $uploadPath = public_path('uploads/banners');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            $image->move($uploadPath, $imageName);
            $data['image_path'] = $imageName;
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner đã được cập nhật thành công!');
    }

    public function destroy(Banner $banner)
    {
        // Delete image file
        if ($banner->image_path) {
            $imagePath = public_path('uploads/banners/' . $banner->image_path);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner đã được xóa thành công!');
    }

    public function toggleStatus(Banner $banner)
    {
        $banner->update(['is_active' => !$banner->is_active]);
        
        $status = $banner->is_active ? 'kích hoạt' : 'vô hiệu hóa';
        return redirect()->back()
            ->with('success', "Banner đã được {$status} thành công!");
    }
}