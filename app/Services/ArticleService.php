<?php
namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Storage;

class ArticleService
{
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

            $data['featured_image_url'] = 'storage/' . $path;

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
                $pathToDelete = str_replace('storage/', '', $article->featured_image_url);
                Storage::disk('public')->delete($pathToDelete);
            }

            $filename = time() . '_' . $data['featured_image']->getClientOriginalName();
            $path     = $data['featured_image']->storeAs('articles', $filename, 'public');

            $data['featured_image_url'] = 'storage/' . $path;
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
}
