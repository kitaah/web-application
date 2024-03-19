<?php

namespace App\Http\Controllers;

use App\Models\Association;
use Illuminate\{Http\JsonResponse, Http\Request};
use Inertia\{Inertia, Response};

/**
 * @method static updateCounter(string $string)
 */
class AssociationController extends Controller
{
    /**
     * Specific association.
     *
     * @param string $slug
     * @return Response
     */
    public function show(string $slug): Response
    {
        $association = Association::where('slug', $slug)
            ->with('media')
            ->firstOrFail();

        return Inertia::render('Associations/Association', [
            'association' => [
                'name' => $association->name,
                'slug' => $association->slug,
                'category_name' => optional($association->category)->name,
                'url' => $association->url,
                'department' => $association->department,
                'address' => $association->address,
                'description' => $association->description,
                'project' => $association->project,
                'image' => $association->getFirstMediaUrl('image'),
            ],
        ]);
    }

    /**
     * Vote for an association.
     *
     * @param string $slug
     * @return JsonResponse
     */
    public function vote(string $slug): JsonResponse
    {
        $association = Association::where('slug', $slug)->firstOrFail();
        $association->increment('points');
        auth()->user()->incrementPoints();

        Association::updateAssociationVotes();

        return response()->json(['success' => true]);
    }
}
