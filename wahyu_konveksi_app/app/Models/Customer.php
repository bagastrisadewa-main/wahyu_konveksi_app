<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'password',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'last_login_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    // 🔹 relasi ke order (NANTI)
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

        // ✅ TAMBAHKAN INI
public function cartItems()
{
    return $this->hasMany(OrderItem::class)->whereNull('order_id');
}
}
