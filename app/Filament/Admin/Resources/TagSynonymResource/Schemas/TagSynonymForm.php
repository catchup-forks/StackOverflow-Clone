<?php

namespace App\Filament\Admin\Resources\TagSynonymResource\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class TagSynonymForm
{
    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public static function schema(): array
    {
        return [
            Section::make(__('Synonym details'))
                ->columns(2)
                ->schema([
                    TextInput::make('source_tag_name')
                        ->label(__('Source tag'))
                        ->required()
                        ->maxLength(25),
                    TextInput::make('target_tag_name')
                        ->label(__('Target tag'))
                        ->required()
                        ->maxLength(25),
                    Select::make('user_id')
                        ->label(__('Created by'))
                        ->relationship('creator', 'display_name')
                        ->searchable()
                        ->preload(),
                    DateTimePicker::make('creation_date')
                        ->label(__('Created at'))
                        ->seconds(false)
                        ->native(false),
                    TextInput::make('auto_rename_count')
                        ->label(__('Auto rename count'))
                        ->numeric()
                        ->default(0),
                    DateTimePicker::make('last_auto_rename')
                        ->label(__('Last auto rename'))
                        ->seconds(false)
                        ->native(false),
                    TextInput::make('score')
                        ->label(__('Score'))
                        ->numeric()
                        ->default(0),
                    Select::make('approved_by_user_id')
                        ->label(__('Approved by'))
                        ->relationship('approvedBy', 'display_name')
                        ->searchable()
                        ->preload()
                        ->nullOption(__('Pending approval')),
                    DateTimePicker::make('approval_date')
                        ->label(__('Approval date'))
                        ->seconds(false)
                        ->native(false),
                ]),
        ];
    }
}
