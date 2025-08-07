@extends('admin.layouts.master')
@section('page_title', 'Bảng Điều Khiển')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="link link-hover">Admin</a></li>
    <li><a href="#" class="link link-hover">Lịch sữ ra vào</a></li>

@endsection
@section('content')
    <div class="p-6">
        <div class="card bg-base-200 shadow-xl">
            <div class="card-body">
                <div class="card-title">
                    <i class="ri-history-line mr-2 text-2xl"></i>
                    <h4 class="text-2xl font-bold">LỊCH SỬ CHECK-IN THÀNH VIÊN</h4>
                </div>

                <form method="GET" action="{{ route('admin.checkin.index') }}" data-autosubmit="true" id="filterForm">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label for="startDate" class="label">
                                <span class="label-text">Ngày bắt đầu</span>
                            </label>
                            <input type="date" id="startDate" name="start_date" value="{{ request('start_date') }}"
                                class="input input-bordered w-full">
                        </div>
                        <div>
                            <label for="endDate" class="label">
                                <span class="label-text">Ngày kết thúc</span>
                            </label>
                            <input type="date" id="endDate" name="end_date" value="{{ request('end_date') }}"
                                class="input input-bordered w-full">
                        </div>

                        <!-- Nút nhanh (Hôm nay / Tuần này / Tháng này) -->
                        <div class="md:col-span-2 flex items-end space-x-2">
                            <div class="flex items-center space-x-2">
                                <button type="button" class="btn btn-sm btn-outline" id="btnToday">Hôm nay</button>
                                <button type="button" class="btn btn-sm btn-outline" id="btnThisWeek">Tuần này</button>
                                <button type="button" class="btn btn-sm btn-outline" id="btnThisMonth">Tháng này</button>
                            </div>

                            <button type="submit" class="btn btn-primary"><i class="ri-filter-line mr-1"></i> Lọc</button>
                            <a href="{{ route('admin.checkin.index') }}" class="btn btn-ghost"><i
                                    class="ri-refresh-line mr-1"></i> Reset</a>
                        </div>
                    </div>
                </form>


                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="stat place-items-center bg-blue-500 text-white p-4 rounded-lg">
                        <div class="stat-title text-white">Tổng lượt check-in</div>
                        <div class="stat-value">{{ $checkins->total() }}</div>
                    </div>
                    <div class="stat place-items-center bg-green-500 text-white p-4 rounded-lg">
                        <div class="stat-title text-white">Đã check-out</div>
                        <div class="stat-value">{{ $checkins->where('checkout_time', '!=', null)->count() }}</div>
                    </div>
                    <div class="stat place-items-center bg-yellow-500 text-white p-4 rounded-lg">
                        <div class="stat-title text-white">Đang tập</div>
                        <div class="stat-value">{{ $checkins->where('checkout_time', null)->count() }}</div>
                    </div>
                </div>


                <div class="overflow-x-auto">


                    <table id="checkintable" class="table table-zebra w-full datatable">

                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Thành viên</th>
                                <th>Mã thẻ</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Thời gian tập</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($checkins as $index => $checkin)
                                <tr class="border-b">
                                    <td>
                                        {{ ($checkins->currentPage() - 1) * $checkins->perPage() + $index + 1 }}</td>

                                    <td>
                                        @if ($checkin->member)
                                            <a href="{{ route('admin.members.show', $checkin->member_id) }}"
                                                class="text-blue-500 font-semibold hover:underline">
                                                {{ $checkin->member->full_name }}
                                            </a>
                                        @else
                                            <span class="text-gray-500 italic">Thành viên đã xóa</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-ghost">{{ $checkin->rfid_card_id }}</span>
                                    </td>
                                    <td class="text-blue-500">
                                        {{ \Carbon\Carbon::parse($checkin->checkin_time)->format('H:i d/m/Y') }}</td>
                                    <td>
                                        @if ($checkin->checkout_time)
                                            <span class="text-green-500">
                                                {{ \Carbon\Carbon::parse($checkin->checkout_time)->format('H:i d/m/Y') }}</span>
                                        @else
                                            <span class="badge badge-warning badge-sm flex items-center justify-center">
                                                <i class="ri-run-line mr-1"></i>Đang tập
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($checkin->checkout_time)
                                            @php
                                                $checkinTime = \Carbon\Carbon::parse($checkin->checkin_time);
                                                $checkoutTime = \Carbon\Carbon::parse($checkin->checkout_time);
                                                $diff = $checkinTime->diff($checkoutTime);
                                                $hours = $diff->h + $diff->days * 24;
                                                $minutes = $diff->i;
                                            @endphp
                                            <span class="badge badge-info badge-sm">
                                                @if ($hours > 0)
                                                    {{ $hours }}h {{ $minutes }}m
                                                @else
                                                    {{ $minutes }}m
                                                @endif
                                            </span>
                                        @else
                                            <span class="text-gray-500">--</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (!$checkin->checkout_time)
                                            <form action="{{ route('admin.checkin.forceCheckout', $checkin->checkin_id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn check-out cho thành viên này?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="ri-logout-box-line mr-1"></i> Check-out
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-500">--</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 flex justify-between items-center">
                    <form action="{{ route('admin.checkin.forceCheckoutAll') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-error"
                            onclick="return confirm('Bạn có chắc chắn muốn check-out tất cả thành viên đang tập không?');">
                            <i class="ri-logout-box-line"></i> Check-out tất cả
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('customjs')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startInput = document.getElementById('startDate');
            const endInput = document.getElementById('endDate');

            // Format Date -> YYYY-MM-DD (phù hợp input[type=date])
            function toYMD(date) {
                const y = date.getFullYear();
                const m = String(date.getMonth() + 1).padStart(2, '0');
                const d = String(date.getDate()).padStart(2, '0');
                return `${y}-${m}-${d}`;
            }

            // Set inputs helper
            function setRange(startDate, endDate, {
                submit = false
            } = {}) {
                startInput.value = toYMD(startDate);
                endInput.value = toYMD(endDate);
                if (submit) {
                    // submit form nếu bạn muốn tự gửi luôn
                    document.getElementById('filterForm').submit();
                }
            }

            // Hôm nay
            document.getElementById('btnToday').addEventListener('click', function() {
                const today = new Date();
                setRange(today, today);
            });

            // Tuần này (bắt đầu Thứ Hai -> kết thúc Chủ nhật)
            document.getElementById('btnThisWeek').addEventListener('click', function() {
                const now = new Date();
                // Lấy ngày hiện tại, tìm Thứ Hai của tuần hiện tại
                // getDay(): 0=Chủ nhật, 1=Thứ hai, ... 6=Thứ bảy
                const day = now.getDay();
                // Nếu muốn tuần bắt đầu Chủ nhật, thay logic ở dưới cho phù hợp
                const diffToMonday = (day === 0) ? -6 : (1 - day); // nếu Chủ nhật -> lùi 6 ngày
                const monday = new Date(now);
                monday.setDate(now.getDate() + diffToMonday);
                const sunday = new Date(monday);
                sunday.setDate(monday.getDate() + 6);
                setRange(monday, sunday);
            });

            // Tháng này (từ ngày 1 -> cuối tháng)
            document.getElementById('btnThisMonth').addEventListener('click', function() {
                const now = new Date();
                const first = new Date(now.getFullYear(), now.getMonth(), 1);
                // cuối tháng: set ngày = 0 của tháng sau
                const last = new Date(now.getFullYear(), now.getMonth() + 1, 0);
                setRange(first, last);
            });

            // --- Tùy chọn: tự động submit khi bấm nút nhanh ---
            // Nếu bạn muốn tự submit sau khi bấm, thay chuyển submit = true ở mỗi setRange(...) phía trên
            // hoặc bật đoạn này để submit nếu bạn thêm attribute data-autosubmit="true" vào form
            const form = document.getElementById('filterForm');
            if (form && form.dataset.autosubmit === 'true') {
                // wrap các nút để submit khi bấm
                const autoButtons = ['btnToday', 'btnThisWeek', 'btnThisMonth'];
                autoButtons.forEach(id => {
                    const btn = document.getElementById(id);
                    if (!btn) return;
                    btn.addEventListener('click', () => {
                        // delay nhỏ để ensure values đã set
                        setTimeout(() => form.submit(), 50);
                    });
                });
            }
        });
    </script>
@endpush
