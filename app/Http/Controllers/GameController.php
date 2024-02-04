<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class GameController extends Controller
{
    /**
     * Get one random game.
     *
     * @return Response
     */
    public function index(): Response
    {
        $game = Game::inRandomOrder()->firstOrFail();

        return Inertia::render('Games/Game', [
            'game' => $game
        ]);
    }
}
