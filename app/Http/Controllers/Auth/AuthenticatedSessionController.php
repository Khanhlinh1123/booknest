<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\GioHang;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */

    

     public function store(Request $request): RedirectResponse
{
    $request->validate([
        'tenDangNhap' => ['required', 'string'],
        'matKhau' => ['required', 'string'],
    ]);

    $credentials = [
        'tenDangNhap' => $request->tenDangNhap,
        'password' => $request->matKhau,
    ];

    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();

        $user = Auth::user();

        // 🔄 Merge giỏ hàng từ session nếu có
        if (session()->has('cart')) {
            $cart = session('cart');

            // Tìm hoặc tạo giỏ hàng cho người dùng
            $gioHang = GioHang::firstOrCreate(['maND' => $user->maND]);

            foreach ($cart as $maSach => $soLuong) {
                // Kiểm tra nếu đã có sách trong giỏ, thì cộng dồn
                $existing = DB::table('giohang_sach')
                    ->where('maGH', $gioHang->maGH)
                    ->where('maSach', $maSach)
                    ->first();

                if ($existing) {
                    DB::table('giohang_sach')
                        ->where('maGH', $gioHang->maGH)
                        ->where('maSach', $maSach)
                        ->update([
                            'soLuong' => $existing->soLuong + $soLuong
                        ]);
                } else {
                    DB::table('giohang_sach')->insert([
                        'maGH' => $gioHang->maGH,
                        'maSach' => $maSach,
                        'soLuong' => $soLuong
                    ]);
                }
            }

            // Xoá giỏ hàng session sau khi merge
            session()->forget('cart');
        }

        // Điều hướng theo phân quyền
        if ($user->phanQuyen === 'admin') {
            return redirect()->route('dashboard');
        }

        return redirect()->route('home');
    }

    return back()->withErrors([
        'tenDangNhap' => 'Tài khoản hoặc mật khẩu không đúng.',
    ]);
}

     

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
