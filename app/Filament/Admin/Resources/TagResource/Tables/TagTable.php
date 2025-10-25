<?php

namespace App\Filament\Admin\Resources\TagResource\Tables;

use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;

class TagTable
{
    public static function configure(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('name')
                    ->label(trans('stackoverflow.admin.tag.table.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('count')
                    ->label(trans('stackoverflow.admin.tag.table.usage_count'))
                    ->sortable(),
                TextColumn::make('excerptPost.title')
                    ->label(trans('stackoverflow.admin.tag.table.excerpt_post'))
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('wikiPost.title')
                    ->label(trans('stackoverflow.admin.tag.table.wiki_post'))
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('popular')
                    ->label(trans('stackoverflow.admin.tag.table.popular_filter'))
                    ->query(fn ($query) => $query->where('count', '>=', 1000)),
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
