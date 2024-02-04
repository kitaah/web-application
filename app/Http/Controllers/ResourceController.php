<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\{Inertia, Response};

class ResourceController extends Controller
{
    /**
     * Resources listing.
     *
     * @return Response
     */
    public function index(): Response
    {
        $resources = Resource::latest()
            ->with('media')
            ->where('is_validated', true)
            ->where('status', 'Publiée')
            ->get();

        if (!$resources) {
            abort(404);
        }

        $resourceData = $resources->map(function ($resource) {
            return array_filter([
                'id' => $resource->id,
                'name' => $resource->name,
                'url' => $resource->url,
                'slug' => $resource->slug,
                'description' => $resource->description,
                'category_name' => optional($resource->category)->name,
                'user_name' => optional($resource->user)->name,
                'created_at' => $resource->created_at->format('d/m/Y'),
                'updated_at' => $resource->updated_at->format('d/m/Y'),
                'image' => $resource->getFirstMediaUrl('image'),
            ]);
        });

        return Inertia::render('Resources/Resources', [
            'resources' => $resourceData,
        ]);
    }

    /**
     * Specific resource.
     *
     * @param string $slug
     * @return Response
     */
    public function show(string $slug): Response
    {
        $resource = Resource::where('slug', $slug)
            ->where('is_validated', true)
            ->where('status', 'Publiée')
            ->with('media')
            ->firstOrFail();

        return Inertia::render('Resources/Resource', [
            'resource' => array_filter([
                'id' => $resource->id,
                'name' => $resource->name,
                'url' => $resource->url,
                'description' => $resource->description,
                'category_name' => $resource->category->name,
                'user_name' => optional($resource->user)->name,
                'created_at' => $resource->created_at->format('d/m/Y'),
                'updated_at' => $resource->updated_at->format('d/m/Y'),
                'image' => $resource->getFirstMediaUrl('image'),
            ]),
        ]);
    }


    /**
     * Resources listing of the authenticated user
     *
     * @return Response
     */
    public function userResources(): Response
    {
        $userResources = Resource::latest()
            ->with('media')
            ->where('user_id', auth()->id())
            ->get();

        $resourceDatas = $userResources->map(function ($resource) {
            return array_filter([
                'id' => $resource->id,
                'name' => $resource->name,
                'url' => $resource->url,
                'description' => $resource->description,
                'user_creator' => optional($resource->user)->id,
                'category_name' => optional($resource->category)->name,
                'created_at' => $resource->created_at->format('d/m/Y'),
                'updated_at' => $resource->updated_at->format('d/m/Y'),
                'image' => $resource->getFirstMediaUrl('image'),
            ]);
        });

        return Inertia::render('Resources/UserResources', [
            'userResources' => $resourceDatas,
        ]);
    }
}

