<?php

namespace App\Filament\Pages;

use Illuminate\Contracts\View\View;
use Filament\{Pages\Dashboard as NewDashboard};

class Dashboard extends NewDashboard
{
    /**
     *  Dashboard and navigation title.
     *
     * @var string|null
     */
    protected static ?string $title = 'Accueil';

    /**
     *  Adding a customized footer.
     *
     * @return View|null
     */
    public function getFooter(): ?View
    {
        return view('filament.custom-content-dashboard');
    }
}
