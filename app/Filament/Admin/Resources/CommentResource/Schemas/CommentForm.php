<?php

namespace App\Filament\Admin\Resources\CommentResource\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use FilamentTiptapEditor\TiptapEditor;

class CommentForm
{
    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public static function schema(): array
    {
        return [
            Section::make(trans('stackoverflow.admin.comment.form.section'))
                ->columns(2)
                ->schema([
                    Select::make('post_id')
                        ->label(trans('stackoverflow.admin.comment.form.post'))
                        ->relationship('post', 'title')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('user_id')
                        ->label(trans('stackoverflow.admin.comment.form.author'))
                        ->relationship('user', 'display_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    TextInput::make('user_display_name')
                        ->label(trans('stackoverflow.admin.comment.form.display_name_override'))
                        ->maxLength(30),
                    TextInput::make('score')
                        ->numeric()
                        ->default(0),
                    TiptapEditor::make('body')
                        ->label(trans('stackoverflow.admin.comment.form.comment'))
                        ->profile('default')
                        ->output('html')
                        ->required()
                        ->columnSpanFull(),
                ]),
            Section::make(trans('stackoverflow.admin.comment.form.moderation_section'))
                ->columns(2)
                ->schema([
                    Toggle::make('requires_admin_review')
                        ->label(trans('stackoverflow.admin.comment.form.requires_review')),
                    Select::make('admin_editor_id')
                        ->label(trans('stackoverflow.admin.comment.form.reviewed_by'))
                        ->relationship('adminEditor', 'display_name')
                        ->searchable()
                        ->preload()
                        ->nullOption(trans('stackoverflow.admin.comment.form.not_reviewed')),
                    DateTimePicker::make('creation_date')
                        ->label(trans('stackoverflow.admin.comment.form.created'))
                        ->seconds(false)
                        ->native(false),
                ]),
        ];
    }
}
