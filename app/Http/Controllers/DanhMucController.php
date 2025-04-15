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
    
        // Lấy query sẵn để áp dụng filter
        $query = $danhmuc->sachs()->with('tacGia');
    
        // Lọc khoảng giá nếu có
        if ($request->has('price')) {
            $priceRanges = $request->price;
            $query->where(function ($q) use ($priceRanges) {
                foreach ($priceRanges as $range) {
                    [$min, $max] = explode('-', str_replace('+', '-999999999', $range));
                    $q->orWhereBetween('giaGoc', [(int)$min, (int)$max]);
                }
            });
        }
    
        // Lọc tác giả nếu có
        if ($request->has('author')) {
            $query->whereHas('tacGia', function ($q) use ($request) {
                $q->whereIn('tenTG', $request->author);
            });
        }
    
        $sachs = $query->get();
    
        // Gửi dữ liệu danh sách tác giả và khoảng giá về view
        $authors = $danhmuc->sachs->pluck('tacGia.tenTG')->filter()->unique()->values();
        $priceRanges = [
            ['value' => '0-100000', 'label' => 'Dưới 100.000₫'],
            ['value' => '100000-200000', 'label' => '100.000₫ – 200.000₫'],
            ['value' => '200000-300000', 'label' => '200.000₫ – 300.000₫'],
            ['value' => '300000+', 'label' => 'Trên 300.000₫'],
        ];
    
        return view('danhmuc.show', compact('danhmuc', 'danhmucs', 'sachs', 'authors', 'priceRanges'));
    }
    

}