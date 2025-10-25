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
                    ->label(trans('stackoverflow.admin.post_history.table.post'))
                    ->limit(50)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('post_history_type_id')
                    ->label(trans('stackoverflow.admin.post_history.table.type'))
                    ->formatStateUsing(function ($state) {
                        $type = PostHistoryType::tryFrom((int) $state) ?? PostHistoryType::Unknown;

                        return trans('stackoverflow.post_history_types.' . $type->name);
                    })
                    ->badge(),
                TextColumn::make('user.display_name')
                    ->label(trans('stackoverflow.admin.post_history.table.user'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('on_date')
                    ->label(trans('stackoverflow.admin.post_history.table.occurred_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('last_7_days')
                    ->label(trans('stackoverflow.admin.post_history.table.last_seven_days'))
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
