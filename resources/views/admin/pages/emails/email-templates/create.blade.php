@extends('admin.layouts.master')

@section('content')
    <div class="p-6">
        @if (isset($template))
            <h1 class="text-3xl font-bold mb-4">Chỉnh Sửa Mẫu Email</h1>
            <form action="{{ route('admin.email-templates.update', $template->template_id) }}" method="POST">
                @method('PUT')
            @else
                <h1 class="text-3xl font-bold mb-4">Tạo Mẫu Email Mới</h1>
                <form action="{{ route('admin.email-templates.store') }}" method="POST">
        @endif

        @csrf
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Tên Mẫu (để bạn nhận biết)</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $template->name ?? '') }}"
                        required
                        class="mt-1 block w-full border @error('name') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700">Tiêu Đề Email</label>
                    <input type="text" name="subject" id="subject"
                        value="{{ old('subject', $template->subject ?? '') }}" required
                        class="mt-1 block w-full border @error('subject') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('subject')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="body" class="block text-sm font-medium text-gray-700">Nội Dung Email</label>
                    <textarea name="body" id="body" rows="15" required
                        class="mt-1 block w-full border @error('body') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('body', isset($template) ? $template->body : '') }}</textarea>
                    <p class="mt-2 text-sm text-gray-500">Sử dụng các biến: [TEN_HOI_VIEN], [NGAY_THAM_GIA]</p>
                    @error('body')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="flex justify-end pt-6 border-t mt-6">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Lưu
                    Mẫu</button>
                <a href="{{ route('admin.email-templates.index') }}"
                    class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md ml-2 hover:bg-gray-300">Hủy</a>
            </div>
        </div>
        </form>
    </div>
@endsection
