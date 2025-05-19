<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NguoiDung extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $table = 'nguoidung';
    protected $primaryKey = 'maND';

    protected $fillable = [
        'tenDangNhap', 'matKhau', 'email', 'soDT', 'tenND', 'diaChi',
        'ngaySinh', 'gioiTinh', 'phanQuyen', 'avatar',
    ];

    protected $hidden = [
        'matKhau', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $timestamps = true;

    // Cung cấp đúng tên cột cho mật khẩu
    public function getAuthPassword()
    {
        return $this->matKhau;
    }

    // Các quan hệ
    public function donHangs()
    {
        return $this->hasMany(Donhang::class, 'maND');
    }

    public function danhGias()
    {
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

}
