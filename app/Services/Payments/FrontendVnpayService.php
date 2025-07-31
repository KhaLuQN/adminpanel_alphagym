<?php
namespace App\Services\Payments;

class FrontendVnpayService
{
    protected $vnpUrl;
    protected $vnpReturnUrl;
    protected $vnpTmnCode;
    protected $vnpHashSecret;

    public function __construct()
    {
        $this->vnpUrl        = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $this->vnpReturnUrl  = route('api.vnpay.return'); // Changed for frontend API
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
            "vnp_OrderType"  => $vnp_OrderType,
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
}
