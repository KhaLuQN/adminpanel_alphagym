<?php
namespace App\Services\Reports;

use App\Models\Member;
use App\Models\MemberSubscription;
use Illuminate\Support\Facades\DB;

class MemberReportService
{
    public function generate($startDate, $endDate)
    {
        $newMembers = Member::whereBetween('join_date', [$startDate, $endDate])->count();

        $churnedMembers = 0;
        $retentionRate  = 0;

        $memberGrowth = Member::select(DB::raw('DATE(join_date) as date'), DB::raw('COUNT(*) as total'))
            ->whereBetween('join_date', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $planDistribution = MemberSubscription::join('membership_plans', 'membersubscriptions.plan_id', '=', 'membership_plans.plan_id')
            ->select('membership_plans.plan_name', DB::raw('COUNT(DISTINCT membersubscriptions.member_id) as total'))
            ->where('membersubscriptions.start_date', '<=', $endDate)
            ->where('membersubscriptions.end_date', '>=', $startDate)
            ->groupBy('membership_plans.plan_name')
            ->get();
        $newMembersList = Member::leftJoin('membersubscriptions', 'members.member_id', '=', 'membersubscriptions.member_id')
            ->leftJoin('membership_plans', 'membersubscriptions.plan_id', '=', 'membership_plans.plan_id')
            ->select('members.full_name', 'members.join_date', 'membership_plans.plan_name')
            ->whereBetween('members.join_date', [$startDate, $endDate])
            ->latest('members.join_date')
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
}
