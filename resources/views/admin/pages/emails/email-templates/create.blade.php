@extends('admin.layouts.master')

@section('content')
    <div class="min-h-screen bg-base-200 p-6">
        <div class="max-w-5xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                @if (isset($template))
                    <div class="flex items-center gap-3 mb-4">
                        <i class="ri-edit-line text-3xl text-primary"></i>
                        <h1 class="text-4xl font-bold text-base-content">Chỉnh Sửa Mẫu Email</h1>
                    </div>
                    <div class="breadcrumbs text-sm">
                        <ul>
                            <li><a href="{{ route('admin.email-templates.index') }}"
                                    class="text-primary hover:text-primary-focus">Mẫu Email</a></li>
                            <li class="text-base-content/70">Chỉnh sửa: {{ $template->name }}</li>
                        </ul>
                    </div>
                @else
                    <div class="flex items-center gap-3 mb-4">
                        <i class="ri-add-circle-line text-3xl text-success"></i>
                        <h1 class="text-4xl font-bold text-base-content">Tạo Mẫu Email Mới</h1>
                    </div>
                    <div class="breadcrumbs text-sm">
                        <ul>
                            <li><a href="{{ route('admin.email-templates.index') }}"
                                    class="text-primary hover:text-primary-focus">Mẫu Email</a></li>
                            <li class="text-base-content/70">Tạo mới</li>
                        </ul>
                    </div>
                @endif
            </div>

            @if (isset($template))
                <form action="{{ route('admin.email-templates.update', $template->template_id) }}" method="POST"
                    id="emailTemplateForm">
                    @method('PUT')
                @else
                    <form action="{{ route('admin.email-templates.store') }}" method="POST" id="emailTemplateForm">
            @endif
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Template Info Card -->
                    <div class="card bg-base-100 shadow-lg">
                        <div class="card-header border-b border-base-300">
                            <div class="card-body pb-4">
                                <h2 class="card-title text-xl flex items-center gap-2">
                                    <i class="ri-information-line text-info"></i>
                                    Thông Tin Mẫu
                                </h2>
                            </div>
                        </div>
                        <div class="card-body space-y-4">
                            <!-- Template Name -->
                            <div class="form-control">
                                <label class="label" for="name">
                                    <span class="label-text font-semibold flex items-center gap-2">
                                        <i class="ri-price-tag-3-line text-primary"></i>
                                        Tên Mẫu
                                    </span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', $template->name ?? '') }}"
                                    placeholder="Nhập tên mẫu để dễ nhận biết..." required
                                    class="input input-bordered w-full @error('name') input-error @enderror focus:input-primary">
                                @error('name')
                                    <label class="label">
                                        <span class="label-text-alt text-error flex items-center gap-1">
                                            <i class="ri-error-warning-line"></i>
                                            {{ $message }}
                                        </span>
                                    </label>
                                @enderror
                            </div>

                            <!-- Email Subject -->
                            <div class="form-control">
                                <label class="label" for="subject">
                                    <span class="label-text font-semibold flex items-center gap-2">
                                        <i class="ri-mail-line text-primary"></i>
                                        Tiêu Đề Email
                                    </span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <input type="text" name="subject" id="subject"
                                    value="{{ old('subject', $template->subject ?? '') }}"
                                    placeholder="Tiêu đề sẽ hiển thị trong hộp thư..." required
                                    class="input input-bordered w-full @error('subject') input-error @enderror focus:input-primary">
                                @error('subject')
                                    <label class="label">
                                        <span class="label-text-alt text-error flex items-center gap-1">
                                            <i class="ri-error-warning-line"></i>
                                            {{ $message }}
                                        </span>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Email Content Card -->
                    <div class="card bg-base-100 shadow-lg">
                        <div class="card-header border-b border-base-300">
                            <div class="card-body pb-4">
                                <h2 class="card-title text-xl flex items-center gap-2">
                                    <i class="ri-file-text-line text-warning"></i>
                                    Nội Dung Email
                                </h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-control">
                                <label class="label" for="body">
                                    <span class="label-text font-semibold">Soạn nội dung email của bạn</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <textarea name="body" id="body" required class="hidden">{{ old('body', isset($template) ? $template->body : '') }}</textarea>
                                @error('body')
                                    <label class="label">
                                        <span class="label-text-alt text-error flex items-center gap-1">
                                            <i class="ri-error-warning-line"></i>
                                            {{ $message }}
                                        </span>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="card bg-base-100 shadow-lg">
                        <div class="card-body">
                            <h3 class="card-title text-lg flex items-center gap-2 mb-4">
                                <i class="ri-settings-3-line text-primary"></i>
                                Thao Tác
                            </h3>
                            <div class="space-y-3">
                                <button type="submit" class="btn btn-primary w-full gap-2" id="saveBtn">
                                    <i class="ri-save-line"></i>
                                    {{ isset($template) ? 'Cập Nhật Mẫu' : 'Lưu Mẫu Mới' }}
                                </button>
                                <a href="{{ route('admin.email-templates.index') }}" class="btn btn-ghost w-full gap-2">
                                    <i class="ri-arrow-left-line"></i>
                                    Quay Lại
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Variables Guide -->
                    <div class="card bg-gradient-to-br from-info/10 to-info/5 border border-info/20 shadow-lg">
                        <div class="card-body">
                            <h3 class="card-title text-lg flex items-center gap-2 mb-4 text-info">
                                <i class="ri-code-s-slash-line"></i>
                                Biến Có Sẵn
                            </h3>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-2 bg-base-100 rounded-lg border">
                                    <code class="text-sm font-mono text-primary">[TEN_HOI_VIEN]</code>
                                    <button type="button" class="btn btn-xs btn-ghost"
                                        onclick="insertVariable('[TEN_HOI_VIEN]')" title="Chèn vào nội dung">
                                        <i class="ri-add-line"></i>
                                    </button>
                                </div>
                                <div class="flex items-center justify-between p-2 bg-base-100 rounded-lg border">
                                    <code class="text-sm font-mono text-primary">[NGAY_THAM_GIA]</code>
                                    <button type="button" class="btn btn-xs btn-ghost"
                                        onclick="insertVariable('[NGAY_THAM_GIA]')" title="Chèn vào nội dung">
                                        <i class="ri-add-line"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="alert alert-info mt-4">
                                <i class="ri-information-line"></i>
                                <span class="text-sm">Nhấp vào nút + để chèn biến vào nội dung email</span>
                            </div>
                        </div>
                    </div>

                    <!-- Preview -->
                    <div class="card bg-base-100 shadow-lg">
                        <div class="card-body">
                            <h3 class="card-title text-lg flex items-center gap-2 mb-4">
                                <i class="ri-eye-line text-success"></i>
                                Xem Trước
                            </h3>
                            <button type="button" class="btn btn-outline btn-success w-full gap-2"
                                onclick="previewEmail()">
                                <i class="ri-mail-open-line"></i>
                                Xem Trước Email
                            </button>
                        </div>
                    </div>

                    <!-- Tips -->
                    <div class="card bg-gradient-to-br from-warning/10 to-warning/5 border border-warning/20">
                        <div class="card-body">
                            <h3 class="card-title text-lg flex items-center gap-2 mb-4 text-warning">
                                <i class="ri-lightbulb-line"></i>
                                Mẹo Hay
                            </h3>
                            <ul class="space-y-2 text-sm">
                                <li class="flex items-start gap-2">
                                    <i class="ri-check-line text-success mt-0.5 flex-shrink-0"></i>
                                    <span>Sử dụng tiêu đề ngắn gọn, hấp dẫn</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="ri-check-line text-success mt-0.5 flex-shrink-0"></i>
                                    <span>Nội dung rõ ràng, dễ đọc</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="ri-check-line text-success mt-0.5 flex-shrink-0"></i>
                                    <span>Kiểm tra trước khi lưu</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>

    <!-- Preview Modal -->
    <dialog id="previewModal" class="modal">
        <div class="modal-box w-11/12 max-w-4xl">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg flex items-center gap-2">
                    <i class="ri-mail-open-line text-primary"></i>
                    Xem Trước Email
                </h3>
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost">
                        <i class="ri-close-line"></i>
                    </button>
                </form>
            </div>

            <div class="border rounded-lg overflow-hidden">
                <!-- Email Header -->
                <div class="bg-base-200 p-4 border-b">
                    <div class="flex items-center gap-2 text-sm">
                        <span class="font-semibold">Tiêu đề:</span>
                        <span id="previewSubject" class="text-base-content/70"></span>
                    </div>
                </div>

                <!-- Email Content -->
                <div class="p-6 bg-white min-h-[400px]">
                    <div id="previewContent" class="prose max-w-none"></div>
                </div>
            </div>

            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Đóng</button>
                </form>
            </div>
        </div>
    </dialog>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
        <div class="bg-base-100 p-6 rounded-lg shadow-xl">
            <div class="flex items-center gap-3">
                <span class="loading loading-spinner loading-md"></span>
                <span>Đang xử lý...</span>
            </div>
        </div>
    </div>
