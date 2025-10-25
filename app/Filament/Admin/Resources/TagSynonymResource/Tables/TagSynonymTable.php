<?php

namespace App\Filament\Admin\Resources\TagSynonymResource\Tables;

use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;

class TagSynonymTable
{
    public static function configure(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('source_tag_name')
                    ->label(trans('stackoverflow.admin.tag_synonym.table.source_tag'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('target_tag_name')
                    ->label(trans('stackoverflow.admin.tag_synonym.table.target_tag'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('creator.display_name')
                    ->label(trans('stackoverflow.admin.tag_synonym.table.requested_by'))
                    ->searchable()
                    ->toggleable(),
                IconColumn::make('approval_date')
                    ->label(trans('stackoverflow.admin.tag_synonym.table.approved'))
                    ->boolean(fn ($record) => ! empty($record->approval_date)),
                TextColumn::make('auto_rename_count')
                    ->label(trans('stackoverflow.admin.tag_synonym.table.auto_renames'))
                    ->sortable(),
                TextColumn::make('score')
                    ->label(trans('stackoverflow.admin.tag_synonym.table.score'))
                    ->sortable(),
            ])
            ->filters([
                Filter::make('pending')
                    ->label(trans('stackoverflow.admin.tag_synonym.table.pending_approval'))
                    ->query(fn ($query) => $query->whereNull('approval_date')),
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
