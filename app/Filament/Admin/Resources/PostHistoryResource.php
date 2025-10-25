<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PostHistoryResource\Pages;
use App\Filament\Admin\Resources\PostHistoryResource\Schemas\PostHistoryForm;
use App\Filament\Admin\Resources\PostHistoryResource\Tables\PostHistoryTable;
use App\Models\PostHistory;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class PostHistoryResource extends Resource
{
    protected static ?string $model = PostHistory::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form->schema(PostHistoryForm::schema());
    }

    public static function table(Table $table): Table
    {
        return PostHistoryTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPostHistories::route('/'),
        ];
    }
}
