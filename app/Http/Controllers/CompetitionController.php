<?php

namespace App\Http\Controllers;

use App\Models\CreateCompetition;
use Illuminate\Http\Request;
use Inertia\{Inertia, Response};

class CompetitionController extends Controller
{
    /**
     * Competition controller.
     *
     * @return Response
     */
    public function index(): Response
    {
        /** @var $competition */
        $competition = CreateCompetition::all();

        return Inertia::render('Competition/Competition', [
            'competition' => $competition,
        ]);
    }
}
