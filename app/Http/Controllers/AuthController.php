<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
{
    return view('auth.login');
}

public function login(Request $request)
{
    $credentials = $request->only('tenDangNhap', 'matKhau');

    if (Auth::attempt($credentials)) {
        return redirect('/')->with('success', 'Đăng nhập thành công!');
    }

    return back()->withErrors(['tenDangNhap' => 'Sai thông tin đăng nhập']);
}

public function logout()
{
    Auth::logout();
    return redirect('/');
}
}
