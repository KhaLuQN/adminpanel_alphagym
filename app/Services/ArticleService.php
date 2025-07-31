<?php
namespace App\Services;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ArticleService
{
    public function getArticlesForIndex()
    {
        return Article::with([
            'user:id,full_name',
            'category:category_id,name',
        ])
            ->select('article_id', 'title', 'slug', 'status', 'featured_image_url', 'published_at', 'user_id', 'article_category_id')
            ->latest('article_id')
            ->get();
    }

    public function getDataForCreateEdit()
    {
        $categories = ArticleCategory::pluck('name', 'category_id');
        $users      = User::pluck('username', 'id');

        return compact('categories', 'users');
    }

    /**
     * Tạo một bài viết mới
     *
     * @param array
     * @return Article
     */
    public function createArticle(array $data): Article
    {
        if (isset($data['featured_image'])) {
            $filename = time() . '_' . $data['featured_image']->getClientOriginalName();

            $path = $data['featured_image']->storeAs('articles', $filename, 'public');

            $data['featured_image_url'] = $path;

            unset($data['featured_image']);
        }

        return Article::create($data);
    }

    /**
     * Cập nhật một bài viết
     *
     * @param Article
     * @param array
     * @return Article
     */
    public function updateArticle(Article $article, array $data): Article
    {
        if (isset($data['featured_image'])) {

            if ($article->featured_image_url) {
                Storage::disk('public')->delete($article->featured_image_url);
            }

            $filename = time() . '_' . $data['featured_image']->getClientOriginalName();
            $path     = $data['featured_image']->storeAs('articles', $filename, 'public');

            $data['featured_image_url'] = $path;
            unset($data['featured_image']);
        }

        $article->update($data);
        return $article;
    }

    /**
     * Xóa một bài viết
     *
     * @param Article
     * @return void
     */
    public function deleteArticle(Article $article): void
    {
        if ($article->featured_image_url) {
            Storage::disk('public')->delete($article->featured_image_url);
        }

        $article->delete();
    }

    public function getApiArticles()
    {
        return Article::with('category')
            ->where('status', 'published')
            ->where('published_at', '<', now())
            ->latest('published_at')
            ->get();
    }

    public function getPublishedArticle(Article $article): Article
    {
        if ($article->status !== 'published' || $article->published_at > now()) {
            abort(404);
        }
        return $article;
    }

    public function getHomeArticles()
    {
        return Article::with('category')
            ->where('status', 'published')
            ->where('published_at', '<', now())
            ->latest('published_at')
            ->get();
    }

    public function getRelatedArticles(string $slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        return Article::where('article_id', '!=', $article->article_id)
            ->where('article_category_id', $article->article_category_id)
            ->latest()
            ->take(3)
            ->get();
    }
}
