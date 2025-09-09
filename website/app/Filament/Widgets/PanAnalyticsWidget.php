<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use App\Models\PanAnalytics;
use Filament\Actions\Action;
use Illuminate\Support\Number;
use Filament\Widgets\TableWidget;


class PanAnalyticsWidget extends TableWidget
{

    protected int | string | array $columnSpan = 'full';

    // protected static ?int $sort = -9;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                PanAnalytics::query()
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable()
                    ->grow(),
                Tables\Columns\TextColumn::make('impressions')
                    ->alignCenter()
                    ->sortable()
                    ->formatStateUsing(fn($record) => $this->toHumanReadableNumber($record->impressions))
                    ->label('Impressions'),
                Tables\Columns\TextColumn::make('hovers')
                    ->alignCenter()
                    ->sortable()
                    ->formatStateUsing(fn($record) => $this->toHumanReadableNumber($record->hovers) . ' (' . $this->toHumanReadablePercentage($record->impressions, $record->hovers) . ')')
                    ->label('Hovers'),
                Tables\Columns\TextColumn::make('clicks')
                    ->alignCenter()
                    ->sortable()
                    ->formatStateUsing(fn($record) => $this->toHumanReadableNumber($record->clicks) . ' (' . $this->toHumanReadablePercentage($record->impressions, $record->clicks) . ')')
                    ->label('Clicks'),
            ])
            ->headerActions([
                Action::make('flushAnalytics')
                    ->label('Flush Analytics')
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->action(fn() => PanAnalytics::truncate()),
            ])
            ->paginated()
            ->paginationPageOptions(['5', '10', '20', '50', 'all'])
            ->defaultSort('impressions', 'desc')
            ->persistFiltersInSession();
    }

    private function toHumanReadableNumber(int $number): string
    {
        return Number::format($number);
    }

    private function toHumanReadablePercentage(int $total, int $part): string
    {
        if ($total === 0) {
            return '0%';
        }

        return Number::percentage($part / $total * 100, 0, 1);
    }
}
