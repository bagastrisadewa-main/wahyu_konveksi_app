<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up()
        {
            Schema::create('article_images', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('article_id');
                $table->string('image_path'); // path upload
                $table->string('caption')->nullable();
                $table->timestamps();

                $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            });
        }
};
