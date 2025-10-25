<?php

namespace App\Filament\Admin\Resources\PostFeedbackResource\Tables;

use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;

class PostFeedbackTable
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
                TextColumn::make('vote_type_id')
                    ->label(__('Vote type'))
                    ->sortable(),
                IconColumn::make('is_anonymous')
                    ->label(__('Anonymous'))
                    ->boolean(),
                TextColumn::make('creation_date')
                    ->label(__('Created at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('anonymous')
                    ->label(__('Anonymous only'))
                    ->query(fn ($query) => $query->where('is_anonymous', true)),
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
