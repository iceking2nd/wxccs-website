<?php

namespace App\Http\Controllers\Blog;

use App\Models\Blog\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function index()
    {
        return Article::paginate(10);
    }

    public function show(Article $article)
    {
        return $article;
    }
}
