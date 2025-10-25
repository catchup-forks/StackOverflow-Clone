<?php

namespace App\Filament\Admin\Resources\PostFeedbackResource\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class PostFeedbackForm
{
    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public static function schema(): array
    {
        return [
            Section::make(__('Feedback details'))
                ->columns(2)
                ->schema([
                    Select::make('post_id')
                        ->label(__('Post'))
                        ->relationship('post', 'title')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Toggle::make('is_anonymous')
                        ->label(__('Anonymous')),
                    TextInput::make('vote_type_id')
                        ->label(__('Vote type ID'))
                        ->numeric()
                        ->required(),
                    DateTimePicker::make('creation_date')
                        ->label(__('Created at'))
                        ->seconds(false)
                        ->native(false)
                        ->required(),
                ]),
        ];
    }
}
