<?php

namespace App\Filament\User\Resources\QuestionResource\Schemas;

use App\Enums\PostType;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Support\Facades\Auth;

class QuestionForm
{
    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public static function schema(): array
    {
        return [
            Hidden::make('post_type_id')
                ->default(PostType::Question->value),
            Hidden::make('user_id')
                ->default(fn () => Auth::id()),
            Hidden::make('creation_date')
                ->default(fn () => now()),
            Section::make(__('Ask a question'))
                ->icon('heroicon-o-question-mark-circle')
                ->schema([
                    TextInput::make('title')
                        ->label(__('Title'))
                        ->placeholder(__('What do you want to know?'))
                        ->required()
                        ->maxLength(250),
                    TiptapEditor::make('body')
                        ->label(__('Details'))
                        ->required()
                        ->profile('default')
                        ->output('markdown')
                        ->columnSpanFull(),
                    TagsInput::make('tags')
                        ->label(__('Tags'))
                        ->helperText(__('Press enter after each tag (markdown supported).'))
                        ->separator(',')
                        ->placeholder(__('Add relevant tags')),
                ]),
        ];
    }
}

