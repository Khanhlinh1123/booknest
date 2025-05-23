<?php

namespace App\Http\Controllers;
use App\Models\DonHang;
use App\Models\Sach;
use App\Models\DanhGia;

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
    }
    public function index()
{
    $user = auth()->user();

    // Lấy tất cả sách mà user đã mua
    $sanPhamDaMua = Sach::whereHas('donHangs', function ($q) use ($user) {
        $q->where('maND', $user->maND);
    })->with(['nhanxet' => function ($q) use ($user) {
        $q->where('maND', $user->maND);
    }])->get();

    return view('profile.nhanxet', compact('sanPhamDaMua'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'maSach' => 'required|exists:sachs,maSach',
        'noiDung' => 'required|string|max:1000',
        'sao' => 'required|integer|min:1|max:5',
    ]);

    $validated['maND'] = auth()->id();

    DanhGia::create($validated);

    return back()->with('success', 'Đã gửi nhận xét thành công!');
}

public function edit($id)
{
    $nhanxet = DanhGia::where('id', $id)->where('maND', auth()->id())->firstOrFail();

    return view('profile.sua_nhanxet', compact('nhanxet'));
}

public function update(Request $request, $id)
{
    $nhanxet = DanhGia::where('id', $id)->where('maND', auth()->id())->firstOrFail();

    $validated = $request->validate([
        'noiDung' => 'required|string|max:1000',
        'sao' => 'required|integer|min:1|max:5',
    ]);

    $nhanxet->update($validated);

    return redirect()->route('nhanxet.index')->with('success', 'Đã cập nhật nhận xét.');
}
}
    
