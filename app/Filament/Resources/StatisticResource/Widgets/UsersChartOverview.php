<?php

namespace App\Filament\Resources\StatisticResource\Widgets;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Flowframe\{Trend\Trend, Trend\TrendValue};
use Illuminate\Support\Carbon;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
class UsersChartOverview extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string|null
     */
    protected static ?string $chartId = 'userChartOverview';

    /**
     * The heading for the chart widget.
     * @var string|null
     */
    protected static ?string $heading = 'Chart utilisateurs';

    /**
     * The loading indicator for the chart widget.
     *
     * @return string|null
     */
    protected static ?string $loadingIndicator = 'Chargement...';

    protected static bool $darkMode = false;

    /**
     * Chart options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        /** @var $data */
        $data = Trend::model(User::class)
            ->between(
                start: Carbon::parse(time: $this->filterFormData['date_start']),
                end: Carbon::parse(time: $this->filterFormData['date_end']),
            )
            ->perMonth()
            ->count();

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Nombre',
                    'data' => $data->map(/**
                     * @param TrendValue $value
                     * @return mixed
                     */ fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'xaxis' => [
                'categories' => $data->map(/**
                 * @param TrendValue $value
                 * @return string
                 */ fn (TrendValue $value) => $value->date),
                'labels' => [
                    'style' => [
                        'colors' => '#9ca3af',
                        'fontWeight' => 600,
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'colors' => '#9ca3af',
                        'fontWeight' => 600,
                    ],
                ],
            ],
            'colors' => ['#16658a'],
            'stroke' => [
                'curve' => 'smooth',
            ],
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            DatePicker::make('date_start')
                ->label('Date de début')
                ->default(now()->startOfYear()),
            DatePicker::make('date_end')
                ->label('Date de fin')
                ->default(now()->endOfYear()),
        ];
    }
}
