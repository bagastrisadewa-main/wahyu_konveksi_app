<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',        // base price / estimasi
        'stock',
        'slug', // ✅ WAJIB        
        // 'category',
        'category_id',
        'image',        // fallback image lama
        'images',       // JSON image
        'is_best_seller',
        'is_custom',
        'is_active',
        'auto_select_all_custom' // ✅ TAMBAH
    ];

    protected $casts = [
        'images' => 'array',
        'is_best_seller' => 'boolean',
        'is_custom' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Relasi kategori
     */
    public function category()
    {
         return $this->belongsTo(Category::class, 'category_id', 'id');
        // return $this->belongsTo(Category::class);
    }

    /**
     * Relasi order item (AMAN walau product soft delete)
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'id');
    }

    /**
     * Scope hanya produk aktif (untuk frontend)
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function options()
{
    return $this->hasMany(ProductOption::class);
}

 protected static function booted()
    {
        static::saving(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

}
