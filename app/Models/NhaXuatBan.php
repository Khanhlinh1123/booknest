<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nhaxuatban extends Model
{
    protected $table = 'nhaxuatban';
    protected $primaryKey = 'maNXB';
    public $timestamps = true;

    protected $fillable = [
        'tenNXB', 'diaChi', 'soDT', 'email', 'created_at'
    ];
    public function sach() {
        return $this->hasMany(Sach::class, 'maNXB');
    }
}
