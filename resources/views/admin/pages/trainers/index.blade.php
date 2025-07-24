@extends('admin.layouts.master')

@section('title', 'Quản lý Huấn luyện viên')

@section('content')
    <div class="p-6">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <h2 class="card-title text-2xl font-bold">Danh sách Huấn luyện viên</h2>
                    <a href="{{ route('admin.trainers.create') }}" class="btn btn-primary">
                        <i class="ri-add-line"></i> Thêm HLV
                    </a>
                </div>

                <!-- Bảng dữ liệu -->
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full datatable">
                        <thead>
                            <tr>
                                <th>Ảnh</th>
                                <th>Họ tên</th>
                                <th>Chuyên môn</th>
                                <th>Kinh nghiệm</th>
                                <th>Trạng thái</th>
                                <th class="no-sort">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainers as $trainer)
                                <tr>
                                    <td>
                                        <div class="avatar">
                                            <div class="w-12 rounded-full">

                                                <img src="{{ asset('storage/images/trainers/trainer.jpg') }}"
                                                    alt="Ảnh HLV">


                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-bold">{{ $trainer->member->full_name }}</div>
                                        <div class="text-sm opacity-50">{{ $trainer->member->phone }}</div>
                                    </td>
                                    <td>
                                        <div class="badge badge-info badge-outline">{{ $trainer->specialty }}</div>
                                    </td>
                                    <td>{{ $trainer->experience_years }} năm</td>
                                    <td><span class="badge badge-success">Đang hoạt động</span></td>
                                    <td>
                                        <div class="flex items-center space-x-2">
                                            <button type="button" class="btn btn-sm btn-info edit-trainer-btn"
                                                data-id="{{ $trainer->id }}" data-specialty="{{ $trainer->specialty }}"
                                                data-experience="{{ $trainer->experience_years }}"
                                                data-bio="{{ $trainer->bio }}"
                                                data-certifications="{{ $trainer->certifications }}"
                                                data-facebook="{{ $trainer->facebook_url }}"
                                                data-instagram="{{ $trainer->instagram_url }}"
                                                data-photo="{{ $trainer->photo_url }}"
                                                data-name="{{ $trainer->member->full_name }}"
                                                data-update-url="{{ route('admin.trainers.update', $trainer->id) }}">
                                                <i class="ri-edit-line"></i>
                                            </button>

                                            <form action="{{ route('admin.trainers.destroy', $trainer->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa HLV này?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-ghost btn-circle">
                                                    <i class="ri-delete-bin-line text-lg text-error"></i>
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

    {{-- Include Modal Chỉnh sửa --}}
    @include('admin.pages.trainers.components.edit')
@endsection

@push('scripts')
    <script>
        function editTrainerModal() {
            return {
                trainer: {},
                member: {},
                updateUrl: '',
                openModal(event) {
                    const button = event.currentTarget;
                    this.trainer = JSON.parse(button.dataset.trainer);
                    this.member = JSON.parse(button.dataset.member);
                    this.updateUrl = button.dataset.updateUrl;

                    // Cập nhật action của form
                    const form = document.getElementById('editTrainerForm');
                    form.action = this.updateUrl;

                    // Điền dữ liệu vào các trường
                    document.getElementById('edit-specialty').value = this.trainer.specialty;
                    document.getElementById('edit-experience_years').value = this.trainer.experience_years;
                    document.getElementById('edit-bio').value = this.trainer.bio;
                    document.getElementById('edit-certifications').value = this.trainer.certifications;
                    document.getElementById('edit-facebook_url').value = this.trainer.facebook_url;
                    document.getElementById('edit-instagram_url').value = this.trainer.instagram_url;
                    document.getElementById('current-photo').src = this.trainer.photo_url;
                }
            }
        }
        document.addEventListener('alpine:init', () => {
            Alpine.data('editTrainerModal', editTrainerModal);
        });
    </script>
@endpush
