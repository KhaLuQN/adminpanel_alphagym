<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleCategory\StoreArticleCategoryRequest;
use App\Http\Requests\ArticleCategory\UpdateArticleCategoryRequest;
use App\Models\ArticleCategory;
use App\Services\ArticleCategoryService;

class ArticleCategoryController extends Controller
{
    protected $articleCategoryService;

    public function __construct(ArticleCategoryService $articleCategoryService)
    {
        $this->articleCategoryService = $articleCategoryService;
    }

    public function index()
    {
        $categories = $this->articleCategoryService->getAllCategoriesWithArticleCount();
        return view('admin.pages.article_categories.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories = $this->articleCategoryService->getParentCategories();
        return view('admin.pages.article_categories.create', compact('parentCategories'));
    }

    public function store(StoreArticleCategoryRequest $request)
    {
        $this->articleCategoryService->createArticleCategory($request->validated());
        return redirect()->route('admin.article-categories.index')->with('success', 'Danh mục đã được tạo thành công!');
    }

    public function edit(ArticleCategory $articleCategory)
    {
        $parentCategories = $this->articleCategoryService->getParentCategories($articleCategory->category_id);
        return view('admin.pages.article_categories.edit', compact('articleCategory', 'parentCategories'));
    }

    public function update(UpdateArticleCategoryRequest $request, ArticleCategory $articleCategory)
    {
        $this->articleCategoryService->updateArticleCategory($articleCategory, $request->validated());
        return redirect()->route('admin.article-categories.index')->with('success', 'Danh mục đã được cập nhật thành công!');
    }

    public function destroy(ArticleCategory $articleCategory)
    {
        $this->articleCategoryService->deleteArticleCategory($articleCategory);
        return redirect()->route('admin.article-categories.index')->with('success', 'Danh mục đã được xóa thành công!');
    }
}
