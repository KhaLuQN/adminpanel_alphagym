@extends('admin.layouts.master')

@section('page_title', 'BÁO CÁO & THỐNG KÊ')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="link link-hover">Admin</a></li>
    <li><a href="#" class="link link-hover">Báo cáo và thống kê</a></li>

@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Báo cáo & Thống kê</h1>

        <div class="card bg-base-100 shadow-xl mb-6">
            <div class="card-body">
                <h2 class="card-title">Bộ lọc thời gian</h2>
                <form method="GET" action="{{ route('admin.reports.index') }}"
                    class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Ngày bắt đầu</span></label>
                        <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                            class="input input-bordered w-full" />
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Ngày kết thúc</span></label>
                        <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                            class="input input-bordered w-full" />
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Chọn nhanh</span></label>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" onclick="setThisWeek()" class="btn btn-outline btn-sm">Tuần này</button>
                            <button type="button" onclick="setThisMonth()" class="btn btn-outline btn-sm">Tháng
                                này</button>
                            <button type="button" onclick="setThisYear()" class="btn btn-outline btn-sm">Năm nay</button>
                        </div>
                    </div>
                    <div class="form-control">
                        <label class="label invisible"><span class="label-text">Lọc</span></label>
                        <button type="submit" class="btn btn-primary">Lọc</button>
                    </div>
                </form>

            </div>
        </div>

        <div role="tablist" class="tabs tabs-lifted">
            <input type="radio" name="report_tabs" role="tab" class="tab" aria-label="Doanh thu" checked />
            <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
                @include('admin.pages.reports.partials.revenue')
            </div>

            <input type="radio" name="report_tabs" role="tab" class="tab" aria-label="Hội viên" />
            <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
                @include('admin.pages.reports.partials.member')
            </div>

            <input type="radio" name="report_tabs" role="tab" class="tab" aria-label="Hoạt động" />
            <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
                @include('admin.pages.reports.partials.activity')
            </div>
        </div>
    </div>
@endsection
<script>
    function formatDate(date) {
        return date.toISOString().split('T')[0];
    }

    function setThisWeek() {
        const today = new Date();
        const dayOfWeek = today.getDay(); // 0 (CN) đến 6 (T7)

        // Lùi về Thứ Hai
        const diffToMonday = dayOfWeek === 0 ? -6 : 1 - dayOfWeek;
        const monday = new Date(today);
        monday.setDate(today.getDate() + diffToMonday);

        // Tính Chủ Nhật
        const sunday = new Date(monday);
        sunday.setDate(monday.getDate() + 6);

        document.getElementById('start_date').value = formatDate(monday);
        document.getElementById('end_date').value = formatDate(sunday);
    }


    function setThisMonth() {
        const now = new Date();
        const firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
        const lastDay = new Date(now.getFullYear(), now.getMonth() + 1,
            0); // Ngày 0 của tháng sau = ngày cuối tháng này

        document.getElementById('start_date').value = formatDate(firstDay);
        document.getElementById('end_date').value = formatDate(lastDay);
    }


    function setThisYear() {
        const now = new Date();
        const firstDay = new Date(now.getFullYear(), 0, 1);
        const lastDay = new Date(now.getFullYear(), 11, 31);

        document.getElementById('start_date').value = formatDate(firstDay);
        document.getElementById('end_date').value = formatDate(lastDay);
    }
</script>
@push('customjs')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Revenue Trend Chart
            var ctxRevenueTrend = document.getElementById('revenueTrendChart')?.getContext('2d');
            if (ctxRevenueTrend) {
                new Chart(ctxRevenueTrend, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($revenueReport['revenueTrend']->pluck('date')) !!},
                        datasets: [{
                            label: 'Doanh thu',
                            data: {!! json_encode($revenueReport['revenueTrend']->pluck('total')) !!},

                            fill: true,
                        }]
                    }
                });
            }




            var ctxRevenueByPlan = document.getElementById('revenueByPlanChart')?.getContext('2d');
            if (ctxRevenueByPlan) {
                new Chart(ctxRevenueByPlan, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($revenueReport['revenueByPlan']->pluck('plan_name')) !!},
                        datasets: [{
                            label: 'Doanh thu',
                            data: {!! json_encode($revenueReport['revenueByPlan']->pluck('total')) !!},

                            borderWidth: 1
                        }]
                    }
                });
            }



            // Member Growth Chart
            var ctxMemberGrowth = document.getElementById('memberGrowthChart')?.getContext('2d');
            if (ctxMemberGrowth) {
                new Chart(ctxMemberGrowth, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($memberReport['memberGrowth']->pluck('date')) !!},
                        datasets: [{
                            label: 'Hội viên mới',
                            data: {!! json_encode($memberReport['memberGrowth']->pluck('total')) !!},

                            borderWidth: 2,
                            fill: true,
                        }]
                    }
                });
            }


            // Plan Distribution Chart
            var ctxPlanDistribution = document.getElementById('planDistributionChart')?.getContext('2d');
            if (ctxPlanDistribution) {
                new Chart(ctxPlanDistribution, {
                    type: 'pie',
                    data: {
                        labels: {!! json_encode($memberReport['planDistribution']->pluck('plan_name')) !!},
                        datasets: [{
                            label: 'Phân bố gói tập',
                            data: {!! json_encode($memberReport['planDistribution']->pluck('total')) !!},

                            borderWidth: 1
                        }]
                    }
                });
            }


            // Checkins By Hour Chart
            var ctxCheckinsByHour = document.getElementById('checkinsByHourChart')?.getContext('2d');
            if (ctxCheckinsByHour) {
                new Chart(ctxCheckinsByHour, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($activityReport['checkinsByHour']->pluck('hour')) !!},
                        datasets: [{
                            label: 'Lượt check-in',
                            data: {!! json_encode($activityReport['checkinsByHour']->pluck('total')) !!},

                            borderWidth: 1
                        }]
                    }
                });
            }


            // Checkins By Day Chart
            var ctxCheckinsByDay = document.getElementById('checkinsByDayChart')?.getContext('2d');
            if (ctxCheckinsByDay) {
                new Chart(ctxCheckinsByDay, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($activityReport['checkinsByDay']->pluck('day')) !!},
                        datasets: [{
                            label: 'Lượt check-in',
                            data: {!! json_encode($activityReport['checkinsByDay']->pluck('total')) !!},

                            borderWidth: 1
                        }]
                    }
                });
            }

        });
    </script>
@endpush
