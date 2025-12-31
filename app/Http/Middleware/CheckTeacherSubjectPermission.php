<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckTeacherSubjectPermission
{
    /**
     * Kiểm tra giáo viên có quyền nhập điểm cho môn học này không
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        // Nếu không phải giáo viên, cho phép (admin có thể làm mọi thứ)
        if (!$user || $user->role !== 'Teacher') {
            return $next($request);
        }

        $teacher = $user->teacher;
        
        if (!$teacher) {
            return redirect()->back()->with('error', 'Không tìm thấy thông tin giáo viên');
        }

        // Lấy môn học từ request (có thể là trong form hoặc URL)
        $monHoc = $request->input('mon_hoc') ?? $request->route('mon_hoc');
        $lop = $request->input('lop') ?? $request->route('lop');
        
        if (!$monHoc || !$lop) {
            // Nếu không có thông tin môn học, cho phép tiếp tục (sẽ validate ở controller)
            return $next($request);
        }

        // Kiểm tra giáo viên có được phân công dạy môn này cho lớp này không
        $isAssigned = DB::table('timetable')
            ->where('ma_giao_vien', $teacher->ma_giao_vien)
            ->where('mon_hoc', $monHoc)
            ->where('lop', $lop)
            ->where('is_active', true)
            ->exists();

        if (!$isAssigned) {
            return redirect()->back()->with('error', 
                'Bạn không có quyền nhập điểm cho môn học này. Bạn chỉ được nhập điểm cho các môn được phân công.');
        }

        return $next($request);
    }
}
