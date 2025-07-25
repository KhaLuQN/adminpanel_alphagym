@extends('admin.layouts.master')
@section('page_title', 'Bảng Điều Khiển')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="link link-hover">Admin</a></li>
    <li><a href="#" class="link link-hover">Quản lý thẻ</a></li>

@endsection
@section('content')
    <div class="p-6">
        <div class="card bg-base-200 shadow-xl">
            <div class="card-body">
                <div class="card-title">
                    <i class="ri-rfid-line mr-2 text-2xl"></i>
                    <h4 class="text-2xl font-bold">QUẢN LÝ THẺ RFID THÀNH VIÊN</h4>
                </div>

                <div class="overflow-x-auto">

                    <table class="table table-zebra datatable">
                        <thead>
                            <tr>
                                <th>Mã thẻ</th>
                                <th>Tên thành viên</th>
                                <th>SĐT</th>
                                <th>Ngày tham gia</th>
                                <th>Tháng đã đóng</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                                <tr class="border-b">
                                    <td>{{ $member->rfid_card_id }}</td>
                                    <td>{{ $member->full_name }}</td>
                                    <td>{{ $member->phone }}</td>
                                    <td>
                                        @if ($member->join_date)
                                            {{ \Carbon\Carbon::parse($member->join_date)->format('d/m/Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $member->total_months_paid }}</td>
                                    <td>
                                        @if ($member->status == 'active')
                                            <span class="badge badge-success">Đang hoạt động</span>
                                        @else
                                            <span class="badge badge-error">Đã khóa</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex items-center space-x-2">
                                            @if ($member->status == 'active')
                                                <form id="lock-form-{{ $member->member_id }}"
                                                    action="{{ route('admin.rfid.update', $member->member_id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="banned">
                                                    <button type="button" class="btn btn-sm btn-warning confirm-action-btn"
                                                        data-form-id="lock-form-{{ $member->member_id }}"
                                                        data-swal-title="Khóa thẻ hội viên?"
                                                        data-swal-text="Hành động này sẽ vô hiệu hóa thẻ ra vào của hội viên {{ $member->full_name }}."
                                                        data-swal-icon="warning" data-swal-confirm-text="Khóa thẻ"
                                                        data-swal-cancel-text="Hủy" title="Khóa thẻ">
                                                        <i class="ri-lock-line"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form id="unlock-form-{{ $member->member_id }}"
                                                    action="{{ route('admin.rfid.update', $member->member_id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="active">
                                                    <button type="button" class="btn btn-sm btn-success confirm-action-btn"
                                                        data-form-id="unlock-form-{{ $member->member_id }}"
                                                        data-swal-title="Mở khóa thẻ hội viên?"
                                                        data-swal-text="Thao tác này sẽ kích hoạt lại thẻ ra vào của hội viên {{ $member->full_name }}."
                                                        data-swal-icon="question" data-swal-confirm-text="Mở khóa"
                                                        data-swal-cancel-text="Hủy" title="Mở khóa thẻ">
                                                        <i class="ri-lock-unlock-line"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('admin.rfid.destroy', $member->member_id) }}"
                                                method="POST" id="delete-form-rfid-{{ $member->member_id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button data-form-id="delete-form-rfid-{{ $member->member_id }}"
                                                    type="button" class="btn btn-sm btn-error delete-btn" title="Gỡ thẻ">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
