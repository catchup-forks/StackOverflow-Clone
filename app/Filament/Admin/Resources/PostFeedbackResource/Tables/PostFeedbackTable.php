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
                    ->label(trans('stackoverflow.admin.post_feedback.table.post'))
                    ->limit(50)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('vote_type_id')
                    ->label(trans('stackoverflow.admin.post_feedback.table.vote_type'))
                    ->sortable(),
                IconColumn::make('is_anonymous')
                    ->label(trans('stackoverflow.admin.post_feedback.table.anonymous'))
                    ->boolean(),
                TextColumn::make('creation_date')
                    ->label(trans('stackoverflow.admin.post_feedback.table.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('anonymous')
                    ->label(trans('stackoverflow.admin.post_feedback.table.anonymous_only'))
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
