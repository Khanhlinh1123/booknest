<?php

namespace App\Http\Controllers;
use App\Models\BaiViet;

use Illuminate\Http\Request;

class BaiVietController extends Controller
{
            public function index()
            {
                $dsBaiViet = BaiViet::orderBy('created_at', 'desc')->paginate(6); // 6 bài mỗi trang
                return view('baiviet.index', compact('dsBaiViet'));
            }
            public function show($slug)
            {
                $baiViet = BaiViet::where('slug', $slug)->firstOrFail();
                return view('baiviet.show', compact('baiViet'));
            }
            

}
