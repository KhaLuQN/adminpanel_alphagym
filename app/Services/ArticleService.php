<?php
namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Storage;

class ArticleService
{
    public function createArticle(array $data): Article
    {
        if (isset($data['featured_image'])) {
            $data['featured_image_url'] = $data['featured_image']->store('articles', 'public');
        }
        return Article::create($data);
    }

    public function updateArticle(Article $article, array $data): bool
    {
        if (isset($data['featured_image'])) {

            if ($article->featured_image_url) {
                Storage::disk('public')->delete($article->featured_image_url);
            }
            $data['featured_image_url'] = $data['featured_image']->store('articles', 'public');
        }
        return $article->update($data);
    }

    public function deleteArticle(Article $article): bool
    {
        if ($article->featured_image_url) {
            Storage::disk('public')->delete($article->featured_image_url);
        }
        return $article->delete();
    }
}
