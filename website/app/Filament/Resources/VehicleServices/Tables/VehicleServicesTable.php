<?php

namespace App\Filament\Resources\VehicleServices\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Columns\Summarizers\Sum;
use Illuminate\Database\Eloquent\Builder;

class VehicleServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('priority')
                    ->formatStateUsing(fn($state) => $state !== null ? mb_convert_case($state, MB_CASE_TITLE, 'UTF-8') : null),
                TextColumn::make('vehicle.notes')
                    ->label('Vehicle Notes')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('service_type')
                    ->label('Service Type')
                    ->formatStateUsing(function ($state) {
                        $map = [
                            'maintenance'   => 'Maintenance',
                            'repair'        => 'Repair',
                            'inspection'    => 'Inspection',
                            'oil_change'    => 'Oil Change',
                            'tire_service'  => 'Tire Service',
                            'battery'       => 'Battery',
                            'brakes'        => 'Brakes',
                            'transmission'  => 'Transmission',
                            'other'         => 'Other',
                        ];
                        return $map[$state] ?? $state;
                    })
                    ->wrap()->formatStateUsing(fn($state) => $state !== null ? mb_convert_case($state, MB_CASE_TITLE, 'UTF-8') : null),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('status')
                    ->formatStateUsing(fn($state) => $state !== null ? mb_convert_case($state, MB_CASE_TITLE, 'UTF-8') : null)
                    ->summarize(
                        Count::make()
                            ->label('Upcoming')
                            ->query(fn ($query) => $query->where('status', 'upcoming'))
                    ),


                TextColumn::make('estimated_cost')
                    ->label('Cost')
                    ->numeric()
                    ->formatStateUsing(fn($state) => $state !== null ? $state . ' ден.' : null)
                    ->sortable()->summarize(
                        Sum::make()
                            ->label('Total Cost')
                            ->formatStateUsing(fn($state) => $state !== null ? number_format((float) $state, 2) . ' ден.' : null)
                    ),

                TextColumn::make('completed_at')
                    ->dateTime()
                    ->sortable()->summarize(Count::make()->label('Total Completed')),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
