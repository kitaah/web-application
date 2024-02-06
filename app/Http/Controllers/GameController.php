<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Inertia\{Inertia, Response};

/**
 * Class GameController
 *
 * @package App\Http\Controllers
 */
class GameController extends Controller
{
    /**
     * Get one random game.
     *
     * @return Response
     */
    public function index(): Response
    {
        $game = $this->getRandomGame();

        return Inertia::render('Games/Game', [
            'game' => $game
        ]);
    }

    /**
     * Get a random game.
     *
     * @return Game
     */
    private function getRandomGame(): Game
    {
        /**
         * The randomly selected game.
         *
         * @var Game
         */
        return Game::inRandomOrder()->firstOrFail();
    }
}
