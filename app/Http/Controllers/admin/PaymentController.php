<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function index(Request $request)
    {
        $payments = $this->paymentService->getPaymentsForIndex($request->all());

        return view('admin.pages.payments.index', [
            'payments' => $payments,
            'filters'  => $request->all(),

        ]);

    }
}
