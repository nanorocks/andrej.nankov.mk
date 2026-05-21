<?php

namespace App\Filament\Widgets;

use App\Models\NewsletterSubscriber;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class RecentSubscribersWidget extends TableWidget
{
    protected static ?int $sort = 0;

    protected int|string|array $columnSpan = 'full';

    protected function getTableHeading(): ?string
    {
        return 'Recent Subscribers';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(NewsletterSubscriber::query()->latest()->limit(5))
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\IconColumn::make('subscribed')
                    ->label('Subscribed')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Signed up')
                    ->since(),
            ]);
    }
}
