<?php

namespace App\Http\Controllers;

use App\Models\Association;
use App\Models\Competition;
use App\Models\CreateCompetition;
use DateTime;
use Illuminate\Http\Request;
use Inertia\{Inertia, Response};

class CompetitionController extends Controller
{
    /**
     * Competition controller.
     *
     * @return Response
     */
    public function index(): Response
    {
        $competition = CreateCompetition::oldest()
            ->where('is_published', true)
            ->where('status', 'En cours')
            ->get();

        $competitionData = $competition->map(function ($competition) {
            return array_filter([
                'id' => $competition->id,
                'name' => $competition->name,
                'slug' => $competition->slug,
                'competition' => $this->getCompetitionData($competition->competition_id),
                'association_first' => $this->getAssociationData($competition->association_id),
                'association_second' => $this->getAssociationData($competition->association_id_second),
                'association_third' => $this->getAssociationData($competition->association_id_third),
            ]);
        });

        return Inertia::render('Competition/Competition', [
            'competition' => $competitionData
        ]);
    }

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
        $association = Association::findOrFail($associationId);

        return $association
            ? [
                'name' => $association->name,
                'slug' => $association->slug,
                'description' => $association->description,
                'category_name' => optional($association->category)->name,
                'project' => $association->project,
                'city' => $association->city,
                'url' => $association->url,
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
