<?php
// File: app/Models/PlanFeature.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanFeature extends Model
{
    use HasFactory;
    protected $primaryKey = 'feature_id';
    public $timestamps    = false;
    protected $fillable   = ['name', 'description', 'icon'];

    public function membershipPlans()
    {
        return $this->belongsToMany(MembershipPlan::class, 'membership_plan_feature', 'feature_id', 'plan_id');
    }
}
