@extends('admin.layouts.master')

@section('content')
    <div class="min-h-screen bg-base-200 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-base-content flex items-center gap-3">
                            <i class="ri-edit-box-line text-primary"></i>
                            Chỉnh Sửa Bài Viết
                        </h1>
                        <p class="text-base-content/70 mt-2">Cập nhật thông tin bài viết của bạn</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.articles.index') }}" class="btn btn-ghost btn-sm">
                            <i class="ri-arrow-left-line"></i>
                            Quay lại
                        </a>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.articles.update', $article->slug) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Basic Information Card -->
                        <div class="card bg-base-100 shadow-lg">
                            <div class="card-body">
                                <h2 class="card-title text-lg flex items-center gap-2">
                                    <i class="ri-information-line text-primary"></i>
                                    Thông Tin Cơ Bản
                                </h2>

                                <div class="space-y-4">
                                    <!-- Title -->
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-semibold flex items-center gap-2">
                                                <i class="ri-text text-primary"></i>
                                                Tiêu Đề
                                            </span>
                                        </label>
                                        <input type="text" name="title" id="title"
                                            class="input input-bordered w-full @error('title') input-error @enderror"
                                            value="{{ old('title', $article->title) }}" required
                                            placeholder="Nhập tiêu đề bài viết...">
                                        @error('title')
                                            <label class="label">
                                                <span class="label-text-alt text-error">{{ $message }}</span>
                                            </label>
                                        @enderror
                                    </div>

                                    <!-- Slug -->
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-semibold flex items-center gap-2">
                                                <i class="ri-link text-primary"></i>
                                                Slug
                                            </span>
                                        </label>
                                        <input type="text" name="slug" id="slug"
                                            class="input input-bordered w-full @error('slug') input-error @enderror"
                                            value="{{ old('slug', $article->slug) }}" required placeholder="slug-bai-viet">
                                        @error('slug')
                                            <label class="label">
                                                <span class="label-text-alt text-error">{{ $message }}</span>
                                            </label>
                                        @enderror
                                    </div>

                                    <!-- Excerpt -->
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-semibold flex items-center gap-2">
                                                <i class="ri-file-text-line text-primary"></i>
                                                Tóm Tắt
                                            </span>
                                        </label>
                                        <textarea name="excerpt" id="excerpt"
                                            class="textarea textarea-bordered h-24 @error('excerpt') textarea-error @enderror"
                                            placeholder="Mô tả ngắn gọn về bài viết...">{{ old('excerpt', $article->excerpt) }}</textarea>
                                        @error('excerpt')
                                            <label class="label">
                                                <span class="label-text-alt text-error">{{ $message }}</span>
                                            </label>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Content Card -->
                        <div class="card bg-base-100 shadow-lg">
                            <div class="card-body">
                                <h2 class="card-title text-lg flex items-center gap-2">
                                    <i class="ri-file-edit-line text-primary"></i>
                                    Nội Dung Bài Viết
                                </h2>

                                <div class="form-control">
                                    <textarea name="content" id="content"
                                        class="textarea textarea-bordered w-full h-96 @error('content') textarea-error @enderror" required>{{ old('content', $article->content) }}</textarea>
                                    @error('content')
                                        <label class="label">
                                            <span class="label-text-alt text-error">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- SEO Card -->
                        <div class="card bg-base-100 shadow-lg">
                            <div class="card-body">
                                <h2 class="card-title text-lg flex items-center gap-2">
                                    <i class="ri-search-eye-line text-primary"></i>
                                    Tối Ưu SEO
                                </h2>

                                <div class="space-y-4">
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-semibold">Meta Keywords</span>
                                        </label>
                                        <input type="text" name="meta_keywords" id="meta_keywords"
                                            class="input input-bordered w-full @error('meta_keywords') input-error @enderror"
                                            value="{{ old('meta_keywords', $article->meta_keywords) }}"
                                            placeholder="từ khóa, seo, marketing">
                                        @error('meta_keywords')
                                            <label class="label">
                                                <span class="label-text-alt text-error">{{ $message }}</span>
                                            </label>
                                        @enderror
                                    </div>

                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-semibold">Meta Description</span>
                                        </label>
                                        <textarea name="meta_description" id="meta_description"
                                            class="textarea textarea-bordered h-20 @error('meta_description') textarea-error @enderror"
                                            placeholder="Mô tả ngắn gọn cho công cụ tìm kiếm...">{{ old('meta_description', $article->meta_description) }}</textarea>
                                        @error('meta_description')
                                            <label class="label">
                                                <span class="label-text-alt text-error">{{ $message }}</span>
                                            </label>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Publish Settings -->
                        <div class="card bg-base-100 shadow-lg">
                            <div class="card-body">
                                <h2 class="card-title text-lg flex items-center gap-2">
                                    <i class="ri-settings-3-line text-primary"></i>
                                    Cài Đặt Xuất Bản
                                </h2>

                                <div class="space-y-4">
                                    <!-- Status -->
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-semibold flex items-center gap-2">
                                                <i class="ri-flag-line text-primary"></i>
                                                Trạng Thái
                                            </span>
                                        </label>
                                        <select name="status" id="status"
                                            class="select select-bordered w-full @error('status') select-error @enderror"
                                            required>
                                            <option value="draft"
                                                {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>
                                                📝 Bản Nháp
                                            </option>
                                            <option value="published"
                                                {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>
                                                ✅ Đã Xuất Bản
                                            </option>

                                        </select>
                                        @error('status')
                                            <label class="label">
                                                <span class="label-text-alt text-error">{{ $message }}</span>
                                            </label>
                                        @enderror
                                    </div>

                                    <!-- Type -->
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-semibold flex items-center gap-2">
                                                <i class="ri-bookmark-line text-primary"></i>
                                                Loại Bài Viết
                                            </span>
                                        </label>
                                        <select name="type" id="type"
                                            class="select select-bordered w-full @error('type') select-error @enderror"
                                            required>
                                            <option value="news"
                                                {{ old('type', $article->type) == 'news' ? 'selected' : '' }}>
                                                📰 Tin Tức
                                            </option>
                                            <option value="event"
                                                {{ old('type', $article->type) == 'event' ? 'selected' : '' }}>
                                                🎉 Sự Kiện
                                            </option>
                                            <option value="blog"
                                                {{ old('type', $article->type) == 'blog' ? 'selected' : '' }}>
                                                ✍️ Blog
                                            </option>
                                            <option value="promotion"
                                                {{ old('type', $article->type) == 'promotion' ? 'selected' : '' }}>
                                                🎯 Khuyến Mãi
                                            </option>
                                        </select>
                                        @error('type')
                                            <label class="label">
                                                <span class="label-text-alt text-error">{{ $message }}</span>
                                            </label>
                                        @enderror
                                    </div>

                                    <!-- Published At -->
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-semibold flex items-center gap-2">
                                                <i class="ri-calendar-line text-primary"></i>
                                                Ngày Xuất Bản
                                            </span>
                                        </label>
                                        <input type="datetime-local" name="published_at" id="published_at"
                                            class="input input-bordered w-full @error('published_at') input-error @enderror"
                                            value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\\TH:i') : '') }}">
                                        @error('published_at')
                                            <label class="label">
                                                <span class="label-text-alt text-error">{{ $message }}</span>
                                            </label>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Author & Category -->
                        <div class="card bg-base-100 shadow-lg">
                            <div class="card-body">
                                <h2 class="card-title text-lg flex items-center gap-2">
                                    <i class="ri-user-settings-line text-primary"></i>
                                    Tác Giả & Danh Mục
                                </h2>

                                <div class="space-y-4">
                                    <!-- Author -->
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-semibold flex items-center gap-2">
                                                <i class="ri-user-line text-primary"></i>
                                                Tác Giả
                                            </span>
                                        </label>
                                        <select name="user_id" id="user_id"
                                            class="select select-bordered w-full @error('user_id') select-error @enderror"
                                            required>
                                            <option value="">-- Chọn Tác Giả --</option>
                                            @foreach ($users as $id => $username)
                                                <option value="{{ $id }}"
                                                    {{ old('user_id', $article->user_id) == $id ? 'selected' : '' }}>
                                                    {{ $username }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <label class="label">
                                                <span class="label-text-alt text-error">{{ $message }}</span>
                                            </label>
                                        @enderror
                                    </div>

                                    <!-- Category -->
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-semibold flex items-center gap-2">
                                                <i class="ri-folder-line text-primary"></i>
                                                Danh Mục
                                            </span>
                                        </label>
                                        <select name="article_category_id" id="article_category_id"
                                            class="select select-bordered w-full @error('article_category_id') select-error @enderror">
                                            <option value="">-- Chọn Danh Mục --</option>
                                            @foreach ($categories as $id => $name)
                                                <option value="{{ $id }}"
                                                    {{ old('article_category_id', $article->article_category_id) == $id ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('article_category_id')
                                            <label class="label">
                                                <span class="label-text-alt text-error">{{ $message }}</span>
                                            </label>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Featured Image -->
                        <div class="card bg-base-100 shadow-lg">
                            <div class="card-body">
                                <h2 class="card-title text-lg flex items-center gap-2">
                                    <i class="ri-image-line text-primary"></i>
                                    Ảnh Đại Diện
                                </h2>

                                <div class="space-y-4">
                                    @if ($article->featured_image_url)
                                        <div class="relative">
                                            <img src="{{ asset('storage/' . $article->featured_image_url) }}"
                                                alt="{{ $article->title }}"
                                                class="w-full h-48 object-cover rounded-lg border-2 border-base-300">
                                            <div class="absolute top-2 right-2">
                                                <div class="badge badge-success">Hiện tại</div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-center py-8 border-2 border-dashed border-base-300 rounded-lg">
                                            <i class="ri-image-add-line text-4xl text-base-content/50"></i>
                                            <p class="text-base-content/70 mt-2">Chưa có ảnh đại diện</p>
                                        </div>
                                    @endif

                                    <div class="form-control">
                                        <input type="file" name="featured_image" id="featured_image"
                                            class="file-input file-input-bordered w-full @error('featured_image') file-input-error @enderror"
                                            accept="image/*">
                                        @error('featured_image')
                                            <label class="label">
                                                <span class="label-text-alt text-error">{{ $message }}</span>
                                            </label>
                                        @enderror
                                        <label class="label">
                                            <span class="label-text-alt">Chọn ảnh mới để thay thế</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Event Details (Show only for event type) -->
                        <div id="event-details" class="card bg-base-100 shadow-lg" style="display: none;">
                            <div class="card-body">
                                <h2 class="card-title text-lg flex items-center gap-2">
                                    <i class="ri-calendar-event-line text-primary"></i>
                                    Chi Tiết Sự Kiện
                                </h2>

                                <div class="space-y-4">
                                    <!-- Event Start Time -->
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-semibold flex items-center gap-2">
                                                <i class="ri-time-line text-primary"></i>
                                                Thời Gian Bắt Đầu
                                            </span>
                                        </label>
                                        <input type="datetime-local" name="event_start_time" id="event_start_time"
                                            class="input input-bordered w-full @error('event_start_time') input-error @enderror"
                                            value="{{ old('event_start_time', $article->event_start_time ? $article->event_start_time->format('Y-m-d\\TH:i') : '') }}">
                                        @error('event_start_time')
                                            <label class="label">
                                                <span class="label-text-alt text-error">{{ $message }}</span>
                                            </label>
                                        @enderror
                                    </div>

                                    <!-- Event End Time -->
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-semibold flex items-center gap-2">
                                                <i class="ri-time-line text-primary"></i>
                                                Thời Gian Kết Thúc
                                            </span>
                                        </label>
                                        <input type="datetime-local" name="event_end_time" id="event_end_time"
                                            class="input input-bordered w-full @error('event_end_time') input-error @enderror"
                                            value="{{ old('event_end_time', $article->event_end_time ? $article->event_end_time->format('Y-m-d\\TH:i') : '') }}">
                                        @error('event_end_time')
                                            <label class="label">
                                                <span class="label-text-alt text-error">{{ $message }}</span>
                                            </label>
                                        @enderror
                                    </div>

                                    <!-- Event Location -->
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-semibold flex items-center gap-2">
                                                <i class="ri-map-pin-line text-primary"></i>
                                                Địa Điểm
                                            </span>
                                        </label>
                                        <input type="text" name="event_location" id="event_location"
                                            class="input input-bordered w-full @error('event_location') input-error @enderror"
                                            value="{{ old('event_location', $article->event_location) }}"
                                            placeholder="Nhập địa điểm tổ chức sự kiện...">
                                        @error('event_location')
                                            <label class="label">
                                                <span class="label-text-alt text-error">{{ $message }}</span>
                                            </label>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="card bg-base-100 shadow-lg">
                            <div class="card-body">
                                <div class="flex flex-col gap-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-save-line"></i>
                                        Cập Nhật Bài Viết
                                    </button>
                                    <a href="{{ route('admin.articles.index') }}" class="btn btn-outline">
                                        <i class="ri-close-line"></i>
                                        Hủy Bỏ
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize CKEditor
            ClassicEditor
                .create(document.querySelector('#content'), {
                    toolbar: {
                        items: [
                            'heading',
                            '|',
                            'bold',
                            'italic',
                            'link',
                            'bulletedList',
                            'numberedList',
                            '|',
                            'outdent',
                            'indent',
                            '|',
                            'imageUpload',
                            'blockQuote',
                            'insertTable',
                            'mediaEmbed',
                            'undo',
                            'redo',


                        ]
                    },
                    language: 'vi',
                    image: {
                        toolbar: [
                            'imageTextAlternative',
                            'imageStyle:full',
                            'imageStyle:side',
                            'linkImage'
                        ]
                    },
                    table: {
                        contentToolbar: [
                            'tableColumn',
                            'tableRow',
                            'mergeTableCells'
                        ]
                    },
                    licenseKey: '',
                    minHeight: '400px'
                })
                .catch(error => {
                    console.error(error);
                });

            // Auto-generate slug from title
            const titleInput = document.getElementById('title');
            const slugInput = document.getElementById('slug');

            titleInput.addEventListener('input', function() {
                const title = this.value;
                const slug = title.toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .trim('-');
                slugInput.value = slug;
            });

            // Show/hide event details based on type
            const typeSelect = document.getElementById('type');
            const eventDetails = document.getElementById('event-details');

            function toggleEventDetails() {
                if (typeSelect.value === 'event') {
                    eventDetails.style.display = 'block';
                } else {
                    eventDetails.style.display = 'none';
                }
            }

            typeSelect.addEventListener('change', toggleEventDetails);
            toggleEventDetails(); // Initialize on page load

            // Preview image before upload
            const fileInput = document.getElementById('featured_image');
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Create preview if needed
                        console.log('Image selected:', file.name);
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>

    <style>
        .ck-editor__editable {
            min-height: 400px;
        }

        .ck-editor__main {
            border-radius: 0.5rem;
        }

        .ck-toolbar {
            border-radius: 0.5rem 0.5rem 0 0;
        }

        .ck-editor__editable {
            border-radius: 0 0 0.5rem 0.5rem;
        }
    </style>
@endsection
