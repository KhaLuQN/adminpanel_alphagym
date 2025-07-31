<?php

namespace App\Services;

use App\Models\Member;

class RFIDService
{
    public function getMembersWithRfid()
    {
        return Member::whereNotNull('rfid_card_id')
            ->orderBy('status', 'desc')
            ->orderBy('join_date', 'desc')
            ->get();
    }

    public function updateRfidStatus(int $memberId, string $status)
    {
        $member = Member::findOrFail($memberId);

        if (empty($member->rfid_card_id)) {
            throw new \Exception('Thành viên này không có thẻ RFID!');
        }

        $member->update([
            'status'     => $status,
            'updated_at' => now(),
        ]);

        return true;
    }

    public function detachRfid(int $memberId)
    {
        $member = Member::findOrFail($memberId);

        if (empty($member->rfid_card_id)) {
            throw new \Exception('Thành viên này không có thẻ RFID!');
        }

        $member->update([
            'rfid_card_id' => null,
            'updated_at'   => now(),
        ]);

        return true;
    }
}
