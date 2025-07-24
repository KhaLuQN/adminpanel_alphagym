@extends('admin.layouts.master')

@section('title', 'Thêm Gói tập mới')

@section('content')
    <div class="p-6">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-2xl font-bold">Thêm Gói tập mới</h2>
                <p class="text-base-content/70 mb-6">Điền thông tin chi tiết và chọn các quyền lợi cho gói tập.</p>

                <form action="{{ route('admin.membership-plans.store') }}" method="POST">
                    @csrf

                    @include('admin.pages.plans.components._form_fields')

                    <div class="flex justify-end gap-4 mt-6">
                        <a href="{{ route('admin.membership-plans.index') }}" class="btn btn-ghost">Hủy</a>
                        <button type="submit" class="btn btn-primary">Lưu Gói tập</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
