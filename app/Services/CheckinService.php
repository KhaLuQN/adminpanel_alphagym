<?php

namespace App\Services;

use App\Models\Checkin;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CheckinService
{
    public function getCheckinsForIndex(array $filters)
    {
        $query = Checkin::with('member');

        if (isset($filters['start_date'])) {
            $query->whereDate('checkin_time', '>=', $filters['start_date']);
        }

        if (isset($filters['end_date'])) {
            $query->whereDate('checkin_time', '<=', $filters['end_date']);
        }

        return $query->orderByDesc('checkin_time')->paginate(30)->withQueryString();
    }

    public function forceCheckout(int $checkinId)
    {
        $checkin = Checkin::findOrFail($checkinId);

        if ($checkin->checkout_time) {
            throw new \Exception('Thành viên đã check-out rồi.');
        }

        $checkin->checkout_time = now();
        $checkin->save();

        return true;
    }

    public function forceCheckoutAll()
    {
        return Checkin::whereNull('checkout_time')
            ->update(['checkout_time' => now()]);
    }

    public function handleMachineCheckin(string $rfidCardId)
    {
        $member = Member::where('rfid_card_id', $rfidCardId)->first();

        if (! $member) {
            return ['status' => 'error', 'message' => 'Không tìm thấy thành viên với mã thẻ này.'];
        }

        if ($member->status !== 'active') {
            return ['status' => 'error', 'message' => 'Thẻ bị lỗi hoặc không hợp lệ. Vui lòng liên hệ quản lý.'];
        }

        $hasActiveSubscription = DB::table('membersubscriptions')
            ->join('payments', 'membersubscriptions.subscription_id', '=', 'payments.subscription_id')
            ->where('membersubscriptions.member_id', $member->member_id)
            ->where('membersubscriptions.end_date', '>=', Carbon::today())
            ->where('payments.payment_status', 'paid')
            ->exists();

        if (! $hasActiveSubscription) {
            return ['status' => 'error', 'message' => 'Hội viên ' . $member->full_name . ' đã hết hạn gói tập. Vui lòng gia hạn!'];
        }

        $existingCheckin = Checkin::where('member_id', $member->member_id)
            ->whereNull('checkout_time')
            ->orderBy('checkin_time', 'desc')
            ->first();

        if ($existingCheckin) {
            $existingCheckin->update(['checkout_time' => now()]);
            return ['status' => 'success', 'message' => 'Đã check-out cho ' . $member->full_name];
        } else {
            Checkin::create([
                'member_id'    => $member->member_id,
                'rfid_card_id' => $member->rfid_card_id,
                'checkin_time' => now(),
            ]);
            return ['status' => 'success', 'message' => 'Đã check-in cho ' . $member->full_name];
        }
    }
}
