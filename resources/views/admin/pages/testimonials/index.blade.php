@extends('admin.layouts.master')

@section('page_title', 'Bảng Điều Khiển')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="link link-hover">Admin</a></li>
    <li><a href="#" class="link link-hover">Quản lý Đánh giá</a></li>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <i class="ri-star-line text-3xl text-yellow-500"></i>
                <h1 class="text-3xl font-bold text-gray-800">Quản lý Đánh giá</h1>
            </div>
            <p class="text-gray-600">Danh sách các đánh giá từ khách hàng</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="card bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-lg">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $testimonials->count() }}</h3>
                            <p class="text-blue-100">Tổng đánh giá</p>
                        </div>
                        <i class="ri-message-3-line text-3xl opacity-80"></i>
                    </div>
                </div>
            </div>

            <div class="card bg-gradient-to-br from-green-500 to-green-600 text-white shadow-lg">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $testimonials->where('is_approved', 1)->count() }}</h3>
                            <p class="text-green-100">Đã duyệt</p>
                        </div>
                        <i class="ri-checkbox-circle-line text-3xl opacity-80"></i>
                    </div>
                </div>
            </div>

            <div class="card bg-gradient-to-br from-orange-500 to-orange-600 text-white shadow-lg">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $testimonials->where('is_approved', 0)->count() }}</h3>
                            <p class="text-orange-100">Chờ duyệt</p>
                        </div>
                        <i class="ri-time-line text-3xl opacity-80"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="card bg-white shadow-xl">
            <div class="card-body">
                <div class="flex items-center gap-3 mb-6">
                    <i class="ri-list-check-2 text-2xl text-primary"></i>
                    <h2 class="text-xl font-semibold">Danh sách Đánh giá</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="table table-zebra datatable w-full">
                        <thead>
                            <tr class="bg-base-200">
                                <th class="text-left">
                                    <i class="ri-hashtag mr-1"></i>ID
                                </th>
                                <th class="text-left">
                                    <i class="ri-user-line mr-1"></i>Khách hàng
                                </th>
                                <th class="text-left">
                                    <i class="ri-message-2-line mr-1"></i>Nội dung
                                </th>
                                <th class="text-center">
                                    <i class="ri-star-line mr-1"></i>Đánh giá
                                </th>
                                <th class="text-center">
                                    <i class="ri-image-line mr-1"></i>Ảnh
                                </th>
                                <th class="text-center">
                                    <i class="ri-shield-check-line mr-1"></i>Trạng thái
                                </th>
                                <th class="text-center">
                                    <i class="ri-calendar-line mr-1"></i>Ngày gửi
                                </th>
                                <th class="text-center">
                                    <i class="ri-settings-line mr-1"></i>Hành động
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($testimonials as $testimonial)
                                <tr class="hover:bg-base-50">
                                    <td class="font-mono text-sm">
                                        #{{ $testimonial->testimonial_id }}
                                    </td>

                                    <td>
                                        <div class="flex items-center gap-3">

                                            <div>
                                                <div class="font-semibold">{{ $testimonial->customer_name }}</div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $testimonial->member?->phone ?? 'Không có' }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="max-w-xs">
                                            <p class="text-sm line-clamp-2" id="content-{{ $testimonial->testimonial_id }}">
                                                {{ Str::limit($testimonial->testimonial_content, 80) }}
                                            </p>
                                            @if (strlen($testimonial->testimonial_content) > 80)
                                                <button class="text-primary text-xs hover:underline mt-1"
                                                    onclick="showContentModal('{{ $testimonial->testimonial_id }}', '{{ addslashes($testimonial->testimonial_content) }}', '{{ $testimonial->customer_name }}')">
                                                    <i class="ri-eye-line mr-1"></i>Xem thêm
                                                </button>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="flex justify-center items-center gap-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="ri-star-{{ $i <= $testimonial->rating ? 'fill' : 'line' }} text-yellow-400 text-sm"></i>
                                            @endfor
                                            <span class="text-sm font-semibold ml-1">({{ $testimonial->rating }})</span>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        @if ($testimonial->image_url)
                                            <div class="avatar">
                                                <div class="w-12 h-12 rounded-lg">
                                                    <img src="{{ asset($testimonial->image_url) }}" alt="Review image"
                                                        class="object-cover cursor-pointer hover:scale-105 transition-transform"
                                                        onclick="showImageModal('{{ asset($testimonial->image_url) }}')">
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-gray-400">
                                                <i class="ri-image-line text-xl"></i>
                                            </div>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if ($testimonial->is_approved)
                                            <div class="badge badge-success gap-1">
                                                <i class="ri-checkbox-circle-line text-xs"></i>
                                                Đã duyệt
                                            </div>
                                        @else
                                            <div class="badge badge-warning gap-1">
                                                <i class="ri-time-line text-xs"></i>
                                                Chờ duyệt
                                            </div>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="text-sm">
                                            <div class="font-medium">{{ $testimonial->submitted_at->format('d/m/Y') }}
                                            </div>
                                            <div class="text-gray-500">{{ $testimonial->submitted_at->format('H:i') }}
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="flex justify-center gap-2">
                                            <!-- Approve/Unapprove Button -->
                                            <form
                                                action="{{ route('admin.testimonials.approve', $testimonial->testimonial_id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="btn btn-sm {{ $testimonial->is_approved ? 'btn-outline btn-warning' : 'btn-success' }} tooltip"
                                                    data-tip="{{ $testimonial->is_approved ? 'Hủy duyệt' : 'Duyệt đánh giá' }}">
                                                    <i
                                                        class="ri-{{ $testimonial->is_approved ? 'close-circle' : 'checkbox-circle' }}-line"></i>
                                                </button>
                                            </form>

                                            <!-- Delete Button -->
                                            <form id="delete-equipment-form-{{ $testimonial->testimonial_id }}"
                                                action="{{ route('admin.testimonials.destroy', $testimonial->testimonial_id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    data-form-id="delete-equipment-form-{{ $testimonial->testimonial_id }}"
                                                    class="btn btn-sm btn-error tooltip delete-btn"
                                                    data-tip="Xóa đánh giá">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <dialog id="image_modal" class="modal">
        <div class="modal-box max-w-2xl">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="font-bold text-lg mb-4">
                <i class="ri-image-line mr-2"></i>Ảnh đánh giá
            </h3>
            <div class="flex justify-center">
                <img id="modal_image" src="" alt="Review image" class="max-w-full max-h-96 rounded-lg">
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <!-- Content Modal -->
    <dialog id="content_modal" class="modal">
        <div class="modal-box max-w-2xl">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="font-bold text-lg mb-4 flex items-center">
                <i class="ri-message-2-line mr-2 text-primary"></i>
                <span>Nội dung đánh giá từ</span>
                <span id="modal_customer_name" class="text-primary ml-2"></span>
            </h3>

            <!-- Rating in modal -->
            <div class="flex items-center gap-2 mb-4 p-3 bg-base-200 rounded-lg">
                <span class="text-sm font-medium">Đánh giá:</span>
                <div class="flex" id="modal_rating">
                    <!-- Stars will be populated by JS -->
                </div>
            </div>

            <!-- Full content -->
            <div class="max-h-96 overflow-y-auto">
                <div class="prose max-w-none">
                    <p id="modal_content" class="text-base leading-relaxed whitespace-pre-wrap"></p>
                </div>
            </div>

            <div class="modal-action">
                <form method="dialog">
                    <button class="btn btn-primary">
                        <i class="ri-close-line mr-1"></i>Đóng
                    </button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
