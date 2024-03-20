<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\{Http\JsonResponse, Http\Request, Support\Facades\Auth};
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

    /**
     * Points incrementation when the user give the right answer.
     *
     * @return JsonResponse
     */
    public function incrementPoints(): JsonResponse
    {
        $user = Auth::user();

        if ($user) {
            $user->incrementPoints();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Utilisateur non authentifié'], 401);
    }
}
