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
    Support\Str,
    Validation\Rules};
use Spatie\{MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist,
    MediaLibrary\MediaCollections\Exceptions\FileIsTooBig};
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
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z0-9_-]*$/'],
            'email' => 'required|string|lowercase|email|max:50|unique:' . User::class,
            'password' => ['required', 'string', 'max:255', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d.*)(?=.*\W.*)[a-zA-Z0-9\S]{8,}$/'],
            'department' => 'required|string|max:50',
            'terms_accepted' => 'required|accepted',
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:1024'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $trimmedName = trim($request->input('name'));
        $trimmedDepartment = ucfirst(trim($request->input('department')));

        $user = User::create([
            'name' => htmlspecialchars($trimmedName),
            'email' => htmlspecialchars(strtolower(trim($request->input('email'))), ENT_COMPAT),
            'password' => Hash::make($request->input('password')),
            'department' => htmlspecialchars($trimmedDepartment, ENT_COMPAT),
            'terms_accepted' => $request->input('terms_accepted'),
        ]);

        if ($request->hasFile('image')) {
            $randomFileName = strtoupper(Str::random(26)) . '.' . $request->file('image')->getClientOriginalExtension();
            $user->addMedia($request->file('image'))->usingFileName($randomFileName)->toMediaCollection('image');
        }

        $user->assignRole('Citoyen');

        event(new Registered($user));

        Auth::login($user);

        Statistic::updateUser();

        return redirect(RouteServiceProvider::HOME);
    }
}
