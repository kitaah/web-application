<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Statistic;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\{Auth\Events\Registered,
    Http\RedirectResponse,
    Http\Request,
    Support\Facades\Auth,
    Support\Facades\Hash,
    Support\Facades\Validator,
    Validation\Rules};

use Inertia\{Inertia, Response};
use App\Traits\DepartmentsTrait;

class RegisteredUserController extends Controller
{
    use DepartmentsTrait;
    /**
     * Display the registration view.
     * @return Response
     */
    public function create(): Response
    {
        try {
            $departments = $this->fetchDepartments();
        } catch (GuzzleException|\JsonException $e) {
        }

        return Inertia::render('Auth/Register', [
            'departments' => $departments,
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        /** @var $request */
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50|unique:'.User::class,
            'email' => 'required|string|lowercase|email|max:50|unique:'.User::class,
            'password' => ['required', 'string', 'max:255', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d.*)(?=.*\W.*)[a-zA-Z0-9\S]{8,}$/'],
            'department' => 'required|string|max:50',
            'terms_accepted' => 'required|accepted',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        /** @var $user */
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'department' => $request->department,
            'terms_accepted' => $request->terms_accepted,
        ]);

        /** @var $user */
        $user->assignRole('Citoyen');

        /** @var $user */
        event(new Registered($user));

        /** @var $user */
        Auth::login($user);

        Statistic::updateUser();

        return redirect(RouteServiceProvider::HOME);
    }
}
