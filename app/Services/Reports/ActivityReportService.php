<?php
namespace App\Services\Reports;

use App\Models\Checkin;
use Illuminate\Support\Facades\DB;

class ActivityReportService
{
    public function generate($startDate, $endDate)
    {
        $baseQuery = Checkin::whereBetween('checkin_time', [$startDate, $endDate]);

        $totalCheckins = (clone $baseQuery)->count();

        $averageWorkoutDuration = (clone $baseQuery)
            ->whereNotNull('checkout_time')
            ->select(DB::raw('AVG(TIMESTAMPDIFF(MINUTE, checkin_time, checkout_time)) as avg_duration'))
            ->value('avg_duration');

        $peakHour = (clone $baseQuery)
            ->select(DB::raw('HOUR(checkin_time) as hour'), DB::raw('COUNT(*) as total'))
            ->groupBy('hour')
            ->orderBy('total', 'desc')
            ->first();

        $checkinsByDay = (clone $baseQuery)
            ->select(DB::raw('DAYNAME(checkin_time) as day'), DB::raw('COUNT(*) as total'))
            ->groupBy('day')
            ->orderBy(DB::raw('FIELD(day, "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday")'))
            ->get();
        $topActiveMembers = Checkin::with('member')
            ->select('member_id', DB::raw('COUNT(*) as total_checkins'))
            ->whereBetween('checkin_time', [$startDate, $endDate])
            ->groupBy('member_id')
            ->orderByDesc('total_checkins')
            ->take(10)
            ->get();
        $checkinsByHour = (clone $baseQuery)
            ->select(DB::raw('HOUR(checkin_time) as hour'), DB::raw('COUNT(*) as total'))
            ->groupBy('hour')
            ->orderBy('hour', 'asc')
            ->get();

        return [
            'totalCheckins'          => $totalCheckins,
            'averageWorkoutDuration' => round($averageWorkoutDuration ?? 0),
            'peakHour'               => $peakHour,
            'checkinsByDay'          => $checkinsByDay,
            'topActiveMembers'       => $topActiveMembers,
            'checkinsByHour'         => $checkinsByHour,
        ];
    }
}
