<?php

namespace App\Services;

use App\Services\Reports\ActivityReportService;
use App\Services\Reports\MemberReportService;
use App\Services\Reports\RevenueReportService;

class ReportService
{
    public function __construct(
        protected RevenueReportService $revenueReportService,
        protected MemberReportService $memberReportService,
        protected ActivityReportService $activityReportService
    ) {}

    public function getAllReports(string $startDate, string $endDate): array
    {
        $revenueReport  = $this->revenueReportService->generate($startDate, $endDate);
        $memberReport   = $this->memberReportService->generate($startDate, $endDate);
        $activityReport = $this->activityReportService->generate($startDate, $endDate);

        return compact('revenueReport', 'memberReport', 'activityReport');
    }
}
