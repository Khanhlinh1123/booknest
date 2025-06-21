<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sach extends Model
{
    protected $table = 'sach';
    protected $primaryKey = 'maSach';
    public $timestamps = false;

    protected $fillable = [
        'tenSach', 'giaGoc', 'maNXB', 'maTG', 'namXB',
        'soLuong', 'kichThuoc', 'hinhanh', 'mieuta', 'maKM', 'slug', 'maDM'
    ];
    

    public function khuyenMai()
    {
        return $this->belongsTo(KhuyenMai::class, 'maKM');
    }
    public function getGiaDaGiamAttribute()
    {
        if (!$this->khuyenMai || !$this->khuyenMai->giaTri) {
            return $this->giaGoc;
    }

    if ($this->khuyenMai->loaiGiam === 'percent') {
        return $this->giaGoc - ($this->giaGoc * $this->khuyenMai->giaTri / 100);
    } elseif ($this->khuyenMai->loaiGiam === 'amount') {
        return max(0, $this->giaGoc - $this->khuyenMai->giaTri);
    }

    return $this->giaGoc;
}
    public function tacGia() {
        return $this->belongsTo(TacGia::class, 'maTG');
    }
    public function danhmuc()
    {
        return $this->belongsTo(DanhMuc::class, 'maDM', 'maDM');
    }
    public function gioHangs() {
        return $this->belongsToMany(GioHang::class, 'giohang_sach', 'maSach', 'maGH');
    }
    public function donHangs()
    {
        return $this->belongsToMany(DonHang::class, 'chitietdonhang', 'maSach', 'maDH')->withPivot('soLuong');
    }
    public function soLuongDaBan()
    {
        return $this->donHangs()->sum('chitietdonhang.soLuong');
    }
    public function getSoLuongDaBanAttribute()
    {
        return $this->donHangs()->sum('chitietdonhang.soLuong');
    }
    public function danhGias() {
        return $this->hasMany(DanhGia::class, 'maSach');
    }
    

    public function nhaXuatBan() {
        return $this->belongsTo(Nhaxuatban::class, 'maNXB');
    }
        // Số lượt đánh giá
    public function getSoDanhGiaAttribute()
    {
        return $this->danhGias()->count();
    }

    // Trung bình số sao
    public function getTrungBinhSaoAttribute()
    {
        return round($this->danhGias()->avg('soSao'), 1) ?? 0;
    }

}
