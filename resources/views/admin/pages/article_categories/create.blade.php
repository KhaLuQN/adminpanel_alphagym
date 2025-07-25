@extends('admin.layouts.master')
@section('page_title', 'Bảng Điều Khiển')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="link link-hover">Admin</a></li>
    <li><a href="#" class="link link-hover">Tạo danh mục bài viết</a></li>

@endsection
@section('content')
    <div class="min-h-screen bg-base-200 p-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="bg-base-100 rounded-lg shadow-lg p-6 mb-6">
                <div class="flex items-center gap-4">
                    <div class="bg-primary/10 p-3 rounded-lg">
                        <i class="ri-add-circle-line text-2xl text-primary"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-base-content">Thêm Danh Mục Bài Viết Mới</h1>
                        <p class="text-base-content/70 text-sm">Tạo danh mục mới để phân loại bài viết</p>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="bg-base-100 rounded-lg shadow-lg p-6">
                <form action="{{ route('admin.article-categories.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    <!-- Tên Danh Mục -->
                    <div class="form-control">
                        <label class="label" for="name">
                            <span class="label-text font-semibold flex items-center gap-2">
                                <i class="ri-text text-primary"></i>
                                Tên Danh Mục
                                <span class="badge badge-error badge-xs">*</span>
                            </span>
                        </label>
                        <input type="text" name="name" id="name"
                            class="input input-bordered w-full focus:input-primary @error('name') input-error @enderror"
                            value="{{ old('name') }}" placeholder="Nhập tên danh mục...">
                        @error('name')
                            <label class="label">
                                <span class="label-text-alt text-error flex items-center gap-1">
                                    <i class="ri-error-warning-line"></i>
                                    {{ $message }}
                                </span>
                            </label>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div class="form-control">
                        <label class="label" for="slug">
                            <span class="label-text font-semibold flex items-center gap-2">
                                <i class="ri-link text-primary"></i>
                                Slug
                                <span class="badge badge-error badge-xs">*</span>
                            </span>
                        </label>
                        <input type="text" name="slug" id="slug"
                            class="input input-bordered w-full font-mono focus:input-primary @error('slug') input-error @enderror"
                            value="{{ old('slug') }}" placeholder="duong-dan-url-thang-thien...">
                        <label class="label">
                            <span class="label-text-alt text-base-content/60 flex items-center gap-1">
                                <i class="ri-information-line"></i>
                                Đường dẫn URL thân thiện (tự động tạo từ tên danh mục)
                            </span>
                        </label>
                        @error('slug')
                            <label class="label">
                                <span class="label-text-alt text-error flex items-center gap-1">
                                    <i class="ri-error-warning-line"></i>
                                    {{ $message }}
                                </span>
                            </label>
                        @enderror
                    </div>

                    <!-- Mô Tả -->
                    <div class="form-control">
                        <label class="label" for="description">
                            <span class="label-text font-semibold flex items-center gap-2">
                                <i class="ri-file-text-line text-primary"></i>
                                Mô Tả
                            </span>
                        </label>
                        <textarea name="description" id="description"
                            class="textarea textarea-bordered w-full h-24 focus:textarea-primary @error('description') textarea-error @enderror"
                            placeholder="Mô tả ngắn gọn về danh mục này...">{{ old('description') }}</textarea>
                        @error('description')
                            <label class="label">
                                <span class="label-text-alt text-error flex items-center gap-1">
                                    <i class="ri-error-warning-line"></i>
                                    {{ $message }}
                                </span>
                            </label>
                        @enderror
                    </div>

                    <!-- Danh Mục Cha -->
                    <div class="form-control">
                        <label class="label" for="parent_id">
                            <span class="label-text font-semibold flex items-center gap-2">
                                <i class="ri-node-tree text-primary"></i>
                                Danh Mục Cha
                            </span>
                        </label>
                        <select name="parent_id" id="parent_id"
                            class="select select-bordered w-full focus:select-primary @error('parent_id') select-error @enderror">
                            <option value="">
                                <span class="flex items-center gap-2">
                                    <i class="ri-folder-open-line"></i>
                                    -- Không có (Danh mục gốc) --
                                </span>
                            </option>
                            @foreach ($parentCategories as $category)
                                <option value="{{ $category->category_id }}"
                                    {{ old('parent_id') == $category->category_id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <label class="label">
                            <span class="label-text-alt text-base-content/60 flex items-center gap-1">
                                <i class="ri-information-line"></i>
                                Chọn danh mục cha để tạo cấu trúc phân cấp
                            </span>
                        </label>
                        @error('parent_id')
                            <label class="label">
                                <span class="label-text-alt text-error flex items-center gap-1">
                                    <i class="ri-error-warning-line"></i>
                                    {{ $message }}
                                </span>
                            </label>
                        @enderror
                    </div>

                    <!-- Ảnh Bìa -->
                    <div class="form-control">
                        <label class="label" for="cover_image">
                            <span class="label-text font-semibold flex items-center gap-2">
                                <i class="ri-image-line text-primary"></i>
                                Ảnh Bìa
                            </span>
                        </label>
                        <input type="file" name="cover_image" id="cover_image"
                            class="file-input file-input-bordered w-full focus:file-input-primary @error('cover_image') file-input-error @enderror"
                            accept="image/*">
                        <label class="label">
                            <span class="label-text-alt text-base-content/60 flex items-center gap-1">
                                <i class="ri-information-line"></i>
                                Chọn ảnh JPG, PNG hoặc GIF (tối đa 2MB)
                            </span>
                        </label>
                        @error('cover_image')
                            <label class="label">
                                <span class="label-text-alt text-error flex items-center gap-1">
                                    <i class="ri-error-warning-line"></i>
                                    {{ $message }}
                                </span>
                            </label>
                        @enderror
                    </div>

                    <!-- Preview Section -->
                    <div id="imagePreview" class="hidden">
                        <div class="divider">
                            <span class="text-base-content/60">Xem trước ảnh</span>
                        </div>
                        <div class="flex justify-center">
                            <div class="avatar">
                                <div class="w-32 h-32 rounded-lg ring ring-primary ring-offset-base-100 ring-offset-2">
                                    <img id="previewImg" src="" alt="Preview" class="object-cover">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="divider"></div>
                    <div class="flex flex-col sm:flex-row gap-3 justify-end">
                        <a href="{{ route('admin.article-categories.index') }}"
                            class="btn btn-ghost gap-2 order-2 sm:order-1">
                            <i class="ri-arrow-left-line"></i>
                            Hủy
                        </a>
                        <button type="submit" class="btn btn-primary gap-2 order-1 sm:order-2">
                            <i class="ri-save-line"></i>
                            Thêm Danh Mục
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('customjs')
    <!-- JavaScript for enhanced functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            const fileInput = document.getElementById('cover_image');
            const imagePreview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');

            // Auto-generate slug from name
            nameInput.addEventListener('input', function() {
                const name = this.value;
                const slug = name
                    .toLowerCase()
                    .replace(/[àáạảãâầấậẩẫăằắặẳẵ]/g, 'a')
                    .replace(/[èéẹẻẽêềếệểễ]/g, 'e')
                    .replace(/[ìíịỉĩ]/g, 'i')
                    .replace(/[òóọỏõôồốộổỗơờớợởỡ]/g, 'o')
                    .replace(/[ùúụủũưừứựửữ]/g, 'u')
                    .replace(/[ỳýỵỷỹ]/g, 'y')
                    .replace(/đ/g, 'd')
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-+|-+$/g, '');

                if (slugInput.value === '' || slugInput.dataset.autoGenerated === 'true') {
                    slugInput.value = slug;
                    slugInput.dataset.autoGenerated = 'true';
                }
            });

            // Manual slug editing
            slugInput.addEventListener('input', function() {
                this.dataset.autoGenerated = 'false';
            });

            // Image preview
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.classList.add('hidden');
                }
            });
        });
    </script>
@endpush
