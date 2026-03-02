<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemProcessLog extends Model
{
    protected $fillable = [
        'order_item_process_id', // FK ke OrderItemProcess
        'status',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'started_at'   => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function orderItemProcess()
    {
        return $this->belongsTo(OrderItemProcess::class);
    }
}
