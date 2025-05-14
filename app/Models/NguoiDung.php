<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NguoiDung extends Model implements AuthenticatableContract
{
    use Authenticatable;
    protected $table = 'nguoidung';
    protected $primaryKey = 'maND';

    protected $fillable = [
        'tenDangNhap', 'matKhau', 'email', 'soDT', 'tenND', 'diaChi',
        'ngaySinh', 'gioiTinh', 'phanQuyen', 'avatar', 
    ];
    public $timestamps = true;


    protected $hidden = ['matKhau'];
    public function donHangs() {
        return $this->hasMany(Donhang::class, 'maND');
    }

    public function danhGias() {
        return $this->hasMany(DanhGia::class, 'maND');
    }

    public function gioHang()
{
    return $this->hasOne(GioHang::class, 'maND');
}

    public function getAuthIdentifierName()
    {
        return 'maND';
    }
    public function getAuthPassword()
    {
        return $this->matKhau; 
    }
}
