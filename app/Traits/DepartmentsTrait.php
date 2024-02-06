<?php

namespace App\Traits;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use JsonException;


trait DepartmentsTrait
{
    /**
     * Json file about French regions and departments
     *
     * @return Collection
     * @throws GuzzleException
     * @throws JsonException|JsonException
     */

    public function fetchDepartments(): Collection
    {
        $client = new Client();

        try {
            $response = $client->get('https://static.data.gouv.fr/resources/departements-et-leurs-regions/20190815-175403/departements-region.json');
            $data = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);

            if (is_array($data) && count($data) > 0) {
                $departments = collect($data)
                    ->map(function ($item) {
                        return ucwords(mb_strtolower($item['dep_name']));
                    });

                return $departments->sortBy(SORT_NATURAL | SORT_FLAG_CASE);
            }
        } catch (RequestException $e) {
            Log::error('Error fetching departments from json file: ' . $e->getMessage());
        }

        return collect();
    }
}
