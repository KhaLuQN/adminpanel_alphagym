@extends('admin.layouts.master')

@section('page_title', 'Bảng Điều Khiển')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="link link-hover">Admin</a></li>
    <li><a href="#" class="link link-hover">Chỉnh sửa huấn luyện viên</a></li>

@endsection

@section('content')
    <div class="p-6">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-2xl font-bold">Chỉnh sửa Huấn luyện viên: {{ $trainer->member->full_name }}</h2>
                <p class="text-base-content/70 mb-6">Cập nhật thông tin chuyên môn của huấn luyện viên.</p>

                @include('admin.pages.trainers._form', ['trainer' => $trainer])

            </div>
        </div>
    </div>
@endsection
