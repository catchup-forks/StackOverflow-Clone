<?php

namespace App\Filament\Admin\Resources\PostFeedbackResource\Pages;

use App\Filament\Admin\Resources\PostFeedbackResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPostFeedback extends EditRecord
{
    protected static string $resource = PostFeedbackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
