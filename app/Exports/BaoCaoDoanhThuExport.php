<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BaoCaoDoanhThuExport implements WithMultipleSheets
{
    protected $from, $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function sheets(): array
    {
        return [
            new DoanhThuExport($this->from, $this->to),         // Tổng hợp đơn hàng
            new DoanhThuChiTietExport($this->from, $this->to),  // Chi tiết sách trong đơn
        ];
    }
}
