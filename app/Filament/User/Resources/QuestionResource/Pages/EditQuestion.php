<?php

namespace App\Filament\User\Resources\QuestionResource\Pages;

use App\Filament\User\Resources\QuestionResource;
use App\Services\PostService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditQuestion extends EditRecord
{
    protected static string $resource = QuestionResource::class;

    protected static string $view = 'filament.app.resources.question-resource.pages.edit-question';

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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        unset($data['post_type_id'], $data['user_id'], $data['creation_date']);

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $service = app(PostService::class);
        $user = auth()->user();

        abort_unless($user, 403);

        return $service->updateQuestion($record, $data, $user);
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('view', ['record' => $this->record]);
    }
}

