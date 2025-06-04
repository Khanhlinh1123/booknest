<?php
namespace App\Http\Controllers\Admin;

use App\Models\Visitor;
use App\Http\Controllers\Controller;
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

        return view('admin.dashboard', compact(
            'tongTruyCapThang',
            'tongDonHangHomNay',
            'doanhThuThang',
            'tongSoSach',
            'donHangGanNhat'
        ));
    }
}