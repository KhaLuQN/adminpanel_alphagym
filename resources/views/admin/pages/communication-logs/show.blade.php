@extends('admin.layouts.master')

@section('content')
    <div class="p-6">
        <div class="card bg-base-200 shadow-xl">
            <div class="card-body">
                <div class="card-title">
                    <i class="ri-mail-open-line mr-2 text-2xl"></i>
                    <h1 class="text-2xl font-bold">Chi Tiết Email Đã Gửi</h1>
                </div>
                <div class="space-y-2">
                    <p><strong>Người nhận:</strong> {{ $log->member->full_name ?? '[Đã xóa]' }}
                        ({{ $log->member->email ?? 'N/A' }})</p>
                    <p><strong>Người gửi:</strong> {{ $log->sender->full_name ?? 'Hệ thống' }}</p>
                    <p><strong>Tên chiến dịch:</strong> {{ $log->campaign_name }}</p>
                    <p><strong>Thời gian gửi:</strong> {{ \Carbon\Carbon::parse($log->sent_at)->format('H:i:s d/m/Y') }}</p>
                    <p><strong>Trạng thái:</strong>
                        @if ($log->status == 'sent')
                            <span class="badge badge-success">Thành công</span>
                        @else
                            <span class="badge badge-error">Thất bại</span>
                        @endif
                    </p>
                    <div class="divider"></div>
                    <h5 class="text-xl font-bold">Nội dung email:</h5>
                    <div class="mockup-code  p-4 overflow-x-auto">
                        <pre><code>{!! $log->body !!}</code></pre>
                    </div>
                </div>
                <div class="card-actions justify-end">
                    <a href="{{ route('admin.communication-logs.index') }}" class="btn btn-ghost">Quay lại Danh sách</a>
                </div>
            </div>
        </div>
    </div>
@endsection
