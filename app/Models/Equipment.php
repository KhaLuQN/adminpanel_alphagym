<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'img',
        'purchase_date',
        'status',
        'location',
        'notes',
    ];

    protected $dates = [
        'purchase_date',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'purchase_date' => 'date:Y-m-d',
    ];

    /**
     * Get the full URL of the equipment image.
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
