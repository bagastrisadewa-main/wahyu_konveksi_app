<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductionProcess;

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

    // cache master process supaya tidak query berulang per item
protected static ?array $masterCache = null;

public function getProcessNameAttribute(): string
{
    if (blank($this->process)) {
        return 'Belum diproses';
    }

    // data lama: kolom process berisi ID ProductionProcess
    if (is_numeric($this->process)) {
        self::$masterCache ??= ProductionProcess::pluck('name', 'id')->all();

        return self::$masterCache[$this->process] ?? 'Belum diproses';
    }

    // data baru: sudah berupa nama proses
    return $this->process;
}

public function getStatusLabelAttribute(): string
{
    return match ($this->status) {
        'completed'  => 'Selesai',
        'processing' => 'Sedang diproses',
        'pending'    => 'Menunggu',
        default      => ucfirst((string) $this->status),
    };
}

public function getStatusColorAttribute(): string
{
    return match ($this->status) {
        'completed'  => 'success',
        'processing' => 'primary',
        'pending'    => 'warning',
        default      => 'secondary',
    };
}
    // public function getProcessNameAttribute()
    // {
    //     // Kalau mau ambil nama dari master process (array/slugs), bisa dicustom
    //     return $this->process; // langsung ambil dari kolom 'process'
    // }
}
