<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Checkin;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckinController extends Controller
{
    public function index(Request $request)
    {

        $query = Checkin::with('member');

        if ($request->filled('start_date')) {
            $query->whereDate('checkin_time', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('checkin_time', '<=', $request->end_date);
        }

        $checkins = $query->orderByDesc('checkin_time')->paginate(30)->withQueryString();

        return view('admin.pages.checkin.index', compact('checkins'));
    }
    public function forceCheckout($checkinId)
    {
        $checkin = Checkin::findOrFail($checkinId);

        if ($checkin->checkout_time) {
            return redirect()->back()->with('error', 'Thành viên đã check-out rồi.');
        }

        $checkin->checkout_time = now();
        $checkin->save();

        return redirect()->back()->with('success', 'Check-out thành công.');
    }

    public function forceCheckoutAll()
    {

        $updatedCount = Checkin::whereNull('checkout_time')
            ->update(['checkout_time' => now()]);

        return redirect()->back()->with('success', "Đã check-out $updatedCount thành viên.");
    }

    public function checkinPage()
    {

        return view('admin.pages.checkin.checkinPage');

    }
    public function machineCheckin(Request $request)
    {
        $request->validate([
            'rfid_card_id' => 'required|string',
        ]);

        $rfid = $request->input('rfid_card_id');

        $member = Member::where('rfid_card_id', $rfid)->first();

        if (! $member) {
            return back()->with('message', 'Không tìm thấy thành viên với mã thẻ này.');
        }
        if ($member->status !== 'active') {
            return back()->with('message', 'Thẻ bị lỗi hoặc không hợp lệ. Vui lòng liên hệ quản lý.');
        }
        $today = \Carbon\Carbon::today();

        $hasActiveSubscription = DB::table('membersubscriptions')
            ->join('payments', 'membersubscriptions.subscription_id', '=', 'payments.subscription_id')
            ->where('membersubscriptions.member_id', $member->member_id)
            ->where('membersubscriptions.end_date', '>=', today())
            ->where('payments.payment_status', 'paid')
            ->exists();

        if (! $hasActiveSubscription) {
            return back()->with('error', 'Hội viên ' . $member->full_name . ' đã hết hạn gói tập. Vui lòng gia hạn!');
        }

        $existingCheckin = Checkin::where('member_id', $member->member_id)
            ->whereNull('checkout_time')
            ->orderBy('checkin_time', 'desc')
            ->first();

        if ($existingCheckin) {

            $existingCheckin->update(['checkout_time' => now()]);
            return back()->with('message', 'Đã check-out cho ' . $member->full_name);
        } else {

            Checkin::create([
                'member_id'    => $member->member_id,
                'rfid_card_id' => $member->rfid_card_id,
                'checkin_time' => now(),
            ]);
            return back()->with('message', 'Đã check-in cho ' . $member->full_name);
        }

    }

}
