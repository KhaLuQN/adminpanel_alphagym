@extends('admin.layouts.master')
@section('page_title', 'Bảng Điều Khiển')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="link link-hover">Admin</a></li>
    <li><a href="#" class="link link-hover">sửa hội viên </a></li>

@endsection
@section('content')
    <div class="p-6">


        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="card bg-base-200 shadow-xl mb-6">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-primary mb-2">
                                <i class="ri-user-settings-line mr-2"></i>
                                Chỉnh sửa thông tin thành viên
                            </h1>
                            <p class="text-base-content/70">Cập nhật thông tin chi tiết của thành viên</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.members.show', $member->member_id) }}"
                                class="btn btn-outline btn-info gap-2">
                                <i class="ri-eye-line"></i>
                                Xem chi tiết
                            </a>
                            <a href="{{ route('admin.members.index') }}" class="btn btn-outline btn-neutral gap-2">
                                <i class="ri-arrow-left-line"></i>
                                Quay lại
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Form -->
            <div class="card bg-base-200 shadow-xl">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.members.update', $member->member_id) }}"
                        enctype="multipart/form-data" x-data="memberEditForm()">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                            <!-- Left Column - Avatar & RFID -->
                            <div class="space-y-6">
                                <!-- Avatar Section -->
                                <div class="card bg-base-100 shadow-md">
                                    <div class="card-body">
                                        <h3 class="card-title text-lg mb-4">
                                            <i class="ri-image-line mr-2 text-primary"></i>
                                            Ảnh đại diện
                                        </h3>

                                        <div class="flex flex-col items-center space-y-4">
                                            <div class="avatar">
                                                <div
                                                    class="w-32 h-32 rounded-full ring ring-primary ring-offset-2 ring-offset-base-100">
                                                    <img id="avatarPreview"
                                                        src="{{ $member->img ? asset($member->img) : asset('images/default.png') }}"
                                                        alt="Avatar" class="object-cover" />
                                                </div>
                                            </div>

                                            <div class="w-full">
                                                <input type="file" name="img" id="avatarInput" accept="image/*"
                                                    class="file-input file-input-bordered w-full"
                                                    @change="previewImage($event)" />
                                                <div class="label">
                                                    <span class="label-text-alt text-base-content/60">
                                                        Chấp nhận: JPG, PNG, GIF (Max: 2MB)
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- RFID Section -->
                                <div class="card bg-base-100 shadow-md">
                                    <div class="card-body">
                                        <h3 class="card-title text-lg mb-4">
                                            <i class="ri-bank-card-line mr-2 text-primary"></i>
                                            Quản lý thẻ RFID
                                        </h3>

                                        <div class="space-y-4">
                                            <!-- Current RFID -->
                                            <div class="form-control">
                                                <label class="label">
                                                    <span class="label-text font-medium">Thẻ hiện tại</span>
                                                </label>
                                                <div class="flex gap-2">
                                                    <input type="text"
                                                        value="{{ $member->rfid_card_id ?? 'Chưa có thẻ' }}" disabled
                                                        class="input input-bordered flex-1 font-mono" />
                                                    @error('rfid_card_id')
                                                        <p
                                                            class="text-red-500 text-sm mt-1 @error('rfid_card_id') input-error @enderror">
                                                            {{ $message }}</p>
                                                    @enderror
                                                    @if ($member->rfid_card_id)
                                                        <div class="tooltip" data-tip="Thẻ đang hoạt động">
                                                            <span class="badge badge-success badge-lg">
                                                                <i class="ri-check-line"></i>
                                                            </span>
                                                        </div>
                                                    @else
                                                        <div class="tooltip" data-tip="Chưa có thẻ">
                                                            <span class="badge badge-warning badge-lg">
                                                                <i class="ri-alert-line"></i>
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- New RFID -->
                                            <div class="form-control">
                                                <label class="label">
                                                    <span class="label-text font-medium">Thêm/Thay đổi thẻ mới</span>
                                                </label>
                                                <div class="join w-full">
                                                    <input type="text" name="rfid_card_id" id="newRfid"
                                                        x-model="newRfidValue" placeholder="Quẹt thẻ RFID vào đây" readonly
                                                        class="input input-bordered join-item flex-1 font-mono" />
                                                    <button type="button" id="scanRfidBtn" @click="startScanRfid()"
                                                        :class="{ 'btn-success': isScanning, 'btn-primary': !isScanning }"
                                                        class="btn join-item">
                                                        <i :class="isScanning ? 'ri-stop-line' : 'ri-scan-line'"
                                                            class="mr-1"></i>
                                                        <span x-text="isScanning ? 'Dừng' : 'Quét thẻ'"></span>
                                                    </button>
                                                    <button type="button" @click="resetRfid()"
                                                        class="btn btn-outline btn-warning join-item tooltip"
                                                        data-tip="Xóa thẻ mới">
                                                        <i class="ri-refresh-line"></i>
                                                    </button>
                                                </div>
                                                <div class="label">
                                                    <span class="label-text-alt text-base-content/60">
                                                        Click "Quét thẻ" rồi đưa thẻ RFID vào đầu đọc
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- RFID Status -->
                                            <div class="alert" :class="getRfidAlertClass()" x-show="rfidMessage"
                                                x-transition>
                                                <i :class="getRfidIcon()"></i>
                                                <span x-text="rfidMessage"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Member Info -->
                            <div class="xl:col-span-2 space-y-6">
                                <!-- Basic Information -->
                                <div class="card bg-base-100 shadow-md">
                                    <div class="card-body">
                                        <h3 class="card-title text-lg mb-4">
                                            <i class="ri-user-line mr-2 text-primary"></i>
                                            Thông tin cơ bản
                                        </h3>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <!-- Full Name -->
                                            <div class="form-control">
                                                <label class="label">
                                                    <span class="label-text font-medium">
                                                        Họ và tên <span class="text-error">*</span>
                                                    </span>
                                                </label>
                                                <input type="text" name="full_name"
                                                    value="{{ old('full_name', $member->full_name) }}" required
                                                    class="input input-bordered @error('full_name') input-error @enderror"
                                                    placeholder="Nhập họ và tên đầy đủ" />
                                                @error('full_name')
                                                    <label class="label">
                                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                                    </label>
                                                @enderror
                                            </div>

                                            <!-- Phone -->
                                            <div class="form-control">
                                                <label class="label">
                                                    <span class="label-text font-medium">
                                                        Số điện thoại <span class="text-error">*</span>
                                                    </span>
                                                </label>
                                                <input type="tel" name="phone"
                                                    value="{{ old('phone', $member->phone) }}" required
                                                    class="input input-bordered @error('phone') input-error @enderror"
                                                    placeholder="Nhập số điện thoại" />
                                                @error('phone')
                                                    <label class="label">
                                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                                    </label>
                                                @enderror
                                            </div>

                                            <!-- Email -->
                                            <div class="form-control">
                                                <label class="label">
                                                    <span class="label-text font-medium">Email</span>
                                                </label>
                                                <input type="email" name="email"
                                                    value="{{ old('email', $member->email) }}"
                                                    class="input input-bordered @error('email') input-error @enderror"
                                                    placeholder="Nhập địa chỉ email" />
                                                @error('email')
                                                    <label class="label">
                                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                                    </label>
                                                @enderror
                                            </div>

                                            <!-- Status -->
                                            <div class="form-control">
                                                <label class="label">
                                                    <span class="label-text font-medium">
                                                        Trạng thái <span class="text-error">*</span>
                                                    </span>
                                                </label>
                                                <select name="status"
                                                    class="select select-bordered @error('status') select-error @enderror">
                                                    <option value="active"
                                                        {{ old('status', $member->status) == 'active' ? 'selected' : '' }}>
                                                        Đang hoạt động
                                                    </option>
                                                    <option value="expired"
                                                        {{ old('status', $member->status) == 'expired' ? 'selected' : '' }}>
                                                        Hết hạn
                                                    </option>
                                                    <option value="blocked"
                                                        {{ old('status', $member->status) == 'blocked' ? 'selected' : '' }}>
                                                        Bị khóa
                                                    </option>
                                                </select>
                                                @error('status')
                                                    <label class="label">
                                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                                    </label>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="card bg-base-100 shadow-md">
                                    <div class="card-body">
                                        <h3 class="card-title text-lg mb-4">
                                            <i class="ri-information-line mr-2 text-primary"></i>
                                            Thông tin bổ sung
                                        </h3>

                                        <div class="form-control">
                                            <label class="label">
                                                <span class="label-text font-medium">Ghi chú</span>
                                            </label>
                                            <textarea name="notes" rows="4" class="textarea textarea-bordered @error('notes') textarea-error @enderror"
                                                placeholder="Nhập ghi chú về thành viên...">{{ old('notes', $member->notes) }}</textarea>
                                            @error('notes')
                                                <label class="label">
                                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                                </label>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="card bg-base-100 shadow-md">
                                    <div class="card-body">
                                        <div class="flex flex-col sm:flex-row gap-4 justify-end">
                                            <a href="{{ route('admin.members.index') }}"
                                                class="btn btn-outline btn-neutral gap-2">
                                                <i class="ri-close-line"></i>
                                                Hủy bỏ
                                            </a>

                                            <button type="submit" class="btn btn-primary gap-2" class="ri-save-line"></>
                                                lưu
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function memberEditForm() {
            return {
                isScanning: false,

                newRfidValue: '',
                rfidMessage: '',
                scanTimeout: null,

                init() {
                    // Focus vào input RFID khi bắt đầu scan
                    document.addEventListener('keydown', this.handleKeydown.bind(this));
                },

                previewImage(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            document.getElementById('avatarPreview').src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                },

                startScanRfid() {
                    if (this.isScanning) {
                        this.stopScanRfid();
                        return;
                    }

                    this.isScanning = true;
                    this.rfidMessage = 'Đang chờ quẹt thẻ RFID...';

                    // Focus vào input để nhận dữ liệu từ RFID reader
                    const rfidInput = document.getElementById('newRfid');
                    rfidInput.removeAttribute('readonly');
                    rfidInput.focus();

                    // Tự động dừng sau 30 giây
                    this.scanTimeout = setTimeout(() => {
                        if (this.isScanning) {
                            this.stopScanRfid();
                            this.rfidMessage = 'Hết thời gian chờ. Vui lòng thử lại.';
                        }
                    }, 30000);
                },

                stopScanRfid() {
                    this.isScanning = false;
                    document.getElementById('newRfid').setAttribute('readonly', 'true');

                    if (this.scanTimeout) {
                        clearTimeout(this.scanTimeout);
                        this.scanTimeout = null;
                    }

                    if (this.newRfidValue) {
                        this.rfidMessage = 'Đã quét thành công thẻ RFID!';
                    } else {
                        this.rfidMessage = 'Đã dừng quét thẻ.';
                    }
                },

                resetRfid() {
                    this.newRfidValue = '';
                    this.rfidMessage = 'Đã xóa thông tin thẻ mới.';
                    this.stopScanRfid();
                },

                handleKeydown(event) {
                    // Nếu đang scan và nhấn Enter (thường là khi RFID reader gửi dữ liệu)
                    if (this.isScanning && event.target.id === 'newRfid' && event.key === 'Enter') {
                        event.preventDefault();
                        this.stopScanRfid();
                    }
                },

                getRfidAlertClass() {
                    if (this.rfidMessage.includes('thành công')) return 'alert-success';
                    if (this.rfidMessage.includes('chờ')) return 'alert-info';
                    if (this.rfidMessage.includes('thời gian') || this.rfidMessage.includes('lỗi')) return 'alert-error';
                    return 'alert-warning';
                },

                getRfidIcon() {
                    if (this.rfidMessage.includes('thành công')) return 'ri-check-line';
                    if (this.rfidMessage.includes('chờ')) return 'ri-time-line';
                    if (this.rfidMessage.includes('thời gian') || this.rfidMessage.includes('lỗi'))
                        return 'ri-error-warning-line';
                    return 'ri-information-line';
                },


            }
        }
    </script>
@endsection
