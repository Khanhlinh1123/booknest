<?php

namespace App\Http\Controllers;
use App\Models\DonHang;

use Illuminate\Http\Request;

class DanhGiaController extends Controller
{
    public function create($maSach)
    {
        $user = auth()->user();
    
        // Kiểm tra xem người dùng đã mua sách này chưa
        $daMua = DonHang::where('maND', $user->maND)
            ->whereHas('sach', function ($query) use ($maSach) {
                $query->where('maSach', $maSach);
            })
            ->exists();
    
        if (!$daMua) {
            return redirect()->back()->with('error', 'Bạn cần mua sách này trước khi có thể đánh giá.');
        }
    
        return view('danhgia.form', compact('maSach'));
    }}
    
