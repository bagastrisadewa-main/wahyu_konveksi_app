<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {

            // Soft delete (AMAN untuk order lama)
            $table->softDeletes()->after('updated_at');

            // Penanda produk custom / preorder
            $table->boolean('is_custom')
                  ->default(true)
                  ->after('is_best_seller');

            // Aktif / nonaktif tanpa delete
            $table->boolean('is_active')
                  ->default(true)
                  ->after('is_custom');

            // Catatan:
            // - kolom images sudah ada (json)
            // - stock & image lama tetap dipertahankan
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['deleted_at', 'is_custom', 'is_active']);
        });
    }
};
