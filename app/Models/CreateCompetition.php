<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CreateCompetition extends Pivot
{
    use HasFactory;

    protected $table = 'create_competitions';

    protected $fillable = [
        'name',
        'slug',
        'association_id',
        'association_id_second',
        'association_id_third',
        'competition_id',
    ];

    /**
     * @return BelongsTo
     */
    public function association(): BelongsTo
    {
        return $this->belongsTo(Association::class);
    }

    /**
     * @return BelongsTo
     */
    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }
}
