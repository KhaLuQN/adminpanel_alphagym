@extends('admin.layouts.master')
@section('page_title', 'Bảng Điều Khiển')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="link link-hover">Admin</a></li>
    <li><a href="#" class="link link-hover">Thanh toán</a></li>

@endsection
@section('content')
    <div class="p-6">
        <div class="card bg-base-200 shadow-xl">
            <div class="card-body">
                <div class="card-title">
                    <i class="ri-bank-card-line mr-2 text-2xl"></i>
                    <h1 class="text-2xl font-bold">Lịch Sử Thanh Toán</h1>
                </div>

                <div id="payments-list" class="overflow-x-auto">

                    <table class="table table-zebra datatable" data-order='[[0,"asc"]]'>
                        <thead>
                            <tr>
                                <th>ID Giao dịch</th>
                                <th>Hội Viên</th>
                                <th>Gói Tập</th>
                                <th>Số Tiền</th>
                                <th>Phương Thức</th>
                                <th>Trạng thái</th>
                                <th>Ngày Thanh Toán</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payments as $payment)
                                <tr>
                                    <td>{{ $payment->payment_id }}</td>
                                    <td>
                                        {{ $payment->subscription?->member?->full_name ?? '[Không xác định]' }}</td>
                                    <td>
                                        {{ $payment->subscription?->plan?->plan_name ?? '[Không xác định]' }}</td>
                                    <td>{{ number_format($payment->amount, 0, ',', '.') }} VNĐ</td>
                                    <td>
                                        @if ($payment->payment_method == 'Cash')
                                            <span class="badge badge-success">Tiền mặt</span>
                                        @elseif($payment->payment_method == 'momo')
                                            <span class="badge badge-secondary">MoMo</span>
                                        @else
                                            <span class="badge badge-info">{{ $payment->payment_method }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $payment->payment_status }}</td>
                                    <td>
                                        <div class="font-medium">
                                            {{ \Carbon\Carbon::parse($payment->payment_date)->format(' d/m/Y') }}
                                        </div>
                                        <div class="text-gray-500">
                                            {{ \Carbon\Carbon::parse($payment->payment_date)->format('H:i ') }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Không có giao dịch nào phù hợp.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
