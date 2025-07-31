<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MembershipPlan;
use App\Models\Payment;
use App\Services\MemberSubscriptionService;
use App\Services\Payments\VnpayService;
use Illuminate\Http\Request;

class MemberSubscriptionController extends Controller
{
    protected $subscriptionService;

    public function __construct(MemberSubscriptionService $subscriptionService,
        VnpayService $vnpayService,
    ) {
        $this->subscriptionService = $subscriptionService;
        $this->vnpayService        = $vnpayService;
    }

    public function create()
    {
        $members = Member::all();

// Tạo mảng JSON-ready ngay tại controller
        $membersJson = $members->map(function ($member) {
            return [
                'id'    => $member->member_id,
                'name'  => $member->full_name,
                'phone' => $member->phone,
                'rfid'  => $member->rfid_card_id,
            ];
        })->values()->all();

        $packages = MembershipPlan::orderBy('price', 'asc')->paginate(10);

        return view('admin.pages.subscriptions.create', compact('packages', 'members', 'membersJson'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id'      => 'required|exists:members,member_id',
            'package_id'     => 'required|exists:membership_plans,plan_id',
            'start_date'     => 'required|date|after_or_equal:today',
            'payment_method' => 'required|in:cash,vnpay,momo',
        ]);

        [$subscription, $actualPrice] = $this->subscriptionService->handleSubscription($request);

        $payment = Payment::create([
            'subscription_id' => $subscription->subscription_id,
            'amount'          => $actualPrice,
            'payment_method'  => $request->payment_method,
            'status'          => 'pending',
        ]);

        if ($request->payment_method === 'cash') {
            $payment->update(['payment_status' => 'paid', 'payment_date' => now()]);
            return redirect()->back()->with('success', 'Đăng ký gói tập và thanh toán tiền mặt thành công!');
        }

        if ($request->payment_method === 'vnpay') {
            $url = $this->vnpayService->generatePaymentUrl($payment->payment_id, $actualPrice);
            return redirect($url);
        }

        return redirect()->back()->with('error', 'Phương thức thanh toán không hợp lệ.');
    }
}
