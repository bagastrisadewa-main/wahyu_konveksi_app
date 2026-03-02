<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('navigation_menus', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);                // Nama menu (Beranda, Tentang Kami, ...)
            $table->string('slug', 200)->nullable()->index(); // Slug/URL friendly, bisa kosong (akan dibuat otomatis)
            $table->string('url', 255)->nullable();      // Jika link external/full-url
            $table->enum('type', ['internal', 'external'])->default('internal'); // internal = route/page, external = full URL
            $table->unsignedBigInteger('parent_id')->nullable()->index(); // parent untuk submenu
            $table->integer('order')->default(0);        // urutan tampil di navbar
            $table->string('icon')->nullable();          // nama kelas/icon (opsional)
            $table->boolean('active')->default(true);    // tampil/tidak
            $table->boolean('open_in_new_tab')->default(false); // buka di tab baru?
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navigation_menus');
    }
};
