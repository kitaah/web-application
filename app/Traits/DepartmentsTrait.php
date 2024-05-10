<?php

namespace App\Traits;

use GuzzleHttp\{Exception\GuzzleException, Client, Exception\RequestException};
use Illuminate\{Support\Collection, Support\Facades\Log};
use JsonException;


trait DepartmentsTrait
{
    /**
     * Json file about French departments
     *
     * @return Collection
     * @throws GuzzleException
     * @throws JsonException|JsonException
     */
    public function fetchDepartments(): Collection
    {
        $client = new Client();
        $departments = collect();

        try {
            $response = $client->get('https://static.data.gouv.fr/resources/departements-et-leurs-regions/20190815-175403/departements-region.json');

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

                if (is_array($data) && count($data) > 0) {
                    $departments = collect($data)
                        ->map(function ($item) {
                            return htmlspecialchars(ucfirst(trim($item['dep_name'])), ENT_COMPAT | ENT_HTML5, 'UTF-8');
                        })
                        ->sortBy(SORT_NATURAL | SORT_FLAG_CASE);
                }
            } else {
                Log::error('Error fetching departments from json file: Invalid response code ' . $response->getStatusCode());
            }
        } catch (RequestException $e) {
            Log::error('Error fetching departments from json file: ' . $e->getMessage());
        }

        return $departments;
    }
}
