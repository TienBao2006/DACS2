<?php

namespace App\Http\Controllers\PageLogin;

use App\Http\Controllers\Controller;
use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = Login::where('username', $request->input('username'))->first();

        if ($user && Hash::check($request->input('password'), $user->password)) {
            // Đăng nhập thành công 
            return redirect()->route('admin.page')->with('success', 'Đăng nhập thành công!');
        } else {
            // Đăng nhập thất bại
            return redirect()->back()->with('error', 'Thông tin đăng nhập không đúng.');
        }
    }
}
