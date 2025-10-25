<?php

namespace App\Filament\User\Resources;

use App\Enums\PostType;
use App\Filament\User\Resources\QuestionResource\Pages;
use App\Filament\User\Resources\QuestionResource\Schemas\QuestionForm;
use App\Filament\User\Resources\QuestionResource\Tables\QuestionTable;
use App\Models\Post;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class QuestionResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $slug = 'questions';

    protected static ?string $label = null;

    protected static ?string $pluralLabel = null;

    public static function getLabel(): ?string
    {
        return trans('stackoverflow.user.questions.label');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('stackoverflow.user.questions.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form->schema(QuestionForm::schema());
    }

    public static function table(Table $table): Table
    {
        return QuestionTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/ask'),
            'view' => Pages\ViewQuestion::route('/{record}'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('post_type_id', PostType::Question->value)
            ->latest('creation_date');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getEloquentQuery()->count();
    }
}

