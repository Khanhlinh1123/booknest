<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tacgia extends Model
{
    protected $table = 'tacgia';
    protected $primaryKey = 'maTG';
    public $timestamps = false;

    protected $fillable = [
        'tenTG', 'hinhanh'
    ];
    public function sach() {
        return $this->hasMany(Sach::class, 'maTG');
    }
}
