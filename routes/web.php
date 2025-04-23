<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GioHangController;
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

Route::get('/sach/{id}', [SachController::class, 'show'])->name('sach.show');
// Route::get('/tim-kiem', [App\Http\Controllers\TimKiemController::class, 'index'])->name('timkiem.index');
Route::get('/gio-hang', [GioHangController::class, 'hienThiGioHang'])->name('giohang.hienthi');
Route::post('/gio-hang/them', [GioHangController::class, 'themVaoGio'])->name('giohang.them');
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

require __DIR__.'/auth.php';
