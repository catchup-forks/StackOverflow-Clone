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
            Section::make(__('Profile details'))
                ->columns(2)
                ->schema([
                    TextInput::make('display_name')
                        ->label(__('Display name'))
                        ->required()
                        ->maxLength(40),
                    TextInput::make('email')
                        ->email()
                        ->label(__('Email'))
                        ->maxLength(160),
                    TextInput::make('website_url')
                        ->label(__('Website'))
                        ->url()
                        ->maxLength(200),
                    TextInput::make('location')
                        ->label(__('Location'))
                        ->maxLength(100),
                    TiptapEditor::make('about_me')
                        ->label(__('About'))
                        ->profile('default')
                        ->output('html')
                        ->columnSpanFull(),
                ]),
            Section::make(__('Reputation'))
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
            Section::make(__('Activity'))
                ->columns(2)
                ->schema([
                    DateTimePicker::make('creation_date')
                        ->label(__('Joined'))
                        ->seconds(false)
                        ->native(false),
                    DateTimePicker::make('last_access_date')
                        ->label(__('Last seen'))
                        ->seconds(false)
                        ->native(false),
                ]),
        ];
    }
}
