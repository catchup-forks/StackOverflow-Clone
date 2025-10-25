<?php

namespace App\Filament\Admin\Resources\UserResource\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use FilamentTiptapEditor\TiptapEditor;

class UserForm
{
    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public static function schema(): array
    {
        return [
            Section::make(trans('stackoverflow.admin.user.form.profile_section'))
                ->columns(2)
                ->schema([
                    TextInput::make('display_name')
                        ->label(trans('stackoverflow.admin.user.form.display_name'))
                        ->required()
                        ->maxLength(40),
                    TextInput::make('email')
                        ->email()
                        ->label(trans('stackoverflow.admin.user.form.email'))
                        ->maxLength(160),
                    TextInput::make('website_url')
                        ->label(trans('stackoverflow.admin.user.form.website'))
                        ->url()
                        ->maxLength(200),
                    TextInput::make('location')
                        ->label(trans('stackoverflow.admin.user.form.location'))
                        ->maxLength(100),
                    TiptapEditor::make('about_me')
                        ->label(trans('stackoverflow.admin.user.form.about'))
                        ->profile('default')
                        ->output('html')
                        ->columnSpanFull(),
                ]),
            Section::make(trans('stackoverflow.admin.user.form.reputation_section'))
                ->columns(2)
                ->schema([
                    TextInput::make('reputation')
                        ->numeric()
                        ->default(0),
                    TextInput::make('views')
                        ->numeric()
                        ->default(0),
                    TextInput::make('up_votes')
                        ->numeric()
                        ->default(0),
                    TextInput::make('down_votes')
                        ->numeric()
                        ->default(0),
                    TextInput::make('age')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(150),
                ]),
            Section::make(trans('stackoverflow.admin.user.form.activity_section'))
                ->columns(2)
                ->schema([
                    DateTimePicker::make('creation_date')
                        ->label(trans('stackoverflow.admin.user.form.joined'))
                        ->seconds(false)
                        ->native(false),
                    DateTimePicker::make('last_access_date')
                        ->label(trans('stackoverflow.admin.user.form.last_seen'))
                        ->seconds(false)
                        ->native(false),
                ]),
        ];
    }
}
