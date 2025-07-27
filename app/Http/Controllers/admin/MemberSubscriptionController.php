<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MembershipPlan;
use App\Models\MemberSubscription;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MemberSubscriptionController extends Controller
{

    public function create()
    {
        $members = Member::all();

        $packages = MembershipPlan::orderBy('price', 'asc')->paginate(10);
        return view(
            'admin.pages.subscriptions.create', compact('packages', 'members'));

    }

    public function store(Request $request)
    {

        $request->validate([
            'member_id'      => 'required|exists:members,member_id',
            'package_id'     => 'required|exists:membership_plans,plan_id',
            'start_date'     => 'required|date|after_or_equal:today',
            'payment_method' => 'required|in:cash,vnpay,momo',
        ]);

        $package = MembershipPlan::findOrFail($request->package_id);

        $actualPrice = $package->price * (1 - $package->discount_percent / 100);

        $currentSubscription = MemberSubscription::where('member_id', $request->member_id)
            ->where('end_date', '>=', now())
            ->orderByDesc('end_date')
            ->first();

        if ($currentSubscription) {

            $startDate = Carbon::parse($currentSubscription->end_date)->addDay();
        } else {

            $startDate = Carbon::parse($request->start_date);
        }

        $endDate = $startDate->copy()->addDays($package->duration_days);

        if ($request->payment_method === 'cash') {

            $subscription = MemberSubscription::create([
                'member_id'    => $request->member_id,
                'plan_id'      => $package->plan_id,
                'start_date'   => $startDate->toDateString(),
                'end_date'     => $endDate->toDateString(),
                'actual_price' => $actualPrice,

            ]);

            Payment::create([
                'subscription_id' => $subscription->subscription_id,
                'amount'          => $actualPrice,
                'payment_date'    => now(),
                'payment_method'  => 'cash',
                'notes'           => 'Thanh toán tiền mặt tại quầy',
                'payment_status'  => 'paid',
            ]);

            return redirect()->back()->with('success', 'Đăng ký gói tập thành công và thanh toán tiền mặt!');
        }

        return redirect()->back()->with('error', 'Chức năng thanh toán MoMo đang được phát triển.');
    }

}
