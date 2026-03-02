<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul utama
            $table->longText('description'); // Deskripsi panjang
            $table->string('image')->nullable(); // Gambar utama
            $table->string('banner_image')->nullable(); // Banner kecil
            $table->string('banner_title')->nullable(); // Judul di banner kecil
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};
