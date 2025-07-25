@extends('admin.layouts.master')


@section('content')
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold">Quản Lý Mẫu Email</h1>
            <a href="{{ route('admin.email-templates.create') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Tạo Mẫu Mới</a>
        </div>



        <div class="bg-white rounded-lg shadow-md">
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="w-3/12 text-left py-3 px-4 font-semibold text-sm">Tên Mẫu</th>
                                <th class="w-5/12 text-left py-3 px-4 font-semibold text-sm">Tiêu Đề</th>
                                <th class="w-2/12 text-left py-3 px-4 font-semibold text-sm">Ngày Tạo</th>
                                <th class="w-2/12 text-left py-3 px-4 font-semibold text-sm">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($templates as $template)
                                <tr class="border-b">
                                    <td class="py-3 px-4">{{ $template->name }}</td>
                                    <td class="py-3 px-4">{{ $template->subject }}</td>
                                    <td class="py-3 px-4">{{ $template->created_at->format('d/m/Y') }}</td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.email-templates.edit', $template->template_id) }}"
                                                class="bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600">Sửa</a>

                                            <form id="delete-email-form-{{ $template->template_id }}"
                                                action="{{ route('admin.email-templates.destroy', $template->template_id) }}"
                                                method="POST">

                                                @csrf
                                                @method('DELETE')


                                                <button type="button"
                                                    class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 delete-btn"
                                                    data-form-id="delete-email-form-{{ $template->template_id }}">
                                                    Xóa
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">Chưa có mẫu email nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
