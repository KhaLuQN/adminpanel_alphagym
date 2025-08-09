<form action="{{ isset($trainer) ? route('admin.trainers.update', $trainer->id) : route('admin.trainers.store') }}"
    method="POST" enctype="multipart/form-data">
    @csrf
    @if (isset($trainer))
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Cột trái: Ảnh và Thông tin thành viên -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Chọn thành viên (chỉ khi tạo mới) -->
            @if (!isset($trainer))
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Chọn Hội viên <span
                                class="text-error">*</span></span></label>
                    <select name="member_id" class="select select-bordered w-full" required>
                        <option disabled selected value="">-- Chọn một hội viên --</option>
                        @foreach ($members as $member)
                            <option value="{{ $member->member_id }}"
                                {{ old('member_id') == $member->member_id ? 'selected' : '' }}>
                                {{ $member->full_name }} ({{ $member->phone }})
                            </option>
                        @endforeach
                    </select>
                    @error('member_id')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>
            @else
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Hội viên</span></label>
                    <div class="p-4 bg-base-200 rounded-lg">
                        <p class="font-bold">{{ $trainer->member->full_name }}</p>
                        <p class="text-sm">{{ $trainer->member->email }}</p>
                        <p class="text-sm">{{ $trainer->member->phone }}</p>
                    </div>
                </div>
            @endif

            <!-- Ảnh đại diện -->
            <div class="form-control">
                <label class="label"><span class="label-text font-semibold">Ảnh đại diện</span></label>
                @if (isset($trainer) && $trainer->photo_url)
                    <img id="current-photo" src="{{ asset('storage/' . $trainer->photo_url) }}" alt="Ảnh HLV"
                        class="w-full h-auto max-w-xs mx-auto rounded-lg shadow mb-4">
                @endif
                <input type="file" name="photo" class="file-input file-input-bordered w-full" />
                <label class="label">
                    @if (isset($trainer))
                        <span class="label-text-alt">Để trống nếu không muốn thay đổi ảnh.</span>
                    @endif
                </label>
                @error('photo')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Cột phải: Thông tin chuyên môn -->
        <div class="lg:col-span-2 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Chuyên môn <span
                                class="text-error">*</span></span></label>
                    <select name="specialty" class="select select-bordered w-full" required>
                        @php
                            $specialties = [
                                'Tăng cơ',
                                'Giảm cân',
                                'Yoga',
                                'Vật lý trị liệu',
                                'Dinh dưỡng thể hình',
                                'Calisthenics',
                                'Chạy bộ & Sức bền',
                            ];
                        @endphp
                        @foreach ($specialties as $specialty)
                            <option value="{{ $specialty }}"
                                {{ old('specialty', $trainer->specialty ?? '') == $specialty ? 'selected' : '' }}>
                                {{ $specialty }}
                            </option>
                        @endforeach
                    </select>
                    @error('specialty')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Số năm kinh nghiệm <span
                                class="text-error">*</span></span></label>
                    <input type="number" name="experience_years" class="input input-bordered w-full"
                        value="{{ old('experience_years', $trainer->experience_years ?? 0) }}" required>
                    @error('experience_years')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Giá mỗi buổi (VNĐ)</span></label>
                    <input type="number" name="price_per_session" class="input input-bordered w-full"
                        value="{{ old('price_per_session', $trainer->price_per_session ?? '') }}">
                    @error('price_per_session')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="form-control">
                <label class="label"><span class="label-text font-semibold">Tiểu sử</span></label>
                <textarea name="bio" class="textarea textarea-bordered w-full h-24">{{ old('bio', $trainer->bio ?? '') }}</textarea>
                @error('bio')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text font-semibold">Chứng chỉ</span></label>
                <input type="text" name="certifications" class="input input-bordered w-full"
                    value="{{ old('certifications', $trainer->certifications ?? '') }}">
                @error('certifications')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Facebook URL</span></label>
                    <input type="url" name="facebook_url" class="input input-bordered w-full"
                        value="{{ old('facebook_url', $trainer->facebook_url ?? '') }}">
                    @error('facebook_url')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text font-semibold">Instagram URL</span></label>
                    <input type="url" name="instagram_url" class="input input-bordered w-full"
                        value="{{ old('instagram_url', $trainer->instagram_url ?? '') }}">
                    @error('instagram_url')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-control">
                <label class="label"><span class="label-text font-semibold">Trạng thái</span></label>
                <div class="flex items-center">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" class="toggle toggle-success"
                        @if (old('is_active', $trainer->is_active ?? 1)) checked @endif />
                    <span class="ml-2">Hoạt động</span>
                </div>
                @error('is_active')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="flex justify-end gap-4 mt-6">
        <a href="{{ route('admin.trainers.index') }}" class="btn btn-ghost">Hủy</a>
        <button type="submit" class="btn btn-primary">
            <i class="ri-save-line"></i>
            {{ isset($trainer) ? 'Cập nhật' : 'Lưu' }} Huấn luyện viên
        </button>
    </div>
</form>
