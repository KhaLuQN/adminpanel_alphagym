@extends('admin.layouts.master')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Chi Tiết Bài Viết: {{ $article->title }}</h1>

        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <p class="text-gray-700 text-sm font-bold">ID:</p>
                <p class="text-gray-900">{{ $article->article_id }}</p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700 text-sm font-bold">Tiêu Đề:</p>
                <p class="text-gray-900">{{ $article->title }}</p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700 text-sm font-bold">Slug:</p>
                <p class="text-gray-900">{{ $article->slug }}</p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700 text-sm font-bold">Nội Dung:</p>
                <div class="prose">{!! $article->content !!}</div>
            </div>
            <div class="mb-4">
                <p class="text-gray-700 text-sm font-bold">Tóm Tắt:</p>
                <p class="text-gray-900">{{ $article->excerpt }}</p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700 text-sm font-bold">Ảnh Đại Diện:</p>
                @if ($article->featured_image_url)
                    <img src="{{ asset('storage/' . $article->featured_image_url) }}" alt="{{ $article->title }}"
                        class="w-64 h-auto object-cover rounded">
                @else
                    <p>Không có ảnh đại diện</p>
                @endif
            </div>
            <div class="mb-4">
                <p class="text-gray-700 text-sm font-bold">Tác Giả:</p>
                <p class="text-gray-900">{{ $article->user->full_name ?? 'N/A' }}</p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700 text-sm font-bold">Danh Mục:</p>
                <p class="text-gray-900">{{ $article->category->name ?? 'N/A' }}</p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700 text-sm font-bold">Loại Bài Viết:</p>
                <p class="text-gray-900">{{ $article->type }}</p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700 text-sm font-bold">Trạng Thái:</p>
                <p class="text-gray-900">{{ $article->status }}</p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700 text-sm font-bold">Ngày Xuất Bản:</p>
                <p class="text-gray-900">{{ $article->published_at ? $article->published_at->format('d/m/Y H:i') : 'N/A' }}
                </p>
            </div>
            @if ($article->type === 'event')
                <div class="mb-4">
                    <p class="text-gray-700 text-sm font-bold">Thời Gian Bắt Đầu Sự Kiện:</p>
                    <p class="text-gray-900">
                        {{ $article->event_start_time ? $article->event_start_time->format('d/m/Y H:i') : 'N/A' }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-gray-700 text-sm font-bold">Thời Gian Kết Thúc Sự Kiện:</p>
                    <p class="text-gray-900">
                        {{ $article->event_end_time ? $article->event_end_time->format('d/m/Y H:i') : 'N/A' }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-gray-700 text-sm font-bold">Địa Điểm Sự Kiện:</p>
                    <p class="text-gray-900">{{ $article->event_location ?? 'N/A' }}</p>
                </div>
            @endif
            <div class="mb-4">
                <p class="text-gray-700 text-sm font-bold">Meta Keywords:</p>
                <p class="text-gray-900">{{ $article->meta_keywords ?? 'N/A' }}</p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700 text-sm font-bold">Meta Description:</p>
                <p class="text-gray-900">{{ $article->meta_description ?? 'N/A' }}</p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700 text-sm font-bold">Lượt Xem:</p>
                <p class="text-gray-900">{{ $article->view_count }}</p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700 text-sm font-bold">Ngày Tạo:</p>
                <p class="text-gray-900">{{ $article->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700 text-sm font-bold">Ngày Cập Nhật:</p>
                <p class="text-gray-900">{{ $article->updated_at->format('d/m/Y H:i') }}</p>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('admin.articles.edit', $article->article_id) }}" class="btn btn-warning">Sửa Bài Viết</a>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-ghost">Quay Lại</a>
            </div>
        </div>
    </div>
@endsection
