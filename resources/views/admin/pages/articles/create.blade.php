@extends('admin.layouts.master')
@section('page_title', 'Bảng Điều Khiển')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="link link-hover">Admin</a></li>
    <li><a href="#" class="link link-hover">Thêm bài viết</a></li>

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
                        <i class="ri-quill-pen-line text-primary"></i>
                        Viết Bài Mới
                    </h1>
                    <p class="text-base-content/70 mt-1">Tạo và xuất bản bài viết mới</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" id="preview-btn" class="btn btn-outline btn-info gap-2">
                    <i class="ri-eye-line"></i>
                    Xem Trước
                </button>
            </div>
        </div>

        <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" id="article-form">
            @csrf
            @include('admin.pages.articles._form')
        </form>
    </div>

    <!-- Preview Modal -->
    <div id="preview-modal" class="modal">
        <div class="modal-box w-11/12 max-w-5xl">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg">Xem Trước Bài Viết</h3>
                <button class="btn btn-sm btn-circle btn-ghost" onclick="closePreviewModal()">✕</button>
            </div>
            <div id="preview-content" class="prose max-w-none">
                <!-- Preview content will be loaded here -->
            </div>
        </div>
    </div>
@endsection

@push('customjs')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Preview functionality
            document.getElementById('preview-btn').addEventListener('click', function() {
                const title = document.getElementById('title').value;
                // Assuming you have a global `editor` variable for CKEditor instance
                const content = editor ? editor.getData() : '';

                const previewContent = `
            <h1 class="text-3xl font-bold mb-4">${title}</h1>
            <div class="article-content">${content}</div>
        `;

                document.getElementById('preview-content').innerHTML = previewContent;
                document.getElementById('preview-modal').classList.add('modal-open');
            });

            window.closePreviewModal = function() {
                document.getElementById('preview-modal').classList.remove('modal-open');
            }
        });
    </script>
@endpush
