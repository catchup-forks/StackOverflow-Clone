<?php

namespace App\Filament\Admin\Resources\PostFeedbackResource\Pages;

use App\Filament\Admin\Resources\PostFeedbackResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPostFeedback extends ListRecords
{
    protected static string $resource = PostFeedbackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
