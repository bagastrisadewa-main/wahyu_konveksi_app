<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductionProcess;

class ProductionProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ProductionProcess::truncate(); // boleh di-comment agar tidak error karena foreign key

        ProductionProcess::insert([
            [
                'name'  => 'Belum Mulai',
                'order' => 1,
            ],
            [
                'name'  => 'Potong Kain',
                'order' => 2,
            ],
            [
                'name'  => 'Jahit',
                'order' => 3,
            ],
            [
                'name'  => 'Bordir',
                'order' => 4,
            ],
            [
                'name'  => 'Sablon',
                'order' => 5,
            ],
            [
                'name'  => 'QC',
                'order' => 6,
            ],
            [
                'name'  => 'Finishing',
                'order' => 7,
            ],
        ]);
    }
}
