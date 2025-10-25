<?php

namespace App\Filament\Admin\Resources\TagSynonymResource\Pages;

use App\Filament\Admin\Resources\TagSynonymResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTagSynonym extends EditRecord
{
    protected static string $resource = TagSynonymResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
