<?php

namespace App\Filament\Admin\Resources\PostHistoryResource\Schemas;

use App\Enums\PostHistoryType;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use FilamentTiptapEditor\TiptapEditor;

class PostHistoryForm
{
    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public static function schema(): array
    {
        return [
            Section::make(trans('stackoverflow.admin.post_history.form.section'))
                ->columns(2)
                ->schema([
                    Select::make('post_id')
                        ->label(trans('stackoverflow.admin.post_history.form.post'))
                        ->relationship('post', 'title')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('user_id')
                        ->label(trans('stackoverflow.admin.post_history.form.user'))
                        ->relationship('user', 'display_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('post_history_type_id')
                        ->label(trans('stackoverflow.admin.post_history.form.type'))
                        ->options(collect(PostHistoryType::cases())->mapWithKeys(
                            fn (PostHistoryType $type) => [
                                $type->value => trans('stackoverflow.post_history_types.' . $type->name),
                            ]
                        ))
                        ->required(),
                    TextInput::make('revision_GUID')
                        ->label(trans('stackoverflow.admin.post_history.form.revision_guid'))
                        ->numeric()
                        ->required(),
                    DateTimePicker::make('on_date')
                        ->label(trans('stackoverflow.admin.post_history.form.occurred_at'))
                        ->seconds(false)
                        ->native(false)
                        ->required(),
                    TextInput::make('user_display_name')
                        ->label(trans('stackoverflow.admin.post_history.form.user_display_name'))
                        ->maxLength(40),
                    TiptapEditor::make('comment')
                        ->label(trans('stackoverflow.admin.post_history.form.comment'))
                        ->profile('default')
                        ->output('html')
                        ->columnSpanFull(),
                    TiptapEditor::make('body')
                        ->label(trans('stackoverflow.admin.post_history.form.body'))
                        ->profile('default')
                        ->output('html')
                        ->columnSpanFull(),
                ]),
        ];
    }
}
