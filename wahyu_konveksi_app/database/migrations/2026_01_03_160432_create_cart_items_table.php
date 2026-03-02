<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up()
        {
            Schema::create('cart_items', function (Blueprint $table) {
                $table->id();

                $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
                $table->foreignId('product_id')->constrained()->cascadeOnDelete();

                $table->integer('qty')->default(1);
                $table->integer('price');
                $table->text('note')->nullable();
                $table->integer('subtotal');

                $table->timestamps();
            });

        }

        public function down()
        {
            Schema::dropIfExists('cart_items');
        }

};
