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
use App\Http\Controllers\MomoController;

use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Auth\VerifyEmailController;

use App\Http\Controllers\Admin\DanhMucController;   
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


Route::prefix('quan-tri')->middleware(['auth', 'is_admin'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

       
    Route::get('/basic-table', function () {
        return view('basic-table');
    });
    
    Route::resource('danhmuc', App\Http\Controllers\Admin\DanhMucController::class);
    Route::resource('sach', App\Http\Controllers\Admin\SachController::class);
    Route::resource('baiviet', App\Http\Controllers\Admin\BaiVietController::class);
    Route::resource('tacgia', App\Http\Controllers\Admin\TacGiaController::class);
    Route::resource('nhaxuatban', App\Http\Controllers\Admin\NXBController::class);
    Route::post('baiviet/upload', [App\Http\Controllers\Admin\BaiVietController::class, 'upload'])->name('baiviet.upload');
    Route::resource('khuyenmai', App\Http\Controllers\Admin\KhuyenMaiController::class);
    Route::get('khuyenmai/{id}/sach', [App\Http\Controllers\Admin\KhuyenMaiController::class, 'products'])->name('khuyenmai.sach');
    Route::get('donhang', [App\Http\Controllers\Admin\DonHangController::class, 'index'])->name('donhang.index');
    Route::post('donhang/{id}/cap-nhat-trang-thai', [App\Http\Controllers\Admin\DonHangController::class, 'capNhatTrangThai'])->name('donhang.updateStatus');

    Route::get('/compose', function () {
        return view('compose');
    });
    
    Route::get('/calendar', function () {
        return view('calendar');
    });
    
    Route::get('/chat', function () {
        return view('chat');
    });
    
    Route::get('/charts', function () {
        return view('charts');
    });
    
    Route::get('/forms', function () {
        return view('forms');
    });
    
    Route::get('/ui', function () {
        return view('ui');
    });
    
    Route::get('/datatable', function () {
        return view('datatable');
    });
    
    Route::get('/google-maps', function () {
        return view('google-maps');
    });
    
    Route::get('/vector-maps', function () {
        return view('vector-maps');
    });
    
    Route::get('/blank', function () {
        return view('blank');
    });
    
    Route::get('/404', function () {
        return view('404');
    });
    
    Route::get('/500', function () {
        return view('500');
    });
    
});
Route::get('/test-admin', function () {
    return 'TEST ADMIN';
})->middleware(['auth', 'is_admin'])->name('admin.test');


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/don-hang', [DonHangController::class, 'index'])->name('donhang.index');
    Route::get('/nhan-xet', [DanhGiaController::class, 'index'])->name('nhanxet.index');
    Route::post('/nhan-xet', [DanhGiaController::class, 'store'])->name('nhanxet.store');
    Route::get('/nhan-xet/{id}/edit', [DanhGiaController::class, 'edit'])->name('nhanxet.edit');
    Route::patch('/nhan-xet/{id}', [DanhGiaController::class, 'update'])->name('nhanxet.update');
    
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
    // Trang thanh toán
    Route::get('/thanh-toan', [DonHangController::class, 'showThanhToan'])->name('checkout');
    Route::post('/thanh-toan', [DonHangController::class, 'handleThanhToan'])->name('checkout.post');

    // VNPAY
    Route::get('/vnpay-payment', [VnPayController::class, 'createPayment'])->name('vnpay.create');


    // MOMO callback
    Route::get('/thanh-toan/momo/callback', [MomoController::class, 'momoCallback'])->name('momo.callback');
});


// 📩 IPN (callback server → server)
Route::post('/momo/ipn', [MomoController::class, 'handleIpn'])->name('momo.ipn');



require __DIR__.'/auth.php';
