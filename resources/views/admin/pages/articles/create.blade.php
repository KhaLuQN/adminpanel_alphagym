@extends('admin.layouts.master')

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
                <button type="button" id="save-draft" class="btn btn-outline btn-warning gap-2">
                    <i class="ri-save-line"></i>
                    Lưu Nháp
                </button>
                <button type="button" id="preview-btn" class="btn btn-outline btn-info gap-2">
                    <i class="ri-eye-line"></i>
                    Xem Trước
                </button>
            </div>
        </div>

        <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" id="article-form">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information Card -->
                    <div class="card bg-base-100 shadow-lg border border-base-300">
                        <div class="card-body">
                            <h2 class="card-title text-xl mb-4 flex items-center gap-2">
                                <i class="ri-information-line text-primary"></i>
                                Thông Tin Cơ Bản
                            </h2>

                            <!-- Title -->
                            <div class="form-control mb-4">
                                <label class="label">
                                    <span class="label-text font-semibold flex items-center gap-2">
                                        <i class="ri-title text-lg"></i>
                                        Tiêu Đề <span class="text-error">*</span>
                                    </span>
                                </label>
                                <input type="text" name="title" id="title"
                                    class="input input-bordered w-full @error('title') input-error @enderror"
                                    value="{{ old('title') }}" placeholder="Nhập tiêu đề bài viết...">
                                @error('title')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- Slug -->
                            <div class="form-control mb-4">
                                <label class="label">
                                    <span class="label-text font-semibold flex items-center gap-2">
                                        <i class="ri-link text-lg"></i>
                                        Slug <span class="text-error">*</span>
                                    </span>
                                </label>
                                <div class="input-group">
                                    <input type="text" name="slug" id="slug"
                                        class="input input-bordered w-full @error('slug') input-error @enderror"
                                        value="{{ old('slug') }}" placeholder="duong-dan-url-bai-viet">
                                    <button type="button" id="generate-slug" class="btn btn-square btn-outline">
                                        <i class="ri-refresh-line"></i>
                                    </button>
                                </div>
                                @error('slug')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- Excerpt -->
                            <div class="form-control mb-4">
                                <label class="label">
                                    <span class="label-text font-semibold flex items-center gap-2">
                                        <i class="ri-file-text-line text-lg"></i>
                                        Tóm Tắt
                                    </span>
                                </label>
                                <textarea name="excerpt" id="excerpt"
                                    class="textarea textarea-bordered h-24 @error('excerpt') textarea-error @enderror"
                                    placeholder="Viết tóm tắt ngắn gọn về bài viết...">{{ old('excerpt') }}</textarea>
                                @error('excerpt')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Content Card -->
                    <div class="card bg-base-100 shadow-lg border border-base-300">
                        <div class="card-body">
                            <h2 class="card-title text-xl mb-4 flex items-center gap-2">
                                <i class="ri-file-edit-line text-primary"></i>
                                Nội Dung Bài Viết
                            </h2>

                            <div class="form-control">
                                <textarea name="content" id="content" class="@error('content') textarea-error @enderror">{{ old('content') }}</textarea>
                                @error('content')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Event Details Card (Hidden by default) -->
                    <div class="card bg-base-100 shadow-lg border border-base-300" id="event-details"
                        style="display: none;">
                        <div class="card-body">
                            <h2 class="card-title text-xl mb-4 flex items-center gap-2">
                                <i class="ri-calendar-event-line text-primary"></i>
                                Thông Tin Sự Kiện
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold flex items-center gap-2">
                                            <i class="ri-time-line"></i>
                                            Thời Gian Bắt Đầu
                                        </span>
                                    </label>
                                    <input type="datetime-local" name="event_start_time" id="event_start_time"
                                        class="input input-bordered @error('event_start_time') input-error @enderror"
                                        value="{{ old('event_start_time') }}">
                                    @error('event_start_time')
                                        <label class="label">
                                            <span class="label-text-alt text-error">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>

                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold flex items-center gap-2">
                                            <i class="ri-time-line"></i>
                                            Thời Gian Kết Thúc
                                        </span>
                                    </label>
                                    <input type="datetime-local" name="event_end_time" id="event_end_time"
                                        class="input input-bordered @error('event_end_time') input-error @enderror"
                                        value="{{ old('event_end_time') }}">
                                    @error('event_end_time')
                                        <label class="label">
                                            <span class="label-text-alt text-error">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>

                                <div class="form-control md:col-span-2">
                                    <label class="label">
                                        <span class="label-text font-semibold flex items-center gap-2">
                                            <i class="ri-map-pin-line"></i>
                                            Địa Điểm Sự Kiện
                                        </span>
                                    </label>
                                    <input type="text" name="event_location" id="event_location"
                                        class="input input-bordered @error('event_location') input-error @enderror"
                                        value="{{ old('event_location') }}"
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

                    <!-- SEO Card -->
                    <div class="card bg-base-100 shadow-lg border border-base-300">
                        <div class="card-body">
                            <h2 class="card-title text-xl mb-4 flex items-center gap-2">
                                <i class="ri-search-eye-line text-primary"></i>
                                Tối Ưu SEO
                            </h2>

                            <div class="space-y-4">
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold flex items-center gap-2">
                                            <i class="ri-hashtag"></i>
                                            Meta Keywords
                                        </span>
                                    </label>
                                    <input type="text" name="meta_keywords" id="meta_keywords"
                                        class="input input-bordered @error('meta_keywords') input-error @enderror"
                                        value="{{ old('meta_keywords') }}"
                                        placeholder="từ khóa 1, từ khóa 2, từ khóa 3...">
                                    @error('meta_keywords')
                                        <label class="label">
                                            <span class="label-text-alt text-error">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>

                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold flex items-center gap-2">
                                            <i class="ri-file-text-line"></i>
                                            Meta Description
                                        </span>
                                    </label>
                                    <textarea name="meta_description" id="meta_description"
                                        class="textarea textarea-bordered h-24 @error('meta_description') textarea-error @enderror"
                                        placeholder="Mô tả ngắn gọn về bài viết để hiển thị trong kết quả tìm kiếm...">{{ old('meta_description') }}</textarea>
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
                    <!-- Publish Card -->
                    <div class="card bg-base-100 shadow-lg border border-base-300">
                        <div class="card-body">
                            <h2 class="card-title text-lg mb-4 flex items-center gap-2">
                                <i class="ri-settings-3-line text-primary"></i>
                                Cài Đặt Xuất Bản
                            </h2>

                            <div class="space-y-4">
                                <!-- Status -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold flex items-center gap-2">
                                            <i class="ri-eye-line"></i>
                                            Trạng Thái
                                        </span>
                                    </label>
                                    <select name="status" id="status"
                                        class="select select-bordered @error('status') select-error @enderror" required>
                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>
                                            <i class="ri-draft-line"></i> Bản Nháp
                                        </option>
                                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>
                                            <i class="ri-checkbox-circle-line"></i> Đã Xuất Bản
                                        </option>

                                    </select>
                                    @error('status')
                                        <label class="label">
                                            <span class="label-text-alt text-error">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>

                                <!-- Published Date -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold flex items-center gap-2">
                                            <i class="ri-calendar-line"></i>
                                            Ngày Xuất Bản
                                        </span>
                                    </label>
                                    <input type="datetime-local" name="published_at" id="published_at"
                                        class="input input-bordered @error('published_at') input-error @enderror"
                                        value="{{ old('published_at') }}">
                                    @error('published_at')
                                        <label class="label">
                                            <span class="label-text-alt text-error">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>

                                <!-- Type -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold flex items-center gap-2">
                                            <i class="ri-price-tag-3-line"></i>
                                            Loại Bài Viết
                                        </span>
                                    </label>
                                    <select name="type" id="type"
                                        class="select select-bordered @error('type') select-error @enderror" required>
                                        <option value="news" {{ old('type') == 'news' ? 'selected' : '' }}>
                                            📰 Tin Tức
                                        </option>
                                        <option value="event" {{ old('type') == 'event' ? 'selected' : '' }}>
                                            🎪 Sự Kiện
                                        </option>
                                        <option value="blog" {{ old('type') == 'blog' ? 'selected' : '' }}>
                                            ✍️ Blog
                                        </option>
                                        <option value="promotion" {{ old('type') == 'promotion' ? 'selected' : '' }}>
                                            🎁 Khuyến Mãi
                                        </option>
                                    </select>
                                    @error('type')
                                        <label class="label">
                                            <span class="label-text-alt text-error">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image Card -->
                    <div class="card bg-base-100 shadow-lg border border-base-300">
                        <div class="card-body">
                            <h2 class="card-title text-lg mb-4 flex items-center gap-2">
                                <i class="ri-image-line text-primary"></i>
                                Ảnh Đại Diện
                            </h2>

                            <div class="form-control">
                                <div class="upload-area border-2 border-dashed border-base-300 rounded-lg p-6 text-center hover:border-primary transition-colors cursor-pointer"
                                    id="upload-area">
                                    <i class="ri-upload-cloud-2-line text-4xl text-base-content/50 mb-2"></i>
                                    <p class="text-base-content/70">Click để chọn ảnh hoặc kéo thả vào đây</p>
                                    <p class="text-sm text-base-content/50 mt-1">JPG, PNG, GIF (tối đa 5MB)</p>
                                </div>
                                <input type="file" name="featured_image" id="featured_image"
                                    class="hidden @error('featured_image') file-input-error @enderror" accept="image/*">
                                <div id="image-preview" class="mt-4 hidden">
                                    <img id="preview-img" class="w-full h-48 object-cover rounded-lg">
                                    <button type="button" id="remove-image" class="btn btn-sm btn-error mt-2">
                                        <i class="ri-delete-bin-line"></i> Xóa ảnh
                                    </button>
                                </div>
                                @error('featured_image')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Author & Category Card -->
                    <div class="card bg-base-100 shadow-lg border border-base-300">
                        <div class="card-body">
                            <h2 class="card-title text-lg mb-4 flex items-center gap-2">
                                <i class="ri-user-settings-line text-primary"></i>
                                Phân Loại
                            </h2>

                            <div class="space-y-4">
                                <!-- Author -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold flex items-center gap-2">
                                            <i class="ri-user-line"></i>
                                            Tác Giả
                                        </span>
                                    </label>
                                    <select name="user_id" id="user_id"
                                        class="select select-bordered @error('user_id') select-error @enderror" required>
                                        <option value="">-- Chọn Tác Giả --</option>
                                        @foreach ($users as $id => $username)
                                            <option value="{{ $id }}"
                                                {{ old('user_id') == $id ? 'selected' : '' }}>
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
                                            <i class="ri-bookmark-line"></i>
                                            Danh Mục
                                        </span>
                                    </label>
                                    <select name="article_category_id" id="article_category_id"
                                        class="select select-bordered @error('article_category_id') select-error @enderror">
                                        <option value="">-- Chọn Danh Mục --</option>
                                        @foreach ($categories as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ old('article_category_id') == $id ? 'selected' : '' }}>
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
                </div>
            </div>

            <!-- Action Buttons -->
            <div
                class="flex items-center justify-between mt-8 p-4 bg-base-100 rounded-lg shadow-lg border border-base-300">
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
                        Xuất Bản
                    </button>
                </div>
            </div>
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

    <!-- CKEditor 5 -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
        let editor;

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
                        '|',
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
                }
            })
            .then(newEditor => {
                editor = newEditor;
                editor.model.document.on('change:data', () => {
                    autoGenerateExcerpt();
                });
            })
            .catch(error => {
                console.error(error);
            });

        // Auto-generate slug from title
        document.getElementById('title').addEventListener('input', function() {
            const title = this.value;
            const slug = title
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
            document.getElementById('slug').value = slug;
        });

        // Manual slug generation
        document.getElementById('generate-slug').addEventListener('click', function() {
            const title = document.getElementById('title').value;
            const slug = title
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
            document.getElementById('slug').value = slug;
        });

        // Auto-generate excerpt from content
        function autoGenerateExcerpt() {
            const excerptField = document.getElementById('excerpt');
            if (excerptField.value.trim() === '' && editor) {
                const content = editor.getData();
                const textContent = content.replace(/<[^>]*>/g, '').trim();
                const excerpt = textContent.substring(0, 200) + (textContent.length > 200 ? '...' : '');
                excerptField.value = excerpt;
            }
        }

        // Show/hide event details based on type
        document.getElementById('type').addEventListener('change', function() {
            const eventDetails = document.getElementById('event-details');
            if (this.value === 'event') {
                eventDetails.style.display = 'block';
            } else {
                eventDetails.style.display = 'none';
            }
        });

        // Image upload handling
        const uploadArea = document.getElementById('upload-area');
        const fileInput = document.getElementById('featured_image');
        const imagePreview = document.getElementById('image-preview');
        const previewImg = document.getElementById('preview-img');
        const removeBtn = document.getElementById('remove-image');

        uploadArea.addEventListener('click', () => fileInput.click());

        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('border-primary');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('border-primary');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('border-primary');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                handleImagePreview(files[0]);
            }
        });

        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                handleImagePreview(e.target.files[0]);
            }
        });

        function handleImagePreview(file) {
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImg.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                    uploadArea.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        }

        removeBtn.addEventListener('click', () => {
            fileInput.value = '';
            imagePreview.classList.add('hidden');
            uploadArea.style.display = 'block';
        });

        // Preview functionality
        document.getElementById('preview-btn').addEventListener('click', function() {
            const title = document.getElementById('title').value;
            const content = editor ? editor.getData() : '';

            const previewContent = `
                <h1 class="text-3xl font-bold mb-4">${title}</h1>
                <div class="article-content">${content}</div>
            `;

            document.getElementById('preview-content').innerHTML = previewContent;
            document.getElementById('preview-modal').classList.add('modal-open');
        });

        function closePreviewModal() {
            document.getElementById('preview-modal').classList.remove('modal-open');
        }

        // Save draft functionality
        document.getElementById('save-draft').addEventListener('click', function() {
            document.getElementById('status').value = 'draft';
            document.getElementById('article-form').submit();
        });

        // Auto-save functionality (optional)
        let autoSaveTimeout;

        function autoSave() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                // Implement auto-save logic here
                console.log('Auto-saving...');
            }, 5000);
        }

        // Trigger auto-save on form changes
        document.getElementById('article-form').addEventListener('input', autoSave);
        if (editor) {
            editor.model.document.on('change:data', autoSave);
        }

        // Set default published date to now when status is published
        document.getElementById('status').addEventListener('change', function() {
            const publishedAtField = document.getElementById('published_at');
            if (this.value === 'published' && !publishedAtField.value) {
                const now = new Date();
                now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                publishedAtField.value = now.toISOString().slice(0, 16);
            }
        });
    </script>
@endsection
