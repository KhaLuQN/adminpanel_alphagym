<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\User;
use App\Services\ArticleService;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index()
    {
        $articles = Article::with([
            'user:id,full_name',
            'category:category_id,name',
        ])
            ->select('article_id', 'title', 'slug', 'status', 'featured_image_url', 'published_at', 'user_id', 'article_category_id')
            ->latest('article_id')
            ->get();

        return view('admin.pages.articles.index', compact('articles'));
    }

    public function create()
    {

        $categories = ArticleCategory::pluck('name', 'category_id');
        $users      = User::pluck('username', 'id');

        return view('admin.pages.articles.create', compact('categories', 'users'));
    }

    public function store(StoreArticleRequest $request)
    {

        $this->articleService->createArticle($request->validated());
        return redirect()->route('admin.articles.index')->with('success', 'Bài viết đã được tạo thành công!');
    }

    public function show(Article $article)
    {

        $article->load('user', 'category');
        return view('admin.pages.articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $categories = ArticleCategory::pluck('name', 'category_id');
        $users      = User::pluck('username', 'id');

        return view('admin.pages.articles.edit', compact('article', 'categories', 'users'));
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
        $this->articleService->updateArticle($article, $request->validated());
        return redirect()->route('admin.articles.index')->with('success', 'Bài viết đã được cập nhật thành công!');
    }

    public function destroy(Article $article)
    {
        $this->articleService->deleteArticle($article);
        return redirect()->route('admin.articles.index')->with('success', 'Bài viết đã được xóa thành công!');
    }
}
