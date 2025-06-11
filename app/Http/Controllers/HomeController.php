<?php

namespace App\Http\Controllers;
use App\Models\DanhMuc;
use App\Models\Sach;
use App\Models\TacGia;
use App\Models\BaiViet;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{


public function index() {
    $danhmucs = DanhMuc::orderBy('tenDM')->get();
    $sachMoi = Sach::with('khuyenMai')->orderBy('created_at', 'desc')->take(5)->get();
    $tacgias = TacGia::orderBy('maTG')->take(5)->get();
    $top3BaiViet = BaiViet::latest('created_at')->take(3)->with('nguoiDung')->get();
     $top5BanChay = DB::table('chitietdonhang')
        ->select('maSach', DB::raw('SUM(soLuong) as tongSoLuong'))
        ->groupBy('maSach')
        ->orderByDesc('tongSoLuong')
        ->take(5)
        ->get();

    $top5Sach = Sach::with('khuyenMai')->whereIn('maSach', $top5BanChay->pluck('maSach'))->get();


    return view('home', compact('danhmucs','sachMoi','tacgias','top3BaiViet', 'top5Sach'));
}
public function timKiem(Request $request) {
    $keyword = $request->tuKhoa;
    $sachs = Sach::where('tenSach', 'like', '%' . $keyword . '%')->get();
    return view('timkiem', compact('sachs', 'keyword'));
}

public function apiTimKiem(Request $request) {
    $keyword = $request->q;
    $sachs = Sach::where('tenSach', 'like', '%' . $keyword . '%')->limit(5)->get();

    return response()->json($sachs->map(function ($sach) {
        return [
            'tenSach' => $sach->tenSach,
            'giaGoc' => $sach->giaGoc,
            'giaDaGiam' => $sach->giaDaGiam,
            'hinhanh' => asset('images/sach/' . $sach->hinhanh),
            'url' => route('sach.show', $sach->maSach),
        ];
    }));
}




}
