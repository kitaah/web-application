<?php

namespace App\Filament\Resources\StatisticResource\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Flowframe\{Trend\Trend, Trend\TrendValue};

class UsersChartOverview extends ChartWidget
{
    /**
     * The heading for the chart widget.
     *
     * @var string|null
     */
    protected static ?string $heading = 'Chart utilisateurs';

    /**
     * The color theme for the chart widget.
     *
     * @var string
     */
    protected static string $color = 'danger';

    /**
     * Get the description for the chart widget.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return 'Nombre d\'utilisateurs inscrits durant l\'année en cours';
    }

    /**
     * Get the data for rendering the chart.
     *
     * @return array
     */
    protected function getData(): array
    {
        /** @var $data */
        $data = Trend::model(User::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Utilisateurs inscrits',
                    'data' => $data->map(/**
                     * @param TrendValue $value
                     * @return mixed
                     */ callback: fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#990000',
                    'borderColor' => '#8f0e0e',
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
