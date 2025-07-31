<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\CheckinService;
use Illuminate\Http\Request;

class CheckinController extends Controller
{
    protected $checkinService;

    public function __construct(CheckinService $checkinService)
    {
        $this->checkinService = $checkinService;
    }

    public function index(Request $request)
    {
        $checkins = $this->checkinService->getCheckinsForIndex($request->all());
        return view('admin.pages.checkin.index', compact('checkins'));
    }

    public function forceCheckout($checkinId)
    {
        try {
            $this->checkinService->forceCheckout($checkinId);
            return redirect()->back()->with('success', 'Check-out thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function forceCheckoutAll()
    {
        $updatedCount = $this->checkinService->forceCheckoutAll();
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

        $result = $this->checkinService->handleMachineCheckin($request->input('rfid_card_id'));

        if ($result['status'] === 'success') {
            return back()->with('message', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }
}
