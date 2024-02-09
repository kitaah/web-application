<?php

namespace App\Http\Controllers;

use App\Models\{Category, Resource, Statistic, User};
use Illuminate\{Http\RedirectResponse,
    Http\Request,
    Support\Facades\Auth,
    Support\Facades\Redirect,
    Http\UploadedFile,
    Support\Facades\Validator,
    Validation\Rule};
use Inertia\{Inertia, Response};
use Spatie\{MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist,
    MediaLibrary\MediaCollections\Exceptions\FileIsTooBig};


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
     * Resources listing of the authenticated user.
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

    /**
     * Create a new resource for the authenticated user.
     *
     * @return Response
     */
    public function create(): Response
    {
        $categories = Category::all();

        return Inertia::render('Resources/Create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a new resource for the authenticated user
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */

    public function store(Request $request): RedirectResponse
    {
        $data = $request->only(['name', 'url', 'slug', 'description', 'category_id', 'image']);

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:50', Rule::unique('resources', 'name')],
            'url' => ['nullable', 'url', 'string', 'max:255'],
            'slug' => ['required', 'string', 'alpha_dash', 'max:50', Rule::unique('resources', 'slug')],
            'description' => ['required', 'string', 'max:5000'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:1024'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $resource = new Resource([
            'name' => $data['name'],
            'url' => $data['url'],
            'user_id' => auth()->id(),
            'slug' => $data['slug'],
            'description' => $data['description'],
            'image' => $data['image'],
        ]);

        $resource->category()->associate($data['category_id']);
        $resource->save($request->only(['name', 'url', 'user_id', 'slug', 'image', 'category_id', 'description']));

        $resource->addMedia($request->file('image'))->toMediaCollection('image');

        Statistic::updateResource();

        return Redirect::route('resource.userIndex');
    }

    /**
     *  Edit the current resource for the authenticated user
     *
     * @param $slug
     * @return Response
     */
    public function edit($slug): Response
    {
        $resource = Resource::where('slug', $slug)->firstOrFail();
        $categories = Category::all();

        return Inertia::render('Resources/Edit', [
            'resource' => $resource,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the current resource for the authenticated user
     *
     * @param Request $request
     * @param $slug
     * @return RedirectResponse
     */
    public function update(Request $request, $slug): RedirectResponse
    {
        $resource = Resource::where('slug', $slug)->firstOrFail();

        Validator::make($request->only(['name', 'url', 'slug','description', 'category_id']), [
            'name' => ['required', 'sometimes', 'string', 'max:50', Rule::unique('resources', 'name')->ignore($resource->id),
            ],
            'url' => ['nullable', 'url', 'string', 'max:255'],
            'slug' => ['required', 'sometimes', 'string', 'alpha_dash', 'max:50', Rule::unique('resources', 'slug')->ignore($resource->id),
            ],
            'description' => ['required', 'sometimes', 'string', 'max:5000'],
            'category_id' => ['required', 'sometimes', 'integer', 'exists:categories,id'],
        ])->validate();

        $resource->update($request->only(['name', 'url', 'slug', 'description', 'category_id']));

        return Redirect::route('resource.userIndex');
    }
}

