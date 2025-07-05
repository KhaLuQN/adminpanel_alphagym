<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonial extends Model
{
    use HasFactory;

    /**
     * Ghi đè khóa chính mặc định (id) của Laravel.
     *
     * @var string
     */
    protected $primaryKey = 'testimonial_id';

    /**
     * Các trường được phép gán hàng loạt (mass-assignable).
     * Quan trọng cho việc sử dụng Testimonial::create().
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_name',
        'testimonial_content',
        'rating',
        'member_id',
        'image_url',
        'is_approved',
        'display_on_website',
        'submitted_at',
    ];

    /**
     * Tự động chuyển đổi các thuộc tính sang kiểu dữ liệu mong muốn.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rating'             => 'integer',
        'is_approved'        => 'boolean',
        'display_on_website' => 'boolean',
        'submitted_at'       => 'datetime',
    ];

    /**
     * Định nghĩa mối quan hệ: một testimonial thuộc về một member (nếu có).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member(): BelongsTo
    {

        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }
}
