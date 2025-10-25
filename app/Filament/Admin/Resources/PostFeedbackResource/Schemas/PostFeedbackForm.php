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
            Section::make(trans('stackoverflow.admin.post_feedback.form.section'))
                ->columns(2)
                ->schema([
                    Select::make('post_id')
                        ->label(trans('stackoverflow.admin.post_feedback.form.post'))
                        ->relationship('post', 'title')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Toggle::make('is_anonymous')
                        ->label(trans('stackoverflow.admin.post_feedback.form.anonymous')),
                    TextInput::make('vote_type_id')
                        ->label(trans('stackoverflow.admin.post_feedback.form.vote_type_id'))
                        ->numeric()
                        ->required(),
                    DateTimePicker::make('creation_date')
                        ->label(trans('stackoverflow.admin.post_feedback.form.created_at'))
                        ->seconds(false)
                        ->native(false)
                        ->required(),
                ]),
        ];
    }
}
