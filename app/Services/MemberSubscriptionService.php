<?php
namespace App\Services;

use App\Models\Member;
use App\Models\MembershipPlan;
use App\Models\MemberSubscription;
use App\Models\Payment;
use Carbon\Carbon;
use App\Services\Payments\VnpayService;

class MemberSubscriptionService
{
    protected $vnpayService;

    public function __construct(VnpayService $vnpayService)
    {
        $this->vnpayService = $vnpayService;
    }

    public function getDataForCreate(): array
    {
        $members = Member::all();
        $membersJson = $members->map(function ($member) {
            return [
                'id'    => $member->member_id,
                'name'  => $member->full_name,
                'phone' => $member->phone,
                'rfid'  => $member->rfid_card_id,
            ];
        })->values()->all();

        $packages = MembershipPlan::orderBy('price', 'asc')->paginate(10);

        return compact('packages', 'members', 'membersJson');
    }

    public function handleSubscription(array $validatedData): array
    {
        $package     = MembershipPlan::findOrFail($validatedData['package_id']);
        $actualPrice = $package->price * (1 - $package->discount_percent / 100);

        $currentSubscription = MemberSubscription::where('member_id', $validatedData['member_id'])
            ->whereHas('payments', function ($query) {
                $query->where('payment_status', 'paid');
            })
            ->where('end_date', '>=', now())
            ->orderByDesc('end_date')
            ->first();

        $startDate = $currentSubscription
        ? Carbon::parse($currentSubscription->end_date)->addDay()
        : Carbon::parse($validatedData['start_date']);

        $endDate = $startDate->copy()->addDays($package->duration_days);

        $subscription = MemberSubscription::create([
            'member_id'    => $validatedData['member_id'],
            'plan_id'      => $package->plan_id,
            'start_date'   => $startDate->toDateString(),
            'end_date'     => $endDate->toDateString(),
            'actual_price' => $actualPrice,
        ]);

        return [$subscription, $actualPrice];
    }

    public function processPayment(Payment $payment, string $paymentMethod)
    {
        if ($paymentMethod === 'cash') {
            $payment->update(['payment_status' => 'paid', 'payment_date' => now()]);
            return redirect()->back()->with('success', 'Đăng ký gói tập và thanh toán tiền mặt thành công!');
        }

        if ($paymentMethod === 'vnpay') {
            $url = $this->vnpayService->generatePaymentUrl($payment->payment_id, $payment->amount);
            return redirect($url);
        }

        return redirect()->back()->with('error', 'Phương thức thanh toán không hợp lệ.');
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
