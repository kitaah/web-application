<?php

namespace App\Filament\Resources\StatisticResource\Widgets;

use App\{Models\Association, Models\Competition, Models\CreateCompetition, Models\Game, Models\Resource, Models\User};
use Filament\{Widgets\StatsOverviewWidget as BaseWidget, Widgets\StatsOverviewWidget\Stat};

class StatisticsOverview extends BaseWidget
{
    /**
     * Get an array of statistics to be displayed.
     *
     * @return array|Stat[]
     */
    protected function getStats(): array
    {
        return [
            Stat::make('Total associations', Association::count()),
            Stat::make('Total jeux', Game::count()),
            Stat::make('Total compétitions', CreateCompetition::count()),
            Stat::make('Total ressources', Resource::count()),
            Stat::make('Total utilisateurs', User::count()),
        ];
    }
}
