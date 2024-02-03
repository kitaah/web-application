<?php

namespace App\Http\Controllers;

use App\Models\Association;
use App\Models\Resource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

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
            ->first();

        if (!$association) {
            abort(404);
        }

        return Inertia::render('Associations/Association', [
            'association' => array_filter([
                'name' => $association->name,
                'slug' => $association->slug,
                'category_name' => optional($association->category)->name,
                'url' => $association->url,
                'city' => $association->city,
                'description' => $association->description,
                'project' => $association->project,
                'image' => $association->getFirstMediaUrl('image'),
            ]),
        ]);
    }
}
