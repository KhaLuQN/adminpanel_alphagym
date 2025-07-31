<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\StoreMemberRequest;
use App\Http\Requests\Member\UpdateMemberRequest;
use App\Models\Member;
use App\Services\MemberService;

class MemberController extends Controller
{
    protected $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    public function index()
    {
        $members = $this->memberService->getMembersForIndex();
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

    public function show(Member $member)
    {
        $data = $this->memberService->getMemberProfileData($member);
        return view('admin.pages.member.show', $data);
    }

    public function edit(Member $member)
    {

        return view('admin.pages.member.edit', compact('member'));
    }

    public function update(UpdateMemberRequest $request, Member $member)
    {

        try {
            $this->memberService->updateMember($member, $request->validated());
            return redirect()->back()->with('success', 'Cập nhật thông tin thành viên thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(Member $member)
    {
        try {
            $this->memberService->deleteMember($member);
            return redirect()->route('admin.members.index')->with('success', 'Xóa hội viên thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.members.index')->with('error', 'Xóa thất bại: ' . $e->getMessage());
        }
    }
}
