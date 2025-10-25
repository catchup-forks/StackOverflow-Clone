<?php

namespace App\Filament\Admin\Resources\UserResource\Tables;

use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;

class UserTable
{
    public static function configure(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('display_name')
                    ->label(__('Display name'))
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('reputation')
                    ->label(__('Reputation'))
                    ->sortable(),
                TextColumn::make('views')
                    ->label(__('Profile views'))
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('creation_date')
                    ->label(__('Joined'))
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('last_access_date')
                    ->label(__('Last seen'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('high_reputation')
                    ->label(__('Reputation ≥ 5k'))
                    ->query(fn ($query) => $query->where('reputation', '>=', 5000)),
                Filter::make('active_recently')
                    ->label(__('Seen in last 30 days'))
                    ->query(fn ($query) => $query->where('last_access_date', '>=', now()->subDays(30))),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
