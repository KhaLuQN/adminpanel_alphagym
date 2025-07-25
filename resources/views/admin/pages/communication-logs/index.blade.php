@extends('admin.layouts.master')
@section('page_title', 'Bảng Điều Khiển')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="link link-hover">Admin</a></li>
    <li><a href="#" class="link link-hover">LOG</a></li>

@endsection
@section('content')
    <div class="p-6">
        <div class="card bg-base-200 shadow-xl">
            <div class="card-body">
                <div class="card-title">
                    <i class="ri-mail-send-line mr-2 text-2xl"></i>
                    <h1 class="text-2xl font-bold">Lịch Sử Gửi Email</h1>
                </div>

                <div id="email-log" class="overflow-x-auto">

                    <table class="table table-zebra w-full datatable">
                        <thead>
                            <tr>
                                <th>Người Nhận</th>
                                <th>Tên Chiến Dịch</th>
                                <th>Tiêu Đề</th>
                                <th>Người Gửi</th>
                                <th>Thời Gian Gửi</th>
                                <th>Trạng Thái</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $log)
                                <tr class="border-b">
                                    <td>{{ $log->member->full_name ?? '[Đã xóa]' }}</td>
                                    <td>{{ $log->campaign_name }}</td>
                                    <td>{{ Str::limit($log->subject, 40) }}</td>
                                    <td>{{ $log->sender->full_name ?? 'Hệ thống' }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($log->sent_at)->format('H:i d/m/Y') }}</td>
                                    <td>
                                        @if ($log->status == 'sent')
                                            <span>Thành công</span>
                                        @else
                                            <span>Thất bại</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.communication-logs.show', $log->log_id) }}"
                                            class="btn btn-sm btn-info">Xem</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">Không có lịch sử nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
