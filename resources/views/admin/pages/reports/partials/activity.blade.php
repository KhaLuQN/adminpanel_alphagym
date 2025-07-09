<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="stats shadow">
        <div class="stat">
            <div class="stat-figure text-info">
                <i class="ri-login-box-line text-4xl"></i>
            </div>
            <div class="stat-title">Tổng lượt Check-in</div>
            <div class="stat-value text-info">{{ $activityReport['totalCheckins'] }}</div>
        </div>
    </div>
    <div class="stats shadow">
        <div class="stat">
            <div class="stat-figure text-warning">
                <i class="ri-time-line text-4xl"></i>
            </div>
            <div class="stat-title">TG tập trung bình</div>
            <div class="stat-value text-warning">{{ round($activityReport['averageWorkoutDuration'], 2) }} phút</div>
        </div>
    </div>
    <div class="stats shadow">
        <div class="stat">
            <div class="stat-figure text-error">
                <i class="ri-fire-line text-4xl"></i>
            </div>
            <div class="stat-title">Giờ vàng</div>
            <div class="stat-value text-error">
                {{ $activityReport['peakHour'] ? $activityReport['peakHour']->hour . ':00' : 'N/A' }}</div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Phân bố Check-in theo giờ</h2>
            <canvas id="checkinsByHourChart"></canvas>
        </div>
    </div>
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Phân bố Check-in theo ngày</h2>
            <canvas id="checkinsByDayChart"></canvas>
        </div>
    </div>
</div>

<div class="card bg-base-100 shadow-xl">
    <div class="card-body">
        <h2 class="card-title mb-4">Top hội viên tích cực</h2>
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full datatable">
                <thead>
                    <tr>
                        <th>Tên hội viên</th>
                        <th>Tổng số lượt check-in</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activityReport['topActiveMembers'] as $member)
                        <tr>
                            <td>{{ $member->member->full_name }}</td>
                            <td>{{ $member->total_checkins }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">Không có dữ liệu.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
