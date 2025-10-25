<?php

namespace App\Filament\User\Resources\QuestionResource\Pages;

use App\Filament\User\Resources\QuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuestion extends EditRecord
{
    protected static string $resource = QuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label(__('Delete question')),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('Your question has been updated!');
    }
}

