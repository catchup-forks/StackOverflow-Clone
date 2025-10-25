<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BadgeResource\Pages;
use App\Filament\Admin\Resources\BadgeResource\Schemas\BadgeForm;
use App\Filament\Admin\Resources\BadgeResource\Tables\BadgeTable;
use App\Models\Badge;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class BadgeResource extends Resource
{
    protected static ?string $model = Badge::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationGroup = 'Community';

    public static function form(Form $form): Form
    {
        return $form->schema(BadgeForm::schema());
    }

    public static function table(Table $table): Table
    {
        return BadgeTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBadges::route('/'),
        ];
    }
}
