<?php

namespace App\Filament\User\Resources\QuestionResource\Pages;

use App\Filament\User\Resources\QuestionResource;
use App\Filament\User\Resources\QuestionResource\Infolists\QuestionInfolist;
use Filament\Actions;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewQuestion extends ViewRecord
{
    protected static string $resource = QuestionResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return QuestionInfolist::configure($infolist);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label(__('Edit question')),
            Actions\DeleteAction::make()
                ->label(__('Delete question')),
        ];
    }
}

