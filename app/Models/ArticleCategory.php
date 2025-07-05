<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleCategory extends Model
{
    use HasFactory;
    use SoftDeletes; // Kích hoạt tính năng Xóa mềm

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'category_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'cover_image_url',
    ];

    /**
     * Accessor to get the full public URL for the category's cover image.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */

    /**
     * Get all of the articles for the ArticleCategory.
     * Defines a one-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles(): HasMany
    {

        return $this->hasMany(Article::class, 'article_category_id', 'category_id');
    }

    /**
     * Get the parent category of this category.
     * Defines an inverse one-to-one relationship (self-referencing).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent(): BelongsTo
    {

        return $this->belongsTo(ArticleCategory::class, 'parent_id', 'category_id');
    }

    /**
     * Get all of the children categories for this category.
     * Defines a one-to-many relationship (self-referencing).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children(): HasMany
    {

        return $this->hasMany(ArticleCategory::class, 'parent_id', 'category_id');
    }
}
