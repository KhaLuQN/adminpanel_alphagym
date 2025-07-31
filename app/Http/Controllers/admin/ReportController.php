<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index(Request $request)
    {

        $startDate = $request->input('start_date', now()->subMonth()->toDateString());
        $endDate   = $request->input('end_date', now()->toDateString());

        $reports = $this->reportService->getAllReports($startDate, $endDate);

        return view('admin.pages.reports.index', array_merge(
            $reports,
            compact('startDate', 'endDate')
        ));
    }
}
