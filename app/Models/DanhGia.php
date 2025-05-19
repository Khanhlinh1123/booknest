<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Danhgia extends Model
{
    protected $table = 'danhgia';
    protected $primaryKey = 'maNXET';
    public $timestamps = true;

    protected $fillable = [
        'maND', 'maSach', 'soSao', 'nhanXet', 'created_at'
    ];

    // Quan hệ người dùng
    public function nguoiDung() {
        return $this->belongsTo(NguoiDung::class, 'maND');
    }

    // Quan hệ sách
    public function sach() {
        return $this->belongsTo(Sach::class, 'maSach');
    }
}
