<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunicationLog;
use Illuminate\Http\Request;

class CommunicationLogController extends Controller
{
    /**
     * Hiển thị danh sách lịch sử gửi email với bộ lọc
     */
    public function index(Request $request)
    {
        $query = CommunicationLog::query()->with(['member', 'sender']);

        $logs = $query->latest('sent_at')->paginate(15)->withQueryString();

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
