<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DanhMuc;

class DanhMucController extends Controller
{
    public function index()
    {
        $danhmucs = DanhMuc::all();
        return view('admin.danhmuc.index', compact('danhmucs'));
    }

    public function create()
    {
        return view('admin.danhmuc.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tenDM' => 'required|string|max:255'
        ]);

        DanhMuc::create($request->only('tenDM'));

        return redirect()->route('admin.danhmuc.index')->with('success', 'Tạo danh mục thành công.');
    }

    public function edit($id)
    {
        $danhmuc = DanhMuc::findOrFail($id);
        return view('admin.danhmuc.edit', compact('danhmuc'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tenDM' => 'required|string|max:255'
        ]);

        $danhmuc = DanhMuc::findOrFail($id);
        $danhmuc->update($request->only('tenDM'));

        return redirect()->route('admin.danhmuc.index')->with('success', 'Cập nhật danh mục thành công.');
    }

    public function destroy($id)
    {
        $danhmuc = DanhMuc::findOrFail($id);
        $danhmuc->delete();

        return redirect()->route('admin.danhmuc.index')->with('success', 'Xóa danh mục thành công.');
    }
}
