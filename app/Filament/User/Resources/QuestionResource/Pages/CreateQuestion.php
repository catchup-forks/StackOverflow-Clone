<?php

namespace App\Filament\User\Resources\QuestionResource\Pages;

use App\Filament\User\Resources\QuestionResource;
use App\Services\PostService;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;

class CreateQuestion extends CreateRecord
{
    protected static string $resource = QuestionResource::class;

    protected static string $view = 'filament.app.resources.question-resource.pages.create-question';

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        unset($data['post_type_id'], $data['user_id'], $data['creation_date']);

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $service = app(PostService::class);
        $user = auth()->user();

        abort_unless($user, 403);

        return $service->createQuestion($data, $user);
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return trans('stackoverflow.user.questions.create.success');
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('view', ['record' => $this->record]);
    }
}

