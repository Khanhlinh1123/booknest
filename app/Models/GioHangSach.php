<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiohangSach extends Model
{
    protected $table = 'giohang_sach';
    protected $primaryKey = 'maGHS';
    public $timestamps = true;

    protected $fillable = [
        'maGH', 'maSach', 'soLuong', 'created_at'
    ];
    public function gioHangs()
    {
        return $this->belongsToMany(GioHang::class, 'giohang_sach', 'maSach', 'maGH')
                    ->withPivot('soLuong');
    }
}
