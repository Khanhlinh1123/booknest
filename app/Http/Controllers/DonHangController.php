<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sach;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use Illuminate\Support\Facades\DB;
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

    $tinhJson = json_decode(file_get_contents(public_path('js/vn-location/tinh_tp.json')), true);
    $huyenJson = json_decode(file_get_contents(public_path('js/vn-location/quan_huyen.json')), true);
    $xaJson = json_decode(file_get_contents(public_path('js/vn-location/xa_phuong.json')), true);
    
    $maTinh = $validated['tinh'];
    $maHuyen = $validated['huyen'];
    $maXa = $validated['xa'];
    
    $tenTinh = $tinhJson[$maTinh]['name'] ?? $maTinh;
    $tenHuyen = $huyenJson[$maHuyen]['name'] ?? $maHuyen;
    $tenXa = $xaJson[$maXa]['name'] ?? $maXa;
    
    $validated['diaChiFull'] = $validated['diaChi'] . ', ' . $tenXa . ', ' . $tenHuyen . ', ' . $tenTinh;
    

    session(['thongTinDatHang' => $validated]);

    return redirect()->route('dathang.step2');
}



public function showStep2()
{
    $thongTin = session('thongTinDatHang');
    $gioHang = session('gioHangDat', []);

    $tongTienHang = collect($gioHang)->sum(function ($item) {
        return $item['sach']->giaDaGiam * $item['soLuong'];
    });

    // 👉 Phí ship cố định: 30,000đ
    $phiShip = 30000;

    // 👉 Nếu muốn miễn phí cho đơn > 500k:
    // if ($tongTienHang >= 500000) $phiShip = 0;

    $tongTien = $tongTienHang + $phiShip;

    return view('dathang.step2', compact('thongTin', 'gioHang', 'tongTien', 'phiShip', 'tongTienHang'));
}

public function handleStep2(Request $request)
{
    $request->validate([
        'pttt' => 'required|string',
    ]);

    $user = auth()->user();
    $thongTin = session('thongTinDatHang');

    if (!$thongTin) {
        return redirect()->route('dathang.step1')->with('error', 'Bạn chưa nhập thông tin giao hàng.');
    }
        $gioHang = session('gioHangDat', []);

    $tongTien = collect($gioHang)->sum(function ($item) {
        return $item['sach']->giaDaGiam * $item['soLuong'];
    });

    
    // Tính phí ship (ví dụ: cố định 30,000)
    $phiShip = 30000;
    $tongTien += $phiShip;

    // Lưu đơn hàng
    $donHang = DonHang::create([
        'maND' => $user->maND,
        'tenNguoiNhan' => $thongTin['ten'],
        'soDT' => $thongTin['soDT'],
        'diaChi' => $thongTin['diaChiFull'],
        'tongTien' => $tongTien,
        'phuongThucGH' => $request->pttt,
        'tinhTrang' => 'Đang xử lý',
    ]);
    $gioHangDat = session('gioHangDat', []);

    // Lưu chi tiết đơn hàng
    foreach ($gioHang as $item) {
        ChiTietDonHang::create([
            'maDH' => $donHang->maDH,
            'maSach' => $item['sach']->maSach,
            'soLuong' => $item['soLuong'],
            'giaMua' => $item['sach']->giaDaGiam,
        ]);

        // Trừ số lượng tồn trong bảng sách
        $item['sach']->soLuong -= $item['soLuong'];
        $item['sach']->save();
    }

    $gioHang = GioHang::where('maND', $user->maND)->first();

    if ($gioHang) {
        $maSachDaMua = collect($gioHangDat)->pluck('sach.maSach')->toArray();

        DB::table('giohang_sach')
            ->where('maGH', $gioHang->maGH)
            ->whereIn('maSach', $maSachDaMua)
            ->delete();
    }


    // Xóa session
    session()->forget(['gioHangDat', 'thongTinDatHang']);

    return view('dathang.thankyou', compact('donHang'));
}



}
