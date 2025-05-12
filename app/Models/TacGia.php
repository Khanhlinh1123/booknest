<?php

namespace App\Models;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;

class Tacgia extends Model
{
    protected $table = 'tacgia';
    protected $primaryKey = 'maTG';
    public $timestamps = false;

    protected $fillable = [
        'tenTG', 'hinhanh', 'slug',
    ];
    public function sach() {
        return $this->hasMany(Sach::class, 'maTG');
    }
    protected static function booted()
    {
        static::creating(function ($tacgia) {
            $tacgia->slug = static::generateUniqueSlug($tacgia->tenTG);
        });

        static::updating(function ($tacgia) {
            $tacgia->slug = static::generateUniqueSlug($tacgia->tenTG, $tacgia->maTG);
        });
    }

    protected static function generateUniqueSlug($name, $ignoreId = null)
    {
        $slug = Str::slug($name);
        $original = $slug;
        $counter = 1;

        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn($query) => $query->where('maTG', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $original . '-' . $counter++;
        }

        return $slug;
    }
}
