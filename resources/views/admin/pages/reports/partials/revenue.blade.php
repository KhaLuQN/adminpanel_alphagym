<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="stats shadow">
        <div class="stat">
            <div class="stat-figure text-primary">
                <i class="ri-money-dollar-circle-line text-4xl"></i>
            </div>
            <div class="stat-title">Tổng doanh thu</div>
            <div class="stat-value text-primary">{{ number_format($revenueReport['totalRevenue'], 0, ',', '.') }} đ</div>
        </div>
    </div>
    <div class="stats shadow">
        <div class="stat">
            <div class="stat-figure text-secondary">
                <i class="ri-shopping-cart-2-line text-4xl"></i>
            </div>
            <div class="stat-title">Tổng số giao dịch</div>
            <div class="stat-value text-secondary">{{ $revenueReport['totalTransactions'] }}</div>
        </div>
    </div>
    <div class="stats shadow">
        <div class="stat">
            <div class="stat-figure text-accent">
                <i class="ri-bar-chart-line text-4xl"></i>
            </div>
            <div class="stat-title">GTGD Trung bình</div>
            <div class="stat-value text-accent">
                {{ number_format($revenueReport['averageTransactionValue'], 0, ',', '.') }} đ</div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Xu hướng doanh thu</h2>
            <canvas id="revenueTrendChart"></canvas>
        </div>
    </div>
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Cơ cấu doanh thu theo gói tập</h2>
            <canvas id="revenueByPlanChart"></canvas>
        </div>
    </div>
</div>

<div class="card bg-base-100 shadow-xl">
    <div class="card-body">
        <h2 class="card-title mb-4">Chi tiết giao dịch</h2>
        <div class="overflow-x-auto">
            <table class="table table-zebra  datatable">
                <thead>
                    <tr>
                        <th>Mã thanh toán</th>
                        <th>Tên hội viên</th>
                        <th>Tên gói tập</th>
                        <th>Số tiền</th>
                        <th>Ngày thanh toán</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($revenueReport['detailedTransactions'] as $transaction)
                        <tr>
                            <td>{{ $transaction->payment_id }}</td>
                            <td>{{ $transaction->full_name }}</td>
                            <td>{{ $transaction->plan_name }}</td>
                            <td>{{ number_format($transaction->amount, 0, ',', '.') }} đ</td>
                            <td>{{ $transaction->payment_date }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Không có dữ liệu.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
