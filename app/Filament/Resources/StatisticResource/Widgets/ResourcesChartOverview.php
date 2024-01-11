<?php

namespace App\Filament\Resources\StatisticResource\Widgets;

use App\Models\Resource;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ResourcesChartOverview extends ChartWidget
{
    protected static ?string $heading = 'Chart ressources';

    protected static string $color = 'success';

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return 'Nombre de ressources créées durant l\'année en cours';
    }

    /**
     * @return array|mixed[]
     */
    protected function getData(): array
    {
        $data = Trend::model(Resource::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Ressources créées',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#16658a',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => ['Janv', 'Fév', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc'],
        ];
    }

    /**
     * @return string
     */
    protected function getType(): string
    {
        return 'line';
    }
}
