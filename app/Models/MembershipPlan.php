<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembershipPlan extends Model
{
    use SoftDeletes;

    protected $table = 'membership_plans';

    protected $primaryKey = 'plan_id';

    protected $fillable = [
        'plan_name',
        'duration_days',
        'price',
        'discount_percent',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(MemberSubscription::class, 'plan_id');
    }
}
