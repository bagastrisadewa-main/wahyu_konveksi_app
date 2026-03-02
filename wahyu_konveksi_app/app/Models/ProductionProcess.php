<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionProcess extends Model
{
    protected $fillable = [
        'name',
        'order',
        'is_active'
    ];

    public function logs()
    {
        return $this->hasMany(OrderItemProcessLog::class);
    }
}
