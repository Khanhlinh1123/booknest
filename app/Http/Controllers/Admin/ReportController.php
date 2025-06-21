<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\BaoCaoDoanhThuExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
public function exportExcel(Request $request)
{
    $from = $request->input('from') ?? now()->startOfMonth()->toDateString();
    $to = $request->input('to') ?? now()->toDateString();

    return Excel::download(new BaoCaoDoanhThuExport($from, $to), "BaoCaoDoanhThu_{$from}_to_{$to}.xlsx");
}
}