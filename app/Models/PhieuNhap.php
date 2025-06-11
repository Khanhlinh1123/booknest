<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuNhap extends Model {
    protected $table = 'phieunhap';
    protected $fillable = ['ngayNhap', 'ghiChu', 'nguoiNhap'];

    public function chiTiet() {
        return $this->hasMany(ChiTietPhieuNhap::class, 'phieuNhap_id');
    }
}



