<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        try {
            $notifications = Notification::orderBy('created_at', 'desc')
                ->paginate(10);
        } catch (\Exception $e) {
            // Nếu bảng notifications chưa tồn tại
            return redirect()->back()->with('error', 'Bảng notifications chưa tồn tại. Vui lòng chạy migration: php artisan migrate');
        }
        
        return view('Admin.notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('Admin.notifications.create');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:info,success,warning,danger',
            'priority' => 'required|in:low,medium,high,urgent',
            'is_active' => 'sometimes|boolean',
            'show_on_homepage' => 'sometimes|boolean',
            'show_popup' => 'sometimes|boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $notification = Notification::create([
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'priority' => $request->priority,
            'is_active' => $request->has('is_active'),
            'show_on_homepage' => $request->has('show_on_homepage'),
            'show_popup' => $request->has('show_popup'),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'created_by' => Auth::user()->username ?? 'admin',
        ]);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Thông báo đã được tạo thành công!');
    }

    public function show(Notification $notification)
    {
        $notification->incrementViewCount();
        return view('Admin.notifications.show', compact('notification'));
    }

    public function edit(Notification $notification)
    {
        return view('Admin.notifications.edit', compact('notification'));
    }

    public function update(Request $request, Notification $notification)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:info,success,warning,danger',
            'priority' => 'required|in:low,medium,high,urgent',
            'is_active' => 'sometimes|boolean',
            'show_on_homepage' => 'sometimes|boolean',
            'show_popup' => 'sometimes|boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $notification->update([
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'priority' => $request->priority,
            'is_active' => $request->has('is_active'),
            'show_on_homepage' => $request->has('show_on_homepage'),
            'show_popup' => $request->has('show_popup'),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Thông báo đã được cập nhật thành công!');
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        
        return redirect()->route('admin.notifications.index')
            ->with('success', 'Thông báo đã được xóa thành công!');
    }

    public function toggleStatus(Notification $notification)
    {
        $notification->update([
            'is_active' => !$notification->is_active
        ]);

        $status = $notification->is_active ? 'kích hoạt' : 'vô hiệu hóa';
        return redirect()->back()
            ->with('success', "Thông báo đã được {$status} thành công!");
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'notifications' => 'required|array',
            'notifications.*' => 'exists:notifications,id'
        ]);

        $notifications = Notification::whereIn('id', $request->notifications);

        switch ($request->action) {
            case 'activate':
                $notifications->update(['is_active' => true]);
                $message = 'Các thông báo đã được kích hoạt!';
                break;
            case 'deactivate':
                $notifications->update(['is_active' => false]);
                $message = 'Các thông báo đã được vô hiệu hóa!';
                break;
            case 'delete':
                $notifications->delete();
                $message = 'Các thông báo đã được xóa!';
                break;
        }

        return redirect()->back()->with('success', $message);
    }

    // API endpoints for homepage
    public function getActiveNotifications()
    {
        try {
            $notifications = Notification::active()
                ->forHomepage()
                ->currentlyValid()
                ->byPriority()
                ->take(5)
                ->get();

            return response()->json($notifications);
        } catch (\Exception $e) {
            return response()->json([], 200); // Trả về mảng rỗng nếu bảng chưa tồn tại
        }
    }

    public function getPopupNotifications()
    {
        try {
            $notifications = Notification::active()
                ->forPopup()
                ->currentlyValid()
                ->byPriority()
                ->take(3)
                ->get();

            return response()->json($notifications);
        } catch (\Exception $e) {
            return response()->json([], 200); // Trả về mảng rỗng nếu bảng chưa tồn tại
        }
    }
}