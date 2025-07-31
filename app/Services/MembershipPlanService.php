<?php
namespace App\Services;

use App\Models\MembershipPlan;

use App\Models\PlanFeature;

class MembershipPlanService
{
    public function getPlansForIndex()
    {
        return MembershipPlan::withCount('features')->latest()->paginate(10);
    }

    public function getDataForCreateEdit()
    {
        return ['features' => PlanFeature::all()];
    }

    public function createPlan(array $validatedData): MembershipPlan
    {
        $planData = [
            'plan_name'        => $validatedData['plan_name'],
            'duration_days'    => $validatedData['duration_days'],
            'price'            => $validatedData['price'],
            'discount_percent' => $validatedData['discount_percent'] ?? 0,
            'description'      => $validatedData['description'],
            'is_active'        => $validatedData['is_active'] ?? false,
        ];

        $plan = MembershipPlan::create($planData);

        if (! empty($validatedData['features'])) {
            $this->syncFeatures($plan, $validatedData['features']);
        }

        return $plan;
    }

    public function updatePlan(MembershipPlan $plan, array $validatedData): MembershipPlan
    {
        $planData = [
            'plan_name'        => $validatedData['plan_name'],
            'duration_days'    => $validatedData['duration_days'],
            'price'            => $validatedData['price'],
            'discount_percent' => $validatedData['discount_percent'] ?? 0,
            'description'      => $validatedData['description'],
            'is_active'        => $validatedData['is_active'] ?? false,
        ];

        $plan->update($planData);

        $features = $validatedData['features'] ?? [];
        $this->syncFeatures($plan, $features);

        return $plan;
    }

    private function syncFeatures(MembershipPlan $plan, array $features): void
    {
        $syncData = [];
        foreach ($features as $feature) {
            if (isset($feature['id'])) {
                $syncData[$feature['id']] = ['feature_value' => $feature['value']];
            }
        }
        $plan->features()->sync($syncData);
    }

    public function deleteMembershipPlan(MembershipPlan $membershipPlan): void
    {
        $membershipPlan->features()->detach();
        $membershipPlan->delete();
    }

    public function getApiActivePlans()
    {
        return MembershipPlan::with('features')->where('is_active', true)->get();
    }

    public function getPlanWithFeatures(MembershipPlan $membershipPlan)
    {
        return $membershipPlan->load('features');
    }
}
