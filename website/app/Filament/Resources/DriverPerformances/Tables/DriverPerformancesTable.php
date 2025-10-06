<?php

namespace App\Filament\Resources\DriverPerformances\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DriverPerformancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('driver_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('period_type'),
                TextColumn::make('period_start')
                    ->date()
                    ->sortable(),
                TextColumn::make('period_end')
                    ->date()
                    ->sortable(),
                TextColumn::make('trips_completed')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('distance_km')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('driving_hours')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('on_time_rate')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('rating')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('accidents_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('incidents_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('infractions_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('fuel_used_liters')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('fuel_efficiency_km_per_l')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('avg_speed_kmh')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('score')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('last_evaluated_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
