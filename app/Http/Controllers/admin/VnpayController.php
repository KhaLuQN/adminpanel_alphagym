<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class VnpayController extends Controller
{
    public function redirectToGateway($payment_id)
    {
        $payment = Payment::findOrFail($payment_id);

    }

}
