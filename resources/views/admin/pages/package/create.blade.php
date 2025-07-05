@extends('admin.layouts.master')

@section('content')
    <div class="p-6">
        <div class="card bg-base-200 shadow-xl">
            <div class="card-body">
                <div class="card-title">
                    <i class="ri-add-box-line mr-2 text-2xl"></i>
                    <h4 class="text-2xl font-bold">THÊM GÓI TẬP</h4>
                </div>
                <form id="addPackageForm" method="POST" action="{{ route('admin.package.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label for="plan_name" class="label">
                                    <span class="label-text">Tên gói tập <span class="text-error">*</span></span>
                                </label>
                                <input type="text" name="plan_name" id="plan_name" placeholder="Nhập tên gói tập"
                                    required class="input input-bordered w-full">
                            </div>
                            <div>
                                <label for="duration_days" class="label">
                                    <span class="label-text">Số ngày hiệu lực <span class="text-error">*</span></span>
                                </label>
                                <input type="number" name="duration_days" id="duration_days" placeholder="VD: 30" required
                                    min="1" class="input input-bordered w-full">
                            </div>
                            <div>
                                <label for="price" class="label">
                                    <span class="label-text">Giá tiền (VNĐ) <span class="text-error">*</span></span>
                                </label>
                                <input type="number" name="price" id="price" placeholder="VD: 500000" required
                                    min="0" class="input input-bordered w-full">
                            </div>
                            <div>
                                <label for="discount_percent" class="label">
                                    <span class="label-text">Phần trăm giảm giá (%)</span>
                                </label>
                                <input type="number" name="discount_percent" id="discount_percent" placeholder="VD: 10"
                                    min="0" max="100" class="input input-bordered w-full">
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end mt-6 pt-6 border-t border-base-300">
                        <a href="{{ route('admin.package.index') }}" class="btn btn-ghost mr-2">Hủy bỏ</a>
                        <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
