<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {

            $table->renameColumn('quantity', 'qty');

            $table->integer('price')->after('product_id');
            $table->text('note')->nullable()->after('qty');
            $table->integer('subtotal')->after('note');

            $table->dropColumn('total_price');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {

            $table->renameColumn('qty', 'quantity');

            $table->dropColumn(['price', 'note', 'subtotal']);

            $table->integer('total_price');
        });
    }
};
