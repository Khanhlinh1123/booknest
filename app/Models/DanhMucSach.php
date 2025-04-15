<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhmucSach extends Model
{
    protected $table = 'danhmuc_sach';
    protected $primaryKey = 'maDMS';
    public $timestamps = false;

    protected $fillable = [
        'maDM', 'maSach'
    ];

    public function danhMuc() {
        return $this->belongsTo(DanhMuc::class, 'maDMS');
    }
    public function sach() {
        return $this->belongsTo(Sach::class, 'maSach');
    }
}
