<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\MemberSubscriptionService;
use Illuminate\Http\Request;

class MemberSubscriptionController extends Controller
{
    protected $subscriptionService;

    public function __construct(MemberSubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function create()
    {
        $data = $this->subscriptionService->getDataForCreate();
        return view('admin.pages.subscriptions.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id'      => 'required|exists:members,member_id',
            'package_id'     => 'required|exists:membership_plans,plan_id',
            'start_date'     => 'required|date|after_or_equal:today',
            'payment_method' => 'required|in:cash,vnpay,momo',
        ]);

        [$subscription, $actualPrice] = $this->subscriptionService->handleSubscription($request->validated());

        $payment = $this->subscriptionService->handlePayment($subscription, $actualPrice, $request->payment_method);

        return $this->subscriptionService->processPayment($payment, $request->payment_method);
    }
}
