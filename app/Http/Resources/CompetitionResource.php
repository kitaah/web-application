<?php

namespace App\Http\Resources;

use App\Models\Association;
use App\Models\Competition;
use DateTime;
use Illuminate\{Http\Request, Http\Resources\Json\JsonResource};
use OpenApi\Annotations as OA;

/**
 * @property mixed $name
 * @property mixed $slug
 * @property mixed $competition
 * @property mixed $id
 * @property mixed $association
 * @property mixed $association_id
 * @property mixed $competition_id
 * @property mixed $association_id_second
 * @property mixed $association_id_third
 * @method getFirstMediaUrl(string $string)
 */
class CompetitionResource extends JsonResource
{
    /**
     * @OA\Get(
     *     path="/api/competition",
     *     operationId="getCurrentCompetition",
     *     tags={"Competition"},
     *     summary="Get current competition information",
     *      @OA\Response(
     *       response=200,
     *       description="Successful operation",
     *      ),
     *      @OA\Response(
     *       response=401,
     *       description="Unauthorized - Invalid credentials",
     *      ),
     *      @OA\Response(
     *       response=403,
     *       description="Forbidden"
     *      ),
     *      @OA\Response(
     *        response=404,
     *        description="Not found"
     *      ),
     *  ),
     * @OA\Server(
     *   url="https://web-application.ddev.site:8443/"
     *  )
     *
     *  Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     *
     */
    public function toArray(Request $request): array
    {
        return array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'competition' => $this->getCompetitionData($this->competition_id),
            'association_first' => $this->getAssociationData($this->association_id),
            'association_second' => $this->getAssociationData($this->association_id_second),
            'association_third' => $this->getAssociationData($this->association_id_third),
        ]);
    }

    /**
     * Retrieves competition data based on its ID.
     *
     * @param $competitionId
     * @return array|null
     */
    private function getCompetitionData($competitionId): ?array
    {
        $competition = Competition::find($competitionId);

        return $competition
            ? [
                'start_date' => DateTime::createFromFormat('Y-m-d', $competition->start_date)->format('d/m/Y'),
                'end_date' => DateTime::createFromFormat('Y-m-d', $competition->end_date)->format('d/m/Y'),
                'budget' => $this->formatCompetitionBudget($competition->budget),
            ]
            : null;
    }

    /**
     * Formats the competition budget with spaces for thousands and adds the specified symbol.
     *
     * @param $budget
     * @return string|null
     */
    private function formatCompetitionBudget($budget): ?string
    {
        return $budget !== null ? number_format($budget, 0, ',', ' ') . '€' : null;
    }

    /**
     * Retrieves association data based on its ID.
     *
     * @param $associationId
     * @return array|null
     */
    private function getAssociationData($associationId): ?array
    {
        $association = Association::find($associationId);

        return $association
            ? [
                'name' => $association->name,
                'description' => $association->description,
                'project' => $association->project,
                'city' => $association->city,
                'points' => $this->formatWithThousandSpaces($association->points),
                'image' => $association->getFirstMediaUrl('image'),
            ]
            : null;
    }

    /**
     * Formats the value with spaces for thousands and adds the specified symbol.
     *
     * @param $value
     * @return string|null
     */
    private function formatWithThousandSpaces($value): ?string
    {
        return $value !== null ? number_format($value, 0, ',', ' ') : null;
    }
}
