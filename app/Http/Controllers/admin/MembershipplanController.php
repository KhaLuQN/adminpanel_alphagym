<?php
/* ======================================================
  FILE 1: app/Http/Controllers/Admin/MembershipPlanController.php
  ======================================================
*/
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipPlan;
use App\Models\PlanFeature;
use Illuminate\Http\Request;

class MembershipPlanController extends Controller
{
    public function index()
    {
        $plans = MembershipPlan::with('features')->latest()->paginate(10);
        return view('admin.pages.plans.index', compact('plans'));
    }

    public function create()
    {
        $features = PlanFeature::all();
        return view('admin.pages.plans.create', compact('features'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plan_name'        => 'required|string|max:255',
            'duration_days'    => 'required|integer|min:1',
            'price'            => 'required|numeric|min:0',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'description'      => 'nullable|string',
            'is_active'        => 'boolean',
            'features'         => 'nullable|array',
            'features.*.id'    => 'required_with:features|exists:plan_features,feature_id',
            'features.*.value' => 'nullable|string|max:255',
        ]);

        $plan = MembershipPlan::create([
            'plan_name'        => $validated['plan_name'],
            'duration_days'    => $validated['duration_days'],
            'price'            => $validated['price'],
            'discount_percent' => $validated['discount_percent'] ?? 0,
            'description'      => $validated['description'],
            'is_active'        => $request->has('is_active'),
        ]);

        if (! empty($validated['features'])) {
            $syncData = [];
            foreach ($validated['features'] as $feature) {
                $syncData[$feature['id']] = ['feature_value' => $feature['value']];
            }
            $plan->features()->sync($syncData);
        }

        return redirect()->route('admin.membership-plans.index')->with('success', 'Tạo gói tập thành công!');
    }

    public function edit(MembershipPlan $membershipPlan)
    {
        $features = PlanFeature::all();
        // Lấy các quyền lợi hiện tại của gói tập để điền vào form
        $planFeatures = $membershipPlan->features->keyBy('feature_id');
        return view('admin.pages.plans.edit', compact('membershipPlan', 'features', 'planFeatures'));
    }

    public function update(Request $request, MembershipPlan $membershipPlan)
    {
        $validated = $request->validate([
            'plan_name'        => 'required|string|max:255',
            'duration_days'    => 'required|integer|min:1',
            'price'            => 'required|numeric|min:0',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'description'      => 'nullable|string',
            'is_active'        => 'boolean',
            'features'         => 'nullable|array',
            'features.*.id'    => 'required_with:features|exists:plan_features,feature_id',
            'features.*.value' => 'nullable|string|max:255',
        ]);

        $membershipPlan->update([
            'plan_name'        => $validated['plan_name'],
            'duration_days'    => $validated['duration_days'],
            'price'            => $validated['price'],
            'discount_percent' => $validated['discount_percent'] ?? 0,
            'description'      => $validated['description'],
            'is_active'        => $request->has('is_active'),
        ]);

        $syncData = [];
        if (! empty($validated['features'])) {
            foreach ($validated['features'] as $feature) {
                $syncData[$feature['id']] = ['feature_value' => $feature['value']];
            }
        }
        $membershipPlan->features()->sync($syncData);

        return redirect()->route('admin.membership-plans.index')->with('success', 'Cập nhật gói tập thành công!');
    }

    public function destroy(MembershipPlan $membershipPlan)
    {
        $membershipPlan->delete();
        return redirect()->route('admin.membership-plans.index')->with('success', 'Xóa gói tập thành công!');
    }
}
