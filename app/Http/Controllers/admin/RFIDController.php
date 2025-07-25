<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class RFIDController extends Controller
{
    /**
     * Hiển thị danh sách thẻ RFID
     */
    public function index()
    {
        $members = Member::whereNotNull('rfid_card_id')
            ->orderBy('status', 'desc')
            ->orderBy('join_date', 'desc')
            ->get();

        return view('admin.pages.rfid.index', compact('members'));
    }

    /**
     * Cập nhật trạng thái thẻ RFID (khóa/mở)
     */
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        if (empty($member->rfid_card_id)) {
            return redirect()->back()
                ->with('error', 'Thành viên này không có thẻ RFID!');
        }

        $member->update([
            'status'     => $request->status,
            'updated_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Cập nhật trạng thái thẻ thành công!');
    }

    /**
     * Gỡ thẻ RFID khỏi thành viên
     */
    public function destroy($id)
    {
        $member = Member::findOrFail($id);

        if (empty($member->rfid_card_id)) {
            return redirect()->back()
                ->with('error', 'Thành viên này không có thẻ RFID!');
        }

        $member->update([
            'rfid_card_id' => null,
            'updated_at'   => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Đã gỡ thẻ RFID khỏi thành viên!');
    }

}
