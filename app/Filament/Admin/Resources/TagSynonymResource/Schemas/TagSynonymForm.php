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
            Section::make(trans('stackoverflow.admin.tag_synonym.form.section'))
                ->columns(2)
                ->schema([
                    TextInput::make('source_tag_name')
                        ->label(trans('stackoverflow.admin.tag_synonym.form.source_tag'))
                        ->required()
                        ->maxLength(25),
                    TextInput::make('target_tag_name')
                        ->label(trans('stackoverflow.admin.tag_synonym.form.target_tag'))
                        ->required()
                        ->maxLength(25),
                    Select::make('user_id')
                        ->label(trans('stackoverflow.admin.tag_synonym.form.created_by'))
                        ->relationship('creator', 'display_name')
                        ->searchable()
                        ->preload(),
                    DateTimePicker::make('creation_date')
                        ->label(trans('stackoverflow.admin.tag_synonym.form.created_at'))
                        ->seconds(false)
                        ->native(false),
                    TextInput::make('auto_rename_count')
                        ->label(trans('stackoverflow.admin.tag_synonym.form.auto_rename_count'))
                        ->numeric()
                        ->default(0),
                    DateTimePicker::make('last_auto_rename')
                        ->label(trans('stackoverflow.admin.tag_synonym.form.last_auto_rename'))
                        ->seconds(false)
                        ->native(false),
                    TextInput::make('score')
                        ->label(trans('stackoverflow.admin.tag_synonym.form.score'))
                        ->numeric()
                        ->default(0),
                    Select::make('approved_by_user_id')
                        ->label(trans('stackoverflow.admin.tag_synonym.form.approved_by'))
                        ->relationship('approvedBy', 'display_name')
                        ->searchable()
                        ->preload()
                        ->nullOption(trans('stackoverflow.admin.tag_synonym.form.pending_approval')),
                    DateTimePicker::make('approval_date')
                        ->label(trans('stackoverflow.admin.tag_synonym.form.approval_date'))
                        ->seconds(false)
                        ->native(false),
                ]),
        ];
    }
}
