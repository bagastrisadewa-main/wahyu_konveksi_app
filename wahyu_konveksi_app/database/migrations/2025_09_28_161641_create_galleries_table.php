<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable(); // opsional
            $table->string('title'); // judul galeri
            $table->string('image'); // path gambar
            $table->text('description')->nullable(); // opsional, keterangan foto
            $table->timestamps();

            // Relasi ke kategori (jika dipakai)
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
