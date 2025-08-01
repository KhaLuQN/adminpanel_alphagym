<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\Payments\VnpayService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiVnpayReturnController extends Controller
{
    protected $vnpayService;

    public function __construct(VnpayService $vnpayService)
    {
        $this->vnpayService = $vnpayService;
    }

    public function handleReturn(Request $request)
    {
        Log::info('VNPAY API Return: Incoming request', ['request' => $request->all()]);

        $vnp_HashSecret = env('VNPAY_HASHSECRET');
        $inputData      = $request->all();
        $secureHash     = $inputData['vnp_SecureHash'];

        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);

        $hashData  = http_build_query($inputData, '', '&');
        $checkHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash !== $checkHash) {
            Log::error('VNPAY API Return: Invalid checksum', ['request' => $request->all()]);
            return response()->json(['message' => 'Chữ ký không hợp lệ.'], 400);
        }
        Log::info('VNPAY API Return: Checksum valid.');

        $paymentId    = $request->input('vnp_TxnRef');
        $responseCode = $request->input('vnp_ResponseCode');

        $payment = Payment::find($paymentId);

        if (! $payment) {
            Log::error('VNPAY API Return: Payment not found', ['vnp_TxnRef' => $paymentId]);
            return response()->json(['message' => 'Không tìm thấy giao dịch thanh toán.'], 404);
        }

        if ($payment->payment_status === 'paid') {
            Log::info('VNPAY API Return: Transaction already processed', ['payment_id' => $paymentId]);
            return response()->json(['message' => 'Giao dịch này đã được xử lý trước đó.', 'status' => 'success'], 200);
        }

        if ($responseCode === '00') {
            // Giao dịch THÀNH CÔNG
            $payment->payment_status = 'paid';
            $payment->payment_date   = Carbon::createFromFormat('YmdHis', $request->input('vnp_PayDate'));
            $payment->save();
            Log::info('VNPAY API Return: Transaction successful', ['payment_id' => $paymentId, 'status' => 'success']);
            return redirect(config('app.frontend_url') . '/payment-status?status=success&message=' . urlencode('Thanh toán thành công! Bạn có thể đến phòng gym để bắt đầu tập luyện.') . '&payment_id=' . $paymentId);
        } else {
            // Giao dịch THẤT BẠI
            $payment->payment_status = 'failed';
            $payment->save();
            Log::info('VNPAY API Return: Transaction failed', ['payment_id' => $paymentId, 'status' => 'failed', 'response_code' => $responseCode]);
            return redirect(config('app.frontend_url') . '/payment-status?status=failed&message=' . urlencode('Thanh toán thất bại hoặc đã bị hủy.') . '&payment_id=' . $paymentId . '&response_code=' . $responseCode);
        }
    }
}
