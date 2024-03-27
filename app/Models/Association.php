<?php

namespace App\Models;

use App\Traits\DepartmentsTrait;
use Illuminate\{Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Model,
    Database\Eloquent\Relations\BelongsTo,
    Support\Collection};
use JsonException;
use Spatie\MediaLibrary\{HasMedia, InteractsWithMedia};

/**
 * @method static count()
 * @method static findOrFail($associationId)
 * @method static firstOrFail()
 * @method static where(string $string, string $slug)
 * @method static updateCounter(string $string)
 */
class Association extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, DepartmentsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'description',
        'project',
        'siret',
        'department',
        'address',
        'contact_information',
        'url',
        'points',
        'is_winner',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'contact_information' => 'json',
        'is_winner' => 'boolean',
    ];

    /**
     * @return Collection
     * @throws JsonException
     */

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
     * Increment the 'points' counter for association votes.
     *
     * @return void
     */
    public static function updateAssociationVotes(): void
    {
        static::updateCounter('points');
    }
}
