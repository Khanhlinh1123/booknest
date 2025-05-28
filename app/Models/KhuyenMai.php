<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhuyenMai extends Model
{
    protected $table = 'khuyenmai';
    protected $primaryKey = 'maKM';
    public $timestamps = true;

    protected $fillable = [
        'tenKM', 'moTa', 'loaiGiam', 'giaTri', 'batDau', 'ketThuc'
    ];

    public function sachs()
    {
        return $this->hasMany(Sach::class, 'maKM', 'maKM');
    }

}
