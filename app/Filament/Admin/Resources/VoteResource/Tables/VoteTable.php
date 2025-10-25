<?php

namespace App\Filament\Admin\Resources\VoteResource\Tables;

use App\Enums\VoteType;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;

class VoteTable
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
                TextColumn::make('user.display_name')
                    ->label(__('User'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('vote_type_id')
                    ->label(__('Type'))
                    ->formatStateUsing(fn ($state) => optional(VoteType::tryFrom((int) $state))->name)
                    ->sortable(),
                TextColumn::make('bounty_amount')
                    ->label(__('Bounty'))
                    ->sortable(),
                TextColumn::make('creation_date')
                    ->label(__('Cast at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('bounty')
                    ->label(__('Has bounty'))
                    ->query(fn ($query) => $query->where('bounty_amount', '>', 0)),
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
