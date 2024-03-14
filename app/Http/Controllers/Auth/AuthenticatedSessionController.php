<?php

namespace App\Http\Controllers\Auth;

use App\{Http\Controllers\Controller, Http\Requests\Auth\LoginRequest, Providers\RouteServiceProvider};
use Illuminate\{Http\RedirectResponse,
    Http\Request,
    Support\Facades\Auth,
    Support\Facades\Route,
    Support\Facades\Validator};
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
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:50',
            'password' => ['required', 'string', 'max:255', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d.*)(?=.*\W.*)[a-zA-Z0-9\S]{8,}$/'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if (auth()->user()->hasRole('Banni')) {
                Auth::logout();
                return back()->withErrors(['email' => 'Votre compte a été banni pour violation de nos conditions générales d\'utilisation.']);
            }

            $request->session()->regenerate();

            return redirect()->intended(RouteServiceProvider::HOME);
        }

        return back()->withErrors([
            'email' => 'Informations de connexion saisies incorrectes.',
        ]);
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
