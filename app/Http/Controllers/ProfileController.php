<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Inertia\{Inertia, Response};
use Illuminate\{Contracts\Auth\MustVerifyEmail,
    Http\RedirectResponse,
    Http\Request,
    Support\Facades\Auth,
    Support\Facades\Redirect,
    Support\Facades\Validator};

class ProfileController extends Controller
{

    /**
     * Display the user's profile form.
     *
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request): Response
    {
        $user = $request->user();
        $mood = htmlspecialchars(trim($user->mood));
        $points = htmlspecialchars(trim($user->points));
        $name = htmlspecialchars(trim($user->name));

        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $user instanceof MustVerifyEmail,
            'status' => session('status'),
            'name' => $name,
            'mood' => $mood,
            'points' => $points,
            'image' => $user->getFirstMediaUrl('image'),
        ]);
    }

    /**
     * Update the user's profile information.
     *
     * @param ProfileUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validator = Validator::make($request->only('mood'), [
            'mood' => 'string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = $request->user();
        $user->mood = htmlspecialchars(trim($request->mood));

        $user->incrementPoints();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        /** @var $request */
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
