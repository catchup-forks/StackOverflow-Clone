<?php

namespace App\Filament\Admin\Resources\CommentResource\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use FilamentTiptapEditor\TiptapEditor;

class CommentForm
{
    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public static function schema(): array
    {
        return [
            Section::make(__('Comment details'))
                ->columns(2)
                ->schema([
                    Select::make('post_id')
                        ->label(__('Post'))
                        ->relationship('post', 'title')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('user_id')
                        ->label(__('Author'))
                        ->relationship('user', 'display_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    TextInput::make('user_display_name')
                        ->label(__('Display name override'))
                        ->maxLength(30),
                    TextInput::make('score')
                        ->numeric()
                        ->default(0),
                    TiptapEditor::make('body')
                        ->label(__('Comment'))
                        ->profile('default')
                        ->output('html')
                        ->required()
                        ->columnSpanFull(),
                ]),
            Section::make(__('Moderation'))
                ->columns(2)
                ->schema([
                    Toggle::make('requires_admin_review')
                        ->label(__('Requires review')),
                    Select::make('admin_editor_id')
                        ->label(__('Reviewed by'))
                        ->relationship('adminEditor', 'display_name')
                        ->searchable()
                        ->preload()
                        ->nullOption(__('Not reviewed')),
                    DateTimePicker::make('creation_date')
                        ->label(__('Created'))
                        ->seconds(false)
                        ->native(false),
                ]),
        ];
    }
}
