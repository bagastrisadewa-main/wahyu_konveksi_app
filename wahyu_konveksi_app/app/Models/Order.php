<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // ======= Kolom yang bisa diisi mass assignment =======
    protected $fillable = [
        'transaction_time',
        'total_price',
        'total_item',
        'subtotal',       // <<< tambahkan supaya create() bisa jalan
        'customer_id',
        'payment_method',
        'status',         // misal: 'pending', 'processing', 'completed'
        'order_number',   // opsional jika pakai
        'order_code',     // wajib sesuai DB
    ];

    // ================= RELATIONS =================
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // ================= HELPERS =================
    public function calculateTotals()
    {
        $totalPrice = $this->items->sum(fn($item) => $item->subtotal + $item->options->sum('extra_price'));
        $totalItem  = $this->items->sum('qty');
        $subtotal   = $this->items->sum('subtotal');

        $this->update([
            'total_price' => $totalPrice,
            'total_item'  => $totalItem,
            'subtotal'    => $subtotal,
        ]);
    }

        public function statusData()
        {
            return $this->belongsTo(OrderStatus::class, 'status', 'slug');
        }

}
