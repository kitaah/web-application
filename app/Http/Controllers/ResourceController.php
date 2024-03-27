<?php

namespace App\Http\Controllers;

use App\Models\{Category, Comment, Resource, Statistic, User};
use Illuminate\{Http\RedirectResponse,
    Http\Request,
    Support\Facades\Auth,
    Support\Facades\Redirect,
    Http\UploadedFile,
    Support\Facades\Validator,
    Support\Str,
    Validation\Rule,
    Validation\ValidationException};
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
                'slug' => $resource->slug,
                'description' => $resource->description,
                'category_name' => optional($resource->category)->name,
                'user_name' => optional($resource->user)->name,
                'created_at' => $resource->created_at->format('d/m/Y'),
                'updated_at' => $resource->updated_at->format('d/m/Y'),
                'image' => $resource->getFirstMediaUrl('image'),
            ]);
        });

        $categories = Category::all();

        return Inertia::render('Resources/Resources', [
            'resources' => $resourceData,
            'categories' => $categories,
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

        $comments = Comment::where('resource_id', $resource->id)
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $formattedComments = $comments->map(function ($comment) {
            $user = User::find($comment->user_id);
            return [
                'id' => $comment->id,
                'content' => $comment->content,
                'user_name' => $user ? $user->name : 'Utilisateur inconnu',
                'created_at' => $comment->created_at->format('d/m/Y'),
                'user_image' => $user ? $user->getFirstMediaUrl('image') : null
            ];
        });

        return Inertia::render('Resources/Resource', [
            'resource' => array_filter([
                'id' => $resource->id,
                'name' => $resource->name,
                'description' => $resource->description,
                'category_name' => optional($resource->category)->name,
                'user_name' => optional($resource->user)->name,
                'created_at' => $resource->created_at->format('d/m/Y'),
                'updated_at' => $resource->updated_at->format('d/m/Y'),
                'user_image' => optional($resource->user)->getFirstMediaUrl('image'),
                'image' => $resource->getFirstMediaUrl('image'),
            ]),
            'comments' => $formattedComments,
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

        $categories = Category::all();

        return Inertia::render('Resources/UserResources', [
            'userResources' => $resourceDatas,
            'categories' => $categories,
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
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50', Rule::unique('resources', 'name')],
            'slug' => ['required', 'string', 'alpha_dash', 'max:50', Rule::unique('resources', 'slug')],
            'description' => ['required', 'string', 'max:5000'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:1024'],
        ], [
            'image.required' => 'Le champ image doit être complété.',
        ])->validate();

        $resource = new Resource();
        $resource->name = htmlspecialchars(trim($request->input('name')), ENT_COMPAT);
        $resource->user_id = auth()->id();
        $resource->slug = htmlspecialchars(trim($request->input('slug')), ENT_COMPAT);
        $resource->description = htmlspecialchars(trim($request->input('description')), ENT_COMPAT);
        $resource->category_id = $request->input('category_id');
        $resource->save();

        auth()->user()->incrementPoints();

        if ($request->hasFile('image')) {
            $randomFileName = strtoupper(Str::random(26)) . '.' . $request->file('image')->getClientOriginalExtension();
            $resource->addMedia($request->file('image'))->usingFileName(htmlspecialchars($randomFileName, ENT_COMPAT))->toMediaCollection('image');
        }

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
     * @throws ValidationException
     */
    public function update(Request $request, $slug): RedirectResponse
    {
        $resource = Resource::where('slug', $slug)->firstOrFail();

        Validator::make($request->only(['name', 'slug', 'description', 'category_id']), [
            'name' => ['required', 'sometimes', 'string', 'max:50', Rule::unique('resources', 'name')->ignore($resource->id)],
            'slug' => ['required', 'sometimes', 'string', 'alpha_dash', 'max:50', Rule::unique('resources', 'slug')->ignore($resource->id)],
            'description' => ['required', 'sometimes', 'string', 'max:5000'],
            'category_id' => ['required', 'sometimes', 'integer', 'exists:categories,id'],
        ], [
            'description.required' => 'Le champ description est obligatoire.',
        ])->validate();

        $trimmedDescription = ucfirst(trim($request->input('description')));

        $resource->update([
            'name' => htmlspecialchars(trim($request->input('name')), ENT_COMPAT),
            'slug' => htmlspecialchars(trim($request->input('slug'))),
            'description' => htmlspecialchars($trimmedDescription, ENT_COMPAT),
            'category_id' => $request->input('category_id'),
        ]);

        return Redirect::route('resource.userIndex');
    }
}

