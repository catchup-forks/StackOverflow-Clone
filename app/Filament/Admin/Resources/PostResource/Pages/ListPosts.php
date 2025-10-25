<?php

namespace App\Filament\Admin\Resources\PostResource\Pages;

use App\Filament\Admin\Resources\PostResource;
use App\Filament\Admin\Resources\PostResource\Schemas\PostForm;
use App\Models\Post;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        $tagNames = [];

        return [
            Actions\CreateAction::make()
                ->form(PostForm::schema())
                ->mutateFormDataUsing(function (array $data) use (&$tagNames): array {
                    [$data, $tagNames] = PostResource::prepareTagPayload($data);

                    return $data;
                })
                ->after(function (Post $record) use (&$tagNames): void {
                    PostResource::syncTags($record, $tagNames);
                }),
        ];
    }
}

