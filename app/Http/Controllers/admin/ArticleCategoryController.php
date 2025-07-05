<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ArticleCategoryController extends Controller
{

    public function index()
    {

        $categories = ArticleCategory::withCount('articles')
            ->latest()
            ->get();

        return view('admin.pages.article_categories.index', compact('categories'));
    }

    public function create()
    {

        $parentCategories = ArticleCategory::get(['category_id', 'name']);
        return view('admin.pages.article_categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {

        if (! $request->filled('slug')) {
            $request->merge(['slug' => Str::slug($request->name)]);
        }

        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|unique:article_categories,slug|max:255',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:article_categories,category_id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $imagePath                        = $request->file('cover_image')->store('categories', 'public');
            $validatedData['cover_image_url'] = $imagePath;
        }

        ArticleCategory::create($validatedData);

        return redirect()->route('admin.article-categories.index')->with('success', 'Danh mục đã được tạo thành công!');
    }

    public function edit(ArticleCategory $articleCategory)
    {

        $parentCategories = ArticleCategory::where('category_id', '!=', $articleCategory->category_id)->get(['category_id', 'name']);
        return view('admin.pages.article_categories.edit', compact('articleCategory', 'parentCategories'));
    }

    public function update(Request $request, ArticleCategory $articleCategory)
    {

        if ($request->filled('name') && ! $request->filled('slug')) {
            $request->merge(['slug' => Str::slug($request->name)]);
        }

        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',

            'slug'        => ['required', 'string', 'max:255', Rule::unique('article_categories')->ignore($articleCategory->category_id, 'category_id')],
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:article_categories,category_id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {

            if ($articleCategory->cover_image_url) {
                Storage::disk('public')->delete($articleCategory->cover_image_url);
            }
            $imagePath                        = $request->file('cover_image')->store('categories', 'public');
            $validatedData['cover_image_url'] = $imagePath;
        }

        $articleCategory->update($validatedData);

        return redirect()->route('admin.article-categories.index')->with('success', 'Danh mục đã được cập nhật thành công!');
    }

    public function destroy(ArticleCategory $articleCategory)
    {

        if ($articleCategory->cover_image_url) {
            Storage::disk('public')->delete($articleCategory->cover_image_url);
        }

        $articleCategory->delete();

        return redirect()->route('admin.article-categories.index')->with('success', 'Danh mục đã được xóa thành công!');
    }
}
