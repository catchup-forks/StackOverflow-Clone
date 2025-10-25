<?php

namespace App\Filament\User\Resources\QuestionResource\Pages;

use App\Filament\User\Resources\QuestionResource;
use App\Services\PostService;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQuestions extends ListRecords
{
    protected static string $resource = QuestionResource::class;

    protected static string $view = 'filament.app.resources.question-resource.pages.list-questions';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('Ask Question'))
                ->url(fn () => static::getResource()::getUrl('create')),
        ];
    }

    protected function getViewData(): array
    {
        $service = app(PostService::class);

        return [
            'questions' => $service->listQuestions(),
            'tags' => $service->recentTags(),
        ];
    }
}

