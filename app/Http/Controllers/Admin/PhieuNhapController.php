<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PhieuNhap;
use App\Models\ChiTietPhieuNhap;
use App\Models\Sach;

class PhieuNhapController extends Controller
{
    public function create() {
        $dsSach = Sach::all();
        return view('admin.phieunhap.create', compact('dsSach'));
    }

    public function store(Request $request) {
        $phieu = PhieuNhap::create(
            $request->only(['ngayNhap', 'ghiChu']) + ['nguoiNhap' => auth()->id()]
        );

        foreach ($request->sach_id as $i => $sach_id) {
            $soLuong = $request->so_luong[$i];
            $donGia = $request->don_gia[$i];

            ChiTietPhieuNhap::create([
                'phieuNhap_id' => $phieu->id,
                'sach_id' => $sach_id,
                'soLuong' => $soLuong,
                'donGia' => $donGia,
            ]);

            $sach = Sach::find($sach_id);
            if ($sach) {
                $soLuongCu = $sach->soLuong;
                $giaCu = $sach->giaGoc;

                $tongGiaTriCu = $soLuongCu * $giaCu;
                $tongGiaTriMoi = $soLuong * $donGia;
                $tongSoLuong = $soLuongCu + $soLuong;

                if ($tongSoLuong > 0) {
                    $giaBinhQuan = ($tongGiaTriCu + $tongGiaTriMoi) / $tongSoLuong;
                    $sach->giaGoc = round($giaBinhQuan); // làm tròn nếu muốn
                }

                $sach->soLuong = $tongSoLuong;
                $sach->save();
            }
        }

        return redirect()->route('admin.phieunhap.create')->with('success', 'Tạo phiếu nhập thành công');
    }
}
