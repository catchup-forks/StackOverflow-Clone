<?php

namespace App\Filament\Admin\Resources\BadgeResource\Tables;

use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;

class BadgeTable
{
    public static function configure(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('name')
                    ->label(__('Badge'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.display_name')
                    ->label(__('User'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('date')
                    ->label(__('Awarded'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('recent')
                    ->label(__('Awarded this month'))
                    ->query(fn ($query) => $query->where('date', '>=', now()->startOfMonth())),
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
