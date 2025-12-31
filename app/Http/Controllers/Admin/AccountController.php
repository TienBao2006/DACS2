<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Login;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Login::all();
        return view('admin.accountManagement', compact('accounts'));
    }

    private function generateStudentCode($khoi, $lop)
    {

        $countInClass = Student::where('lop', $lop)->count() + 1;

        $lopCode = str_replace($khoi, '', $lop); 
        $stt = str_pad($countInClass, 2, '0', STR_PAD_LEFT);

        return $khoi . $lopCode . $stt;
    }
    public function storeAccount(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:login,username',
            'password' => 'required|string|min:6',
            'role' => 'required|string|in:admin,Teacher,Student',
            'is_active' => 'boolean',
            'khoi' => 'required_if:role,Student',
            'lop' => 'required_if:role,Student',
            'ho_va_ten' => 'required_if:role,Student'
        ]);

        Login::create([
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
            'is_active' => $request->input('is_active', true)
        ]);

        if ($request->input('role') === 'Teacher') {
            
            $teacherCount = Teacher::count() + 1;
            $maGiaoVien = 'GV' . str_pad($teacherCount, 3, '0', STR_PAD_LEFT);

            Teacher::create([
                'ma_giao_vien' => $maGiaoVien,
                'username' => $request->username,
            ]);
        }

        if ($request->input('role') === 'Student') {
            
            $maHocSinh = $this->generateStudentCode($request->khoi, $request->lop);

            while (Student::where('ma_hoc_sinh', $maHocSinh)->exists()) {
                $countInClass = Student::where('lop', $request->lop)->count() + 1;
                $lopCode = str_replace($request->khoi, '', $request->lop);
                $stt = str_pad($countInClass, 2, '0', STR_PAD_LEFT);
                $maHocSinh = $request->khoi . $lopCode . $stt;
                $countInClass++;
            }

            Student::create([
                'ma_hoc_sinh' => $maHocSinh,
                'ho_va_ten' => $request->ho_va_ten ?: $request->username,
                'trang_thai' => 'Đang học',
                'khoi' => $request->khoi,
                'lop' => $request->lop,
                'nam_hoc' => date('Y') . '-' . (date('Y') + 1)
            ]);
        }

        if ($request->input('role') === 'admin') {
            User::create([
                'username' => $request->username,
            ]);
        }

        return redirect()->back()->with('success', 'Tài khoản mới đã được tạo thành công!');
    }
    public function editAccount($id)
    {
        $account = Login::findOrFail($id);
        return view('admin.editAccount', compact('account'));
    }
    public function updateAccount(Request $request, $id)
    {
        $account = Login::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:255|unique:login,username,' . $account->id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|string|in:admin,Teacher,Student',
            'is_active' => 'boolean'
        ]);

        $account->username = $request->input('username');

        if ($request->filled('password')) {
            $account->password = Hash::make($request->input('password'));
        }
        $account->role = $request->input('role');
        $account->is_active = $request->input('is_active', true);
        $account->save();

        return redirect()->route('admin.account.index')->with('success', 'Tài khoản đã được cập nhật thành công!');
    }
    public function deleteAccount($id)
    {
        $account = Login::findOrFail($id);
        $account->delete();

        return redirect()->route('admin.account.index')->with('success', 'Tài khoản đã được xóa thành công!');
    }

    public function toggleStatus($id)
    {
        $account = Login::findOrFail($id);
        $account->is_active = !$account->is_active;
        $account->save();

        $status = $account->is_active ? 'kích hoạt' : 'vô hiệu hóa';
        return redirect()->back()->with('success', "Tài khoản đã được {$status} thành công!");
    }
}
