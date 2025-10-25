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
            Section::make(trans('stackoverflow.admin.tag.form.section'))
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->label(trans('stackoverflow.admin.tag.form.name'))
                        ->required()
                        ->maxLength(25),
                    TextInput::make('count')
                        ->label(trans('stackoverflow.admin.tag.form.usage_count'))
                        ->numeric()
                        ->default(0),
                    Select::make('excerpt_post_id')
                        ->label(trans('stackoverflow.admin.tag.form.excerpt_post'))
                        ->relationship('excerptPost', 'title')
                        ->searchable()
                        ->preload()
                        ->nullOption(trans('stackoverflow.admin.tag.form.none')),
                    Select::make('wiki_post_id')
                        ->label(trans('stackoverflow.admin.tag.form.wiki_post'))
                        ->relationship('wikiPost', 'title')
                        ->searchable()
                        ->preload()
                        ->nullOption(trans('stackoverflow.admin.tag.form.none')),
                ]),
        ];
    }
}
