<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KhuyenMai;
use App\Models\Sach;
use Illuminate\Http\Request;

class KhuyenMaiController extends Controller
{
    public function index()
    {
        $khuyenmais = KhuyenMai::latest()->paginate(10);
        return view('admin.khuyenmai.index', compact('khuyenmais'));
    }

    public function create()
    {
        return view('admin.khuyenmai.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tenKM' => 'required|string|max:255',
            'moTa' => 'nullable|string',
            'loaiGiam' => 'required|in:percent,amount',
            'giaTri' => 'required|numeric|min:0',
            'batDau' => 'required|date',
            'ketThuc' => 'required|date|after_or_equal:batDau',
        ]);

        KhuyenMai::create($data);
        return redirect()->route('admin.khuyenmai.index')->with('success', 'Thêm khuyến mãi thành công.');
    }

    public function edit($id)
    {
        $khuyenmai = KhuyenMai::findOrFail($id);
        return view('admin.khuyenmai.edit', compact('khuyenmai'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'tenKM' => 'required|string|max:255',
            'moTa' => 'nullable|string',
            'loaiGiam' => 'required|in:percent,amount',
            'giaTri' => 'required|numeric|min:0',
            'batDau' => 'required|date',
            'ketThuc' => 'required|date|after_or_equal:batDau',
        ]);

        $khuyenmai = KhuyenMai::findOrFail($id);
        $khuyenmai->update($data);

        return redirect()->route('admin.khuyenmai.index')->with('success', 'Cập nhật thành công.');
    }

    public function destroy($id)
    {
        KhuyenMai::destroy($id);
        return back()->with('success', 'Đã xóa khuyến mãi.');
    }

    public function products($id)
    {
        $khuyenmai = KhuyenMai::findOrFail($id);
        $sachs = Sach::where('maKM', $id)->paginate(10);
        return view('admin.khuyenmai.products', compact('khuyenmai', 'sachs'));
    }
}
