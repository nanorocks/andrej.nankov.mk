<?php

namespace App\Filament\Widgets;

use App\Models\NewsletterSubscriber;
use Carbon\CarbonImmutable;
use Filament\Widgets\ChartWidget;

class SubscriberGrowthChart extends ChartWidget
{
    protected static ?int $sort = -5;

    protected ?string $heading = 'Newsletter Signups — Last 30 Days';

    protected function getData(): array
    {
        $start = CarbonImmutable::now()->subDays(29)->startOfDay();

        $counts = NewsletterSubscriber::query()
            ->where('created_at', '>=', $start)
            ->selectRaw('DATE(created_at) as d, COUNT(*) as c')
            ->groupBy('d')
            ->pluck('c', 'd');

        $labels = [];
        $data = [];

        for ($i = 0; $i < 30; $i++) {
            $day = $start->addDays($i)->toDateString();
            $labels[] = CarbonImmutable::parse($day)->format('M j');
            $data[] = (int) ($counts[$day] ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Signups',
                    'data' => $data,
                    'borderColor' => '#F53F3F',
                    'backgroundColor' => 'rgba(245, 63, 63, 0.2)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
