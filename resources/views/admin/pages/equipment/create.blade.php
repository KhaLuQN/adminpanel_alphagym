@extends('admin.layouts.master')

@section('content')
    <div class="p-6">
        <div class="card bg-base-200 shadow-xl">
            <div class="card-body">
                <div class="card-title">
                    <i class="ri-add-box-line mr-2 text-2xl"></i>
                    <h4 class="text-2xl font-bold">THÊM THIẾT BỊ MỚI</h4>
                </div>
                <form action="{{ route('admin.equipment.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="label">
                                    <span class="label-text">Tên thiết bị <span class="text-error">*</span></span>
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    class="input input-bordered w-full @error('name') input-error @enderror">
                                @error('name')
                                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="purchase_date" class="label">
                                    <span class="label-text">Ngày mua <span class="text-error">*</span></span>
                                </label>
                                <input type="date" id="purchase_date" name="purchase_date"
                                    value="{{ old('purchase_date') }}"
                                    class="input input-bordered w-full @error('purchase_date') input-error @enderror">
                                @error('purchase_date')
                                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="status" class="label">
                                    <span class="label-text">Trạng thái <span class="text-error">*</span></span>
                                </label>
                                <select id="status" name="status"
                                    class="select select-bordered w-full @error('status') select-error @enderror">
                                    <option value="working" {{ old('status') == 'working' ? 'selected' : '' }}>Đang hoạt
                                        động</option>
                                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Bảo
                                        trì</option>
                                    <option value="broken" {{ old('status') == 'broken' ? 'selected' : '' }}>Hư hỏng
                                    </option>
                                </select>
                                @error('status')
                                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div>
                                <label class="label">
                                    <span class="label-text">Hình ảnh thiết bị</span>
                                </label>
                                <div class="flex items-center justify-center w-full">
                                    <label for="img"
                                        class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer bg-base-100 hover:bg-base-300">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <i class="ri-image-add-line text-4xl text-base-content"></i>
                                            <p class="mb-2 text-sm text-base-content/70"><span class="font-semibold">Click
                                                    để tải lên</span> hoặc kéo và thả</p>
                                            <p class="text-xs text-base-content/50">PNG, JPG, GIF lên đến 2MB</p>
                                        </div>
                                        <input id="img" name="img" type="file" class="hidden" accept="image/*">
                                    </label>
                                </div>
                                <img id="img-preview" src="#" alt="Ảnh xem trước"
                                    class="mt-4 max-h-60 rounded-md hidden">
                            </div>
                            <div>
                                <label for="location" class="label">
                                    <span class="label-text">Vị trí đặt thiết bị</span>
                                </label>
                                <input type="text" id="location" name="location" value="{{ old('location') }}"
                                    class="input input-bordered w-full @error('location') input-error @enderror">
                                @error('location')
                                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="notes" class="label">
                                    <span class="label-text">Ghi chú</span>
                                </label>
                                <textarea id="notes" name="notes" rows="3"
                                    class="textarea textarea-bordered w-full @error('notes') textarea-error @enderror">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end mt-6 pt-6 border-t border-base-300">
                        <a href="{{ route('admin.equipment.index') }}" class="btn btn-ghost mr-2">Hủy bỏ</a>
                        <button type="submit" class="btn btn-primary">Lưu thiết bị</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('customjs')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imgInput = document.getElementById('img');
            const imgPreview = document.getElementById('img-preview');

            imgInput.addEventListener('change', function(e) {
                const file = e.target.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imgPreview.src = e.target.result;
                        imgPreview.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    imgPreview.src = '#';
                    imgPreview.classList.add('hidden');
                }
            });
        });
    </script>
@endpush
