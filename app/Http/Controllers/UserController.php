<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function show(string $name): Response
    {
        $user = User::where('name', $name)
            ->with('media')
            ->firstOrFail();

        return Inertia::render('Users/Profile', [
            'user' => array_filter([
                'id' => $user->id,
                'name' => $user->name,
                'roles' => $user->getRoleNames(),
                'image' => $user->getFirstMediaUrl('image'),
            ]),
        ]);
    }
}
