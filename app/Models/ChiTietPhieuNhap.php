<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietPhieuNhap extends Model {
    protected $table = 'chitietphieunhap';
    protected $fillable = ['phieuNhap_id', 'sach_id', 'soLuong', 'donGia'];

    public function sach() {
        return $this->belongsTo(Sach::class, 'sach_id', 'maSach');
    }
}
