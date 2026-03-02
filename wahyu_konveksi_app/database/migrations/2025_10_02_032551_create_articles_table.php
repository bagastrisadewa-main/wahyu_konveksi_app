<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up()
        {
            Schema::create('articles', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique(); // SEO URL
                $table->text('content');
                $table->unsignedBigInteger('user_id')->nullable(); // author jika mau
                $table->string('layout')->default('default'); // pilihan layout
                $table->boolean('is_published')->default(true);

                // SEO fields
                $table->string('meta_title')->nullable();
                $table->string('meta_description')->nullable();
                $table->string('keywords')->nullable();
                
                // Statistik
                $table->unsignedBigInteger('views')->default(0);

                $table->timestamps();
            });
        }

};
