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
            Section::make(trans('stackoverflow.admin.badge.form.section'))
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->label(trans('stackoverflow.admin.badge.form.name'))
                        ->required()
                        ->maxLength(50),
                    Select::make('user_id')
                        ->label(trans('stackoverflow.admin.badge.form.recipient'))
                        ->relationship('user', 'display_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    DateTimePicker::make('date')
                        ->label(trans('stackoverflow.admin.badge.form.awarded_at'))
                        ->seconds(false)
                        ->native(false)
                        ->required(),
                ]),
        ];
    }
}
