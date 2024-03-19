<?php

use App\Http\{Controllers\AssociationController,
    Controllers\CommentController,
    Controllers\CompetitionController,
    Controllers\GameController,
    Controllers\HomeController,
    Controllers\ImageResourceController,
    Controllers\ProfileController,
    Controllers\ResourceController,
    Controllers\UserController};
use Illuminate\{Foundation\Application, Support\Facades\Route};
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', static function () {
    //return Inertia::render('Welcome', [
        //'canLogin' => Route::has('login'),
        //'canRegister' => Route::has('register'),
        //'laravelVersion' => Application::VERSION,
        //'phpVersion' => PHP_VERSION,
    //]);
//});

Route::get('/dashboard', static function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/jeu', [GameController::class, 'index'])->name('game.index');
});


Route::middleware(['auth', 'verified', 'role:Citoyen|Super-Administrateur'])->group(function () {
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profil', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/mes-ressources', [ResourceController::class, 'userIndex'])->name('resource.userIndex');
    Route::get('/mes-ressources/ajout', [ResourceController::class, 'create'])->name('resource.create');
    Route::post('/mes-ressources/ajout', [ResourceController::class, 'store'])->name('resource.store');
    Route::get('/mes-ressources/modifier/{slug}', [ResourceController::class, 'edit'])->name('resource.edit');
    Route::put( '/mes-ressources/modifier/{slug}', [ResourceController::class, 'update'])->name('resource.update');
    Route::get('/mes-ressources/modifier-image/{slug}', [ImageResourceController::class, 'edit'])->name('image.edit');
    Route::put( '/mes-ressources/modifier-image/{slug}', [ImageResourceController::class, 'update'])->name('image.update');
});

Route::middleware(['auth', 'verified', 'role:Citoyen|Super-Administrateur', 'permission:vote for an association'])->group(function () {
    Route::post('/association/{slug}/vote', [AssociationController::class, 'vote'])->name('associations.vote');
});

Route::middleware(['auth', 'verified', 'role:Citoyen|Super-Administrateur', 'permission:post a comment'])->group(function () {
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
//Route::inertia('/', 'Home')->name('home');
Route::inertia('/Home2', 'Home2')->name('home2');
Route::inertia('/accessibilite', 'Legal/Accessibility')->name('accessibility');
Route::inertia('/mentions-legales', 'Legal/Disclaimer')->name('disclaimer');
Route::inertia('/politique-de-confidentialite', 'Legal/PrivacyPolicy')->name('privacypolicy');
Route::inertia('/conditions-generales-utilisation', 'Legal/TermsAndConditions')->name('termsandconditions');
Route::inertia('/politique-de-cookies', 'Legal/CookiePolicy')->name('cookiepolicy');

Route::get('/ressources', [ResourceController::class, 'index'])->name('resources.index');
Route::get('/ressource/{slug}', [ResourceController::class, 'show'])->name('resources.show');

Route::get('/competition', [CompetitionController::class, 'index'])->name('competition.index');

Route::get('/association/{slug}', [AssociationController::class, 'show'])->name('associations.show');

require __DIR__.'/auth.php';
