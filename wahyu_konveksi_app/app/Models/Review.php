<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['article_id','name','rating','review'];

    public function article() {
        return $this->belongsTo(Article::class);
    }
}
