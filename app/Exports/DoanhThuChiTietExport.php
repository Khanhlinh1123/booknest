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

class DoanhThuChiTietExport implements FromArray, WithHeadings, WithEvents, ShouldAutoSize, WithTitle
{
    protected $from, $to, $data = [], $tongTien = 0;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;

        $donHangs = Donhang::whereBetween('created_at', [$from, $to])
            ->where('tinhTrang', 'Đã hoàn thành')
            ->with(['chitiet.sach'])
            ->get();

        $stt = 1;
        foreach ($donHangs as $dh) {
            foreach ($dh->chitiet as $ct) {
                $tenSach = $ct->sach ? $ct->sach->tenSach : '(Không rõ)';
                $thanhTien = $ct->donGia * $ct->soLuong;

                $this->data[] = [
                    $stt++,
                    $dh->created_at->format('d/m/Y'),
                    $dh->maDH,
                    $tenSach,
                    number_format($ct->donGia, 0, ',', '.'),
                    $ct->soLuong,
                    number_format($thanhTien, 0, ',', '.'),
                ];

                $this->tongTien += $thanhTien;
            }
        }

        // Dòng tổng kết
        $this->data[] = [
            '',
            '',
            '',
            '',
            '',
            'TỔNG',
            number_format($this->tongTien, 0, ',', '.')
        ];
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            ['BÁO CÁO DOANH THU CHI TIẾT THEO SẢN PHẨM'],
            ["Khoảng thời gian: {$this->from} đến {$this->to}"],
            ['STT', 'Ngày đặt', 'Mã đơn', 'Tên sách', 'Đơn giá', 'Số lượng', 'Thành tiền'],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                $sheet->mergeCells('A1:G1');
                $sheet->mergeCells('A2:G2');

                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A1:G2')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A3:G3')->getFont()->setBold(true);
                $sheet->getStyle('A3:G3')->getAlignment()->setHorizontal('center');

                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle("A4:G{$highestRow}")->getAlignment()->setHorizontal('center');
                $sheet->getStyle("A{$highestRow}:G{$highestRow}")->getFont()->setBold(true);
            }
        ];
    }

    public function title(): string
    {
        return 'Chi tiết doanh thu';
    }
}
