<?php

// app/Http/Controllers/Api/MembershipPlanController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MembershipPlanResource;
use App\Models\MembershipPlan;

class MembershipPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = MembershipPlan::with('features')->where('is_active', true)->get();

        return MembershipPlanResource::collection($plans);
    }

    /**
     * Display the specified resource.
     */
    public function show(MembershipPlan $membershipPlan)
    {
        return new MembershipPlanResource($membershipPlan->load('features'));

    }
}
