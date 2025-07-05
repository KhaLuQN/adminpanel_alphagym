<?php

// app/Http/Controllers/Api/ArticleController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;

class ArticleController extends Controller
{

    public function index()
    {
        $articles = Article::where('status', 'published')
            ->where('published_at', '<', now())
            ->latest('published_at')
            ->paginate(10);

        return ArticleResource::collection($articles);
    }

    public function show(Article $article)
    {
        if ($article->status !== 'published' || $article->published_at > now()) {
            abort(404);
        }
        return new ArticleResource($article);
    }
}
