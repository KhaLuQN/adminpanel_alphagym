<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\StoreMemberRequest;
use App\Http\Requests\Member\UpdateMemberRequest;
use App\Models\Member;
use App\Services\MemberService;
use Carbon\Carbon;

class MemberController extends Controller
{
    protected $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    public function index()
    {

        $members = Member::select('member_id', 'full_name', 'phone', 'status', 'img', 'rfid_card_id')
            ->latest('member_id')
            ->get();

        return view('admin.pages.member.index', compact('members'));
    }

    public function create()
    {

        return view('admin.pages.member.create');
    }

    public function store(StoreMemberRequest $request)
    {
        try {
            $this->memberService->createMember($request->validated());
            return redirect()->route('admin.members.index')->with('success', 'Thêm thành viên thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function update(UpdateMemberRequest $request)
    {
        try {
            $member = Member::findOrFail($request->validated()['member_id']);
            $this->memberService->updateMember($member, $request->validated());
            return redirect()->back()->with('success', 'Cập nhật thông tin thành viên thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show($id)
    {
        $member = Member::with([
            'checkins' => function ($query) {
                $query->orderBy('checkin_time', 'desc')->limit(10);
            },
        ])->findOrFail($id);

        $totalCheckins     = $member->checkins()->count();
        $lastMonthCheckins = $member->checkins()
            ->where('checkin_time', '>=', Carbon::now()->subMonth())
            ->count();
        $avgSessionTime = $this->calculateAvgSessionTime($member);

        $subscriptions = $member->subscriptions()
            ->whereHas('payments', function ($query) {
                $query->where('payment_status', 'paid');
            })
            ->get();

        return view('admin.pages.member.show', compact(
            'member',
            'totalCheckins',
            'lastMonthCheckins',
            'avgSessionTime',
            'subscriptions'
        ));
    }

    private function calculateAvgSessionTime($member)
    {
        $sessions = $member->checkins()
            ->whereNotNull('checkout_time')
            ->get();

        if ($sessions->isEmpty()) {
            return null;
        }

        $totalSeconds = 0;
        foreach ($sessions as $session) {
            $totalSeconds += $session->checkin_time->diffInSeconds($session->checkout_time);
        }

        $avgSeconds = $totalSeconds / $sessions->count();

        return [
            'hours'   => floor($avgSeconds / 3600),
            'minutes' => floor(($avgSeconds % 3600) / 60),
        ];
    }

    public function destroy($id)
    {
        $member = Member::find($id);

        if (! $member) {
            return redirect()->route('admin.members.index')->with('error', 'Không tìm thấy hội viên.');
        }

        try {

            $member->delete();
            return redirect()->route('admin.members.index')->with('success', 'Xóa hội viên thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.members.index')->with('error', 'Xóa thất bại: ' . $e->getMessage());
        }
    }
}
