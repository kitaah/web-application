<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\{Http\RedirectResponse, Http\Request, Support\Facades\Redirect, Support\Facades\Validator};
use Inertia\{Inertia, Response};
use Spatie\{MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist,
    MediaLibrary\MediaCollections\Exceptions\FileIsTooBig};
use Illuminate\Validation\ValidationException;

/**
 * Class ImageResourceController
 *
 * @package App\Http\Controllers
 */
class ImageResourceController extends Controller
{
    /**
     * Edit current image resource for the authenticated user.
     *
     * @param string $slug
     * @return Response
     */
    public function edit(string $slug): Response
    {
        $resource = $this->findResourceBySlug($slug);

        return Inertia::render('Resources/ImageEdit', [
            'resource' => $resource,
        ]);
    }

    /**
     * Update current resource for the authenticated user.
     *
     * @param Request $request
     * @param string $slug
     * @return RedirectResponse
     */
    public function update(Request $request, string $slug): RedirectResponse
    {
        $resource = $this->findResourceBySlug($slug);

        $this->validateImage($request);

        $this->updateResource($resource, $request);

        return Redirect::route('resource.userIndex');
    }

    /**
     * Find a resource by slug or throw an exception if not found.
     *
     * @param string $slug
     * @return Resource
     */
    private function findResourceBySlug(string $slug): Resource
    {
        return Resource::where('slug', $slug)->firstOrFail();
    }

    /**
     * Validate the image in the request.
     *
     * @param Request $request
     * @return void
     */
    private function validateImage(Request $request): void
    {
        Validator::make($request->all(), [
            'image' => ['image', 'mimes:jpeg,png,jpg', 'max:1024'],
        ])->validate();
    }

    /**
     * Update the resource with the given request data.
     *
     * @param Resource $resource
     * @param Request $request
     * @return void
     */
    private function updateResource(Resource $resource, Request $request): void
    {
        $resource->update($request->only(['image']));

        if ($request->hasFile('image')) {
            $this->handleImageUpload($resource, $request);
        }
    }

    /**
     * Handle the image upload for the resource.
     *
     * @param Resource $resource
     * @param Request $request
     * @return void
     */
    private function handleImageUpload(Resource $resource, Request $request): void
    {
        $resource->clearMediaCollection('image');

        try {
            $resource->addMedia($request->file('image'))->toMediaCollection('image');
        } catch (FileDoesNotExist | FileIsTooBig $exception) {
            throw ValidationException::withMessages(['image' => $exception->getMessage()]);
        }
    }
}
