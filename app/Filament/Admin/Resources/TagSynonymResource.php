<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TagSynonymResource\Pages;
use App\Filament\Admin\Resources\TagSynonymResource\Schemas\TagSynonymForm;
use App\Filament\Admin\Resources\TagSynonymResource\Tables\TagSynonymTable;
use App\Models\TagSynonym;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class TagSynonymResource extends Resource
{
    protected static ?string $model = TagSynonym::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';

    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form->schema(TagSynonymForm::schema());
    }

    public static function table(Table $table): Table
    {
        return TagSynonymTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTagSynonyms::route('/'),
            'create' => Pages\CreateTagSynonym::route('/create'),
            'edit' => Pages\EditTagSynonym::route('/{record}/edit'),
        ];
    }
}
