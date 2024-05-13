<?php

namespace App\Models;

use Illuminate\{Database\Eloquent\Factories\HasFactory, Database\Eloquent\Model, Database\Eloquent\Relations\HasMany};

/**
 * @method static find(mixed $user_id)
 * @method static pluck(string $string, string $string1)
 * @method static inRandomOrder()
 * @method static orderBy(string $string, string $string1)
 */
class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'name',
        'slug',
    ];

    /**
     * Get the resources associated with this category.
     *
     * @return HasMany
     */
    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class);
    }

    /**
     * Get the associations associated with this category.
     *
     * @return HasMany
     */
    public function associations(): HasMany
    {
        return $this->hasMany(Association::class);
    }
}
