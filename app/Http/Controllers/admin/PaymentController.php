<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::query();

        $query->with(['subscription.member', 'subscription.plan']);

        $payments = $query->latest('payment_date')->paginate(20)->withQueryString();

        return view('admin.pages.payments.index', [
            'payments' => $payments,
            'filters'  => $request->all(),

        ]);

    }
}
