<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title','slug','content','user_id','layout','is_published',
        'meta_title','meta_description','keywords','views'
    ];

    public function images() {
        return $this->hasMany(ArticleImage::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function getRouteKeyName()
{
    return 'slug';
}
}
