<?php

use App\Http\Controllers\Api\ArticleCategoryController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\MembershipPlanController;
use App\Http\Controllers\Api\SubscriptionInitiateController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\TrainerController;
use Illuminate\Support\Facades\Route;

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/home', [ArticleController::class, 'getHomeArticles']);
Route::get('/articles/{article:slug}/related', [ArticleController::class, 'getRelatedArticles'])->name('articles.related');

Route::get('/articles/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');

Route::get('/membership-plans', [MembershipPlanController::class, 'index']);
Route::get('/membership-plans/{membershipPlan}', [MembershipPlanController::class, 'show']);

Route::get('/testimonials', [TestimonialController::class, 'index']);
Route::post('/testimonials', [TestimonialController::class, 'store']);

Route::get('/trainers', [TrainerController::class, 'index']);

Route::get('/article-categories', [ArticleCategoryController::class, 'index']);

Route::post('/subscription/initiate', [SubscriptionInitiateController::class, 'initiate']);
