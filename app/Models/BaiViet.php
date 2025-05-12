<?php

namespace App\Models;
use Illuminate\Support\Str;


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

    

    protected static function booted()
    {
        static::creating(function ($baiViet) {
            $baiViet->slug = static::generateUniqueSlug($baiViet->tieuDe);
        });

        static::updating(function ($baiViet) {
            $baiViet->slug = static::generateUniqueSlug($baiViet->tieuDe, $baiViet->id);
        });
    }

    protected static function generateUniqueSlug($title, $ignoreId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (
            BaiViet::where('slug', $slug)
                ->when($ignoreId, fn($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return $slug;
    }


    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'maND', 'maND');
    }

    
}
