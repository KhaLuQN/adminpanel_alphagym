<?php
namespace App\Services\Payments;

use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class VnpayService
{
    protected $vnpUrl;
    protected $vnpReturnUrl;
    protected $vnpTmnCode;
    protected $vnpHashSecret;

    public function __construct()
    {
        $this->vnpUrl        = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $this->vnpReturnUrl  = route('vnpay.return');
        $this->vnpTmnCode    = env('VNPAY_TMNCODE');
        $this->vnpHashSecret = env('VNPAY_HASHSECRET');
    }

    public function generatePaymentUrl($transactionId, $amount, $orderInfo = null)
    {
        $vnp_TxnRef = (string) $transactionId;

        $vnp_OrderInfo = $orderInfo ?? 'Thanh toan goi tap gym ' . $vnp_TxnRef;
        $vnp_OrderType = 'gym_membership';
        $vnp_Amount    = (int) ($amount * 100);

        $vnp_Locale     = 'vn';
        $vnp_IpAddr     = request()->ip();
        $vnp_ExpireDate = now()->addMinutes(15)->format('YmdHis');

        $inputData = [
            "vnp_Version"    => "2.1.0",
            "vnp_TmnCode"    => $this->vnpTmnCode,
            "vnp_Amount"     => $vnp_Amount,
            "vnp_Command"    => "pay",
            "vnp_CreateDate" => now()->format('YmdHis'),
            "vnp_CurrCode"   => "VND",
            "vnp_IpAddr"     => $vnp_IpAddr,
            "vnp_Locale"     => $vnp_Locale,
            "vnp_OrderInfo"  => $vnp_OrderInfo,
            "vnp_OrderType"  => "gym_membership",
            "vnp_ReturnUrl"  => $this->vnpReturnUrl,
            "vnp_TxnRef"     => $vnp_TxnRef,
            "vnp_ExpireDate" => $vnp_ExpireDate,
        ];

        ksort($inputData);

        $queryString   = http_build_query($inputData, '', '&', );
        $vnpSecureHash = hash_hmac('sha512', $queryString, $this->vnpHashSecret);
        $vnpUrl        = $this->vnpUrl . '?' . $queryString . '&vnp_SecureHash=' . $vnpSecureHash;

        return $vnpUrl;
    }

    public function handleVnpayReturn(array $requestData): array
    {
        $vnp_HashSecret = env('VNPAY_HASHSECRET');
        $secureHash     = $requestData['vnp_SecureHash'];

        unset($requestData['vnp_SecureHashType']);
        unset($requestData['vnp_SecureHash']);
        ksort($requestData);

        $hashData  = http_build_query($requestData, '', '&');
        $checkHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash !== $checkHash) {
            Log::error('VNPAY Return: Invalid checksum', ['request' => $requestData]);
            return ['status' => 'error', 'message' => 'Chữ ký không hợp lệ.', 'payment_id' => $paymentId ?? null, 'response_code' => $responseCode ?? null];
        }

        $paymentId    = $requestData['vnp_TxnRef'];
        $responseCode = $requestData['vnp_ResponseCode'];

        $payment = Payment::find($paymentId);

        if (! $payment) {
            return ['status' => 'error', 'message' => 'Không tìm thấy giao dịch thanh toán.', 'payment_id' => $paymentId, 'response_code' => $responseCode];
        }

        if ($payment->payment_status === 'paid') {
            return ['status' => 'error', 'message' => 'Giao dịch này đã được xử lý trước đó.', 'payment_id' => $paymentId, 'response_code' => $responseCode];
        }

        if ($responseCode === '00') {
            // Giao dịch THÀNH CÔNG
            $payment->payment_status = 'paid';
            $payment->payment_date   = Carbon::createFromFormat('YmdHis', $requestData['vnp_PayDate']);
            $payment->save();

            return ['status' => 'success', 'message' => 'Thanh toán thành công!', 'payment_id' => $paymentId, 'response_code' => $responseCode];
        } else {
            $payment->payment_status = 'failed';
            $payment->save();
            if ($payment->memberSubscription) {
                $payment->memberSubscription->delete();
            }

            return ['status' => 'error', 'message' => 'Thanh toán thất bại hoặc đã bị hủy.', 'payment_id' => $paymentId, 'response_code' => $responseCode];
        }
    }
}
