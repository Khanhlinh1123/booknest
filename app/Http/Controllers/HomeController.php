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
    $sachMoi = Sach::with('khuyenMai')->orderBy('created_at', 'desc')->take(4)->get();
    $tacgias = TacGia::orderBy('maTG')->take(6)->get();

    return view('home', compact('danhmucs','sachMoi','tacgias'));
}




}
