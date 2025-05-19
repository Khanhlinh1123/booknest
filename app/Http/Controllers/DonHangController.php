<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sach;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use App\Models\GioHang;
class DonHangController extends Controller
{
    public function showStep1(Request $request)
{
    $chonSach = $request->input('chonSach', []);
    $gioHang = [];

    if (count($chonSach)) {
        $cart = session('cart', []);
        $sachs = Sach::whereIn('maSach', $chonSach)->get();

        foreach ($sachs as $sach) {
            $soLuong = $cart[$sach->maSach] ?? 1;
            $gioHang[] = [
                'sach' => $sach,
                'soLuong' => $soLuong
            ];
        }

        // Lưu tạm vào session để dùng ở bước tiếp theo
        session(['gioHangDat' => $gioHang]);
    } else {
        $gioHang = session('gioHangDat', []);
    }

    return view('dathang.step1', compact('gioHang'));
}

public function handleStep1(Request $request)
{
    $validated = $request->validate([
        'ten' => 'required|string',
        'soDT' => 'required|string',
        'tinh' => 'required|string',
        'huyen' => 'required|string',
        'xa' => 'required|string',
        'diaChi' => 'required|string',

    ]);

    // Gộp địa chỉ
    $validated['diaChiFull'] = $validated['diaChi'] . ', ' . $validated['xa'] . ', ' . $validated['huyen'] . ', ' . $validated['tinh'];

    session(['thongTinDatHang' => $validated]);

    return redirect()->route('dathang.step2');
}



public function showStep2()
{
    $thongTin = session('thongTinDatHang');
    $gioHang = session('gioHangDat', []);

    $tongTien = collect($gioHang)->sum(function ($item) {
        return $item['sach']->giaDaGiam * $item['soLuong'];
    });

    return view('dathang.step2', compact('thongTin', 'gioHang', 'tongTien'));
}
public function handleStep2(Request $request)
{
    $user = auth()->user();
    $thongTin = session('thongTinDatHang');
    $gioHang = session('gioHangDat', []);

    $tongTien = collect($gioHang)->sum(function ($item) {
        return $item['sach']->giaDaGiam * $item['soLuong'];
    });

    $donHang = DonHang::create([
        'maND' => $user->maND,
        'tenNguoiNhan' => $thongTin['ten'], // 👈 lưu tên người nhận
        'soDT' => $thongTin['soDT'],
        'diaChiGiao' => $thongTin['diaChi'],
        'ghiChu' => $thongTin['ghiChu'] ?? null,
        'tongTien' => $tongTien,
        'phuongThucGH' => 'required|string', // 👈 thêm dòng này

    ]);

    // ... lưu chi tiết đơn hàng, xóa session

    return view('dathang.thankyou', compact('donHang'));
}



}
