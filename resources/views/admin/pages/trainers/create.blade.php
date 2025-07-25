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

                <form action="{{ route('admin.trainers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-control mb-4">
                        <label class="label"><span class="label-text font-semibold">Chọn Hội viên <span
                                    class="text-error">*</span></span></label>
                        <select name="member_id" class="select select-bordered w-full" required>
                            <option disabled selected value="">-- Chọn một hội viên --</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->member_id }}">{{ $member->full_name }} ({{ $member->phone }})
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                        <!-- Cột ảnh -->
                        <div class="md:col-span-1">
                            <label class="label"><span class="label-text font-semibold">Ảnh đại diện</span></label>
                            @if (isset($isEdit))
                                <img id="current-photo" src="" alt="Ảnh HLV" class="w-full rounded-lg shadow mb-4">
                            @endif
                            <input type="file" name="photo" class="file-input file-input-bordered w-full" />
                        </div>

                        <!-- Cột thông tin -->
                        <div class="md:col-span-2 space-y-4">
                            <div>
                                <label class="label"><span class="label-text font-semibold">Chuyên môn <span
                                            class="text-error">*</span></span></label>
                                <select name="specialty" id="edit-specialty" class="select select-bordered w-full" required>
                                    <option value="Tăng cơ">Tăng cơ</option>
                                    <option value="Giảm cân">Giảm cân</option>
                                    <option value="Yoga">Yoga</option>
                                    <option value="Vật lý trị liệu">Vật lý trị liệu</option>
                                    <option value="Dinh dưỡng thể hình">Dinh dưỡng thể hình</option>
                                    <option value="Calisthenics">Calisthenics</option>
                                    <option value="Chạy bộ & Sức bền">Chạy bộ & Sức bền</option>
                                </select>
                            </div>
                            <div>
                                <label class="label"><span class="label-text font-semibold">Số năm kinh nghiệm <span
                                            class="text-error">*</span></span></label>
                                <input type="number" name="experience_years" id="edit-experience_years"
                                    class="input input-bordered w-full" value="0" required>
                            </div>
                            <div>
                                <label class="label"><span class="label-text font-semibold">Tiểu sử</span></label>
                                <textarea name="bio" id="edit-bio" class="textarea textarea-bordered w-full h-24"></textarea>
                            </div>
                            <div>
                                <label class="label"><span class="label-text font-semibold">Chứng chỉ</span></label>
                                <input type="text" name="certifications" id="edit-certifications"
                                    class="input input-bordered w-full">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="label"><span class="label-text font-semibold">Facebook URL</span></label>
                                    <input type="url" name="facebook_url" id="edit-facebook_url"
                                        class="input input-bordered w-full">
                                </div>
                                <div>
                                    <label class="label"><span class="label-text font-semibold">Instagram
                                            URL</span></label>
                                    <input type="url" name="instagram_url" id="edit-instagram_url"
                                        class="input input-bordered w-full">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 mt-6">
                        <a href="{{ route('admin.trainers.index') }}" class="btn btn-ghost">Hủy</a>
                        <button type="submit" class="btn btn-primary">Lưu Huấn luyện viên</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
