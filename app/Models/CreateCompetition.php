<?php

namespace App\Models;

use Illuminate\Database\{Eloquent\Factories\HasFactory, Eloquent\Relations\BelongsTo, Eloquent\Relations\Pivot};

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
        'association_id',
        'association_id_second',
        'association_id_third',
        'competition_id',
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
