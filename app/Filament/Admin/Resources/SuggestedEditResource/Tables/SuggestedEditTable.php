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
                    ->label(trans('stackoverflow.admin.suggested_edit.table.title'))
                    ->limit(60)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('post.title')
                    ->label(trans('stackoverflow.admin.suggested_edit.table.post'))
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('owner.display_name')
                    ->label(trans('stackoverflow.admin.suggested_edit.table.suggested_by'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('creation_date')
                    ->label(trans('stackoverflow.admin.suggested_edit.table.created'))
                    ->dateTime()
                    ->sortable(),
                IconColumn::make('approval_date')
                    ->label(trans('stackoverflow.admin.suggested_edit.table.approved'))
                    ->boolean(fn ($record) => ! empty($record->approval_date)),
                IconColumn::make('rejection_date')
                    ->label(trans('stackoverflow.admin.suggested_edit.table.rejected'))
                    ->boolean(fn ($record) => ! empty($record->rejection_date)),
            ])
            ->filters([
                Filter::make('pending')
                    ->label(trans('stackoverflow.admin.suggested_edit.table.pending_review'))
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
