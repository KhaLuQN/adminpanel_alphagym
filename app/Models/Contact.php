<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'message',
        'type',
    ];

    public function getSubmittedAtFormattedAttribute()
    {
        return Carbon::parse($this->submitted_at)->format('d/m/Y');
    }

    protected $casts = [
        'type' => 'string',
    ];
}
