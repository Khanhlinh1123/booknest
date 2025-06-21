<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DanhMuc;
use App\Models\Sach;


class DanhMucController extends Controller
{
    
    public function show($id, Request $request)
    {
        $danhmuc = DanhMuc::findOrFail($id);
        $danhmucs = DanhMuc::all(); // cho menu bên trái

        $priceRanges = [
            ['value' => '0-100000', 'label' => 'Dưới 100.000₫'],
            ['value' => '100000-200000', 'label' => '100.000₫ – 200.000₫'],
            ['value' => '200000-300000', 'label' => '200.000₫ – 300.000₫'],
            ['value' => '300000-10000000', 'label' => 'Trên 300.000₫'],
        ];

        $query = $danhmuc->sachs()
            ->with('tacGia')
            ->withCount('danhGias') // số lượt đánh giá
            ->withAvg('danhGias', 'soSao') // trung bình sao
            ->with(['donHangs' => function ($q) {
                $q->withPivot('soLuong');
            }]);
        switch ($request->sort) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            
            default:
                $query->orderBy('maSach', 'asc'); // mặc định
                break;
        }
        

        if ($request->has('price')) {
            $priceFilters = $request->price;
            $query->where(function ($q) use ($priceFilters) {
                foreach ($priceFilters as $range) {
                    [$min, $max] = explode('-', str_replace('+', '-10000000', $range));
                    $q->orWhereBetween('giaGoc', [(int)$min, (int)$max]);
                }
            });
        }

        if ($request->has('author')) {
            $query->whereHas('tacGia', function ($q) use ($request) {
                $q->whereIn('tenTG', $request->author);
            });
        }

        $sachs = $query->get();

if ($request->sort === 'price_asc') {
    $sachs = $sachs->sortBy(function ($sach) {
        return $sach->giaDaGiam;
    });
} elseif ($request->sort === 'price_desc') {
    $sachs = $sachs->sortByDesc(function ($sach) {
        return $sach->giaDaGiam;
    });
}

// Phân trang thủ công sau khi sort
$page = request()->get('page', 1);
$perPage = 12;
$sachs = new \Illuminate\Pagination\LengthAwarePaginator(
    $sachs->forPage($page, $perPage),
    $sachs->count(),
    $perPage,
    $page,
    ['path' => request()->url(), 'query' => request()->query()]
);


        $authors = $danhmuc->sachs->pluck('tacGia.tenTG')->filter()->unique()->values();

        return view('danhmuc.show', compact('danhmuc', 'danhmucs', 'sachs', 'authors', 'priceRanges'));
    }
    

}