<?php

namespace App\Http\Controllers\PageLogin;

use App\Http\Controllers\Controller;
use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

        $user = Login::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Sai tên đăng nhập hoặc mật khẩu.');
        }

        Auth::login($user);

        if ($user->role === 'Teacher') {
            return redirect()->route('teacher.dashboard');
        }

        if ($user->role === 'Student') {
            return redirect()->route('student.dashboard');
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin.page');
        }

        Auth::logout();
        return back()->with('error', 'Tài khoản không hợp lệ.');
    }
}
