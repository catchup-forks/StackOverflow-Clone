<?php

namespace App\Filament\Admin\Resources\SuggestedEditResource\Tables;

use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;

class SuggestedEditTable
{
    public static function configure(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->limit(60)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('post.title')
                    ->label(__('Post'))
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('owner.display_name')
                    ->label(__('Suggested by'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('creation_date')
                    ->label(__('Created'))
                    ->dateTime()
                    ->sortable(),
                IconColumn::make('approval_date')
                    ->label(__('Approved'))
                    ->boolean(fn ($record) => ! empty($record->approval_date)),
                IconColumn::make('rejection_date')
                    ->label(__('Rejected'))
                    ->boolean(fn ($record) => ! empty($record->rejection_date)),
            ])
            ->filters([
                Filter::make('pending')
                    ->label(__('Pending review'))
                    ->query(fn ($query) => $query->whereNull('approval_date')->whereNull('rejection_date')),
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
