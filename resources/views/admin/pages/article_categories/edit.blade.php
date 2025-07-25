@extends('admin.layouts.master')
@section('page_title', 'Bảng Điều Khiển')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="link link-hover">Admin</a></li>
    <li><a href="#" class="link link-hover">Sửa danh mục bài viết</a></li>

@endsection
@section('content')
    <div class="min-h-screen bg-base-200 p-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="bg-base-100 rounded-lg shadow-lg p-6 mb-6">
                <div class="flex items-center gap-4">
                    <div class="bg-warning/10 p-3 rounded-lg">
                        <i class="ri-edit-circle-line text-2xl text-warning"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-base-content">Chỉnh Sửa Danh Mục Bài Viết</h1>
                        <p class="text-base-content/70 text-sm">Cập nhật thông tin danh mục "{{ $articleCategory->name }}"
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="bg-base-100 rounded-lg shadow-lg p-6">
                <form action="{{ route('admin.article-categories.update', $articleCategory->category_id) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

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
                            value="{{ old('name', $articleCategory->name) }}" placeholder="Nhập tên danh mục..." required>
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
                            value="{{ old('slug', $articleCategory->slug) }}" placeholder="duong-dan-url-thang-thien..."
                            required>
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
                            placeholder="Mô tả ngắn gọn về danh mục này...">{{ old('description', $articleCategory->description) }}</textarea>
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
                                    {{ old('parent_id', $articleCategory->parent_id) == $category->category_id ? 'selected' : '' }}>
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

                        <!-- Current Image Display -->
                        <div class="mb-4">
                            <div class="flex items-center gap-4">
                                <div class="text-sm text-base-content/70 font-medium">Ảnh hiện tại:</div>
                                <div id="currentImageContainer">
                                    @if ($articleCategory->cover_image_url)
                                        <div class="avatar">
                                            <div
                                                class="w-20 h-20 rounded-lg ring ring-primary ring-offset-base-100 ring-offset-2">
                                                <img src="{{ asset('storage/' . $articleCategory->cover_image_url) }}"
                                                    alt="{{ $articleCategory->name }}" class="object-cover">
                                            </div>
                                        </div>
                                    @else
                                        <div class="w-20 h-20 bg-base-200 rounded-lg flex items-center justify-center">
                                            <i class="ri-image-line text-base-content/40 text-2xl"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- File Input -->
                        <input type="file" name="cover_image" id="cover_image"
                            class="file-input file-input-bordered w-full focus:file-input-primary @error('cover_image') file-input-error @enderror"
                            accept="image/*">
                        <label class="label">
                            <span class="label-text-alt text-base-content/60 flex items-center gap-1">
                                <i class="ri-information-line"></i>
                                Chọn ảnh mới để thay thế (JPG, PNG hoặc GIF - tối đa 2MB)
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

                    <!-- New Image Preview -->
                    <div id="newImagePreview" class="hidden">
                        <div class="divider">
                            <span class="text-base-content/60">Ảnh mới sẽ thay thế</span>
                        </div>
                        <div class="flex justify-center">
                            <div class="avatar">
                                <div class="w-32 h-32 rounded-lg ring ring-warning ring-offset-base-100 ring-offset-2">
                                    <img id="newPreviewImg" src="" alt="New Preview" class="object-cover">
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
                        <button type="submit" class="btn btn-warning gap-2 order-1 sm:order-2">
                            <i class="ri-save-line"></i>
                            Cập Nhật Danh Mục
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change History Card (Optional Enhancement) -->
            <div class="bg-base-100 rounded-lg shadow-lg p-6 mt-6">
                <div class="flex items-center gap-3 mb-4">
                    <i class="ri-history-line text-info text-xl"></i>
                    <h3 class="text-lg font-semibold">Thông Tin Danh Mục</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="flex items-center gap-2">
                        <i class="ri-calendar-line text-base-content/60"></i>
                        <span class="text-base-content/60">Ngày tạo:</span>
                        <span class="font-medium">{{ $articleCategory->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="ri-calendar-check-line text-base-content/60"></i>
                        <span class="text-base-content/60">Cập nhật lần cuối:</span>
                        <span class="font-medium">{{ $articleCategory->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
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
            const newImagePreview = document.getElementById('newImagePreview');
            const newPreviewImg = document.getElementById('newPreviewImg');


            const originalSlug = slugInput.value;
            let manualSlugEdit = false;

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

                if (!manualSlugEdit) {
                    slugInput.value = slug;
                }
            });

            // Detect manual slug editing
            slugInput.addEventListener('input', function() {
                manualSlugEdit = true;
            });

            // New image preview
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        newPreviewImg.src = e.target.result;
                        newImagePreview.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    newImagePreview.classList.add('hidden');
                }
            });
        });
    </script>
@endpush
