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
    return view('tacgia.show', compact('tacgias'));
        // Chưa có logic gì ở đây
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