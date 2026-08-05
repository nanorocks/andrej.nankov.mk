<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class MostVisitedSocMediaChart extends ChartWidget
{
    protected ?string $heading = 'Most Clicked Social Media Links';

    protected function getData(): array
    {
        $records = \App\Models\PanAnalytics::where('name', 'like', 'Soc-%')->get();

        $labels = $records->pluck('name')->map(function ($name) {
            return str_replace('Soc-', '', $name);
        })->toArray();
        $data = $records->pluck('clicks')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Clicks',
                    'data' => $data,
                    'backgroundColor' => array_fill(0, count($data), '#F53F3F'), // Filament red
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
