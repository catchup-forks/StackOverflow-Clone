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
            Section::make(__('Post details'))
                ->columns(2)
                ->schema([
                    TextInput::make('title')
                        ->label(__('Title'))
                        ->required()
                        ->maxLength(250)
                        ->columnSpanFull(),
                    Select::make('post_type_id')
                        ->label(__('Type'))
                        ->required()
                        ->options(collect(PostType::cases())->mapWithKeys(
                            fn (PostType $type) => [$type->value => __($type->name)]
                        )->all()),
                    Select::make('user_id')
                        ->label(__('Author'))
                        ->relationship('user', 'display_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Toggle::make('is_blog')
                        ->label(__('Blog post'))
                        ->default(false)
                        ->helperText(__('Marking a post as a blog entry keeps it featured for users.')),
                    TagsInput::make('tags')
                        ->label(__('Tags'))
                        ->separator(',')
                        ->placeholder(__('Add tags'))
                        ->columnSpanFull(),
                    TiptapEditor::make('body')
                        ->label(__('Content'))
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
            Section::make(__('Meta'))
                ->collapsible()
                ->columns(2)
                ->schema([
                    TextInput::make('owner_display_name')->label(__('Owner display name'))->maxLength(40),
                    TextInput::make('last_editor_display_name')->label(__('Last editor'))->maxLength(40),
                    TextInput::make('score')->numeric()->default(0),
                    TextInput::make('view_count')->numeric()->default(0),
                    TextInput::make('answer_count')->numeric()->default(0),
                    TextInput::make('comment_count')->numeric()->default(0),
                    TextInput::make('favorite_count')->numeric()->default(0),
                ]),
        ];
    }
}

