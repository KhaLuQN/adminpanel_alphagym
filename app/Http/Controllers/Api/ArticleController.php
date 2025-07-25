<?php

// app/Http/Controllers/Api/ArticleController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleSliceResource;
use App\Models\Article;

class ArticleController extends Controller
{

    public function index()
    {
        $articles = Article::with('category')
            ->where('status', 'published')
            ->where('published_at', '<', now())
            ->latest('published_at')
            ->get();

        return ArticleResource::collection($articles);
    }

    public function show(Article $article)
    {
        if ($article->status !== 'published' || $article->published_at > now()) {
            abort(404);
        }
        return new ArticleResource($article);
    }
    public function getHomeArticles()
    {
        $articles = Article::with('category')
            ->where('status', 'published')
            ->where('published_at', '<', now())
            ->latest('published_at')
            ->get();

        return ArticleSliceResource::collection($articles);

    }
    public function getRelatedArticles($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        $related = Article::where('article_id', '!=', $article->article_id)
            ->where('article_category_id', $article->article_category_id)
            ->latest()
            ->take(3)
            ->get();

        return ArticleSliceResource::collection($related);

    }

}
