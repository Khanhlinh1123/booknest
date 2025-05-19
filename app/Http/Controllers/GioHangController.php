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

 // API tăng số lượng
public function apiTang(Request $request)
{
    $maSach = $request->input('maSach');

    if (Auth::check()) {
        $user = Auth::user();
        $gioHang = GioHang::firstOrCreate(['maND' => $user->maND]);

        DB::table('giohang_sach')
            ->where('maGH', $gioHang->maGH)
            ->where('maSach', $maSach)
            ->increment('soLuong', 1);
    } else {
        $cart = session('cart', []);
        $cart[$maSach] = ($cart[$maSach] ?? 0) + 1;
        session(['cart' => $cart]);
    }

    return response()->json(['success' => true]);
}

// API giảm số lượng
public function apiGiam(Request $request)
{
    $maSach = $request->input('maSach');
    $soLuongMoi = 0;

    if (Auth::check()) {
        $user = Auth::user();
        $gioHang = GioHang::firstOrCreate(['maND' => $user->maND]);

        $item = GioHangSach::where('maGH', $gioHang->maGH)
            ->where('maSach', $maSach)
            ->first();

        if ($item) {
            $item->soLuong--;
            if ($item->soLuong <= 0) {
                $item->delete();
                $soLuongMoi = 0;
            } else {
                $item->save();
                $soLuongMoi = $item->soLuong;
            }
        }

    } else {
        $cart = session('cart', []);
        if (isset($cart[$maSach])) {
            $cart[$maSach]--;
            if ($cart[$maSach] <= 0) {
                unset($cart[$maSach]);
                $soLuongMoi = 0;
            } else {
                $soLuongMoi = $cart[$maSach];
            }
            session(['cart' => $cart]);
        }
    }

    return response()->json([
        'success' => true,
        'soLuong' => $soLuongMoi,
        'canXoa' => $soLuongMoi <= 1
    ]);
}


// API xóa sản phẩm
public function apiXoa(Request $request)
{
    $maSach = $request->input('maSach');

    if (Auth::check()) {
        $user = Auth::user();
        $gioHang = GioHang::firstOrCreate(['maND' => $user->maND]);

        DB::table('giohang_sach')
            ->where('maGH', $gioHang->maGH)
            ->where('maSach', $maSach)
            ->delete();
    } else {
        $cart = session('cart', []);
        if (isset($cart[$maSach])) {
            unset($cart[$maSach]);
            session(['cart' => $cart]);
        }
    }

    return response()->json(['success' => true]);
}


}