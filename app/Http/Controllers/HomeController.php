<?php

namespace App\Http\Controllers;

use App\Models\{Association, Category, Competition, CreateCompetition, Resource, User};
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * Competition controller.
     *
     * @return Response
     */

    public function index(): Response
    {
        $resources = Resource::inRandomOrder()->limit(5)->get()->map(function ($resource) {
            return [
                'id' => $resource->id,
                'name' => $resource->name,
                'slug' => $resource->slug,
                'description' => $resource->description,
                'category_name' => optional($resource->category)->name,
                'created_at' => $resource->created_at->format('d/m/Y'),
            ];
        });

        $user = Auth::user();

        if ($user) {
            $users = User::where('department', $user->department)
                ->where('id', '!=', $user->id)
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'Citoyen');
                })
                ->inRandomOrder()
                ->take(25)
                ->get()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'image' => $user->getFirstMediaUrl('image'),
                    ];
                });
        } else {
            $users = [];
        }

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

        return Inertia::render('Home', [
            'resources' => $resources,
            'users' => $users,
            'competition' => $competitionData
        ]);
    }

    /**
     * Timestamp conversion.
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
