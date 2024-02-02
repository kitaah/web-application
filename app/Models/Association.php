<?php

namespace App\Models;

use Illuminate\{Database\Eloquent\Factories\HasFactory, Database\Eloquent\Model, Support\Collection};
use JsonException;
use Spatie\MediaLibrary\{HasMedia, InteractsWithMedia};

/**
 * @method static count()
 * @method static find($associationId)
 */
class Association extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'project',
        'siret',
        'city',
        'points',
        'is_winner',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_winner' => 'boolean',
    ];

    /**
     * @return Collection
     * @throws JsonException
     */
    public function fetchCitiesFromAPI(): Collection
    {
        $json = file_get_contents('https://www.data.gouv.fr/fr/datasets/r/521fe6f9-0f7f-4684-bb3f-7d3d88c581bb');
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        if ($data !== null && isset($data['cities']) && is_array($data['cities']) && count($data['cities']) > 0) {
            $cities = collect($data['cities'])
                ->map(function ($city) {
                    return [
                        'id' => $city['insee_code'],
                        'label' => ucwords(mb_strtolower($city['label'])),
                    ];
                });

            return $cities->sortBy('label', SORT_NATURAL | SORT_FLAG_CASE);
        }

        return collect();
    }
}
