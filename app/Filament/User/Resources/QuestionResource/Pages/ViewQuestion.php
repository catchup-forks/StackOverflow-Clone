<?php

namespace App\Filament\User\Resources\QuestionResource\Pages;

use App\Filament\User\Resources\QuestionResource;
use App\Services\PostService;
use Filament\Resources\Pages\ViewRecord;

class ViewQuestion extends ViewRecord
{
    protected static string $resource = QuestionResource::class;

    protected static string $view = 'filament.app.resources.question-resource.pages.view-question';

    protected function getViewData(): array
    {
        $service = app(PostService::class);

        $post = $service->findQuestion($this->record->getKey());
        $answers = $service->answersForQuestion($post)->load(['votes', 'user']);
        $acceptedAnswer = $answers->firstWhere('id', $post->accepted_answer_id);
        $otherAnswers = $answers->filter(fn ($answer) => $acceptedAnswer?->id !== $answer->id);

        return [
            'post' => $post->load(['user', 'comments', 'votes']),
            'answer' => $acceptedAnswer,
            'answers' => $otherAnswers,
            'tags' => $service->recentTags(),
        ];
    }
}

