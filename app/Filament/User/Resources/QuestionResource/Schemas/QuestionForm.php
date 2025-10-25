<?php

namespace App\Filament\User\Resources\QuestionResource\Schemas;

use App\Enums\PostType;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Support\Facades\Auth;

class QuestionForm
{
    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public static function schema(): array
    {
        return [
            Hidden::make('post_type_id')
                ->default(PostType::Question->value),
            Hidden::make('user_id')
                ->default(fn () => Auth::id()),
            Hidden::make('creation_date')
                ->default(fn () => now()),
            Section::make(trans('stackoverflow.user.questions.form.section'))
                ->icon('heroicon-o-question-mark-circle')
                ->schema([
                    TextInput::make('title')
                        ->label(trans('stackoverflow.user.questions.form.title'))
                        ->placeholder(trans('stackoverflow.user.questions.form.title_placeholder'))
                        ->required()
                        ->maxLength(250),
                    TiptapEditor::make('body')
                        ->label(trans('stackoverflow.user.questions.form.details'))
                        ->required()
                        ->profile('default')
                        ->output('markdown')
                        ->columnSpanFull(),
                    TagsInput::make('tags')
                        ->label(trans('stackoverflow.user.questions.form.tags'))
                        ->helperText(trans('stackoverflow.user.questions.form.tags_helper'))
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
                        ->placeholder(trans('stackoverflow.user.questions.form.tags_placeholder')),
                ]),
        ];
    }
}

