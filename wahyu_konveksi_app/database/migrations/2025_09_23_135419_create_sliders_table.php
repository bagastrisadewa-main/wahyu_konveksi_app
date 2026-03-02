<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();       // judul slider
            $table->string('subtitle')->nullable();    // sub judul / deskripsi singkat
            $table->string('button_text')->nullable(); // teks tombol (Shop Now)
            $table->string('button_link')->nullable(); // link tombol
            $table->string('image');                   // path gambar
            $table->integer('order')->default(0);      // urutan tampil
            $table->boolean('is_active')->default(true); // aktif / tidak
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
