<?php
namespace App\Http\Controllers\Admin;

use App\Models\Visitor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\DonHang;
use App\Models\Sach;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $thangNay = Carbon::now()->month;
        $namNay = Carbon::now()->year;

        $tongTruyCapThang = Visitor::whereMonth('date', $thangNay)
                                    ->whereYear('date', $namNay)
                                    ->count();

        $tongDonHangHomNay = DonHang::whereDate('created_at', today())->count();

        $doanhThuThang = DonHang::whereMonth('created_at', $thangNay)
                                ->whereYear('created_at', $namNay)
                                ->sum('tongTien');

        $tongSoSach = Sach::count();

        $donHangGanNhat = DonHang::latest()->take(5)->get();

        $revenueByMonth = DonHang::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw("SUM(tongTien) as total")
        )
        ->where('tinhTrang', 'Đã hoàn thành')
        ->groupBy('month')
        ->orderBy('month')
        ->get();
        

        $labels = $revenueByMonth->pluck('month');
        $values = $revenueByMonth->pluck('total');
        // Lấy top 5 sách bán chạy
        $topBooks = Sach::select('tenSach', DB::raw('SUM(chitietdonhang.soLuong) as total'))
        ->join('chitietdonhang', 'sach.maSach', '=', 'chitietdonhang.maSach')
        ->join('donhang', 'donhang.maDH', '=', 'chitietdonhang.maDH')
        ->where('donhang.tinhTrang', 'Đã hoàn thành')
        ->groupBy('sach.maSach', 'tenSach')
        ->orderByDesc('total')
        ->limit(5)
        ->get();

    $bookLabels = $topBooks->pluck('tenSach');
    $bookCounts = $topBooks->pluck('total');


    
        $soLuongSachTheoThang = Donhang::where('tinhTrang', 'Đã hoàn thành')
        ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as thang, SUM(sl.soLuong) as soLuong")
        ->leftJoin('chitietdonhang as sl', 'donhang.maDH', '=', 'sl.maDH')
        ->groupBy('thang')
        ->orderBy('thang')
        ->pluck('soLuong', 'thang')
        ->toArray();

        $soLuongTheoThang = [];
        foreach ($labels as $thang) {
            $soLuongTheoThang[] = $soLuongSachTheoThang[$thang] ?? 0;
        }

        return view('admin.dashboard', compact(
            'tongTruyCapThang',
            'tongDonHangHomNay',
            'doanhThuThang',
            'tongSoSach',
            'donHangGanNhat',
            'labels',
            'values',
            'bookLabels',
            'bookCounts',
            'soLuongTheoThang' 
        ));

    }
    public function ajaxData(Request $request)
{
    $from = $request->input('from') ?? now()->startOfMonth()->toDateString();
    $to = $request->input('to') ?? now()->toDateString();

    // 1. Tạo danh sách tất cả các tháng trong khoảng
    $labels = [];
    $start = Carbon::parse($from)->startOfMonth();
    $end = Carbon::parse($to)->startOfMonth();

    while ($start <= $end) {
        $labels[] = $start->format('m/Y');
        $start->addMonth();
    }

    // 2. Truy vấn từ DB
    $data = Donhang::where('tinhTrang', 'Đã hoàn thành')
        ->whereBetween('created_at', [$from, $to])
        ->selectRaw('DATE_FORMAT(created_at, "%m/%Y") as thang, SUM(tongTien) as tong, SUM(sl.soLuong) as soLuong')
        ->leftJoin('chitietdonhang as sl', 'donhang.maDH', '=', 'sl.maDH')
        ->groupBy('thang')
        ->pluck('tong', 'thang')
        ->toArray();

    $soLuong = Donhang::where('tinhTrang', 'Đã hoàn thành')
        ->whereBetween('created_at', [$from, $to])
        ->selectRaw('DATE_FORMAT(created_at, "%m/%Y") as thang, SUM(sl.soLuong) as sl')
        ->leftJoin('chitietdonhang as sl', 'donhang.maDH', '=', 'sl.maDH')
        ->groupBy('thang')
        ->pluck('sl', 'thang')
        ->toArray();

    // 3. Gắn giá trị hoặc 0 nếu không có
    $values = [];
    $soLuongArr = [];
    foreach ($labels as $thang) {
        $values[] = $data[$thang] ?? 0;
        $soLuongArr[] = $soLuong[$thang] ?? 0;
    }

    return response()->json([
        'labels' => $labels,
        'values' => $values,
        'soLuong' => $soLuongArr,
    ]);
}


}