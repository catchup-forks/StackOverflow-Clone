<?php

namespace App\Filament\Admin\Resources\PostResource\Tables;

use App\Filament\Admin\Resources\PostResource;
use App\Filament\Admin\Resources\PostResource\Schemas\PostForm;
use App\Models\Post;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class PostTable
{
    public static function configure(Tables\Table $table): Tables\Table
    {
        $tagNamesForEdit = [];

        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('title')
                    ->label(trans('stackoverflow.admin.post.table.title'))
                    ->sortable()
                    ->searchable()
                    ->limit(60),
                TextColumn::make('user.display_name')
                    ->label(trans('stackoverflow.admin.post.table.author'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('score')
                    ->label(trans('stackoverflow.admin.post.table.score'))
                    ->sortable(),
                TextColumn::make('view_count')
                    ->label(trans('stackoverflow.admin.post.table.views'))
                    ->sortable(),
                TextColumn::make('creation_date')
                    ->label(trans('stackoverflow.admin.post.table.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('post_type_id')
                    ->label(trans('stackoverflow.admin.post.table.type'))
                    ->options([
                        1 => trans('stackoverflow.admin.post.table.question'),
                        2 => trans('stackoverflow.admin.post.table.answer'),
                    ]),
                Filter::make('is_blog')
                    ->label(trans('stackoverflow.admin.post.table.blog_posts'))
                    ->query(fn ($query) => $query->where('is_blog', true)),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form(PostForm::schema())
                    ->mutateFormDataUsing(function (array $data) use (&$tagNamesForEdit): array {
                        [$data, $tagNamesForEdit] = PostResource::prepareTagPayload($data);

                        return $data;
                    })
                    ->after(function (Post $record) use (&$tagNamesForEdit): void {
                        PostResource::syncTags($record, $tagNamesForEdit);
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

