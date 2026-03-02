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
    Schema::table('settings', function (Blueprint $table) {
        $table->string('store_phone')->nullable();              // Nomor WhatsApp
        $table->string('store_instagram')->nullable();          // URL Instagram
        $table->string('store_tiktok')->nullable();             // URL TikTok
    });
}

public function down()
{
    Schema::table('settings', function (Blueprint $table) {
        $table->dropColumn([
            'store_phone',
            'store_instagram',
            'store_tiktok'
        ]);
    });
}


};
