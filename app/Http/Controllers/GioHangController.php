<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DanhMuc;
use App\Models\Sach;
use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use App\Models\GioHang;
use App\Models\GioHangSach;

class GioHangController extends Controller
{

    
    
    public function themVaoGio(Request $request)
    {
        $maSach = $request->input('maSach');
        $soLuong = (int) $request->input('soLuong', 1);
    
        $sach = Sach::findOrFail($maSach); // Kiểm tra tồn tại
    
        if (Auth::check()) {
            // Người dùng đã đăng nhập -> Lưu vào DB
            $user = Auth::user();
    
            $gioHang = GioHang::firstOrCreate(['maND' => $user->maND]);
    
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
    
        } else {
            // Chưa đăng nhập -> Lưu vào session
            $cart = session()->get('cart', []);
    
            if (isset($cart[$maSach])) {
                $cart[$maSach] += $soLuong;
            } else {
                $cart[$maSach] = $soLuong;
            }
    
            session(['cart' => $cart]);
        }
    
        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng');
    }
    
public function hienThiGioHang()
{

    $items = [];

    if (Auth::check()) {
        // đã đăng nhập -> Lấy từ DB
        $gioHang = GioHang::firstOrCreate(['maND' => Auth::id()]);

        $items = GioHangSach::where('maGH', $gioHang->maGH)
            ->with('sach')
            ->get();
    } else {
        // Chưa đăng nhập -> Lấy từ session
        $sessionItems = session()->get('cart', []);
        $ids = array_keys($sessionItems);
        $sachs = Sach::whereIn('maSach', $ids)->get();

        $items = $sachs->map(function ($sach) use ($sessionItems) {
            return [
                'sach' => $sach,
                'soLuong' => $sessionItems[$sach->maSach],
            ];
        });
    }

    return view('giohang.show', compact('items'));
}
}