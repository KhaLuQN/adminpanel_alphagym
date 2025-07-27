<?php
namespace App\Services;

use App\Models\MembershipPlan;
use App\Models\MemberSubscription;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MemberSubscriptionService
{
    public function handleSubscription(Request $request)
    {
        $package     = MembershipPlan::findOrFail($request->package_id);
        $actualPrice = $package->price * (1 - $package->discount_percent / 100);

        $currentSubscription = MemberSubscription::where('member_id', $request->member_id)
            ->where('end_date', '>=', now())
            ->orderByDesc('end_date')
            ->first();

        $startDate = $currentSubscription
        ? Carbon::parse($currentSubscription->end_date)->addDay()
        : Carbon::parse($request->start_date);

        $endDate = $startDate->copy()->addDays($package->duration_days);

        $subscription = MemberSubscription::create([
            'member_id'    => $request->member_id,
            'plan_id'      => $package->plan_id,
            'start_date'   => $startDate->toDateString(),
            'end_date'     => $endDate->toDateString(),
            'actual_price' => $actualPrice,
        ]);

        return [$subscription, $actualPrice];
    }

    public function handlePayment($subscription, $actualPrice, $method)
    {
        return Payment::create([
            'subscription_id' => $subscription->subscription_id,
            'amount'          => $actualPrice,
            'payment_date'    => now(),
            'payment_method'  => $method,
            'notes'           => $method === 'cash' ? 'Thanh toán tiền mặt tại quầy' : 'Thanh toán online',
            'payment_status'  => $method === 'cash' ? 'paid' : 'pending',
        ]);
    }
}
