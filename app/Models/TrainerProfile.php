<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainerProfile extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trainer_profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'member_id',
        'photo_url',
        'specialty',
        'bio',
        'certifications',
        'experience_years',
        'facebook_url',
        'instagram_url',
    ];

    /**
     * Get the member that owns the trainer profile.
     * Defines an inverse one-to-one relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member(): BelongsTo
    {

        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

}
