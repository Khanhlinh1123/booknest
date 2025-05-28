<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donhang;
use Illuminate\Http\Request;

class DonHangController extends Controller
{
    public function index()
    {
        $donhangs = Donhang::with('nguoiDung')->latest()->paginate(10);
        return view('admin.donhang.index', compact('donhangs'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'tinhTrang' => 'required|in:0,1,2,3'
        ]);

        $donhang = Donhang::findOrFail($id);

        if ((int)$request->tinhTrang <= $donhang->tinhTrang) {
            return back()->with('error', 'Không thể cập nhật về trạng thái thấp hơn!');
        }

        $donhang->update(['tinhTrang' => $request->tinhTrang]);

        return back()->with('success', 'Cập nhật trạng thái thành công!');
    }
}
