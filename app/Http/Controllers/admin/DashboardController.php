<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Checkin;
use App\Models\Member;
use App\Models\MemberSubscription;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $today        = Carbon::today();
        $sevenDaysAgo = Carbon::today()->subDays(6);

        // ===== 1. TÍNH TOÁN CÁC THẺ KPI =====

        // Doanh thu hôm nay
        $todayRevenue = Payment::whereDate('payment_date', $today)->sum('amount');

        // Số hội viên mới trong ngày
        $newMembersCount = Member::whereDate('join_date', $today)->count();

        // Tổng lượt check-in hôm nay
        $checkinsToday = Checkin::whereDate('checkin_time', $today)->count();

        // Số hội viên đang có mặt trong phòng gym
        $membersInGymCount = Checkin::whereDate('checkin_time', $today)
            ->whereNull('checkout_time')
            ->count();

        // Tổng số hội viên đang hoạt động (còn hạn gói tập)
        $totalMembers = Member::whereHas('subscriptions', function ($query) use ($today) {
            $query->where('end_date', '>=', $today);
        })->count();

        // ===== 2. CHUẨN BỊ DỮ LIỆU CHO BIỂU ĐỒ =====

        // Doanh thu 7 ngày gần nhất
        $revenueLast7Days = Payment::select(
            DB::raw('DATE(payment_date) as date'),
            DB::raw('SUM(amount) as total')
        )
            ->where('payment_date', '>=', $sevenDaysAgo)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->pluck('total', 'date');

        // Lượt check-in 7 ngày gần nhất
        $activityLast7Days = Checkin::select(
            DB::raw('DATE(checkin_time) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('checkin_time', '>=', $sevenDaysAgo)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->pluck('count', 'date');

        // Tạo một mảng ngày đầy đủ để đảm bảo biểu đồ không bị thiếu ngày
        $dateRange = collect();
        for ($i = 0; $i < 7; $i++) {
            $dateRange->push(Carbon::today()->subDays($i)->format('Y-m-d'));
        }
        $dateRange = $dateRange->reverse();

        $revenueChartData = $dateRange->map(function ($date) use ($revenueLast7Days) {
            return $revenueLast7Days->get($date, 0);
        });
        $activityChartData = $dateRange->map(function ($date) use ($activityLast7Days) {
            return $activityLast7Days->get($date, 0);
        });

        $revenueChart = [
            'labels' => array_values($dateRange->map(fn($date) => Carbon::parse($date)->format('d/m'))->toArray()),
            'data'   => array_map('floatval', $revenueChartData->values()->toArray()),
        ];

        $activityChart = [
            'labels' => array_values($dateRange->map(fn($date) => Carbon::parse($date)->format('d/m'))->toArray()),
            'data'   => array_map('intval', $activityChartData->values()->toArray()),
        ];

        $membersInGym = Checkin::with('member')
            ->whereNull('checkout_time')
            ->latest('checkin_time')
            ->limit(10)
            ->get();

        $expiringMembers = MemberSubscription::with(['member', 'plan'])
            ->where('end_date', '>=', $today)
            ->where('end_date', '<=', $today->copy()->addDays(3))
            ->orderBy('end_date', 'asc')
            ->limit(10) // Giới hạn 10 người
            ->get();

        return view('admin.pages.dashboard.index', compact(
            'todayRevenue',
            'newMembersCount',
            'checkinsToday',
            'membersInGymCount',
            'totalMembers',
            'revenueChart',
            'activityChart',
            'membersInGym',
            'expiringMembers'
        ));
    }
}
