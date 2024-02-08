<?php

namespace App\Http\Controllers\Auth;

use App\{Http\Controllers\Controller, Http\Requests\Auth\LoginRequest, Providers\RouteServiceProvider};
use Illuminate\{Http\RedirectResponse, Http\Request, Support\Facades\Auth, Support\Facades\Route};
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        /** @var $request */
        $request->authenticate();

        /** @var $request */
        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        /** @var $request */

        $request->session()->invalidate();

        /** @var $request */
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
