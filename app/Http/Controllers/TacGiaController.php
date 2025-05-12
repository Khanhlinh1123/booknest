<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TacGia;
use App\Models\Sach;
use App\Models\DanhMuc;

class TacGiaController extends Controller
{
    public function index()
    {
        $tacgias = TacGia::all(); // hoặc paginate nếu nhiều
    return view('tacgia.index', compact('tacgias'));
        // Chưa có logic gì ở đây
    }
    public function show($slug)
    {
        $tacgia = TacGia::where('slug', $slug)->firstOrFail();
        $sachs = $tacgia->sach()->with('tacGia')->paginate(12); // 12 quyển / trang

        return view('tacgia.show', compact('tacgia', 'sachs'));
    }


    public function create()
    {
        // Chưa có logic gì ở đây
    }

    public function store(Request $request)
    {
        // Chưa có logic gì ở đây
    }

    
}