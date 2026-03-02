<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'color',
        'order',
        'is_active'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
