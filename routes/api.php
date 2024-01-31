<?php

use App\Http\Resources\AllResourcesResource;
use App\Models\Resource;
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
    $resources = Resource::latest()->where('is_validated', true)->get();
    return AllResourcesResource::collection($resources);
});

