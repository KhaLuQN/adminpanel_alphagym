<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->subMonth()->toDateString());
        $endDate   = $request->input('end_date', now()->toDateString());

        $revenueReport  = $this->getRevenueReport($startDate, $endDate);
        $memberReport   = $this->getMemberReport($startDate, $endDate);
        $activityReport = $this->getActivityReport($startDate, $endDate);
        // @dd($startDat, $endDate, $revenueReport, $memberReport, $activityReport, );
        return view('admin.pages.reports.index', compact('revenueReport', 'memberReport', 'activityReport', 'startDate', 'endDate'));
    }

    private function getRevenueReport($startDate, $endDate)
    {
        $payments = DB::table('payments')
            ->whereBetween('payment_date', [$startDate, $endDate]);

        $totalRevenue            = $payments->sum('amount');
        $totalTransactions       = $payments->count();
        $averageTransactionValue = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;

        $revenueTrend = DB::table('payments')
            ->select(DB::raw('DATE(payment_date) as date'), DB::raw('SUM(amount) as total'))
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $revenueByPlan = DB::table('payments')
            ->join('membersubscriptions', 'payments.subscription_id', '=', 'membersubscriptions.subscription_id')
            ->join('membership_plans', 'membersubscriptions.plan_id', '=', 'membership_plans.plan_id')
            ->select('membership_plans.plan_name', DB::raw('SUM(payments.amount) as total'))
            ->whereBetween('payments.payment_date', [$startDate, $endDate])
            ->groupBy('membership_plans.plan_name')
            ->get();

        $detailedTransactions = DB::table('payments')
            ->join('membersubscriptions', 'payments.subscription_id', '=', 'membersubscriptions.subscription_id')
            ->join('members', 'membersubscriptions.member_id', '=', 'members.member_id')
            ->join('membership_plans', 'membersubscriptions.plan_id', '=', 'membership_plans.plan_id')
            ->select('payments.payment_id', 'members.full_name', 'membership_plans.plan_name', 'payments.amount', 'payments.payment_date')
            ->whereBetween('payments.payment_date', [$startDate, $endDate])
            ->orderBy('payments.payment_date', 'desc')
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

    private function getMemberReport($startDate, $endDate)
    {
        $newMembers = DB::table('members')->whereBetween('join_date', [$startDate, $endDate])->count();

        $churnedMembers = DB::table('membersubscriptions')
            ->where('end_date', '>', now()->subDays(90))
            ->where('end_date', '<', now())
            ->distinct('member_id')
            ->count('member_id');

        $retentionRate = 0;

        $memberGrowth = DB::table('members')
            ->select(DB::raw('DATE(join_date) as date'), DB::raw('COUNT(*) as total'))
            ->whereBetween('join_date', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $planDistribution = DB::table('membersubscriptions')
            ->join('membership_plans', 'membersubscriptions.plan_id', '=', 'membership_plans.plan_id')
            ->select('membership_plans.plan_name', DB::raw('COUNT(*) as total'))
            ->where('membersubscriptions.start_date', '<=', $endDate)
            ->where('membersubscriptions.end_date', '>=', $startDate)
            ->groupBy('membership_plans.plan_name')
            ->get();

        $newMembersList = DB::table('members')
            ->leftJoin('membersubscriptions', 'members.member_id', '=', 'membersubscriptions.member_id')
            ->leftJoin('membership_plans', 'membersubscriptions.plan_id', '=', 'membership_plans.plan_id')
            ->select('members.full_name', 'members.join_date', 'membership_plans.plan_name')
            ->whereBetween('members.join_date', [$startDate, $endDate])
            ->orderBy('members.join_date', 'desc')
            ->get();

        return [
            'newMembers'       => $newMembers,
            'churnedMembers'   => $churnedMembers,
            'retentionRate'    => $retentionRate,
            'memberGrowth'     => $memberGrowth,
            'planDistribution' => $planDistribution,
            'newMembersList'   => $newMembersList,
        ];
    }

    private function getActivityReport($startDate, $endDate)
    {
        $checkins = DB::table('checkins')->whereBetween('checkin_time', [$startDate, $endDate]);

        $totalCheckins = $checkins->count();

        $averageWorkoutDuration = DB::table('checkins')
            ->whereBetween('checkin_time', [$startDate, $endDate])
            ->whereNotNull('checkout_time')
            ->select(DB::raw('AVG(TIMESTAMPDIFF(MINUTE, checkin_time, checkout_time)) as avg_duration'))
            ->value('avg_duration');

        $peakHour = DB::table('checkins')
            ->whereBetween('checkin_time', [$startDate, $endDate])
            ->select(DB::raw('HOUR(checkin_time) as hour'), DB::raw('COUNT(*) as total'))
            ->groupBy('hour')
            ->orderBy('total', 'desc')
            ->first();

        $checkinsByHour = DB::table('checkins')
            ->whereBetween('checkin_time', [$startDate, $endDate])
            ->select(DB::raw('HOUR(checkin_time) as hour'), DB::raw('COUNT(*) as total'))
            ->groupBy('hour')
            ->orderBy('hour', 'asc')
            ->get();

        $checkinsByDay = DB::table('checkins')
            ->whereBetween('checkin_time', [$startDate, $endDate])
            ->select(DB::raw('DAYNAME(checkin_time) as day'), DB::raw('COUNT(*) as total'))
            ->groupBy('day')
            ->orderBy(DB::raw('FIELD(day, "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday")'))
            ->get();

        $topActiveMembers = DB::table('checkins')
            ->join('members', 'checkins.member_id', '=', 'members.member_id')
            ->select('members.full_name', DB::raw('COUNT(*) as total_checkins'))
            ->whereBetween('checkin_time', [$startDate, $endDate])
            ->groupBy('members.full_name')
            ->orderBy('total_checkins', 'desc')
            ->take(10)
            ->get();

        return [
            'totalCheckins'          => $totalCheckins,
            'averageWorkoutDuration' => $averageWorkoutDuration,
            'peakHour'               => $peakHour,
            'checkinsByHour'         => $checkinsByHour,
            'checkinsByDay'          => $checkinsByDay,
            'topActiveMembers'       => $topActiveMembers,
        ];
    }
}
