<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\Payments\VnpayService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VnpayController extends Controller
{
    protected $vnpayService;

    public function __construct(VnpayService $vnpayService)
    {
        $this->vnpayService = $vnpayService;
    }

    public function handleReturn(Request $request)
    {
        $vnp_HashSecret = env('VNPAY_HASHSECRET');
        $inputData      = $request->all();
        $secureHash     = $inputData['vnp_SecureHash'];

        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);

        $hashData  = http_build_query($inputData, '', '&');
        $checkHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash !== $checkHash) {
            Log::error('VNPAY Return: Invalid checksum', ['request' => $request->all()]);
            return redirect()->route('admin.subscriptions.create')->with('error', 'Chữ ký không hợp lệ.');
        }

        $paymentId    = $request->input('vnp_TxnRef');
        $responseCode = $request->input('vnp_ResponseCode');

        $payment = Payment::find($paymentId);

        if (! $payment) {
            Log::error('VNPAY Return: Payment not found', ['vnp_TxnRef' => $subscriptionId]);
            return redirect()->route('admin.subscriptions.create')->with('error', 'Không tìm thấy giao dịch thanh toán.');
        }

        if ($payment->payment_status === 'paid') {
            return redirect()->route('admin.subscriptions.create')->with('error', 'Giao dịch này đã được xử lý trước đó.');
        }

        if ($responseCode === '00') {
            // Giao dịch THÀNH CÔNG
            $payment->payment_status = 'paid';

            $payment->payment_date = Carbon::createFromFormat('YmdHis', $request->input('vnp_PayDate'));
            $payment->save();

            return redirect()->route('admin.subscriptions.create')->with('success', 'Thanh toán thành công!');
        } else {
            // Giao dịch THẤT BẠI
            $payment->payment_status = 'failed';
            $payment->save();

            return redirect()->route('admin.subscriptions.create')->with('error', 'Thanh toán thất bại hoặc đã bị hủy.');
        }
    }
}
