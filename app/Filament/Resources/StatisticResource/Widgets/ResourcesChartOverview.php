<?php

namespace App\Filament\Resources\StatisticResource\Widgets;

use App\Models\Resource;
use Filament\Forms\Components\DatePicker;
use Flowframe\{Trend\Trend, Trend\TrendValue};
use Illuminate\Support\Carbon;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ResourcesChartOverview extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string|null
     */
    protected static ?string $chartId = 'resourcesChartOverview';

    /**
     * The heading for the chart widget.
     * @var string|null
     */
    protected static ?string $heading = 'Graphique ressources';

    /**
     * The footer description for the chart widget.
     *
     * @var string|null
     */
    protected static ?string $footer = 'Informations sur le nombre de ressources.';

    /**
     * Polling interval when the data is refresh.
     *
     * @var string|null
     */
    protected static ?string $pollingInterval = '60s';

    /**
     * Defer loading.
     *
     * @var bool
     */
    protected static bool $deferLoading = true;

    /**
     * Chart options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        if (!$this->readyToLoad) {
            return [];
        }

        sleep(2);

        /** @var $data */
        $data = Trend::model(Resource::class)
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
                    'name' => 'Quantité',
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
            'colors' => ['#f59e0b'],
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
