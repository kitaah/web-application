<?php

namespace App\Filament\Resources\StatisticResource\Widgets;

use App\Models\Resource;
use Filament\Widgets\ChartWidget;
use Flowframe\{Trend\Trend, Trend\TrendValue};

class ResourcesChartOverview extends ChartWidget
{
    /**
     * The heading for the chart widget.
     *
     * @var string|null
     */
    protected static ?string $heading = 'Chart ressources';

    /**
     * The color theme for the chart widget.
     *
     * @var string
     */
    protected static string $color = 'success';

    /**
     * Get the description for the chart widget.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return 'Nombre de ressources créées durant l\'année en cours';
    }

    /**
     * Get the data for rendering the chart.
     *
     * @return array
     */
    protected function getData(): array
    {
        /** @var $data */
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
                    'data' => $data->map(/**
                     * @param TrendValue $value
                     * @return mixed
                     */ callback: fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#16658a',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => ['Janv', 'Fév', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc'],
        ];
    }

    /**
     * Get the type of the chart (line chart in this case).
     *
     * @return string
     */
    protected function getType(): string
    {
        return 'line';
    }
}
