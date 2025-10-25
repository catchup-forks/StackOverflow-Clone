<?php

namespace App\Filament\Admin\Resources\CommentResource\Tables;

use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;

class CommentTable
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
                    ->label(trans('stackoverflow.admin.comment.table.post'))
                    ->searchable()
                    ->sortable()
                    ->limit(60),
                TextColumn::make('user.display_name')
                    ->label(trans('stackoverflow.admin.comment.table.author'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('score')
                    ->label(trans('stackoverflow.admin.comment.table.score'))
                    ->sortable(),
                IconColumn::make('requires_admin_review')
                    ->label(trans('stackoverflow.admin.comment.table.needs_review'))
                    ->boolean(),
                TextColumn::make('creation_date')
                    ->label(trans('stackoverflow.admin.comment.table.created'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('requires_review')
                    ->label(trans('stackoverflow.admin.comment.table.requires_review'))
                    ->query(fn ($query) => $query->where('requires_admin_review', true)),
                Filter::make('flagged_recently')
                    ->label(trans('stackoverflow.admin.comment.table.created_last_seven_days'))
                    ->query(fn ($query) => $query->where('creation_date', '>=', now()->subDays(7))),
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
