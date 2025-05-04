<?php

namespace App\Http\Controllers;
use App\Models\DanhMuc;
use App\Models\Sach;
use App\Models\TacGia;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{


public function index() {
    $danhmucs = DanhMuc::orderBy('tenDM')->get();
    $sachMoi = Sach::with('khuyenMai')->orderBy('created_at', 'desc')->take(5)->get();
    $tacgias = TacGia::orderBy('maTG')->take(6)->get();

    return view('home', compact('danhmucs','sachMoi','tacgias'));
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
