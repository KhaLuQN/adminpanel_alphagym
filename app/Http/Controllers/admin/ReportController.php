<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\Reports\ActivityReportService;
use App\Services\Reports\MemberReportService;
use App\Services\Reports\RevenueReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function __construct(
        protected RevenueReportService $revenueReportService,
        protected MemberReportService $memberReportService,
        protected ActivityReportService $activityReportService
    ) {}

    public function index(Request $request)
    {

        $startDate = $request->input('start_date', now()->subMonth()->toDateString());
        $endDate   = $request->input('end_date', now()->toDateString());

        $revenueReport  = $this->revenueReportService->generate($startDate, $endDate);
        $memberReport   = $this->memberReportService->generate($startDate, $endDate);
        $activityReport = $this->activityReportService->generate($startDate, $endDate);

        // @dd($revenueReport, $memberReport, $activityReport);

        return view('admin.pages.reports.index', compact(
            'revenueReport',
            'memberReport',
            'activityReport',
            'startDate',
            'endDate',

        ));
    }
}
