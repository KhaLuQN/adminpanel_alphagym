@extends('admin.layouts.master')
@section('page_title', 'Bảng Điều Khiển')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="link link-hover">Admin</a></li>
    <li><a href="#" class="link link-hover">Chi tiết hội viên</a></li>

@endsection
@section('content')
    <div class="p-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- CỘT BÊN TRÁI --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- THÔNG TIN CÁ NHÂN --}}
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body items-center text-center">
                        <div class="avatar">
                            <div class="w-32 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                                <img src="{{ $member->img ? asset($member->img) : asset('images/default.png') }}"
                                    alt="Avatar thành viên" />
                            </div>
                        </div>
                        <h2 class="card-title text-2xl mt-4">{{ $member->full_name }}</h2>
                        <p class="text-base-content/70">
                            Thành viên từ {{ \Carbon\Carbon::parse($member->join_date)->format('d/m/Y') }}
                        </p>
                        {{-- Trạng thái tổng quan --}}
                        @if ($member->status === 'active')
                            <div class="badge badge-success badge-outline gap-2">
                                <i class="ri-shield-check-line"></i> Đang hoạt động
                            </div>
                        @else
                            <div class="badge badge-error badge-outline gap-2">
                                <i class="ri-shield-cross-line"></i> Đã khóa
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h3 class="card-title border-b border-base-300 pb-2">Thông tin liên hệ</h3>
                        <div class="space-y-3 mt-2 text-base">
                            <div class="flex justify-between">
                                <span class="font-semibold text-base-content/70"><i
                                        class="ri-phone-line w-4 inline-block mr-2"></i>SĐT</span>
                                <span>{{ $member->phone }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-semibold text-base-content/70"><i
                                        class="ri-mail-line w-4 inline-block mr-2"></i>Email</span>
                                <span>{{ $member->email ?? 'Chưa có' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-semibold text-base-content/70"><i
                                        class="ri-rfid-line w-4 inline-block mr-2"></i>RFID</span>
                                <span>{{ $member->rfid_card_id ?? 'Chưa có' }}</span>
                            </div>
                        </div>
                        {{-- Ghi chú --}}
                        <h3 class="card-title border-b border-base-300 pb-2 mt-4">Ghi chú</h3>
                        <p class="text-base-content/80 mt-2 italic">
                            {{ $member->notes ?? 'Không có ghi chú.' }}
                        </p>
                    </div>
                </div>

            </div>

            {{-- CỘT BÊN PHẢI --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- CÁC CHỈ SỐ THỐNG KÊ --}}
                <div class="stats shadow w-full">
                    <div class="stat">
                        <div class="stat-figure text-primary">
                            <i class="ri-walk-line text-4xl"></i>
                        </div>
                        <div class="stat-title">Tổng lượt check-in</div>
                        <div class="stat-value text-primary">{{ $totalCheckins }}</div>
                    </div>
                    <div class="stat">
                        <div class="stat-figure text-secondary">
                            <i class="ri-calendar-event-line text-4xl"></i>
                        </div>
                        <div class="stat-title">Check-in tháng này</div>
                        <div class="stat-value text-secondary">{{ $lastMonthCheckins }}</div>
                    </div>
                    <div class="stat">
                        <div class="stat-figure text-accent">
                            <i class="ri-time-line text-4xl"></i>
                        </div>
                        <div class="stat-title">Thời gian tập TB</div>
                        <div class="stat-value text-accent">
                            @if ($avgSessionTime)
                                {{ $avgSessionTime['hours'] }}h {{ $avgSessionTime['minutes'] }}m
                            @else
                                N/A
                            @endif
                        </div>
                    </div>
                </div>

                {{-- LỊCH SỬ GÓI TẬP --}}
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h3 class="card-title">Lịch sử Gói tập</h3>
                        <div class="overflow-x-auto">
                            <table class="table table-zebra datatable">
                                <thead>
                                    <tr>
                                        <th>Tên Gói tập</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($subscriptions as $sub)
                                        <tr>
                                            <td>{{ optional($sub->plan)->plan_name ?? 'N/A' }}</td>


                                            <td>{{ \Carbon\Carbon::parse($sub->start_date)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($sub->end)->format('d/m/Y') }}</td>

                                            <td>
                                                @if (now()->between($sub->start_date, $sub->end_date))
                                                    <span class="badge badge-success">Còn hạn</span>
                                                @else
                                                    <span class="badge badge-ghost">Hết hạn</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Chưa đăng ký gói tập nào.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- LỊCH SỬ CHECK-IN --}}
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div class="card-title flex justify-between items-center">
                            <h3>Lịch sử Check-in gần đây</h3>
                            <a href="{{ route('admin.checkin.index') }}?member_id={{ $member->member_id }}"
                                class="btn btn-sm btn-outline btn-info">
                                <i class="ri-history-line mr-1"></i> Xem tất cả
                            </a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="table table-zebra datatable">
                                <thead>
                                    <tr>
                                        <th>Thời gian Check-in</th>
                                        <th>Thời gian Check-out</th>
                                        <th>Tổng thời gian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($member->checkins->take(10) as $checkin)
                                        <tr>
                                            <td>{{ $checkin->checkin_time->format('H:i - d/m/Y') }}</td>
                                            <td>
                                                @if ($checkin->checkout_time)
                                                    {{ $checkin->checkout_time->format('H:i - d/m/Y') }}
                                                @else
                                                    <span class="badge badge-warning">Đang tập</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $checkin->session_duration }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Chưa có lịch sử check-in.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
