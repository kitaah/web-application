<?php

namespace App\Models;

use Illuminate\Database\{Eloquent\Factories\HasFactory, Eloquent\Model, Eloquent\Relations\BelongsTo};
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @method static count()
 * @method static latest()
 * @method static where(string $string, $slug)
 * @method static create(array $array)
 * @method static findOrFail($id)
 * @method static inRandomOrder()
 * @property mixed $category_id
 * @property mixed $description
 * @property mixed $slug
 * @property int|mixed|string|null $user_id
 * @property mixed $url
 * @property mixed $name
 * @property mixed $id
 * @property mixed $is_validated
 * @property mixed $status
 * @property mixed $category
 * @property mixed $user
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class Resource extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'user_id',
        'name',
        'slug',
        'description',
        'url',
        'is_validated',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_validated' => 'boolean',
    ];

    /**
     * Get the category that this model belongs to.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the user associated with this model.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
