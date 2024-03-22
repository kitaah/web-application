<?php

namespace App\Models;

use Illuminate\{Database\Eloquent\Factories\HasFactory, Database\Eloquent\Model, Database\Eloquent\Relations\BelongsTo};

/**
 * @method static create(array $array)
 * @method static where(string $string, $id)
 * @method static latest()
 * @property int|mixed|string|null $user_id
 * @property mixed $resource_id
 * @property mixed $content
 */
class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'resource_id',
        'content',
        'is_published',
        'is_reported',
        'moderation_comment',
        'is_user_banned',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_published' => 'boolean',
        'is_reported' => 'boolean',
        'is_user_banned' => 'boolean',
    ];

    /**
     * Get the user that owns the comment.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the resource that the comment belongs to.
     *
     * @return BelongsTo
     */
    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class);
    }
}