@endsection

@push('scripts')
    <script>
        function showImageModal(imageSrc) {
            document.getElementById('modal_image').src = imageSrc;
            document.getElementById('image_modal').showModal();
        }

        function showContentModal(id, content, customerName) {
            // Set customer name
            document.getElementById('modal_customer_name').textContent = customerName;

            // Set content
            document.getElementById('modal_content').textContent = content;

            // Get rating from the table row and display in modal
            const ratingContainer = document.getElementById('modal_rating');
            const tableRow = document.querySelector(`#content-${id}`).closest('tr');
            const ratingElement = tableRow.querySelector('.ri-star-fill, .ri-star-line').closest('div');

            // Extract rating value (this is a simple approach, you might need to adjust based on your exact HTML structure)
            const ratingText = ratingElement.textContent.match(/\((\d+)\)/);
            const rating = ratingText ? parseInt(ratingText[1]) : 0;

            // Generate stars for modal
            ratingContainer.innerHTML = '';
            for (let i = 1; i <= 5; i++) {
                const star = document.createElement('i');
                star.className = `ri-star-${i <= rating ? 'fill' : 'line'} text-yellow-400`;
                ratingContainer.appendChild(star);
            }

            // Add rating text
            const ratingSpan = document.createElement('span');
            ratingSpan.className = 'text-sm font-semibold ml-2 text-gray-600';
            ratingSpan.textContent = `(${rating}/5)`;
            ratingContainer.appendChild(ratingSpan);

            // Show modal
            document.getElementById('content_modal').showModal();
        }
    </script>
@endpush
