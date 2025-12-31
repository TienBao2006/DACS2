<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Login;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherAccountController extends Controller
{
    public function index()
    {
        // Lấy tất cả giáo viên, bao gồm cả những giáo viên chưa có tài khoản login
        $teachers = Teacher::with('login')->orderBy('created_at', 'desc')->get();
        
        // Tạo collection giả lập để hiển thị như tài khoản
        $teacherAccounts = $teachers->map(function($teacher) {
            return (object)[
                'id' => $teacher->login ? $teacher->login->id : $teacher->id, // Use login ID if exists, otherwise teacher ID
                'teacher_id' => $teacher->id, // Keep teacher ID for reference
                'username' => $teacher->login ? $teacher->login->username : ($teacher->ma_giao_vien ?? 'Chưa có'),
                'is_active' => $teacher->login ? $teacher->login->is_active : false,
                'created_at' => $teacher->created_at,
                'teacher' => $teacher,
                'has_login' => $teacher->login ? true : false
            ];
        });
        
        return view('Admin.accounts.teacher-accounts', compact('teacherAccounts'));
    }

    public function create()
    {
        return view('Admin.accounts.create-teacher-account');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:login,username',
            'password' => 'required|string|min:6',
            'ho_ten' => 'required|string|max:200',
            'gioi_tinh' => 'required|in:Nam,Nữ',
            'ngay_sinh' => 'nullable|date',
            'so_dien_thoai' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:100',
            'dia_chi' => 'nullable|string|max:500',
            'bang_cap' => 'nullable|string|max:200',
            'trinh_do_chuyen_mon' => 'nullable|string|max:200',
            'to_chuyen_mon' => 'nullable|string|max:100',
            'mon_day' => 'nullable|string|max:200',
            'mon_kiem_nhiem' => 'nullable|string|max:200',
            'nam_cong_tac' => 'nullable|integer|min:1990|max:' . date('Y'),
            'chuc_vu' => 'nullable|string|max:100',
            'lop_chu_nhiem' => 'nullable|string|max:50',
            'mo_ta' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        // Tạo mã giáo viên tự động
        $teacherCount = Teacher::count() + 1;
        $maGiaoVien = 'GV' . str_pad($teacherCount, 3, '0', STR_PAD_LEFT);
        
        // Kiểm tra trùng lặp mã giáo viên
        while (Teacher::where('ma_giao_vien', $maGiaoVien)->exists()) {
            $teacherCount++;
            $maGiaoVien = 'GV' . str_pad($teacherCount, 3, '0', STR_PAD_LEFT);
        }

        // Tạo tài khoản login
        $login = Login::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'Teacher',
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        // Tạo hồ sơ giáo viên với liên kết login_id
        Teacher::create([
            'login_id' => $login->id,
            'ma_giao_vien' => $maGiaoVien,
            'ho_ten' => $request->ho_ten,
            'gioi_tinh' => $request->gioi_tinh,
            'ngay_sinh' => $request->ngay_sinh,
            'so_dien_thoai' => $request->so_dien_thoai,
            'email' => $request->email,
            'dia_chi' => $request->dia_chi,
            'bang_cap' => $request->bang_cap,
            'trinh_do_chuyen_mon' => $request->trinh_do_chuyen_mon,
            'to_chuyen_mon' => $request->to_chuyen_mon,
            'mon_day' => $request->mon_day,
            'mon_kiem_nhiem' => $request->mon_kiem_nhiem,
            'nam_cong_tac' => $request->nam_cong_tac,
            'chuc_vu' => $request->chuc_vu ?? 'Giáo viên',
            'lop_chu_nhiem' => $request->lop_chu_nhiem,
            'mo_ta' => $request->mo_ta,
        ]);

        return redirect()->route('admin.teacher-accounts.index')
            ->with('success', "Tài khoản giáo viên {$maGiaoVien} đã được tạo thành công!");
    }

    public function edit($id)
    {
        $account = Login::where('role', 'Teacher')->findOrFail($id);
        $teacher = $account->teacher;
        
        return view('Admin.accounts.edit-teacher-account', compact('account', 'teacher'));
    }

    public function update(Request $request, $id)
    {
        $account = Login::where('role', 'Teacher')->findOrFail($id);
        $teacher = $account->teacher;

        $request->validate([
            'username' => 'required|string|max:255|unique:login,username,' . $account->id,
            'password' => 'nullable|string|min:6',
            'ho_ten' => 'required|string|max:200',
            'gioi_tinh' => 'required|in:Nam,Nữ',
            'ngay_sinh' => 'nullable|date',
            'so_dien_thoai' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:100',
            'dia_chi' => 'nullable|string|max:500',
            'bang_cap' => 'nullable|string|max:200',
            'trinh_do_chuyen_mon' => 'nullable|string|max:200',
            'to_chuyen_mon' => 'nullable|string|max:100',
            'mon_day' => 'nullable|string|max:200',
            'mon_kiem_nhiem' => 'nullable|string|max:200',
            'nam_cong_tac' => 'nullable|integer|min:1990|max:' . date('Y'),
            'chuc_vu' => 'nullable|string|max:100',
            'lop_chu_nhiem' => 'nullable|string|max:50',
            'mo_ta' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        // Cập nhật tài khoản login
        $account->username = $request->username;
        if ($request->filled('password')) {
            $account->password = Hash::make($request->password);
        }
        $account->is_active = $request->has('is_active') ? true : false;
        $account->save();

        // Cập nhật thông tin giáo viên (không cần username nữa)
        if ($teacher) {
            $teacher->update([
                'ho_ten' => $request->ho_ten,
                'gioi_tinh' => $request->gioi_tinh,
                'ngay_sinh' => $request->ngay_sinh,
                'so_dien_thoai' => $request->so_dien_thoai,
                'email' => $request->email,
                'dia_chi' => $request->dia_chi,
                'bang_cap' => $request->bang_cap,
                'trinh_do_chuyen_mon' => $request->trinh_do_chuyen_mon,
                'to_chuyen_mon' => $request->to_chuyen_mon,
                'mon_day' => $request->mon_day,
                'mon_kiem_nhiem' => $request->mon_kiem_nhiem,
                'nam_cong_tac' => $request->nam_cong_tac,
                'chuc_vu' => $request->chuc_vu ?? 'Giáo viên',
                'lop_chu_nhiem' => $request->lop_chu_nhiem,
                'mo_ta' => $request->mo_ta,
            ]);
        }

        return redirect()->route('admin.teacher-accounts.index')
            ->with('success', 'Tài khoản giáo viên đã được cập nhật thành công!');
    }

    public function destroy($id)
    {
        $account = Login::where('role', 'Teacher')->findOrFail($id);
        $teacher = $account->teacher;
        
        // Xóa hồ sơ giáo viên trước
        if ($teacher) {
            $teacher->delete();
        }
        
        // Xóa tài khoản login
        $account->delete();

        return redirect()->route('admin.teacher-accounts.index')
            ->with('success', 'Tài khoản giáo viên đã được xóa thành công!');
    }

    public function toggleStatus($id)
    {
        $account = Login::where('role', 'Teacher')->findOrFail($id);
        $account->is_active = !$account->is_active;
        $account->save();

        $status = $account->is_active ? 'kích hoạt' : 'vô hiệu hóa';
        return redirect()->back()
            ->with('success', "Tài khoản giáo viên đã được {$status} thành công!");
    }
}
