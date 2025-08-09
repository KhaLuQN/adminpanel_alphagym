@extends('admin.layouts.master')
@section('page_title', 'Khiếu nại từ khách hàng')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="link link-hover">Admin</a></li>
    <li><a href="#" class="link link-hover">Liên hệ & Khiếu nại</a></li>
@endsection

@section('content')
    <div class="container mx-auto p-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Quản lý Liên hệ & Khiếu nại</h1>
                <p class="text-gray-600 mt-2">Theo dõi và xử lý các yêu cầu từ khách hàng</p>
            </div>

            <!-- Stats Cards -->
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-primary">
                        <i class="ri-message-3-line text-2xl"></i>
                    </div>
                    <div class="stat-title">Tổng số</div>
                    <div class="stat-value text-primary">{{ $contacts->count() }}</div>
                </div>

                <div class="stat">
                    <div class="stat-figure text-warning">
                        <i class="ri-time-line text-2xl"></i>
                    </div>
                    <div class="stat-title">Chưa giải quyết</div>
                    <div class="stat-value text-warning">{{ $contacts->where('is_resolved', 0)->count() }}</div>
                </div>

                <div class="stat">
                    <div class="stat-figure text-success">
                        <i class="ri-check-line text-2xl"></i>
                    </div>
                    <div class="stat-title">Đã giải quyết</div>
                    <div class="stat-value text-success">{{ $contacts->where('is_resolved', 1)->count() }}</div>
                </div>
            </div>
        </div>



        <!-- Main Content -->
        <div class="bg-white rounded-lg p-3 shadow-sm overflow-hidden">
            <!-- Table Header -->
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full datatable">
                    <thead class="bg-gray-50">
                        <tr>

                            <th>Khách hàng</th>
                            <th>Liên hệ</th>
                            <th>Loại</th>
                            <th>Nội dung</th>
                            <th>Trạng thái</th>
                            <th>Thời gian</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $contact)
                            <tr class="hover">


                                <!-- Customer Info -->
                                <td>
                                    <div class="flex items-center  space-x-3">

                                        <div>
                                            <div class="font-bold  text-sm">{{ $contact->full_name }}</div>

                                        </div>
                                    </div>
                                </td>

                                <!-- Contact Info -->
                                <td>
                                    <div class="text-sm">
                                        <div class="flex items-center gap-1 mb-1">
                                            <i class="ri-mail-line text-xs"></i>
                                            <span>{{ $contact->email }}</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <i class="ri-phone-line text-xs"></i>
                                            <span>{{ $contact->phone }}</span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Type Badge -->
                                <td>
                                    @php
                                        $typeConfig = [
                                            'complain' => ['label' => 'Khiếu nại', 'class' => 'badge-error'],
                                            'support' => ['label' => 'Hỗ trợ', 'class' => 'badge-success'],
                                            'contact' => ['label' => 'Liên hệ', 'class' => 'badge-info'],
                                        ];
                                        $config = $typeConfig[$contact->type] ?? [
                                            'label' => 'Khác',
                                            'class' => 'badge-neutral',
                                        ];
                                    @endphp
                                    <div class="badge {{ $config['class'] }} badge-sm">
                                        {{ $config['label'] }}
                                    </div>
                                </td>

                                <!-- Message -->
                                <td>
                                    <div class="max-w-xs">
                                        <p class="text-sm line-clamp-2">{{ Str::limit($contact->message, 100) }}</p>
                                        @if (strlen($contact->message) > 100)
                                            <button class="text-xs text-primary hover:underline mt-1"
                                                onclick="viewMessage_{{ $contact->id }}.showModal()">
                                                Xem thêm
                                            </button>
                                        @endif
                                    </div>
                                </td>

                                <!-- Status -->
                                <td>
                                    @if ($contact->is_resolved)
                                        <div class="badge badge-success badge-sm gap-1">
                                            <i class="ri-check-line"></i>
                                            Đã giải quyết
                                        </div>
                                    @else
                                        <div class="badge badge-warning badge-sm gap-1">
                                            <i class="ri-time-line"></i>
                                            Chưa giải quyết
                                        </div>
                                    @endif
                                </td>

                                <!-- Time -->
                                <td>
                                    <div class="text-sm">
                                        <div>{{ $contact->submitted_at_formatted }}</div>

                                        <div class="text-xs opacity-50">{{ $contact->submitted_at }}</div>
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td>
                                    <div class="dropdown dropdown-end">
                                        <button tabindex="0" class="btn btn-ghost btn-sm">
                                            <i class="ri-more-2-line"></i>
                                        </button>
                                        <ul tabindex="0"
                                            class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                            <li>
                                                <a onclick="viewDetails_{{ $contact->id }}.showModal()">
                                                    <i class="ri-eye-line"></i>
                                                    Xem chi tiết
                                                </a>
                                            </li>
                                            @if (!$contact->is_resolved)
                                                <li>
                                                    <form action="{{ route('admin.contacts.resolve', $contact->id) }}"
                                                        method="POST" class="w-full">
                                                        @csrf

                                                        <button type="submit"
                                                            class="flex items-center gap-2 w-full text-left">
                                                            <i class="ri-check-line"></i>
                                                            Đánh dấu đã giải quyết
                                                        </button>
                                                    </form>
                                                </li>
                                            @else
                                                <li>
                                                    <form action="{{ route('admin.contacts.unresolve', $contact->id) }}"
                                                        method="POST" class="w-full">
                                                        @csrf

                                                        <button type="submit"
                                                            class="flex items-center gap-2 w-full text-left">
                                                            <i class="ri-close-line"></i>
                                                            Đánh dấu chưa giải quyết
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                            <li>
                                                <button type="button"
                                                    class="text-info btn-ghost reply-email-btn flex items-center gap-2"
                                                    data-email="{{ $contact->email }}"
                                                    data-name="{{ $contact->full_name }}" data-id="{{ $contact->id }}">
                                                    <i class="ri-mail-send-line"></i>
                                                    Gửi email
                                                </button>
                                            </li>


                                            <li>
                                                <a href="tel:{{ $contact->phone }}" class="text-info">
                                                    <i class="ri-phone-line"></i>
                                                    Gọi điện
                                                </a>
                                            </li>
                                            <div class="divider my-1"></div>
                                            <li>
                                                <form action="{{ route('admin.contacts.destroy', $contact->id) }}"
                                                    id="delete-form-contacts-{{ $contact->id }}" method="POST"
                                                    class="w-full">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button data-form-id="delete-form-contacts-{{ $contact->id }}"
                                                        type="button" class="delete-btn">
                                                        <i class="ri-delete-bin-line"></i>
                                                        Xóa
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <!-- Message Detail Modal -->
                            <dialog id="viewMessage_{{ $contact->id }}" class="modal">
                                <div class="modal-box">
                                    <h3 class="font-bold text-lg mb-4">Nội dung chi tiết</h3>
                                    <div class="py-4">
                                        <p class="text-sm leading-relaxed">{{ $contact->message }}</p>
                                    </div>
                                    <div class="modal-action">
                                        <form method="dialog">
                                            <button class="btn">Đóng</button>
                                        </form>
                                    </div>
                                </div>
                                <form method="dialog" class="modal-backdrop">
                                    <button>close</button>
                                </form>
                            </dialog>

                            <!-- Detail Modal -->
                            <dialog id="viewDetails_{{ $contact->id }}" class="modal">
                                <div class="modal-box max-w-2xl">
                                    <h3 class="font-bold text-lg mb-4">Chi tiết liên hệ #{{ $contact->id }}</h3>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                        <div class="space-y-3">
                                            <div>
                                                <label class="label">
                                                    <span class="label-text font-medium">Họ tên</span>
                                                </label>
                                                <p class="text-sm">{{ $contact->full_name }}</p>
                                            </div>

                                            <div>
                                                <label class="label">
                                                    <span class="label-text font-medium">Email</span>
                                                </label>
                                                <p class="text-sm">{{ $contact->email }}</p>
                                            </div>

                                            <div>
                                                <label class="label">
                                                    <span class="label-text font-medium">Số điện thoại</span>
                                                </label>
                                                <p class="text-sm">{{ $contact->phone }}</p>
                                            </div>
                                        </div>

                                        <div class="space-y-3">
                                            <div>
                                                <label class="label">
                                                    <span class="label-text font-medium">Loại</span>
                                                </label>
                                                <div class="badge {{ $config['class'] }} badge-sm">
                                                    {{ $config['label'] }}
                                                </div>
                                            </div>

                                            <div>
                                                <label class="label">
                                                    <span class="label-text font-medium">Trạng thái</span>
                                                </label>
                                                @if ($contact->is_resolved)
                                                    <div class="badge badge-success badge-sm">Đã giải quyết</div>
                                                @else
                                                    <div class="badge badge-warning badge-sm">Chưa giải quyết</div>
                                                @endif
                                            </div>

                                            <div>
                                                <label class="label">
                                                    <span class="label-text font-medium">Thời gian gửi</span>
                                                </label>
                                                <p class="text-sm">{{ $contact->submitted_at }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="label">
                                            <span class="label-text font-medium">Nội dung</span>
                                        </label>
                                        <div class="bg-gray-50 p-4 rounded-lg">
                                            <p class="text-sm leading-relaxed">{{ $contact->message }}</p>
                                        </div>
                                    </div>

                                    <div class="modal-action">
                                        @if (!$contact->is_resolved)
                                            <form action="{{ route('admin.contacts.resolve', $contact->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success">
                                                    <i class="ri-check-line"></i>
                                                    Đánh dấu đã giải quyết
                                                </button>
                                            </form>
                                        @endif

                                        <form method="dialog">
                                            <button class="btn">Đóng</button>
                                        </form>
                                    </div>
                                </div>
                                <form method="dialog" class="modal-backdrop">
                                    <button>close</button>
                                </form>
                            </dialog>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-8">
                                    <div class="flex flex-col items-center">
                                        <i class="ri-inbox-line text-4xl text-gray-400 mb-4"></i>
                                        <p class="text-gray-500">Không có dữ liệu</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @include('admin.pages.contacts.modals')
        </div>


    </div>


@endsection
@push('customjs')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chọn tất cả nút reply
            document.querySelectorAll('.reply-email-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const email = this.dataset.email || '';
                    const name = this.dataset.name || '';
                    const id = this.dataset.id || '';

                    // Fill modal fields
                    document.getElementById('reply_contact_id').value = id;
                    document.getElementById('reply_to_email').value = email;
                    document.getElementById('reply_to_display').value = name + ' <' + email + '>';

                    // Nếu muốn thay subject mặc định theo tên
                    document.getElementById('reply_subject').value =
                        `Phản hồi từ GymTech: Trả lời ${name}`;

                    // Tùy chỉnh body mẫu (nếu cần)
                    const bodyEl = document.getElementById('reply_body');
                    if (bodyEl) {
                        bodyEl.value =
                            `Xin chào ${name},\n\nCảm ơn bạn đã gửi phản hồi tới GymTech. Chúng tôi đã nhận được phản hồi của bạn và đang xem xét. Dưới đây là phản hồi từ chúng tôi — bạn có thể chỉnh sửa trước khi gửi:\n\n[Viết nội dung ở đây...]\n\nTrân trọng,\nGymTech`;
                    }

                    // Show modal (sử dụng dialog API như bạn đang dùng)
                    const modal = document.getElementById('replyEmailModal');
                    if (modal && typeof modal.showModal === 'function') {
                        modal.showModal();
                    } else if (modal) {
                        // fallback: toggle class nếu dùng khác
                        modal.classList.add('open');
                    }
                });
            });

            // Cancel button đóng modal
            const cancelBtn = document.getElementById('reply_cancel_btn');
            if (cancelBtn) {
                cancelBtn.addEventListener('click', function() {
                    const modal = document.getElementById('replyEmailModal');
                    if (modal && typeof modal.close === 'function') modal.close();
                });
            }
        });
    </script>
@endpush
