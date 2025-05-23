<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sach;
use App\Models\DanhMuc;
use App\Models\TacGia;
use App\Models\KhuyenMai;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SachController extends Controller
{
    public function index()
    {
        $sachs = Sach::with(['danhmuc', 'tacGia', 'khuyenMai'])->paginate(10);
        return view('admin.sach.index', compact('sachs'));
    }

    public function create()
    {
        $danhmucs = DanhMuc::all();
        $tacgias = TacGia::all();
        $khuyenmais = KhuyenMai::all();
        return view('admin.sach.create', compact('danhmucs', 'tacgias', 'khuyenmais'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tenSach' => 'required|string|max:255',
            'giaGoc' => 'required|numeric',
            'maDM' => 'required|exists:danhmuc,maDM',
            'maTG' => 'required|exists:tacgia,maTG',
            'namXB' => 'required|integer',
            'soLuong' => 'required|integer',
            'kichThuoc' => 'nullable|string',
            'hinhanh' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'mieuta' => 'nullable|string',
            'maKM' => 'nullable|exists:khuyenmai,maKM'
        ]);

        if ($request->hasFile('hinhanh')) {
            $file = $request->file('hinhanh');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/sach'), $fileName);
            $data['hinhanh'] = $fileName; // chỉ lưu tên
        }
        $data['slug'] = Str::slug($data['tenSach']); // tự tạo slug từ tên sách

        Sach::create($data);
        return redirect()->route('admin.sach.index')->with('success', 'Thêm sách thành công.');
    }

    public function edit($id)
    {
        
        $sach = Sach::findOrFail($id);
        $danhmucs = DanhMuc::all();
        $tacgias = TacGia::all();
        $khuyenmais = KhuyenMai::all();
        return view('admin.sach.edit', compact('sach', 'danhmucs', 'tacgias', 'khuyenmais'));
    }

    public function update(Request $request, $id)
    {
        $sach = Sach::findOrFail($id);

        $data = $request->validate([
            'tenSach' => 'required|string|max:255',
            'giaGoc' => 'required|numeric',
            'maDM' => 'required|exists:danhmuc,maDM',
            'maTG' => 'required|exists:tacgia,maTG',
            'namXB' => 'required|integer',
            'soLuong' => 'required|integer',
            'kichThuoc' => 'nullable|string',
            'hinhanh' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'mieuta' => 'nullable|string',
            'maKM' => 'nullable|exists:khuyenmai,maKM'
        ]);
        if ($request->hasFile('hinhanh')) {
            $file = $request->file('hinhanh');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/sach'), $fileName);
            $data['hinhanh'] = $fileName;
        }
        
        
        $sach->update($data);
        return redirect()->route('admin.sach.index')->with('success', 'Cập nhật sách thành công.');
    }

    public function destroy($id)
    {
        Sach::destroy($id);
        return redirect()->route('admin.sach.index')->with('success', 'Xóa sách thành công.');
    }
}
