<?php

namespace App\Filament\Admin\Resources\PostHistoryResource\Tables;

use App\Enums\PostHistoryType;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;

class PostHistoryTable
{
    public static function configure(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('post.title')
                    ->label(__('Post'))
                    ->limit(50)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('post_history_type_id')
                    ->label(__('Type'))
                    ->formatStateUsing(fn ($state) => optional(PostHistoryType::tryFrom((int) $state))->name)
                    ->badge(),
                TextColumn::make('user.display_name')
                    ->label(__('User'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('on_date')
                    ->label(__('Occurred at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('last_7_days')
                    ->label(__('Last 7 days'))
                    ->query(fn ($query) => $query->where('on_date', '>=', now()->subDays(7))),
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
