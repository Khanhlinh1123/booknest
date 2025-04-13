<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donhang extends Model
{
    protected $table = 'donhang';
    protected $primaryKey = 'maDH';
    public $timestamps = true;

    protected $fillable = [
        'maND', 'tongTien', 'tinhTrang', 'phuongThucGH', 'diaChi', 'soDT', 'created_at'
    ];
    public function nguoiDung() {
        return $this->belongsTo(Nguoidung::class, 'maND');
    }
    
    public function sachs() {
        return $this->belongsToMany(Sach::class, 'chitietdonhang', 'maDH', 'maSach');
    }
}
