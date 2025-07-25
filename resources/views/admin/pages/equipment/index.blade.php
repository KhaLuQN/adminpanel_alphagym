@extends('admin.layouts.master')

@section('content')
    <div class="p-6">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="card-title flex justify-between items-center mb-4">
                    <div class="flex items-center">
                        <i class="ri-tools-line mr-2 text-2xl"></i>
                        <h4 class="text-2xl font-bold">QUẢN LÝ THIẾT BỊ PHÒNG GYM</h4>
                    </div>
                    <a href="{{ route('admin.equipment.create') }}" class="btn btn-primary">
                        <i class="ri-add-line mr-1"></i> Thêm thiết bị mới
                    </a>
                </div>

                <div id="equipment-list" class="overflow-x-auto">
                    <table id="equipmentTable" class="table table-zebra w-full datatable">
                        <thead>
                            <tr>
                                <th>Hình ảnh</th>
                                <th>Tên thiết bị</th>
                                <th>Ngày mua</th>
                                <th>Trạng thái</th>
                                <th>Vị trí</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($equipments as $equipment)
                                <tr class="border-b">
                                    <td>
                                        @if ($equipment->img)
                                            <div class="avatar">
                                                <div class="w-20 rounded">
                                                    <img src="{{ asset('storage/' . $equipment->img) }}"
                                                        alt="{{ $equipment->name }}">
                                                </div>
                                            </div>
                                        @else
                                            <div
                                                class="w-20 h-20 bg-base-300 flex items-center justify-center rounded-md mx-auto">
                                                <i class="ri-image-line text-3xl text-base-content opacity-50"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $equipment->name }}</td>
                                    <td>{{ $equipment->purchase_date->format('d/m/Y') }}</td>
                                    <td>
                                        @if ($equipment->status == 'working')
                                            <span class="badge badge-success">Đang hoạt động</span>
                                        @elseif($equipment->status == 'maintenance')
                                            <span class="badge badge-warning">Bảo trì</span>
                                        @else
                                            <span class="badge badge-error">Hư hỏng</span>
                                        @endif
                                    </td>
                                    <td>{{ $equipment->location ?? 'Chưa xác định' }}</td>
                                    <td>
                                        <div class="flex items-center space-x-2">
                                            <button type="button"
                                                class="btn btn-sm btn-ghost btn-circle btn-open-edit-modal"
                                                data-id="{{ $equipment->id }}" data-name="{{ $equipment->name }}"
                                                data-purchase_date="{{ $equipment->purchase_date->format('Y-m-d') }}"
                                                data-status="{{ $equipment->status }}"
                                                data-location="{{ $equipment->location }}"
                                                data-notes="{{ $equipment->notes }}"
                                                data-img="{{ asset('storage/' . $equipment->img) }}">
                                                <i class="ri-edit-line text-lg text-info"></i>
                                            </button>

                                            <form id="delete-equipment-form-{{ $equipment->id }}"
                                                action="{{ route('admin.equipment.destroy', $equipment->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button data-form-id="delete-equipment-form-{{ $equipment->id }}"
                                                    type="button" class="btn btn-sm btn-ghost btn-circle delete-btn">
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

    @include('admin.pages.equipment.components.edit')
@endsection
