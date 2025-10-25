<?php

namespace App\Filament\Admin\Resources\SuggestedEditResource\Pages;

use App\Filament\Admin\Resources\SuggestedEditResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSuggestedEdit extends EditRecord
{
    protected static string $resource = SuggestedEditResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
