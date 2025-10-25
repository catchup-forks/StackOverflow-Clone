<?php

namespace App\Filament\Admin\Resources\PostResource\Pages;

use App\Filament\Admin\Resources\PostResource;
use App\Models\Tag;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected array $tagNames = [];

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->tagNames = collect($data['tags'] ?? [])
            ->map(fn ($tag) => trim((string) $tag))
            ->filter()
            ->map(fn (string $tag) => strtolower($tag))
            ->unique()
            ->values()
            ->all();

        $data['tags'] = implode(',', $this->tagNames);

        return $data;
    }

    protected function afterSave(): void
    {
        $tagIds = collect($this->tagNames)
            ->map(fn (string $tag) => Tag::query()->firstOrCreate(['name' => $tag], ['count' => 0]))
            ->pluck('id')
            ->all();

        $this->record->tags()->sync($tagIds);
    }
}
