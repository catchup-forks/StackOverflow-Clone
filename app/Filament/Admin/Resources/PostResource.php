<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PostResource\Pages;
use App\Filament\Admin\Resources\PostResource\Schemas\PostForm;
use App\Filament\Admin\Resources\PostResource\Tables\PostTable;
use App\Models\Post;
use App\Models\Tag;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = null;

    protected static ?string $navigationGroup = 'Content';

    public static function getModelLabel(): string
    {
        return trans('stackoverflow.admin.post.label');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('stackoverflow.admin.post.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return trans('stackoverflow.admin.post.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form->schema(PostForm::schema());
    }

    public static function table(Table $table): Table
    {
        return PostTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) Post::query()->count();
    }

    public static function getEloquentQuery()
    {
        return parent::getEloquentQuery()
            ->orderByDesc('creation_date');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array{0: array<string, mixed>, 1: array<int, string>}
     */
    public static function prepareTagPayload(array $data): array
    {
        $tagNames = collect($data['tags'] ?? [])
            ->map(fn ($tag) => trim((string) $tag))
            ->filter()
            ->map(fn (string $tag) => strtolower($tag))
            ->unique()
            ->values()
            ->all();

        $data['tags'] = implode(',', $tagNames);

        return [$data, $tagNames];
    }

    /**
     * @param  array<int, string>  $tagNames
     */
    public static function syncTags(Post $post, array $tagNames): void
    {
        $tagIds = collect($tagNames)
            ->map(fn (string $tag) => Tag::query()->firstOrCreate(['name' => $tag], ['count' => 0])->id)
            ->all();

        $post->tags()->sync($tagIds);
    }
}

