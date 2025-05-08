<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaiViet extends Model
{
    use HasFactory;

    protected $table = 'baiviet';

    protected $fillable = [
        'tieuDe',
        'slug',
        'tomTat',
        'noiDung',
        'anhBia',
        'nguoi_dung_id',
    ];

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'maND', 'maND');
    }

    
}
