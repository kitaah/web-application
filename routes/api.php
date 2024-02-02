<?php

use App\Http\{Resources\AllResourcesResource,
    Resources\CompetitionResource,
    Resources\GameResource};
use App\Models\{CreateCompetition, Game, Resource};
use Illuminate\{Http\Request, Support\Facades\Route};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/resources', static function() {
    $resources = Resource::latest()
        ->where('is_validated', true)
        ->where('status', 'Publiée')
        ->get();
    return AllResourcesResource::collection($resources);
});

Route::get('/competition', static function() {
    $competition = CreateCompetition::oldest()
        ->where('is_published', true)
        ->where('status', 'En cours')
        ->get();
    return CompetitionResource::collection($competition);
});

Route::get('/game', static function () {
    $game = Game::inRandomOrder()->firstOrFail();
    return new GameResource($game);
});


