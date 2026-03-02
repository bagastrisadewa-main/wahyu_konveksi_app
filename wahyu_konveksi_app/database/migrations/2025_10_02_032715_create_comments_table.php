<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up()
        {
            Schema::create('comments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('article_id');
                $table->string('name');   // pengunjung
                $table->string('email')->nullable();
                $table->text('comment');
                $table->boolean('is_approved')->default(true);
                $table->timestamps();

                $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            });
        }
};
