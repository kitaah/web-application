<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Inertia\{Inertia, Response};

class ResourceController extends Controller
{
    /**
     * Resource controller.
     *
     * @return Response
     */
    public function index(): Response
    {
        /** @var $resources */
        $resources = Resource::all();

        return Inertia::render('Resources/Resources', [
            'resources' => $resources,
        ]);
    }
}
