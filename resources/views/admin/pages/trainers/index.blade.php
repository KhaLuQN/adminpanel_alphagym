@extends('admin.layouts.master')

@section('page_title', 'Bảng Điều Khiển')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="link link-hover">Admin</a></li>
    <li><a href="#" class="link link-hover">Quản lý huấn luyện viên</a></li>

@endsection

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

                                                <img src="{{ asset('storage/' . $trainer->photo_url) }}" alt="Ảnh HLV">


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
                                            <a href="{{ route('admin.trainers.edit', $trainer->id) }}" class="btn btn-sm btn-info">
                                                <i class="ri-edit-line"></i>
                                            </a>

                                            <form action="{{ route('admin.trainers.destroy', $trainer->id) }}"
                                                method="POST"
                                                class="delete-form">
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

    
@endsection


