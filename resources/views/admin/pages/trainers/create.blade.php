@extends('admin.layouts.master')


@section('page_title', 'Bảng Điều Khiển')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="link link-hover">Admin</a></li>
    <li><a href="#" class="link link-hover">Thêm huấn luyện viên</a></li>

@endsection

@section('content')
    <div class="p-6">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-2xl font-bold">Thêm Huấn luyện viên mới</h2>
                <p class="text-base-content/70 mb-6">Chọn một hội viên để gán vai trò Huấn luyện viên và điền thông tin
                    chuyên môn.</p>

                @include('admin.pages.trainers._form')

            </div>
        </div>
    </div>
@endsection
