<?php

namespace App\Filament\Resources\VehicleServices\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class VehicleServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('vehicle_id')
                    ->required()
                    ->numeric(),
                TextInput::make('service_type'),
                TextInput::make('title'),
                Textarea::make('description')
                    ->columnSpanFull(),
                DatePicker::make('due_date'),
                TextInput::make('due_mileage')
                    ->numeric(),
                TextInput::make('interval_months')
                    ->numeric(),
                TextInput::make('interval_mileage')
                    ->numeric(),
                Select::make('priority')
                    ->options(['low' => 'Low', 'normal' => 'Normal', 'high' => 'High', 'critical' => 'Critical'])
                    ->default('normal')
                    ->required(),
                Select::make('status')
                    ->options([
            'upcoming' => 'Upcoming',
            'scheduled' => 'Scheduled',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            'overdue' => 'Overdue',
        ])
                    ->default('upcoming')
                    ->required(),
                DateTimePicker::make('scheduled_at'),
                DateTimePicker::make('completed_at'),
                TextInput::make('vendor_name'),
                TextInput::make('vendor_contact'),
                TextInput::make('estimated_cost')
                    ->numeric(),
                TextInput::make('reminder_offset_days')
                    ->numeric(),
                DateTimePicker::make('reminder_at'),
                TextInput::make('meta'),
            ]);
    }
}
