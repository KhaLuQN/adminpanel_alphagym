<?php
namespace App\Services;

use App\Models\Payment;

class PaymentService
{
    public function getPaymentsForIndex(array $filters)
    {
        $query = Payment::query();

        $query->with(['subscription.member', 'subscription.plan']);

        return $query->latest('payment_date')->get();
    }
}
