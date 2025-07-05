@extends('admin.layouts.master')

@section('content')
    <div class="p-6">
        <div class="card bg-base-200 shadow-xl">
            <div class="card-body">
                <div class="card-title">
                    <i class="ri-user-add-line mr-2 text-2xl"></i>
                    <h4 class="text-2xl font-bold">THÊM THÀNH VIÊN MỚI</h4>
                </div>
                <form id="addMemberForm" method="POST" action="{{ route('admin.members.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                                <label for="memberName" class="label">
                                    <span class="label-text">Họ tên <span class="text-error">*</span></span>
                                </label>
                                <input type="text" name="full_name" value="{{ old('full_name') }}" id="memberName"
                                    placeholder="Nhập họ tên đầy đủ"
                                    class="input input-bordered w-full @error('full_name') input-error @enderror">
                                @error('full_name')
                                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="memberPhone" class="label">
                                    <span class="label-text">Số điện thoại <span class="text-error">*</span></span>
                                </label>
                                <label class="input-group">
                                    <span><i class="ri-phone-line"></i></span>
                                    <input type="tel" name="phone" value="{{ old('phone') }}" id="memberPhone"
                                        placeholder="Nhập số điện thoại"
                                        class="input input-bordered w-full @error('phone') input-error @enderror">
                                </label>
                                @error('phone')
                                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="memberEmail" class="label">
                                    <span class="label-text">Email</span>
                                </label>
                                <label class="input-group">
                                    <span><i class="ri-mail-line"></i></span>
                                    <input type="email" name="email" value="{{ old('email') }}" id="memberEmail"
                                        placeholder="Nhập email (nếu có)"
                                        class="input input-bordered w-full @error('email') input-error @enderror">
                                </label>
                                @error('email')
                                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="memberNotes" class="label">
                                    <span class="label-text">Ghi chú</span>
                                </label>
                                <textarea id="memberNotes" name="notes" rows="3" placeholder="Nhập ghi chú (nếu cần)"
                                    class="textarea textarea-bordered w-full @error('notes') textarea-error @enderror">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div>
                                <label class="label">
                                    <span class="label-text">Ảnh đại diện</span>
                                </label>
                                <div class="text-center p-4 border-2 border-dashed rounded-md border-base-300">
                                    <div id="avatarPreview" class="{{ old('img') ? 'block' : 'hidden' }}">
                                        <img id="previewImage" src="{{ old('img') ? asset(old('img')) : '#' }}"
                                            alt="Avatar Preview"
                                            class="w-24 h-24 mx-auto rounded-full object-cover shadow-md">
                                    </div>
                                    <div id="avatarPlaceholder"
                                        class="w-24 h-24 mx-auto rounded-full bg-base-100 flex items-center justify-center {{ old('img') ? 'hidden' : 'block' }}">
                                        <i class="ri-user-line text-4xl text-base-content"></i>
                                    </div>
                                    <div class="mt-4">
                                        <label for="memberAvatar" class="btn btn-outline btn-sm">
                                            <span>Tải ảnh lên</span>
                                            <input id="memberAvatar" name="img" type="file" class="hidden"
                                                accept="image/*">
                                        </label>
                                        <p class="text-xs text-base-content/70 mt-1">Ảnh JPG/PNG, tối đa 2MB</p>
                                    </div>
                                    @error('img')
                                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label class="label">
                                    <span class="label-text">Thẻ RFID</span>
                                </label>
                                <div class="card bg-base-100 shadow-md">
                                    <div class="card-body">
                                        <div class="form-control">
                                            <label class="label">
                                                <span class="label-text">Mã thẻ RFID</span>
                                            </label>
                                            <div class="join">
                                                <input type="text" name="rfid_card_id" id="memberRfid"
                                                    placeholder="Quẹt thẻ RFID" value="{{ old('rfid_card_id') }}" readonly
                                                    class="input input-bordered join-item w-full @error('rfid_card_id') input-error @enderror">
                                                <button type="button" id="scanRfidBtn" class="btn btn-primary join-item">
                                                    <i class="ri-rss-line mr-1"></i> Quét
                                                </button>
                                            </div>
                                            <p class="text-xs text-base-content/70 mt-1">Nhấn nút quét và đưa thẻ vào đầu
                                                đọc</p>
                                            @error('rfid_card_id')
                                                <p class="text-error text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end mt-6 pt-6 border-t border-base-300">
                        <a href="{{ route('admin.members.index') }}" class="btn btn-ghost mr-2">Hủy bỏ</a>
                        <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('customjs')
    <script>
        // Xử lý hiển thị ảnh preview khi chọn file
        document.getElementById('memberAvatar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('previewImage').src = event.target.result;
                    document.getElementById('avatarPreview').classList.remove('hidden');
                    document.getElementById('avatarPlaceholder').classList.add('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('previewImage').src = '#';
                document.getElementById('avatarPreview').classList.add('hidden');
                document.getElementById('avatarPlaceholder').classList.remove('hidden');
            }
        });

        // Xử lý quét thẻ RFID
        let isScanning = false;
        document.getElementById('scanRfidBtn').addEventListener('click', function() {
            isScanning = true;
            const rfidInput = document.getElementById('memberRfid');
            rfidInput.placeholder = 'Đang chờ quét thẻ...';
            this.innerHTML = '<i class="ri-loader-4-line animate-spin mr-1"></i> Đang quét';
            this.disabled = true;

            // Timeout sau 30 giây nếu không quét được
            setTimeout(() => {
                if (isScanning) {
                    isScanning = false;
                    rfidInput.placeholder = 'Quẹt thẻ RFID';
                    this.innerHTML = '<i class="ri-rss-line mr-1"></i> Quét';
                    this.disabled = false;
                    alert('Không nhận được tín hiệu thẻ. Vui lòng thử lại.');
                }
            }, 30000);
        });

        // Giả lập nhận tín hiệu từ đầu đọc RFID (bàn phím)
        document.addEventListener('keypress', function(e) {
            if (isScanning) {
                const rfidInput = document.getElementById('memberRfid');

                // Giả sử kết thúc bằng Enter (có thể điều chỉnh theo thiết bị thực tế)
                if (e.key === 'Enter') {
                    isScanning = false;
                    document.getElementById('scanRfidBtn').innerHTML = '<i class="ri-rss-line mr-1"></i> Quét';
                    document.getElementById('scanRfidBtn').disabled = false;

                    // Xử lý dữ liệu thẻ ở đây (có thể validate hoặc gửi AJAX kiểm tra)
                    console.log('RFID scanned:', rfidInput.value);
                } else {
                    // Thêm ký tự vào input
                    rfidInput.value += e.key;
                }
            }
        });
    </script>
@endpush
