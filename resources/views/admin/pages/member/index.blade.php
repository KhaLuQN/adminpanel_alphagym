@extends('admin.layouts.master')

@section('content')
    <div class="p-6">
        <div class="card bg-base-200 shadow-xl">
            <div class="card-body">
                <div class="card-title flex justify-between items-center mb-4">
                    <h4 class="text-2xl font-bold">Danh sách thành viên</h4>
                    <a href="{{ route('admin.members.create') }}" class="btn btn-primary">
                        <i class="ri-user-add-line mr-1"></i> Thêm thành viên
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="table table-zebra datatable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ảnh</th>
                                <th>Họ tên</th>
                                <th>SĐT</th>

                                <th>Mã thẻ</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($members as $member)
                                <tr data-status="{{ $member->status }}">
                                    <td>{{ $member->member_id }}</td>
                                    <td>
                                        <div class="avatar">
                                            <div class="w-10 h-10 rounded-full">

                                                <img src="{{ $member->img ? asset($member->img) : asset('images/default.png') }}"
                                                    alt="image">
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $member->full_name }}</td>
                                    <td>{{ $member->phone }}</td>



                                    <td>{{ $member->rfid_card_id }}</td>
                                    <td>
                                        @if ($member->status === 'active')
                                            <span class="badge badge-success">Đang hoạt động</span>
                                        @elseif($member->status === 'expired')
                                            <span class="badge badge-warning">Hết hạn</span>
                                        @else
                                            <span class="badge badge-error">Đã khóa</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex items-center space-x-2">

                                            <a href="{{ route('admin.members.show', $member->member_id) }}"
                                                class="btn btn-sm btn-outline btn-info">
                                                Chi tiết
                                            </a>
                                            <button class="btn btn-sm btn-info edit-member-btn"
                                                data-id="{{ $member->member_id }}" data-name="{{ $member->full_name }}"
                                                data-phone="{{ $member->phone }}" data-email="{{ $member->email }}"
                                                data-image="{{ $member->img ? asset($member->img) : asset('images/default.png') }}"
                                                data-notes="{{ $member->notes }}" data-rfid="{{ $member->rfid_card_id }}"
                                                data-status="{{ $member->status }}">
                                                <i class="ri-edit-line"></i>
                                            </button>

                                            <form action="{{ route('admin.members.destroy', $member->member_id) }}"
                                                method="POST" id="delete-member-form-{{ $member->member_id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-error delete-btn"
                                                    data-form-id="delete-member-form-{{ $member->member_id }}">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        @include('admin.pages.member.components.editmember')
                    </table>
                </div>



            </div>
        </div>
    </div>
@endsection
@push('customjs')
    @vite('resources/js/delete-confirmation.js')
@endpush
