<?php

namespace App\Filament\Resources\StatisticResource\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class UsersChartOverview extends ChartWidget
{
    protected static string $chartId = 'Chart utilisateurs';

    protected static ?string $heading = 'Chart utilisateurs';

    protected static string $color = 'danger';

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return 'Nombre d\'utilisateurs inscrits durant l\'année en cours';
    }

    /**
     * @return array
     */
    protected function getData(): array
    {
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
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
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
