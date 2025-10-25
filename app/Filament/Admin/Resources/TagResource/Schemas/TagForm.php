<?php

namespace App\Filament\Admin\Resources\TagResource\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class TagForm
{
    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public static function schema(): array
    {
        return [
            Section::make(__('Tag details'))
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->label(__('Name'))
                        ->required()
                        ->maxLength(25),
                    TextInput::make('count')
                        ->label(__('Usage count'))
                        ->numeric()
                        ->default(0),
                    Select::make('excerpt_post_id')
                        ->label(__('Excerpt post'))
                        ->relationship('excerptPost', 'title')
                        ->searchable()
                        ->preload()
                        ->nullOption(__('None')),
                    Select::make('wiki_post_id')
                        ->label(__('Wiki post'))
                        ->relationship('wikiPost', 'title')
                        ->searchable()
                        ->preload()
                        ->nullOption(__('None')),
                ]),
        ];
    }
}
