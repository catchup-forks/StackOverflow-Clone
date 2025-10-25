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
                    ->label(trans('stackoverflow.admin.vote.table.post'))
                    ->limit(50)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.display_name')
                    ->label(trans('stackoverflow.admin.vote.table.user'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('vote_type_id')
                    ->label(trans('stackoverflow.admin.vote.table.type'))
                    ->formatStateUsing(function ($state) {
                        $type = VoteType::tryFrom((int) $state) ?? VoteType::Unknown;

                        return trans('stackoverflow.vote_types.' . $type->name);
                    })
                    ->sortable(),
                TextColumn::make('bounty_amount')
                    ->label(trans('stackoverflow.admin.vote.table.bounty'))
                    ->sortable(),
                TextColumn::make('creation_date')
                    ->label(trans('stackoverflow.admin.vote.table.cast_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('bounty')
                    ->label(trans('stackoverflow.admin.vote.table.has_bounty'))
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
