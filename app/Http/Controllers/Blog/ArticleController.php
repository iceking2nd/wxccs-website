<?php

namespace App\Http\Controllers\Blog;

use App\Models\Blog\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['store','update']);
    }

    public function index()
    {
        $articles = Article::with('author')->orderBy('created_at','desc')->paginate(10);
        return $articles;
    }

    public function show(Article $article)
    {
        $data = $article;
        $data['author'] = $article->author;
        return $data;
    }

    public function store(Request $request)
    {
        $author_id = auth()->guard('api')->user()->id;
        try
        {
            $article = Article::create([
                'author_id' => $author_id,
                'title' => $request->get('title'),
                'content' => $request->get('content'),
            ]);
            return response()->json($article->toArray());
        }
        catch (\Exception $exception)
        {
            return response()->json($exception,500);
        }
    }

    public function update(Article $article,Request $request)
    {
        $user_id = auth()->guard('api')->user()->id;
        if ($article->author_id == $user_id)
        {
            try
            {
                $article->update([
                    'title' => $request->get('title'),
                    'content' => $request->get('content'),
                ]);
                return response()->json($article->toArray());
            }
            catch (\Exception $exception)
            {
                return response()->json($exception,500);
            }
        }
        else
        {
            return response()->json(['message' => 'You are not the author of this article!'],403);
        }
    }
}
