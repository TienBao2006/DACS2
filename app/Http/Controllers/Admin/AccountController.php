<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Login;
use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Login::all();
        return view('admin.accountManagement', compact('accounts'));
    }
    public function storeAccount(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:login,username',
            'password' => 'required|string|min:6',
            'role' => 'required|string|in:admin,Teacher,Student'
        ]);

        // Lưu tài khoản mới vào cơ sở dữ liệu
        Login::create([
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role')
        ]);

        // // Dieu kien them 
        // if ($request->input('role') === 'Teacher') {
        //     $teacher = Teacher::create([
        //         'username' => $request->username,
        //     ]);
        //     $teacher->ma_giao_vien = 'GV' . str_pad($teacher->id, 3, '0', STR_PAD_LEFT);
        //     $teacher->save();
        // }


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
            'role' => 'required|string|in:admin,Teacher,Student'
        ]);

        $account->username = $request->input('username');

        if ($request->filled('password')) {
            $account->password = Hash::make($request->input('password'));
        }
        $account->role = $request->input('role');
        $account->save();

        return redirect()->route('admin.account.index')->with('success', 'Tài khoản đã được cập nhật thành công!');
    }
    public function deleteAccount($id)
    {
        $account = Login::findOrFail($id);
        $account->delete();

        return redirect()->route('admin.account.index')->with('success', 'Tài khoản đã được xóa thành công!');
    }
}
