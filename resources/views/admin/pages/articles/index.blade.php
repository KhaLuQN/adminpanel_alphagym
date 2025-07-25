@extends('admin.layouts.master')
@section('page_title', 'Bảng Điều Khiển')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="link link-hover">Admin</a></li>
    <li><a class="link link-hover">Tất cả bài viết</a></li>

@endsection
@section('content')
    <div class="p-6">


        <div class="card bg-base-200 shadow-xl">
            <div class="card-body">
                <!-- Header Section -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-base-content flex items-center gap-2">
                            <i class="ri-article-line text-primary"></i>
                            Quản Lý Bài Viết & Tin Tức
                        </h1>
                        <p class="text-base-content/70 mt-1">Quản lý và theo dõi tất cả bài viết của bạn</p>
                    </div>
                    <a href="{{ route('admin.articles.create') }}"
                        class="btn btn-primary gap-2 shadow-lg hover:shadow-xl transition-all duration-300">
                        <i class="ri-add-line text-lg"></i>
                        Viết Bài Mới
                    </a>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="stat bg-base-100 shadow-md rounded-lg border border-base-300">
                        <div class="stat-figure text-primary">
                            <i class="ri-file-text-line text-3xl"></i>
                        </div>
                        <div class="stat-title">Tổng Bài Viết</div>
                        <div class="stat-value text-primary">{{ $articles->count() }}</div>
                    </div>
                    <div class="stat bg-base-100 shadow-md rounded-lg border border-base-300">
                        <div class="stat-figure text-success">
                            <i class="ri-checkbox-circle-line text-3xl"></i>
                        </div>
                        <div class="stat-title">Đã Xuất Bản</div>
                        <div class="stat-value text-success">{{ $articles->where('status', 'published')->count() }}</div>
                    </div>
                    <div class="stat bg-base-100 shadow-md rounded-lg border border-base-300">
                        <div class="stat-figure text-warning">
                            <i class="ri-draft-line text-3xl"></i>
                        </div>
                        <div class="stat-title">Bản Nháp</div>
                        <div class="stat-value text-warning">{{ $articles->where('status', 'draft')->count() }}</div>
                    </div>
                    <div class="stat bg-base-100 shadow-md rounded-lg border border-base-300">
                        <div class="stat-figure text-error">
                            <i class="ri-pause-circle-line text-3xl"></i>
                        </div>
                        <div class="stat-title">Đã Ẩn</div>
                        <div class="stat-value text-error">{{ $articles->where('status', 'hidden')->count() }}</div>
                    </div>
                </div>

                <!-- Articles Table -->

                <div class="card bg-base-100 shadow-xl border border-base-300">
                    <div class="card-body p-0">
                        <div class="overflow-x-auto">
                            <table class="table table-zebra w-full datatable">
                                <!-- Head -->
                                <thead class="bg-base-200">
                                    <tr>
                                        <th class="text-center w-16">
                                            <i class="ri-hashtag text-lg"></i>
                                        </th>
                                        <th class="min-w-[200px]">
                                            <i class="ri-title text-lg mr-2"></i>Tiêu Đề
                                        </th>
                                        <th class="hidden md:table-cell">
                                            <i class="ri-user-line text-lg mr-2"></i>Tác Giả
                                        </th>
                                        <th class="hidden lg:table-cell">
                                            <i class="ri-bookmark-line text-lg mr-2"></i>Danh Mục
                                        </th>
                                        <th class="text-center">
                                            <i class="ri-eye-line text-lg mr-2"></i>Trạng Thái
                                        </th>
                                        <th class="hidden xl:table-cell text-center">
                                            <i class="ri-calendar-line text-lg mr-2"></i>Ngày XB
                                        </th>
                                        <th class="text-center w-20">
                                            <i class="ri-image-line text-lg"></i>
                                        </th>
                                        <th class="text-center w-32">
                                            <i class="ri-tools-line text-lg"></i>Hành Động
                                        </th>
                                    </tr>
                                </thead>
                                <!-- Body -->
                                <tbody>
                                    @forelse ($articles as $article)
                                        <tr class="hover:bg-base-200/50 transition-colors duration-200">
                                            <!-- ID -->
                                            <td class="text-center font-mono text-sm">
                                                <div class="badge badge-outline">{{ $article->article_id }}</div>
                                            </td>

                                            <!-- Title & Slug -->
                                            <td>
                                                <div class="flex flex-col">
                                                    <div class="font-semibold text-base-content truncate max-w-xs"
                                                        title="{{ $article->title }}">
                                                        {{ $article->title }}
                                                    </div>
                                                    <div class="text-xs text-base-content/60 font-mono">
                                                        <i class="ri-link text-xs mr-1"></i>{{ $article->slug }}
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Author -->
                                            <td class="hidden md:table-cell">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-sm">{{ $article->user->full_name ?? 'N/A' }}</span>
                                                </div>
                                            </td>

                                            <!-- Category -->
                                            <td class="hidden lg:table-cell">
                                                @if ($article->category)
                                                    <div class="badge badge-outline badge-sm">
                                                        {{ $article->category->name }}
                                                    </div>
                                                @else
                                                    <span class="text-base-content/50 text-sm">Chưa phân loại</span>
                                                @endif
                                            </td>

                                            <!-- Status -->
                                            <td class="text-center">
                                                @php
                                                    $statusConfig = [
                                                        'published' => [
                                                            'badge-success',
                                                            'ri-checkbox-circle-fill',
                                                            'Đã xuất bản',
                                                        ],
                                                        'draft' => ['badge-warning', 'ri-draft-fill', 'Bản nháp'],
                                                        'hidden' => ['badge-error', 'ri-eye-off-fill', 'Đã ẩn'],
                                                    ];
                                                    $config = $statusConfig[$article->status] ?? [
                                                        'badge-ghost',
                                                        'ri-question-fill',
                                                        'Không xác định',
                                                    ];
                                                @endphp
                                                <div class="badge {{ $config[0] }} gap-1 font-medium">
                                                    <i class="{{ $config[1] }} text-xs"></i>
                                                    {{ $config[2] }}
                                                </div>
                                            </td>

                                            <!-- Published Date -->
                                            <td class="hidden xl:table-cell text-center">
                                                @if ($article->published_at)
                                                    <div class="text-sm">
                                                        <div class="font-medium">
                                                            {{ $article->published_at->format('d/m/Y') }}
                                                        </div>
                                                        <div class="text-xs text-base-content/60">
                                                            {{ $article->published_at->format('H:i') }}</div>
                                                    </div>
                                                @else
                                                    <span class="text-base-content/50 text-sm">Chưa xuất bản</span>
                                                @endif
                                            </td>

                                            <!-- Featured Image -->
                                            <td class="text-center">
                                                @if ($article->featured_image_url)
                                                    <div class="avatar">
                                                        <div class="w-12 h-12 rounded-lg">
                                                            <img src="{{ asset($article->featured_image_url) }}"
                                                                alt="{{ $article->title }}" class="object-cover">
                                                        </div>
                                                    </div>
                                                @else
                                                    <div
                                                        class="w-12 h-12 rounded-lg bg-base-300 flex items-center justify-center mx-auto">
                                                        <i class="ri-image-line text-base-content/30"></i>
                                                    </div>
                                                @endif
                                            </td>

                                            <!-- Actions -->
                                            <td>
                                                <div class="flex items-center justify-center gap-1">
                                                    <!-- Edit Button -->
                                                    <div class="tooltip" data-tip="Chỉnh sửa">
                                                        <a href="{{ route('admin.articles.edit', $article->slug) }}"
                                                            class="btn btn-sm btn-square btn-ghost hover:btn-info transition-all duration-200">
                                                            <i class="ri-pencil-line text-lg"></i>
                                                        </a>
                                                    </div>

                                                    <!-- Delete Button -->
                                                    <div class="tooltip" data-tip="Xóa bài viết">
                                                        <form
                                                            action="{{ route('admin.articles.destroy', $article->slug) }}"
                                                            method="POST"
                                                            id="delete-article-form-{{ $article->article_id }}"
                                                            class="inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                class="btn btn-sm btn-square btn-ghost hover:btn-error transition-all duration-200 delete-btn"
                                                                data-form-id="delete-article-form-{{ $article->article_id }}">
                                                                <i class="ri-delete-bin-line text-lg"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-12">
                                                <div class="flex flex-col items-center gap-4">
                                                    <i class="ri-article-line text-6xl text-base-content/20"></i>
                                                    <div>
                                                        <p class="text-lg font-medium text-base-content/70">Chưa có bài
                                                            viết
                                                            nào
                                                        </p>
                                                        <p class="text-sm text-base-content/50">Hãy tạo bài viết đầu tiên
                                                            của
                                                            bạn
                                                        </p>
                                                    </div>
                                                    <a href="{{ route('admin.articles.create') }}"
                                                        class="btn btn-primary gap-2">
                                                        <i class="ri-add-line"></i>
                                                        Viết Bài Mới
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
