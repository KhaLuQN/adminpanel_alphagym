<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Models\Article;
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
        $articles = $this->articleService->getArticlesForIndex();
        return view('admin.pages.articles.index', compact('articles'));
    }

    public function create()
    {
        $data = $this->articleService->getDataForCreateEdit();
        return view('admin.pages.articles.create', $data);
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
        $data = $this->articleService->getDataForCreateEdit();
        return view('admin.pages.articles.edit', array_merge(compact('article'), $data));
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
