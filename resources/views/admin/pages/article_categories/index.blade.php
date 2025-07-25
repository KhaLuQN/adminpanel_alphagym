@extends('admin.layouts.master')
@section('page_title', 'Bảng Điều Khiển')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="link link-hover">Admin</a></li>
    <li><a href="#" class="link link-hover">Danh mục bài viết</a></li>

@endsection
@section('content')
    <div class="min-h-screen bg-base-200 p-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="bg-base-100 rounded-lg shadow-lg p-6 mb-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-center gap-3">
                        <div class="bg-primary/10 p-3 rounded-lg">
                            <i class="ri-article-line text-2xl text-primary"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-base-content">Quản Lý Danh Mục Bài Viết</h1>
                            <p class="text-base-content/70 text-sm">Quản lý các danh mục bài viết của website</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.article-categories.create') }}" class="btn btn-primary gap-2">
                        <i class="ri-add-line"></i>
                        Thêm Danh Mục Mới
                    </a>
                </div>
            </div>

            <!-- Table Section -->
            <div class="bg-base-100 rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full datatable">
                        <thead class="bg-base-200">
                            <tr>
                                <th class="text-base-content font-semibold">
                                    <div class="flex items-center gap-2">
                                        <i class="ri-hashtag"></i>
                                        ID
                                    </div>
                                </th>
                                <th class="text-base-content font-semibold">
                                    <div class="flex items-center gap-2">
                                        <i class="ri-text-wrap"></i>
                                        Tên Danh Mục
                                    </div>
                                </th>
                                <th class="text-base-content font-semibold">
                                    <div class="flex items-center gap-2">
                                        <i class="ri-link"></i>
                                        Slug
                                    </div>
                                </th>
                                <th class="text-base-content font-semibold">
                                    <div class="flex items-center gap-2">
                                        <i class="ri-file-text-line"></i>
                                        Mô Tả
                                    </div>
                                </th>
                                <th class="text-base-content font-semibold">
                                    <div class="flex items-center gap-2">
                                        <i class="ri-image-line"></i>
                                        Ảnh Bìa
                                    </div>
                                </th>
                                <th class="text-base-content font-semibold">
                                    <div class="flex items-center gap-2">
                                        <i class="ri-node-tree"></i>
                                        Danh Mục Cha
                                    </div>
                                </th>
                                <th class="text-base-content font-semibold">
                                    <div class="flex items-center gap-2">
                                        <i class="ri-settings-line"></i>
                                        Hành Động
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr class="hover:bg-base-200/50 transition-colors">
                                    <td class="font-mono text-sm">
                                        <div class="badge badge-outline">{{ $category->category_id }}</div>
                                    </td>
                                    <td>
                                        <div class="font-semibold text-base-content">{{ $category->name }}</div>
                                    </td>
                                    <td>
                                        <div class="font-mono text-sm bg-base-200 px-2 py-1 rounded inline-block">
                                            {{ $category->slug }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="max-w-xs">
                                            @if ($category->description)
                                                <p class="text-sm text-base-content/70 truncate"
                                                    title="{{ $category->description }}">
                                                    {{ $category->description }}
                                                </p>
                                            @else
                                                <span class="text-base-content/40 italic">Không có mô tả</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if ($category->cover_image_url)
                                            <div class="avatar">
                                                <div
                                                    class="w-16 h-16 rounded-lg ring ring-primary ring-offset-base-100 ring-offset-2">
                                                    <img src="{{ asset('storage/' . $category->cover_image_url) }}"
                                                        alt="{{ $category->name }}" class="object-cover">
                                                </div>
                                            </div>
                                        @else
                                            <div class="w-16 h-16 bg-base-200 rounded-lg flex items-center justify-center">
                                                <i class="ri-image-line text-base-content/40 text-xl"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($category->parent)
                                            <div class="badge badge-secondary badge-outline gap-1">
                                                <i class="ri-folder-line text-xs"></i>
                                                {{ $category->parent->name }}
                                            </div>
                                        @else
                                            <div class="badge badge-ghost gap-1">
                                                <i class="ri-folder-open-line text-xs"></i>
                                                Danh mục gốc
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.article-categories.edit', $category->category_id) }}"
                                                class="btn btn-sm btn-warning gap-1 hover:btn-warning-focus">
                                                <i class="ri-edit-line"></i>
                                                Sửa
                                            </a>
                                            <form
                                                action="{{ route('admin.article-categories.destroy', $category->category_id) }}"
                                                method="POST" class="inline-block"
                                                id="delete-article-categories-form-{{ $category->category_id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    data-form-id="delete-article-categories-form-{{ $category->category_id }}"
                                                    class="btn btn-sm btn-error gap-1 hover:btn-error-focus delete-btn">
                                                    <i class="ri-delete-bin-line"></i>
                                                    Xóa
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Empty State -->
                @if ($categories->isEmpty())
                    <div class="text-center py-16">
                        <div class="bg-base-200 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="ri-article-line text-3xl text-base-content/40"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-base-content mb-2">Chưa có danh mục nào</h3>
                        <p class="text-base-content/70 mb-4">Hãy tạo danh mục đầu tiên để bắt đầu quản lý bài viết</p>
                        <a href="{{ route('admin.article-categories.create') }}" class="btn btn-primary gap-2">
                            <i class="ri-add-line"></i>
                            Thêm Danh Mục Đầu Tiên
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
