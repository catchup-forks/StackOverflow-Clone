<?php

namespace App\Filament\Admin\Resources\PostResource\Tables;

use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class PostTable
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
                    ->sortable()
                    ->searchable()
                    ->limit(60),
                TextColumn::make('user.display_name')
                    ->label(__('Author'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('score')
                    ->label(__('Score'))
                    ->sortable(),
                TextColumn::make('view_count')
                    ->label(__('Views'))
                    ->sortable(),
                TextColumn::make('creation_date')
                    ->label(__('Created at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('post_type_id')
                    ->label(__('Type'))
                    ->options([
                        1 => __('Question'),
                        2 => __('Answer'),
                    ]),
                Filter::make('is_blog')
                    ->label(__('Blog posts'))
                    ->query(fn ($query) => $query->where('is_blog', true)),
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

