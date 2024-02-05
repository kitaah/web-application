<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\{Inertia, Response};
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Illuminate\Support\Facades\Validator;

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
    public function userIndex(): Response
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
                'slug' => $resource->slug,
                'is_validated' => $resource->is_validated,
                'status' => $resource->status,
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

    public function create(): Response
    {
        $categories = Category::all();

        return Inertia::render('Resources/Create', [
            'categories' => $categories,
        ]);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'url' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $resource = new Resource([
            'name' => $validatedData['name'],
            'url' => $validatedData['url'],
            'user_id' => auth()->id(),
            'slug' => $validatedData['slug'],
            'description' => $validatedData['description'],
        ]);

        $resource->category()->associate($validatedData['category_id']);
        $resource->save();

        $resource->addMedia($request->file('image'))->toMediaCollection('image');

        return Redirect::route('resource.userIndex');
    }

    public function edit($slug): Response
    {
        $resource = Resource::where('slug', $slug)->firstOrFail();
        $categories = Category::all();

        return Inertia::render('Resources/Edit', [
            'resource' => $resource,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, $slug): RedirectResponse
    {
        $resource = Resource::where('slug', $slug)->firstOrFail();

        Validator::make($request->all(), [
            'name' => ['required', 'sometimes'],
            'url' => ['required', 'sometimes'],
            'description' => ['required', 'sometimes'],
            'category_id' => ['required', 'sometimes', 'exists:categories,id'],
        ])->validate();

        $resource->update($request->only(['name', 'url', 'description', 'category_id', 'image']));

        return Redirect::route('resource.userIndex');
    }
}

