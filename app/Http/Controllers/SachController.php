<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sach;
use App\Models\DanhMuc;

class SachController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
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
    public function show($slug)
    {
        $sach = Sach::with(['tacGia', 'nhaXuatBan', 'khuyenMai'])->where('slug', $slug)->firstOrFail();
        $sachCDM = Sach::with('khuyenMai')
        ->where('maDM', $sach->maDM)
        ->where('maSach', '!=', $sach->maSach)
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
        $sach = Sach::where('slug', $slug)->with(['tacGia', 'nhaXuatBan', 'danhGias.nguoiDung'])->firstOrFail();

        // Lấy số lượng đánh giá và điểm trung bình
        $soDanhGia = $sach->danhGias()->count();
        $trungBinhSao = round($sach->danhGias()->avg('soSao'), 1); // làm tròn 1 chữ số thập phân

        // Các sách cùng danh mục
        $sachCDM = Sach::where('maDM', $sach->maDM)->where('maSach', '!=', $sach->maSach)->limit(5)->get();

        return view('sach.show', compact('sach', 'soDanhGia', 'trungBinhSao', 'sachCDM'));

    // Lấy 5 sách cùng danh mục (trừ chính nó)
    

    }
    public function sachMoi(Request $request)
    {
        $priceRanges = [
            ['value' => '0-100000', 'label' => 'Dưới 100.000₫'],
            ['value' => '100000-200000', 'label' => '100.000₫ – 200.000₫'],
            ['value' => '200000-300000', 'label' => '200.000₫ – 300.000₫'],
            ['value' => '300000-10000000', 'label' => 'Trên 300.000₫'],
        ];

        $query = Sach::with(['tacGia', 'danhMuc'])->orderBy('created_at', 'desc');

        // Lọc theo khoảng giá
        if ($request->has('price')) {
            $priceFilters = $request->price;
            $query->where(function ($q) use ($priceFilters) {
                foreach ($priceFilters as $range) {
                    [$min, $max] = explode('-', str_replace('+', '-10000000', $range));
                    $q->orWhereBetween('giaGoc', [(int)$min, (int)$max]);
                }
            });
        }

        // Lọc theo danh mục
        if ($request->has('danhmuc')) {
            $query->whereIn('maDM', $request->danhmuc);
        }

        // Sắp xếp
        $sachs = $query->get();
        if ($request->sort === 'price_asc') {
            $sachs = $sachs->sortBy(fn($sach) => $sach->giaDaGiam);
        } elseif ($request->sort === 'price_desc') {
            $sachs = $sachs->sortByDesc(fn($sach) => $sach->giaDaGiam);
        }

        // Phân trang thủ công
        $page = $request->get('page', 1);
        $perPage = 8;
        $sachs = new \Illuminate\Pagination\LengthAwarePaginator(
            $sachs->forPage($page, $perPage),
            $sachs->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $danhmucs = DanhMuc::all(); // để hiển thị bộ lọc thể loại

        return view('sach.new', compact('sachs', 'priceRanges', 'danhmucs'));
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
