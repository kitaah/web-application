<?php

namespace App\Models;

use Illuminate\Database\{Eloquent\Factories\HasFactory, Eloquent\Relations\BelongsTo, Eloquent\Relations\Pivot};

/**
 * @method static count()
 * @method static where(string $string, string $string1)
 * @method static oldest()
 * @method static inRandomOrder()
 */
class CreateCompetition extends Pivot
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'create_competitions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'status',
        'is_published',
        'association_id',
        'association_id_second',
        'association_id_third',
        'competition_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * Get the association that this model belongs to.
     *
     * @return BelongsTo
     */
    public function association(): BelongsTo
    {
        return $this->belongsTo(Association::class);
    }

    /**
     * Get the competition associated with this model.
     *
     * @return BelongsTo
     */
    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }
}
