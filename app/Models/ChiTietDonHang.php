<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chitietdonhang extends Model
{
    protected $table = 'chitietdonhang';
    protected $primaryKey = 'maDH';
    public $timestamps = false;

    protected $fillable = [
        'maSach', 'soLuong'
    ];
    public function donHang() {
        return $this->belongsTo(Donhang::class, 'maDH');
    }

    public function sach() {
        return $this->belongsTo(Sach::class, 'maSach');
    }
}