@endsection



@push('customjs')
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

    <script>
        let editor;

        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#body'), {
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'underline', '|',
                        'link', 'bulletedList', 'numberedList', '|',
                        'outdent', 'indent', '|',
                        'blockQuote', 'insertTable', '|',
                        'fontColor', 'fontBackgroundColor', '|',
                        'alignment', '|',
                        'undo', 'redo'
                    ]
                },
                language: 'vi',
                placeholder: 'Nhập nội dung email của bạn tại đây...\n\nBạn có thể sử dụng các biến như [TEN_HOI_VIEN], [NGAY_THAM_GIA] để cá nhân hóa email.',
                height: '400px'
            })
            .then(newEditor => {
                editor = newEditor;

                // Auto-save draft every 30 seconds
                setInterval(() => {
                    const content = editor.getData();
                    if (content.trim()) {
                        localStorage.setItem('email_template_draft', JSON.stringify({
                            name: document.getElementById('name').value,
                            subject: document.getElementById('subject').value,
                            body: content,
                            timestamp: new Date().toISOString()
                        }));
                    }
                }, 30000);

                // Load draft if exists
                const draft = localStorage.getItem('email_template_draft');
                if (draft && !@json(isset($template))) {
                    const draftData = JSON.parse(draft);
                    if (confirm('Bạn có muốn khôi phục bản nháp đã lưu không?')) {
                        document.getElementById('name').value = draftData.name || '';
                        document.getElementById('subject').value = draftData.subject || '';
                        editor.setData(draftData.body || '');
                    }
                }
            })
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
                // Fallback to regular textarea if CKEditor fails
                document.getElementById('body').classList.remove('hidden');
                document.getElementById('body').setAttribute('rows', '15');
                document.getElementById('body').classList.add('textarea', 'textarea-bordered');
            });

        // Insert variable into editor
        function insertVariable(variable) {
            if (editor) {
                const viewFragment = editor.data.processor.toView(variable);
                const modelFragment = editor.data.toModel(viewFragment);
                editor.model.insertContent(modelFragment);
                editor.editing.view.focus();
            }
        }

        // Preview email function
        function previewEmail() {
            const subject = document.getElementById('subject').value || 'Không có tiêu đề';
            const content = editor ? editor.getData() : document.getElementById('body').value;

            document.getElementById('previewSubject').textContent = subject;
            document.getElementById('previewContent').innerHTML = content ||
                '<p class="text-base-content/50 italic">Chưa có nội dung</p>';

            document.getElementById('previewModal').showModal();
        }

        // Form submission handling
        document.getElementById('emailTemplateForm').addEventListener('submit', function(e) {
            // Show loading
            document.getElementById('loadingOverlay').classList.remove('hidden');

            // Update textarea with editor content
            if (editor) {
                document.getElementById('body').value = editor.getData();
            }

            // Clear draft after successful save
            setTimeout(() => {
                localStorage.removeItem('email_template_draft');
            }, 1000);
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl+S to save
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                document.getElementById('saveBtn').click();
            }

            // Ctrl+P to preview
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                previewEmail();
            }
        });

        // Auto-resize and improve UX
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading states to buttons
            const buttons = document.querySelectorAll('button[type="submit"]');
            buttons.forEach(btn => {
                btn.addEventListener('click', function() {
                    this.classList.add('loading');
                    setTimeout(() => {
                        this.classList.remove('loading');
                    }, 5000);
                });
            });

            // Character count for subject
            const subjectInput = document.getElementById('subject');
            const maxLength = 100;

            function updateCharCount() {
                const current = subjectInput.value.length;
                const remaining = maxLength - current;

                let countElement = document.getElementById('subjectCharCount');
                if (!countElement) {
                    countElement = document.createElement('span');
                    countElement.id = 'subjectCharCount';
                    countElement.className = 'label-text-alt';
                    subjectInput.parentNode.querySelector('.label').appendChild(countElement);
                }

                countElement.textContent = `${current}/${maxLength}`;
                countElement.className = remaining < 20 ? 'label-text-alt text-warning' :
                    'label-text-alt text-base-content/50';
            }

            subjectInput.addEventListener('input', updateCharCount);
            updateCharCount();
        });

        // Warn before leaving if there are unsaved changes
        let hasUnsavedChanges = false;

        ['input', 'change'].forEach(event => {
            document.addEventListener(event, function() {
                hasUnsavedChanges = true;
            });
        });

        document.getElementById('emailTemplateForm').addEventListener('submit', function() {
            hasUnsavedChanges = false;
        });

        window.addEventListener('beforeunload', function(e) {
            if (hasUnsavedChanges) {
                e.preventDefault();
                e.returnValue = '';
            }
        });
    </script>
@endpush
