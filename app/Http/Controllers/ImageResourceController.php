<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Resource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class ImageResourceController extends Controller
{
    public function edit($slug): Response
    {
        $resource = Resource::where('slug', $slug)->firstOrFail();

        return Inertia::render('Resources/ImageEdit', [
            'resource' => $resource,
        ]);
    }

    public function update(Request $request, $slug): RedirectResponse
    {
        $resource = Resource::where('slug', $slug)->firstOrFail();

        Validator::make($request->all(), [
            'image' => ['image', 'mimes:jpeg,png,jpg'],
        ])->validate();

        $resource->update($request->only(['image']));

        if ($request->hasFile('image')) {
        $resource->clearMediaCollection('image');

        $resource->addMedia($request->file('image'))->toMediaCollection('image');
        }

        return Redirect::route('resource.userIndex');
    }
}
