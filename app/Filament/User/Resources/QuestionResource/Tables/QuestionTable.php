<?php

namespace App\Filament\User\Resources\QuestionResource\Tables;

use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class QuestionTable
{
    public static function configure(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('Question'))
                    ->searchable()
                    ->sortable()
                    ->limit(80),
                TextColumn::make('user.display_name')
                    ->label(__('Asked by'))
                    ->sortable(),
                TextColumn::make('score')
                    ->label(__('Score'))
                    ->sortable(),
                TextColumn::make('answer_count')
                    ->label(__('Answers'))
                    ->sortable(),
                TextColumn::make('creation_date')
                    ->label(__('Asked'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label(__('View')),
                Tables\Actions\EditAction::make()
                    ->label(__('Improve')),
            ])
            ->bulkActions([]);
    }
}

