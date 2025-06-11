<?php
namespace App\Http\Controllers\Admin;

use App\Models\Visitor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\DonHang;
use App\Models\Sach;
use Carbon\Carbon;

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
    $topBooks = DB::table('chitietdonhang')
        ->select('maSach', DB::raw('SUM(soLuong) as total'))
        ->groupBy('maSach')
        ->orderByDesc('total')
        ->limit(5)
        ->get();

    // Tạo mảng nhãn và giá trị
    $bookLabels = [];
    $bookCounts = [];

    foreach ($topBooks as $book) {
        $tenSach = DB::table('sach')->where('maSach', $book->maSach)->value('tenSach');
        $bookLabels[] = $tenSach ?: "Sách ID " . $book->maSach;
        $bookCounts[] = $book->total;
    }
    $soLuongSachTheoThang = DB::table('donhang')
    ->join('chitietdonhang', 'donhang.maDH', '=', 'chitietdonhang.maDH')
    ->select(DB::raw("DATE_FORMAT(donhang.created_at, '%Y-%m') as thang"), DB::raw("SUM(chitietdonhang.soLuong) as soLuong"))
    ->groupBy('thang')
    ->orderBy('thang')
    ->pluck('soLuong')
    ->toArray();


        return view('admin.dashboard', compact(
            'tongTruyCapThang',
            'tongDonHangHomNay',
            'doanhThuThang',
            'tongSoSach',
            'donHangGanNhat','labels', 'values',
            'bookLabels', 'bookCounts',
            'soLuongSachTheoThang'
        ));
    }
}