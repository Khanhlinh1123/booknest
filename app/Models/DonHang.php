<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donhang extends Model
{
    protected $table = 'donhang';
    protected $primaryKey = 'maDH';
    public $timestamps = true;

    protected $fillable = [
        'maND', 'tenNguoiNhan', 'tongTien', 'tinhTrang', 'phuongThucGH', 'diaChi', 'soDT', 'created_at', 'updated_at'
    ];
    public function nguoiDung() {
        return $this->belongsTo(Nguoidung::class, 'maND');
    }
    
    public function sachs() {
        return $this->belongsToMany(Sach::class, 'chitietdonhang', 'maDH', 'maSach');
    }
    public function chitiet()
    {
        return $this->hasMany(\App\Models\ChiTietDonHang::class, 'maDH', 'maDH');
    }

    public static function tinhTrangList()
    {
        return [
            0 => 'Chờ xử lý',
            1 => 'Đang vận chuyển',
            2 => 'Đã giao',
            3 => 'Đã hủy'
        ];
    }

    public function getTenTinhTrangAttribute()
    {
        return self::tinhTrangList()[$this->tinhTrang] ?? 'Không xác định';
    }
}
