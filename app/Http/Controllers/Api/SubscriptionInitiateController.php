<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MembershipPlan;
use App\Models\MemberSubscription;
use App\Models\Payment;
use App\Services\Payments\VnpayService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionInitiateController extends Controller
{
    protected $vnpayService;

    public function __construct(VnpayService $vnpayService)
    {
        $this->vnpayService = $vnpayService;
    }

    public function initiate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_type'      => 'required|in:new,existing',
            'member_identifier'  => 'required_if:customer_type,existing|string',
            'customer_name'      => 'required_if:customer_type,new|string|max:255',
            'customer_email'     => 'required_if:customer_type,new|email|unique:members,email|max:255',
            'customer_phone'     => 'required_if:customer_type,new|string|max:20',
            'membership_plan_id' => 'required|exists:membership_plans,plan_id',
            'payment_method'     => 'required|in:vnpay',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $member = null;
        if ($request->customer_type === 'new') {
            $member = Member::create([
                'full_name' => $request->customer_name,
                'email'     => $request->customer_email,
                'phone'     => $request->customer_phone,
                'join_date' => Carbon::now(),

            ]);
        } else { // existing
            $member = Member::where('email', $request->member_identifier)
                ->orWhere('phone', $request->member_identifier)
                ->first();

            if (! $member) {
                return response()->json(['message' => 'Existing member not found.'], 404);
            }
        }

        $plan = MembershipPlan::find($request->membership_plan_id);

        $startDate = Carbon::now();
        $endDate   = $startDate->copy()->addDays($plan->duration_days);

        $subscription = MemberSubscription::create([
            'member_id'    => $member->member_id,
            'plan_id'      => $plan->plan_id,
            'start_date'   => $startDate->toDateString(),
            'end_date'     => $endDate->toDateString(),
            'actual_price' => $plan->price,

        ]);

        $payment = Payment::create([
            'subscription_id' => $subscription->subscription_id,
            'amount'          => $plan->price,
            'payment_date'    => Carbon::now(),
            'payment_method'  => $request->payment_method,
            'payment_status'  => 'pending',
            'notes'           => 'Thanh toán bằng vnpay',
        ]);

        if ($request->payment_method === 'vnpay') {

            $vnpayUrl = $this->vnpayService->generatePaymentUrl($payment->payment_id, $payment->amount, 'Thanh toan goi tap ' . $plan->plan_name);
            return response()->json(['payment_url' => $vnpayUrl]);
        }

        return response()->json(['message' => 'Payment initiation failed.'], 500);
    }
}
