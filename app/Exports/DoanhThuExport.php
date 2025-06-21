<?php

namespace App\Exports;

use App\Models\Donhang;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;

class DoanhThuExport implements FromArray, WithHeadings, WithEvents, ShouldAutoSize, WithTitle
{
    protected $from, $to, $data = [], $tongTien = 0, $tongSL = 0, $tongLoai = 0;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;

        $donHangs = Donhang::whereBetween('created_at', [$from, $to])
            ->where('tinhTrang', 'Đã hoàn thành')
            ->withCount([
                'chitiet as so_sach' => fn($q) => $q->select(DB::raw("SUM(soLuong)")),
                'chitiet as so_loai_sach' => fn($q) => $q->select(DB::raw("COUNT(DISTINCT maSach)")),
            ])
            ->get();

        foreach ($donHangs as $dh) {
            $this->data[] = [
                $dh->created_at->format('d/m/Y'),
                $dh->maDH,
                $dh->tongTien,
                $dh->so_sach,
                $dh->so_loai_sach,
            ];

            $this->tongTien += $dh->tongTien;
            $this->tongSL += $dh->so_sach;
            $this->tongLoai += $dh->so_loai_sach;
        }

        // Thêm dòng tổng
        $this->data[] = [
            'TỔNG',
            '',
            $this->tongTien,
            $this->tongSL,
            $this->tongLoai
        ];
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            ['BÁO CÁO DOANH THU THEO ĐƠN HÀNG'],
            ["Khoảng thời gian: {$this->from} đến {$this->to}"],
            ['Ngày đặt', 'Mã đơn hàng', 'Tổng tiền', 'Số lượng sách', 'Số sách khác nhau'],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;

                // In đậm tiêu đề
                $sheet->getStyle('A1:E1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A2:E2')->getFont()->setItalic(true);
                $sheet->mergeCells('A1:E1');
                $sheet->mergeCells('A2:E2');
                $sheet->getStyle('A1:E2')->getAlignment()->setHorizontal('center');

                // In đậm header
                $sheet->getStyle('A3:E3')->getFont()->setBold(true);
                $sheet->getStyle('A3:E3')->getAlignment()->setHorizontal('center');

                // Căn giữa dữ liệu
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle("A4:E{$highestRow}")->getAlignment()->setHorizontal('center');

                // In đậm dòng cuối (tổng)
                $sheet->getStyle("A{$highestRow}:E{$highestRow}")->getFont()->setBold(true);
            },
        ];
    }

    public function title(): string
    {
        return 'Báo cáo doanh thu';
    }
}
