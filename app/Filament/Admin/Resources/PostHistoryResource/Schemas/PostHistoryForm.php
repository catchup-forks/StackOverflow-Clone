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
            Section::make(__('History details'))
                ->columns(2)
                ->schema([
                    Select::make('post_id')
                        ->label(__('Post'))
                        ->relationship('post', 'title')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('user_id')
                        ->label(__('User'))
                        ->relationship('user', 'display_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('post_history_type_id')
                        ->label(__('Type'))
                        ->options(collect(PostHistoryType::cases())->mapWithKeys(fn (PostHistoryType $type) => [$type->value => __($type->name)]))
                        ->required(),
                    TextInput::make('revision_GUID')
                        ->label(__('Revision GUID'))
                        ->numeric()
                        ->required(),
                    DateTimePicker::make('on_date')
                        ->label(__('Occurred at'))
                        ->seconds(false)
                        ->native(false)
                        ->required(),
                    TextInput::make('user_display_name')
                        ->label(__('User display name'))
                        ->maxLength(40),
                    TiptapEditor::make('comment')
                        ->label(__('Comment'))
                        ->profile('default')
                        ->output('html')
                        ->columnSpanFull(),
                    TiptapEditor::make('body')
                        ->label(__('Body'))
                        ->profile('default')
                        ->output('html')
                        ->columnSpanFull(),
                ]),
        ];
    }
}
