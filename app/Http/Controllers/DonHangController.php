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
    public function showThanhToan(Request $request)
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

            session(['gioHangDat' => $gioHang]);
        } else {
            $gioHang = session('gioHangDat', []);
        }

        $tongTienHang = collect($gioHang)->sum(fn($item) => $item['sach']->giaDaGiam * $item['soLuong']);
        $phiShip = 30000;
        $tongTien = $tongTienHang + $phiShip;

        return view('dathang.checkout', compact('gioHang', 'tongTienHang', 'phiShip', 'tongTien'));
    }

    public function handleThanhToan(Request $request)
    {
        $request->validate([
            'ten' => 'required|string',
            'soDT' => 'required|string',
            'tinh' => 'required|string',
            'huyen' => 'required|string',
            'xa' => 'required|string',
            'diaChi' => 'required|string',
            'pttt' => 'required|string',
            'tongTien' => 'required|numeric',
        ]);

        $thongTin = $request->only(['ten', 'soDT', 'tinh', 'huyen', 'xa', 'diaChi']);
        $gioHang = session('gioHangDat', []);

        $tinhJson = json_decode(file_get_contents(public_path('js/vn-location/tinh_tp.json')), true);
        $huyenJson = json_decode(file_get_contents(public_path('js/vn-location/quan_huyen.json')), true);
        $xaJson = json_decode(file_get_contents(public_path('js/vn-location/xa_phuong.json')), true);

        $thongTin['diaChiFull'] = $thongTin['diaChi'] . ', ' .
            ($xaJson[$thongTin['xa']]['name'] ?? $thongTin['xa']) . ', ' .
            ($huyenJson[$thongTin['huyen']]['name'] ?? $thongTin['huyen']) . ', ' .
            ($tinhJson[$thongTin['tinh']]['name'] ?? $thongTin['tinh']);

        // Lưu thông tin tạm để Momo / VNPay xử lý sau
        session(['tam_thanh_toan' => [
            'gioHang' => $gioHang,
            'thongTin' => $thongTin,
            'pttt' => $request->pttt
        ]]);

        // Gửi qua MOMO
        if ($request->pttt === 'momo') {
            return app()->call('App\Http\Controllers\MomoController@createPayment', ['request' => $request]);
        }
        
        
        

        // Gửi qua VNPAY
        if ($request->pttt === 'vnpay') {
            return redirect()->route('vnpay.create', ['amount' => $request->tongTien]);
        }

        // COD: xử lý đơn luôn
        $user = auth()->user();
        $tongTien = $request->tongTien;

        $donHang = DonHang::create([
            'maND' => $user->maND,
            'tenNguoiNhan' => $thongTin['ten'],
            'soDT' => $thongTin['soDT'],
            'diaChi' => $thongTin['diaChiFull'],
            'tongTien' => $tongTien,
            'phuongThucGH' => $request->pttt,
            'tinhTrang' => 'Đang xử lý',
        ]);

        foreach ($gioHang as $item) {
            ChiTietDonHang::create([
                'maDH' => $donHang->maDH,
                'maSach' => $item['sach']->maSach,
                'soLuong' => $item['soLuong'],
                'giaMua' => $item['sach']->giaDaGiam,
            ]);

            $item['sach']->soLuong -= $item['soLuong'];
            $item['sach']->save();
        }

        $gioHangDb = GioHang::where('maND', $user->maND)->first();

        if ($gioHangDb) {
            $maSachDaMua = collect($gioHang)->pluck('sach.maSach')->toArray();

            DB::table('giohang_sach')
                ->where('maGH', $gioHangDb->maGH)
                ->whereIn('maSach', $maSachDaMua)
                ->delete();
        }

        session()->forget(['gioHangDat']);

        return view('dathang.thankyou', compact('donHang'));
    }
}
