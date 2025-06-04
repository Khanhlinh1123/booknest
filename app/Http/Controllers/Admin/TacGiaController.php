<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\TacGia;
use Illuminate\Http\Request;

class TacGiaController extends Controller
{
    public function index() {
        $tacgias = TacGia::paginate(10);
        return view('admin.tacgia.index', compact('tacgias'));
    }

    public function create() {
        return view('admin.tacgia.create');
    }

    public function store(Request $request) {
        $request->validate(['tenTG' => 'required|string|max:255']);
        TacGia::create($request->all());
        return redirect()->route('admin.tacgia.index')->with('success', 'Thêm tác giả thành công.');
    }

    public function edit($id) {
        $tacgia = TacGia::findOrFail($id);
        return view('admin.tacgia.edit', compact('tacgia'));
    }

    public function update(Request $request, $id) {
        $tacgia = TacGia::findOrFail($id);
        $request->validate(['tenTG' => 'required|string|max:255']);
        $tacgia->update($request->all());
        return redirect()->route('admin.tacgia.index')->with('success', 'Cập nhật tác giả thành công.');
    }

    public function destroy($id) {
        TacGia::destroy($id);
        return back()->with('success', 'Xóa tác giả thành công.');
    }
}