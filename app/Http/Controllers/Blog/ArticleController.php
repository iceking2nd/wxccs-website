<?php

namespace App\Http\Controllers\Blog;

use App\Models\Blog\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('author')->paginate(10);
        return $articles;
    }

    public function show(Article $article)
    {
        return $article;
    }
}
