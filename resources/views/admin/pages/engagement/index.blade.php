@extends('admin.layouts.master')

@section('content')
    <div class="min-h-screen bg-base-200 p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-base-content flex items-center gap-3">
                            <i class="ri-mail-send-line text-primary"></i>
                            Email Marketing & CSKH
                        </h1>
                        <p class="text-base-content/70 mt-2">Gửi email tới hội viên theo tiêu chí lọc</p>
                    </div>
                    <div class="stats shadow">
                        <div class="stat place-items-center">
                            <div class="stat-title">Tổng hội viên</div>
                            <div class="stat-value text-primary">{{ $members->total() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="card bg-base-100 shadow-lg mb-6">
                <div class="card-body">
                    <h2 class="card-title text-xl flex items-center gap-2">
                        <i class="ri-filter-3-line text-primary"></i>
                        Bộ Lọc Hội Viên
                    </h2>

                    <form method="GET" action="{{ route('admin.engagement.index') }}" class="mt-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold flex items-center gap-2">
                                        <i class="ri-calendar-line text-primary"></i>
                                        Số tháng đã tham gia
                                    </span>
                                </label>
                                <input type="number" name="months" id="months" class="input input-bordered w-full"
                                    value="{{ $filters['months'] ?? '' }}" placeholder="Ví dụ: 3">
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold flex items-center gap-2">
                                        <i class="ri-forbid-line text-primary"></i>
                                        Chiến dịch (để loại trừ)
                                    </span>
                                </label>
                                <input type="text" name="campaign_name" id="campaign_name"
                                    class="input input-bordered w-full" value="{{ $filters['campaign_name'] ?? '' }}"
                                    placeholder="Ví dụ: feedback-3-thang">
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text opacity-0">Action</span>
                                </label>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri-search-line"></i>
                                    Lọc Danh Sách
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Email Form -->
            <form method="POST" action="{{ route('admin.engagement.send') }}" id="email-form">
                @csrf

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                    <!-- Members List -->
                    <div class="xl:col-span-2">
                        <div class="card bg-base-100 shadow-lg">
                            <div class="card-body">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="card-title text-xl flex items-center gap-2">
                                        <i class="ri-team-line text-primary"></i>
                                        Danh Sách Hội Viên
                                        <div class="badge badge-primary">{{ $members->total() }}</div>
                                    </h2>


                                </div>

                                <div class="overflow-x-auto">
                                    <table class="table table-zebra w-full datatable">
                                        <thead>
                                            <tr>
                                                <th class="text-center w-16"> <input type="checkbox" id="select-all"
                                                        class="checkbox checkbox-primary"></th>
                                                <th class="text-left"><i class="ri-user-line mr-2"></i>Tên Hội Viên</th>
                                                <th class="text-left"><i class="ri-mail-line mr-2"></i>Email</th>
                                                <th class="text-left"><i class="ri-calendar-line mr-2"></i>Ngày Tham Gia
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($members as $member)
                                                <tr class="hover">
                                                    <td class="text-center">
                                                        <input type="checkbox" name="member_ids[]"
                                                            value="{{ $member->member_id }}"
                                                            class="member-checkbox checkbox checkbox-primary">
                                                    </td>
                                                    <td class="font-medium">
                                                        <div class="flex items-center gap-2">
                                                            <div class="avatar placeholder">
                                                                <div
                                                                    class="bg-primary text-center text-primary-content rounded-full w-8 h-8 text-xs">
                                                                    <span>{{ substr($member->full_name, 0, 1) }}</span>
                                                                </div>
                                                            </div>
                                                            {{ $member->full_name }}
                                                        </div>
                                                    </td>
                                                    <td class="text-blue-600">{{ $member->email }}</td>
                                                    <td>
                                                        <div class="badge badge-outline">
                                                            {{ \Carbon\Carbon::parse($member->join_date)->format('d/m/Y') }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-8">
                                                        <div class="flex flex-col items-center">
                                                            <i
                                                                class="ri-user-search-line text-4xl text-base-content/50 mb-2"></i>
                                                            <p class="text-base-content/70">Không tìm thấy hội viên nào phù
                                                                hợp</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                @if ($members->hasPages())
                                    <div class="mt-4 flex justify-center">
                                        {{ $members->links() }}
                                    </div>
                                @endif

                                <div class="mt-4 flex justify-between items-center">
                                    <div id="selected-count" class="text-sm text-base-content/70">
                                        <i class="ri-checkbox-multiple-line mr-1"></i>
                                        Đã chọn: <span class="font-semibold">0</span> hội viên
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="button" id="select-none" class="btn btn-ghost btn-sm">
                                            <i class="ri-checkbox-blank-line"></i>
                                            Bỏ chọn tất cả
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email Composer -->
                    <div class="xl:col-span-1">
                        <div class="card bg-base-100 shadow-lg sticky top-6">
                            <div class="card-body">
                                <h2 class="card-title text-xl flex items-center gap-2">
                                    <i class="ri-mail-settings-line text-primary"></i>
                                    Soạn Thảo Email
                                </h2>

                                <div class="space-y-4">
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-semibold flex items-center gap-2">
                                                <i class="ri-template-line text-primary"></i>
                                                Chọn mẫu email
                                            </span>
                                        </label>
                                        <select id="template-selector" class="select select-bordered w-full">
                                            <option value="">-- Tự soạn --</option>
                                            @foreach ($templates as $template)
                                                <option value="{{ $template->template_id }}"
                                                    data-subject="{{ $template->subject }}"
                                                    data-body="{{ $template->body }}">
                                                    {{ $template->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-semibold flex items-center gap-2">
                                                <i class="ri-flag-line text-primary"></i>
                                                Tên chiến dịch
                                            </span>
                                        </label>
                                        <input type="text" name="campaign_name" id="campaign_name_send" required
                                            placeholder="Ví dụ: feedback-3-thang" class="input input-bordered w-full">
                                        <label class="label">
                                            <span class="label-text-alt">Để lưu log và theo dõi</span>
                                        </label>
                                    </div>

                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-semibold flex items-center gap-2">
                                                <i class="ri-text text-primary"></i>
                                                Tiêu đề email
                                            </span>
                                        </label>
                                        <input type="text" name="subject" id="subject" required
                                            class="input input-bordered w-full" placeholder="Nhập tiêu đề email...">
                                    </div>

                                    <div class="alert alert-info">
                                        <i class="ri-information-line"></i>
                                        <div>
                                            <h4 class="font-bold">Biến có thể sử dụng:</h4>
                                            <ul class="text-sm mt-1">
                                                <li><code>[TEN_HOI_VIEN]</code> - Tên hội viên</li>
                                                <li><code>[NGAY_THAM_GIA]</code> - Ngày tham gia</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Send Button - UPDATED -->
                                    <div class="form-control mt-6">
                                        <button type="submit" class="btn btn-success btn-lg confirm-action-btn"
                                            id="send-btn" disabled data-form-id="email-form"
                                            data-swal-title="Xác nhận gửi email?"
                                            data-swal-text="Email sẽ được gửi đến các hội viên đã chọn. Bạn có chắc chắn?"
                                            data-swal-icon="info" data-swal-confirm-text="Gửi Ngay"
                                            data-swal-confirm-class="btn btn-success ml-2"
                                            data-swal-cancel-class="btn btn-ghost">
                                            <i class="ri-send-plane-fill"></i>
                                            Gửi Email
                                            <span id="send-count" class="badge badge-outline ml-2">0</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email Content Editor -->
                <div class="card bg-base-100 shadow-lg mt-6">
                    <div class="card-body">
                        <h2 class="card-title text-xl flex items-center gap-2">
                            <i class="ri-file-edit-line text-primary"></i>
                            Nội Dung Email
                        </h2>
                        <div class="form-control mt-4">
                            <textarea name="body" id="body" rows="10" class="textarea textarea-bordered w-full min-h-96"
                                placeholder="Nhập nội dung email..."></textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->


    <style>
        .ck-editor__editable {
            min-height: 300px;
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

        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
@endsection

@push('customjs')
    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let editor;


            ClassicEditor
                .create(document.querySelector('#body'), {

                    toolbar: {
                        items: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList',
                            'numberedList', '|', 'outdent', 'indent', '|', 'blockQuote', 'insertTable',
                            'undo', 'redo',
                        ]
                    },
                    language: 'vi',
                    table: {
                        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                    },
                    licenseKey: '',
                })
                .then(newEditor => {
                    editor = newEditor;

                    newEditor.model.document.on('change:data', () => {
                        const bodyTextarea = document.querySelector('#body');
                        bodyTextarea.value = newEditor.getData();
                    });
                })
                .catch(error => {
                    console.error(error);
                });

            // Select all functionality
            const selectAllCheckbox = document.getElementById('select-all');
            const memberCheckboxes = document.querySelectorAll('.member-checkbox');
            const selectedCountSpan = document.querySelector('#selected-count span');
            const sendCountSpan = document.getElementById('send-count');
            const sendBtn = document.getElementById('send-btn');
            const selectNoneBtn = document.getElementById('select-none');

            function updateSelectedCount() {
                const checkedBoxes = document.querySelectorAll('.member-checkbox:checked');
                const count = checkedBoxes.length;
                selectedCountSpan.textContent = count;
                sendCountSpan.textContent = count;
                sendBtn.disabled = count === 0;

                if (count === 0) {
                    selectAllCheckbox.indeterminate = false;
                    selectAllCheckbox.checked = false;
                } else if (count === memberCheckboxes.length) {
                    selectAllCheckbox.indeterminate = false;
                    selectAllCheckbox.checked = true;
                } else {
                    selectAllCheckbox.indeterminate = true;
                }
            }

            selectAllCheckbox.addEventListener('change', function() {
                memberCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateSelectedCount();
            });

            selectNoneBtn.addEventListener('click', function() {
                memberCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
                selectAllCheckbox.checked = false;
                updateSelectedCount();
            });

            memberCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedCount);
            });

            // Template selector
            document.getElementById('template-selector').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const subjectInput = document.getElementById('subject');

                if (selectedOption.value) {
                    subjectInput.value = selectedOption.getAttribute('data-subject');
                    if (editor) {
                        const bodyContent = selectedOption.getAttribute('data-body');
                        editor.setData(bodyContent);
                    }
                } else {
                    subjectInput.value = '';
                    if (editor) {
                        editor.setData('');
                    }
                }
            });


            updateSelectedCount();
        });
    </script>
@endpush
