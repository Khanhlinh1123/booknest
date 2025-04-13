<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Giohang extends Model
{
    protected $table = 'giohang';
    protected $primaryKey = 'maGH';
    public $timestamps = false;

    protected $fillable = [
        'maND'
    ];
    public function nguoiDung()
{
    return $this->belongsTo(NguoiDung::class, 'maND');
}

public function sachs()
{
    return $this->belongsToMany(Sach::class, 'giohang_sach', 'maGH', 'maSach')
                ->withPivot('soLuong');
}
}
