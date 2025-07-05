<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="stats shadow">
        <div class="stat">
            <div class="stat-figure text-success">
                <i class="ri-user-add-line text-4xl"></i>
            </div>
            <div class="stat-title">Hội viên mới</div>
            <div class="stat-value text-success">{{ $memberReport['newMembers'] }}</div>
        </div>
    </div>
    <div class="stats shadow">
        <div class="stat">
            <div class="stat-figure text-error">
                <i class="ri-user-subtract-line text-4xl"></i>
            </div>
            <div class="stat-title">Hội viên rời đi</div>
            <div class="stat-value text-error">{{ $memberReport['churnedMembers'] }}</div>
        </div>
    </div>
    <div class="stats shadow">
        <div class="stat">
            <div class="stat-figure text-info">
                <i class="ri-user-shared-line text-4xl"></i>
            </div>
            <div class="stat-title">Tỷ lệ gia hạn</div>
            <div class="stat-value text-info">{{ round($memberReport['retentionRate'], 2) }}%</div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Tăng trưởng hội viên</h2>
            <canvas id="memberGrowthChart"></canvas>
        </div>
    </div>
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Phân bố gói tập</h2>
            <canvas id="planDistributionChart"></canvas>
        </div>
    </div>
</div>

<div class="card bg-base-100 shadow-xl">
    <div class="card-body">
        <h2 class="card-title mb-4">Danh sách hội viên mới</h2>
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th>Tên hội viên</th>
                        <th>Ngày tham gia</th>
                        <th>Gói tập đầu tiên</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($memberReport['newMembersList'] as $member)
                        <tr>
                            <td>{{ $member->full_name }}</td>
                            <td>{{ $member->join_date }}</td>
                            <td>{{ $member->plan_name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Không có dữ liệu.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>