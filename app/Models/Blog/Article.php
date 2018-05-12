<?php

namespace App\Models\Blog;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'blog_articles';
    protected $fillable = ['author_id','title','content'];

    public function author()
    {
        return $this->belongsTo(User::class,'author_id');
    }
}
