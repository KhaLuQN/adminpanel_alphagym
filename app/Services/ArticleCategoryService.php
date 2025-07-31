<?php

namespace App\Services;

use App\Models\ArticleCategory;
use Illuminate\Support\Facades\Storage;

class ArticleCategoryService
{
    public function getAllCategoriesWithArticleCount()
    {
        return ArticleCategory::withCount('articles')->latest()->get();
    }

    public function getParentCategories(int $exceptCategoryId = null)
    {
        $query = ArticleCategory::query();

        if ($exceptCategoryId) {
            $query->where('category_id', '!=', $exceptCategoryId);
        }

        return $query->get(['category_id', 'name']);
    }

    public function createArticleCategory(array $data): void
    {
        if (isset($data['cover_image'])) {
            $imagePath = $data['cover_image']->store('categories', 'public');
            $data['cover_image_url'] = $imagePath;
        }

        ArticleCategory::create($data);
    }

    public function updateArticleCategory(ArticleCategory $articleCategory, array $data): void
    {
        if (isset($data['cover_image'])) {
            if ($articleCategory->cover_image_url) {
                Storage::disk('public')->delete($articleCategory->cover_image_url);
            }
            $imagePath = $data['cover_image']->store('categories', 'public');
            $data['cover_image_url'] = $imagePath;
        }

        $articleCategory->update($data);
    }

    public function deleteArticleCategory(ArticleCategory $articleCategory): void
    {
        if ($articleCategory->cover_image_url) {
            Storage::disk('public')->delete($articleCategory->cover_image_url);
        }

        $articleCategory->delete();
    }

    public function getApiCategories()
    {
        return ArticleCategory::withCount(['articles' => function ($query) {
            $query->where('status', 'published');
        }])->take(4)->get();
    }
}
