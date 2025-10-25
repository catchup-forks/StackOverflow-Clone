<?php

namespace App\Filament\Admin\Resources\PostHistoryResource\Pages;

use App\Filament\Admin\Resources\PostHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPostHistory extends EditRecord
{
    protected static string $resource = PostHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
