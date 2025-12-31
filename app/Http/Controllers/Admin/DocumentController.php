<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::query();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by public status
        if ($request->filled('is_public')) {
            $query->where('is_public', $request->is_public);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $documents = $query->orderBy('created_at', 'desc')->paginate(15);

        $categories = [
            'general' => 'Tổng hợp',
            'curriculum' => 'Chương trình học',
            'exam' => 'Đề thi - Kiểm tra',
            'regulation' => 'Quy định - Thông tư',
            'form' => 'Biểu mẫu',
            'report' => 'Báo cáo',
            'other' => 'Khác'
        ];

        return view('Admin.documents.index', compact('documents', 'categories'));
    }

    public function create()
    {
        $categories = [
            'general' => 'Tổng hợp',
            'curriculum' => 'Chương trình học',
            'exam' => 'Đề thi - Kiểm tra',
            'regulation' => 'Quy định - Thông tư',
            'form' => 'Biểu mẫu',
            'report' => 'Báo cáo',
            'other' => 'Khác'
        ];

        return view('Admin.documents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'file' => 'required|file|max:10240', // 10MB max
            'is_public' => 'nullable|boolean',
            'tags' => 'nullable|string'
        ]);

        try {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public');

            $tags = $request->tags ? explode(',', $request->tags) : [];
            $tags = array_map('trim', $tags);

            Document::create([
                'title' => $request->title,
                'description' => $request->description,
                'file_path' => $filePath,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'file_type' => $file->getMimeType(),
                'category' => $request->category,
                'is_public' => $request->has('is_public'),
                'uploaded_by' => Auth::id(),
                'tags' => $tags
            ]);

            return redirect()->route('admin.documents.index')
                ->with('success', 'Tài liệu đã được tải lên thành công!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi tải lên tài liệu: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Document $document)
    {
        $categories = [
            'general' => 'Tổng hợp',
            'curriculum' => 'Chương trình học',
            'exam' => 'Đề thi - Kiểm tra',
            'regulation' => 'Quy định - Thông tư',
            'form' => 'Biểu mẫu',
            'report' => 'Báo cáo',
            'other' => 'Khác'
        ];

        return view('Admin.documents.show', compact('document', 'categories'));
    }

    public function edit(Document $document)
    {
        $categories = [
            'general' => 'Tổng hợp',
            'curriculum' => 'Chương trình học',
            'exam' => 'Đề thi - Kiểm tra',
            'regulation' => 'Quy định - Thông tư',
            'form' => 'Biểu mẫu',
            'report' => 'Báo cáo',
            'other' => 'Khác'
        ];

        return view('Admin.documents.edit', compact('document', 'categories'));
    }

    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'file' => 'nullable|file|max:10240',
            'is_public' => 'nullable|boolean',
            'tags' => 'nullable|string'
        ]);

        try {
            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'is_public' => $request->has('is_public'),
            ];

            // Handle tags
            if ($request->filled('tags')) {
                $tags = explode(',', $request->tags);
                $tags = array_map('trim', $tags);
                $data['tags'] = $tags;
            }

            // Handle file upload
            if ($request->hasFile('file')) {
                // Delete old file
                if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                    Storage::disk('public')->delete($document->file_path);
                }

                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('documents', $fileName, 'public');

                $data['file_path'] = $filePath;
                $data['file_name'] = $file->getClientOriginalName();
                $data['file_size'] = $file->getSize();
                $data['file_type'] = $file->getMimeType();
            }

            $document->update($data);

            return redirect()->route('admin.documents.index')
                ->with('success', 'Tài liệu đã được cập nhật thành công!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi cập nhật tài liệu: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Document $document)
    {
        try {
            // Delete file from storage
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            $document->delete();

            return redirect()->route('admin.documents.index')
                ->with('success', 'Tài liệu đã được xóa thành công!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi xóa tài liệu: ' . $e->getMessage());
        }
    }

    public function download(Document $document)
    {
        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File not found');
        }

        // Increment download count
        $document->increment('downloads');

        return Storage::disk('public')->download($document->file_path, $document->file_name);
    }
}