<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMembershipPlanRequest;
use App\Http\Requests\UpdateMembershipPlanRequest;
use App\Models\MembershipPlan;
use App\Models\PlanFeature;
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
        $plans = MembershipPlan::withCount('features')->latest()->paginate(10);
        return view('admin.pages.plans.index', compact('plans'));
    }

    public function create()
    {
        $features = PlanFeature::all();
        return view('admin.pages.plans.create', compact('features'));
    }

    public function store(StoreMembershipPlanRequest $request)
    {

        $this->planService->createPlan($request->validated());
        return redirect()->route('admin.membership-plans.index')->with('success', 'Tạo gói tập thành công!');
    }

    public function edit(MembershipPlan $membershipPlan)
    {
        $features     = PlanFeature::all();
        $planFeatures = $membershipPlan->features->keyBy('feature_id');
        return view('admin.pages.plans.edit', compact('membershipPlan', 'features', 'planFeatures'));
    }

    public function update(UpdateMembershipPlanRequest $request, MembershipPlan $membershipPlan)
    {
        $this->planService->updatePlan($membershipPlan, $request->validated());
        return redirect()->route('admin.membership-plans.index')->with('success', 'Cập nhật gói tập thành công!');
    }

    public function destroy(MembershipPlan $membershipPlan)
    {
        $membershipPlan->features()->detach();
        $membershipPlan->delete();
        return redirect()->route('admin.membership-plans.index')->with('success', 'Xóa gói tập thành công!');
    }
}
