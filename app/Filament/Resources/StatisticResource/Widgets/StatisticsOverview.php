<?php

namespace App\Filament\Resources\StatisticResource\Widgets;

use App\Models\Association;
use App\Models\Competition;
use App\Models\Game;
use App\Models\Resource;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatisticsOverview extends BaseWidget
{
    /**
     * @return array|Stat[]
     */
    protected function getStats(): array
    {
        return [
            Stat::make('Total associations', Association::count()),
            Stat::make('Total jeux', Game::count()),
            Stat::make('Total compétitions', Competition::count()),
            Stat::make('Total ressources', Resource::count()),
            Stat::make('Total utilisateurs', User::count()),
        ];
    }
}
