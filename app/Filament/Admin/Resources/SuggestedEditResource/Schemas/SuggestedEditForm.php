<?php

namespace App\Filament\Admin\Resources\SuggestedEditResource\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use FilamentTiptapEditor\TiptapEditor;

class SuggestedEditForm
{
    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public static function schema(): array
    {
        return [
            Section::make(__('Edit details'))
                ->columns(2)
                ->schema([
                    Select::make('post_id')
                        ->label(__('Post'))
                        ->relationship('post', 'title')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('owner_user_id')
                        ->label(__('Suggested by'))
                        ->relationship('owner', 'display_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    TextInput::make('title')
                        ->label(__('Title'))
                        ->maxLength(250)
                        ->columnSpanFull(),
                    TagsInput::make('tags')
                        ->label(__('Tags'))
                        ->separator(',')
                        ->suggestions(fn () => \App\Models\Tag::query()->orderByDesc('count')->limit(20)->pluck('name')->all())
                        ->afterStateHydrated(fn (TagsInput $component, $state) => $component->state(
                            collect(explode(',', (string) $state))
                                ->map(fn (string $tag) => trim($tag))
                                ->filter()
                                ->values()
                                ->all()
                        ))
                        ->dehydrateStateUsing(fn ($state) => collect($state)
                            ->map(fn ($tag) => trim((string) $tag))
                            ->filter()
                            ->map(fn (string $tag) => strtolower($tag))
                            ->unique()
                            ->values()
                            ->all())
                        ->columnSpanFull(),
                    TiptapEditor::make('body')
                        ->label(__('Body'))
                        ->profile('default')
                        ->output('html')
                        ->columnSpanFull(),
                    TiptapEditor::make('comment')
                        ->label(__('Comment'))
                        ->profile('default')
                        ->output('html')
                        ->columnSpanFull(),
                ]),
            Section::make(__('Review timeline'))
                ->columns(3)
                ->schema([
                    DateTimePicker::make('creation_date')
                        ->label(__('Created'))
                        ->seconds(false)
                        ->native(false)
                        ->required(),
                    DateTimePicker::make('approval_date')
                        ->label(__('Approved'))
                        ->seconds(false)
                        ->native(false),
                    DateTimePicker::make('rejection_date')
                        ->label(__('Rejected'))
                        ->seconds(false)
                        ->native(false),
                    TextInput::make('revision_GUID')
                        ->label(__('Revision GUID'))
                        ->numeric(),
                ]),
        ];
    }
}
