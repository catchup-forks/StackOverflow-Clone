<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\VoteResource\Pages;
use App\Filament\Admin\Resources\VoteResource\Schemas\VoteForm;
use App\Filament\Admin\Resources\VoteResource\Tables\VoteTable;
use App\Models\Vote;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class VoteResource extends Resource
{
    protected static ?string $model = Vote::class;

    protected static ?string $navigationIcon = 'heroicon-o-hand-thumb-up';

    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form->schema(VoteForm::schema());
    }

    public static function table(Table $table): Table
    {
        return VoteTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVotes::route('/'),
        ];
    }
}
