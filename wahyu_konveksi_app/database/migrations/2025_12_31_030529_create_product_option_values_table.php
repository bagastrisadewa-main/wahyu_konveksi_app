<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_option_values', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_option_id')
                ->constrained('product_options')
                ->onDelete('cascade');

            $table->string('label'); // contoh: Puring Full
            $table->integer('extra_price')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_option_values');
    }
};
