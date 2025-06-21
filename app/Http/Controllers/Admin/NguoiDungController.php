<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NguoiDung;
use Illuminate\Http\Request;

class NguoiDungController extends Controller
{
    public function index()
    {
        $nguoidungs = NguoiDung::latest()->paginate(10);
        return view('admin.nguoidung.index', compact('nguoidungs'));
    }

    public function show($id)
    {
        $nguoidung = NguoiDung::findOrFail($id);
        return view('admin.nguoidung.show', compact('nguoidung'));
    }

    // Tùy chọn: thêm create, edit, destroy nếu cần
}
