<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $primaryKey = 'payment_id';
    public $timestamps    = false;
    protected $fillable   = [
        'subscription_id',
        'amount',
        'payment_date',
        'payment_method',
        'notes',
        'payment_status',
    ];

    public function subscription()
    {
        return $this->belongsTo(MemberSubscription::class, 'subscription_id', 'subscription_id');
    }
}
