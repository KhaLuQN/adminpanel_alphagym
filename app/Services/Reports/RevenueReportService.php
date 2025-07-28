<?php
namespace App\Services\Reports;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class RevenueReportService
{
    public function generate($startDate, $endDate)
    {
        $baseQuery = Payment::where('payment_status', 'paid')
            ->whereBetween('payment_date', [$startDate, $endDate]);

        $kpiData = (clone $baseQuery)->select(
            DB::raw('SUM(amount) as totalRevenue'),
            DB::raw('COUNT(*) as totalTransactions')
        )->first();

        $totalRevenue            = $kpiData->totalRevenue ?? 0;
        $totalTransactions       = $kpiData->totalTransactions ?? 0;
        $averageTransactionValue = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;

        $revenueTrend = (clone $baseQuery)
            ->select(DB::raw('DATE(payment_date) as date'), DB::raw('SUM(amount) as total'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $revenueByPlan = Payment::join('membersubscriptions', 'payments.subscription_id', '=', 'membersubscriptions.subscription_id')
            ->join('membership_plans', 'membersubscriptions.plan_id', '=', 'membership_plans.plan_id')
            ->select('membership_plans.plan_name', DB::raw('SUM(payments.amount) as total'))
            ->whereBetween('payments.payment_date', [$startDate, $endDate])
            ->groupBy('membership_plans.plan_name')
            ->get();
        $detailedTransactions = Payment::with(['subscription.member', 'subscription.plan'])
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->latest('payment_date')
            ->get();

        return [
            'totalRevenue'            => $totalRevenue,
            'totalTransactions'       => $totalTransactions,
            'averageTransactionValue' => $averageTransactionValue,
            'revenueTrend'            => $revenueTrend,
            'revenueByPlan'           => $revenueByPlan,
            'detailedTransactions'    => $detailedTransactions,
        ];
    }
}
