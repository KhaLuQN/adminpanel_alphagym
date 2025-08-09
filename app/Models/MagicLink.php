<?php
namespace App\Models;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MagicLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'token',
        'expires_at',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');

    }

    public function isUsed()
    {
        return ! is_null($this->used_at);
    }

    public function markAsUsed()
    {
        $this->update(['used_at' => now()]);
    }
}
