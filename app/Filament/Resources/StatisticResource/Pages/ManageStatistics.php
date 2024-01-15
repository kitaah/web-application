<?php

namespace App\Filament\Resources\StatisticResource\Pages;

use App\Filament\{Resources\StatisticResource,
    Resources\StatisticResource\Widgets\ResourcesChartOverview,
    Resources\StatisticResource\Widgets\StatisticsOverview,
    Resources\StatisticResource\Widgets\UsersChartOverview};
use Filament\Resources\Pages\ManageRecords;

class ManageStatistics extends ManageRecords
{
    /**
     * The associated resource class for managing statistics.
     *
     * @var string
     */
    protected static string $resource = StatisticResource::class;

    /**
     * Get the footer widgets for the page.
     *
     * @return array
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
