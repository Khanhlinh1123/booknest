<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\NguoiDung;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    // Validate input
    $request->validate([
        'tenDangNhap' => ['required', 'string', 'max:255', 'unique:nguoidung'],
        'tenND' => ['required', 'string', 'max:255'],
        'soDT' => ['required', 'string', 'max:15'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:nguoidung'],
        'matKhau' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    // Tạo người dùng mới
    $nguoiDung = NguoiDung::create([
        'tenDangNhap' => $request->tenDangNhap,
        'tenND' => $request->tenND,
        'soDT' => $request->soDT,
        'email' => $request->email,
        'matKhau' => Hash::make($request->matKhau),
        'phanQuyen' => 'customer',
    ]);

    // 📧 Gửi email xác minh
    event(new Registered($nguoiDung));

    // Tự động đăng nhập
    Auth::login($nguoiDung);

    // Chuyển hướng tới trang thông báo xác minh
    return redirect()->route('verification.notice');
}

}
