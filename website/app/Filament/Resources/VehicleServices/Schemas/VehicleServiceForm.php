<?php

namespace App\Filament\Resources\VehicleServices\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Fieldset;
use Filament\Forms\Components\DateTimePicker;

class VehicleServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Fieldset::make('Base Service Information')
                    ->schema([
                        Select::make('vehicle_id')
                            ->label('Vehicle')
                            ->options(\App\Models\Vehicle::query()->pluck('notes', 'id')->toArray())
                            ->searchable()
                            ->required(),
                        Select::make('priority')
                            ->options(['low' => 'Low', 'normal' => 'Normal', 'high' => 'High', 'critical' => 'Critical'])
                            ->default('normal')
                            ->required(),
                        Select::make('service_type')
                            ->label('Service Type')
                            ->options([
                                'maintenance'   => 'Maintenance',
                                'repair'        => 'Repair',
                                'inspection'    => 'Inspection',
                                'oil_change'    => 'Oil Change',
                                'tire_service'  => 'Tire Service',
                                'battery'       => 'Battery',
                                'brakes'        => 'Brakes',
                                'transmission'  => 'Transmission',
                                'other'         => 'Other',
                            ])
                            ->searchable()
                            ->required()
                            ->default('maintenance'),
                        TextInput::make('title')->required(),
                        Textarea::make('description')
                            ->columnSpanFull()->required(),
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
                        TextInput::make('estimated_cost')
                            ->numeric()->required()->label('Cost'),
                        TextInput::make('vendor_contact')
                            ->label('Service Contact')->tel(),

                        DateTimePicker::make('completed_at'),

                    ])
                    ->columns(2),




                Fieldset::make('Intervals & Scheduling Reminders')
                    ->schema([
                        TextInput::make('interval_months')
                            ->numeric(),
                        TextInput::make('interval_mileage')
                            ->numeric(),
                        DateTimePicker::make('scheduled_at'),

                        TextInput::make('vendor_name'),
                        TextInput::make('due_mileage')
                            ->numeric(),

                        TextInput::make('reminder_offset_days')
                            ->numeric(),
                        DateTimePicker::make('reminder_at')->columnSpanFull(),
                        RichEditor::make('meta')->label('Metadata (JSON)')->json()
                            ->columnSpanFull(),
                    ])
                    ->columns(2)



            ]);
    }
}
