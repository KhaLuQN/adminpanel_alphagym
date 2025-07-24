@extends('admin.layouts.master')

@section('title', 'Chỉnh sửa Gói tập')

@section('content')
    <div class="p-6">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-2xl font-bold">Chỉnh sửa: {{ $membershipPlan->plan_name }}</h2>

                <form action="{{ route('admin.membership-plans.update', $membershipPlan->plan_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Include form fields partial --}}
                    @include('admin.pages.plans.components._form_fields', ['plan' => $membershipPlan])

                    <div class="flex justify-end gap-4 mt-6">
                        <a href="{{ route('admin.membership-plans.index') }}" class="btn btn-ghost">Hủy</a>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
