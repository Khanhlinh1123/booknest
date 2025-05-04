<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMuc extends Model
{
    protected $table = 'danhmuc'; 
    protected $primaryKey = 'maDM'; 

    public $timestamps = false; 
    
    protected $fillable = ['tenDM'];

    public function sachs()
    {
        return $this->hasMany(Sach::class, 'maDM', 'maDM');
    }
}
