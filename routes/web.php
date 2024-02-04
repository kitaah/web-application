<?php

use App\Http\{Controllers\AssociationController,
    Controllers\CompetitionController,
    Controllers\GameController,
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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/game', [GameController::class, 'index'])->name('game.index');
});

Route::inertia('/', 'Home')->name('home');
Route::inertia('/accessibilite', 'Legal/Accessibility')->name('accessibility');
Route::inertia('/mentions-legales', 'Legal/Disclaimer')->name('disclaimer');
Route::inertia('/politique-de-confidentialite', 'Legal/PrivacyPolicy')->name('privacypolicy');

Route::get('/ressources', [ResourceController::class, 'index'])->name('resources.index');
Route::get('/ressource/{slug}', [ResourceController::class, 'show'])->name('resources.show');

Route::get('/mes-ressources', [ResourceController::class, 'userResources'])->name('user.resources');

Route::get('/competition', [CompetitionController::class, 'index'])->name('competition.index');

Route::get('/association/{slug}', [AssociationController::class, 'show'])->name('associations.show');
Route::post('/association/{slug}/vote', [AssociationController::class, 'vote'])->name('associations.vote');

require __DIR__.'/auth.php';
