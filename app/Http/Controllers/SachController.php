<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sach;

class SachController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sach = Sach::with(['tacGia', 'nhaXuatBan', 'khuyenMai'])->findOrFail($id);
        return view('sach.show', compact('sach'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function goiYSach(Request $request)
    {
        $keyword = $request->keyword;

        $sach = Sach::where('tenSach', 'like', '%' . $keyword . '%')
                    ->select('maSach', 'tenSach')
                    ->take(5)
                    ->get();

        return response()->json($sach);
    }

    public function timKiem(Request $request)
{
    $keyword = $request->input('tuKhoa');
    $sachs = \App\Models\Sach::where('tenSach', 'like', '%' . $keyword . '%')->get();

    return view('timkiem.ketqua', compact('sachs', 'keyword'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
