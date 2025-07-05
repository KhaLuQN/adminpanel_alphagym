<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleCategoryResource;
use App\Models\ArticleCategory;

// Đảm bảo bạn đã có Model này

class ArticleCategoryController extends Controller
{

    public function index()
    {

        $categories = ArticleCategory::withCount(['articles' => function ($query) {
            $query->where('status', 'published');
        }])->take(4)->get();

        return ArticleCategoryResource::collection($categories);
    }
}
