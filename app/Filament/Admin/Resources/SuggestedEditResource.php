<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SuggestedEditResource\Pages;
use App\Filament\Admin\Resources\SuggestedEditResource\Schemas\SuggestedEditForm;
use App\Filament\Admin\Resources\SuggestedEditResource\Tables\SuggestedEditTable;
use App\Models\SuggestedEdit;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class SuggestedEditResource extends Resource
{
    protected static ?string $model = SuggestedEdit::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form->schema(SuggestedEditForm::schema());
    }

    public static function table(Table $table): Table
    {
        return SuggestedEditTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuggestedEdits::route('/'),
        ];
    }
}
