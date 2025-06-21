<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BaiViet;
use App\Models\NguoiDung;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BaiVietController extends Controller
{
    public function index()
    {
        $baiviets = BaiViet::with('nguoiDung')->latest()->paginate(10);
        return view('admin.baiviet.index', compact('baiviets'));
    }

    public function create()
    {
        $nguoidungs = NguoiDung::all();
        return view('admin.baiviet.create', compact('nguoidungs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tieuDe' => 'required|string|max:255',
            'noiDung' => 'required',
            'anhBia' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Thêm người dùng đang đăng nhập
        $data['maND'] = auth()->user()->maND; // 👈 đúng với tên cột trong bảng

        if ($request->hasFile('anhBia')) {
            $file = $request->file('anhBia');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images/baiviet'), $fileName);
            // LƯU KÈM ĐƯỜNG DẪN
            $data['anhBia'] = 'images/baiviet/' . $fileName;
        }


        BaiViet::create($data);

        return redirect()->route('admin.baiviet.index')->with('success', 'Đã thêm bài viết.');
    }


    public function edit($id)
    {
        $baiviet = BaiViet::findOrFail($id);
        $nguoidungs = NguoiDung::all();
        return view('admin.baiviet.edit', compact('baiviet', 'nguoidungs'));
    }

    public function update(Request $request, $id)
    {
        $baiviet = BaiViet::findOrFail($id);

        $data = $request->validate([
            'tieuDe' => 'required|string|max:255',
            'noiDung' => 'required',
            'anhBia' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
                    $data['maND'] = auth()->user()->maND;


        if ($request->hasFile('anhBia')) {
            $file = $request->file('anhBia');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images/baiviet'), $fileName);
            $data['anhBia'] = 'images/baiviet/' . $fileName;
        } else {
            $data['anhBia'] = $baiviet->anhBia; // 👈 giữ nguyên ảnh cũ nếu không upload lại
        }



        $baiviet->update($data);

        return redirect()->route('admin.baiviet.index')->with('success', 'Cập nhật thành công.');
    }

    public function destroy($id)
    {
        BaiViet::destroy($id);
        return redirect()->route('admin.baiviet.index')->with('success', 'Đã xóa bài viết.');
    }
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/baiviet'), $fileName);

            $url = asset('images/baiviet/' . $fileName);
            return response()->json([
                'url' => $url
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
