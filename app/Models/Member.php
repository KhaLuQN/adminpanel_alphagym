<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Member extends Model
{
    use SoftDeletes;

    protected $table      = 'members';
    protected $primaryKey = 'member_id';

    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'rfid_card_id',
        'join_date',
        'status',
        'total_months_paid',
        'notes',
        'img',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(MemberSubscription::class, 'member_id');
    }

    public function latestSubscription()
    {
        return $this->hasOne(MemberSubscription::class, 'member_id')
            ->latestOfMany('end_date');
    }

    public function checkins()
    {
        return $this->hasMany(Checkin::class, 'member_id', 'member_id');
    }
    public function trainerProfile(): HasOne
    {

        return $this->hasOne(TrainerProfile::class, 'member_id', 'member_id');
    }

    /**
     * Get the full URL of the member image.
     *
     * @param  string|null  $value
     * @return string|null
     */
    public function getImgAttribute($value)
    {
        if ($value) {
            return 'storage/' . $value;
        }

        return null;
    }
}
