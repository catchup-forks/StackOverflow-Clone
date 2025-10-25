<?php

namespace App\Filament\Admin\Resources\BadgeResource\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class BadgeForm
{
    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public static function schema(): array
    {
        return [
            Section::make(__('Badge details'))
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->label(__('Name'))
                        ->required()
                        ->maxLength(50),
                    Select::make('user_id')
                        ->label(__('Recipient'))
                        ->relationship('user', 'display_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    DateTimePicker::make('date')
                        ->label(__('Awarded at'))
                        ->seconds(false)
                        ->native(false)
                        ->required(),
                ]),
        ];
    }
}
