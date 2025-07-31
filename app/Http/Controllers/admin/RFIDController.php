<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\RFIDService;
use Illuminate\Http\Request;

class RFIDController extends Controller
{
    protected $rfidService;

    public function __construct(RFIDService $rfidService)
    {
        $this->rfidService = $rfidService;
    }

    /**
     * Hiển thị danh sách thẻ RFID
     */
    public function index()
    {
        $members = $this->rfidService->getMembersWithRfid();

        return view('admin.pages.rfid.index', compact('members'));
    }

    /**
     * Cập nhật trạng thái thẻ RFID (khóa/mở)
     */
    public function update(Request $request, $id)
    {
        try {
            $this->rfidService->updateRfidStatus($id, $request->status);
            return redirect()->back()
                ->with('success', 'Cập nhật trạng thái thẻ thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Gỡ thẻ RFID khỏi thành viên
     */
    public function destroy($id)
    {
        try {
            $this->rfidService->detachRfid($id);
            return redirect()->back()
                ->with('success', 'Đã gỡ thẻ RFID khỏi thành viên!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }
}
