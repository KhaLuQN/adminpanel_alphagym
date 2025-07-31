<?php

namespace App\Services;

use App\Models\Checkin;
use App\Models\Member;
use App\Models\MemberSubscription;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getDashboardData(): array
    {
        $today        = Carbon::today();
        $sevenDaysAgo = Carbon::today()->subDays(6);

        // KPI Data
        $todayRevenue      = Payment::whereDate('payment_date', $today)
            ->where('payment_status', 'paid')
            ->sum('amount');
        $newMembersCount   = Member::whereDate('join_date', $today)->count();
        $checkinsToday     = Checkin::whereDate('checkin_time', $today)->count();
        $membersInGymCount = Checkin::whereDate('checkin_time', $today)
            ->whereNull('checkout_time')
            ->count();
        $totalMembers      = Member::whereHas('subscriptions', function ($query) use ($today) {
            $query->where('end_date', '>=', $today);
        })->count();

        // Chart Data
        $revenueLast7Days = Payment::select(
            DB::raw('DATE(payment_date) as date'),
            DB::raw('SUM(amount) as total')
        )
            ->where('payment_status', 'paid')
            ->where('payment_date', '>=', $sevenDaysAgo)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->pluck('total', 'date');

        $activityLast7Days = Checkin::select(
            DB::raw('DATE(checkin_time) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('checkin_time', '>=', $sevenDaysAgo)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->pluck('count', 'date');

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

        // Other Data
        $membersInGym = Checkin::with('member')
            ->whereNull('checkout_time')
            ->latest('checkin_time')
            ->limit(10)
            ->get();

        $expiringMembers = MemberSubscription::with(['member', 'plan'])
            ->whereBetween('end_date', [$today, $today->copy()->addDays(3)])
            ->whereHas('payments', function ($query) {
                $query->where('payment_status', 'paid');
            })
            ->orderBy('end_date', 'asc')
            ->limit(10)
            ->get();

        return compact(
            'todayRevenue',
            'newMembersCount',
            'checkinsToday',
            'membersInGymCount',
            'totalMembers',
            'revenueChart',
            'activityChart',
            'membersInGym',
            'expiringMembers'
        );
    }
}
