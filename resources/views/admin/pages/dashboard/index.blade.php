@extends('admin.layouts.master')

@section('page_title', 'Bảng Điều Khiển')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="link link-hover">Admin</a></li>
    <li><a class="link link-hover">Dashboard</a></li>

@endsection



@section('content')
    <div class="max-w-6xl mx-auto p-6 space-y-8">

        {{-- Header với tiêu đề và các nút chức năng --}}
        <div class="flex flex-col lg:flex-row justify-between items-start gap-4">
            <div>
                <h1 class="text-3xl font-bold text-base-content flex items-center gap-2">
                    <i class="ri-dashboard-3-line text-primary"></i>
                    Tổng quan hôm nay
                </h1>
                <p class="text-base-content/70 mt-1">Dữ liệu được cập nhật theo thời gian thực.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-outline btn-primary">
                    <i class="ri-add-circle-line text-lg"></i> Đăng ký gói tập
                </a>
                <a href="{{ route('admin.members.create') }}" class="btn btn-primary shadow-lg">
                    <i class="ri-user-add-line text-lg"></i> Thêm Thành viên
                </a>
            </div>
        </div>

        {{-- Thống kê tổng quan --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
            <div class="stat bg-base-100 shadow-lg rounded-box border border-success/20">
                <div class="stat-figure text-success"><i class="ri-money-dollar-circle-line text-3xl"></i></div>
                <div class="stat-title">Doanh thu hôm nay</div>
                <div class="stat-value text-success">{{ number_format($todayRevenue, 0) }}
                </div>
            </div>

            <div class="stat bg-base-100 shadow-lg rounded-box border border-info/20">
                <div class="stat-figure text-info"><i class="ri-user-add-fill text-3xl"></i></div>
                <div class="stat-title">Thành viên mới</div>
                <div class="stat-value text-info">{{ $newMembersCount }}</div>
            </div>

            <div class="stat bg-base-100 shadow-lg rounded-box border border-accent/20">
                <div class="stat-figure text-accent"><i class="ri-walk-line text-3xl"></i></div>
                <div class="stat-title">Lượt Check-in</div>
                <div class="stat-value text-accent">{{ $checkinsToday }}</div>
            </div>

            <div class="stat bg-base-100 shadow-lg rounded-box border border-secondary/20">
                <div class="stat-figure text-secondary"><i class="ri-body-scan-line text-3xl"></i></div>
                <div class="stat-title">Đang có mặt</div>
                <div class="stat-value text-secondary">{{ $membersInGymCount }}</div>
            </div>

            <div class="stat bg-base-100 shadow-lg rounded-box border border-primary/20">
                <div class="stat-figure text-primary"><i class="ri-team-fill text-3xl"></i></div>
                <div class="stat-title">Tổng số Thành viên</div>
                <div class="stat-value text-primary">{{ $totalMembers }}</div>
            </div>
        </div>

        {{-- Biểu đồ thống kê --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
            <div class="lg:col-span-3 card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <h2 class="card-title flex items-center gap-2">
                            <i class="ri-line-chart-line text-primary"></i>
                            Doanh thu 7 ngày gần nhất
                        </h2>
                        {{-- Dropdown có thể giữ lại hoặc bỏ đi --}}
                    </div>
                    <div class="h-80">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title flex items-center gap-2">
                        <i class="ri-bar-chart-line text-accent"></i>
                        Lượt hoạt động 7 ngày gần nhất
                    </h2>
                    <div class="h-80">
                        <canvas id="activityChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Thành viên đang có mặt --}}
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title flex items-center gap-2">
                        <i class="ri-user-location-line text-success"></i>
                        Thành viên đang có mặt
                    </h2>
                    <div class="overflow-x-auto h-auto">
                        <table class="table table-sm datatable">
                            <thead>
                                <tr>
                                    <th>Hội viên</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($membersInGym as $checkin)
                                    <tr class="hover">
                                        <td>
                                            <div class="flex items-center gap-3">
                                                <div class="avatar">
                                                    <div class="mask mask-squircle w-12 h-12">
                                                        <img src="{{ asset($checkin->member->img ?? 'images/default-avatar.png') }}"
                                                            alt="Avatar" />
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="font-bold">{{ $checkin->member->full_name }}</div>
                                                    <div class="text-sm opacity-50">Check-in:
                                                        {{ $checkin->checkin_time->format('H:i') }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="badge badge-outline badge-success">Đang tập</div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-4">Không có hội viên nào đang tập.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            {{-- Thành viên sắp hết hạn --}}
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-warning flex items-center gap-2">Thành viên sắp hết hạn (< 3 ngày) </h2>
                            <i class="ri-alarm-warning-line"></i>
                            <div class="overflow-x-auto h-auto">
                                <table class="table table-sm datatable">
                                    <thead>
                                        <tr>
                                            <th>Hội viên</th>
                                            <th>Hạn gói tập</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($expiringMembers as $sub)
                                            <tr class="hover">
                                                <td>
                                                    <div class="flex items-center gap-3">
                                                        <div class="avatar">
                                                            <div class="mask mask-squircle w-12 h-12">
                                                                <img src="{{ asset($sub->member->img ?? 'images/default-avatar.png') }}"
                                                                    alt="Avatar" />
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="font-bold">{{ $sub->member->full_name }}</div>
                                                            <div class="text-sm opacity-50">Gói:
                                                                {{ $sub->plan->plan_name }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="font-bold text-error">Hết hạn:
                                                        {{ \Carbon\Carbon::parse($sub->end_date)->format('d/m/Y') }}</div>
                                                    <div class="text-sm text-warning">
                                                        {{ \Carbon\Carbon::parse($sub->end_date)->diffForHumans() }}

                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center py-4">Không có hội viên nào sắp hết
                                                    hạn.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                </div>
            </div>
        </div>




    </div>
@endsection


@push('customjs')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const revenueChartData = {!! json_encode($revenueChart ?? ['labels' => [], 'data' => []]) !!};
            const activityChartData = {!! json_encode($activityChart ?? ['labels' => [], 'data' => []]) !!};

            const revenueCtx = document.getElementById('revenueChart');
            if (revenueCtx) {
                new Chart(revenueCtx, {
                    type: 'line',
                    data: {
                        labels: revenueChartData.labels,
                        datasets: [{
                            label: 'Doanh thu (VNĐ)',
                            data: revenueChartData.data,

                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'hsl(var(--p))',

                            pointBorderWidth: 2,
                            pointRadius: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return new Intl.NumberFormat('vi-VN').format(value) + ' VNĐ';
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Biểu đồ Hoạt động
            const activityCtx = document.getElementById('activityChart');
            if (activityCtx) {
                new Chart(activityCtx, {
                    type: 'bar',
                    data: {
                        labels: activityChartData.labels,
                        datasets: [{
                            label: 'Lượt Check-in',
                            data: activityChartData.data,

                            borderWidth: 1,
                            borderRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        indexAxis: 'y',
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush
