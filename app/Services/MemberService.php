<?php
namespace App\Services;

use App\Models\Member;
use Illuminate\Http\UploadedFile;

class MemberService
{
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

            $member->img = $this->storeMemberImage($validatedData['img']);
        }

        $member->save();

        return $member;
    }

    private function storeMemberImage(UploadedFile $file): string
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('admin/images/member'), $filename);
        return 'admin/images/member/' . $filename;
    }
}
