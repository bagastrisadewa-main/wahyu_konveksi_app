<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemProcess extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'process', // simpan slug/nama proses saja
        'status',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'started_at'   => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    // Relasi ke ProductionProcess di model bisa opsional
    // kita akan ambil nama via slug atau ID yang dikirim
    public function getProcessNameAttribute()
    {
        // Kalau mau ambil nama dari master process (array/slugs), bisa dicustom
        return $this->process; // langsung ambil dari kolom 'process'
    }
}
