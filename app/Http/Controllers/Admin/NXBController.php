<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NhaXuatBan;

class NXBController extends Controller
{
    public function index()
    {
        $nxb = NhaXuatBan::all();
        return view('admin.nhaxuatban.index', compact('nxb'));
    }

    public function create()
    {
        return view('admin.nhaxuatban.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tenNXB' => 'required|string|max:255'
        ]);

        NhaXuatBan::create($request->all());

        return redirect()->route('admin.nhaxuatban.index')->with('success', 'Thêm nhà xuất bản thành công.');
    }

    
    public function edit($id) {
        $nxb = NhaXuatBan::findOrFail($id);
        return view('admin.nhaxuatban.edit', compact('nxb'));
    }

    public function update(Request $request, $id) {
        $nxb = NhaXuatBan::findOrFail($id);
        $request->validate(['tenNXB' => 'required|string|max:255']);
        $nxb->update($request->all());
        return redirect()->route('admin.nhaxuatban.index')->with('success', 'Cập nhật nhà xuất bản thành công.');
    }

    public function destroy($id) {
        NhaXuatBan::destroy($id);
        return back()->with('success', 'Xóa nhà xuất bản thành công.');
    }
}
