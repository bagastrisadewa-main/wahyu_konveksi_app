<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderStatus;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // OrderStatus::truncate(); // aman saat dev, supaya tidak dobel

        OrderStatus::insert([
            [
                'name'  => 'Menunggu Konfirmasi',
                'slug'  => 'waiting_confirmation',
                'color' => 'warning',
                'order' => 1,
            ],
            [
                'name'  => 'Dikonfirmasi',
                'slug'  => 'confirmed',
                'color' => 'primary',
                'order' => 2,
            ],
            [
                'name'  => 'Menunggu DP',
                'slug'  => 'waiting_dp',
                'color' => 'info',
                'order' => 3,
            ],
            [
                'name'  => 'DP Diterima',
                'slug'  => 'dp_received',
                'color' => 'success',
                'order' => 4,
            ],
            [
                'name'  => 'Produksi',
                'slug'  => 'production',
                'color' => 'info',
                'order' => 5,
            ],
            [
                'name'  => 'Produksi Ditunda',
                'slug'  => 'production_hold',
                'color' => 'secondary',
                'order' => 6,
            ],
            [
                'name'  => 'Siap Dikirim',
                'slug'  => 'ready_shipping',
                'color' => 'primary',
                'order' => 7,
            ],
            [
                'name'  => 'Selesai',
                'slug'  => 'completed',
                'color' => 'success',
                'order' => 8,
            ],
            [
                'name'  => 'Dibatalkan',
                'slug'  => 'cancelled',
                'color' => 'danger',
                'order' => 9,
            ],
        ]);
    }
}
