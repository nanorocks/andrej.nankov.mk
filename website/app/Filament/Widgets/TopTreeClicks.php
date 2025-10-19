<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class TopTreeClicks extends ChartWidget
{
    // use HasWidgetShield;

    protected ?string $heading = 'Top Tree Clicks';

    protected function getData(): array
    {
        $records = \App\Models\PanAnalytics::orderBy('clicks', 'desc')
            ->limit(3)
            ->get();

        $labels = $records->pluck('name')->toArray();

        $data = $records->pluck('clicks')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Clicks',
                    'data' => $data,
                    'backgroundColor' => [
                        '#F53F3F', // Red for #1
                        '#FF8C00', // Orange for #2
                        '#FFD700', // Gold for #3
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
