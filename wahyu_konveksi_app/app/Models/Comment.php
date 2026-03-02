<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'article_id',
        'name',
        'email',
        'comment',
        'rating',
        'is_approved'
    ];

    public function article() {
        return $this->belongsTo(Article::class);
    }
       public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }
}
