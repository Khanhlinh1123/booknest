<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PhieuNhap;
use App\Models\ChiTietPhieuNhap;
use App\Models\Sach;
use App\Models\TacGia;
use App\Models\Nhaxuatban;
use App\Models\DanhMuc;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PhieuNhapController extends Controller
{
    public function create()
    {
        $dsSach = Sach::all();
        $dsTacGia = TacGia::all();
        $dsNXB = Nhaxuatban::all();
        $dsDanhMuc = DanhMuc::all();

        return view('admin.phieunhap.create', compact('dsSach', 'dsTacGia', 'dsNXB', 'dsDanhMuc'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $phieu = PhieuNhap::create(
                $request->only(['ngayNhap', 'ghiChu']) + ['nguoiNhap' => auth()->id()]
            );

            foreach ($request->sach_id as $i => $sach_id) {
                $soLuong = $request->so_luong[$i];
                $donGia = $request->don_gia[$i];

                // Nếu là sách mới
                if ($sach_id === '__NEW__') {
                    $tenSachMoi = $request->sach_moi[$i] ?? null;
                    if ($tenSachMoi) {
                        $sach = Sach::create([
                            'tenSach'    => $tenSachMoi,
                            'maTG'       => $request->tac_gia_id[$i] ?? null,
                            'maNXB'      => $request->nxb_id[$i] ?? null,
                            'maDM'       => $request->danh_muc_id[$i] ?? null,
                            'soLuong'    => 0,
                            'giaGoc'     => 0,
                            'slug'       => Str::slug($tenSachMoi),
                        ]);
                        $sach_id = $sach->maSach;
                    } else {
                        continue; // Nếu thiếu tên sách thì bỏ qua dòng này
                    }
                }

                // Tạo chi tiết phiếu nhập
                ChiTietPhieuNhap::create([
                    'phieuNhap_id' => $phieu->id,
                    'sach_id'      => $sach_id,
                    'soLuong'      => $soLuong,
                    'donGia'       => $donGia,
                ]);

                // Cập nhật sách tồn kho & giá trung bình
                $sach = Sach::find($sach_id);
                if ($sach) {
                    $soLuongCu = $sach->soLuong;
                    $giaCu = $sach->giaGoc;

                    $tongGiaTriCu = $soLuongCu * $giaCu;
                    $tongGiaTriMoi = $soLuong * $donGia;
                    $tongSoLuong = $soLuongCu + $soLuong;

                    if ($tongSoLuong > 0) {
                        $giaBinhQuan = ($tongGiaTriCu + $tongGiaTriMoi) / $tongSoLuong;
                        $sach->giaGoc = round($giaBinhQuan);
                    }

                    $sach->soLuong = $tongSoLuong;
                    $sach->save();
                }
            }

            DB::commit();
            return redirect()->route('admin.phieunhap.create')->with('success', 'Tạo phiếu nhập thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
