<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Plans\StoreMembershipPlanRequest;
use App\Http\Requests\Plans\UpdateMembershipPlanRequest;
use App\Models\MembershipPlan;
use App\Services\MembershipPlanService;

class MembershipPlanController extends Controller
{
    protected $planService;

    public function __construct(MembershipPlanService $planService)
    {
        $this->planService = $planService;
    }

    public function index()
    {
        $plans = $this->planService->getPlansForIndex();
        return view('admin.pages.plans.index', compact('plans'));
    }

    public function create()
    {
        $data = $this->planService->getDataForCreateEdit();
        return view('admin.pages.plans.create', $data);
    }

    public function store(StoreMembershipPlanRequest $request)
    {

        $this->planService->createPlan($request->validated());
        return redirect()->route('admin.membership-plans.index')->with('success', 'Tạo gói tập thành công!');
    }

    public function edit(MembershipPlan $membershipPlan)
    {
        $data         = $this->planService->getDataForCreateEdit();
        $planFeatures = $membershipPlan->features->keyBy('feature_id');
        
        return view('admin.pages.plans.edit', array_merge(compact('membershipPlan', 'planFeatures'), $data));
    }

    public function update(UpdateMembershipPlanRequest $request, MembershipPlan $membershipPlan)
    {
        $this->planService->updatePlan($membershipPlan, $request->validated());
        return redirect()->route('admin.membership-plans.index')->with('success', 'Cập nhật gói tập thành công!');
    }

    public function destroy(MembershipPlan $membershipPlan)
    {
        $this->planService->deleteMembershipPlan($membershipPlan);
        return redirect()->route('admin.membership-plans.index')->with('success', 'Xóa gói tập thành công!');
    }
}
