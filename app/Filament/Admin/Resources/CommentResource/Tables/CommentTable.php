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
                    ->label(__('Post'))
                    ->searchable()
                    ->sortable()
                    ->limit(60),
                TextColumn::make('user.display_name')
                    ->label(__('Author'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('score')
                    ->label(__('Score'))
                    ->sortable(),
                IconColumn::make('requires_admin_review')
                    ->label(__('Needs review'))
                    ->boolean(),
                TextColumn::make('creation_date')
                    ->label(__('Created'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('requires_review')
                    ->label(__('Requires review'))
                    ->query(fn ($query) => $query->where('requires_admin_review', true)),
                Filter::make('flagged_recently')
                    ->label(__('Created in last 7 days'))
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
