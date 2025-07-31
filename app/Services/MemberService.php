<?php
namespace App\Services;

use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MemberService
{
    public function getMembersForIndex()
    {
        return Member::select('member_id', 'full_name', 'phone', 'email'
            , 'status', 'img', 'rfid_card_id')
            ->latest('member_id')
            ->get();
    }

    public function createMember(array $validatedData): Member
    {
        if (isset($validatedData['rfid_card_id'])) {
            $exists = Member::where('rfid_card_id', $validatedData['rfid_card_id'])->exists();
            if ($exists) {
                throw new \Exception('Thẻ RFID này đã được sử dụng bởi thành viên khác.');
            }
        }

        $member = new Member();
        $member->fill($validatedData);
        $member->status = 'active';

        if (isset($validatedData['img'])) {
            $member->img = $this->storeMemberImage($validatedData['img']);
        }

        $member->save();

        return $member;
    }

    public function updateMember(Member $member, array $validatedData): Member
    {
        if (isset($validatedData['rfid_card_id'])) {
            $existingRfid = Member::where('rfid_card_id', $validatedData['rfid_card_id'])
                ->where('member_id', '!=', $member->member_id)
                ->first();

            if ($existingRfid) {
                throw new \Exception('Thẻ RFID này đã được sử dụng bởi thành viên khác.');
            }
        }

        $member->fill($validatedData);

        if (isset($validatedData['img'])) {
            if ($member->img) {
                Storage::disk('public')->delete($member->img);
            }
            $member->img = $this->storeMemberImage($validatedData['img']);
        }

        $member->save();

        return $member;
    }

    public function deleteMember(Member $member): void
    {
        if ($member->img) {
            Storage::disk('public')->delete($member->img);
        }
        $member->delete();
    }

    public function getMemberProfileData(Member $member): array
    {
        $member->load([
            'checkins' => function ($query) {
                $query->orderBy('checkin_time', 'desc')->limit(10);
            },
        ]);

        $totalCheckins     = $member->checkins()->count();
        $lastMonthCheckins = $member->checkins()
            ->where('checkin_time', '>=', Carbon::now()->subMonth())
            ->count();
        $avgSessionTime = $this->calculateAvgSessionTime($member);

        $subscriptions = $member->subscriptions()
            ->whereHas('payments', function ($query) {
                $query->where('payment_status', 'paid');
            })
            ->get();

        return compact(
            'member',
            'totalCheckins',
            'lastMonthCheckins',
            'avgSessionTime',
            'subscriptions'
        );
    }

    private function calculateAvgSessionTime(Member $member): ?array
    {
        $sessions = $member->checkins()
            ->whereNotNull('checkout_time')
            ->get();

        if ($sessions->isEmpty()) {
            return null;
        }

        $totalSeconds = 0;
        foreach ($sessions as $session) {
            $totalSeconds += Carbon::parse($session->checkin_time)->diffInSeconds(Carbon::parse($session->checkout_time));
        }

        $avgSeconds = $totalSeconds / $sessions->count();

        return [
            'hours'   => floor($avgSeconds / 3600),
            'minutes' => floor(($avgSeconds % 3600) / 60),
        ];
    }

    private function storeMemberImage(UploadedFile $file): string
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        return $file->storeAs('member', $filename, 'public');
    }
}
