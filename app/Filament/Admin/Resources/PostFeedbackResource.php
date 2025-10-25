<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PostFeedbackResource\Pages;
use App\Filament\Admin\Resources\PostFeedbackResource\Schemas\PostFeedbackForm;
use App\Filament\Admin\Resources\PostFeedbackResource\Tables\PostFeedbackTable;
use App\Models\PostFeedback;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class PostFeedbackResource extends Resource
{
    protected static ?string $model = PostFeedback::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';

    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form->schema(PostFeedbackForm::schema());
    }

    public static function table(Table $table): Table
    {
        return PostFeedbackTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPostFeedback::route('/'),
            'create' => Pages\CreatePostFeedback::route('/create'),
            'edit' => Pages\EditPostFeedback::route('/{record}/edit'),
        ];
    }
}
