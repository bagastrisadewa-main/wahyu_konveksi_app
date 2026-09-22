<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'customer_id',
        'product_id',
        'price',
        'qty',
        'note',
        'subtotal'
    ];

    /* ================= RELATIONS ================= */

    public function customer()
{
    return $this->belongsTo(Customer::class);
}


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function options()
    {
        return $this->hasMany(OrderItemOption::class);
    }

    public function processes()
    {
        return $this->hasMany(OrderItemProcess::class);
    }
    
        public function processLogs()
    {
        return $this->hasMany(OrderItemProcessLog::class);
    }

    /* ================= HELPERS ================= */

    public function calculateSubtotal()
    {
        $extra = $this->options->sum('extra_price');

        $this->update([
            'subtotal' => ($this->price + $extra) * $this->qty
        ]);
    }


    // Proses terakhir dari tabel order_item_processes.
// Pakai koleksi yang sudah di-eager load supaya tidak N+1.
public function getCurrentProcessAttribute(): ?OrderItemProcess
{
    return $this->processes->sortByDesc('id')->first();
}

public function getProcessLabelAttribute(): string
{
    return $this->current_process?->process_name ?? 'Belum diproses';
}

public function getProcessColorAttribute(): string
{
    return $this->current_process?->status_color ?? 'secondary';
}



}
