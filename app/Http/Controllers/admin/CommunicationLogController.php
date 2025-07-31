<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\CommunicationLogService;
use Illuminate\Http\Request;

class CommunicationLogController extends Controller
{
    protected $communicationLogService;

    public function __construct(CommunicationLogService $communicationLogService)
    {
        $this->communicationLogService = $communicationLogService;
    }

    /**
     * Hiển thị danh sách lịch sử gửi email với bộ lọc
     */
    public function index(Request $request)
    {
        $logs = $this->communicationLogService->getCommunicationLogsForIndex($request->all());

        return view('admin.pages.communication-logs.index', [
            'logs'    => $logs,
            'filters' => $request->all(),

        ]);
    }

    /**
     * Hiển thị chi tiết một email đã gửi
     */
    public function show(CommunicationLog $log)
    {
        return view('admin.pages.communication-logs.show', ['log' => $log]);
    }
}
