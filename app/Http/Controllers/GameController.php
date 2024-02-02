<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class GameController extends Controller
{
    /**
     * Resource controller.
     *
     * @return Response
     */
    public function index(): Response
    {
        $game = Game::inRandomOrder()->firstorfail();

        return Inertia::render('Games/Game', [
            'game' => $game,
        ]);
    }
}
