<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\MemberEngagementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberEngagementController extends Controller
{
    protected $memberEngagementService;

    public function __construct(MemberEngagementService $memberEngagementService)
    {
        $this->memberEngagementService = $memberEngagementService;
    }

    public function index(Request $request)
    {
        $data = $this->memberEngagementService->getMembersForEngagementIndex($request->all());

        return view('admin.pages.engagement.index', $data);
    }

    /**
     * Xử lý gửi email cho các hội viên đã chọn
     */
    public function send(Request $request)
    {
        $request->validate([
            'member_ids'    => 'required|array|min:1',
            'member_ids.*'  => 'exists:members,member_id',
            'campaign_name' => 'required|string|max:100',
            'subject'       => 'required|string|max:255',
            'body'          => 'required|string',

        ]);

        $sentCount = $this->memberEngagementService->sendCampaignEmail(
            $request->member_ids,
            $request->campaign_name,
            $request->subject,
            $request->body,
            Auth::id()
        );

        return redirect()->back()->with('success', "Đã gửi email thành công cho {$sentCount}/" . count($request->member_ids) . " hội viên.");
    }
}
