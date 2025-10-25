<?php

namespace App\Filament\Admin\Resources\PostResource\Schemas;

use App\Enums\PostType;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use FilamentTiptapEditor\TiptapEditor;

class PostForm
{
    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public static function schema(): array
    {
        return [
            Section::make(trans('stackoverflow.admin.post.form.section'))
                ->columns(2)
                ->schema([
                    TextInput::make('title')
                        ->label(trans('stackoverflow.admin.post.form.title'))
                        ->required()
                        ->maxLength(250)
                        ->columnSpanFull(),
                    Select::make('post_type_id')
                        ->label(trans('stackoverflow.admin.post.form.type'))
                        ->required()
                        ->options(collect(PostType::cases())->mapWithKeys(
                            fn (PostType $type) => [
                                $type->value => trans('stackoverflow.post_types.' . $type->name),
                            ]
                        )->all()),
                    Select::make('user_id')
                        ->label(trans('stackoverflow.admin.post.form.author'))
                        ->relationship('user', 'display_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Toggle::make('is_blog')
                        ->label(trans('stackoverflow.admin.post.form.blog_post'))
                        ->default(false)
                        ->helperText(trans('stackoverflow.admin.post.form.blog_post_helper')),
                    TagsInput::make('tags')
                        ->label(trans('stackoverflow.admin.post.form.tags'))
                        ->separator(',')
                        ->suggestions(fn () => \App\Models\Tag::query()->orderByDesc('count')->limit(20)->pluck('name')->all())
                        ->afterStateHydrated(fn (TagsInput $component, $state) => $component->state(
                            collect(explode(',', (string) $state))
                                ->map(fn (string $tag) => trim($tag))
                                ->filter()
                                ->values()
                                ->all()
                        ))
                        ->dehydrateStateUsing(fn ($state) => collect($state)
                            ->map(fn ($tag) => trim((string) $tag))
                            ->filter()
                            ->map(fn (string $tag) => strtolower($tag))
                            ->unique()
                            ->values()
                            ->all())
                        ->placeholder(trans('stackoverflow.admin.post.form.tags_placeholder'))
                        ->columnSpanFull(),
                    TiptapEditor::make('body')
                        ->label(trans('stackoverflow.admin.post.form.content'))
                        ->required()
                        ->profile('default')
                        ->output('markdown')
                        ->toolbarButtons([
                            'heading',
                            'bold',
                            'italic',
                            'strike',
                            'link',
                            'orderedList',
                            'bulletList',
                            'blockquote',
                            'codeBlock',
                            'horizontalRule',
                            'table',
                            'undo',
                            'redo',
                        ])
                        ->columnSpanFull(),
                ]),
            Section::make(trans('stackoverflow.admin.post.form.meta_section'))
                ->collapsible()
                ->columns(2)
                ->schema([
                    TextInput::make('owner_display_name')->label(trans('stackoverflow.admin.post.form.owner_display_name'))->maxLength(40),
                    TextInput::make('last_editor_display_name')->label(trans('stackoverflow.admin.post.form.last_editor'))->maxLength(40),
                    TextInput::make('score')->numeric()->default(0),
                    TextInput::make('view_count')->numeric()->default(0),
                    TextInput::make('answer_count')->numeric()->default(0),
                    TextInput::make('comment_count')->numeric()->default(0),
                    TextInput::make('favorite_count')->numeric()->default(0),
                ]),
        ];
    }
}

