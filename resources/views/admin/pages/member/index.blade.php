@extends('admin.layouts.master')
@section('page_title', 'Bảng Điều Khiển')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="link link-hover">Admin</a></li>
    <li><a href="#" class="link link-hover">Tất cả hội viên</a></li>

@endsection
@section('content')
    <div class="p-6">
        <div class="card bg-base-200 shadow-xl">
            <div class="card-body">
                <!-- Header -->
                <div class="card-title flex justify-between items-center mb-6">
                    <div>
                        <h4 class="text-3xl font-bold text-primary">Danh sách thành viên</h4>
                        <p class="text-base-content/70 mt-1">Quản lý thông tin các thành viên trong hệ thống</p>
                    </div>
                    <a href="{{ route('admin.members.create') }}"
                        class="btn btn-primary btn-lg gap-2 shadow-lg hover:shadow-xl transition-all">
                        <i class="ri-user-add-line text-lg"></i>
                        Thêm thành viên
                    </a>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="stat bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg shadow-lg">
                        <div class="stat-figure">
                            <i class="ri-user-check-line text-2xl opacity-70"></i>
                        </div>
                        <div class="stat-title text-green-100">Đang hoạt động</div>
                        <div class="stat-value text-2xl">{{ $members->where('status', 'active')->count() }}</div>
                    </div>

                    <div class="stat bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-lg shadow-lg">
                        <div class="stat-figure">
                            <i class="ri-user-unfollow-line text-2xl opacity-70"></i>
                        </div>
                        <div class="stat-title text-yellow-100">Hết hạn</div>
                        <div class="stat-value text-2xl">{{ $members->where('status', 'expired')->count() }}</div>
                    </div>

                    <div class="stat bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg shadow-lg">
                        <div class="stat-figure">
                            <i class="ri-user-forbid-line text-2xl opacity-70"></i>
                        </div>
                        <div class="stat-title text-red-100">Đã khóa</div>
                        <div class="stat-value text-2xl">{{ $members->where('status', 'blocked')->count() }}</div>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto bg-base-100 rounded-lg shadow-inner">
                    <table class="table table-zebra datatable w-full">
                        <thead>
                            <tr class="bg-base-300 text-base-content">
                                <th class="font-bold text-center">
                                    <i class="ri-hashtag mr-1"></i>ID
                                </th>
                                <th class="font-bold text-center">
                                    <i class="ri-image-line mr-1"></i>Ảnh
                                </th>
                                <th class="font-bold">
                                    <i class="ri-user-line mr-1"></i>Họ tên
                                </th>
                                <th class="font-bold">
                                    <i class="ri-phone-line mr-1"></i>SĐT
                                </th>
                                <th class="font-bold">
                                    <i class="ri-mail-line mr-1"></i>Email
                                </th>
                                <th class="font-bold text-center">
                                    <i class="ri-bank-card-line mr-1"></i>Mã thẻ
                                </th>
                                <th class="font-bold text-center">
                                    <i class="ri-signal-tower-line mr-1"></i>Trạng thái
                                </th>
                                <th class="font-bold text-center">
                                    <i class="ri-settings-line mr-1"></i>Thao tác
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                                <tr data-status="{{ $member->status }}" class="hover:bg-base-200/50 transition-colors">
                                    <td class="text-center font-medium">
                                        <span class="badge badge-outline">{{ $member->member_id }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="avatar">
                                            <div
                                                class="w-12 h-12 rounded-full ring ring-primary ring-offset-2 ring-offset-base-100">
                                                <img src="{{ $member->img ? asset($member->img) : asset('images/default.png') }}"
                                                    alt="Avatar của {{ $member->full_name }}" class="object-cover">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center space-x-3">
                                            <div>
                                                <a href="{{ route('admin.members.show', $member->member_id) }}"
                                                    class="font-bold text-base-content hover:text-primary transition-colors">
                                                    {{ $member->full_name }}
                                                </a>
                                                @if ($member->notes)
                                                    <div class="text-sm text-base-content/60 mt-1">
                                                        <i
                                                            class="ri-information-line mr-1"></i>{{ Str::limit($member->notes, 30) }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center">
                                            <i class="ri-phone-line mr-2 text-base-content/60"></i>
                                            <span class="font-medium">{{ $member->phone }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center">
                                            <i class="ri-mail-line mr-2 text-base-content/60"></i>
                                            <span class="font-medium">{{ $member->email }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if ($member->rfid_card_id)
                                            <span
                                                class="badge badge-accent badge-lg font-mono">{{ $member->rfid_card_id }}</span>
                                        @else
                                            <span class="badge badge-ghost">Chưa có</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($member->status === 'active')
                                            <div class="badge badge-success gap-1 font-medium">
                                                <i class="ri-check-line text-sm"></i>
                                                Đang hoạt động
                                            </div>
                                        @elseif($member->status === 'expired')
                                            <div class="badge badge-warning gap-1 font-medium">
                                                <i class="ri-time-line text-sm"></i>
                                                Hết hạn
                                            </div>
                                        @else
                                            <div class="badge badge-error gap-1 font-medium">
                                                <i class="ri-close-line text-sm"></i>
                                                Đã khóa
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex items-center justify-center space-x-2">
                                            <!-- Nút xem chi tiết -->
                                            <div class="tooltip" data-tip="Xem chi tiết">
                                                <a href="{{ route('admin.members.show', $member->member_id) }}"
                                                    class="btn btn-sm btn-circle btn-outline btn-info hover:scale-110 transition-transform">
                                                    <i class="ri-eye-line text-base"></i>
                                                </a>
                                            </div>

                                            <!-- Nút sửa -->
                                            <div class="tooltip" data-tip="Chỉnh sửa">
                                                <a href="{{ route('admin.members.edit', $member->member_id) }}"
                                                    class="btn btn-sm btn-circle btn-outline btn-warning hover:scale-110 transition-transform">
                                                    <i class="ri-edit-line text-base"></i>
                                                </a>
                                            </div>

                                            <!-- Nút xóa -->
                                            <div class="tooltip" data-tip="Xóa thành viên">
                                                <form action="{{ route('admin.members.destroy', $member->member_id) }}"
                                                    method="POST" id="delete-member-form-{{ $member->member_id }}"
                                                    class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="btn btn-sm btn-circle btn-outline btn-error delete-btn hover:scale-110 transition-transform"
                                                        data-form-id="delete-member-form-{{ $member->member_id }}">
                                                        <i class="ri-delete-bin-line text-base"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Empty state -->
                @if ($members->isEmpty())
                    <div class="text-center py-12">
                        <div class="mb-4">
                            <i class="ri-user-line text-6xl text-base-content/20"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-base-content/70 mb-2">Chưa có thành viên nào</h3>
                        <p class="text-base-content/50 mb-4">Hãy thêm thành viên đầu tiên vào hệ thống</p>
                        <a href="{{ route('admin.members.create') }}" class="btn btn-primary">
                            <i class="ri-user-add-line mr-2"></i>
                            Thêm thành viên ngay
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
