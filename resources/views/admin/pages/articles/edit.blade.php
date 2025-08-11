@extends('admin.layouts.master')
@section('page_title', 'Chỉnh Sửa Bài Viết')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="link link-hover">Admin</a></li>
    <li><a href="{{ route('admin.articles.index') }}" class="link link-hover">Bài viết</a></li>
    <li><a href="#" class="link link-hover">Chỉnh sửa</a></li>
@endsection

@section('content')
    <div class="container mx-auto p-6 max-w-6xl">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.articles.index') }}" class="btn btn-ghost btn-sm">
                    <i class="ri-arrow-left-line text-lg"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-base-content flex items-center gap-2">
                        <i class="ri-edit-box-line text-primary"></i>
                        Chỉnh Sửa Bài Viết
                    </h1>
                    <p class="text-base-content/70 mt-1">Cập nhật thông tin cho bài viết: {{ $article->title }}</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.articles.update', $article->slug) }}" method="POST" enctype="multipart/form-data" id="article-form">
            @csrf
            @method('PUT')
            
            @include('admin.pages.articles._form', ['article' => $article])

            <!-- Action Buttons -->
            <div class="flex items-center justify-between mt-8 p-4 bg-base-100 rounded-lg shadow-lg border border-base-300">
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-ghost gap-2">
                        <i class="ri-arrow-left-line"></i>
                        Quay Lại
                    </a>
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit" name="action" value="draft" class="btn btn-outline btn-warning gap-2">
                        <i class="ri-save-line"></i>
                        Lưu Nháp
                    </button>
                    <button type="submit" name="action" value="publish" class="btn btn-primary gap-2">
                        <i class="ri-send-plane-line"></i>
                        Cập Nhật
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection