@extends('admin.layouts.master')

@section('content')
    <div class="p-6">
        <div class="card bg-base-200 shadow-xl">
            <div class="card-body">
                <div class="card-title flex justify-between items-center mb-4">
                    <h4 class="text-2xl font-bold">Danh sách gói tập</h4>
                    <a href="{{ route('admin.package.create') }}" class="btn btn-primary">
                        <i class="ri-add-line mr-1"></i> Thêm gói tập mới
                    </a>
                </div>

                {{-- Bảng DataTables mới, loại bỏ các nút sắp xếp và ô tìm kiếm thủ công --}}
                <div class="overflow-x-auto">
                    {{-- Gán id="packageTable" để DataTables khởi tạo trên bảng này --}}
                    {{-- Đảm bảo không có table-fixed hoặc w-[X%] trên table hoặc th --}}
                    <table id="packageTable" class="table table-zebra w-full datatable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên gói</th> {{-- DataTables sẽ tự động thêm icon sắp xếp khi click --}}
                                <th>Thời hạn (ngày)</th>
                                <th>Giá tiền</th>
                                <th>Giảm giá (%)</th>
                                <th>Giá sau giảm</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $package)
                                <tr class="border-b">
                                    <td class="py-3 px-4">{{ $package->plan_id }}</td>
                                    <td class="py-3 px-4">{{ $package->plan_name }}</td>
                                    <td class="py-3 px-4">{{ $package->duration_days }} ngày</td>
                                    <td class="py-3 px-4">{{ number_format($package->price) }}đ</td>
                                    <td class="py-3 px-4">
                                        @if ($package->discount_percent > 0)
                                            <span class="badge badge-success">{{ $package->discount_percent }}%</span>
                                        @else
                                            <span class="badge badge-ghost">0%</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 font-bold">
                                        @php
                                            $discountedPrice = $package->price * (1 - $package->discount_percent / 100);
                                        @endphp
                                        {{ number_format($discountedPrice) }}đ
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center space-x-2">
                                            <button class="btn btn-sm btn-info edit-package-btn"
                                                data-id="{{ $package->plan_id }}" data-name="{{ $package->plan_name }}"
                                                data-duration="{{ $package->duration_days }}"
                                                data-price="{{ $package->price }}"
                                                data-discount="{{ $package->discount_percent }}">
                                                <i class="ri-edit-line"></i>
                                            </button>
                                            <form action="{{ route('admin.package.destroy', $package->plan_id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa gói tập này không?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-error">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @include('admin.pages.package.components.editpackage')
                    </table>
                </div>
            </div>
        </div>


    </div>
@endsection
