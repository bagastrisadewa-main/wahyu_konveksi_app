<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'type',         // checkbox, select, number
        'is_required'
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    /**
     * Relasi ke produk
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relasi ke nilai opsi
     */
    public function values()
    {
        return $this->hasMany(ProductOptionValue::class);
    }
}
