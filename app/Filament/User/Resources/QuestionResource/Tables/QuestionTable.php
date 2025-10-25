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
                    ->label(trans('stackoverflow.user.questions.table.question'))
                    ->searchable()
                    ->sortable()
                    ->limit(80),
                TextColumn::make('user.display_name')
                    ->label(trans('stackoverflow.user.questions.table.asked_by'))
                    ->sortable(),
                TextColumn::make('score')
                    ->label(trans('stackoverflow.user.questions.table.score'))
                    ->sortable(),
                TextColumn::make('answer_count')
                    ->label(trans('stackoverflow.user.questions.table.answers'))
                    ->sortable(),
                TextColumn::make('creation_date')
                    ->label(trans('stackoverflow.user.questions.table.asked'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label(trans('stackoverflow.user.questions.table.view')),
                Tables\Actions\EditAction::make()
                    ->label(trans('stackoverflow.user.questions.table.improve')),
            ])
            ->bulkActions([]);
    }
}

