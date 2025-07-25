@extends('admin.layouts.master')

@section('page_title', 'Bảng Điều Khiển')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="link link-hover">Admin</a></li>
    <li><a href="#" class="link link-hover">Tất cả gói tập</a></li>

@endsection

@section('content')
    <div class="p-6">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <h2 class="card-title text-2xl font-bold">Danh sách Gói tập</h2>
                    <a href="{{ route('admin.membership-plans.create') }}" class="btn btn-primary">
                        <i class="ri-add-line"></i> Thêm Gói tập mới
                    </a>
                </div>

                <!-- Bảng dữ liệu -->
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full datatable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên gói</th>
                                <th>Thời hạn</th>
                                <th>Giá gốc</th>
                                <th>Giảm giá</th>
                                <th>Giá cuối</th>
                                <th>Quyền lợi</th>
                                <th>Trạng thái</th>
                                <th class="no-sort">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($plans as $plan)
                                <tr>
                                    <td class="font-mono">{{ $plan->plan_id }}</td>
                                    <td class="font-semibold">{{ $plan->plan_name }}</td>
                                    <td>{{ $plan->duration_days }} ngày</td>
                                    <td>{{ number_format($plan->price, 0) }}đ</td>
                                    <td>
                                        @if ($plan->discount_percent > 0)
                                            <span class="badge badge-success">{{ $plan->discount_percent }}%</span>
                                        @else
                                            <span class="badge badge-ghost">Không</span>
                                        @endif
                                    </td>
                                    <td class="font-bold text-primary">
                                        {{ number_format($plan->price * (1 - $plan->discount_percent / 100), 0) }}đ
                                    </td>
                                    <td>
                                        <div class="tooltip" data-tip="{{ $plan->features->pluck('name')->join(', ') }}">
                                            <span class="badge badge-outline">{{ $plan->features_count }} QL</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($plan->is_active)
                                            <span class="badge badge-success badge-sm">Đang hoạt động</span>
                                        @else
                                            <span class="badge badge-error badge-sm">Đã khóa</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex items-center space-x-2">
                                            <div class="tooltip" data-tip="Chỉnh sửa">
                                                <a href="{{ route('admin.membership-plans.edit', $plan->plan_id) }}"
                                                    class="btn btn-sm btn-ghost btn-circle">
                                                    <i class="ri-edit-line text-lg text-info"></i>
                                                </a>
                                            </div>
                                            <div class="tooltip" data-tip="Xóa">
                                                <form
                                                    action="{{ route('admin.membership-plans.destroy', $plan->plan_id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa gói tập này không?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-ghost btn-circle">
                                                        <i class="ri-delete-bin-line text-lg text-error"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-8">
                                        <p>Chưa có gói tập nào. <a href="{{ route('admin.membership-plans.create') }}"
                                                class="link link-primary">Thêm ngay</a></p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
