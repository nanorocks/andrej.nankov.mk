<?php

namespace App\Filament\Resources\DriverPerformances\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DriverPerformanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('driver_id')
                    ->required()
                    ->numeric(),
                Select::make('period_type')
                    ->options([
            'daily' => 'Daily',
            'weekly' => 'Weekly',
            'monthly' => 'Monthly',
            'quarterly' => 'Quarterly',
            'yearly' => 'Yearly',
            'lifetime' => 'Lifetime',
        ])
                    ->default('daily')
                    ->required(),
                DatePicker::make('period_start'),
                DatePicker::make('period_end'),
                TextInput::make('trips_completed')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('distance_km')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('driving_hours')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('on_time_rate')
                    ->numeric(),
                TextInput::make('rating')
                    ->numeric(),
                TextInput::make('accidents_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('incidents_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('infractions_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('fuel_used_liters')
                    ->numeric(),
                TextInput::make('fuel_efficiency_km_per_l')
                    ->numeric(),
                TextInput::make('avg_speed_kmh')
                    ->numeric(),
                TextInput::make('score')
                    ->numeric(),
                TextInput::make('metrics'),
                DateTimePicker::make('last_evaluated_at'),
            ]);
    }
}
