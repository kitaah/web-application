<?php

namespace App\Filament\Resources\StatisticResource\Pages;

use App\Filament\Resources\StatisticResource;
use App\Filament\Resources\StatisticResource\Widgets\ResourcesChartOverview;
use App\Filament\Resources\StatisticResource\Widgets\StatisticsOverview;
use App\Filament\Resources\StatisticResource\Widgets\UsersChartOverview;
use Filament\Resources\Pages\ManageRecords;

class ManageStatistics extends ManageRecords
{
    protected static string $resource = StatisticResource::class;

    /**
     * @return string[]
     */
    protected function getFooterWidgets(): array
    {
        return [
            StatisticsOverview::class,
            ResourcesChartOverview::class,
            UsersChartOverview::class,
        ];
    }
}
