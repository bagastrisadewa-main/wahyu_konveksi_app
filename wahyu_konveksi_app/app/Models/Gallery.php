<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'image',
        'description',
        'status',
    ];

    // Cast JSON → array
    protected $casts = [
        'image' => 'array',
    ];

    // Relasi kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Accessor aman untuk gambar gallery
     * Bisa handle:
     * - array (data baru)
     * - string JSON (data lama)
     * - null / rusak
     */
    public function getImagesAttribute()
    {
        if (is_array($this->image)) {
            return $this->image;
        }

        if (is_string($this->image)) {
            return json_decode($this->image, true) ?? [];
        }

        return [];
    }
}
