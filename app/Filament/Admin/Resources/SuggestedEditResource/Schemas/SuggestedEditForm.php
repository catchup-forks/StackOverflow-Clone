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
            Section::make(trans('stackoverflow.admin.suggested_edit.form.section'))
                ->columns(2)
                ->schema([
                    Select::make('post_id')
                        ->label(trans('stackoverflow.admin.suggested_edit.form.post'))
                        ->relationship('post', 'title')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('owner_user_id')
                        ->label(trans('stackoverflow.admin.suggested_edit.form.suggested_by'))
                        ->relationship('owner', 'display_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    TextInput::make('title')
                        ->label(trans('stackoverflow.admin.suggested_edit.form.title'))
                        ->maxLength(250)
                        ->columnSpanFull(),
                    TagsInput::make('tags')
                        ->label(trans('stackoverflow.admin.suggested_edit.form.tags'))
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
                        ->label(trans('stackoverflow.admin.suggested_edit.form.body'))
                        ->profile('default')
                        ->output('html')
                        ->columnSpanFull(),
                    TiptapEditor::make('comment')
                        ->label(trans('stackoverflow.admin.suggested_edit.form.comment'))
                        ->profile('default')
                        ->output('html')
                        ->columnSpanFull(),
                ]),
            Section::make(trans('stackoverflow.admin.suggested_edit.form.timeline_section'))
                ->columns(3)
                ->schema([
                    DateTimePicker::make('creation_date')
                        ->label(trans('stackoverflow.admin.suggested_edit.form.created'))
                        ->seconds(false)
                        ->native(false)
                        ->required(),
                    DateTimePicker::make('approval_date')
                        ->label(trans('stackoverflow.admin.suggested_edit.form.approved'))
                        ->seconds(false)
                        ->native(false),
                    DateTimePicker::make('rejection_date')
                        ->label(trans('stackoverflow.admin.suggested_edit.form.rejected'))
                        ->seconds(false)
                        ->native(false),
                    TextInput::make('revision_GUID')
                        ->label(trans('stackoverflow.admin.suggested_edit.form.revision_guid'))
                        ->numeric(),
                ]),
        ];
    }
}
