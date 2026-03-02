<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up()
        {
            Schema::create('reviews', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('article_id');
                $table->string('name');   // pengunjung
                $table->unsignedTinyInteger('rating'); // 1-5
                $table->text('review')->nullable();
                $table->timestamps();

                $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            });
        }

};
