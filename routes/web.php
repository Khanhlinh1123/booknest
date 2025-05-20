<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GioHangController;
use App\Http\Controllers\DonHangController;
use App\Http\Controllers\TacGiaController;
use App\Http\Controllers\DanhGiaController;
use App\Http\Controllers\BaiVietController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\VNPayController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;    
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\SocialController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('register', [RegisteredUserController::class, 'store']);

Route::get('/danh-muc/{maDM}', [App\Http\Controllers\DanhMucController::class, 'show'])->name('danhmuc.show');
use App\Http\Controllers\SachController;
Route::get('/sach-moi', [SachController::class, 'sachMoi'])->name('sach.new');

Route::get('/sach/{slug}', [SachController::class, 'show'])->name('sach.show');
Route::get('/gio-hang', [GioHangController::class, 'hienThiGioHang'])->name('giohang.hienthi');
Route::post('/gio-hang/them', [GioHangController::class, 'themVaoGio'])->name('giohang.them');
Route::post('/gio-hang/api-tang', [GioHangController::class, 'apiTang']);
Route::post('/gio-hang/api-giam', [GioHangController::class, 'apiGiam']);
Route::post('/gio-hang/api-xoa', [GioHangController::class, 'apiXoa']);
// Route::post('/gio-hang/xoa', [App\Http\Controllers\GioHangController::class, 'destroy'])->name('giohang.destroy');
// Route::post('/gio-hang/cap-nhat', [App\Http\Controllers\GioHangController::class, 'update'])->name('giohang.update');
// Route::get('/thanh-toan', [App\Http\Controllers\ThanhToanController::class, 'index'])->name('thanhtoan.index');
// Route::post('/thanh-toan', [App\Http\Controllers\ThanhToanController::class, 'store'])->name('thanhtoan.store');
// Route::get('/thong-tin-ca-nhan', [App\Http\Controllers\ThongTinCaNhanController::class, 'index'])->name('thongtincanhan.index');
// Route::post('/thong-tin-ca-nhan', [App\Http\Controllers\ThongTinCaNhanController::class, 'update'])->name('thongtincanhan.update');
// Route::get('/thong-tin-ca-nhan/doi-mat-khau', [App\Http\Controllers\ThongTinCaNhanController::class, 'editPassword'])->name('thongtincanhan.editPassword');
// Route::post('/thong-tin-ca-nhan/doi-mat-khau', [App\Http\Controllers\ThongTinCaNhanController::class, 'updatePassword'])->name('thongtincanhan.updatePassword');    
// Route::get('/thong-tin-ca-nhan/lich-su-mua-hang', [App\Http\Controllers\LichSuMuaHangController::class, 'index'])->name('lichsumuahang.index');
// Route::get('/thong-tin-ca-nhan/lich-su-mua-hang/{id}', [App\Http\Controllers\LichSuMuaHangController::class, 'show'])->name('lichsumuahang.show');
// Route::get('/thong-tin-ca-nhan/lich-su-mua-hang/{id}/chi-tiet', [App\Http\Controllers\LichSuMuaHangController::class, 'showChiTiet'])->name('lichsumuahang.chitiet');
// Route::get('/thong-tin-ca-nhan/lich-su-mua-hang/{id}/chi-tiet/xoa', [App\Http\Controllers\LichSuMuaHangController::class, 'destroy'])->name('lichsumuahang.chitiet.xoa');
Route::get('/tim-kiem', [App\Http\Controllers\HomeController::class, 'timKiem'])->name('timkiem');
Route::get('/api/sach-search', [App\Http\Controllers\HomeController::class, 'apiTimKiem']);
Route::get('/tac-gia', [TacGiaController::class, 'index'])->name('tacgia.index');
Route::get('/tac-gia/{slug}', [TacGiaController::class, 'show'])->name('tacgia.show');

Route::get('/bai-viet', [BaiVietController::class, 'index'])->name('baiviet.index');
Route::get('/bai-viet/{slug}', [BaiVietController::class, 'show'])->name('baiviet.show');
Route::post('/danh-gia/submit', [DanhGiaController::class, 'store'])->name('danhgia.submit');

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google.redirect');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::middleware('auth')->group(function () {
    Route::get('/dat-hang/thong-tin', [DonHangController::class, 'showStep1'])->name('dathang.step1');
    Route::post('/dat-hang/thong-tin', [DonHangController::class, 'handleStep1'])->name('dathang.step1.post');

    Route::get('/dat-hang/xac-nhan', [DonHangController::class, 'showStep2'])->name('dathang.step2');
    Route::post('/dat-hang/xac-nhan', [DonHangController::class, 'handleStep2'])->name('dathang.step2.post');
    
    // 💳 Khởi tạo thanh toán VNPay (GET để redirect được)
    Route::get('/vnpay-payment', [VnPayController::class, 'createPayment'])->name('vnpay.create');
});

// 🌐 Callback từ VNPay trả về (GET)
Route::get('/vnpay-return', [VNPayController::class, 'handleReturn'])->name('vnpay.return');



require __DIR__.'/auth.php';
