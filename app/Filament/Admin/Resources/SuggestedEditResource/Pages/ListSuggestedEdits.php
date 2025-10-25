<?php

namespace App\Filament\Admin\Resources\SuggestedEditResource\Pages;

use App\Filament\Admin\Resources\SuggestedEditResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSuggestedEdits extends ListRecords
{
    protected static string $resource = SuggestedEditResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
